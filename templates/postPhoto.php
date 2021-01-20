<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= strip_tags($post['title']); ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-photo">
                <div class="post-details__main-block post post--details">
                    <div class="post-details__image-wrapper post-photo__image-wrapper">
                        <img src="../img/<?= strip_tags($post['content']) ?>" alt="Фото от пользователя" width="760"
                             height="507">
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
        </section>
    </div>
</main>