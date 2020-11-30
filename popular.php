<?php
session_start();
if (isset($_SESSION['userName'])) {
    $is_auth = rand(0, 1);
    include "helpers.php";
    $user_name = $_SESSION['userName'];
    require('functions.php');
    require('data.php');

    if ( ! (isset($_GET['offset'])) || ! (isset($_GET['id']))) {
        $offset = 0;
    } else {
        $offset = htmlspecialchars($_GET['offset']);
    }


    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id,p.title, p.authorId, login, p.title,  conT.icon_name, p.avatar, p.content, p.author, p.creationDate FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id  left JOIN  likes l  ON p.id = l.recipientId  GROUP BY p.id ORDER BY Count(l.id) DESC LIMIT 6 OFFSET $offset";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $postsCount = mysqli_fetch_all(mysqli_query($con, "SELECT COUNT(id) as count FROM posts"), MYSQLI_ASSOC);

    $id = '';
    if (isset($_GET['id'])) {
        if (htmlspecialchars($_GET['id']) != '') {
            $id = htmlspecialchars($_GET['id']);
            $sqlPost = "SELECT p.id, p.authorId, p.title, login, p.title,  conT.icon_name, p.avatar, p.content,p.author, p.creationDate,COUNT(l.id) AS likesCount FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id left JOIN likes l  ON l.recipientId = p.id WHERE p.typeID = $id  GROUP BY  p.id ORDER BY likesCount DESC LIMIT 6 OFFSET $offset";
            $resultPosts = mysqli_query($con, $sqlPost);//узнать количество постов
            $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
            $postsCount = count($rowsPosts);

        } else {
            $id = 0;
        }
    }

    $page_content = include_template('main.php', [
        'posts' => $rowsPosts,
        'con' => $con,
        'offset' => $offset,
        'postCount' => $postsCount[0]['count'],
        'id' => $id,
    ]);
    $layout_content = include_template('layout.php',
        ['content' => $page_content, 'title' => 'Blog']);
    print($layout_content);
} else {
    header("Location:http://395709-readme-12/");
}

