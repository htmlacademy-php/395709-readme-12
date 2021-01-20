<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <?php
    if (! empty($messageAuthor)) { ?>
        <section class="messages tabs">
            <h2 class="visually-hidden">Сообщения</h2>
            <div class="messages__contacts" >
                <ul class="messages__contacts-list tabs__list" >
                    <?php
                    foreach ($messageAuthor as $author) { ?>
                        <li class="messages__contacts-item">
                            <a href="../messages.php?id=<?= intval($author['authorId']) === intval($sessionId) ? intval($author['recipientId']) : intval($author['authorId']) ?>&tab=message">
                                <div class="messages__contacts-tab <?=  intval($author['id']) === intval($id) || intval($newMessage) === intval($author['recipientId']) ?  'messages__contacts-tab--active' : '' ?>   ">
                                    <div class="messages__avatar-wrapper">
                                        <img class="messages__avatar" src="img/<?= strip_tags($author['avatar']) ?>"
                                             alt="Аватар пользователя">
                                    </div>
                                    <div class="messages__info">
                                                <span class="messages__contact-name">
                                                    <?= strip_tags($author['login']) ?>
                                                </span>
                                        <div class="messages__preview">
                                            <p class="messages__preview-text">
                                                <?=end($message)['content'] ?>
                                            </p>
                                            <time class="messages__preview-time" datetime="2019-05-01T14:40">
                                                <?= DateFormat(0, $author['DATE']) ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                    <?php } ?>
                </ul>
            </div>

            <div class="messages__chat">
                <?php
                if (isset($id) && !empty($id)) { ?>
                <div class="messages__chat-wrapper">

                    <ul class="messages__list tabs__content tabs__content--active">
                        <?php
                        foreach ($message as $mes) {
                            $role = intval($mes['authorId']) === intval($sessionId) ? 1 : 0 ?>
                            <li class="messages__item <?= intval($role)  === 1 ? 'messages__item--my' : '' ?>">
                                <div class="messages__info-wrapper">
                                    <div class="messages__item-avatar">
                                        <a class="messages__author-link"
                                           href="../profileControl.php?UserId=<?= intval($Author[$role]['id']) ?>">
                                            <img class="messages__avatar"
                                                 src="img/<?= strip_tags($Author[$role]['avatar']) ?>"
                                                 alt="Аватар пользователя">
                                        </a>
                                    </div>
                                    <div class="messages__item-info">
                                        <a class="messages__author" href="#">
                                            <?= strip_tags($Author[$role]['login']) ?>
                                        </a>
                                        <time class="messages__time" datetime="2019-05-01T14:40">
                                            <?= DateFormat(0, $mes['date']) ?>
                                        </time>
                                    </div>
                                </div>
                                <p class="messages__text">
                                    <?= strip_tags($mes['content']) ?>
                                </p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="comments">
                    <form class="comments__form form"
                          action="../messages.php?id=<?= intval($id) ?>&tab=message"
                          method="post">
                        <div class="comments__my-avatar">
                            <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                        </div>
                        <div class="form__input-section <?= ! empty($error) ? 'form__input-section--error' : '' ?>">
                                                <textarea class="comments__textarea form__textarea form__input"
                                                          name='text'
                                                          placeholder="Ваше сообщение"></textarea>
                            <label class="visually-hidden">Ваше сообщение</label>
                            <?php if (! empty($error)) { ?>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Ошибка валидации</h3>
                                    <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                </div>
                            <?php } ?>
                        </div>
                        <input type="hidden" id="recipientId" name="recipientId" value="<?= strip_tags($AuthorId) ?>">

                        <button class="comments__submit button button--green" type="submit">Отправить</button>
                    </form>
                <?php } else { ?>
                        <div class="container" style="height: 300px; width:100%">
                            <h2>Выберите человека, которому хотите написать</h2>
                        </div>
                <?php } ?>
                </div>

        </section>
        <?php
    } else { ?>
        <section class="search"  style="margin-top: 5%">
            <div class="search__no-results container">
                <p class="search__no-results-info">У вас пока нет сообщений</p>
                <p class="search__no-results-desc">
                    Попробуйте написать кому-нибудь перейдя по ссылке 'Сообщения' в профиле пользователя.                </p>
                <div class="search__links">
                </div>
            </div>
        </section>

    <?php } ?>
</main>

