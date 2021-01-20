<?php
session_start();
include "helpers.php";
require('functions.php');
require('dbConfig.php');
if (isset($_SESSION['userName'])) {
    $user_name = $_SESSION['userName'];
    $lastSort = '';
    $sortDirection = 'DESC';
    $sort = 'views ';
    $popularSorting = '';
    $likeSorting = '';
    $dateSorting = '';
    if (! isset($_GET['offset']) || ! isset($_GET['id'])) {
        $offset = 0;
    } else {
        $offset = mysqli_real_escape_string($con, $_GET['offset']);
    }
    if (isset($_GET['previous']) && ! empty($_GET['previous'])) {
        $lastSort = $_GET['previous'];
    }
    if (isset($_GET['dir']) && ! empty($_GET['dir'])) {
        $sortDirection = $_GET['dir'];
    }


    if (isset($_GET['sort']) && ! empty($_GET['sort'])) {
        $popularSorting = (string)$_GET['sort'] === 'popular' || empty($sort) ? 'sorting__link--active' : '';
        $likeSorting = (string)$_GET['sort'] === 'like' ? 'sorting__link--active' : '';
        $dateSorting = (string)$_GET['sort'] === 'date' ? 'sorting__link--active' : '';
        $sort = (string)$_GET['sort'] === 'popular' ? 'views' : ((string)$_GET['sort'] === 'like' ? "Count(l.id)" : "creationDate") ;
        $sortDirection = ($lastSort === $_GET['sort'] && $sortDirection === 'DESC' ? 'ASC' : 'DESC' );
        $lastSort= $_GET['sort'];
    }

    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id,p.title, p.authorId, login, p.title,  conT.icon_name, p.content, p.author, p.creationDate,p.typeID, u.avatar FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id  left JOIN  likes l  ON p.id = l.recipientId  GROUP BY p.id ORDER BY $sort $sortDirection LIMIT 6 OFFSET $offset";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $postsCount = mysqli_fetch_all(mysqli_query($con, "SELECT COUNT(id) as count FROM posts"), MYSQLI_ASSOC);

    $id = 0;

    if (isset($_GET['id']) && ! empty($_GET['id'])) {
        $id = mysqli_real_escape_string($con, $_GET['id']);
        $sqlPost = "SELECT p.id, p.authorId, p.title, login, p.title,  conT.icon_name, u.avatar, p.content,p.author, p.creationDate,COUNT(l.id),p.typeID AS likesCount FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id left JOIN likes l  ON l.recipientId = p.id WHERE p.typeID = $id  GROUP BY  p.id ORDER BY $sort $sortDirection LIMIT 6 OFFSET $offset";
        $resultPosts = mysqli_query($con, $sqlPost);
        $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
        $postsCount = count($rowsPosts);
    }
    $postStatistic = array();
    $iter = 0;
    if (! empty($rowsPosts)) {
        foreach ($rowsPosts as $post) {
            $data = preparePostSatatisticDate($con, $post['id']);
            array_push($rowsPosts[$iter], array(
                'likesRepostsComments'=>include_template(
                    'widgets/likesRepostsComments.php',
                    [
                    'like' => $data[0]['like'],
                    'comment' => $data[0]['comment'],
                    'reposts' => $data[0]['reposts'],
                    'view' => $data[0]['view'],
                    'id' => $post['id'],
                    ]
                ),
                'tags' =>getTags($con, $post['id']),
            ));
            $iter++;
        }
    }



    $pageContent = include_template('main.php', [
        'posts' => $rowsPosts,
        'con' => $con,
        'offset' => $offset,
        'lastSort' => $lastSort,
        'dir' => $sortDirection,
        'popularSorting' => $popularSorting,
        'likeSorting' => $likeSorting,
        'dateSorting' => $dateSorting,
        'tab' => isset($_GET['tab']) ? htmlspecialchars($_GET['tab']) : '',
        'postCount' => $postsCount[0]['count'],
        'id' => $id,
        'postStatistic' => $postStatistic,
    ]);
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
    echo include_template(
        'authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
    );
}
