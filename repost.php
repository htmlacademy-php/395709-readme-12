<?php
session_start();
require('functions.php');
require('dbConfig.php');
if (isset($_SESSION['userName'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $data = SqlRequest('*', 'posts', 'id=', $con, $id);
    $title = mysqli_real_escape_string($con, $data[0]['title']);
    $content = mysqli_real_escape_string($con, $data[0]['content']);
    $typeID = mysqli_real_escape_string($con, $data[0]['typeID']);
    $authorId = mysqli_real_escape_string($con, $_SESSION['id']);
    $repostCount = $data[0]['repostCount'] + 1;
    $avatar = mysqli_real_escape_string($con, $_SESSION['avatar']);
    $sql = "UPDATE posts SET repostCount =".$repostCount." WHERE id = $id";
    $result = mysqli_query($con, $sql);

    SqlInsert(
        "posts(title,content,typeID,authorId,repostCount,views)",
        "'$title'".", "."'$content'".','."'$typeID'".', '."'$authorId'".','."0, 0",
        $con
    );
    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    echo include_template(
        'authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
    );
}
