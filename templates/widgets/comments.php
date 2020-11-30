<div class="comments">
    <form class="comments__form form" action="../SendComment.php" method="post">
        <div class="comments__my-avatar">
            <img class="comments__picture" src=../img/<?= $_SESSION['avatar'] ?> alt="Аватар
                 пользователя">
        </div>
        <div class="form__input-section form__input-section--error">
            <input type="hidden" id="postId" name="postId" value=<?= $postId ?>>
            <textarea class="comments__textarea form__textarea form__input" name="comment"
                      placeholder="Ваш комментарий"></textarea>
            <label class="visually-hidden">Ваш комментарий</label>
            <button class="form__error-button button" type="button">!</button>
            <?php if (htmlspecialchars(isset($_GET['error']))) { ?>
                <?php if ( ! empty($_GET['error'])) { ?>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Ошибка валидации</h3>
                        <p class="form__error-desc"><?= htmlspecialchars($_GET['error']); ?></p>
                    </div>
                <?php }
            } ?>
        </div>
        <button class="comments__submit button button--green" type="submit">Отправить</button>
    </form>
    <div class="comments__list-wrapper">
        <ul class="comments__list">
            <?php
            $CommentInf = SqlRequest('content, login, authorId, avatar ', ' comments c', ' c.postId= ',
                $con, $id, '', "JOIN users u ON c.authorId = u.id");
            ?>
            <?php foreach ($CommentInf as $inf): ?>
                <li class="comments__item user">
                    <div class="comments__avatar">
                        <a class="user__avatar-link" href="#">
                            <img class="comments__picture" src="../img/<?= $inf['avatar'] ?>"
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
        </ul>
    </div>
</div>