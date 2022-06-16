-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 19 2021 г., 19:14
-- Версия сервера: 5.7.29
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `parking_list`
--
CREATE DATABASE IF NOT EXISTS `parking_list` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `parking_list`;

-- --------------------------------------------------------

--
-- Структура таблицы `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_parking` int(11) NOT NULL,
  `data` date NOT NULL,
  `pr_id` int(11) NOT NULL,
  `str` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rozm` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cars`
--

INSERT INTO `cars` (`id`, `number`, `brand`, `number_parking`, `data`, `pr_id`, `str`, `rozm`) VALUES
(2, 'AH 4035 HX', 'Mercedes-Benz', 189, '2021-04-14', 16, 'Uninsured', b'0'),
(3, 'BE 8180 BB', 'Bentley', 6, '2021-04-14', 16, 'Insured', b'1'),
(4, 'OI 7543 JH', 'Audi', 87, '2022-01-13', 16, 'Uninsured', b'0'),
(5, 'FK 6862 NF', 'Lada', 55, '2021-04-25', 16, 'Insured', b'1'),
(6, 'GY 5413 FH', 'Mercedes-Benz', 77, '2021-03-31', 17, 'Uninsured', b'0'),
(7, 'BX 3332 LH', 'Hyundai', 57, '2014-06-13', 17, 'Insured', b'1'),
(8, 'LK 3760 JP', 'BMW', 1, '2017-10-11', 17, 'Insured', b'1'),
(9, 'AH 3256 BX', 'Mitsubishi', 7, '2021-04-09', 17, 'Uninsured', b'1'),
(10, 'GY 5413 FH', 'Audi', 3, '2021-04-08', 18, 'Insured', b'1'),
(11, 'FL 4569 IU', 'Opel', 78, '2015-01-05', 18, 'Uninsured', b'1'),
(13, 'GY 5413 FH', 'Opel', 77, '2021-04-19', 19, 'Insured', b'0'),
(14, 'FL 4569 IU', 'Audi', 206, '2021-04-19', 19, 'Uninsured', b'0');

-- --------------------------------------------------------

--
-- Структура таблицы `parkings`
--

CREATE TABLE `parkings` (
  `id` int(11) NOT NULL,
  `adress` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `director` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `parkings`
--

INSERT INTO `parkings` (`id`, `adress`, `director`) VALUES
(16, 'вул. Соборна, 44/a', 'Гайсюк А.В.'),
(17, 'вул. Декабристів, 15/а', ' Петрова Т.І.'),
(18, 'пр.Центральний, 296/а', ' Семенова К.В.'),
(19, 'вул. Чигрина, 35', 'Степанова М.Н.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rights` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `passwd`, `rights`) VALUES
(26, 'admin', '123', '111111111'),
(27, 'reader', '111', '100011000'),
(28, 'director', '222', '111011100'),
(29, 'seller', '333', '100110010'),
(30, '', '', '\r\n');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pr_id` (`pr_id`);

--
-- Индексы таблицы `parkings`
--
ALTER TABLE `parkings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ix_username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `parkings`
--
ALTER TABLE `parkings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `fk_pr_id` FOREIGN KEY (`pr_id`) REFERENCES `parkings` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
