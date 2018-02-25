
INSERT INTO `users` (`id`, `user_name`, `secret_key`, `active`, `created`) 
VALUES 
(NULL, 'admin2', '5f4dcc3b5aa765d61d8327deb882cf99', '1', NOW()), 
(NULL, 'admin3', '5f4dcc3b5aa765d61d8327deb882cf99', '1', NOW());

ALTER TABLE `user_profile` ADD `parent_id` INT(6) NULL DEFAULT NULL COMMENT 'track parent user' AFTER `gender`;

INSERT INTO `users` (`id`, `user_name`, `secret_key`, `active`, `created`) 
VALUES 
(NULL, 'user1', '5f4dcc3b5aa765d61d8327deb882cf99', '1', NOW()), 
(NULL, 'user2', '5f4dcc3b5aa765d61d8327deb882cf99', '1', NOW());


INSERT INTO `user_profile` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `gender`, `parent_id`, `email_id`, `user_image`) 
VALUES 
(NULL, '4', 'userone', '', 'traveller', 'F', '1', 'user1@traveller.com', '');

INSERT INTO `user_profile` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `gender`, `parent_id`, `email_id`, `user_image`) VALUES (NULL, '5', 'usertwo', '', 'traveller', 'F', '1', 'user2@traveller.com', '');