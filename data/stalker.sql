-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 18 2012 г., 16:00
-- Версия сервера: 5.5.24
-- Версия PHP: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `stalker`
--

-- --------------------------------------------------------

--
-- Структура таблицы `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `zone_id` (`zone_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `area`
--

INSERT INTO `area` (`id`, `zone_id`, `name`) VALUES
(1, 1, 'район первы'),
(2, 1, 'район второ'),
(3, 2, 'район первый второй зоны'),
(4, 2, 'районй воторй второй хзоны'),
(5, 1, 'третий');

-- --------------------------------------------------------

--
-- Структура таблицы `arms`
--

CREATE TABLE IF NOT EXISTS `arms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `damage` int(11) NOT NULL DEFAULT '10',
  `base_reloading_time` int(11) NOT NULL DEFAULT '2',
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `level` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Дамп данных таблицы `arms`
--

INSERT INTO `arms` (`id`, `type_id`, `name`, `price`, `damage`, `base_reloading_time`, `level`) VALUES
(4, 2, 'Охотничий нож', 100, 10, 2, 1),
(7, 4, 'Обрез', 100, 10, 2, 1),
(8, 4, 'Охотничье ружьё', 100, 10, 2, 1),
(9, 4, 'Чейзер 13', 100, 10, 2, 1),
(10, 4, 'СПАС 14', 100, 10, 2, 1),
(11, 4, 'АКМ-74/2У', 100, 10, 2, 1),
(12, 4, 'Гадюка 5', 100, 10, 2, 1),
(13, 4, 'АКМ-74/2', 100, 10, 2, 1),
(14, 4, 'ИЛ 86', 100, 10, 2, 1),
(15, 4, 'АС-96/2', 100, 10, 2, 1),
(16, 4, 'ТРс-301', 100, 10, 2, 1),
(17, 4, 'СГИ-5к', 100, 10, 2, 1),
(18, 4, 'Гром-С14', 100, 10, 2, 1),
(19, 4, 'ГП-37', 100, 10, 2, 1),
(20, 4, 'СА "Лавина"', 100, 10, 2, 1),
(21, 4, 'ФТ 200М', 100, 10, 2, 1),
(22, 4, 'РП-74', 100, 10, 2, 1),
(23, 4, 'Винтарь-ВС', 100, 10, 2, 1),
(24, 4, 'СВДм-2', 100, 10, 2, 1),
(25, 4, 'СВУмк-2', 100, 10, 2, 1),
(26, 4, 'ЭМ1', 100, 10, 2, 1),
(27, 3, 'ПМм', 100, 10, 2, 1),
(28, 3, 'Фора-12', 100, 10, 2, 1),
(29, 3, 'ХПСС-1м', 100, 10, 2, 1),
(30, 3, 'Марта', 100, 10, 2, 1),
(31, 3, 'Волкер-П9м', 100, 10, 2, 1),
(32, 3, 'УДП Компакт', 100, 10, 2, 1),
(33, 3, 'СИП-т М200', 100, 10, 2, 1),
(34, 3, 'Кора-919', 100, 10, 2, 1),
(35, 3, 'Чёрный ястреб', 100, 10, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `arms_class`
--

CREATE TABLE IF NOT EXISTS `arms_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `arms_class`
--

INSERT INTO `arms_class` (`id`, `name`) VALUES
(1, 'Холодное оружие'),
(2, 'Легкое оружие'),
(3, 'Тяжелое оружие');

-- --------------------------------------------------------

--
-- Структура таблицы `arms_type`
--

CREATE TABLE IF NOT EXISTS `arms_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `single_name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `arms_type`
--

INSERT INTO `arms_type` (`id`, `class_id`, `name`, `single_name`) VALUES
(2, 1, 'Ножи', 'Нож'),
(3, 2, 'Пистолеты', 'Пистолет'),
(4, 3, 'Автоматы', 'Автомат');

-- --------------------------------------------------------

--
-- Структура таблицы `bank_operations`
--

CREATE TABLE IF NOT EXISTS `bank_operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `value` varchar(1024) DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Дамп данных таблицы `bank_operations`
--

INSERT INTO `bank_operations` (`id`, `name`, `user_id`, `time`, `value`, `comment`) VALUES
(2, 'purchase Arms', 2, 1348722064, '6', '100'),
(3, 'sell Arms', 2, 1348722126, '45', NULL),
(4, 'sell Arms', 2, 1348722174, '44', '90'),
(5, 'purchase Arms', 2, 1348722694, '6', '100'),
(6, 'sell Arms', 2, 1348723489, '46', '90'),
(7, 'purchase Arms', 2, 1348726008, '4', '100'),
(8, 'purchase Arms', 2, 1348726010, '4', '100'),
(9, 'purchase Arms', 2, 1348726012, '4', '100'),
(10, 'purchase Arms', 2, 1348726678, '4', '100'),
(11, 'sell Arms', 2, 1348726684, '47', '90'),
(12, 'sell Equipment', 2, 1348726688, '8', NULL),
(13, 'purchase Arms', 2, 1348726695, '6', '100'),
(14, 'purchase Arms', 2, 1348726696, '6', '100'),
(15, 'purchase Equipment', 2, 1348727648, '2', '450'),
(16, 'sell Arms', 2, 1348729728, '51', '90'),
(17, 'purchase Arms', 1, 1348733059, '4', '100');

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `price` int(11) NOT NULL,
  `armor` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `equipment`
--

INSERT INTO `equipment` (`id`, `type_id`, `name`, `price`, `armor`) VALUES
(1, 1, 'Спецназ-75', 500, 1),
(2, 2, 'Омон-13', 450, 1),
(3, 2, 'Кожаная куртка', 100, 1),
(4, 2, 'Бандитская куртка', 100, 1),
(5, 2, 'Бронежилет ЧН-1', 100, 1),
(6, 2, 'Комб. «Заря»', 100, 1),
(7, 2, 'Бронежилет ЧН-2', 100, 1),
(8, 2, 'Комб. «Ветер свободы»', 100, 1),
(9, 2, 'ПС5-М «Унив. защ.»', 100, 1),
(10, 2, 'Бронекостюм «Берилл-5М»', 100, 1),
(11, 2, 'Бронежилет ЧН-3а', 100, 1),
(12, 2, 'Комб «Страж свободы»', 100, 1),
(13, 2, 'Комб. «СЕВА»', 100, 1),
(14, 2, 'ПСЗ-9д «Броня Долга»', 100, 1),
(15, 2, 'Экзоскелет «Свобода»', 100, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `equipment_type`
--

CREATE TABLE IF NOT EXISTS `equipment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `slot_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `equipment_type`
--

INSERT INTO `equipment_type` (`id`, `name`, `slot_id`) VALUES
(1, 'Шлемы', 1),
(2, 'Бронежелеты', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `forum`
--

CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_message`
--

CREATE TABLE IF NOT EXISTS `forum_message` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL DEFAULT '0',
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_section`
--

CREATE TABLE IF NOT EXISTS `forum_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  KEY `id` (`id`),
  KEY `parent` (`parent`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_topic`
--

CREATE TABLE IF NOT EXISTS `forum_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hp` int(11) NOT NULL,
  `max_expo` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `levels`
--

INSERT INTO `levels` (`id`, `hp`, `max_expo`, `level`) VALUES
(1, 200, 200, 1),
(2, 230, 400, 2),
(3, 265, 800, 3),
(4, 304, 1600, 4),
(5, 350, 3200, 5),
(6, 402, 6400, 6),
(7, 462, 12800, 7),
(8, 531, 24600, 8),
(9, 610, 51200, 9),
(10, 701, 102400, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `mob`
--

CREATE TABLE IF NOT EXISTS `mob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `current_hp` int(11) NOT NULL DEFAULT '0',
  `last_beaten_time` int(11) NOT NULL DEFAULT '0',
  `last_beaten_hp` int(11) NOT NULL,
  `last_died_time` int(11) NOT NULL DEFAULT '0',
  `area_id` int(11) NOT NULL,
  `alive` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `area_id` (`area_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `mob`
--

INSERT INTO `mob` (`id`, `type_id`, `name`, `current_hp`, `last_beaten_time`, `last_beaten_hp`, `last_died_time`, `area_id`, `alive`) VALUES
(1, 1, 'Mob1', 200, 1350058509, -52, 1350058509, 1, 1),
(2, 1, 'Mob2', 200, 1350058533, -74, 1350058533, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `mob_class`
--

CREATE TABLE IF NOT EXISTS `mob_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `mob_class`
--

INSERT INTO `mob_class` (`id`, `name`) VALUES
(1, 'Agressive');

-- --------------------------------------------------------

--
-- Структура таблицы `mob_type`
--

CREATE TABLE IF NOT EXISTS `mob_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `level` int(11) NOT NULL,
  `profession_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `profession_id` (`profession_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `mob_type`
--

INSERT INTO `mob_type` (`id`, `name`, `level`, `profession_id`, `class_id`) VALUES
(1, 'First agr. mob', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `profession`
--

CREATE TABLE IF NOT EXISTS `profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `profession`
--

INSERT INTO `profession` (`id`, `name`) VALUES
(1, 'Warriror');

-- --------------------------------------------------------

--
-- Структура таблицы `profession_x_skill`
--

CREATE TABLE IF NOT EXISTS `profession_x_skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profession` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `profession` (`profession`),
  KEY `skill` (`skill`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1348336760),
('m120922_143533_create_table_user', 1348470492),
('m120924_052828_create_table_arms_type', 1348470492),
('m120924_053500_create_table_arms', 1348470492),
('m120924_054601_create_table_user_arms', 1348470492),
('m120924_055116_create_table_equipment', 1348470492),
('m120924_055245_create_table_user_equipment', 1348470492),
('m120924_055601_create_table_zone', 1348470492),
('m120924_055733_create_table_area', 1348470492),
('m120924_060750_create_table_levels', 1348470492),
('m120924_162052_alter_table_user', 1348471979);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `last_beaten` int(11) DEFAULT '0',
  `last_beaten_hp` int(11) DEFAULT NULL,
  `total_time` int(11) NOT NULL DEFAULT '0',
  `frag` int(11) NOT NULL DEFAULT '0',
  `squad` int(11) DEFAULT NULL,
  `expo` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '1',
  `current_hp` int(11) unsigned NOT NULL,
  `current_area` int(11) DEFAULT NULL,
  `cash` int(11) NOT NULL DEFAULT '0',
  `alive` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `reg_date`, `last_activity`, `last_beaten`, `last_beaten_hp`, `total_time`, `frag`, `squad`, `expo`, `level`, `current_hp`, `current_area`, `cash`, `alive`) VALUES
(5, 'admin@stalker.local', '4297f44b13955235245b2497399d7a93', 'Admin', 1350592361, 1350597565, 0, NULL, 0, 0, NULL, 0, 1, 200, NULL, 0, 1),
(6, 'moderator@stalker.local', '4297f44b13955235245b2497399d7a93', 'Moderator', 1350592952, 1350601229, 0, NULL, 0, 0, NULL, 0, 1, 200, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_arms`
--

CREATE TABLE IF NOT EXISTS `user_arms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arms_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `armed` int(11) NOT NULL DEFAULT '0',
  `ext_damage` int(11) NOT NULL DEFAULT '0',
  `ext_reloading_time_less` int(11) NOT NULL DEFAULT '0',
  `last_shot` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `arms_id` (`arms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Дамп данных таблицы `user_arms`
--

INSERT INTO `user_arms` (`id`, `arms_id`, `user_id`, `armed`, `ext_damage`, `ext_reloading_time_less`, `last_shot`) VALUES
(35, 4, NULL, 0, 0, 0, 0),
(36, 4, NULL, 0, 0, 0, 0),
(41, 4, NULL, 0, 0, 0, 0),
(42, 4, NULL, 0, 0, 0, 0),
(43, 4, NULL, 0, 0, 0, 0),
(47, 4, NULL, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_equipment`
--

CREATE TABLE IF NOT EXISTS `user_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `slot_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `equipped` tinyint(1) NOT NULL DEFAULT '0',
  `ext_armor` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `slot_id` (`slot_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `user_equipment`
--

INSERT INTO `user_equipment` (`id`, `user_id`, `slot_id`, `equipment_id`, `equipped`, `ext_armor`) VALUES
(2, NULL, 1, 1, 0, 0),
(8, NULL, 2, 2, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_log`
--

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=243 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_message`
--

CREATE TABLE IF NOT EXISTS `user_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `text` text NOT NULL,
  `readed` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `deleted_by_sender` int(11) NOT NULL DEFAULT '0',
  `deleted_by_taker` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `to` (`to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `user_message`
--

INSERT INTO `user_message` (`id`, `from`, `to`, `text`, `readed`, `date`, `deleted_by_sender`, `deleted_by_taker`) VALUES
(12, 5, 6, 'admin to moder', 1, 1350597578, 0, 0),
(13, 5, 6, 'to moder again', 1, 1350598108, 0, 0),
(14, 6, 5, 're:2moder\r\n\r\ntoAdmin from moder', 1, 1350598140, 0, 0),
(15, 5, 6, 'wefwe', 1, 1350598157, 1, 0),
(21, 6, 5, 'from Moder 2 Admin - destined for deletion by sender ', 1, 1350599193, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_slot`
--

CREATE TABLE IF NOT EXISTS `user_slot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user_slot`
--

INSERT INTO `user_slot` (`id`, `name`) VALUES
(1, 'Голова'),
(2, 'Торс'),
(3, 'Руки'),
(4, 'Ноги');

-- --------------------------------------------------------

--
-- Структура таблицы `zone`
--

CREATE TABLE IF NOT EXISTS `zone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `min_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `zone`
--

INSERT INTO `zone` (`id`, `name`, `min_level`) VALUES
(1, 'Первая зона', 1),
(2, 'Вторая зона', 5);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `area`
--
ALTER TABLE `area`
  ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `arms`
--
ALTER TABLE `arms`
  ADD CONSTRAINT `arms_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `arms_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `arms_type`
--
ALTER TABLE `arms_type`
  ADD CONSTRAINT `arms_type_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `arms_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `equipment_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forum_message`
--
ALTER TABLE `forum_message`
  ADD CONSTRAINT `forum_message_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `forum_topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forum_section`
--
ALTER TABLE `forum_section`
  ADD CONSTRAINT `forum_section_ibfk_2` FOREIGN KEY (`forum_id`) REFERENCES `forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `forum_section_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `forum_section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD CONSTRAINT `forum_topic_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `forum_section` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mob`
--
ALTER TABLE `mob`
  ADD CONSTRAINT `mob_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `mob_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mob_ibfk_2` FOREIGN KEY (`area_id`) REFERENCES `area` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `mob_type`
--
ALTER TABLE `mob_type`
  ADD CONSTRAINT `mob_type_ibfk_1` FOREIGN KEY (`level`) REFERENCES `levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mob_type_ibfk_2` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mob_type_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `mob_class` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `profession_x_skill`
--
ALTER TABLE `profession_x_skill`
  ADD CONSTRAINT `profession_x_skill_ibfk_1` FOREIGN KEY (`profession`) REFERENCES `profession` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profession_x_skill_ibfk_2` FOREIGN KEY (`skill`) REFERENCES `skill` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_arms`
--
ALTER TABLE `user_arms`
  ADD CONSTRAINT `user_arms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_arms_ibfk_3` FOREIGN KEY (`arms_id`) REFERENCES `arms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_equipment`
--
ALTER TABLE `user_equipment`
  ADD CONSTRAINT `user_equipment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_equipment_ibfk_3` FOREIGN KEY (`slot_id`) REFERENCES `user_slot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_equipment_ibfk_5` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_log`
--
ALTER TABLE `user_log`
  ADD CONSTRAINT `user_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_message`
--
ALTER TABLE `user_message`
  ADD CONSTRAINT `user_message_ibfk_1` FOREIGN KEY (`from`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_message_ibfk_2` FOREIGN KEY (`to`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
