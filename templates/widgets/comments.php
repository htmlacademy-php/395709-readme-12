<div class="comments__list-wrapper">
    <ul class="comments__list">
        <?php foreach ($comments as $inf) : ?>
            <li class="comments__item user">
                <div class="comments__avatar">
                    <a class="user__avatar-link" href="#">
                        <img class="comments__picture" src="../img/<?= strip_tags($inf['avatar']) ?>"
                             alt="Аватар пользователя">
                    </a>
                </div>
                <div class="comments__info">
                    <div class="comments__name-wrapper">
                        <a class="comments__user-name" href="#">
                            <span><?= strip_tags($inf['login']) ?></span>
                        </a>
                        <time class="comments__time" datetime="2019-03-20"><?= DateFormat(0, $inf['creationDate']) ?></time>
                    </div>
                    <p class="comments__text">
                        <?= strip_tags($inf['content']) ?>
                    </p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
