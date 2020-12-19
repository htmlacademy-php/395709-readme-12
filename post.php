<?php
session_start();
include "helpers.php";
require_once('mail.php');
require('functions.php');
require('dbConfig.php');

if (isset($_SESSION['userName'])) {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id, p.title, login, p.title,  conT.icon_name, u.avatar, p.content, p.views, p.typeID, p.author FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id WHERE p.id = $id ORDER BY views DESC;";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $comments = SqlRequest('content, login, authorId, avatar, c.creationDate ', ' comments c', " c.postId= $id ORDER BY c.creationDate DESC",
        $con,'', '', "JOIN users u ON c.authorId = u.id");
    $data = preparePostSatatisticDate($con, $rowsPosts[0]['id']);
    array_push($rowsPosts[0], array(
        'like' => $data[0]['like'],
        'comment' => $data[0]['comment'],
        'reposts' => $data[0]['reposts'],
        'view' => $data[0]['view'],
        'comments' => $comments,
    ));
    $userId = $_SESSION['id'];
    $url = "profileControl.php?UserId=$userId";

    $authorInfo = array();
    $postAuthor = SqlRequest('login, authorId, u.avatar, u.registrationDate', 'posts p', 'p.id =', $con, $id, ' ',
        'JOIN  users u ON p.authorId = u.id');
    $postsCount = SqlRequest("COUNT(id)", "posts", "authorId=", $con, $postAuthor[0]['authorId'], "count");
    $subscribersCount = SqlRequest('COUNT(users.id) ', 'subscription', 'authorId=', $con, $postAuthor[0]['authorId'],
        'count', 'JOIN users ON users.id = subscription.userId');
    array_push($authorInfo, array(
        'postAuthor' => $postAuthor[0],
        'postsCount' => $postsCount[0]['count'],
        'subscribersCount' => $subscribersCount[0]['count'],
    ));

    $isSubscribed = empty(mysqli_fetch_all(mysqli_query($con,
        "SELECT  * from subscription where userId = ".$_SESSION['id']." AND authorId =  ".$postAuthor[0]['authorId']),
        MYSQLI_ASSOC));

    if (isset($_POST['UserId'])) {
        $subscription = mysqli_real_escape_string($con, $_POST['UserId']);
        $sql = "SELECT  * from subscription where userId =  $userId  AND authorId = $subscription";
        if (empty(mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC))) {
            SqlInsert("subscription(authorId,userId)", $subscription.','.$_SESSION['id'], $con);
            $UserInfo = SqlRequest('email, login', 'users', 'id = ', $con, $subscription);
            $login = $UserInfo[0]['login'];
            $email = $UserInfo[0]['email'];
            $message = (new Swift_Message("Новый подписчик."))
                ->setTo([$email => $login])
                ->setFrom("keks@phpdemo.ru", "keks")
                ->setBody("Здравствуйте, $login. На вас подписался новый пользователь ".$_SESSION['userName'].". Вот ссылка на его профиль: $url");
            $mailer->send($message);

        } else {
            $sqlPost = "DELETE FROM subscription WHERE userId =  $userId  AND authorId = $subscription";
            mysqli_query($con, $sqlPost);
        }
        header("Location: ".$_SERVER["REQUEST_URI"]);
        exit;
    }

    $selectPageContent = [
        "post-link" => "postLink",
        "post-text" => "postText",
        "post-quote" => "postQuote",
        "post-photo" => "postPhoto",
    ];
    if (intval($_GET['id']) < 0) {
        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
        http_response_code(404);
        header('Location: 404.html');
        exit();
    }

    $pageContent = include_template($selectPageContent[$rowsPosts[0]['icon_name']].'.php',
        [
            'post' => $rowsPosts[0],
            'authorInfo' => $authorInfo[0],
            'con' => $con,
            'id' => $id,
            'isSubscribed' => $isSubscribed,
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


