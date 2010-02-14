--
-- MySQL 5.1.42
-- Sun, 14 Feb 2010 16:07:08 +0000
--

CREATE TABLE `forums` (
   `id` int(11) unsigned not null,
   `name` varchar(30) not null,
   `description` varchar(255),
   PRIMARY KEY (`id`),
   UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `forums` (`id`, `name`, `description`) VALUES 
('1', 'Öppet Forum', 'Det öppna forumet som alla är välkomna att skriva i!'),
('2', 'Stängt Forum', 'Ett stängt forum där bara Änglar kan läsa och skriva'),
('3', 'Nyheter', 'Enbart utvalda Änglar kan läsa och skriva här. Varje inlägg hamnar på framsidan.');

CREATE TABLE `forums_roles` (
   `forum_id` int(11) unsigned not null,
   `role_id` int(11) unsigned not null,
   PRIMARY KEY (`forum_id`,`role_id`),
   KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `forums_roles` (`forum_id`, `role_id`) VALUES 
('2', '3'),
('3', '4');

CREATE TABLE `invites` (
   `token` char(40) not null,
   `e-mail` varchar(255) not null,
   `inviter` int(11) unsigned not null,
   `invitee` int(11) unsigned,
   PRIMARY KEY (`token`),
   UNIQUE KEY (`e-mail`),
   KEY `inviter` (`inviter`),
   KEY `invitee` (`invitee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `invites` (`token`, `e-mail`, `inviter`, `invitee`) VALUES 
('1ba8a4f1778c52e8d6e766acfce17cc87203ebd8', 'kim@burgestrand.se', '1', NULL);

CREATE TABLE `posts` (
   `id` int(11) unsigned not null auto_increment,
   `forum_id` int(11) unsigned not null,
   `user_id` int(11) unsigned,
   `author` varchar(50) not null,
   `ip` varbinary(16) not null,
   `message` text not null,
   `created` datetime not null,
   PRIMARY KEY (`id`),
   KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
   `id` int(11) unsigned not null auto_increment,
   `name` varchar(32) not null,
   `description` varchar(255) not null,
   PRIMARY KEY (`id`),
   UNIQUE KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES 
('1', 'login', 'Login privileges, granted after account confirmation'),
('2', 'admin', 'Administrative user, has access to everything.'),
('3', 'ängel', 'Counts as a member of Änglarna Stockholm.'),
('4', 'reporter', 'Is allowed to read and post in the news forum.'),
('5', 'moderator', 'Has the ability to alter forum posts (eg. modify, delete).');

CREATE TABLE `roles_users` (
   `user_id` int(10) unsigned not null,
   `role_id` int(10) unsigned not null,
   PRIMARY KEY (`user_id`,`role_id`),
   KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sessions` (
   `session_id` varchar(24) not null,
   `last_active` int(10) unsigned not null,
   `contents` text not null,
   PRIMARY KEY (`session_id`),
   KEY `last_active` (`last_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user_tokens` (
   `id` int(11) unsigned not null auto_increment,
   `user_id` int(11) unsigned not null,
   `user_agent` varchar(40) not null,
   `token` varchar(32) not null,
   `created` int(10) unsigned not null,
   `expires` int(10) unsigned not null,
   PRIMARY KEY (`id`),
   UNIQUE KEY (`token`),
   KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- [Table `user_tokens` is empty]

CREATE TABLE `users` (
   `id` int(11) unsigned not null auto_increment,
   `e-mail` varchar(255) not null,
   `username` varchar(50) not null,
   `password` text not null,
   `logins` int(10) unsigned not null default '0',
   `last_login` int(10) unsigned,
   PRIMARY KEY (`id`),
   UNIQUE KEY (`username`),
   UNIQUE KEY (`e-mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `forums_roles`
  ADD CONSTRAINT `forums_roles_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `forums_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;