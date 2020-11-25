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
                        $posts = SqlRequest("*", "posts", "authorId=", $con, $AuthorInfo[0]['id']);
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
                        <?php $index = 0;
                        foreach ($posts as $post):
                            $date = DateFormat($index);
                            $index = $index + 1;

                            ?>
                            <h2 class="visually-hidden">Публикации</h2>
                            <article class="profile__post post post-photo">
                                <header class="post__header">
                                    <h2><a href="#"><?= htmlspecialchars($post['title']) ?></a></h2>
                                </header>
                                <div class="post__main">
                                    <?php if ($post['typeID'] == 2): ?>
                                        <blockquote>
                                            <p>
                                                <?= htmlspecialchars($post['content']) ?>
                                            </p>
                                            <cite>Неизвестный Автор</cite>
                                        </blockquote>

                                    <?php elseif ($post['typeID'] == 1): ?>
                                        <div class="post__main">
                                            <p style="margin-left: 10%"><?= text_split(htmlspecialchars($post['content'])) ?></p>

                                        </div>

                                    <?php elseif ($post['typeID'] == 3): ?>
                                        <div class="post-photo__image-wrapper">
                                            <img src="img/<?= htmlspecialchars($post['content']) ?>"
                                                 alt="Фото от пользователя" width="760" height="396">
                                        </div>


                                    <?php elseif ($post['typeID'] == 5): ?>
                                        <div class="post-link__wrapper">
                                            <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                                <div class="post-link__info-wrapper">
                                                    <div class="post-link__icon-wrapper">
                                                        <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                                             alt="Иконка">
                                                    </div>
                                                    <div class="post-link__info">
                                                        <h3><?= htmlspecialchars($post['title']) ?></h3>
                                                    </div>
                                                </div>
                                                <span><?= htmlspecialchars($post['content']) ?></span>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <footer class="post__footer">
                                    <div class="post__indicators">
                                        <div class="post__buttons">
                                            <a class="post__indicator post__indicator--likes button"
                                               href="like.php?postId=<?= $post['id'] ?>"
                                               title="Лайк">
                                                <svg class="post__indicator-icon" width="20" height="17">
                                                    <use xlink:href="#icon-heart"></use>
                                                </svg>
                                                <svg class="post__indicator-icon post__indicator-icon--like-active"
                                                     width="20" height="17">
                                                    <use xlink:href="#icon-heart-active"></use>
                                                </svg>
                                                <?php
                                                $ComLike = SqlRequest('COUNT(userId)', 'likes', 'recipientId =', $con,
                                                    $post['id'], "as L");
                                                ?>
                                                <span><?= $ComLike[0]['L'] ?></span>
                                                <span class="visually-hidden">количество лайков</span>
                                            </a>
                                            <a class="post__indicator post__indicator--repost button"
                                               href="../repost.php?id=<?= $post['id'] ?>" title="Репост">
                                                <svg class="post__indicator-icon" width="19" height="17">
                                                    <use xlink:href="#icon-repost"></use>
                                                </svg>
                                                <?php $reposts = SqlRequest("link", "posts", "id = ", $con,
                                                    $post['id']) ?>
                                                <span><?= $reposts[0]['link'] ?></span>
                                                <span class="visually-hidden">количество репостов</span>
                                            </a>
                                        </div>
                                        <time class="post__time" datetime="2019-01-30T23:41"><?= $date ?></time>
                                    </div>
                                    <div style="display:flex; margin-left: 10px">
                                        <?php
                                        $tagsId = SqlRequest('hashtagId', 'posthashtag', 'postId =', $con, $post['id']);
                                        foreach ($tagsId as $tag) {
                                            $tagLink = SqlRequest('title', 'hashtag', 'id= ', $con,
                                                $tag["hashtagId"]); ?>
                                            <a style="background-color: white; border: solid transparent; color: #2a4ad0;"
                                               href=<?= sprintf("http://395709-readme-12/search.php?request=%s",
                                                '%23'.$tagLink[0]['title']) ?>> <?= '#'.$tagLink[0]['title']; ?> </a>
                                        <?php } ?>
                                    </div>
                                </footer>
                                <div class="comments">
                                    <a class="comments__button button" href="#">Показать комментарии</a>
                                </div>
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
                                //                            echo '<pre>' ;
                                //                            print_r($likes);
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
