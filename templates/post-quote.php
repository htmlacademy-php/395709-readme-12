<?php
$title = SqlRequest('title', 'posts', 'id = ', $con, $id, "as L");
?>
<h1 class="page__title page__title--publication"><?= $title[0]['L']; ?></h1>
<section class="post-details">

    <h2 class="visually-hidden">Публикация</h2>
    <article class="feed__post post post-quote">

        <div class="post-details__wrapper post-photo">

            <div class="post-details__main-block post post--details">
                <?php
                $content = SqlRequest('content', 'posts', ' id =', $con, $id);
                $author = SqlRequest('author', 'posts', ' id =', $con, $id, "as L");
                ?>
                <div class="post__main">
                    <blockquote>
                        <p>
                            <?= $content[0]['content']; ?>
                        </p>
                        <cite><?= $author[0]['L']; ?></cite>
                    </blockquote>
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

