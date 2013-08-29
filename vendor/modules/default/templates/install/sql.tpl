CREATE TABLE IF NOT EXISTS `{$ppo->prefixe}_users` (
	
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`login` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
	`password` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `login` (`login`)
	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$ppo->prefixe}_i18n` (
	`id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
	`text` text COLLATE utf8_unicode_ci NOT NULL,
	`lang` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'fr',
	`country` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FR',
	`auto_insert` BOOLEAN NOT NULL DEFAULT FALSE,
	`last_use` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`, `lang`, `country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

