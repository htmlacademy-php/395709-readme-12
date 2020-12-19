<div class="post__buttons">
    <a class="post__indicator post__indicator--likes button" href="like.php?postId=<?= $id ?>" title="Лайк">
        <svg class="post__indicator-icon" width="20" height="17">
            <use xlink:href="#icon-heart"></use>
        </svg>
        <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
            <use xlink:href="#icon-heart-active"></use>
        </svg>
        <span><?= $like ?></span>
        <span class="visually-hidden">количество лайков</span>
    </a>
    <a class="post__indicator post__indicator--comments button" href="../post.php?id=<?= $id ?>" title="Комментарии">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-comment"></use>
        </svg>
        <span><?php echo $comment ?></span>
        <span class="visually-hidden">количество комментариев</span>
    </a>
    <a class="post__indicator post__indicator--repost button" href="../repost.php?id=<?= $id ?>"
       title="Репост">
        <svg class="post__indicator-icon" width="19" height="17">
            <use xlink:href="#icon-repost"></use>
        </svg>
        <span><?= $reposts ?></span>
        <span class="visually-hidden">количество репостов</span>
    </a>
</div>

<span class="post__view"><?= $view.' просмотров' ?></span>

