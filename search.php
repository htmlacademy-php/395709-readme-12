<?php
session_start();
if (isset($_SESSION['userName'])) {
    include "helpers.php";
    require('functions.php');
    require('dbConfig.php');

    $rowsPosts = [];
    $GetRequest = htmlspecialchars($_GET['request']);

    if (isset($GetRequest)) {
        if ( ! empty($GetRequest)) {
            $request = trim($GetRequest);
            if ($GetRequest[0] === "#") {
                $GetRequest = substr($GetRequest, 1);
                $hashtagId = mysqli_fetch_all(mysqli_query($con,
                    sprintf("SELECT id FROM  hashtag WHERE MATCH(title) AGAINST('%s')", $request)), MYSQLI_ASSOC);
                $rowsPosts = mysqli_fetch_all(mysqli_query($con,
                    sprintf("SELECT * FROM posts WHERE id IN (SELECT postId FROM posthashtag WHERE hashtagId = %s ORDER BY creationDate DESC)",
                        $hashtagId[0]['id'])), MYSQLI_ASSOC);
            } else {
                $rowsPosts = mysqli_fetch_all(mysqli_query($con,
                    sprintf("SELECT * FROM  posts WHERE MATCH(title,content) AGAINST('%s') ORDER BY views DESC",
                        $request)),
                    MYSQLI_ASSOC);
            }

            if (empty($rowsPosts)) {

                $pageContent = include_template('noResults.php', ['search' => $GetRequest]);
                echo include_template('layout.php',
                    [
                        'content' => $pageContent,
                        'title' => 'Blog',
                        'userName' => $_SESSION['userName'],
                        'avatar' => "../img/".$_SESSION['avatar'],
                    ]);
            } else {
                $iter = 0;
                foreach ($rowsPosts as $post) {
                    $data = preparePostSatatisticDate($con, $post['id']);
                    $postAuthor = SqlRequest('avatar,login', 'users', ' id = ', $con, $post['authorId']);
                    array_push($rowsPosts[$iter], array(
                        'like' => $data[0]['like'],
                        'comment' => $data[0]['comment'],
                        'reposts' => $data[0]['reposts'],
                        'view' => $data[0]['view'],
                        'avatar' => $postAuthor[0]['avatar'],
                        'login' => $postAuthor[0]['login'],
                    ));
                    $iter++;
                }

                $pageContent = include_template('searchResults.php',
                    ['posts' => $rowsPosts, 'con' => $con, 'search' => $GetRequest]);
                echo include_template('layout.php',
                    [
                        'content' => $pageContent,
                        'title' => 'Blog',
                        'userName' => $_SESSION['userName'],
                        'avatar' => "../img/".$_SESSION['avatar'],
                    ]);
            }

        } else {
            header("Location:".getenv("HTTP_REFERER"));
        }
    }
}

