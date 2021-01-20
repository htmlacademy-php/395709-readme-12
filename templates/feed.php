<?php
if (isset($userName)) { ?>
    <main class="page__main page__main--feed">
        <div class="container">
            <h1 class="page__title page__title--feed">Моя лента</h1>
        </div>
        <div class="page__main-wrapper container">
            <section class="feed">
                <h2 class="visually-hidden">Лента</h2>
                <div class="feed__main-wrapper">
                    <div class="feed__wrapper">
                        <?php
                        foreach ($posts as $post) :?>
                            <article class="feed__post post post-photo">
                                <header class="post__header post__author">
                                    <a class="post__author-link"
                                       href="../profileControl.php?UserId=<?= intval($post['authorId']) ?>"
                                       title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar" src="img/<?= strip_tags($post['av']) ?>"
                                                 alt="Аватар пользователя" width="60" height="60">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= strip_tags($post['login']) ?></b>
                                            <span class="post__time"><?= DateFormat(0, $post['creationDate']) ?></span>
                                        </div>
                                    </a>
                                </header>
                                <?= $post[0]['postFeed']; ?>
                                <?php foreach ($post[0]['tags'] as $tag) { ?>
                                    <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                                       href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                                <?php } ?>

                                <footer class="post__footer post__indicators">
                                    <?= $post[0]['likesRepostsComments']; ?>
                                </footer>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?= $sort; ?>
            </section>
            <?=  $advert; ?>
        </div>
    </main>

    <?php
} else {
    echo $authorization;
}

