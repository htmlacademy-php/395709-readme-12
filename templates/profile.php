<!DOCTYPE html>
<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
                <div class="profile__user-info user__info">
                    <div class="profile__avatar user__avatar">
                        <img class="profile__picture user__picture"
                             src="../img/<?= strip_tags($AuthorInfo['avatar']) ?>"
                             alt="Аватар пользователя" style="width: 100px;">
                    </div>
                    <div class="profile__name-wrapper user__name-wrapper">
                        <span class="profile__name user__name"><?= strip_tags($AuthorInfo['login']) ?></span>
                        <time class="profile__user-time user__time" datetime="2014-03-20">Зарегистрировался:  <?= DateFormat(0, $AuthorInfo['registrationDate']) ?></time>
                    </div>
                </div>
                <div class="profile__rating user__rating">
                    <p class="profile__rating-item user__rating-item user__rating-item--publications">
                        <span class="user__rating-amount"><?= strip_tags($postsCount); ?></span>
                        <span class="profile__rating-text user__rating-text">публикаций</span>
                    </p>
                    <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                        <span class="user__rating-amount"><?= strip_tags($subscribersCount) ?></span>
                        <span class="profile__rating-text user__rating-text">подписчиков</span>
                    </p>
                </div>
                <?php if (intval($userId) !== intval($sessionId)) { ?>
                    <div class="profile__user-buttons user__buttons">
                        <form action="../profileControl.php?UserId=<?= intval($userId) ?>"
                              method="post">
                            <input name="UserId" type="hidden" value="<?= intval($userId) ?>">
                            <button class="profile__user-button user__button user__button--subscription button button--main"
                                    style="width: 100%;"
                                    type="submit"><?= intval($isSubscribedOnPostAuthor) === 0 ? "Подписаться" : "Отписаться" ?></button>
                        </form>
                        <a class="profile__user-button user__button user__button--writing button button--green"
                           href="/messages.php?newMessage=<?= intval($userId) ?>&id=<?= intval($userId) ?>">Сообщение</a>
                    </div>
                <?php } ?>
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
                        <?php if (intval($sessionId) === intval($userId)) { ?>
                            <li class="profile__tabs-item filters__item">
                                <a class="profile__tabs-link filters__button tabs__item button" href="#">Лайки</a>
                            </li>
                            <li class="profile__tabs-item filters__item">
                                <a class="profile__tabs-link filters__button tabs__item button"
                                   href="#">Подписки</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="profile__tab-content">
                    <?php
                    echo $profilePosts;
                    if (intval($sessionId) === intval($userId)) {
                        echo $profileLikes,$profileSubscriptions;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

