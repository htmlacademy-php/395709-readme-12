<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php
                        $post = [
                            $posts[2]['title'],
                            $posts[3]['title'],
                            $posts[0]['title'],
                            $posts[1]['title'],
                            $posts[4]['title'],
                        ];
                        $checkType = [
                            (empty($error) || $type == 1) ? true : false,
                            $type == 2 ? true : false,
                            $type == 3 ? true : false,
                            $type == 4 ? true : false,
                            $type == 5 ? true : false,
                        ];
                        $width = [22, 24, 20, 21, 21];
                        $height = [18, 16, 21, 20, 18];
                        $href = [
                            "#icon-filter-photo",
                            "#icon-filter-video",
                            "#icon-filter-text",
                            "#icon-filter-quote",
                            "#icon-filter-link",
                        ];
                        $i = 0;
                        foreach ($post as $postsTitle):?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class=" adding-post__tabs-link filters__button filters__button--photo  tabs__item  button  tabs__item--active  <?= $checkType[$i] ? "  filters__button--active" : "" ?>  "
                                   href="#">
                                    <svg class="filters__icon" width= <?= $width[$i]; ?> height=<?= $height[$i]; ?>>
                                        <use xlink:href=<?= $href[$i]; ?>></use>
                                    </svg>
                                    <span><?= $postsTitle ?> </span>
                                </a>
                            </li>
                            <?php $i++; endforeach; ?>
                    </ul>
                </div>

                <div class="adding-post__tab-content">
                    <section
                            class="adding-post__photo tabs__content  <?= ($type == 0 or $type == 1) ? " tabs__content--active" : "" ?> ">
                        <h2 class="visually-hidden">Форма добавления фото</h2>
                        <form class="adding-post__form form" action="add.php" method="post" name="addPhoto"
                              enctype="multipart/form-data" id=1>
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-heading">Заголовок
                                            <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $error['photo-heading'] != '' ? "form__input-section--error" : "" ?>">
                                            <input type="hidden" name="name" value="1">
                                            <input class="adding-post__input form__input  " id="photo-heading"
                                                   type="text" name="photo-heading"
                                                   value="<?= getPostVal('photo-heading'); ?>"
                                                   placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $error['photo-heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('AddPhoto.php', ['error' => $error]); ?>
                        </form>
                    </section>

                    <section
                            class="adding-post__video tabs__content  <?= $type == "2" ? " tabs__content--active" : "" ?> ">
                        <h2 class="visually-hidden">Форма добавления видео</h2>
                        <form class="adding-post__form form" action="add.php" name="addVideo" method="post"
                              enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-heading">Заголовок
                                            <span class="form__input-required">*</span></label>
                                        <div class="form__input-section  <?= $error['video-heading'] != '' ? "form__input-section--error" : "" ?>">
                                            <input type="hidden" name="name" value="2">
                                            <input class="adding-post__input form__input" id="video-heading" type="text"
                                                   name="video-heading" value="<?= getPostVal('video-heading') ?>"
                                                   placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $error['video-heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('AddVideo.php',
                                        ['error' => $error, 'scriptname' => $scriptname]); ?>
                        </form>
                    </section>

                    <section
                            class="adding-post__text tabs__content  <?= $type == 3 ? " tabs__content--active" : "" ?> ">
                        <h2 class="visually-hidden">Форма добавления текста</h2>
                        <form class="adding-post__form form" action="add.php" name="addText" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span
                                                    class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $error['text-heading'] != '' ? "form__input-section--error" : "" ?>">
                                            <input type="hidden" name="name" value="3">
                                            <input class="adding-post__input form__input" id="text-heading" type="text"
                                                   name="text-heading" value="<?= getPostVal('text-heading') ?>"
                                                   placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $error['text-heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('AddText.php', ['error' => $error]); ?>
                        </form>
                    </section>

                    <section
                            class="adding-post__quote tabs__content  <?= $type == 4 ? " tabs__content--active" : "" ?> ">
                        <h2 class="visually-hidden">Форма добавления цитаты</h2>
                        <form class="adding-post__form form" action="add.php" name="addQuote" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-heading">Заголовок
                                            <span class="form__input-required">*</span></label>
                                        <div class="form__input-section  <?= $error['quote-heading'] != '' ? "form__input-section--error" : "" ?>">
                                            <input type="hidden" name="name" value="4">
                                            <input class="adding-post__input form__input" id="quote-heading" type="text"
                                                   name="quote-heading" value="<?= getPostVal('quote-heading') ?>"
                                                   placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $error['quote-heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('AddQuote.php', ['error' => $error]); ?>
                        </form>
                    </section>

                    <section class="adding-post__link tabs__content  ">
                        <h2 class="visually-hidden">Форма добавления ссылки</h2>
                        <form class="adding-post__form form" action="add.php" name="addLink" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span
                                                    class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= $error['link-heading'] != '' ? "form__input-section--error" : "" ?>">
                                            <input type="hidden" name="name" value="5">
                                            <input class="adding-post__input form__input" id="link-heading" type="text"
                                                   name="link-heading" value="<?= getPostVal('link-heading') ?>"
                                                   placeholder="Введите заголовок">
                                            <button class="form__error-button button" type="button">!<span
                                                        class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $error['link-heading'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('AddLink.php', ['error' => $error]); ?>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>

