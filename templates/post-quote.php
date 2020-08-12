<?php 
require('functions.php');
$title = SqlRequest('title', 'posts', 'id = ', $con, $id, "as L");
?>
<h1 class="page__title page__title--publication"><?= $title[0]['L'];?></h1>
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
      
            $ComLike= SqlRequest('COUNT(userId)', 'likes', 'recipientId =', $con, $id, "as L");
            ?>
            
            <span><?= $ComLike[0]['L'] ?></span>
            <span class="visually-hidden">количество лайков</span>
            </a>
            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
            <svg class="post__indicator-icon" width="19" height="17">
                <use xlink:href="#icon-comment"></use>
            </svg>
            <?php 
            $Comment= SqlRequest('COUNT(content)', 'comments', 'postId =', $con, $id, "as L");
            ?>
            <span><?php echo $Comment[0]['L'] ?></span>
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
            $view= SqlRequest('views', 'posts', ' id =', $con, $id, "as L");
         ?>
        <span class="post__view"><?= $view[0]['L'].' просмотров' ?></span>
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
            $CommentInf = SqlRequest('content, login, authorId, avatar ', ' comments c' ,' c.postId= ',  $con,$id, '', "JOIN users u ON c.authorId = u.id");?>
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
           $postAuthor=SqlRequest('login, authorId, u.avatar', 'posts p', 'p.id =', $con, $id, ' ', 'JOIN  users u ON p.authorId = u.id');
            ?>
            <a class="post-details__avatar-link user__avatar-link" href="#">
            <img class="post-details__picture user__picture" src="img/<?= $postAuthor[0]['avatar']?>" alt="Аватар пользователя">
            </a>
        </div>
        <div class="post-details__name-wrapper user__name-wrapper">
            <span><?= $postAuthor[0]['login'] ?> </span>
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

