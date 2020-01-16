<?php
$categories_drop_sql = 'DROP TABLE IF EXISTS categories';
$categories_create_sql = 'CREATE TABLE `categories` (
                              `id` INT(11) unsigned AUTO_INCREMENT UNIQUE KEY DEFAULT NULL,
                              `name` VARCHAR(128),
                              `icon` VARCHAR(30),
                              UNIQUE KEY unique_name(name)
)';
$categories_insert_sql = 'INSERT INTO `categories` (name, icon) VALUES (?,?)';

$cities_drop_sql = 'DROP TABLE IF EXISTS cities';
$cities_create_sql = 'CREATE TABLE `cities` (
                          `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                          `city` VARCHAR(128),
                          `long` FLOAT(20, 17),
                          `lat` FLOAT(20, 17)
)';

$cities_insert_sql = 'INSERT INTO `cities` (city, lat, `long`) VALUES (?,?,?)';

$users_drop_sql = 'DROP TABLE IF EXISTS users';
$users_create_sql = 'CREATE TABLE `users` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `name` VARCHAR(128),
                         `password` VARCHAR(72),
                         `email` VARCHAR(255),
                         `dt_add` DATETIME,
                         `city_id` INT unsigned,
                         UNIQUE KEY unique_email(email),
                         FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`)
)';
$users_insert_sql = 'INSERT INTO `users` (
                     name, password, email, dt_add, city_id)
                     VALUES (?,?,?,?,?)';


$tasks_drop_sql = 'DROP TABLE IF EXISTS tasks';
$tasks_create_sql = 'CREATE TABLE `tasks` (
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
                         FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
                         FOREIGN KEY (`client_id`) REFERENCES `users`(`id`),
                         FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`)
)';
$tasks_insert_sql = 'INSERT INTO `tasks` (
                     dt_add, category_id, description,
                     expire, name, address, budget, lat,
                     `long`,`client_id`, `contractor_id`)
                     VALUES (?,?,?,?,?,?,?,?,?,?,?)';
