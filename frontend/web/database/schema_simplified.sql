CREATE DATABASE task_force CHARACTER SET utf8;
USE task_force;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
                              `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                              `name` VARCHAR(128),
                              `icon` VARCHAR(30),
                              UNIQUE KEY unique_name(name)
);

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
                          `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                          `city` VARCHAR(128),
                          `long` FLOAT(20, 17),
                          `lat` FLOAT(20, 17)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `name` VARCHAR(128),
                         `password` VARCHAR(72),
                         `email` VARCHAR(255),
                         `dt_add` DATETIME,
                         `city_id` INT unsigned,
                         UNIQUE KEY unique_email(email),
                         FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`)
);

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `dt_add` DATETIME,
                         `description` VARCHAR(1500),
                         `expire` DATETIME,
                         `name` VARCHAR(128),
                         `budget` INT(20) unsigned,
                         `long` FLOAT(20, 17),
                         `lat` FLOAT(20, 17),
                         `category_id` INT unsigned NOT NULL,
                         `client_id` INT unsigned NOT NULL,
                         `contractor_id` INT unsigned,
                         FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
                         FOREIGN KEY (`client_id`) REFERENCES `users`(`id`),
                         FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `opinions`;
CREATE TABLE `opinions` (
                             `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                             `dt_add` DATETIME,
                             `rate` INT(1),
                             `task_id` INT unsigned NOT NULL,
                             `client_id` INT unsigned NOT NULL,
                             FOREIGN KEY (`task_id`) REFERENCES  `tasks`(`id`),
                             FOREIGN KEY (`client_id`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies` (
                           `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                           `dt_add` DATETIME,
                           `rate` INT(1),
                           `description` VARCHAR(1500),
                           `contractor_id` INT unsigned NOT NULL,
                           `task_id` INT unsigned NOT NULL,
                           FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`),
                           FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`)
);
