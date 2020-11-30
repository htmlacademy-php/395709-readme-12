<?php
$title = SqlRequest('title', 'posts', 'id = ', $con, $id, "as L");
?>
<h1 class="page__title page__title--publication"><?= $title[0]['L']; ?></h1>
<section class="post-details">

    <h2 class="visually-hidden">Публикация</h2>
    <article class="feed__post post post-text ">
        <div class="post-details__wrapper post-photo">
            <div class="post-details__main-block post post--details">
                <div class="post-link__wrapper">
                    <a class="post-link__external" href="<?= $post['content'] ?>" title="Перейти по ссылке">
                        <div class="post-link__icon-wrapper">
                            <img src="../img/logo-vita.jpg" alt="Иконка">
                        </div>
                        <div class="post-link__info">
                            <h3><?= $post['title'] ?></h3>

                            <span><?= $post['content'] ?></span>
                        </div>
                        <svg class="post-link__arrow" width="11" height="16">
                            <use xlink:href="#icon-arrow-right-ad"></use>
                        </svg>
                    </a>
                </div>

                <div class="post__indicators">
                    <?php echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $id]);?>
                </div>

                <?php echo include_template('widgets/comments.php', ['con'=>$con, 'id' => $id, 'postId'=>$post['id']]); ?>

            </div>
            <?php  echo include_template('widgets/postCreateUser.php', ['con'=>$con, 'id' => $id]);?>
        </div>
    </article>
</section>

