<?php
session_start();
require('helpers.php');
require('functions.php');
require_once('mail.php');
require('dbConfig.php');

if (isset($_SESSION['userName'])) {
    $userId =  mysqli_real_escape_string($con, $_SESSION['id']);
    $url = "profileControl.php?UserId=$userId";
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

    $postAuthorId =mysqli_real_escape_string($con, isset($_GET['UserId']) ? $_GET['UserId'] : $subscription);
    if (isset($_GET['UserId'])) {
        if (! empty(mysqli_fetch_all(mysqli_query(
            $con,
            "SELECT  * from subscription where userId =   $userId  AND authorId =  $postAuthorId"
        ), MYSQLI_ASSOC))) {
            $isSubscribedOnPostAuthor = 1;
        } else {
            $isSubscribedOnPostAuthor = 0;
        }
    }

    $sql = "SELECT  * from users where id = $postAuthorId";
    $postAuthorInfo = mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC);

    $userPostsCount = SqlRequest(
        "COUNT(id)",
        "posts",
        "authorId=",
        $con,
        $postAuthorId,
        "count"
    );
    $id = mysqli_real_escape_string($con, $postAuthorId);
    $posts = SqlRequest("*", "posts", "authorId=$id ORDER BY creationDate DESC", $con);
    $userSubscribersCount = SqlRequest(
        'COUNT(users.id) ',
        'subscription',
        'authorId=',
        $con,
        mysqli_real_escape_string($con, $_GET['UserId']),
        'count',
        'JOIN users ON users.id = subscription.userId'
    );

    $comments = array();
    $iter = 0;
    foreach ($posts as $post) {
        $CommentInf = SqlRequest(
            'content, login, authorId, avatar ',
            ' comments c',
            ' c.postId= ',
            $con,
            mysqli_real_escape_string($con, $post['id']),
            '',
            "JOIN users u ON c.authorId = u.id"
        );
        $comments = SqlRequest(
            'content, login, authorId, avatar, c.creationDate ',
            ' comments c',
            " c.postId=".  mysqli_real_escape_string($con, $post['id'])." ORDER BY c.creationDate DESC",
            $con,
            '',
            '',
            "JOIN users u ON c.authorId = u.id"
        );
        $data = preparePostSatatisticDate($con, $post['id']);
        array_push($posts[$iter], array(
            'likesRepostComments' => include_template(
                'widgets/likesRepostsComments.php',
                [
                    'like' => $data[0]['like'],
                    'comment' => $data[0]['comment'],
                    'reposts' => $data[0]['reposts'],
                    'view' => $data[0]['view'],
                    'id' => $post['id'],
                ]
            ),
            'comments' =>  include_template(
                'widgets/comments.php',
                ['con' => $con, 'postId' => $post['id'], 'comments' => $comments]
            ),
            'postFeed'=> include_template('widgets/postFeed.php', [
                'con' => $con,
                'id' => intval($post['id']),
                'content' => $post['content'],
                'typeID' => $post['typeID'],
                'link' => '',
                'title' => $post['title'],
                'quoteAuthor' => $post['author'],
            ]),
            'tags' =>getTags($con, $post['id']),
        ));
        $iter++;
    }


    $postsWithLikes = SqlRequest(
        "likes.userId, likes.recipientId, posts.content, posts.typeID, users.avatar, users.login ",
        "likes ",
        "likes.recipientId IN (SELECT id FROM posts WHERE authorId = $userId) ",
        $con,
        '',
        '',
        ' JOIN posts ON  likes.recipientId = posts.id JOIN users ON users.id = userId'
    );

    $subscribers = SqlRequest(
        'users.login, users.avatar, users.id ',
        'subscription',
        'authorId=',
        $con,
        mysqli_real_escape_string($con, $_GET['UserId']),
        '',
        'JOIN users ON users.id = subscription.userId'
    );

    $iter = 0;
    foreach ($subscribers as $subscriber) {
        $postsCount = SqlRequest(
            "COUNT(id)",
            "posts",
            "authorId=",
            $con,
            $subscriber['id'],
            "count"
        );
        $subscribersCount = SqlRequest(
            'COUNT(users.id) ',
            'subscription',
            'authorId=',
            $con,
            mysqli_real_escape_string($con, $subscriber['id']),
            'count',
            'JOIN users ON users.id = subscription.userId'
        );
        $mutualSubscription = empty(mysqli_fetch_all(
            mysqli_query(
                $con,
                "SELECT  * from subscription where userId = ". mysqli_real_escape_string($con, $_SESSION['id'])." AND authorId =  ".$subscriber['id']
            ),
            MYSQLI_ASSOC
        ));
        array_push($subscribers[$iter], array(
            'subscribersCount' => $subscribersCount[0]['count'],
            'postsCount' => $postsCount[0]['count'],
            'mutualSubscription' => $mutualSubscription,
        ));
        $iter++;
    }
    $profileSubscriptions = include_template('widgets/profileSubscriptions.php', ['subscribers' => $subscribers, 'UserId' =>$_GET['UserId']]);
    $profileLikes  = include_template('widgets/profilelikes.php', ['postsWithLikes' => $postsWithLikes]);
    $profilePosts = include_template('widgets/profilePosts.php', ['posts' => $posts, 'con' => $con]);

    $pageContent = include_template(
        "profile.php",
        [
            'AuthorInfo' => $postAuthorInfo[0],
            'con' => $con,
            'profilePosts'=> $profilePosts,
            'profileLikes' => $profileLikes,
            'profileSubscriptions' =>$profileSubscriptions,
            'isSubscribedOnPostAuthor' => $isSubscribedOnPostAuthor,
            'posts' => $posts,
            'postsCount' => $userPostsCount[0]['count'],
            'subscribersCount' => $userSubscribersCount[0]['count'],
            'subscribers' => $subscribers,
            'userId' => $_GET['UserId'],
            'sessionId' => $_SESSION['id']
        ]
    );
    echo include_template(
        'layout.php',
        [
            'content' => $pageContent,
            'title' => 'Blog',
            'userName' => $_SESSION['userName'],
            'avatar' => "../img/".$_SESSION['avatar'],
            'tab' =>isset($_GET['tab']) ? ($_GET['tab']) : '',
            'sessionId' => $_SESSION['id'],
        ]
    );
} else {
    echo include_template(
        'authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']
    );
}
