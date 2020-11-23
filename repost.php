<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('functions.php');
    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
    $id = htmlspecialchars($_GET['id']);

    $data = SqlRequest('*', 'posts', 'id=', $con, $id);
    $title = $data[0]['title'];
    $content = $data[0]['content'];
    $typeID = $data[0]['typeID'];
    $authorId = $_SESSION['id'];
    $link = $data[0]['link'] + 1;
    $avatar = $_SESSION['avatar'];
    $sql = "UPDATE posts SET link =".$link." WHERE id = $id";
    $result = mysqli_query($con, $sql);

    $X = SQLINSERT("posts(title,content,typeID,authorId,link,avatar,views)",
        "'$title'".", "."'$content'".','."'$typeID'".', '."'$authorId'".','."'$link'".','."'$avatar'".', 0', $con);
    header("Location: ".$_SERVER['HTTP_REFERER']);

} else {
    header("Location:http://395709-readme-12/");
}


