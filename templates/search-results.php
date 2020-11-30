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
                            $link = '';
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
                                    <?php echo include_template('widgets/postFeed.php', ['con'=>$con, 'id' => $post['id'], 'content' =>$post['content'], 'typeID' =>$post['typeID'], 'link' => $link, 'title'=>$post['title']]);?>
                                    <br>
                                    <div style="display:flex; margin-left: 10px ">
                                        <?php getTags($con,$post['id']); ?>
                                    </div>

                                </div>
                                <footer class="post__footer post__indicators">
                                    <?php echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $post['id']]);?>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php } ?>
