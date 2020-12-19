<?php
session_start();
require('functions.php');
require('dbConfig.php');
if (isset($_SESSION['userName'])) {
    $id = intval($_GET['id']);
    $data = SqlRequest('*', 'posts', 'id=', $con, $id);
    $title = $data[0]['title'];
    $content = $data[0]['content'];
    $typeID = $data[0]['typeID'];
    $authorId = $_SESSION['id'];
    $repostCount = $data[0]['repostCount'] + 1;
    $avatar = $_SESSION['avatar'];
    $sql = "UPDATE posts SET repostCount =".$repostCount." WHERE id = $id";
    $result = mysqli_query($con, $sql);

    SqlInsert("posts(title,content,typeID,authorId,repostCount,views)",
        "'$title'".", "."'$content'".','."'$typeID'".', '."'$authorId'".','."0, 0", $con);
    header("Location: ".$_SERVER['HTTP_REFERER']);

} else {
    echo include_template('authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']);
}


