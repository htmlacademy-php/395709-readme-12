<?php
session_start();
if (isset($_SESSION['userName'])) {
    include "helpers.php";
    require('functions.php');
    require('dbConfig.php');

    $rowsPosts = [];
    $GetRequest = strip_tags($_GET['request']);

    if (isset($GetRequest) && ! empty($GetRequest)) {
        $request = mysqli_real_escape_string($con, trim($GetRequest));
        if ((string)$GetRequest[0] === "#") {
            $request = substr($GetRequest, 1);
            $hashtagId =strlen($request)>2 ? mysqli_fetch_all(mysqli_query(
                $con,
                sprintf("SELECT id FROM  hashtag WHERE MATCH(title) AGAINST('%s')", $request)
            ), MYSQLI_ASSOC) :
                (mysqli_fetch_all(mysqli_query(
                    $con,
                    sprintf("SELECT id FROM  hashtag WHERE title  LIKE '%s'", $request)
                ), MYSQLI_ASSOC)) ;

            $rowsPosts = mysqli_fetch_all(mysqli_query(
                $con,
                sprintf(
                    "SELECT * FROM posts WHERE id IN (SELECT postId FROM posthashtag WHERE hashtagId = %s ORDER BY creationDate DESC)",
                    mysqli_real_escape_string($con, $hashtagId[0]['id'])
                )
            ), MYSQLI_ASSOC);
        } else {
            $rowsPosts = mysqli_fetch_all(
                mysqli_query(
                    $con,
                    sprintf(
                        "SELECT * FROM  posts WHERE MATCH(title,content) AGAINST('%s') ORDER BY views DESC",
                        $request
                    )
                ),
                MYSQLI_ASSOC
            );
        }

        if (empty($rowsPosts)) {
            $pageContent = include_template('noResults.php', ['search' => $GetRequest]);
            echo include_template(
                'layout.php',
                [
                    'content' => $pageContent,
                    'title' => 'Blog',
                    'userName' => $_SESSION['userName'],
                    'avatar' => "../img/".$_SESSION['avatar'],
                    'tab' =>isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : '',
                    'sessionId' => $_SESSION['id'],
                ]
            );
        } else {
            $iter = 0;
            foreach ($rowsPosts as $post) {
                $data = preparePostSatatisticDate($con, mysqli_real_escape_string($con, $post['id']));
                $postAuthor = SqlRequest('avatar,login', 'users', ' id = ', $con, mysqli_real_escape_string($con, $post['authorId']));
                array_push($rowsPosts[$iter], array(
                    'postFeed' => include_template('widgets/postFeed.php', [
                        'con' => $con,
                        'id' => $post['id'],
                        'content' => $post['content'],
                        'typeID' => $post['typeID'],
                        'link' => '',
                        'title' => $post['title'],
                        'quoteAuthor' => $post['author'],
                    ]),
                    'likesRepostsComments' => include_template(
                        'widgets/likesRepostsComments.php',
                        [
                            'like' => $data[0]['like'],
                            'comment' => $data[0]['comment'],
                            'reposts' => $data[0]['reposts'],
                            'view' => $data[0]['view'],
                            'id' => $post['id'],
                        ]
                    ),
                    'avatar' => $postAuthor[0]['avatar'],
                    'login' => $postAuthor[0]['login'],
                    'tags' =>getTags($con, $post['id']),
                ));
                    $iter++;
            }

            $pageContent = include_template(
                'searchResults.php',
                ['posts' => $rowsPosts, 'con' => $con, 'search' => $GetRequest, 'userName' => $_SESSION['userName']]
            );
            echo include_template(
                'layout.php',
                [
                    'content' => $pageContent,
                    'title' => 'Blog',
                    'userName' => $_SESSION['userName'],
                    'avatar' => "../img/".$_SESSION['avatar'],
                    'tab' =>isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : '',
                    'sessionId' => $_SESSION['id'],
                ]
            );
        }
    } else {
        header("Location:".getenv("HTTP_REFERER"));
    }
}
