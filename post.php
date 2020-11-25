<?php
session_start();
if (isset($_SESSION['userName'])) {
    include "helpers.php";
    require_once('Mail.php');
    require('functions.php');
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;
    }

    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id, p.title, login, p.title,  conT.icon_name, p.avatar, p.content, p.views, p.typeID FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id WHERE p.id = $id ORDER BY views DESC;";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $userId = $_SESSION['id'];
    $url = "http://395709-readme-12/profileControl.php?UserId=$userId";
    if (isset($_POST['UserId'])) {
        $subscription = htmlspecialchars($_POST['UserId']);
        $sql = "SELECT  * from subscription where userId =  $userId  AND authorId = $subscription";
        if (empty(mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC))) {
            SQLINSERT("subscription(authorId,userId)", $subscription.','.$_SESSION['id'], $con);
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
    $page_content = include_template('post-details.php', ['posts' => $rowsPosts, 'con' => $con, 'id' => $id]);
    echo include_template('layout.php', ['content' => $page_content, 'title' => 'Blog']);
} else {
    header("Location:http://395709-readme-12/");
}


