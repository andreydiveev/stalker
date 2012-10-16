-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 16 2012 г., 12:17
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
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `arms`
--

INSERT INTO `arms` (`id`, `type_id`, `name`, `price`, `damage`, `base_reloading_time`) VALUES
(4, 2, 'Охотничий нож', 100, 10, 2),
(5, 3, 'ТТ (с глушителем)', 1000, 10, 10),
(6, 4, 'АК-47', 100, 10, 30);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `equipment`
--

INSERT INTO `equipment` (`id`, `type_id`, `name`, `price`, `armor`) VALUES
(1, 1, 'Спецназ-75', 500, 1),
(2, 2, 'Омон-13', 450, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nick`, `reg_date`, `last_activity`, `last_beaten`, `last_beaten_hp`, `total_time`, `frag`, `squad`, `expo`, `level`, `current_hp`, `current_area`, `cash`, `alive`) VALUES
(1, 'admin12@ya.ru', 'e10adc3949ba59abbe56e057f20f883e', 'Admin', 1348471986, 1350414253, 1350413671, 90, 0, 0, NULL, 0, 1, 200, 1, 8350, 1),
(2, 'admin@stalker.ru', '4297f44b13955235245b2497399d7a93', 'AAd', 1348472004, 1350414356, 1350029382, -2, 0, 0, NULL, 4000, 1, 200, 1, 95, 1),
(4, 'a@ya.ru', '4297f44b13955235245b2497399d7a93', 'a', 1348840372, 1348840469, NULL, NULL, 0, 0, NULL, 0, 1, 0, 2, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `user_arms`
--

INSERT INTO `user_arms` (`id`, `arms_id`, `user_id`, `armed`, `ext_damage`, `ext_reloading_time_less`, `last_shot`) VALUES
(1, 5, NULL, 0, 0, 0, 0),
(23, 5, NULL, 0, 0, 0, 0),
(24, 5, NULL, 0, 0, 0, 0),
(25, 5, NULL, 0, 0, 0, 0),
(26, 5, NULL, 0, 0, 0, 0),
(27, 5, NULL, 0, 0, 0, 0),
(28, 5, NULL, 0, 0, 0, 0),
(29, 5, NULL, 0, 0, 0, 0),
(30, 5, NULL, 0, 0, 0, 0),
(31, 5, NULL, 0, 0, 0, 0),
(32, 5, NULL, 0, 0, 0, 0),
(33, 5, NULL, 0, 0, 0, 0),
(34, 6, NULL, 0, 0, 0, 0),
(35, 4, NULL, 0, 0, 0, 0),
(36, 4, NULL, 0, 0, 0, 0),
(37, 5, NULL, 0, 0, 0, 0),
(38, 5, 2, 1, 100, 0, 1350413671),
(39, 5, 2, 0, 0, 0, 0),
(40, 5, NULL, 0, 0, 0, 0),
(41, 4, NULL, 0, 0, 0, 0),
(42, 4, NULL, 0, 0, 0, 0),
(43, 4, NULL, 0, 0, 0, 0),
(44, 6, NULL, 0, 0, 0, 0),
(45, 6, NULL, 0, 0, 0, 0),
(46, 6, NULL, 0, 0, 0, 0),
(47, 4, NULL, 0, 0, 0, 0),
(48, 4, 2, 0, 0, 0, 0),
(49, 4, 2, 0, 0, 0, 0),
(50, 4, 2, 1, 0, 0, 1350058531),
(51, 6, NULL, 1, 0, 0, 0),
(52, 6, 2, 1, 0, 0, 1350058527),
(53, 4, 1, 1, 0, 0, 1349947039),
(54, 5, NULL, 0, 0, 0, 0),
(55, 5, 1, 0, 0, 0, 0);

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
(3, 2, 1, 1, 1, 0),
(8, NULL, 2, 2, 0, 0),
(9, 2, 2, 2, 1, 0),
(10, 2, 2, 2, 0, 0),
(11, 1, 2, 2, 0, 0);

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

--
-- Дамп данных таблицы `user_log`
--

INSERT INTO `user_log` (`id`, `user_id`, `message`) VALUES
(35, 1, 'You wounded [AAd] by 110'),
(36, 2, 'You wound [Admin] by 110'),
(37, 1, 'You wounded [AAd] by 10'),
(38, 2, 'You wound [Admin] by 10'),
(39, 1, 'You wounded [AAd] by 10'),
(40, 2, 'You wound [Admin] by 10'),
(41, 1, 'You wounded [AAd] by 110'),
(42, 2, 'You wound [Admin] by 110'),
(43, 1, 'You wounded [AAd] by 10'),
(44, 2, 'You wound [Admin] by 10'),
(45, 1, 'You wounded [AAd] by 10'),
(46, 2, 'You wound [Admin] by 10'),
(47, 1, 'You wounded [AAd] by 10'),
(48, 2, 'You wound [Admin] by 10'),
(49, 1, 'You wounded [AAd] by 10'),
(50, 2, 'You wound [Admin] by 10'),
(51, 1, 'You killed by [AAd]'),
(52, 2, 'You kill [Admin]'),
(53, 1, 'You wounded [AAd] by 110'),
(54, 2, 'You wound [Admin] by 110'),
(55, 1, 'You wounded [AAd] by 10'),
(56, 2, 'You wound [Admin] by 10'),
(57, 1, 'You wounded [AAd] by 10'),
(58, 2, 'You wound [Admin] by 10'),
(59, 1, 'You wounded [AAd] by 10'),
(60, 2, 'You wound [Admin] by 10'),
(61, 1, 'You wounded [AAd] by 10'),
(62, 2, 'You wound [Admin] by 10'),
(63, 1, 'You wounded [AAd] by 10'),
(64, 2, 'You wound [Admin] by 10'),
(65, 1, 'You wounded [AAd] by 10'),
(66, 2, 'You wound [Admin] by 10'),
(67, 1, 'You wounded [AAd] by 10'),
(68, 2, 'You wound [Admin] by 10'),
(69, 1, 'You wounded [AAd] by 110'),
(70, 2, 'You wound [Admin] by 110'),
(71, 1, 'You wounded [AAd] by 110'),
(72, 2, 'You wound [Admin] by 110'),
(73, 1, 'You killed by [AAd]'),
(74, 2, 'You kill [Admin]'),
(75, 2, 'You wounded [AAd] by 109'),
(76, 2, 'You wound [AAd] by 109'),
(77, 2, 'You killed by [AAd]'),
(78, 2, 'You kill [AAd]'),
(79, 2, 'You wound [Mob2] by 110'),
(80, 2, 'You wound [Mob2] by 110'),
(81, 2, 'You wound [Mob1] by 110'),
(82, 2, 'You wound [Mob2] by 110'),
(83, 2, 'You wound [Mob2] by 10'),
(84, 2, 'You wound [Mob2] by 10'),
(85, 2, 'You wound [Mob2] by 10'),
(86, 2, 'You wound [Mob2] by 10'),
(87, 2, 'You wound [Mob2] by 90'),
(88, 2, 'You wound [Mob2] by 10'),
(89, 2, 'You wound [Mob2] by 10'),
(90, 1, 'You wounded [AAd] by 10'),
(91, 2, 'You wound [Admin] by 10'),
(92, 1, 'You wounded [AAd] by 10'),
(93, 2, 'You wound [Admin] by 10'),
(94, 2, 'You wound [Mob2] by 10'),
(95, 2, 'You wound [Mob2] by 10'),
(96, 2, 'You wound [Mob2] by 110'),
(97, 2, 'You wound [Mob2] by -40'),
(98, 2, 'You wound [Mob2] by 10'),
(99, 2, 'You wound [Mob2] by 10'),
(100, 2, 'You wound [Mob2] by 10'),
(101, 2, 'You wound [Mob2] by 10'),
(102, 2, 'You wound [Mob2] by 10'),
(103, 2, 'You wound [Mob2] by 10'),
(104, 2, 'You wound [Mob2] by 10'),
(105, 2, 'You wound [Mob2] by 10'),
(106, 2, 'You wound [Mob2] by 10'),
(107, 2, 'You wound [Mob2] by 10'),
(108, 2, 'You wound [Mob2] by 10'),
(109, 2, 'You wound [Mob2] by 10'),
(110, 2, 'You wound [Mob2] by 10'),
(111, 1, 'You wounded [AAd] by 10'),
(112, 2, 'You wound [Admin] by 10'),
(113, 2, 'You wound [Mob1] by 10'),
(114, 2, 'You wound [Mob1] by 10'),
(115, 2, 'You wound [Mob1] by 10'),
(116, 2, 'You wound [Mob1] by 10'),
(117, 2, 'You wound [Mob1] by 10'),
(118, 2, 'You wound [Mob1] by 10'),
(119, 2, 'You wound [Mob1] by 10'),
(120, 1, 'You wounded [AAd] by 10'),
(121, 2, 'You wound [Admin] by 10'),
(122, 2, 'You wound [Mob1] by 10'),
(123, 2, 'You wound [Mob1] by 10'),
(124, 1, 'You wounded [AAd] by 110'),
(125, 2, 'You wound [Admin] by 110'),
(126, 1, 'You wounded [AAd] by 10'),
(127, 2, 'You wound [Admin] by 10'),
(128, 1, 'You wounded [AAd] by 10'),
(129, 2, 'You wound [Admin] by 10'),
(130, 2, 'You wound [Mob1] by 10'),
(131, 2, 'You wound [Mob1] by 10'),
(132, 2, 'You wound [Mob1] by 10'),
(133, 2, 'You wound [Mob1] by 10'),
(134, 2, 'You wound [Mob1] by 10'),
(135, 2, 'You wound [Mob1] by 10'),
(136, 2, 'You wound [Mob1] by 110'),
(137, 2, 'You wound [Mob1] by 10'),
(138, 2, 'You wound [Mob1] by 10'),
(139, 2, 'You wound [Mob1] by 10'),
(140, 2, 'You wound [Mob1] by 110'),
(141, 2, 'You wound [Mob1] by 10'),
(142, 2, 'You wound [Mob1] by 10'),
(143, 2, 'You wound [Mob1] by 10'),
(144, 2, 'You wound [Mob1] by 10'),
(145, 2, 'You wound [Mob1] by 10'),
(146, 2, 'You wound [Mob1] by 10'),
(147, 2, 'You wound [Mob1] by 10'),
(148, 2, 'You wound [Mob1] by 110'),
(149, 2, 'You wound [Mob1] by 10'),
(150, 2, 'You wound [Mob1] by 10'),
(151, 2, 'You wound [Mob1] by 110'),
(152, 2, 'You wound [Mob1] by 10'),
(153, 2, 'You wound [Mob1] by 10'),
(154, 2, 'You kill [Mob1]'),
(155, 1, 'You wounded [AAd] by 10'),
(156, 2, 'You wound [Admin] by 10'),
(157, 2, 'You wound [Mob1] by 110'),
(158, 2, 'You wound [Mob1] by 10'),
(159, 2, 'You wound [Mob1] by 10'),
(160, 2, 'You wound [Mob1] by 10'),
(161, 2, 'You wound [Mob1] by 10'),
(162, 2, 'You kill [Mob1]'),
(163, 2, 'You wound [Mob1] by 110'),
(164, 2, 'You wound [Mob1] by 10'),
(165, 2, 'You wound [Mob1] by 10'),
(166, 2, 'You wound [Mob1] by 10'),
(167, 2, 'You wound [Mob1] by 10'),
(168, 2, 'You kill [Mob1]'),
(169, 2, 'You wound [Mob1] by 110'),
(170, 2, 'You wound [Mob1] by 10'),
(171, 2, 'You wound [Mob1] by 10'),
(172, 2, 'You wound [Mob1] by 110'),
(173, 2, 'You wound [Mob1] by 10'),
(174, 2, 'You wound [Mob1] by 10'),
(175, 2, 'You wound [Mob1] by 10'),
(176, 2, 'You kill [Mob1]'),
(177, 2, 'You wound [Mob2] by 10'),
(178, 2, 'You wound [Mob1] by 110'),
(179, 2, 'You wound [Mob1] by 10'),
(180, 2, 'You wound [Mob1] by 10'),
(181, 2, 'You wound [Mob1] by 10'),
(182, 2, 'You wound [Mob1] by 10'),
(183, 2, 'You wound [Mob1] by 10'),
(184, 2, 'You kill [Mob1]'),
(185, 2, 'You wound [Mob1] by 110'),
(186, 2, 'You wound [Mob1] by 10'),
(187, 2, 'You wound [Mob1] by 10'),
(188, 2, 'You wound [Mob1] by 10'),
(189, 2, 'You wound [Mob1] by 10'),
(190, 2, 'You wound [Mob1] by 10'),
(191, 2, 'You kill [Mob1]'),
(192, 2, 'You wound [Mob1] by 110'),
(193, 2, 'You wound [Mob1] by 10'),
(194, 2, 'You wound [Mob1] by 10'),
(195, 2, 'You wound [Mob1] by 10'),
(196, 2, 'You kill [Mob1]'),
(197, 2, 'You wound [Mob2] by 110'),
(198, 2, 'You wound [Mob2] by 10'),
(199, 2, 'You wound [Mob2] by 10'),
(200, 2, 'You wound [Mob2] by 10'),
(201, 2, 'You wound [Mob2] by 10'),
(202, 2, 'You wound [Mob2] by 10'),
(203, 2, 'Expo +1000'),
(204, 2, 'You kill [Mob2]'),
(205, 2, 'You wound [Mob1] by 110'),
(206, 2, 'You wound [Mob1] by 10'),
(207, 2, 'You wound [Mob1] by 10'),
(208, 2, 'You wound [Mob1] by 10'),
(209, 2, 'You wound [Mob1] by 10'),
(210, 2, 'You wound [Mob1] by 10'),
(211, 2, 'Expo +1000'),
(212, 2, 'You kill [Mob1]'),
(213, 2, 'You wound [Mob1] by 110'),
(214, 2, 'You wound [Mob1] by 10'),
(215, 2, 'You wound [Mob1] by 10'),
(216, 2, 'You wound [Mob1] by 10'),
(217, 2, 'You wound [Mob1] by 10'),
(218, 2, 'Expo +1000'),
(219, 2, 'You kill [Mob1]'),
(220, 2, 'You wound [Mob2] by 10'),
(221, 2, 'You wound [Mob2] by 10'),
(222, 2, 'You wound [Mob2] by 110'),
(223, 2, 'You wound [Mob2] by 10'),
(224, 2, 'You wound [Mob1] by 10'),
(225, 2, 'You wound [Mob1] by 10'),
(226, 2, 'You wound [Mob1] by 110'),
(227, 2, 'You wound [Mob1] by 10'),
(228, 2, 'You wound [Mob2] by 10'),
(229, 2, 'You wound [Mob1] by 10'),
(230, 2, 'Expo +1000'),
(231, 2, 'You kill [Mob1]'),
(232, 2, 'You wound [Mob2] by 10'),
(233, 2, 'You wound [Mob2] by 10'),
(234, 2, 'You wound [Mob2] by 110'),
(235, 2, 'You wound [Mob2] by 10'),
(236, 2, 'You wound [Mob2] by 10'),
(237, 2, 'You wound [Mob2] by 10'),
(238, 2, 'You wound [Mob2] by 10'),
(239, 2, 'Expo +1000'),
(240, 2, 'You kill [Mob2]'),
(241, 1, 'You wounded [AAd] by 110'),
(242, 2, 'You wound [Admin] by 110');

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
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `from` (`from`),
  KEY `to` (`to`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `user_message`
--

INSERT INTO `user_message` (`id`, `from`, `to`, `text`, `readed`, `date`, `deleted`) VALUES
(1, 1, 2, '1 to 2', 0, 123, 0),
(2, 2, 1, 'efeefe', 0, 1350414194, 0);

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
