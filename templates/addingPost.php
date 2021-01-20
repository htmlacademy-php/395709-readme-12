<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--photo filters__button--active tabs__item tabs__item--active button  <?= (empty($error) || intval($type) === 1) ? "  filters__button--active" : "" ?> ">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-photo"></use>
                                </svg>
                                <span>Фото</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">

                            <a class="adding-post__tabs-link filters__button filters__button--video tabs__item button <?= intval($type) === 2 ? "  filters__button--active" : "" ?> "
                               href="#">
                                <svg class="filters__icon" width="24" height="16">
                                    <use xlink:href="#icon-filter-video"></use>
                                </svg>
                                <span>Видео</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--text tabs__item button <?= intval($type) === 3 ? "  filters__button--active" : "" ?> "
                               href="#">
                                <svg class="filters__icon" width="20" height="21">
                                    <use xlink:href="#icon-filter-text"></use>
                                </svg>
                                <span>Текст</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--quote tabs__item button <?= intval($type) === 4 ? "  filters__button--active" : "" ?> "
                               href="#">
                                <svg class="filters__icon" width="21" height="20">
                                    <use xlink:href="#icon-filter-quote"></use>
                                </svg>
                                <span>Цитата</span>
                            </a>
                        </li>
                        <li class="adding-post__tabs-item filters__item">
                            <a class="adding-post__tabs-link filters__button filters__button--link tabs__item button <?= intval($type) === 5 ? "  filters__button--active" : "" ?> "
                               href="#">
                                <svg class="filters__icon" width="21" height="18">
                                    <use xlink:href="#icon-filter-link"></use>
                                </svg>
                                <span>Ссылка</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <section
                            class="adding-post__photo tabs__content  <?= (intval($type) === 0 or intval($type) === 1) ? " tabs__content--active" : "" ?> ">
                        <?= $addPhoto; ?>
                    </section>

                    <section
                            class="adding-post__video tabs__content  <?= intval($type) === 2 ? " tabs__content--active" : "" ?> ">
                        <?= $addVideo; ?>
                    </section>

                    <section
                            class="adding-post__text tabs__content  <?= intval($type) === 3 ? " tabs__content--active" : "" ?> ">
                        <?= $addText; ?>
                    </section>

                    <section
                            class="adding-post__quote tabs__content  <?= intval($type) === 4 ? " tabs__content--active" : "" ?> ">
                        <?= $addQuote; ?>
                    </section>

                    <section
                            class="adding-post__link tabs__content <?= intval($type) === 5 ? " tabs__content--active" : "" ?> ">
                        <?= $addLink; ?>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>

