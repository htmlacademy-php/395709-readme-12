<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('helpers.php');
    require('functions.php');
    $postId = htmlspecialchars($_GET['postId']);
    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    $userId = $_SESSION['id'];
    $isLikeSet = SqlRequest("id", "likes", "recipientId = $postId  AND userId = $userId", $con);
    if ( ! $isLikeSet) {
        SQLINSERT('likes(recipientId, userId)', $postId.','.$userId, $con);
    } else {
        $sqlPost = "DELETE FROM likes WHERE recipientId = $postId  AND userId = $userId";
        mysqli_query($con, $sqlPost);
    }
    header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>
