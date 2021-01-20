<section class="profile__posts tabs__content tabs__content--active">
    <?php
    foreach ($posts as $post) : ?>
        <h2 class="visually-hidden">Публикации</h2>
        <article class="profile__post post post-photo">
            <?= $post[0]['postFeed']; ?>
            <footer class="post__footer">
                <div style="display:flex; margin-left: 10px">
                    <?php foreach ($post[0]['tags'] as $tag) { ?>
                        <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                           href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                    <?php } ?>
                </div>
                <div class="post__indicators">
                    <?= $post[0]['likesRepostComments']; ?>
                    <time class="post__time" datetime="2019-01-30T23:41"><?= DateFormat(1, $post['creationDate']) ?></time>
                </div>
                <ul class="comments__list">
                    <div style="margin:1%">
                        <?= $post[0]['comments']; ?>
                    </div>
                </ul>
            </footer>
        </article>
    <?php endforeach; ?>
</section>
