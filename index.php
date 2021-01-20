<?php
session_start();
require("helpers.php");
require("functions.php");
require('dbConfig.php');

$errors = [];
if (isset($_POST['Send'])) {
    $required_fields = explode(" ", $_POST['Send']);
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        } else {
            $errors[$field] = null;
        }
    }

    if (is_null($errors['login']) && is_null($errors['password'])) {
        $UserData = mysqli_fetch_all(
            mysqli_query(
                $con,
                sprintf("SELECT id, password, avatar  from users WHERE login ='%s'", mysqli_real_escape_string($con, $_POST['login']))
            ),
            MYSQLI_ASSOC
        );
        if (! empty($UserData[0]['password'])) {
            if (password_verify(mysqli_real_escape_string($con, $_POST['password']), $UserData[0]['password'])) {
                $_SESSION['id'] = intval($UserData[0]['id']);
                $_SESSION['userName'] = $_POST['login'];
                $_SESSION['avatar'] = is_null($UserData[0]['avatar']) ? 'userpic-medium.jpg' : $UserData[0]['avatar'];
            } else {
                $errors["password"] = " Неверный логин или пароль";
            }
        } else {
            $errors["login"] = "Неверный логин или пароль";
        }
    }
}

if (isset($_SESSION['userName'])) {
    if (isset($_GET['id'])) {
        if (! empty($_GET['id'])) {
            $id = intval($_GET['id']);
            $posts = SqlRequest(
                'ps.*, users.avatar AS av, users.login ',
                "posts  AS ps ",
                "authorId IN ( SELECT authorId FROM subscription WHERE userId =".mysqli_real_escape_string($con, $_SESSION['id']).") AND  ps.typeID = $id ",
                $con,
                '',
                '',
                ' JOIN users ON users.id = ps.authorId'
            );
        }
    } else {
        $id = 0;
        $posts = SqlRequest(
            'ps.*, users.avatar AS av, users.login ',
            "posts  AS ps ",
            "authorId IN ( SELECT authorId FROM subscription WHERE userId = ".mysqli_real_escape_string($con, $_SESSION['id']).") ",
            $con,
            '',
            '',
            ' JOIN users ON users.id = ps.authorId'
        );
    }
    $iter = 0;
    foreach ($posts as $post) {
        $data = preparePostSatatisticDate($con, $post['id']);
        array_push($posts[$iter], array(
            'postFeed' => include_template('widgets/postFeed.php', [
                'con' => $con,
                'id' => $post['id'],
                'content' => $post['content'],
                'typeID' => $post['typeID'],
                'link' => "/post.php?id=".intval($post['id']),
                'title' => $post['title'],
                'quoteAuthor' => $post['author'],
            ]),
            'tags' =>getTags($con, $post['id']),
            'likesRepostsComments'=>include_template(
                'widgets/likesRepostsComments.php',
                [
                'like' => $data[0]['like'],
                'comment' => $data[0]['comment'],
                'reposts' => $data[0]['reposts'],
                'view' => $data[0]['view'],
                'id' => $post['id'],
                ]
            )
        ));
        $iter++;
    }
    $authorization = include_template(
        'authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
    );
    $advert  = include_template('widgets/advertising.php');
    $sort = include_template('widgets/sortPosts.php', ['id' => $id]);
    $pageContent = include_template('feed.php', ['posts' => $posts, 'con' => $con, 'id' => $id, 'sort' => $sort, 'advert'=> $advert,'authorization' => $authorization, 'userName' => $_SESSION['userName']]);
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
        ['con' => $con, 'errors' => $errors, 'avatar' => "../img/userpic-larisa.jpg"]
    );
}
