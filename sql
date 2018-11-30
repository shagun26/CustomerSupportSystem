CREATE TABLE `anonymoususers` ( 
    `uid` int NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `assignedto` VARCHAR(50) NOT NULL,
    primary key (`uid`)
) Engine = InnoDB;

CREATE TABLE `messages` (
    `mid` int NOT NULL AUTO_INCREMENT,
    `from` VARCHAR(50) NOT NULL,
    `to` VARCHAR(50) NOT NULL,
    `message` VARCHAR(8000) NOT NULL,
    primary key (`mid`)
) Engine = InnoDB;

CREATE TABLE 'numassigned' (
    `username` VARCHAR(50) NOT NULL,
    `number` int NOT NULL
) Engine = InnoDB;

CREATE TABLE `users` (
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(10) NOT NULL
) Engine = InnoDB;