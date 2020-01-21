<?php
$categories_drop_sql = 'DROP TABLE IF EXISTS category';
$categories_create_sql = 'CREATE TABLE `category` (
                              `id` INT(11) unsigned AUTO_INCREMENT UNIQUE KEY DEFAULT NULL,
                              `name` VARCHAR(128),
                              `icon` VARCHAR(30),
                              UNIQUE KEY unique_name(name)
)';
$categories_insert_sql = 'INSERT INTO `category` (name, icon) VALUES (?,?)';

$cities_drop_sql = 'DROP TABLE IF EXISTS city';
$cities_create_sql = 'CREATE TABLE `city` (
                          `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                          `city` VARCHAR(128),
                          `long` FLOAT(20, 17),
                          `lat` FLOAT(20, 17)
)';

$cities_insert_sql = 'INSERT INTO `city` (city, lat, `long`) VALUES (?,?,?)';

$users_drop_sql = 'DROP TABLE IF EXISTS user';
$users_create_sql = 'CREATE TABLE `user` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `email` VARCHAR(255),
                         `name` VARCHAR(128),
                         `password` VARCHAR(72),
                         `dt_add` DATETIME,
                         `city_id` INT unsigned,
                         UNIQUE KEY unique_email(email),
                         FOREIGN KEY (`city_id`) REFERENCES `city`(`id`)
)';
$users_insert_sql = 'INSERT INTO `user` (
                     email, name, password, dt_add, city_id)
                     VALUES (?,?,?,?,?)';


$tasks_drop_sql = 'DROP TABLE IF EXISTS task';
$tasks_create_sql = 'CREATE TABLE `task` (
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
$tasks_insert_sql = 'INSERT INTO `task` (
                     dt_add, category_id, description,
                     expire, name, address, budget, lat,
                     `long`,`client_id`, `contractor_id`)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?)';
