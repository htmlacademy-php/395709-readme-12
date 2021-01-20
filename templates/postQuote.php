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
                            <?= $post[0]['likesRepostsComments']; ?>
                        </div>
                        <div class="comments">
                            <?php echo $post[0]['commentForm'],$post[0]['comments']; ?>
                        </div>
                    </div>
                    <?= $post[0]['postCreator']; ?>
                </div>
            </article>
        </section>
    </div>
</main>