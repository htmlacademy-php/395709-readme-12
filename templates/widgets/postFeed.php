<?php if (intval($typeID) === 2): ?>
    <article class = "post-quote" >
        <header class="post__header">
            <a href="<?= $link; ?>"><h2> <?= strip_tags($title) ?></h2></a>
        </header>
        <div class="post__main post-quote ">
            <blockquote >
                <p >
                    <?= strip_tags($content) ?>
                </p>
                <cite><?=  strip_tags($quoteAuthor) ?></cite>
            </blockquote>
        </div>
    </article>
<?php elseif (intval($typeID) === 1): ?>
    <header class="post__header">
        <a href="<?= $link; ?>"><h2> <?= strip_tags($title) ?></h2></a>
    </header>
    <div class="post__main">
        <p style="margin-left: 10%"><?= text_split(strip_tags($content)) ?></p>

    </div>

<?php elseif (intval($typeID) === 3): ?>
    <div class="post__main">
        <h2><a href="<?= $link; ?>"><?= strip_tags($title) ?></a></h2>
        <div class="post-photo__image-wrapper">
            <img src="img/<?= strip_tags($content) ?>"
                 alt="Фото от пользователя" width="760" height="396">
        </div>
    </div>

<?php elseif (intval($typeID) === 5): ?>
    <header class="post__header">
        <a href="<?= $link; ?>"><h2> <?= strip_tags($title) ?></h2></a>
    </header>
    <div class="post-link__wrapper">
        <a class="post-link__external" href="<?= $link; ?>" title="Перейти по ссылке">
            <div class="post-link__info-wrapper">
                <div class="post-link__icon-wrapper">
                    <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                         alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= strip_tags($title) ?></h3>
                    <span><?= strip_tags($content) ?></span>
                </div>
            </div>

        </a>
    </div>
<?php endif; ?>
