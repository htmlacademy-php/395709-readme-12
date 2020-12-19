<section class="profile__likes tabs__content">
    <h2 class="visually-hidden">Лайки</h2>
    <ul class="profile__likes-list">
        <?php foreach ($postsWithLikes as $like) { ?>
            <li class="post-mini post-mini--photo post user">
                <a class="post-mini post-mini--photo post user">
                    <div class="post-mini__user-info user__info">
                        <div class="post-mini__avatar user__avatar">
                            <a class="user__avatar-link" href="#">
                                <img class="post-mini__picture user__picture"
                                     src="../img/<?= strip_tags($like['avatar']) ?>"
                                     alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="post-mini__name-wrapper user__name-wrapper">
                            <a class="post-mini__name user__name" href="#">
                                <span><?= strip_tags($like['login']) ?></span>
                            </a>
                            <div class="post-mini__action">
                                <span class="post-mini__activity user__additional">Лайкнул вашу публикацию</span>
                            </div>
                        </div>
                    </div>
                    <div class="post-mini__preview">
                        <a class="post-mini__link" href="#" title="Перейти на публикацию">
                            <?php if ($like['typeID'] == 3) { ?>
                                <div class="post-mini__image-wrapper">
                                    <img class="post-mini__image" src="../img/rock-small.png"
                                         width="109"
                                         height="109" alt="Превью публикации">
                                </div>
                                <span class="visually-hidden">Фото</span>

                            <?php } elseif ($like['typeID'] == 2) { ?>
                                <span class="visually-hidden">Цитата</span>
                                <svg class="post-mini__preview-icon" width="21" height="20">
                                    <use xlink:href="#icon-filter-quote"></use>
                                </svg>
                            <?php } elseif ($like['typeID'] == 1) { ?>
                                <span class="visually-hidden">Текст</span>
                                <svg class="post-mini__preview-icon" width="20" height="21">
                                    <use xlink:href="#icon-filter-text"></use>
                                </svg>
                            <?php } elseif ($like['typeID'] == 5) { ?>
                                <span class="visually-hidden">Ссылка</span>
                                <svg class="post-mini__preview-icon" width="21" height="18">
                                    <use xlink:href="#icon-filter-link"></use>
                                </svg>
                            <?php } else { ?>
                                <div class="post-mini__image-wrapper">
                                    <img class="post-mini__image" src="../img/coast-small.png"
                                         width="109" height="109" alt="Превью публикации">
                                    <span class="post-mini__play-big">
                                                                <svg class="post-mini__play-big-icon"
                                                                     width="12"
                                                                     height="13">
                                                                  <use xlink:href="#icon-video-play-big"></use>
                                                                </svg>
                                                            </span>
                                </div>
                                <span class="visually-hidden">Видео</span>
                            <?php } ?>
                        </a>
                    </div>
            </li>
            </a>
        <?php } ?>
    </ul>
</section>