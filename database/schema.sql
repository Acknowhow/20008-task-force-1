CREATE DATABASE task_force CHARACTER SET utf8;
USE task_force;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
                              `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                              `name` VARCHAR(128),
                              UNIQUE KEY unique_name(name)
);

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
                          `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                          `name` VARCHAR(128),
                          `longitude` FLOAT(20, 17),
                          `latitude` FLOAT(20, 17)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `name` VARCHAR(128),
                         `description` VARCHAR(1500),
                         `birthdate` DATE,
                         `password` VARCHAR(72),
                         `email` VARCHAR(255),
                         `phone` INT(11),
                         `skype` VARCHAR(64),
                         `tasks_failed` VARCHAR (5),
                         `city_id` INT unsigned,
                         user_categories json,
                         user_notifications json,
                         UNIQUE KEY unique_email(email),
                         FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`)
);

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
                         `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                         `task_name` VARCHAR(128),
                         `task_paths` json,
                         `task_budget` INT(20) unsigned,
                         `task_description` VARCHAR(1500),
                         `task_status` VARCHAR(20),
                         `date_add` DATETIME,
                         `date_end` DATETIME,
                         `category_id` INT unsigned NOT NULL,
                         `city_id` INT unsigned,
                         `client_id` INT unsigned NOT NULL,
                         `contractor_id` INT unsigned,
                         FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`),
                         FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`),
                         FOREIGN KEY (`client_id`) REFERENCES `users`(`id`),
                         FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
                             `id`INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                             `is_failed` TINYINT(1),
                             `task_rating` FLOAT (3,1),
                             `task_id` INT unsigned NOT NULL,
                             `client_id` INT unsigned NOT NULL,
                             `contractor_id` INT unsigned NOT NULL,
                             FOREIGN KEY (`client_id`) REFERENCES `users`(`id`),
                             FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`)
);

DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies` (
                           `id` INT(11) unsigned AUTO_INCREMENT NOT NULL PRIMARY KEY,
                           `date_add` DATETIME,
                           `description` VARCHAR(1500),
                           `task_price` INT(20) unsigned,
                           `contractor_id` INT unsigned NOT NULL,
                           `task_id` INT unsigned NOT NULL,
                           FOREIGN KEY (`contractor_id`) REFERENCES `users`(`id`),
                           FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`)
);
