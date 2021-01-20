<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= strip_tags($post['title']); ?></h1>
<section class="post-details">
    <h2 class="visually-hidden">Публикация</h2>
    <article class="feed__post post post-text ">
        <div class="post-details__wrapper post-photo">
            <div class="post-details__main-block post post--details">
                <div class="post-video__block">
                    <div class="post-video__preview" >
                        <?=embed_youtube_cover($post['content'], 760, 360); ?>
                    </div>
                    <div class="post-video__control">
                        <a class="post-video__play post-video__play--paused button button--video" href = "<?= $post['content'] ?>" type="button"><span class="visually-hidden">Запустить видео</span></a>
                        <div class="post-video__scale-wrapper">
                            <div class="post-video__scale">
                                <div class="post-video__bar">
                                    <div class="post-video__toggle"></div>
                                </div>
                            </div>
                        </div>
                        <button class="post-video__fullscreen post-video__fullscreen--inactive button button--video" type="button"><span class="visually-hidden">Полноэкранный режим</span></button>
                    </div>
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
