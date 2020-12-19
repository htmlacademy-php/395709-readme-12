<h2 class="visually-hidden">Форма добавления ссылки</h2>
<form class="adding-post__form form" action="add.php" name="addLink" method="post">
    <div class="form__text-inputs-wrapper">
        <div class="form__text-inputs">
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="link-heading">Заголовок <span
                            class="form__input-required">*</span></label>
                <div class="form__input-section <?= ! empty($error['link-heading']) ? "form__input-section--error" : "" ?>">
                    <input type="hidden" name="name" value="5">
                    <input class="adding-post__input form__input" id="link-heading" type="text"
                           name="link-heading" value="<?= getPostVal('link-heading', $con) ?>"
                           placeholder="Введите заголовок">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['link-heading'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__textarea-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="post-link">Ссылка <span
                            class="form__input-required">*</span></label>
                <div class="form__input-section <?= ! empty($error['link-link']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="post-link" type="text" name="link-link"
                           placeholder="Введите ссылку"
                           value="<?= getPostVal('link-link', $con) ?>">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['link-link'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="link-tags">Теги</label>
                <div class="form__input-section <?= ! empty($error['link-tag']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="link-tags" type="text" name="link-tag"
                           placeholder="Введите тег"
                           value="<?= getPostVal('link-tag', $con) ?>">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['link-tag'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ( ! empty($error)) {
            echo include_template('widgets/formErrors.php',
                ['error' => $error, 'errorHeader' => array("Заголовок", "Ссылка", "Теги")]);
        } ?>
    </div>
    <div class="adding-post__buttons">
        <button class="adding-post__submit button button--main" type="submit" value="link-heading link-link link-tag"
                name='Send'>Опубликовать
        </button>
        <a class="adding-post__close" href="#">Закрыть</a>
    </div>
</form>
