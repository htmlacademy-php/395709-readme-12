<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= strip_tags($post['title']); ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <article class="feed__post post post-quote">

                <div class="post-details__wrapper post-photo">

                    <div class="post-details__main-block post post--details">
                        <div class="post__main">
                            <blockquote>
                                <p>
                                    <?= strip_tags($post['content']); ?>
                                </p>
                                <cite><?= strip_tags($post['author']); ?></cite>
                            </blockquote>
                        </div>

                        <div class="post__indicators">
                            <?php echo include_template('widgets/likesRepostsComments.php',
                                [
                                    'like' => $post[0]['like'],
                                    'comment' => $post[0]['comment'],
                                    'reposts' => $post[0]['reposts'],
                                    'view' => $post[0]['view'],
                                    'id' => $id,
                                ]); ?>
                        </div>
                        <div class="comments">
                            <?php
                            echo include_template('widgets/newCommentForm.php',
                                ['con' => $con, 'postId' => $post['id']]);
                            echo include_template('widgets/comments.php',
                                ['con' => $con, 'postId' => $post['id'], 'comments' => $post[0]["comments"]]); ?>
                        </div>
                    </div>
                    <?php echo include_template('widgets/postCreateUser.php', [
                        'con' => $con,
                        'id' => $id,
                        'postAuthor' => $authorInfo['postAuthor'],
                        'postsCount' => $authorInfo['postsCount'],
                        'subscribersCount' => $authorInfo['subscribersCount'],
                        'isSubscribed' => $isSubscribed,
                    ]); ?>
                </div>
            </article>
        </section>
    </div>
</main>