<h2 class="visually-hidden">Форма добавления видео</h2>
<form class="adding-post__form form" action="add.php" name="addVideo" method="post"
      enctype="multipart/form-data">
    <div class="form__text-inputs-wrapper">
        <div class="form__text-inputs">
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="video-heading">Заголовок
                    <span class="form__input-required">*</span></label>
                <div class="form__input-section  <?= ! empty($error['video-heading']) ? "form__input-section--error" : "" ?>">
                    <input type="hidden" name="name" value="2">
                    <input class="adding-post__input form__input" id="video-heading" type="text"
                           name="video-heading" value="<?= getPostVal('video-heading', $con) ?>"
                           placeholder="Введите заголовок">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['video-heading'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span
                            class="form__input-required">*</span></label>
                <div class="form__input-section <?= ! empty($error['Video-link']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="video-url" type="text" name="Video-link"
                           value="<?= getPostVal('Video-link', $con) ?>" placeholder="Введите ссылку">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['Video-link'] ?></p>
                    </div>
                </div>
            </div>
            <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="video-tags">Теги</label>
                <div class="form__input-section <?= ! empty($error['Video-tag']) ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="video-tags" type="text" name="Video-tag"
                           value="<?= getPostVal('Video-tag', $con) ?>" placeholder="Введите ссылку">
                    <button class="form__error-button button" type="button">!<span
                                class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                        <h3 class="form__error-title">Заголовок сообщения</h3>
                        <p class="form__error-desc"><?= $error['Video-tag'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (! empty($error)) {
            echo $errorForm;
        } ?>
    </div>
    <div class="adding-post__buttons">
        <button class="adding-post__submit button button--main" type="submit" value="video-heading Video-link Video-tag"
                name='Send'>Опубликовать
        </button>
        <a class="adding-post__close" href="#">Закрыть</a>
    </div>
</form>
