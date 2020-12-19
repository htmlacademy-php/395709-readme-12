<?php
if (isset($_SESSION['userName'])) { ?>
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
                        foreach ($posts as $post):?>
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

                                <?php echo include_template('widgets/postFeed.php', [
                                    'con' => $con,
                                    'id' => $post['id'],
                                    'content' => $post['content'],
                                    'typeID' => $post['typeID'],
                                    'link' => "/post.php?id=".intval($post['id']),
                                    'title' => $post['title'],
                                    'quoteAuthor' => $post['author'],
                                ]); ?>

                                <?php foreach (getTags($con, $post['id']) as $tag) { ?>
                                    <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                                       href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                                <?php } ?>

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
                <?php echo include_template('widgets/sortPosts.php', ['id' => $id]); ?>
            </section>
            <?php echo include_template('widgets/advertising.php'); ?>
        </div>
    </main>

<?php } else {
    echo include_template('authorization.php',
        ['con' => $con, 'errors' => array(), 'avatar' => "../img/userpic-larisa.jpg", 'userName' => 'Новый юзер']);
} ?>

