<h2 class="visually-hidden">Форма добавления цитаты</h2>
<form class="adding-post__form form" action="add.php" name="addQuote" method="post">
    <div class="form__text-inputs-wrapper">
        <div class="form__text-inputs">
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="quote-heading">Заголовок
                    <span class="form__input-required">*</span></label>
                <div class="form__input-section  <?= ! empty($error['quote-heading']) ? "form__input-section--error" : "" ?>">
                    <input type="hidden" name="name" value="4">
                    <input class="adding-post__input form__input" id="quote-heading" type="text"
                           name="quote-heading" value="<?= getPostVal('quote-heading', $con) ?>"
                           placeholder="Введите заголовок">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['quote-heading'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__input-wrapper form__textarea-wrapper">
                <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span
                            class="form__input-required">*</span></label>
                <div class="form__input-section <?= ! empty($error['QuoteName']) ? "form__input-section--error" : "" ?>">
                    <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input"
                              id="cite-text"
                              name="QuoteName" placeholder="Текст цитаты"><?= getPostVal('QuoteName',
                            $con) ?></textarea>
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['QuoteName'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__textarea-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="quote-author">Автор <span
                            class="form__input-required">*</span></label>
                <div class="form__input-section <?= ! empty($error['quote-author']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author"
                           placeholder="Автор" value="<?= getPostVal('quote-author', $con) ?>">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['quote-author'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                <div class="form__input-section <?= ! empty($error['quote-tag']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="cite-tags" type="text" name="quote-tag"
                           value="<?= getPostVal('quote-tag', $con) ?>" placeholder="Введите теги">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['quote-tag'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ( ! empty($error)) {
            echo include_template('widgets/formErrors.php',
                ['error' => $error, 'errorHeader' => array("Заголовок", "Текст цитаты", "Автор", "Теги")]);
        } ?>
    </div>
    <div class="adding-post__buttons">
        <button class="adding-post__submit button button--main" type="submit"
                value="quote-heading QuoteName quote-tag quote-author" name='Send'>Опубликовать
        </button>
        <a class="adding-post__close" href="#">Закрыть</a>
    </div>
</form>