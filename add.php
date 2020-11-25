<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "helpers.php";
require("functions.php");
require_once('Mail.php');
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
$sql = "SELECT  title  from content_type";
$result = mysqli_query($con, $sql);
$rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
$errors = [];
$res = 0;
$url = 0;
$type = 0;
$avatar = $_SESSION['avatar'];

if (isset($_POST['Send'])) {
    $type = htmlspecialchars($_POST['name']);
    $required_fields = explode(" ", $_POST['Send']);
    $tagValidation = $_POST[$required_fields[2]];
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
            $errors['video'] = validateVideo();
            if ($errors['video-heading'] == null && $errors['Video-link'] == null && $errors['video'] == null) {
                $filename = $_POST['video-heading'];
                $videoValidation = $_POST['Video-link'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)",
                    "'$filename'".","."'$videoValidation'".','.$_SESSION['id'].",5,"."'$avatar'", $con);
            }
            break;

        case "photo-heading":
            $errors['Photo'] = photoValidation();
            if (($errors['photo-heading'] == null && $errors['userpic-file-photo'] == null && $errors['photo-link'] == null) || ($errors['photo-heading'] == null && $errors['userpic-file-photo'] == null) && $errors['Photo'] == null) {
                $file_name = $_FILES['userpic-file-photo']['tmp_name'];
                $save_name = $_FILES['userpic-file-photo']['name'];
                move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $file_path.$save_name);
                $link = '../uploads/'.$save_name;
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)",
                    "'$save_name'".','."'$link'".','.$_SESSION['id'].",3,"."'$avatar'", $con);
            }
            $errors['PhotoLink'] = validatePhotoLink();

            if ($errors['photo-heading'] == null && $errors['photo-link'] == null && $errors['PhotoLink'] == null) {
                $content = file_get_contents($_POST['photo-link']);
                $extension = explode(".", $_POST['photo-link']);
                $extension = end($extension);
                $filename = $_POST['photo-heading'];
                $local = __DIR__.'/uploads/'.$filename.'.'.$extension;
                file_put_contents($local, $content);
                $link = '../uploads/'.$filename.'.'.$extension;
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)",
                    "'$filename'".','."'$link'".','.$_SESSION['id'].",3,"."'$avatar'", $con);
            }
            break;
        case "quote-heading":
            if ($errors['quote-heading'] == null && $errors['QuoteName'] == null) {
                $filename = $_POST['quote-heading'];
                $content = $_POST['QuoteName'];
                $author = $_POST['quote-author'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar,author)",
                    "'$filename'".","."'$content'".','.$_SESSION['id'].",2,"."'$avatar'".','."'$author'", $con);
            }
            break;
        case "text-heading":
            if ($errors['text-heading'] == null && $errors['PostText'] == null) {
                $filename = $_POST['text-heading'];
                $content = $_POST['PostText'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)",
                    "'$filename'".","."'$content'".','.$_SESSION['id'].",1,"."'$avatar'", $con);
            }
            break;
        case "link-heading":
            if ($errors['link-heading'] == null && $errors['link-link'] == null) {
                $filename = $_POST['link-heading'];
                $content = $_POST['link-link'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)",
                    "'$filename'".","."'$content'".','.$_SESSION['id'].",5,"."'$avatar'", $con);
            }
            break;


    }


    $last_post_id = mysqli_insert_id($con);
    $tags = explode(" ", $tagValidation);
    $errors['tags'] = validateTag($tagValidation);
    if ($errors['tags'] == null && $res != false && $tags[0] != '') {
        foreach ($tags as $tag) {
            SQLINSERT('hashtag(title)', "'$tagValidation'", $con);
            $last_id = mysqli_insert_id($con);
            SQLINSERT("PostHashtag(userId,hashtagId,postId)", "1, ".$last_id.",".$last_post_id,
                $con);
        }
    }

    if ($res == 1 && $last_post_id != 0) {
        $subscribers = SqlRequest('users.email,users.login ', 'subscription', 'authorId=', $con, $_SESSION['id'], '',
            'JOIN users ON users.id = subscription.userId');
        $url = "http://395709-readme-12/profileControl.php?UserId=".$_SESSION['id'];
        foreach ($subscribers as $subscriber) {
            $message = (new Swift_Message("Новая публикация от пользователя ".$_SESSION['userName']))
                ->setTo([$subscriber['email'] => $subscriber['login']])
                ->setFrom("keks@phpdemo.ru", "keks")
                ->setBody("Здравствуйте,".$subscriber['login']." Пользователь ".$_SESSION['userName']." только что опубликовал новую запись $filename. Посмотрите её на странице пользователя: $url");
            $mailer->send($message);
        }
        $query = '/post.php?id='.$last_post_id;
        $url = "http://395709-readme-12".$query;
        header(sprintf("Location: %s", $url));
        exit;

    } else {
        $url = "";
    }

}
$scriptname = pathinfo(__FILE__, PATHINFO_BASENAME);

$page_content = include_template('adding-post.php',
    ['posts' => $rowsType, 'con' => $con, 'error' => $errors, 'scriptname' => $scriptname, 'type' => $type]);
$layout_content = include_template('layout.php',
    ['content' => $page_content, 'title' => 'Blog']);
print($layout_content);
?>
