<?php
if (isset($_SESSION['userName'])) {
    ?>


    <main class="page__main page__main--search-results">
        <h1 class="visually-hidden">Страница результатов поиска</h1>
        <section class="search">
            <h2 class="visually-hidden">Результаты поиска</h2>
            <div class="search__query-wrapper">
                <div class="search__query container">
                    <span>Вы искали:</span>
                    <span class="search__query-text"><?= $search ?></span>
                </div>
            </div>
            <div class="search__results-wrapper">
                <div class="container">
                    <div class="search__content">
                        <?php
                        $index = 0;
                        foreach ($posts as $post):
                            $date = DateFormat($index);
                            $index = $index + 1;
                            $PostAuthor = SqlRequest('avatar,login', 'users', ' id = ', $con, $post['authorId']);
                            ?>
                            <article class="search__post post post-text">
                                <header class="post__header post__author">
                                    <a class="post__author-link" href="#" title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar"
                                                 src="../img/<?= $PostAuthor[0]['avatar'] ?>"
                                                 alt="Аватар пользователя">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= $PostAuthor[0]['login'] ?></b>
                                            <span class="post__time"><?= $date ?></span>
                                        </div>
                                    </a>
                                </header>
                                <div class="post__main">
                                    <?php if ($post['typeID'] == 2): ?>
                                        <blockquote>
                                            <p>
                                                <?= htmlspecialchars($post['content']) ?>
                                            </p>
                                            <cite>Xью Оден</cite>
                                        </blockquote>
                                    <?php elseif ($post['typeID'] == 1): ?>
                                        <h2><a href="#">  <?= $post['title'] ?></a></h2>
                                        <p>
                                            <?= text_split($post['content']); ?>
                                        </p>
                                    <?php elseif ($post['typeID'] == 3): ?>
                                        <h2><a href="#"><?= $post['title'] ?></a></h2>
                                        <div class="post-photo__image-wrapper">
                                            <img src="../img/<?= htmlspecialchars($post['content']) ?>"
                                                 alt="Фото от пользователя" width="760" height="396">
                                        </div>
                                    <?php elseif ($post['typeID'] == 5): ?>
                                        <div class="post-link__wrapper">
                                            <a class="post-link__external" href="http://www.vitadental.ru"
                                               title="Перейти по ссылке">
                                                <div class="post-link__icon-wrapper">
                                                    <img src="../img/logo-vita.jpg" alt="Иконка">
                                                </div>
                                                <div class="post-link__info">
                                                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                                                    <span><?= htmlspecialchars($post['content']) ?></span>
                                                </div>
                                                <svg class="post-link__arrow" width="11" height="16">
                                                    <use xlink:href="#icon-arrow-right-ad"></use>
                                                </svg>
                                            </a>
                                        </div>

                                    <?php elseif ($post['typeID'] == 4): ?>
                                        <div class="post-video__preview">-->
                                            <img src="../img/coast.jpg" alt="Превью к видео" width="760" height="396">
                                        </div>
                                        <div class="post-video__control">
                                            <button class="post-video__play post-video__play--paused button button--video"
                                                    type="button"><span class="visually-hidden">Запустить видео</span>
                                            </button>
                                            <div class="post-video__scale-wrapper">
                                                <div class="post-video__scale">
                                                    <div class="post-video__bar">
                                                        <div class="post-video__toggle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video"
                                                    type="button"><span
                                                        class="visually-hidden">Полноэкранный режим</span></button>
                                        </div>
                                        <button class="post-video__play-big button" type="button">
                                            <svg class="post-video__play-big-icon" width="27" height="28">
                                                <use xlink:href="#icon-video-play-big"></use>
                                            </svg>
                                            <span class="visually-hidden">Запустить проигрыватель</span>
                                        </button>
                                    <?php endif; ?>

                                    <br>
                                    <div style="display:flex; margin-left: 10px ">
                                        <?php
                                        $tagsId = SqlRequest('hashtagId', 'posthashtag', 'postId =', $con, $post['id']);
                                        foreach ($tagsId as $tag) {
                                            $tagLink = SqlRequest('title', 'hashtag', 'id= ', $con,
                                                $tag["hashtagId"]); ?>
                                            <a style="background-color: white; border: solid transparent; color: #2a4ad0;"
                                               href=<?= sprintf("http://395709-readme-12/search.php?request=%s",
                                                '%23'.$tagLink[0]['title']) ?>> <?= '#'.$tagLink[0]['title']; ?> </a>
                                        <?php } ?>
                                    </div>

                                </div>
                                <footer class="post__footer post__indicators">
                                    <div class="post__buttons">
                                        <a class="post__indicator post__indicator--likes button"
                                           href="http://395709-readme-12/like.php?postId=<?= $post['id'] ?>"
                                           title="Лайк">
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
                                            $Comment = SqlRequest('COUNT(content)', 'comments', 'postId =', $con,
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
                                            </svg>
                                            <span><?php echo $Comment[0]['L'] ?></span>
                                            <span class="visually-hidden">количество комментариев</span>
                                        </a>
                                    </div>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php } ?>
