<div class="post-details__user user">
    <div class="post-details__user-info user__info">
        <div class="post-details__avatar user__avatar">
            <a class="post-details__name user__name" href="#">
                <?php
                $postAuthor = SqlRequest('login, authorId, u.avatar', 'posts p', 'p.id =', $con, $id, ' ',
                    'JOIN  users u ON p.authorId = u.id');
                ?>
                <a class="post-details__avatar-link user__avatar-link" href="#">
                    <img class="post-details__picture user__picture"
                         src="../img/<?= $postAuthor[0]['avatar'] ?>" alt="Аватар пользователя">
                </a>
        </div>
        <div class="post-details__name-wrapper user__name-wrapper">
            <span><?= $postAuthor[0]['login'] ?> </span>
            </a>
            <time class="post-details__time user__time" datetime="2014-03-20">5 лет на сайте</time>
        </div>
    </div>
    <?php $postsCount = SqlRequest("COUNT(id)", "posts", "authorId=", $con,
        $postAuthor[0]['authorId'], "count");
    $subscribersCount = SqlRequest('COUNT(users.id) ', 'subscription', 'authorId=',
        $con, $postAuthor[0]['authorId'], 'count',
        'JOIN users ON users.id = subscription.userId');
    ?>
    <div class="post-details__rating user__rating">
        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
            <span class="post-details__rating-amount user__rating-amount"><?= $subscribersCount[0]['count'] ?></span>
            <span class="post-details__rating-text user__rating-text">подписчиков</span>
        </p>
        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
            <span class="post-details__rating-amount user__rating-amount"><?= $postsCount[0]['count'] ?></span>
            <span class="post-details__rating-text user__rating-text">публикаций</span>
        </p>
    </div>
    <?php if( $postAuthor[0]['authorId'] != $_SESSION['id']){ ?>
        <div class="post-details__user-buttons user__buttons">
            <form action="../post.php?id=<?= htmlspecialchars($_GET['id']) ?>"
                  method="post">
                <input name="UserId" type="hidden"
                       value="<?= $postAuthor[0]['authorId'] ?>">
                <button class="profile__user-button user__button user__button--subscription button button--main"
                        style="width: 100%;"
                        type="submit"><?= empty(mysqli_fetch_all(mysqli_query($con,
                        "SELECT  * from subscription where userId = ".$_SESSION['id']." AND authorId =  ".$postAuthor[0]['authorId']),
                        MYSQLI_ASSOC)) ? "Подписаться" : "Отписаться" ?></button>
            </form>
            <a class="user__button user__button--writing button button--green"
               href="messages.php?newMessage=<?= $postAuthor[0]['authorId'] ?>&id=<?= $postAuthor[0]['authorId'] ?>">Сообщение</a>
        </div>
    <?php  }  ?>
</div>