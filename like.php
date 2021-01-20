<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('helpers.php');
    require('functions.php');
    require('dbConfig.php');

    $postId = mysqli_real_escape_string($con, $_GET['postId']);
    $userId = mysqli_real_escape_string($con, $_SESSION['id']);
    $isLikeSet = SqlRequest("id", "likes", "recipientId = $postId  AND userId = $userId", $con);

    if (! $isLikeSet) {
        SqlInsert('likes(recipientId, userId)', $postId.','.$userId, $con);
    } else {
        $sqlPost = "DELETE FROM likes WHERE recipientId = $postId  AND userId = $userId";
        mysqli_query($con, $sqlPost);
    }
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
