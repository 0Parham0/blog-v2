CREATE DATABASE IF NOT EXISTS blogProjectDb;

USE blogProjectDb;

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `name_as_author` VARCHAR(100) NOT NULL UNIQUE,
    `email` VARCHAR(80) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `blogs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(80) NOT NULL,
    `description` TEXT NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE IF NOT EXISTS `tags` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS `likes` (
    `user_id` INT UNSIGNED NOT NULL,
    `blog_id` INT UNSIGNED NOT NULL,
    `created_time` TIMESTAMP NOT NULL,
    PRIMARY KEY (`user_id`, `blog_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`blog_id`) REFERENCES `blogs`(`id`)
);

CREATE TABLE IF NOT EXISTS `blog_tags` (
    `tag_id` INT UNSIGNED NOT NULL,
    `blog_id` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`tag_id`, `blog_id`),
    FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`),
    FOREIGN KEY (`blog_id`) REFERENCES `blogs`(`id`)
);