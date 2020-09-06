<?php
include "helpers.php";
require("functions.php");
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
$errors = [];
$res = 0;
if(isset($_POST['Send'])) {
    $required_fields = explode(" ", $_POST['Send']);
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } else {
            $errors[$field] = NULL;
        }
    }
    $errors['email'] = EmailValidation($con);
    $errors['userpic-file-photo'] = photoValidation();
    $errors['password'] = validatePassword();
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $login = $_POST['login'];
    $email = $_POST['email'];
//    var_dump($errors);
//    if ($errors['email']==null  and $errors['password']==null and $errors['userpic-file-photo ']==null ){
//        $image = $_POST['userpic-file-photo'];
//        $file_name = $_FILES['userpic-file-photo']['tmp_name'];
//        $save_name =  $_FILES['userpic-file-photo']['name'];
//        move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $file_path . $save_name );
//        $link =   '/uploads/'. $save_name;
//      $res = SQLINSERT("users(email,login,password,avatar)", "'$email'". ",". "'$login'".', '."'$password'".','."'$link",$con);
//    }
    if ($errors['email']==null  and $errors['password']==null and $errors['login']==null){
         $res = SQLINSERT("users(email,login,password)", "'$email'". ",". "'$login'".', '."'$password'",$con);
    }
    if($res == 1){
        header("Location:http://395709-readme-12/");
    }
}
$page_content = include_template('registration.php',['con' =>$con,'errors'=>$errors]);
print($page_content);
?>
