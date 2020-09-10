<?php
include "helpers.php";
require("functions.php");
$errors = [];
$res = 0;
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
if(isset($_POST['Send'])) {
    $required_fields = explode(" ", htmlspecialchars($_POST['Send']));
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } else {
            $errors[$field] = NULL;
        }
    }
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $errors['email'] = EmailValidation($email);
    $errors['emailExist'] = IsEmailExist($con,$email);
    $errors['userpic-file-photo'] = photoValidation();
    $errors['password'] = comparePassword();
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

//    var_dump($errors);
//    if ($errors['email']==null  and $errors['password']==null and $errors['userpic-file-photo ']==null ){
//        $image = $_POST['userpic-file-photo'];
//        $file_name = $_FILES['userpic-file-photo']['tmp_name'];
//        $save_name =  $_FILES['userpic-file-photo']['name'];
//        move_uploaded_file($_FILES['userpic-file-photo']['tmp_name'], $file_path . $save_name );
//        $link =   '/uploads/'. $save_name;
//      $res = SQLINSERT("users(email,login,password,avatar)", "'htmlspecialchars($email)'". ",". "'htmlspecialchars($login)'".', '."'htmlspecialchars($password)'".','."'htmlspecialchars($link)",$con);
//    }
    if ($errors['email']==null  and $errors['password']==null and $errors['login']==null){
         $res = SQLINSERT("users(email,login,password)", "'$email'". ",". "'$login'".', '."'$password'",$con);
    }
    if($res == 1){
        header("Location:http://395709-readme-12/");
    }
}
var_dump($errors);
$page_content = include_template('registration.php',['con' =>$con,'errors'=>$errors]);
print($page_content);
?>
