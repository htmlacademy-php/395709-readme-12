<section class="profile__posts tabs__content tabs__content--active">
    <?php
    foreach ($posts as $post): ?>
        <h2 class="visually-hidden">Публикации</h2>
        <article class="profile__post post post-photo">
            <?php
            echo include_template('widgets/postFeed.php', [
                'con' => $con,
                'id' => intval($post['id']),
                'content' => $post['content'],
                'typeID' => $post['typeID'],
                'link' => '',
                'title' => $post['title'],
                'quoteAuthor' => $post['author'],

            ]); ?>
            <footer class="post__footer">
                <div style="display:flex; margin-left: 10px">
                    <?php foreach (getTags($con, $post['id']) as $tag) { ?>
                        <a style='background-color: white; border: solid transparent; color: #2a4ad0;'
                           href="/search.php?request=%23<?= $tag ?>"><?= $tag ?></a>
                    <?php } ?>
                </div>
                <div class="post__indicators">
                    <?php echo include_template('widgets/likesRepostsComments.php',
                        [
                            'like' => $post[0]['like'],
                            'comment' => $post[0]['comment'],
                            'reposts' => $post[0]['reposts'],
                            'view' => $post[0]['view'],
                            'id' => $post['id'],
                        ]); ?>
                    <time class="post__time" datetime="2019-01-30T23:41"><?= DateFormat(1,
                            $post['creationDate']) ?></time>
                </div>
                <ul class="comments__list">
                    <div style="margin:1%">
                        <?php echo include_template('widgets/comments.php',
                            ['con' => $con, 'postId' => $post['id'], 'comments' => $post[0]["comments"]]); ?>
                    </div>
                </ul>
            </footer>
        </article>
    <?php endforeach; ?>
</section>