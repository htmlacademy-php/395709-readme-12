<?php
if (isset($userName)) { ?>
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
                        <?php foreach ($posts as $post) : ?>
                            <article class="search__post post post-text">
                                <header class="post__header post__author">
                                    <a class="post__author-link" href="#" title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar"
                                                 src="../img/<?= strip_tags($post[0]['avatar']); ?>"
                                                 alt="Аватар пользователя">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= strip_tags($post[0]['login']) ?></b>
                                            <span class="post__time"><?= DateFormat(1, $post['creationDate']) ?></span>
                                        </div>
                                    </a>
                                </header>
                                <div class="post__main">
                                    <?= $post[0]['postFeed']?>
                                    <br>
                                    <div style="display:flex; margin-left: 10px ">
                                        <?php foreach ($post[0]['tags'] as $tag) { ?>
                                            <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                                               href="/search.php?request=%23<?= strip_tags($tag) ?>"><?= strip_tags($tag) ?></a>
                                        <?php } ?>
                                    </div>

                                </div>
                                <footer class="post__footer post__indicators">
                                    <?= $post[0]['likesRepostsComments'] ?>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php } ?>
