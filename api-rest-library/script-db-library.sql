CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

CREATE TABLE USERS(
id              int(255) auto_increment not null,
name            varchar(50) NOT NULL,
surname         varchar(100),
email           varchar(255) NOT NULL,
password        varchar(255) NOT NULL,
role            varchar(30) NOT NULL,
avatar          varchar(255),
created_at      datetime DEFAULT CURRENT_TIMESTAMP;,
updated_at      datetime DEFAULT NULL,
remember_token  varchar(255),
CONSTRAINT PK_USERS PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE BOOKS(
id              int(255) auto_increment not null,
user_id         int(255) not null,
title           varchar(255),
author          varchar(255),
description     text not null,
no_comments     int(255) DEFAULT '0',
image           varchar(255),
status          varchar(50),
created_at      datetime DEFAULT CURRENT_TIMESTAMP,
updated_at      datetime DEFAULT NULL,
CONSTRAINT PK_BOOKS PRIMARY KEY(id),
CONSTRAINT FK_BOOK_USER FOREIGN KEY(user_id) REFERENCES USERS(id)
)ENGINE=InnoDb;

CREATE TABLE COMMENTS(
id              int(255) auto_increment not null,
user_id         int(255) not null,
book_id         int(255) not null,
comment         text not null,
created_at      datetime DEFAULT CURRENT_TIMESTAMP,
updated_at      datetime DEFAULT NULL,
CONSTRAINT PK_COMMENTS PRIMARY KEY(id),
CONSTRAINT FK_COMMENT_USER FOREIGN KEY(user_id) REFERENCES USERS(id),
CONSTRAINT FK_COMMENT_BOOK FOREIGN KEY(book_id) REFERENCES BOOKS(id)
)ENGINE=InnoDb;