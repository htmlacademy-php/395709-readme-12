<?php
if (isset($_SESSION['userName'])):?>
    <main class="page__main page__main--feed">
        <div class="container">
            <h1 class="page__title page__title--feed">Моя лента</h1>
        </div>
        <div class="page__main-wrapper container">
            <section class="feed">
                <h2 class="visually-hidden">Лента</h2>
                <div class="feed__main-wrapper">
                    <div class="feed__wrapper">

                        <?php $index = 0;
                        foreach ($posts as $post):
                            $params['id'] = $post['id'];
                            $query = http_build_query($params);
                            $link = "/"."post.php"."?".$query;

                            ?>
                            <article class="feed__post post post-photo">
                                <header class="post__header post__author">
                                    <a class="post__author-link"
                                       href="http://395709-readme-12/profileControl.php?UserId=<?= $post['authorId'] ?>"
                                       title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar" src="img/<?= $post['av'] ?>"
                                                 alt="Аватар пользователя" width="60" height="60">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= $post['login'] ?></b>
                                            <span class="post__time"><?= DateFormat(0, $post['creationDate']) ?></span>
                                        </div>
                                    </a>
                                </header>

                                <?php if ($post['typeID'] == 2): ?>
                                    <blockquote>
                                        <p>
                                            <?= htmlspecialchars($post['content']) ?>
                                        </p>
                                        <cite>Неизвестный Автор</cite>
                                    </blockquote>

                                <?php elseif ($post['typeID'] == 1): ?>
                                    <div class="post__main">
                                        <p style="margin-left: 10%"><?= text_split(htmlspecialchars($post['content'])) ?></p>

                                    </div>

                                <?php elseif ($post['typeID'] == 3): ?>
                                    <div class="post__main">
                                        <h2><a href="<?= $link; ?>">Наконец, обработала фотки!</a></h2>
                                        <div class="post-photo__image-wrapper">
                                            <img src="img/<?= htmlspecialchars($post['content']) ?>"
                                                 alt="Фото от пользователя" width="760" height="396">
                                        </div>
                                    </div>

                                <?php elseif ($post['typeID'] == 5): ?>
                                    <div class="post-link__wrapper">
                                        <a class="post-link__external" href="<?= $link; ?>" title="Перейти по ссылке">
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

                                <?php
                                $tagsId = SqlRequest('hashtagId', 'posthashtag', 'postId =', $con, $post['id']);
                                foreach ($tagsId

                                as $tag) {
                                $tagLink = SqlRequest('title', 'hashtag', 'id= ', $con,
                                    $tag["hashtagId"]); ?>
                                <a style="background-color: white; border: solid transparent; color: #2a4ad0;"
                                   href=<?= sprintf("http://395709-readme-12/search.php?request=%s",
                                       '%23'.$tagLink[0]['title']) ?><?= '#'.$tagLink[0]['title']; ?>
                                   </a>
                                    <?php } ?>

                                    <footer class="post__footer post__indicators">
                                        <div class="post__buttons">
                                            <a class="post__indicator post__indicator--likes button"
                                               href="like.php?postId=<?= $post['id'] ?>" title="Лайк">
                                                <svg class="post__indicator-icon" width="20" height="17">
                                                    <use xlink:href="#icon-heart"></use>
                                                </svg>
                                                <svg class="post__indicator-icon post__indicator-icon--like-active"
                                                     width="20" height="17">
                                                    <use xlink:href="#icon-heart-active"></use>
                                                </svg>
                                                <?php
                                                $ComLike = SqlRequest('COUNT(userId)', 'likes', 'recipientId =', $con,
                                                    $post['id'], "as L");
                                                ?>
                                                <span><?= $ComLike[0]['L'] ?></span>
                                                <span class="visually-hidden">количество лайков</span>
                                            </a>
                                            <a class="post__indicator post__indicator--comments button"
                                               href="http://395709-readme-12/post.php?id=<?= $post['id'] ?>"
                                               title="Комментарии">
                                                <svg class="post__indicator-icon" width="19" height="17">
                                                    <use xlink:href="#icon-comment"></use>
                                                </svg><?php $Comment = SqlRequest('COUNT(content)', 'comments',
                                                    'postId =', $con,
                                                    $post['id'], "as L"); ?>
                                                <span><?= $ComLike[0]['L'] ?></span>
                                                <span class="visually-hidden">количество комментариев</span>
                                            </a>
                                            <a class="post__indicator post__indicator--repost button"
                                               href="../repost.php?id=<?= $post['id'] ?>" title="Репост">
                                                <svg class="post__indicator-icon" width="19" height="17">
                                                    <use xlink:href="#icon-repost"></use>
                                                </svg>
                                                <?php $reposts = SqlRequest("link", "posts", "id = ", $con,
                                                    $post['id']) ?>
                                                <span><?= $reposts[0]['link'] ?></span>
                                                <span class="visually-hidden">количество репостов</span>
                                            </a>
                                        </div>
                                    </footer>
                            </article>
                        <? endforeach; ?>
                    </div>
                </div>
                <ul class="feed__filters filters">
                    <li class="feed__filters-item filters__item">
                        <?php $id == 0 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--ellipse filters__button--all filters__button--active <?= $class ?> "
                           href="http://395709-readme-12/">
                            <span>Все</span>
                        </a>
                    </li>
                    <li class="feed__filters-item filters__item">
                        <?php $id == 3 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--photo button <?= $class; ?>"
                           href="<?= typeRequest(3, 1); ?>">
                            <span class="visually-hidden">Фото</span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-photo"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="feed__filters-item filters__item">
                        <?php $id == 4 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--video button <?= $class; ?>"
                           href="<?= typeRequest(4, 1); ?>">
                            <span class="visually-hidden">Видео</span>
                            <svg class="filters__icon" width="24" height="16">
                                <use xlink:href="#icon-filter-video"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="feed__filters-item filters__item">
                        <?php $id == 1 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--text button <?= $class; ?>"
                           href="<?= typeRequest(1, 1); ?>">
                            <span class="visually-hidden">Текст</span>
                            <svg class="filters__icon" width="20" height="21">
                                <use xlink:href="#icon-filter-text"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="feed__filters-item filters__item">
                        <?php $id == 2 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--quote button <?= $class; ?>"
                           href="<?= typeRequest(2, 1); ?>">
                            <span class="visually-hidden">Цитата</span>
                            <svg class="filters__icon" width="21" height="20">
                                <use xlink:href="#icon-filter-quote"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="feed__filters-item filters__item">
                        <?php $id == 5 ? $class = "filters__button--active" : $class = ""; ?>
                        <a class="filters__button filters__button--link button <?= $class; ?>"
                           href="<?= typeRequest(5, 1); ?>">
                            <span class="visually-hidden">Ссылка</span>
                            <svg class="filters__icon" width="21" height="18">
                                <use xlink:href="#icon-filter-link"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </section>
            <aside class="promo">
                <article class="promo__block promo__block--barbershop">
                    <h2 class="visually-hidden">Рекламный блок</h2>
                    <p class="promo__text">
                        Все еще сидишь на окладе в офисе? Открой свой барбершоп по нашей франшизе!
                    </p>
                    <a class="promo__link" href="#">
                        Подробнее
                    </a>
                </article>
                <article class="promo__block promo__block--technomart">
                    <h2 class="visually-hidden">Рекламный блок</h2>
                    <p class="promo__text">
                        Товары будущего уже сегодня в онлайн-сторе Техномарт!
                    </p>
                    <a class="promo__link" href="#">
                        Перейти в магазин
                    </a>
                </article>
                <article class="promo__block">
                    <h2 class="visually-hidden">Рекламный блок</h2>
                    <p class="promo__text">
                        Здесь<br> могла быть<br> ваша реклама
                    </p>
                    <a class="promo__link" href="#">
                        Разместить
                    </a>
                </article>
            </aside>
        </div>
    </main>
    </body>
    </html>

<?php else:
    header("Location:http://395709-readme-12/");
endif; ?>

