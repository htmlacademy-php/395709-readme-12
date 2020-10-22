<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include "helpers.php";
require("functions.php");
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
$sql = "SELECT  title  from content_type";
$result = mysqli_query($con, $sql);
$rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
$errors = [];
$res = 0;
$url = 0;
$type = 0;

if(isset($_POST['Send']))
{
    $type = htmlspecialchars($_POST['name']);
    $required_fields = explode(" ", $_POST['Send']);
    $tagValidation = $_POST[$required_fields[2]];
    $file_path = __DIR__ . '/uploads/';
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
        else{
            $errors[$field] = NULL;
        }
    }
    switch ($required_fields[0]) {
        case "video-heading":
            $errors['video']=validateVideo();
            if ($errors['video-heading']==NULL && $errors['Video-link']==NULL && $errors['video']==NULL){
                    $filename = $_POST['video-heading'];
                    $videoValidation =$_POST['Video-link'];
                    $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)", "'$filename'". ",". "'$videoValidation'".",1,5,"."'userpic-larisa-small.jpg'",$con);
            }
            break;

        case "photo-heading":
            $errors['Photo'] = photoValidation();
            if (( $errors['photo-heading']==NULL && $errors['userpic-file-photo']==NULL && $errors['photo-link']==NULL) || ($errors['photo-heading']==NULL && $errors['userpic-file-photo']==NULL) &&  $errors['Photo']==NULL) {
                    $file_name = $_FILES['userpic-file-photo']['tmp_name'];
                    $save_name =  $_FILES['userpic-file-photo']['name'];
                    move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $file_path . $save_name );
                    $link =     '../uploads/'. $save_name;
                    $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)", "'$save_name'".',' ."'$link'".",1,3,"."'userpic-larisa-small.jpg'",$con);
            }
            $errors['PhotoLink'] = validatePhotoLink();

            if ($errors['photo-heading']==NULL && $errors['photo-link']==NULL && $errors['PhotoLink']==NULL){
                    $content = file_get_contents($_POST['photo-link']);
                    $extension = explode(".",   $_POST['photo-link']);
                    $extension = end($extension);
                    $filename = $_POST['photo-heading'];
                    $local= __DIR__ . '/uploads/'. $filename .'.' . $extension;
                    file_put_contents($local,$content);
                    $link =     '../uploads/'.$filename .'.' . $extension;
                    $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)", "'$filename'".',' ."'$link'".",1,3,"."'userpic-larisa-small.jpg'",$con);
            }
            break;
        case "quote-heading":
            if($errors['quote-heading']==NULL && $errors['QuoteName']==NULL){
                $filename = $_POST['quote-heading'];
                $content = $_POST['QuoteName'];
                $author = $_POST['quote-author'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar,author)", "'$filename'". ",". "'$content'".",1,2,"."'userpic-larisa-small.jpg'".','. "'$author'",$con);
            }
            break;
        case "text-heading":
            if($errors['text-heading']==NULL && $errors['PostText']==NULL){
                $filename = $_POST['text-heading'];
                $content = $_POST['PostText'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)", "'$filename'". ",". "'$content'".",1,1,"."'userpic-larisa-small.jpg'",$con);
            }
            break;
        case "link-heading":
            if($errors['link-heading']==NULL && $errors['link-link']==NULL){
                $filename = $_POST['link-heading'];
                $content = $_POST['link-link'];
                $res = SQLINSERT("posts(title,content,authorId, typeID,avatar)", "'$filename'". ",". "'$content'".",1,5,"."'userpic-larisa-small.jpg'",$con);
            }
            break;

    }


    $last_post_id = mysqli_insert_id($con);
    $tags = explode(" ", $tagValidation);
    $errors['tags'] = validateTag($tagValidation);
    if ($errors['tags']==NULL && $res!=FALSE){
        foreach ($tags as $tag){
            SQLINSERT('hashtag(title)', "'$tagValidation'", $con);
            $last_id = mysqli_insert_id($con);
            SQLINSERT("PostHashtag(userId,hashtagId,postId)", "1, ".$last_id ."," .$last_post_id ,$con); //переделать пост айди
        }
    }
    if ($res == 1 &&  $last_id!=0 ){
        $query  = '/post.php?id='.$last_post_id ;
        $url = "http://395709-readme-12". $query;
        header(sprintf("Location: %s",$url));
    }
    else{
        $url = "";
    }

}
$scriptname = pathinfo(__FILE__, PATHINFO_BASENAME);

$page_content = include_template('adding-post.php', ['posts' => $rowsType, 'con' =>$con, 'error' => $errors, 'scriptname' =>$scriptname, 'type' =>$type]);

print($page_content);
?>
