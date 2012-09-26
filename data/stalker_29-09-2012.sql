-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 25 2012 г., 23:52
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
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `arms`
--

INSERT INTO `arms` (`id`, `type_id`, `name`, `price`) VALUES
(4, 2, 'Охотничий нож', 100),
(5, 3, 'ТТ (с глушителем)', 1000),
(6, 4, 'АК-47', 100);

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
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `arms_type`
--

INSERT INTO `arms_type` (`id`, `class_id`, `name`) VALUES
(2, 1, 'Ножи'),
(3, 2, 'Пистолеты'),
(4, 3, 'Автоматы');

-- --------------------------------------------------------

--
-- Структура таблицы `equipment`
--

CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `equipment`
--

INSERT INTO `equipment` (`id`, `type_id`, `name`, `price`) VALUES
(1, 1, 'Спецназ-75', 500),
(2, 2, 'Омон-13', 450);

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
(1, 'Шлемы', 0),
(2, 'Бронежелеты', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hp` int(11) NOT NULL,
  `max_expo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `levels`
--

INSERT INTO `levels` (`id`, `hp`, `max_expo`) VALUES
(1, 200, 200),
(2, 230, 400),
(3, 265, 800),
(4, 304, 1600),
(5, 350, 3200),
(6, 402, 6400),
(7, 462, 12800),
(8, 531, 24600),
(9, 610, 51200),
(10, 701, 102400);

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
  `total_time` int(11) NOT NULL DEFAULT '0',
  `frag` int(11) NOT NULL DEFAULT '0',
  `squad` int(11) DEFAULT NULL,
  `expo` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `current_hp` int(11) NOT NULL,
  `current_area` int(11) DEFAULT NULL,
  `cash` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `reg_date`, `last_activity`, `total_time`, `frag`, `squad`, `expo`, `level`, `current_hp`, `current_area`, `cash`) VALUES
(1, 'admin12@ya.ru', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 1348471986, 0, 0, 0, NULL, 0, 0, 0, NULL, 0),
(2, 'admin@stalker.ru', '4297f44b13955235245b2497399d7a93', 'AAd', 1348472004, 1348597473, 0, 0, NULL, 0, 0, 0, 5, 960),
(3, '', '', 'vendor', 0, 0, 0, 0, NULL, 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_arms`
--

CREATE TABLE IF NOT EXISTS `user_arms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arms_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `armed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `arms_id` (`arms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Дамп данных таблицы `user_arms`
--

INSERT INTO `user_arms` (`id`, `arms_id`, `user_id`, `armed`) VALUES
(1, 5, NULL, 0),
(23, 5, NULL, 0),
(24, 5, NULL, 0),
(25, 5, NULL, 0),
(26, 5, NULL, 0),
(27, 5, NULL, 0),
(28, 5, NULL, 0),
(29, 5, NULL, 0),
(30, 5, NULL, 0),
(31, 5, NULL, 0),
(32, 5, NULL, 0),
(33, 5, NULL, 0),
(34, 6, NULL, 0),
(35, 4, NULL, 0),
(36, 4, NULL, 0),
(37, 5, NULL, 0),
(38, 5, 2, 0),
(39, 5, 2, 0),
(40, 5, 2, 0),
(41, 4, 2, 0),
(42, 4, NULL, 0),
(43, 4, 2, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_equipment`
--

CREATE TABLE IF NOT EXISTS `user_equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `slot_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `equipped` (`user_id`,`slot_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `slot_id` (`slot_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- Ограничения внешнего ключа таблицы `user_arms`
--
ALTER TABLE `user_arms`
  ADD CONSTRAINT `user_arms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_arms_ibfk_3` FOREIGN KEY (`arms_id`) REFERENCES `arms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_equipment`
--
ALTER TABLE `user_equipment`
  ADD CONSTRAINT `user_equipment_ibfk_5` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_equipment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_equipment_ibfk_3` FOREIGN KEY (`slot_id`) REFERENCES `user_slot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
