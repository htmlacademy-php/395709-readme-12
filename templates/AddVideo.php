<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span
                class="form__input-required">*</span></label>
    <div class="form__input-section <?= $error['Video-link'] != '' ? "form__input-section--error" : "" ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="Video-link"
               value="<?= getPostVal('Video-link') ?>" placeholder="Введите ссылку">
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
    <div class="form__input-section <?= $error['Video-tag'] != '' ? "form__input-section--error" : "" ?>">
        <input class="adding-post__input form__input" id="video-tags" type="text" name="Video-tag"
               value="<?= getPostVal('Video-tag') ?>" placeholder="Введите ссылку">
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
$errorVideoHeader = ["Заголовок", "Ссылка youtube", "Теги", "Ccылка"];
if (array_key_exists('video-heading',$error)){
    AddErrors($error,$errorVideoHeader);
} ?>
</div>
<div class="adding-post__buttons">
    <button class="adding-post__submit button button--main" type="submit" value="video-heading Video-link Video-tag"
            name='Send'>Опубликовать
    </button>
    <a class="adding-post__close" href="#">Закрыть</a>
</div>
