<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="post-link">Ссылка <span
                class="form__input-required">*</span></label>
    <div class="form__input-section <?= $error['link-link'] != '' ? "form__input-section--error" : "" ?>">
        <input class="adding-post__input form__input" id="post-link" type="text" name="link-link"
               value="<?= getPostVal('link-link') ?>">
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
    <div class="form__input-section <?= $error['link-tag'] != '' ? "form__input-section--error" : "" ?>">
        <input class="adding-post__input form__input" id="link-tags" type="text" name="link-tag"
               value="<?= getPostVal('link-tag') ?>" placeholder="Введите ссылку">
        <button class="form__error-button button" type="button">!<span
                    class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $error['link-tag'] ?></p>
        </div>
    </div>
</div>
</div>
<?php if (isset($error['link-heading'])): ?>
    <div class="form__invalid-block">
        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
        <ul class="form__invalid-list">
            <?php $errorHeader = ["Заголовок", "Ссылка", "Теги"];
            $i = 0; ?>
            <?php foreach ($error as $er) { ?>
                <?php
                if ($er != ''):?>
                    <li class="form__invalid-item"><?= $errorHeader[$i].': '.$er; ?></li>
                <?php endif; ?>
                <?php $i = $i + 1; ?>
            <?php } ?>

        </ul>
    </div>
<?php endif; ?>
</div>
<div class="adding-post__buttons">
    <button class="adding-post__submit button button--main" type="submit" value="link-heading link-link link-tag"
            name='Send'>Опубликовать
    </button>
    <a class="adding-post__close" href="#">Закрыть</a>
</div>