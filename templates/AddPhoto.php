<div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
                <div class="form__input-section <?= $error['photo-link']!='' ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-link" value="<?=getPostVal('photo-link')?>"  placeholder="Введите ссылку">
                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                    <h3 class="form__error-title">Заголовок сообщения</h3>
                    <p class="form__error-desc"><?= $error['photo-link'] ?></p>
                    </div>
                </div>
                </div>
                <div class="adding-post__input-wrapper form__input-wrapper">
                <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                <div class="form__input-section <?= $error['photo-tag']!='' ? "form__input-section--error" : "" ?>">
                    <input class="adding-post__input form__input" id="photo-tags" type="text" name="photo-tag" value="<?=getPostVal('photo-tag')?>" placeholder="Введите теги">
                    <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                    <div class="form__error-text">
                    <h3 class="form__error-title">Заголовок сообщения</h3>
                    <p class="form__error-desc"><?= $error['photo-tag'] ?></p>
                    </div>
                </div>
                </div>
            </div>
            <?php if (isset($error['photo-heading'])):?> 
            <div class="form__invalid-block">
                <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
                <ul class="form__invalid-list">
                <?php $errorPhotoHeader=["Заголовок","Ссылка из интернета","Теги","Фото","","Cсылка"];$i = 0; ?>
                <?php foreach ($error as $er) { ?>    
                    <?php 
                    if($er!=''):?>
                        <li class="form__invalid-item"><?= $errorPhotoHeader[$i].': '.$er; ?></li>
                    <?php endif;?>
                    <?php $i = $i+1;?>
                <?php } ?>
                </ul>
            </div>
            <?php endif;?>
            </div>
            <div class="adding-post__input-file-container form__input-container form__input-container--file">
                    <div class="adding-post__input-file-wrapper form__input-file-wrapper">
                      <div class="adding-post__file-zone adding-post__file-zone--photo form__file-zone dropzone">
                        <input class="adding-post__input-file form__input-file" id="userpic-file-photo" action="form.php" type="file" name="userpic-file-photo" title=" ">
                        <div class="form__file-zone-text">
                          <span>Перетащите фото сюда</span>
                        </div>
                      </div>
                      <button class="adding-post__input-file-button form__input-file-button form__input-file-button--photo button" type="button">
                        <span>Выбрать фото</span>
                        <svg class="adding-post__attach-icon form__attach-icon" width="10" height="20">
                          <use xlink:href="#icon-attach"></use>
                        </svg>
                      </button>
                    </div>
            <div class="adding-post__file adding-post__file--photo form__file dropzone-previews">

            </div>
            </div>
            <div class="adding-post__buttons">
            <button class="adding-post__submit button button--main" type="submit" value="photo-heading photo-link photo-tag userpic-file-photo" name="Send" >Опубликовать</button>
            <a class="adding-post__close" href="#">Закрыть</a>
            </div>