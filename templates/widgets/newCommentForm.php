<form class="comments__form form" action="../SendComment.php" method="post">
    <div class="comments__my-avatar">
        <img class="comments__picture" src=../img/<?= $_SESSION['avatar'] ?> alt="Аватар
             пользователя">
    </div>
    <div class="form__input-section <?= isset($_GET['error']) && ! empty($_GET['error']) ? 'form__input-section--error' : '' ?>">
        <input type="hidden" id="postId" name="postId" value=<?= $postId ?>>
        <textarea class="comments__textarea form__textarea form__input" name="comment"
                  placeholder="Ваш комментарий"></textarea>
        <label class="visually-hidden">Ваш комментарий</label>
        <button class="form__error-button button" type="button">!</button>
        <?php if (isset($_GET['error']) && ! empty($_GET['error'])) { ?>
            <div class="form__error-text">
                <h3 class="form__error-title">Ошибка валидации</h3>
                <p class="form__error-desc"><?= htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php } ?>
    </div>
    <button class="comments__submit button button--green" type="submit">Отправить</button>
</form>