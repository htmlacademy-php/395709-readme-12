<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('helpers.php');
    require('functions.php');
    require_once('Mail.php');
    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
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

    $postAuthorId = htmlspecialchars(isset($_GET['UserId']) ? htmlspecialchars($_GET['UserId']) : $subscription);
    if (isset($_GET['UserId'])) {
        if ( ! empty(mysqli_fetch_all(mysqli_query($con,
            "SELECT  * from subscription where userId =   $userId  AND authorId =  $postAuthorId"), MYSQLI_ASSOC))) {
            $isSubscribedOnPostAuthor = 1;
        } else {
            $isSubscribedOnPostAuthor = 0;
        }
    }


    $sql = "SELECT  * from users where id = $postAuthorId";
    $postAuthorInfo = mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC);
    $page_content = include_template("profile.php",
        ['AuthorInfo' => $postAuthorInfo, 'con' => $con, 'isSubscribedOnPostAuthor' => $isSubscribedOnPostAuthor]);
    echo include_template('layout.php', ['content' => $page_content, 'title' => 'Blog']);
} else {
    header("Location:http://395709-readme-12/");
}
?>
