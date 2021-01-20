<?php
session_start();
require('functions.php');
include "helpers.php";
require('dbConfig.php');
if (isset($_SESSION['userName'])) {
    $newMessageId = 0;
    $errors = [];
    $AuthorId = [];
    $message = [];
    $Author = [];

    if (isset($_POST['text'])) {
        if ((string)$_POST['text'] === '') {
            $errors['text'] = 'Поле не заполнено';
        }
        if (empty($errors)) {
            $id = mysqli_real_escape_string($con, $_POST['recipientId']);
            $content = mysqli_real_escape_string($con, $_POST['text']);
            SqlInsert('message(authorId,recipientId,content)', $_SESSION['id'].', '.$id.','."'$content'", $con);
        }
    }
    if (isset($_GET['newMessage'])) {
        $newMessageId = mysqli_real_escape_string($con, $_GET['newMessage']);
        $isMessagesExist = empty(SqlRequest(
            "id",
            "message",
            " (authorId = $newMessageId and recipientId = ". mysqli_real_escape_string($con, $_SESSION['id'])."2 ) OR (authorId = ". mysqli_real_escape_string($con, $_SESSION['id'])." and recipientId = $newMessageId)",
            $con
        ));
        if ($isMessagesExist) {
            $newMessageAuthor = SqlRequest("  avatar, login", "users", "id =".$newMessageId, $con, '', '', "");
            $newMessageAuthor[0]['recipientId'] = $newMessageId;
            $newMessageAuthor[0]['authorId'] =  mysqli_real_escape_string($con, $_SESSION['id']);
            date_default_timezone_set('Asia/Almaty');
            $newMessageAuthor[0]['DATE'] = date("Y-m-d H:i:s");
        } else {
            $newMessageAuthor = [];
        }
    }
    mysqli_query($con, " SET sql_mode = ''");
    $messageAuthor = SqlRequest(
        "  DATE, users.avatar, users.login, message.authorId, message.recipientId, users.id",
        "message",
        "recipientId =". mysqli_real_escape_string($con, $_SESSION['id'])." or authorId = ". mysqli_real_escape_string($con, $_SESSION['id'])." AND message.authorId NOT  in (SELECT recipientId FROM message  WHERE authorId = message.recipientId  ) group BY LEAST(message.authorId, message.recipientId)  ORDER BY DATE DESC  ",
        $con,
        '',
        '',
        "JOIN users ON IF(message.authorId = ". mysqli_real_escape_string($con, $_SESSION['id']).", users.id = message.recipientId  ,  users.id = message.authorId)  "
    );
    if (!empty($newMessageAuthor) && !empty($messageAuthor)) {
        array_unshift($messageAuthor, $newMessageAuthor[0]);
    } elseif (!empty($newMessageAuthor)) {
        array_push($messageAuthor, $newMessageAuthor[0]);
    }

    if (! empty($messageAuthor)) {
        $AuthorId = mysqli_real_escape_string($con, (isset($_GET['id']) ? intval($_GET['id']) : (intval($messageAuthor[0]['authorId']) === intval($_SESSION['id']) ? $messageAuthor[0]['recipientId'] : $messageAuthor[0]['authorId'])));
        $message = SqlRequest(
            "  date,content,  message.authorId",
            "message",
            "(recipientId = ". mysqli_real_escape_string($con, $_SESSION['id'])." AND authorId =  ".$AuthorId.") OR (recipientId = ".$AuthorId." AND authorId =  ". mysqli_real_escape_string($con, $_SESSION['id']).")  ORDER BY date",
            $con
        );
        $Author = SqlRequest(
            " avatar, login,id",
            "users",
            "id = $AuthorId or id =  ". mysqli_real_escape_string($con, $_SESSION['id']),
            $con
        );
    }


    $pageContent = include_template(
        "messages.php",
        [
            'messageAuthor' => $messageAuthor,
            'con' => $con,
            'error' => $errors,
            'AuthorId' => $AuthorId,
            'Author' => $Author,
            'message' => $message,
            'id' => isset($_GET['id']) ? $_GET['id']: '' ,
            'sessionId' =>$_SESSION['id'],
            'newMessage' =>  isset($_GET['newMessage']) ? $_GET['newMessage']: '' ,
        ]
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
} else {
    echo include_template(
        'authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
    );
}
