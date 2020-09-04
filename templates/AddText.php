<div class="adding-post__textarea-wrapper form__textarea-wrapper">
        <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
        <div class="form__input-section <?= $error['PostText']!='' ? "form__input-section--error" : "" ?>">
            <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name = "PostText" placeholder="Введите текст публикации"><?=getPostVal('PostText'); ?></textarea>
            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
            <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $error['PostText'] ?></p>
            </div>
        </div>
        </div>
        <div class="adding-post__input-wrapper form__input-wrapper">
        <label class="adding-post__label form__label" for="post-tags">Теги</label>
        <div class="form__input-section <?= $error['Text-tag']!='' ? "form__input-section--error" : "" ?>">
            <input class="adding-post__input form__input" id="post-tags" type="text" name="Text-tag" value="<?=getPostVal('Text-tag')?>" placeholder="Введите теги">
            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
            <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $error['Text-tag'] ?></p>
            </div>
        </div>
        </div>
    </div>
    <?php if (isset($error['text-heading'])):?> 
    <div class="form__invalid-block">
        <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
        <ul class="form__invalid-list">
        <?php $errorHeader=["Заголовок","Текст поста","Теги"];$i = 0; ?>
        <?php foreach ($error as $er) { ?>    
            <?php 
            if($er!=''):?>
                 <li class="form__invalid-item"><?= $errorHeader[$i].': '.$er; ?></li>
            <?php endif;?>
            <?php $i = $i+1;?>
        <?php } ?>
        </ul>
    </div>
    <?php endif;?>
    </div>
    <div class="adding-post__buttons">
    <button class="adding-post__submit button button--main" type="submit" value="text-heading PostText Text-tag" name='Send'>Опубликовать</button>
    <a class="adding-post__close" href="#">Закрыть</a>
    </div>