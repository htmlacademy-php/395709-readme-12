<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('functions.php');
    include "helpers.php";

    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    $newMessageId = 0;
    $errors = [];
    if (htmlspecialchars(isset($_POST['text']))) {
        if (htmlspecialchars($_POST['text']) == '') {
            $errors['text'] = 'Поле не заполнено';
        }
        if (empty($errors)) {
            $id = htmlspecialchars($_POST['recipientId']);
            $content = htmlspecialchars($_POST['text']);
            SQLINSERT('message(authorId,recipientId,content)', $_SESSION['id'].', '.$id.','."'$content'", $con);
        }

    }
    if (htmlspecialchars(isset($_GET['newMessage']))) {
        $newMessageId = htmlspecialchars($_GET['newMessage']);
        if (empty(SqlRequest("id", "message",
            " (authorId = $newMessageId and recipientId = ".$_SESSION['id']."2 ) OR (authorId = ".$_SESSION['id']." and recipientId = $newMessageId)",
            $con))) {
            $newMessageAuthor = SqlRequest("  avatar, login", "users", "id =".$newMessageId, $con, '', '', "");
            $newMessageAuthor[0]['authorId'] = $newMessageId;
            $newMessageAuthor[0]['recipientId'] = $_SESSION['id'];
            date_default_timezone_set('Asia/Almaty');
            $newMessageAuthor[0]['DATE'] = date("Y-m-d H:i:s");
        } else {
            $newMessageAuthor = [];
        }
    }

    $messageAuthor = SqlRequest("  DATE, users.avatar, users.login, message.authorId, message.recipientId", "message",
        "recipientId =".$_SESSION['id']." or authorId = ".$_SESSION['id']." AND message.authorId NOT  in (SELECT recipientId FROM message  WHERE authorId = message.recipientId  ) group BY LEAST(message.authorId, message.recipientId)  ORDER BY DATE DESC  ",
        $con, '', '',
        "JOIN users ON IF(message.authorId = ".$_SESSION['id'].", users.id = message.recipientId  ,  users.id = message.authorId)  ");


    if ( ! empty($newMessageAuthor)) {
        array_unshift($messageAuthor, $newMessageAuthor[0]);
    }
    $layout_content = include_template("messages.php", ['messageAuthor' => $messageAuthor, 'con' => $con, 'error' => $errors]);
    echo include_template('layout.php', ['content' => $layout_content, 'title' => 'Blog']);

} else {
    header("Location:http://395709-readme-12/");
}
?>

