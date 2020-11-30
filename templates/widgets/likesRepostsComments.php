<div class="post__buttons">
    <a class="post__indicator post__indicator--likes button"   href="like.php?postId=<?= $id ?>" title="Лайк">
        <svg class="post__indicator-icon" width="20" height="17">
            <use xlink:href="#icon-heart"></use>
        </svg>
        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
            <use xlink:href="#icon-heart-active"></use>
        </svg>
        <?php
        $ComLike = SqlRequest('COUNT(userId)', 'likes', 'recipientId =', $con, $id, "as L");
        ?>
        <span><?= $ComLike[0]['L'] ?></span>
        <span class="visually-hidden">количество лайков</span>
    </a>
    <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-comment"></use>
        </svg>
        <?php
        $Comment = SqlRequest('COUNT(content)', 'comments', 'postId =', $con, $id, "as L");
        ?>
        <span><?php echo $Comment[0]['L'] ?></span>
        <span class="visually-hidden">количество комментариев</span>
    </a>
    <a class="post__indicator post__indicator--repost button" href="../repost.php?id=<?= $id ?>"
       title="Репост">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-repost"></use>
        </svg>
        <?php $reposts = SqlRequest("repostCount", "posts", "id = ", $con, $id) ?>
        <span><?= $reposts[0]['repostCount'] ?></span>
        <span class="visually-hidden">количество репостов</span>
    </a>
</div>
<?php
$view = SqlRequest('views', 'posts', ' id =', $con, $id, "as L");
?>
<span class="post__view"><?= $view[0]['L'].' просмотров' ?></span>

