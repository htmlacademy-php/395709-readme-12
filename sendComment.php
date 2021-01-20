<?php
session_start();
if (isset($_SESSION['userName'])) {
    require('functions.php');
    require('dbConfig.php');

    $errors = '';
    if (isset($_POST['comment'])) {
        $comment = mysqli_real_escape_string($con, $_POST['comment']);
        if (strlen($comment) < 4) {
            $errors = "Слишком короткий текст";
        }
        if (empty($comment)) {
            $errors = 'Поле не заполнено';
        }
        $postId = mysqli_real_escape_string($con, $_POST['postId']);
        $isPostExist = SqlRequest("*", "posts", "id =  $postId ", $con);
        if (empty($errors) && ! empty($isPostExist)) {
            SqlInsert('comments(content,authorId,postId)', "'$comment'".','.mysqli_real_escape_string($con, $_SESSION['id']).','.$postId, $con);
        }
        header("Location: ".$_SERVER['HTTP_REFERER']."&error=$errors");
    } else {
        echo include_template(
            'authorization.php',
            ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
        );
    }
}
