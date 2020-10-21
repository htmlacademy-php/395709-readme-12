<?php
session_start();
if(isset($_SESSION['userName'])){
    require('helpers.php');
    require('functions.php');
    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
    $userId = $_SESSION['id'];

    if(isset($_POST['UserId'])){
        $subscription = htmlspecialchars($_POST['UserId']);
        $sql = "SELECT  * from subscription where userId =  $userId  AND authorId = $subscription";
        if(empty(mysqli_fetch_all( mysqli_query($con, $sql ), MYSQLI_ASSOC))){
            SQLINSERT("subscription(authorId,userId)",$subscription.','.$_SESSION['id'],$con);
        }
        else{
            $sqlPost = "DELETE FROM subscription WHERE userId =  $userId  AND authorId = $subscription";
            mysqli_query($con, $sqlPost);
        }
        header("Location: ".$_SERVER["REQUEST_URI"]);
        exit;
    }

    $postAuthorId = htmlspecialchars(isset($_GET['UserId']) ? htmlspecialchars($_GET['UserId']) : $subscription );
    if(isset($_GET['UserId'])) {
        if (!empty(mysqli_fetch_all(mysqli_query($con, "SELECT  * from subscription where userId =   $userId  AND authorId =  $postAuthorId"), MYSQLI_ASSOC))) {
            $isSubscribedOnPostAuthor = 1;
        }
        else{
            $isSubscribedOnPostAuthor = 0;
        }
    }


    $sql = "SELECT  * from users where id = $postAuthorId";
    $postAuthorInfo = mysqli_fetch_all( mysqli_query($con, $sql), MYSQLI_ASSOC);
    $layout_content = include_template("profile.php",['AuthorInfo'=>$postAuthorInfo, 'con'=>$con, 'isSubscribedOnPostAuthor'=>$isSubscribedOnPostAuthor]);
    print($layout_content);
}
else{
    header("Location:http://395709-readme-12/");
}
?>
