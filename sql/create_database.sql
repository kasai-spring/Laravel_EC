SET NAMES utf8;
DROP DATABASE IF EXISTS provisoriam;
CREATE DATABASE provisoriam;

USE provisoriam;

DROP TABLE IF EXISTS users;
CREATE TABLE users
(
    id              INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id         VARCHAR(255)    NOT NULL,
    email           VARCHAR(255)    NOT NULL,
    password        VARCHAR(255)    NOT NULL,
    create_date     DATE            NOT NULL,
    last_login_date DATE            NOT NULL,
    admin_flg       TINYINT(1)      NOT NULL DEFAULT 0
);
