Use blog;
INSERT INTO users (login, email, password,avatar)
VALUES ('Лариса', 'lar@.gmail.com', '123', 'userpic-larisa.jpg');
INSERT INTO users (login, email, password,avatar)
VALUES ('Владик', 'vlad@gmail.com', '124', 'userpic-mark.jpg');
INSERT INTO users (login, email, password,avatar)
VALUES ('Виктор', 'Vitek@gmail.com', '125', 'userpic-petro.jpg');
INSERT INTO content_type(title, icon_name)
VALUES ('Текст', 'post-text');
INSERT INTO content_type(title, icon_name)
VALUES ('Цитата', 'post-quote');
INSERT INTO content_type(title, icon_name)
VALUES ('Картинка', 'post-photo');
INSERT INTO content_type(title, icon_name)
VALUES ('Видео', 'post-video');
INSERT INTO content_type(title, icon_name)
VALUES ('Ссылка', 'post-link');
INSERT INTO posts (authorId, typeID, title, content, avatar)
VALUES (1, 2, 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'userpic-larisa-small.jpg');
INSERT INTO posts (authorId, typeID, title, content, avatar)
VALUES (2, 1, 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала! ', 'userpic.jpg');
INSERT INTO posts (authorId, typeID, title, content, avatar)
VALUES (3, 3, 'Наконец, обработал фотки!', 'rock-medium.jpg', 'userpic-mark.jpg');
INSERT INTO posts (authorId, typeID, title, content, avatar)
VALUES (1, 3, 'Моя мечта', 'coast-medium.jpg', 'userpic-larisa-small.jpg');
INSERT INTO posts (authorId, typeID, title, content, avatar)
VALUES (2, 5, 'Лучшие курсы', 'www.htmlacademy.ru', 'userpic.jpg');


INSERT INTO comments (authorId, postId, content)
VALUES (2, 3, 'Классные фотки)');
INSERT INTO comments (authorId, postId, content)
VALUES (1, 2, 'Он будет не очень.');
INSERT INTO comments (authorId, postId, content)
VALUES (1, 2, 'Я тоже!');

-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента
SELECT p.title, login, conT.title
FROM posts p
         JOIN users u ON p.authorId = u.id
         JOIN content_type conT ON typeID = conT.id
ORDER BY views DESC;

-- получить список постов для конкретного пользователя;
SELECT p.title
FROM posts p
WHERE authorId = 1;

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя;
SELECT content, login
FROM comments c
         JOIN users u ON u.id = c.authorId
WHERE postId = 2;

-- добавить лайк к посту;
INSERT INTO likes (userId, recipientId)
VALUES (1, 2);

-- подписаться на пользователя.
INSERT INTO subscription (userId, authorId)
VALUES (3, 2);



UPDATE posts
SET views =100
WHERE id > 0;