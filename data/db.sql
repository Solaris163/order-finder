-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Авг 08 2020 г., 20:10
-- Версия сервера: 8.0.21-0ubuntu0.20.04.4
-- Версия PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `local_olkon`
--

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `patronymic` varchar(20) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `name`, `surname`, `patronymic`, `address`, `phone`) VALUES
(1, 'Иван', 'Сидоров', 'Евгеньевич', 'Самара ул. Мичурина д. 14 кв. 46', '+79375555555'),
(2, 'Петр', 'Иванов', 'Сергеевич', 'Самара ул. Ново-Садовая д. 63 кв. 15', '+79373333333'),
(3, 'Юлия', 'Хабарова', 'Александровна', 'Самара ул. Некрасова д. 191 кв. 62', '+79372222222');

-- --------------------------------------------------------

--
-- Структура таблицы `managers`
--

CREATE TABLE `managers` (
  `id` int NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `managers`
--

INSERT INTO `managers` (`id`, `name`) VALUES
(1, 'Менеджер Анатолий'),
(2, 'Менеджер Илья');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `cost` float NOT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `cost`, `comment`) VALUES
(1, 1, 8000, 'первый заказ'),
(2, 2, 6000, 'второй заказ'),
(3, 1, 5000, 'третий заказ'),
(4, 3, 10000, 'четвертый заказ');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_managers`
--

CREATE TABLE `orders_managers` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `manager_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_managers`
--

INSERT INTO `orders_managers` (`id`, `order_id`, `manager_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 1),
(5, 4, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_kind_id` int NOT NULL,
  `sum` float NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_kind_id`, `sum`, `date`) VALUES
(1, 1, 1, 5000, '2020-08-09'),
(2, 2, 2, 3000, '2020-08-04'),
(3, 2, 1, 3000, '2020-08-05'),
(4, 1, 2, 1000, '2020-08-01'),
(5, 4, 2, 10000, '2020-08-04');

-- --------------------------------------------------------

--
-- Структура таблицы `payment_kinds`
--

CREATE TABLE `payment_kinds` (
  `id` int NOT NULL,
  `kind_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payment_kinds`
--

INSERT INTO `payment_kinds` (`id`, `kind_name`) VALUES
(1, 'Наличный'),
(2, 'Безналичный');

-- --------------------------------------------------------

--
-- Структура таблицы `works`
--

CREATE TABLE `works` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `work_kind_id` int NOT NULL,
  `cost` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `works`
--

INSERT INTO `works` (`id`, `order_id`, `work_kind_id`, `cost`) VALUES
(1, 1, 1, 1000),
(2, 1, 2, 4000),
(3, 1, 3, 3000),
(4, 2, 1, 1000),
(5, 2, 2, 3000),
(6, 3, 1, 1000),
(7, 3, 2, 4000),
(8, 4, 1, 1000),
(9, 4, 2, 6000),
(10, 4, 3, 3000);

-- --------------------------------------------------------

--
-- Структура таблицы `work_kinds`
--

CREATE TABLE `work_kinds` (
  `id` int NOT NULL,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `work_kinds`
--

INSERT INTO `work_kinds` (`id`, `title`) VALUES
(1, 'Выезд мастера'),
(2, 'Изготовление окон'),
(3, 'Установка окон');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_managers`
--
ALTER TABLE `orders_managers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payment_kinds`
--
ALTER TABLE `payment_kinds`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `work_kinds`
--
ALTER TABLE `work_kinds`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders_managers`
--
ALTER TABLE `orders_managers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `payment_kinds`
--
ALTER TABLE `payment_kinds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `works`
--
ALTER TABLE `works`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `work_kinds`
--
ALTER TABLE `work_kinds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
