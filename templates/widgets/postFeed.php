<?php if ($typeID == 2): ?>
    <blockquote>
        <p>
            <?= htmlspecialchars($content) ?>
        </p>
        <cite>Неизвестный Автор</cite>
    </blockquote>

<?php elseif ($typeID == 1): ?>
    <div class="post__main">
        <p style="margin-left: 10%"><?= text_split(htmlspecialchars($content)) ?></p>

    </div>

<?php elseif ($typeID == 3): ?>
    <div class="post__main">
        <h2><a href="<?= $link; ?>">Наконец, обработала фотки!</a></h2>
        <div class="post-photo__image-wrapper">
            <img src="img/<?= htmlspecialchars($content) ?>"
                 alt="Фото от пользователя" width="760" height="396">
        </div>
    </div>

<?php elseif ($typeID == 5): ?>
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= $link; ?>" title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                         alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= $title ?></h3>
                    <span><?= htmlspecialchars($content) ?></span>
                </div>
            </div>

        </a>
    </div>
<?php endif; ?>
