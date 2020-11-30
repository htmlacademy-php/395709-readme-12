<?php
$title = SqlRequest('title', 'posts', 'id = ', $con, $id, "as L");
?>
<h1 class="page__title page__title--publication"><?= $title[0]['L']; ?></h1>
<section class="post-details">
    <h2 class="visually-hidden">Публикация</h2>
    <div class="post-details__wrapper post-photo">
        <div class="post-details__main-block post post--details">
            <div class="post-details__image-wrapper post-photo__image-wrapper">
                <img src="../img/<?= $post['content'] ?>" alt="Фото от пользователя" width="760" height="507">
            </div>

            <div class="post__indicators">
                <?php echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $id]);?>
            </div>

            <?php echo include_template('widgets/comments.php', ['con'=>$con, 'id' => $id, 'postId'=>$post['id']]); ?>

        </div>
        <?php  echo include_template('widgets/postCreateUser.php', ['con'=>$con, 'id' => $id]);?>
    </div>
</section>
