CREATE DATABASE Blog
    DEFAULT CHARACTER  SET utf8
    DEFAULT COLLATE  utf8_general_ci;

USE Blog;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registrationDate  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(128) NOT NULL UNIQUE,
  login VARCHAR(128) UNIQUE,
  password CHAR(64),
  avatar VARCHAR(255)
);

CREATE TABLE content_type(
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(128),
  icon_name VARCHAR(128)
);

CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  title VARCHAR(128),
  content VARCHAR(255),
  typeID INT,
  authorId INT,
  image VARCHAR(255),
  video VARCHAR(255),
  link VARCHAR(255),
  views INT,
  FOREIGN KEY (authorId)  REFERENCES users(id),
  FOREIGN KEY (typeId)  REFERENCES content_type(id)
);


CREATE TABLE comments(
  id INT AUTO_INCREMENT PRIMARY KEY,
  creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  content VARCHAR(255),
  authorId INT,
  postId INT,
  FOREIGN KEY (postId)  REFERENCES posts(id),
  FOREIGN KEY (authorId)  REFERENCES users(id)
);

CREATE TABLE likes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  recipientId INT,
  FOREIGN KEY (userId)  REFERENCES users(id),
  FOREIGN KEY (recipientId)  REFERENCES users(id)
);

CREATE TABLE subscription(
  id INT AUTO_INCREMENT PRIMARY KEY,
  authorId INT,
  userId INT,
  FOREIGN KEY (userId)  REFERENCES users(id),
  FOREIGN KEY (authorId)  REFERENCES users(id)
);


CREATE TABLE message(
  id INT AUTO_INCREMENT PRIMARY KEY,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  content VARCHAR(255),
  authorId INT,
  recipientId INT,
  FOREIGN KEY (recipientId)  REFERENCES users(id),
  FOREIGN KEY (authorId)  REFERENCES users(id)
);

CREATE TABLE hashtag(
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255)
);

CREATE TABLE PostHashtag(
  id INT AUTO_INCREMENT PRIMARY KEY,
  userId INT,
  hashtagId INT,
  FOREIGN KEY (userId)  REFERENCES users(id),
  FOREIGN KEY (hashtagId)  REFERENCES hashtag(id)
);



CREATE INDEX u_mail ON users(email);
CREATE INDEX u_login ON users(login);
CREATE INDEX post_title ON posts(title);
CREATE INDEX h_title ON hashtag(title);

