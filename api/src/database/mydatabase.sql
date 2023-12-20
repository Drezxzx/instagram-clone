-- Active: 1702220253652@@127.0.0.1@3306@phpmyadmin

DROP DATABASE IF EXISTS socialred;


CREATE DATABASE IF NOT EXISTS socialred;
USE socialred;


CREATE TABLE IF NOT EXISTS users (
    iduser TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    mail VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(20) NOT NULL,
    nameimg VARCHAR(100)  NULL,
    description VARCHAR(100) NULL
);



CREATE TABLE IF NOT EXISTS publications (
    idpublications TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    iduser TINYINT UNSIGNED NOT NULL,
    description VARCHAR(250) NOT NULL,
    `date` DATE NOT NULL,
    nameimg VARCHAR(250),
    FOREIGN KEY (iduser) REFERENCES users(iduser)
);




CREATE TABLE IF NOT EXISTS coments (
    idcoments TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idpublications TINYINT UNSIGNED,
    iduser TINYINT UNSIGNED,
    `date` DATE NOT NULL,
    coment VARCHAR(100),
    FOREIGN KEY (iduser) REFERENCES users(iduser),
    FOREIGN KEY (idpublications) REFERENCES publications(idpublications)
);
CREATE TABLE IF NOT EXISTS likes (
    idpublications TINYINT UNSIGNED,
    idliker TINYINT UNSIGNED,
    `date` DATE NOT NULL,
    likes TINYINT UNSIGNED,
    PRIMARY KEY (idliker, idpublications),
    FOREIGN KEY (idliker) REFERENCES users(iduser),
    FOREIGN KEY (idpublications) REFERENCES publications(idpublications)
);





CREATE TABLE IF NOT EXISTS USERFRIEND (
    idfollower TINYINT UNSIGNED,
    idfollowed TINYINT UNSIGNED,
    PRIMARY KEY (idfollower,idfollowed),
    FOREIGN KEY (idfollower) REFERENCES users(iduser),
    FOREIGN KEY (idfollowed) REFERENCES users(iduser)
);

