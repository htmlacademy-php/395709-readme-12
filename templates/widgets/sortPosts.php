<ul class="feed__filters filters">
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 0 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active <?= $class ?> "
           href="../index.php">
            <span>Все</span>
        </a>
    </li>
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 3 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--photo button <?= $class; ?>"
           href="<?= typeRequest(3, 1); ?>">
            <span class="visually-hidden">Фото</span>
            <svg class="filters__icon" width="22" height="18">
                <use xlink:href="#icon-filter-photo"></use>
            </svg>
        </a>
    </li>
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 4 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--video button <?= $class; ?>"
           href="<?= typeRequest(4, 1); ?>">
            <span class="visually-hidden">Видео</span>
            <svg class="filters__icon" width="24" height="16">
                <use xlink:href="#icon-filter-video"></use>
            </svg>
        </a>
    </li>
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 1 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--text button <?= $class; ?>"
           href="<?= typeRequest(1, 1); ?>">
            <span class="visually-hidden">Текст</span>
            <svg class="filters__icon" width="20" height="21">
                <use xlink:href="#icon-filter-text"></use>
            </svg>
        </a>
    </li>
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 2 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--quote button <?= $class; ?>"
           href="<?= typeRequest(2, 1); ?>">
            <span class="visually-hidden">Цитата</span>
            <svg class="filters__icon" width="21" height="20">
                <use xlink:href="#icon-filter-quote"></use>
            </svg>
        </a>
    </li>
    <li class="feed__filters-item filters__item">
        <?php intval($id) === 5 ? $class = "filters__button--active" : $class = ""; ?>
        <a class="filters__button filters__button--link button <?= $class; ?>"
           href="<?= typeRequest(5, 1); ?>">
            <span class="visually-hidden">Ссылка</span>
            <svg class="filters__icon" width="21" height="18">
                <use xlink:href="#icon-filter-link"></use>
            </svg>
        </a>
    </li>
</ul>
