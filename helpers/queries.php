<?php
$category_drop_sql = 'DROP TABLE IF EXISTS category';
$category_create_sql = 'CREATE TABLE `category` (
                              `id` INT(11) unsigned AUTO_INCREMENT UNIQUE KEY DEFAULT NULL,
                              `name` VARCHAR(128),
                              `icon` VARCHAR(30),
                              UNIQUE KEY unique_name(name)
)';
$category_insert_sql = 'INSERT INTO `category` (name, icon) VALUES (?,?)';

$city_drop_sql = 'DROP TABLE IF EXISTS city';
$city_create_sql = 'CREATE TABLE `city` (
                          `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                          `city` VARCHAR(128),
                          `long` FLOAT(20, 17),
                          `lat` FLOAT(20, 17)
)';

$city_insert_sql = 'INSERT INTO `city` (city, lat, `long`) VALUES (?,?,?)';

$user_drop_sql = 'DROP TABLE IF EXISTS user';
$user_create_sql = 'CREATE TABLE `user` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `email` VARCHAR(255),
                         `name` VARCHAR(128),
                         `password` VARCHAR(72),
                         `dt_add` DATETIME,
                         `city_id` INT unsigned,
                         UNIQUE KEY unique_email(email),
                         FOREIGN KEY (`city_id`) REFERENCES `city`(`id`)
)';
$user_insert_sql = 'INSERT INTO `user` (
                     email, name, password, dt_add, city_id)
                     VALUES (?,?,?,?,?)';


$task_drop_sql = 'DROP TABLE IF EXISTS task';
$task_create_sql = 'CREATE TABLE `task` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `dt_add` DATETIME,
                         `category_id` INT unsigned NOT NULL,
                         `description` VARCHAR(1500),
                         `expire` DATETIME,
                         `name` VARCHAR(128),
                         `address` VARCHAR (500),
                         `budget` INT(20) unsigned,
                         `lat` FLOAT(20, 17),
                         `long` FLOAT(20, 17),
                         `client_id` INT unsigned NOT NULL,
                         `contractor_id` INT unsigned,
                         FOREIGN KEY (`category_id`) REFERENCES `category`(`id`),
                         FOREIGN KEY (`client_id`) REFERENCES `user`(`id`),
                         FOREIGN KEY (`contractor_id`) REFERENCES `user`(`id`)
)';
$task_insert_sql = 'INSERT INTO `task` (
                     dt_add, category_id, description,
                     expire, name, address, budget, lat,
                     `long`,`client_id`, `contractor_id`)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?)';

$opinion_drop_sql = 'DROP TABLE IF EXISTS opinion';
$opinion_create_sql = 'CREATE TABLE `opinion` (
	                     `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `dt_add` DATETIME,
                         `rate` INT(1),
                         `description` VARCHAR(1500),
                         `client_id` INT unsigned NOT NULL,
                         `task_id` INT unsigned NOT NULL,
                         FOREIGN KEY (`client_id`) REFERENCES `user`(`id`),
                         FOREIGN KEY (`task_id`) REFERENCES `task`(`id`)
)';
$opinion_insert_sql = 'INSERT INTO `opinion` (
                       dt_add, rate, `description`, client_id, task_id)
                       VALUES (?,?,?,?,?)';

$profile_drop_sql = 'DROP TABLE IF EXISTS `profile`';
$profile_create_sql = 'CREATE TABLE `profile` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `address` VARCHAR(100),
                         `bd` DATE,
                         `about` VARCHAR(1000),
                         `phone` VARCHAR(20),
                         `skype` VARCHAR(50),
                         `contractor_id` INT unsigned NOT NULL,
                         FOREIGN KEY (`contractor_id`) REFERENCES `user`(`id`)
)';
$profile_insert_sql = 'INSERT INTO `profile` (
                       address, bd, about, phone, skype, contractor_id)
                       VALUES (?,?,?,?,?,?)';

$reply_drop_sql = 'DROP TABLE IF EXISTS reply';
$reply_create_sql = 'CREATE TABLE `reply` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `dt_add` DATETIME,
                         `rate` INT(1),
                         `description` VARCHAR(1000),
                         `contractor_id` INT unsigned NOT NULL,
                         `task_id` INT unsigned NOT NULL,
                         FOREIGN KEY (`contractor_id`) REFERENCES `user`(`id`),
                         FOREIGN KEY (`task_id`) REFERENCES `task`(`id`)
)';
$reply_insert_sql = 'INSERT INTO `reply` (dt_add, rate, `description`, contractor_id, task_id)
                     VALUES (?,?,?,?,?)';


