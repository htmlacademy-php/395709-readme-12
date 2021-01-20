<form class="comments__form form" action="../SendComment.php" method="post">
    <div class="comments__my-avatar">
        <img class="comments__picture" src=../img/<?= strip_tags($avatar) ?> alt="Аватар
             пользователя">
    </div>
    <div class="form__input-section <?= isset($error) && ! empty($error) ? 'form__input-section--error' : '' ?>">
        <input type="hidden" id="postId" name="postId" value=<?= strip_tags($postId) ?>>
        <textarea class="comments__textarea form__textarea form__input" name="comment"
                  placeholder="Ваш комментарий"></textarea>
        <label class="visually-hidden">Ваш комментарий</label>
        <button class="form__error-button button" type="button">!</button>
        <?php if (isset($error) && ! empty($error)) { ?>
            <div class="form__error-text">
                <h3 class="form__error-title">Ошибка валидации</h3>
                <p class="form__error-desc"><?= strip_tags($error); ?></p>
            </div>
        <?php } ?>
    </div>
    <button class="comments__submit button button--green" type="submit">Отправить</button>
</form>
