<!DOCTYPE html>
<?php
if (isset($_SESSION['userName'])){
?>
<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <img class="profile__picture user__picture" src="../img/<?= $AuthorInfo[0]['avatar'] ?>"
                             alt="Аватар пользователя" style="width: 100px;">
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= $AuthorInfo[0]['login'] ?></span>
                        <time class="profile__user-time user__time" datetime="2014-03-20">5 лет на сайте</time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <?php
                        $postsCount = SqlRequest("COUNT(id)", "posts", "authorId=", $con, $AuthorInfo[0]['id'],
                            "count");
                        $id = $AuthorInfo[0]['id'];
                        $posts = SqlRequest("*", "posts", "authorId=$id ORDER BY creationDate DESC", $con );
                        $subscribersCount = SqlRequest('COUNT(users.id) ', 'subscription', 'authorId=', $con,
                            htmlspecialchars($_GET['UserId']), 'count', 'JOIN users ON users.id = subscription.userId');

                        ?>
                        <span class="user__rating-amount"><?= $postsCount[0]["count"]; ?></span>
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= $subscribersCount[0]['count'] ?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <?php if( htmlspecialchars($_GET['UserId'])!=$_SESSION['id']){ ?>
                    <div class="profile__user-buttons user__buttons">
                        <form action="../profileControl.php?UserId=<?= htmlspecialchars($_GET['UserId']) ?>" method="post">
                            <input name="UserId" type="hidden" value="<?= htmlspecialchars($_GET['UserId']) ?>">
                            <button class="profile__user-button user__button user__button--subscription button button--main"
                                    style="width: 100%;"
                                    type="submit"><?= $isSubscribedOnPostAuthor == 0 ? "Подписаться" : "Отписаться" ?></button>
                        </form>
                        <a class="profile__user-button user__button user__button--writing button button--green"
                           href="messages.php?newMessage=<?= htmlspecialchars($_GET['UserId']) ?>&id=<?= htmlspecialchars($_GET['UserId']) ?>">Сообщение</a>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button filters__button--active tabs__item tabs__item--active button">Посты</a>
                        </li>
                        <?php if($_SESSION['id']== htmlspecialchars($_GET['UserId'])){ ?>

                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="#">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="#">Подписки</a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="profile__tab-content">
                    <section class="profile__posts tabs__content tabs__content--active">
                        <?php
                        foreach ($posts as $post):
                            $date = DateFormat(1,$post['creationDate']);?>
                            <h2 class="visually-hidden">Публикации</h2>
                            <article class="profile__post post post-photo">
                                <header class="post__header">
                                    <h2><a href="#"><?= htmlspecialchars($post['title']) ?></a></h2>
                                </header>
                                <?php
                                $link = '';
                                echo include_template('widgets/postFeed.php', ['con'=>$con, 'id' => $post['id'], 'content' =>$post['content'], 'typeID' =>$post['typeID'], 'link' => $link, 'title'=>$post['title']]);?>
                                <footer class="post__footer">
                                    <div style="display:flex; margin-left: 10px">
                                        <?php getTags($con,$post['id']);?>
                                    </div>
                                    <div class="post__indicators">
                                        <?php echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $post['id']]);?>
                                        <time class="post__time" datetime="2019-01-30T23:41"><?= $date ?></time>
                                    </div>
                                    <ul class="comments__list">
                                        <div style="margin:1%">
                                            <?php
                                            $CommentInf = SqlRequest('content, login, authorId, avatar ', ' comments c', ' c.postId= ',
                                                $con, $post['id'], '', "JOIN users u ON c.authorId = u.id"); ?>
                                            <?php foreach ($CommentInf as $inf): ?>
                                                <li class="comments__item user">
                                                    <div class="comments__avatar">
                                                        <a class="user__avatar-link" href="#">
                                                            <img class="comments__picture" src="img/<?= $inf['avatar'] ?>"
                                                                 alt="Аватар пользователя">
                                                        </a>
                                                    </div>
                                                    <div class="comments__info">
                                                        <div class="comments__name-wrapper">
                                                            <a class="comments__user-name" href="#">
                                                                <span><?= $inf['login'] ?></span>
                                                            </a>
                                                            <time class="comments__time" datetime="2019-03-20">1 ч назад</time>
                                                        </div>
                                                        <p class="comments__text">
                                                            <?= $inf['content'] ?>

                                                        </p>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </div>
                                    </ul>
                                </footer>

                            </article>
                        <? endforeach; ?>


                    </section>
                    <?php if($_SESSION['id']== htmlspecialchars($_GET['UserId'])){ ?>
                        <section class="profile__likes tabs__content">
                            <h2 class="visually-hidden">Лайки</h2>
                            <ul class="profile__likes-list">
                                <?php
                                $authorId = 1;
                                $likes = SqlRequest("likes.userId, likes.recipientId, posts.content, posts.typeID, users.avatar, users.login ",
                                    "likes ", "likes.recipientId IN (SELECT id FROM posts WHERE authorId = $authorId) ",
                                    $con, '', '',
                                    ' JOIN posts ON  likes.recipientId = posts.id JOIN users ON users.id = userId');
                                foreach ($likes as $like) { ?>
                                    <li class="post-mini post-mini--photo post user">
                                        <a class="post-mini post-mini--photo post user">
                                            <div class="post-mini__user-info user__info">
                                                <div class="post-mini__avatar user__avatar">
                                                    <a class="user__avatar-link" href="#">
                                                        <img class="post-mini__picture user__picture"
                                                             src="../img/<?= $like['avatar'] ?>"
                                                             alt="Аватар пользователя">
                                                    </a>
                                                </div>
                                                <div class="post-mini__name-wrapper user__name-wrapper">
                                                    <a class="post-mini__name user__name" href="#">
                                                        <span><?= $like['login'] ?></span>
                                                    </a>
                                                    <div class="post-mini__action">
                                                        <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                                                        <time class="post-mini__time user__additional"
                                                              datetime="2014-03-20T20:20">5
                                                            минут назад
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="post-mini__preview">
                                                <a class="post-mini__link" href="#" title="Перейти на публикацию">
                                                    <?php if ($like['typeID'] == 3) { ?>
                                                        <div class="post-mini__image-wrapper">
                                                            <img class="post-mini__image" src="../img/rock-small.png"
                                                                 width="109"
                                                                 height="109" alt="Превью публикации">
                                                        </div>
                                                        <span class="visually-hidden">Фото</span>

                                                    <?php } elseif ($like['typeID'] == 2) { ?>
                                                        <span class="visually-hidden">Цитата</span>
                                                        <svg class="post-mini__preview-icon" width="21" height="20">
                                                            <use xlink:href="#icon-filter-quote"></use>
                                                        </svg>
                                                    <?php } elseif ($like['typeID'] == 1) { ?>

                                                    <?php } elseif ($like['typeID'] == 5) { ?>
                                                        <span class="visually-hidden">Ссылка</span>
                                                        <svg class="post-mini__preview-icon" width="21" height="18">
                                                            <use xlink:href="#icon-filter-link"></use>
                                                        </svg>
                                                    <?php } else { ?>
                                                        <div class="post-mini__image-wrapper">
                                                            <img class="post-mini__image" src="../img/coast-small.png"
                                                                 width="109" height="109" alt="Превью публикации">
                                                            <span class="post-mini__play-big">
                                                                            <svg class="post-mini__play-big-icon" width="12"
                                                                                 height="13">
                                                                              <use xlink:href="#icon-video-play-big"></use>
                                                                            </svg>
                                                                        </span>
                                                        </div>
                                                        <span class="visually-hidden">Видео</span>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                    </li>
                                    </a>

                                <?php } ?>
                            </ul>
                        </section>

                        <section class="profile__subscriptions tabs__content">
                            <h2 class="visually-hidden">Подписки</h2>
                            <ul class="profile__subscriptions-list">
                                <?php
                                $subscribers = SqlRequest('users.login, users.avatar, users.id ', 'subscription',
                                    'authorId=', $con, htmlspecialchars($_GET['UserId']), '',
                                    'JOIN users ON users.id = subscription.userId');
                                foreach ($subscribers as $subscriber) {
                                    ?>
                                    <li class="post-mini post-mini--photo post user">
                                        <div class="post-mini__user-info user__info">
                                            <div class="post-mini__avatar user__avatar">
                                                <a class="user__avatar-link" href="#">
                                                    <img class="post-mini__picture user__picture"
                                                         src="../img/<?= $subscriber['avatar'] ?>"
                                                         alt="Аватар пользователя">
                                                </a>
                                            </div>
                                            <div class="post-mini__name-wrapper user__name-wrapper">
                                                <a class="post-mini__name user__name" href="#">
                                                    <span><?= $subscriber['login'] ?></span>
                                                </a>
                                                <time class="post-mini__time user__additional" datetime="2014-03-20T20:20">5
                                                    лет
                                                    на сайте
                                                </time>
                                            </div>
                                        </div>
                                        <div class="post-mini__rating user__rating">

                                            <?php
                                            $postsCount = SqlRequest("COUNT(id)", "posts", "authorId=", $con,
                                                $subscriber['id'], "count");
                                            ?>
                                            <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                                                <span class="post-mini__rating-amount user__rating-amount"><?= $postsCount[0]['count'] ?></span>
                                                <span class="post-mini__rating-text user__rating-text">публикаций</span>
                                            </p>
                                            <?php
                                            $subscribersCount = SqlRequest('COUNT(users.id) ', 'subscription', 'authorId=',
                                                $con, $subscriber['id'], 'count',
                                                'JOIN users ON users.id = subscription.userId');
                                            ?>
                                            <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                                                <span class="post-mini__rating-amount user__rating-amount"><?= $subscribersCount[0]['count'] ?> </span>
                                                <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                                            </p>
                                        </div>
                                        <div class="post-mini__user-buttons user__buttons">
                                            <form action="../profileControl.php?UserId=<?= htmlspecialchars($_GET['UserId']) ?>"
                                                  method="post">
                                                <input name="UserId" type="hidden"
                                                       value="<?= htmlspecialchars($subscriber['id']) ?>">
                                                <button class="profile__user-button user__button user__button--subscription button button--main"
                                                        style="width: 100%;"
                                                        type="submit"><?= empty(mysqli_fetch_all(mysqli_query($con,
                                                        "SELECT  * from subscription where userId = ".$_SESSION['id']." AND authorId =  ".$subscriber['id']),
                                                        MYSQLI_ASSOC)) ? "Подписаться" : "Отписаться" ?></button>
                                            </form>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </section>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
}
else {
    header("Location:http://395709-readme-12/");
} ?>
