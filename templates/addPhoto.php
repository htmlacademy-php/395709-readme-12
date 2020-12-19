<h2 class="visually-hidden">Форма добавления фото</h2>
<form class="adding-post__form form" action="add.php" name="addText" method="post">
    <div class="adding-post__form form" action="add.php" method="post" name="addPhoto"
         enctype="multipart/form-data" id=1>
        <div class="form__text-inputs-wrapper">
            <div class="form__text-inputs">
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-heading">Заголовок
                        <span class="form__input-required">*</span></label>
                    <div class="form__input-section <?= ! empty($error['photo-heading']) ? "form__input-section--error" : "" ?>">
                        <input type="hidden" name="name" value="1">
                        <input class="adding-post__input form__input  " id="photo-heading"
                               type="text" name="photo-heading"
                               value="<?= getPostVal('photo-heading', $con); ?>"
                               placeholder="Введите заголовок">
                        <button class="form__error-button button" type="button">!<span
                                    class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $error['photo-heading'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                    <div class="form__input-section <?= ! empty($error['photo-link']) ? "form__input-section--error" : "" ?>">
                        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-link"
                               value="<?= getPostVal('photo-link', $con) ?>" placeholder="Введите ссылку">
                        <button class="form__error-button button" type="button">!<span
                                    class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $error['photo-link'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="adding-post__input-wrapper form__input-wrapper">
                    <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                    <div class="form__input-section <?= ! empty($error['photo-tag']) ? "form__input-section--error" : "" ?>">
                        <input class="adding-post__input form__input" id="photo-tags" type="text" name="photo-tag"
                               value="<?= getPostVal('photo-tag', $con) ?>" placeholder="Введите теги">
                        <button class="form__error-button button" type="button">!<span
                                    class="visually-hidden">Информация об ошибке</span></button>
                        <div class="form__error-text">
                            <h3 class="form__error-title">Заголовок сообщения</h3>
                            <p class="form__error-desc"><?= $error['photo-tag'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ( ! empty($error)) {
                echo include_template('widgets/formErrors.php', [
                    'error' => $error,
                    'errorHeader' => array("Заголовок", "Ссылка из интернета", "Теги", "Фото", "", "Cсылка"),
                ]);
            } ?>
        </div>
        <div class="adding-post__input-file-container form__input-container form__input-container--file">
            <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                    <input class="adding-post__input-file form__input-file" id="userpic-file-photo" action="add.php"
                           type="file" name="userpic-file-photo" title=" ">
                    <div class="form__file-zone-text">
                        <span>Перетащите фото сюда</span>
                    </div>
                </div>
                <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button"
                        type="button">
                    <span>Выбрать фото</span>
                    <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                        <use xlink:href="#icon-attach"></use>
                    </svg>
                </button>
            </div>
            <div class="adding-post__file adding-post__file--photo form__file dropzone-previews"></div>
        </div>
        <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit"
                    value="photo-heading photo-link photo-tag userpic-file-photo" name="Send">Опубликовать
            </button>
            <a class="adding-post__close" href="#">Закрыть</a>
        </div>
    </div>
</form>
