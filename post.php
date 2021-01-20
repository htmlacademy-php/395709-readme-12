<?php
session_start();
include "helpers.php";
require_once('mail.php');
require('functions.php');
require('dbConfig.php');

if (isset($_SESSION['userName'])) {
    $id = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : 0;
    $sql = "SELECT  title  from content_type";
    $result = mysqli_query($con, $sql);
    $rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $sqlPost = "SELECT p.id, p.title, login, p.title,  conT.icon_name, u.avatar, p.content, p.views, p.typeID, p.author FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id WHERE p.id = $id ORDER BY views DESC;";
    $resultPosts = mysqli_query($con, $sqlPost);
    $rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
    $comments = SqlRequest(
        'content, login, authorId, avatar, c.creationDate ',
        ' comments c',
        " c.postId= $id ORDER BY c.creationDate DESC",
        $con,
        '',
        '',
        "JOIN users u ON c.authorId = u.id"
    );
    $data = preparePostSatatisticDate($con, $rowsPosts[0]['id']);
    $userId =  mysqli_real_escape_string($con, $_SESSION['id']);
    $url = "profileControl.php?UserId=$userId";
    $sql = "UPDATE posts SET views =".(intval($data[0]['view']) + 1)." WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $authorInfo = array();
    $postAuthor = SqlRequest(
        'login, authorId, u.avatar, u.registrationDate',
        'posts p',
        'p.id =',
        $con,
        $id,
        ' ',
        'JOIN  users u ON p.authorId = u.id'
    );
    $postsCount = SqlRequest("COUNT(id)", "posts", "authorId=", $con, mysqli_real_escape_string($con, $postAuthor[0]['authorId']), "count");
    $subscribersCount = SqlRequest(
        'COUNT(users.id) ',
        'subscription',
        'authorId=',
        $con,
        mysqli_real_escape_string($con, $postAuthor[0]['authorId']),
        'count',
        'JOIN users ON users.id = subscription.userId'
    );
    array_push($authorInfo, array(
        'postAuthor' => $postAuthor[0],
        'postsCount' => $postsCount[0]['count'],
        'subscribersCount' => $subscribersCount[0]['count'],
    ));

    $isSubscribed = empty(mysqli_fetch_all(
        mysqli_query(
            $con,
            "SELECT  * from subscription where userId = ". mysqli_real_escape_string($con, $_SESSION['id'])." AND authorId =  ".mysqli_real_escape_string($con, $postAuthor[0]['authorId'])
        ),
        MYSQLI_ASSOC
    ));

    array_push($rowsPosts[0], array(
        'likesRepostsComments'=>include_template(
            'widgets/likesRepostsComments.php',
            [
                'like' => $data[0]['like'],
                'comment' => $data[0]['comment'],
                'reposts' => $data[0]['reposts'],
                'view' => $data[0]['view'],
                'id' => $id,
            ]
        ),
        'commentForm' => include_template(
            'widgets/newCommentForm.php',
            ['con' => $con, 'postId' => $id, 'error'=> isset($_GET['error']) ? $_GET['error'] : '' , 'avatar'=> $_SESSION['avatar']]
        ),
        'comments' => include_template(
            'widgets/comments.php',
            ['con' => $con, 'postId' => $id, 'comments' => $comments]
        ),
        'postCreator' =>include_template('widgets/postCreateUser.php', [
                'con' => $con,
                'id' => $id,
                'postAuthor' => $authorInfo[0]['postAuthor'],
                'postsCount' => $authorInfo[0]['postsCount'],
                'subscribersCount' => $authorInfo[0]['subscribersCount'],
                'isSubscribed' => $isSubscribed,
                'sessionId' => $_SESSION['id']
            ])));

    if (isset($_POST['UserId'])) {
        $subscription = mysqli_real_escape_string($con, $_POST['UserId']);
        $sql = "SELECT  * from subscription where userId =  $userId  AND authorId = $subscription";
        if (empty(mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC))) {
            SqlInsert("subscription(authorId,userId)", $subscription.','. mysqli_real_escape_string($con, $_SESSION['id']), $con);
            $UserInfo = SqlRequest('email, login', 'users', 'id = ', $con, $subscription);
            $login = $UserInfo[0]['login'];
            $email = $UserInfo[0]['email'];
            $message = (new Swift_Message("Новый подписчик."))
                ->setTo([$email => $login])
                ->setFrom("keks@phpdemo.ru", "keks")
                ->setBody("Здравствуйте, $login. На вас подписался новый пользователь ".$_SESSION['userName'].". Вот ссылка на его профиль: $url");
            $mailer->send($message);
        } else {
            $sqlPost = "DELETE FROM subscription WHERE userId =  $userId  AND authorId = $subscription";
            mysqli_query($con, $sqlPost);
        }
        header("Location: ".$_SERVER["REQUEST_URI"]);
        exit;
    }

    $selectPageContent = [
        "post-link" => "postLink",
        "post-text" => "postText",
        "post-quote" => "postQuote",
        "post-photo" => "postPhoto",
        "post-video" => "postVideo",
    ];
    if (intval($_GET['id']) < 0) {
        header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
        http_response_code(404);
        header('Location: 404.html');
        exit();
    }

    $pageContent = include_template(
        $selectPageContent[$rowsPosts[0]['icon_name']].'.php',
        [
            'post' => $rowsPosts[0],
            'con' => $con,
            'id' => $id,
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
