<?php
session_start();
require("helpers.php");
require("functions.php");
$errors = [];
$con = [];
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
if (isset($_POST['Send'])) {
    $required_fields = explode(" ", htmlspecialchars($_POST['Send']));
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } else {
            $errors[$field] = null;
        }
    }

    if (is_null($errors['login']) && is_null($errors['password'])) {
        $UserData = mysqli_fetch_all(mysqli_query($con,
            sprintf("SELECT id, password, avatar  from users WHERE login ='%s'", htmlspecialchars($_POST['login']))),
            MYSQLI_ASSOC);
        if ( ! empty($UserData[0]['password'])) {
            if (password_verify(htmlspecialchars($_POST['password']), $UserData[0]['password'])) {
                $_SESSION['id'] = $UserData[0]['id'];
                $_SESSION['userName'] = htmlspecialchars($_POST['login']);
                $_SESSION['avatar'] = is_null($UserData[0]['avatar']) ? 'userpic-medium.jpg' : $UserData[0]['avatar'];
            } else {
                $errors["password"] = " Неверный логин или пароль";
            }

        } else {
            $errors["login"] = "Неверный логин или пароль";
        }

    }
}
//    echo '<pre>';
//    print_r($posts);

if (htmlspecialchars(isset($_GET['id']))) {
    if ($_GET['id'] != '') {
        $id = htmlspecialchars($_GET['id']);
        $posts = SqlRequest('ps.*, users.avatar AS av, users.login ', "posts  AS ps ",
            "authorId IN ( SELECT authorId FROM subscription WHERE userId = 4) AND  ps.typeID = $id ", $con, '', '',
            ' JOIN users ON users.id = ps.authorId');
    }
} else {
    $id = 0;
    $posts = SqlRequest('ps.*, users.avatar AS av, users.login ', "posts  AS ps ",
        "authorId IN ( SELECT authorId FROM subscription WHERE userId = 4) ", $con, '', '',
        ' JOIN users ON users.id = ps.authorId');
}


if (isset($_SESSION['userName'])) {
//    header("Location: http://395709-readme-12/templates/feed.php");
    $page_content = include_template('feed.php', ['posts' => $posts, 'con' => $con, 'id' => $id]);
    echo include_template('layout.php', ['content' => $page_content, 'title' => 'Blog']);
} else {
    echo include_template('authorization.php', ['con' => $con, 'errors' => $errors]);
}


?>
