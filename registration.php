<?php
include "helpers.php";
require("functions.php");
require('dbConfig.php');

$errors = [];
$res = 0;

if (isset($_POST['Send'])) {
    $required_fields = explode(" ", $_POST['Send']);
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } else {
            $errors[$field] = null;
        }
    }
    $login = mysqli_real_escape_string($con, $_POST['login']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $errors['email'] = EmailValidation($email);
    $errors['emailExist'] = IsEmailExist($con, $email);
    $errors['userpic-file-photo'] = photoValidation(htmlspecialchars($_FILES['userpic-file-photo']['name']));
    $errors['password'] = comparePassword(
        mysqli_real_escape_string($con, $_POST['password']),
        mysqli_real_escape_string($con, $_POST['password-repeat'])
    );
    $password = password_hash(mysqli_real_escape_string($con, $_POST['password']), PASSWORD_DEFAULT);
    if ($errors['email'] === null && $errors['password'] === null && $errors['login'] === null) {
        $res = SqlInsert(
            "users(email,login,password,avatar)",
            "'$email'".","."'$login'".', '."'$password'".",'userpic-petro.jpg'",
            $con
        );
    }
    if (intval($res) === 1) {
        echo include_template(
            'authorization.php',
            ['con' => $con, 'errors' => $errors, 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
        );
    }
}
$formErrors = include_template('widgets/formErrors.php', [
    'error' => $errors,
    'errorHeader' => array("Email", "Логин", "Пароль", "Повтор пароля ", "Аватар", "Email"),
]);
$pageContent = include_template('registration.php', ['con' => $con, 'errors' => $errors, 'formErrors'=> $formErrors]);
echo include_template(
    'layout.php',
    [
        'content' => $pageContent,
        'title' => 'Blog',
        'userName' => 'Новый юзер',
        'avatar' => "../img/userpic-larisa.jpg",
        'tab' =>isset($_GET['tab']) ? strip_tags($_GET['tab']) : '',
        'sessionId' => isset($_SESSION['id']) ? strip_tags($_SESSION['id']) : '',
    ]
);
