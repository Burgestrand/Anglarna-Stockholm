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