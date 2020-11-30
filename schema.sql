CREATE DATABASE Blog
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE Blog;

CREATE TABLE users
(
    id               INT AUTO_INCREMENT PRIMARY KEY,
    registrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email            VARCHAR(128) NOT NULL UNIQUE,
    login            VARCHAR(128) UNIQUE,
    password         CHAR(64)     NOT NULL,
    avatar           VARCHAR(255)
);

CREATE TABLE content_type
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    title     VARCHAR(128),
    icon_name VARCHAR(128)
);

CREATE TABLE posts
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title        VARCHAR(128),
    content      VARCHAR(255),
    typeID       INT NOT NULL,
    authorId     INT NOT NULL,
    image        VARCHAR(255),
    video        VARCHAR(255),
    link         VARCHAR(255),
    views        INT,
    avatar       VARCHAR(128),
    author       VARCHAR(128),
    repostCount  VARCHAR(128),
    FOREIGN KEY (authorId) REFERENCES users (id),
    FOREIGN KEY (typeId) REFERENCES content_type (id)
);


CREATE TABLE comments
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content      VARCHAR(255),
    authorId     INT NOT NULL,
    postId       INT NOT NULL,
    FOREIGN KEY (postId) REFERENCES posts (id),
    FOREIGN KEY (authorId) REFERENCES users (id)
);

CREATE TABLE likes
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    userId      INT NOT NULL,
    recipientId INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES users (id),
    FOREIGN KEY (recipientId) REFERENCES posts (id)
);

CREATE TABLE subscription
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    authorId INT NOT NULL,
    userId   INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES users (id),
    FOREIGN KEY (authorId) REFERENCES users (id)
);


CREATE TABLE message
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    date        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content     VARCHAR(255),
    authorId    INT NOT NULL,
    recipientId INT NOT NULL,
    FOREIGN KEY (recipientId) REFERENCES users (id),
    FOREIGN KEY (authorId) REFERENCES users (id)
);

CREATE TABLE hashtag
(
    id    INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255)
);

CREATE TABLE PostHashtag
(
    id        INT AUTO_INCREMENT PRIMARY KEY,
    userId    INT NOT NULL,
    hashtagId INT NOT NULL,
    postId    INT NOT NULL,
    FOREIGN KEY (userId) REFERENCES users (id),
    FOREIGN KEY (hashtagId) REFERENCES hashtag (id),
    FOREIGN KEY (postId) REFERENCES posts (id)
);



CREATE INDEX u_mail ON users (email);
CREATE INDEX u_login ON users (login);
CREATE INDEX post_title ON posts (title);
CREATE INDEX h_title ON hashtag (title);
CREATE FULLTEXT INDEX post_search ON posts (title, content);
CREATE FULLTEXT INDEX Tag_search ON hashtag (title)

