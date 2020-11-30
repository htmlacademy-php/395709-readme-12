<?php
if (isset($_SESSION['userName'])):?>
    <main class="page__main page__main--feed">
        <div class="container">
            <h1 class="page__title page__title--feed">Моя лента</h1>
        </div>
        <div class="page__main-wrapper container">
            <section class="feed">
                <h2 class="visually-hidden">Лента</h2>
                <div class="feed__main-wrapper">
                    <div class="feed__wrapper">

                        <?php $index = 0;
                        foreach ($posts as $post):
                            $params['id'] = $post['id'];
                            $query = http_build_query($params);
                            $link = "/"."post.php"."?".$query;

                            ?>
                            <article class="feed__post post post-photo">
                                <header class="post__header post__author">
                                    <a class="post__author-link"
                                       href="http://395709-readme-12/profileControl.php?UserId=<?= $post['authorId'] ?>"
                                       title="Автор">
                                        <div class="post__avatar-wrapper">
                                            <img class="post__author-avatar" src="img/<?= $post['av'] ?>"
                                                 alt="Аватар пользователя" width="60" height="60">
                                        </div>
                                        <div class="post__info">
                                            <b class="post__author-name"><?= $post['login'] ?></b>
                                            <span class="post__time"><?= DateFormat(0, $post['creationDate']) ?></span>
                                        </div>
                                    </a>
                                </header>

                                <?php echo include_template('widgets/postFeed.php', ['con'=>$con, 'id' => $post['id'], 'content' =>$post['content'], 'typeID' =>$post['typeID'], 'link' => $link, 'title'=>$post['title']]);?>


                                <?php getTags($con,$post['id']); ?>

                                <footer class="post__footer post__indicators" >
                                     <?php   echo include_template('widgets/likesRepostsComments.php', ['con'=>$con, 'id' => $post['id']]); ?>
                                </footer>
                            </article>
                        <? endforeach; ?>
                    </div>
                </div>
                <?php   echo include_template('widgets/SortPosts.php', ['con'=>$con, 'id' => $id]); ?>
            </section>
            <?php   echo include_template('widgets/advertising.php', ['con'=>$con, 'id' => isset($post['id']) ? $post['id'] : 0  ]); ?>

        </div>
    </main>
    </body>
    </html>

<?php else:
    header("Location:http://395709-readme-12/");
endif; ?>

