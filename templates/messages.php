<main class="page__main page__main--messages">
    <h1 class="visually-hidden">Личные сообщения</h1>
    <?php
    if ( ! empty($messageAuthor)) { ?>
        <section class="messages tabs">
            <h2 class="visually-hidden">Сообщения</h2>
            <div class="messages__contacts">
                <ul class="messages__contacts-list tabs__list">
                    <?php $i = 0;
                    if (isset($_GET['id'])) {
                        $i = $_GET['id'];
                    }
                    foreach ($messageAuthor as $author) { ?>
                        <li class="messages__contacts-item">
                            <a href="http://395709-readme-12/messages.php?id=<?= $author['authorId'] == $_SESSION['id'] ? $author['recipientId'] : $author['authorId'] ?>&tab=message" >
                                <div class="messages__contacts-tab <?= ($author['authorId'] == $_SESSION['id'] ? $author['recipientId'] : $author['authorId']) == $_GET['id']  ? 'messages__contacts-tab--active' : '' ?>   ">
                                    <div class="messages__avatar-wrapper">
                                        <img class="messages__avatar" src="img/<?= $author['avatar'] ?>"
                                             alt="Аватар пользователя">
                                    </div>
                                    <div class="messages__info">
                                                <span class="messages__contact-name">
                                                    <?= $author['login'] ?>
                                                </span>
                                        <div class="messages__preview">
                                            <p class="messages__preview-text">
                                                Озеро Байкал – огромное
                                            </p>
                                            <time class="messages__preview-time" datetime="2019-05-01T14:40">
                                                <?= DateFormat(0, $author['DATE']) ?>
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <?php $i++;
                    } ?>
                </ul>
            </div>

                <div class="messages__chat">
                    <?php
                    if (isset($_GET['id'])) {?>
                    <div class="messages__chat-wrapper">

                        <ul class="messages__list tabs__content tabs__content--active">
                            <?php
                            $AuthorId = (htmlspecialchars(isset($_GET['id'])) ? htmlspecialchars($_GET['id']) : ($messageAuthor[0]['authorId'] == $_SESSION['id'] ? $messageAuthor[0]['recipientId'] : $messageAuthor[0]['authorId']));
                            $message = SqlRequest("  date,content,  message.authorId", "message",
                                "(recipientId = ".$_SESSION['id']." AND authorId =  ".$AuthorId.") OR (recipientId = ".$AuthorId." AND authorId =  ".$_SESSION['id'].")  ORDER BY date",
                                $con, '', '');
                            $Author = SqlRequest(" avatar, login,id", "users", "id = $AuthorId or id =  ".$_SESSION['id'],
                                $con);
                            foreach ($message as $mes) {
                                $role = $mes['authorId'] == $_SESSION['id'] ? 1 : 0 ?>
                                <li class="messages__item <?= $role == 1 ? 'messages__item--my' : '' ?>">
                                    <div class="messages__info-wrapper">
                                        <div class="messages__item-avatar">
                                            <a class="messages__author-link"
                                               href="http://395709-readme-12/profileControl.php?UserId=<?= $Author[$role]['id'] ?>">
                                                <img class="messages__avatar" src="img/<?= $Author[$role]['avatar'] ?>"
                                                     alt="Аватар пользователя">
                                            </a>
                                        </div>
                                        <div class="messages__item-info">
                                            <a class="messages__author" href="#">
                                                <?= $Author[$role]['login'] ?>
                                            </a>
                                            <time class="messages__time" datetime="2019-05-01T14:40">
                                                <?= DateFormat(0, $mes['date']) ?>
                                            </time>
                                        </div>
                                    </div>
                                    <p class="messages__text">
                                        <?= $mes['content'] ?>
                                    </p>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="comments">
                        <form class="comments__form form" action="../messages.php?id=<?= htmlspecialchars($_GET['id']) ?>&tab=message"
                              method="post">
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                            </div>
                            <div class="form__input-section <?= !empty($error) ? 'form__input-section--error' : '' ?>">
                                                <textarea class="comments__textarea form__textarea form__input" name='text'
                                                          placeholder="Ваше сообщение"></textarea>
                                <label class="visually-hidden">Ваше сообщение</label>
                                <?php if(!empty($error)){?>
                                    <button class="form__error-button button" type="button">!</button>
                                    <div class="form__error-text">
                                        <h3 class="form__error-title">Ошибка валидации</h3>
                                        <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                    </div>
                                <?php } ?>
                            </div>
                            <input type="hidden" id="recipientId" name="recipientId" value="<?= $AuthorId ?>">

                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <?php } else{?>
                                <div  class="container"  style="height: 300px">
                                    <h2  >Выберите человека, которому хотите написать</h2>
                                </div>
                       <?php } ?>
                    </div>

        </section>
        <?php
    } else { ?>
        <section class="search">
            <div class="search__results-wrapper">
                <div class="search__no-results container">
                    <p class="search__no-results-info">У вас пока нет сообщений</p>
                    <p class="search__no-results-desc">
                        Попробуйте написать кому-нибудь перейдя по ссылке 'Сообщения' в профиле пользователя.
                    </p>
                </div>
            </div>
        </section>

    <?php } ?>
</main>

