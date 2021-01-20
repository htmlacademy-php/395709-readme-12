<?php
session_start();

include "helpers.php";
require("functions.php");
require_once('mail.php');
require('dbConfig.php');

if (isset($_SESSION['userName'])) {
    $errors = [];
    $res = 0;
    $url = 0;
    $type = 0;
    $rowsType = SqlRequest("title", "content_type", "id>0", $con);

    if (isset($_POST['Send'])) {
        $type = htmlspecialchars($_POST['name']);
        $required_fields = explode(" ", htmlspecialchars($_POST['Send']));
        $tagValidation = htmlspecialchars($_POST[$required_fields[2]]);
        $file_path = __DIR__.'/uploads/';
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = 'Поле не заполнено';
            } else {
                $errors[$field] = null;
            }
        }

        switch ($required_fields[0]) {
            case "video-heading":
                $videoLink = mysqli_real_escape_string($con, $_POST['Video-link']);
                $errors['Video-link'] = validateVideo($videoLink);
                if ($errors['video-heading'] === null && $errors['Video-link'] === null) {
                    $filename = mysqli_real_escape_string($con, $_POST['video-heading']);
                    $videoValidation = mysqli_real_escape_string($con, $_POST['Video-link']);
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID)",
                        "'$filename'".","."'$videoValidation'".','.mysqli_real_escape_string($con, $_SESSION['id']).",4",
                        $con
                    );
                }
                break;

            case "photo-heading":
                $errors['photo-link'] = validatePhotoLink(htmlspecialchars($_POST['photo-link']));
                if (($errors['photo-heading'] === null && ! empty($_FILES['userpic-file-photo']['name']) && $errors['photo-link'] === null)) {
                    $file_name = mysqli_real_escape_string($con, $_FILES['userpic-file-photo']['tmp_name']);
                    $save_name = mysqli_real_escape_string($con, $_FILES['userpic-file-photo']['name']);
                    move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $file_path.$save_name);
                    $link = '../uploads/'.$save_name;
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID)",
                        "'$save_name'".','."'$link'".','.mysqli_real_escape_string($con, $_SESSION['id']).",3",
                        $con
                    );
                }

                if ($errors['photo-heading'] === null && $errors['photo-link'] === null && empty($_FILES['userpic-file-photo']['name'])) {
                    $content = file_get_contents(mysqli_real_escape_string($con, $_POST['photo-link']));
                    $extension = explode(".", mysqli_real_escape_string($con, ($_POST['photo-link'])));
                    $extension = end($extension);
                    $filename = mysqli_real_escape_string($con, $_POST['photo-heading']);
                    $local = __DIR__.'/uploads/'.$filename.'.'.$extension;
                    file_put_contents($local, $content);
                    $link = '../uploads/'.$filename.'.'.$extension;
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID)",
                        "'$filename'".','."'$link'".','.mysqli_real_escape_string($con, $_SESSION['id']).",3",
                        $con
                    );
                }
                break;
            case "quote-heading":
                if ($errors['quote-heading'] === null && $errors['QuoteName'] === null) {
                    $filename = mysqli_real_escape_string($con, $_POST['quote-heading']);
                    $content = mysqli_real_escape_string($con, $_POST['QuoteName']);
                    $author = mysqli_real_escape_string($con, $_POST['quote-author']);
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID,author)",
                        "'$filename'".","."'$content'".','.mysqli_real_escape_string($con, $_SESSION['id']).",2,"."'$author'",
                        $con
                    );
                }
                break;
            case "text-heading":
                if ($errors['text-heading'] === null && $errors['PostText'] === null) {
                    $filename = mysqli_real_escape_string($con, $_POST['text-heading']);
                    $content = mysqli_real_escape_string($con, $_POST['PostText']);
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID)",
                        "'$filename'".","."'$content'".','.mysqli_real_escape_string($con, $_SESSION['id']).",1",
                        $con
                    );
                }
                break;
            case "link-heading":
                $errors['link-link'] = validateLink(htmlspecialchars($_POST['link-link']));
                if ($errors['link-heading'] === null && $errors['link-link'] === null) {
                    $filename = mysqli_real_escape_string($con, $_POST['link-heading']);
                    $content = mysqli_real_escape_string($con, $_POST['link-link']);
                    $res = SqlInsert(
                        "posts(title,content,authorId, typeID)",
                        "'$filename'".","."'$content'".','.mysqli_real_escape_string($con, $_SESSION['id']).",5",
                        $con
                    );
                }
                break;
        }
        $lastPostId = mysqli_insert_id($con);
        $tags = explode(" ", $tagValidation);
        $errors['tags'] = validateTag($tagValidation);
        if ($errors['tags'] === null && $res !== false && ! empty($tags[0])) {
            foreach ($tags as $tag) {
                $tag = mysqli_real_escape_string($con, $tag);
                $isExist = SqlRequest("id", "hashtag", "title = "."'$tag'", $con);
                if (!empty($isExist)) {
                    $last_id = $isExist[0]['id'];
                } else {
                    SqlInsert('hashtag(title)', "'$tag'", $con);
                    $last_id = mysqli_insert_id($con);
                }
                SqlInsert(
                    "PostHashtag(userId,hashtagId,postId)",
                    "1, ".$last_id.",".$lastPostId,
                    $con
                );
            }
        }

        if ($res === true && intval($lastPostId) !== 0) {
            $subscribers = SqlRequest(
                'users.email,users.login ',
                'subscription',
                'authorId=',
                $con,
                mysqli_real_escape_string($con, $_SESSION['id']),
                '',
                'JOIN users ON users.id = subscription.userId'
            );
            $url = "/profileControl.php?UserId=".intval($_SESSION['id']);
            foreach ($subscribers as $subscriber) {
                $message = (new Swift_Message("Новая публикация от пользователя ".$_SESSION['userName']))
                    ->setTo([$subscriber['email'] => $subscriber['login']])
                    ->setFrom("keks@phpdemo.ru", "keks")
                    ->setBody("Здравствуйте,".$subscriber['login']." Пользователь ".$_SESSION['userName']." только что опубликовал новую запись $filename. Посмотрите её на странице пользователя: $url");
                $mailer->send($message);
            }
            $query = '/post.php?id='.$lastPostId;
            header(sprintf("Location: %s", $query));
            exit;
        } else {
            $url = "";
        }
    }
    $errorFormLink = include_template(
        'widgets/formErrors.php',
        ['error' => $errors, 'errorHeader' => array("Заголовок", "Ссылка", "Теги")]
    );
    $errorFormPhoto = include_template('widgets/formErrors.php', [
        'error' => $errors,
        'errorHeader' => array("Заголовок", "Ссылка из интернета", "Теги", "Фото", "", "Cсылка"),
    ]);
    $errorFormQuote =  include_template(
        'widgets/formErrors.php',
        ['error' => $errors, 'errorHeader' => array("Заголовок", "Текст цитаты", "Автор", "Теги")]
    );
    $errorFormText = include_template(
        'widgets/formErrors.php',
        ['error' => $errors, 'errorHeader' => array("Заголовок", "Текст поста", "Теги")]
    );
    $errorFormVideo = include_template(
        'widgets/formErrors.php',
        ['error' => $errors, 'errorHeader' => array("Заголовок", "Ссылка youtube", "Теги", "Ccылка")]
    );
    $pageContent = include_template(
        'addingPost.php',
        [
            'posts' => $rowsType,
            'con' => $con,
            'error' => $errors,
            'type' => $type,
            'addPhoto'   => include_template('addPhoto.php', ['error' => $errors, 'con' => $con, 'errorForm'=>$errorFormPhoto]),
            'addVideo' =>include_template('addVideo.php', ['error' => $errors, 'con' => $con, 'errorForm'=>$errorFormVideo]),
            'addText' =>include_template('addText.php', ['error' => $errors, 'con' => $con, 'errorForm'=>$errorFormText ]),
            'addQuote' =>include_template('addQuote.php', ['error' => $errors, 'con' => $con, 'errorForm'=>$errorFormQuote]),
            'addLink' =>include_template('addLink.php', ['error' => $errors, 'con' => $con, 'errorForm'=>$errorFormLink]),
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
