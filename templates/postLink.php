<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= strip_tags($post['title']); ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <article class="feed__post post post-text ">
                <div class="post-details__wrapper post-photo">
                    <div class="post-details__main-block post post--details">
                        <div class="post-link__wrapper">
                            <a class="post-link__external" href="<?= strip_tags($post['content']) ?>"
                               title="Перейти по ссылке">
                                <div class="post-link__icon-wrapper">
                                    <img src="../img/logo-vita.jpg" alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3><?= strip_tags($post['title']) ?></h3>

                                    <span><?= strip_tags($post['content']) ?></span>
                                </div>
                                <svg class="post-link__arrow" width="11" height="16">
                                    <use xlink:href="#icon-arrow-right-ad"></use>
                                </svg>
                            </a>
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