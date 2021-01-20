<div class="post-details__user user">
    <div class="post-details__user-info user__info">
        <div class="post-details__avatar user__avatar">
            <a class="post-details__name user__name" href="#">
                <a class="post-details__avatar-link user__avatar-link" href="../profileControl.php?UserId=<?= $postAuthor['authorId']?>" >
                    <img class="post-details__picture user__picture"
                         src="../img/<?= strip_tags($postAuthor['avatar']) ?>" alt="Аватар пользователя">
                </a>
        </div>
         <div class="post-details__name-wrapper user__name-wrapper">
            <span><?= strip_tags($postAuthor['login']) ?> </span>
            </a>
            <br>
            <time class="post-details__time user__time" datetime="2014-03-20">Зарегистрировался: <?= DateFormat(0, $postAuthor['registrationDate']) ?></time>
        </div>
    </div>

    <div class="post-details__rating user__rating">
        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
            <span class="post-details__rating-amount user__rating-amount"><?= strip_tags($subscribersCount) ?></span>
            <span class="post-details__rating-text user__rating-text">подписчиков</span>
        </p>
        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
            <span class="post-details__rating-amount user__rating-amount"><?= strip_tags($postsCount) ?></span>
            <span class="post-details__rating-text user__rating-text">публикаций</span>
        </p>
    </div>
    <?php if (intval($postAuthor['authorId']) !==  intval($sessionId)) { ?>
        <div class="post-details__user-buttons user__buttons">
            <form action="../post.php?id=<?= intval($id) ?>"
                  method="post">
                <input name="UserId" type="hidden"
                       value="<?= intval($postAuthor['authorId']) ?>">
                <button class="profile__user-button user__button user__button--subscription button button--main"
                        style="width: 100%;"
                        type="submit"><?= $isSubscribed ? "Подписаться" : "Отписаться" ?></button>
            </form>
            <a class="user__button user__button--writing button button--green"
               href="messages.php?newMessage=<?= $postAuthor['authorId'] ?>&id=<?= $postAuthor['authorId'] ?>">Сообщение</a>
        </div>
    <?php } ?>
</div>