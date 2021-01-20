<section class="profile__subscriptions tabs__content">
    <h2 class="visually-hidden">Подписки</h2>
    <ul class="profile__subscriptions-list">
        <?php foreach ($subscribers as $subscriber) { ?>
            <li class="post-mini post-mini--photo post user">
                <div class="post-mini__user-info user__info">
                    <div class="post-mini__avatar user__avatar">
                        <a class="user__avatar-link" href="#">
                            <img class="post-mini__picture user__picture"
                                 src="../img/<?= strip_tags($subscriber['avatar']) ?>"
                                 alt="Аватар пользователя">
                        </a>
                    </div>
                    <div class="post-mini__name-wrapper user__name-wrapper">
                        <a class="post-mini__name user__name" href="#">
                            <span><?= strip_tags($subscriber['login']) ?></span>
                        </a>
                        <time class="post-mini__time user__additional"
                              datetime="2014-03-20T20:20">5
                            лет
                            на сайте
                        </time>
                    </div>
                </div>
                <div class="post-mini__rating user__rating">
                    <p class="post-mini__rating-item user__rating-item user__rating-item--publications">
                        <span class="post-mini__rating-amount user__rating-amount"><?= $subscriber[0]['postsCount'] ?></span>
                        <span class="post-mini__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="post-mini__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="post-mini__rating-amount user__rating-amount"><?= $subscriber[0]['subscribersCount'] ?> </span>
                        <span class="post-mini__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <div class="post-mini__user-buttons user__buttons">
                    <form action="../profileControl.php?UserId=<?= strip_tags($UserId) ?>"
                          method="post">
                        <input name="UserId" type="hidden"
                               value="<?= intval($subscriber['id']) ?>">
                        <button class="profile__user-button user__button user__button--subscription button button--main"
                                style="width: 100%;"
                                type="submit"><?= $subscriber[0]['mutualSubscription'] ? "Подписаться" : "Отписаться" ?></button>
                    </form>
                </div>
            </li>
        <?php } ?>
    </ul>
</section>
