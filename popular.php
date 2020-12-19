<?php
session_start();
include "helpers.php";
require('functions.php');
require('dbConfig.php');
if (isset($_SESSION['userName'])) {
    $user_name = $_SESSION['userName'];

    if ( ! isset($_GET['offset']) || ! isset($_GET['id'])) {
        $offset = 0;
    } else {
        $offset = htmlspecialchars($_GET['offset']);
    }

    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id,p.title, p.authorId, login, p.title,  conT.icon_name, p.content, p.author, p.creationDate,p.typeID, u.avatar FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id  left JOIN  likes l  ON p.id = l.recipientId  GROUP BY p.id ORDER BY Count(l.id) DESC LIMIT 6 OFFSET $offset";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $postsCount = mysqli_fetch_all(mysqli_query($con, "SELECT COUNT(id) as count FROM posts"), MYSQLI_ASSOC);

    $id = 0;;
    if (isset($_GET['id']) && ! empty($_GET['id'])) {
        $id = intval($_GET['id']);
        $sqlPost = "SELECT p.id, p.authorId, p.title, login, p.title,  conT.icon_name, u.avatar, p.content,p.author, p.creationDate,COUNT(l.id),p.typeID AS likesCount FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id left JOIN likes l  ON l.recipientId = p.id WHERE p.typeID = $id  GROUP BY  p.id ORDER BY likesCount DESC LIMIT 6 OFFSET $offset";
        $resultPosts = mysqli_query($con, $sqlPost);//узнать количество постов
        $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
        $postsCount = count($rowsPosts);
    }

    $postStatistic = array();
    $iter = 0;
    if ( ! empty($rowsPosts)) {
        foreach ($rowsPosts as $post) {
            $data = preparePostSatatisticDate($con, $post['id']);
            array_push($rowsPosts[$iter], array(
                'like' => $data[0]['like'],
                'comment' => $data[0]['comment'],
                'reposts' => $data[0]['reposts'],
                'view' => $data[0]['view'],
            ));
            $iter++;
        }
    }


    $pageContent = include_template('main.php', [
        'posts' => $rowsPosts,
        'con' => $con,
        'offset' => $offset,
        'postCount' => $postsCount[0]['count'],
        'id' => $id,
        'postStatistic' => $postStatistic,
    ]);
    echo include_template('layout.php',
        [
            'content' => $pageContent,
            'title' => 'Blog',
            'userName' => $_SESSION['userName'],
            'avatar' => "../img/".$_SESSION['avatar'],
        ]);
} else {
    echo include_template('authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']);
}

