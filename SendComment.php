<?php
    session_start();
    if(isset($_SESSION['userName'])) {
        require('functions.php');
        require('data.php');
        $errors = '';
        if (isset($_POST['comment'])) {
            $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
            $comment = htmlspecialchars($_POST['comment']);
            if (strlen($comment) < 4) {
                $errors = "Слишком короткий текст";
            }
            if (empty($comment)) {
                $errors = 'Поле не заполнено';
            }
            $postId = htmlspecialchars($_POST['postId']);
            $isPostExist = SqlRequest("*", "posts", "id =  $postId ", $con);
            if (empty($errors) && !empty($isPostExist)) {
               SQLINSERT('comments(content,authorId,postId)', "'$comment'" . ',' .  $_SESSION['id'] . ',' . $postId, $con);
            }
            header("Location: ".$_SERVER['HTTP_REFERER']."&error=$errors");
        } else {
            header("Location:http://395709-readme-12/");
        }
    }
?>
