<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link <?= strip_tags($popularSorting) ?>" href="<?= "../".typeRequest($id)."&sort=popular&previous=".strip_tags($lastSort)."&dir=".strip_tags($dir) ;?>">
                            <span>Популярность</span>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link  <?= $likeSorting ?>" href="<?= "../".typeRequest($id)."&sort=like&previous=".strip_tags($lastSort)."&dir=".strip_tags($dir) ;?>">
                            <span>Лайки</span>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link  <?= $dateSorting ?>" href="<?= "../".typeRequest($id)."&sort=date&previous=".strip_tags($lastSort)."&dir=".strip_tags($dir) ;?>">
                            <span>Дата</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <?php intval($id) === 0 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active <?= $class ?> "
                           href="../popular.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php intval($id) === 3 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--photo button <?= $class; ?>"
                           href="<?= typeRequest(3); ?>">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-photo"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php intval($id) === 4 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--video button <?= $class; ?>"
                           href="<?= typeRequest(4); ?>">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="#icon-filter-video"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php intval($id) === 1 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--text button <?= $class; ?>"
                           href="<?= typeRequest(1); ?>">
                            <span class="visually-hidden">Текст</span>
                            <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php intval($id) === 2 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--quote button <?= $class; ?>"
                           href="<?= typeRequest(2); ?>">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php intval($id) === 5 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--link button <?= $class; ?>"
                           href="<?= typeRequest(5); ?>">
                            <span class="visually-hidden">Ссылка</span>
                            <svg class="filters__icon" width="21" height="18">
                                <use xlink:href="#icon-filter-link"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php
            foreach ($posts as $post) :?>
                <article class="popular__post post <?= strip_tags($post['icon_name']) ?>">
                    <header class="post__header">
                        <a href="<?= "/post.php?id=".intval($post['id']); ?>">
                            <h2> <?= strip_tags($post['title']) ?></h2></a>
                    </header>
                    <div class="post__main">
                        <?php if ($post['icon_name'] === 'post-quote') : ?>
                            <blockquote>
                                <p>
                                    <?= strip_tags($post['content']) ?>
                                </p>
                                <cite><?= strip_tags($post['author']) ?> </cite>
                            </blockquote>

                        <?php elseif ($post['icon_name'] === 'post-text') : ?>
                            <div class="post__main">
                                <p><?= text_split(strip_tags($post['content'])) ?></p>

                            </div>

                        <?php elseif ($post['icon_name'] === 'post-photo') : ?>
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?= strip_tags($post['content']) ?>" alt="Фото от пользователя"
                                     width="360" height="240">
                            </div>

                        <?php elseif ($post['icon_name'] === 'post-video') :?>
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?=embed_youtube_cover($post['content']); ?>
                                </div>
                                <a href="<?= "/post.php?id=".intval($post['id']); ?>" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                        <?php elseif ($post['icon_name'] === 'post-link') : ?>
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="<?= strip_tags($post['content']) ?>" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                                 alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= strip_tags($post['title']) ?></h3>
                                        </div>
                                    </div>
                                    <span><?= strip_tags($post['content']) ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <br>
                        <div style="display:flex; margin-left: 10px">
                            <?php foreach ($post[0]['tags'] as $tag) { ?>
                                <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                                   href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link"
                               href=<?= sprintf("profileControl.php?UserId=%s", intval($post['authorId'])) ?> title="Автор">
                                <div class="post__avatar-wrapper">
                                    <img class="post__author-avatar" src="img/<?= strip_tags($post['avatar']) ?>"
                                         alt="Аватар пользователя" style="float:none" width="40" height="40">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"> <?= strip_tags($post['login']) ?></b>
                                    <time class="post__time" datetime=""><?= DateFormat(1, $post['creationDate']) ?> </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <?= $post[0]['likesRepostsComments'] ?>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>

        </div>
        <?php if ($postCount > 6) { ?>
            <div class="popular__page-links">
                <a class="popular__page-link popular__page-link--prev button button--gray"
                   href="../popular.php?offset=<?= $offset > 0 ? $offset - 6 : $offset ?>&id=<?= isset($id) ? intval($id) : '' ?> ">Предыдущая
                    страница</a>
                <a class="popular__page-link popular__page-link--next button button--gray"
                   href="../popular.php?offset=<?= $offset + 6 < $postCount ? $offset + 6 : $offset ?>&id=<?= isset($id) ? intval($id) : '' ?> ">Следующая
                    страница</a>
            </div>
        <?php } ?>
    </div>
</section>



