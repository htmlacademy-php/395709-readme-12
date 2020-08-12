<?php 
            $sqlPost = "SELECT title  FROM posts  WHERE id=$id";
            $result = mysqli_query($con, $sqlPost);
            $title= mysqli_fetch_all($result, MYSQLI_ASSOC);
            $title = $title[0];
            require('functions.php');
            ?>
<h1 class="page__title page__title--publication"><?= $title['title'];?></h1>
<section class="post-details" >

    <h2 class="visually-hidden">Публикация</h2>
    <article class="feed__post post post-quote">

    <div class="post-details__wrapper post-photo">
        
    <div class="post-details__main-block post post--details">
    <div class="post__main">
                  <blockquote>
                    <p>
                      Тысячи людей живут без любви, но никто — без воды.
                    </p>
                    <cite>Xью Оден</cite>
                  </blockquote>
                </div>
        <div class="post__indicators">
        <div class="post__buttons">
            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
            <svg class="post__indicator-icon" width="20" height="17">
                <use xlink:href="#icon-heart"></use>
            </svg>
            <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                <use xlink:href="#icon-heart-active"></use>
            </svg>
            <?php 
      
            $ComLike=SqlR('COUNT(userId)', 'likes', 'recipientId =', $con, $id);
            ?>
            
            <span><?= $ComLike['L'] ?></span>
            <span class="visually-hidden">количество лайков</span>
            </a>
            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-comment"></use>
            </svg>
            <?php 
            $Comment=SqlR('COUNT(content)', 'comments', 'postId =', $con, $id);
            ?>
            <span><?php echo $Comment['L'] ?></span>
            <span class="visually-hidden">количество комментариев</span>
            </a>
            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-repost"></use>
            </svg>
            <span>5</span>
            <span class="visually-hidden">количество репостов</span>
            </a>
        </div>
        <?php 
            $view=SqlR('views', 'posts', ' id =', $con, $id);
         ?>
        <span class="post__view"><?= $view['L'].' просмотров' ?></span>
        </div>
        <div class="comments">
        <form class="comments__form form" action="#" method="post">
            <div class="comments__my-avatar">
            <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
            </div>
            <div class="form__input-section form__input-section--error">
            <textarea class="comments__textarea form__textarea form__input" placeholder="Ваш комментарий"></textarea>
            <label class="visually-hidden">Ваш комментарий</label>
            <button class="form__error-button button" type="button">!</button>
            <div class="form__error-text">
                <h3 class="form__error-title">Ошибка валидации</h3>
                <p class="form__error-desc">Это поле обязательно к заполнению</p>
            </div>
            </div>
            <button class="comments__submit button button--green" type="submit">Отправить</button>
        </form>
        <div class="comments__list-wrapper">
            <ul class="comments__list">
            <?php 
            $sqlPost = "SELECT content, login, authorId, avatar   FROM comments c JOIN users u ON c.authorId = u.id WHERE c.postId=$id";
            $result = mysqli_query($con, $sqlPost);
            $CommentInf= mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <?php foreach  ($CommentInf as $inf):?>
            <li class="comments__item user">
                <div class="comments__avatar">
                <a class="user__avatar-link" href="#">
                    <img class="comments__picture" src="img/<?= $inf['avatar']?>" alt="Аватар пользователя">
                </a>
                </div>
                <div class="comments__info">
                <div class="comments__name-wrapper">
                    <a class="comments__user-name" href="#">
                    <span><?= $inf['login'] ?></span>
                    </a>
                    <time class="comments__time" datetime="2019-03-20">1 ч назад</time>
                </div>
                <p class="comments__text">
                <?= $inf['content'] ?>

                </p>
                </div>
            </li>
            <?php endforeach; ?>
          
            </ul>
           
            <a class="comments__more-link" href="#">
            <span>Показать все комментарии</span>
            <sup class="comments__amount">45</sup>
            </a>
        </div>
        </div>
    </div>
    <div class="post-details__user user">
        <div class="post-details__user-info user__info">
        <div class="post-details__avatar user__avatar">
        <a class="post-details__name user__name" href="#">
            <?php
            $sql = "SELECT  login, authorId, u.avatar   FROM posts p JOIN users u ON p.authorId = u.id WHERE p.id = $id";
            $result = mysqli_query($con, $sql);
            $postAuthor = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $postAuthor = $postAuthor[0];
            ?>
            <a class="post-details__avatar-link user__avatar-link" href="#">
            <img class="post-details__picture user__picture" src="img/<?= $postAuthor['avatar']?>" alt="Аватар пользователя">
            </a>
        </div>
        <div class="post-details__name-wrapper user__name-wrapper">
            <span><?= $postAuthor['login'] ?> </span>
            </a>
            <time class="post-details__time user__time" datetime="2014-03-20">5 лет на сайте</time>
        </div>
        </div>
        <div class="post-details__rating user__rating">
        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
            <span class="post-details__rating-amount user__rating-amount">1856</span>
            <span class="post-details__rating-text user__rating-text">подписчиков</span>
        </p>
        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
            <span class="post-details__rating-amount user__rating-amount">556</span>
            <span class="post-details__rating-text user__rating-text">публикаций</span>
        </p>
        </div>
        <div class="post-details__user-buttons user__buttons">
        <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
        <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
        </div>
    </div>
    </div>
</article>
</section>

