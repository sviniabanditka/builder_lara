-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 11 2016 г., 11:02
-- Версия сервера: 10.1.0-MariaDB
-- Версия PHP: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `c1_lara5`
--

-- --------------------------------------------------------

--
-- Структура таблицы `persistences`
--

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `persistences`
--

INSERT INTO `persistences` (`id`, `user_id`, `code`, `created_at`, `updated_at`) VALUES
(4, 7, 'Izc8y8PCJMwaRINjkxzIQyepceM77tZ1', '2016-04-01 10:00:00', '2016-04-01 10:00:00'),
(5, 1, 'OmoSjSovii4GxtwAqdHYZi1FBPq5LqMv', '2016-04-01 13:33:58', '2016-04-01 13:33:58'),
(6, 1, 'ngRw67sqGplptItYBWV7JrEb34PekPtj', '2016-04-04 09:09:07', '2016-04-04 09:09:07'),
(7, 1, 'sXoVWg1hVUkrVmYE1XXCpFrDpOOlIegh', '2016-04-05 07:16:05', '2016-04-05 07:16:05'),
(9, 10, 'yIw1evURKLM0xJUDNpwRPIfCAAdFpcdz', '2016-04-06 13:22:15', '2016-04-06 13:22:15'),
(13, 10, '8H4cUAc43GkVUSv0pExQi0vduKvTP65k', '2016-04-06 13:58:03', '2016-04-06 13:58:03'),
(14, 10, 'TSNjxMOVH6TxMYZ37wauWIqBNCNyyt1o', '2016-04-07 12:55:59', '2016-04-07 12:55:59'),
(15, 10, '4GQ975oCWhyFn9fgZgbSfWKEpt01mFgB', '2016-04-08 09:23:34', '2016-04-08 09:23:34'),
(16, 1, 'UQVNXMjRmvPlcHFQBPZOrXFzorZ2SKPL', '2016-04-11 07:47:13', '2016-04-11 07:47:13');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
