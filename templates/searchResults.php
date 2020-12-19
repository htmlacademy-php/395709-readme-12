<?php
if (isset($_SESSION['userName'])) { ?>
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
                        <?php foreach ($posts as $post): ?>
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
                                    <?php echo include_template('widgets/postFeed.php', [
                                        'con' => $con,
                                        'id' => $post['id'],
                                        'content' => $post['content'],
                                        'typeID' => $post['typeID'],
                                        'link' => '',
                                        'title' => $post['title'],
                                        'quoteAuthor' => $post['author'],
                                    ]); ?>
                                    <br>
                                    <div style="display:flex; margin-left: 10px ">
                                        <?php foreach (getTags($con, $post['id']) as $tag) { ?>
                                            <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                                               href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                                        <?php } ?>
                                    </div>

                                </div>
                                <footer class="post__footer post__indicators">
                                    <?php echo include_template('widgets/likesRepostsComments.php',
                                        [
                                            'like' => $post[0]['like'],
                                            'comment' => $post[0]['comment'],
                                            'reposts' => $post[0]['reposts'],
                                            'view' => $post[0]['view'],
                                            'id' => $post['id'],
                                        ]); ?>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php } ?>
