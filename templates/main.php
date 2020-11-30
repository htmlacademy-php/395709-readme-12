<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">

                        <?php $id == 0 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active <?= $class ?> "
                           href="http://395709-readme-12/popular.php">
                            <span>Все</span>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php $id == 3 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--photo button <?= $class; ?>"
                           href="<?= typeRequest(3); ?>">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-photo"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php $id == 4 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--video button <?= $class; ?>"
                           href="<?= typeRequest(4); ?>">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="#icon-filter-video"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php $id == 1 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--text button <?= $class; ?>"
                           href="<?= typeRequest(1); ?>">
                            <span class="visually-hidden">Текст</span>
                            <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php $id == 2 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--quote button <?= $class; ?>"
                           href="<?= typeRequest(2); ?>">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="popular__filters-item filters__item">
                        <?php $id == 5 ? $class = "filters__button--active" : $class = ""; ?>
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
            foreach ($posts as $post):
                $date = DateFormat(1,$post['creationDate']);
                ?>
                <article class="popular__post post <?= $post['icon_name'] ?>">
                    <?php
                    $params['id'] = $post['id'];
                    $query = http_build_query($params);
                    $link = "/"."post.php"."?".$query;
                    ?>
                    <header class="post__header">
                        <a href="<?= $link; ?>"><h2> <?= htmlspecialchars($post['title']) ?></h2></a>
                    </header>
                    <div class="post__main">
                        <?php if ($post['icon_name'] == 'post-quote'): ?>
                            <blockquote>
                                <p>
                                    <?= htmlspecialchars($post['content']) ?>
                                </p>
                                <cite><?= $post['author'] ?> </cite>
                            </blockquote>

                        <?php elseif ($post['icon_name'] == 'post-text'): ?>
                            <div class="post__main">
                                <p><?= text_split(htmlspecialchars($post['content'])) ?></p>

                            </div>

                        <?php elseif ($post['icon_name'] == 'post-photo'): ?>
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?= htmlspecialchars($post['content']) ?>" alt="Фото от пользователя"
                                     width="360" height="240">
                            </div>


                        <?php elseif ($post['icon_name'] == 'post-link'): ?>
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                                 alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                                        </div>
                                    </div>
                                    <span><?= htmlspecialchars($post['content']) ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <br>
                        <div style="display:flex; margin-left: 10px">
                               <?php getTags($con,$post['id']);?>
                        </div>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link"
                               href=<?= sprintf("profileControl.php?UserId=%s", $post['authorId']) ?> title="Автор">
                                <div class="post__avatar-wrapper">
                                    <img class="post__author-avatar" src="img/<?= htmlspecialchars($post['avatar']) ?>"
                                         alt="Аватар пользователя" style="float:none" width="40" height="40">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"> <?= htmlspecialchars($post['login']) ?></b>
                                    <time class="post__time" datetime=""><?= $date ?> </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <?php echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $post['id']]);?>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>

        </div>
        <?php if ($postCount > 6) { ?>
            <div class="popular__page-links">
                <a class="popular__page-link popular__page-link--prev button button--gray"
                   href="http://395709-readme-12/popular.php?offset=<?= $offset > 0 ? $offset - 6 : $offset ?>&id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?> ">Предыдущая
                    страница</a>
                <a class="popular__page-link popular__page-link--next button button--gray"
                   href="http://395709-readme-12/popular.php?offset=<?= $offset + 6 < $postCount ? $offset + 6 : $offset ?>&id=<?= isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '' ?> ">Следующая
                    страница</a>
            </div>
        <?php } ?>
    </div>
</section>



