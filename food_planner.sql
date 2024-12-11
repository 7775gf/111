-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Дек 11 2024 г., 15:54
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `food_planner`
--

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `calories` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `calories`, `price`, `created_at`) VALUES
(1, 'Яблоко', 52, 0.50, '2024-12-10 18:54:08'),
(2, 'Банан', 89, 0.75, '2024-12-10 18:54:08'),
(3, 'Морковь', 41, 0.30, '2024-12-10 18:54:08'),
(4, 'Картофель', 77, 0.40, '2024-12-10 18:54:08'),
(5, 'Курица (филе)', 165, 3.50, '2024-12-10 18:54:08'),
(6, 'Говядина (филе)', 250, 5.00, '2024-12-10 18:54:08'),
(7, 'Свинина (филе)', 242, 4.50, '2024-12-10 18:54:08'),
(8, 'Рыба (семга)', 206, 6.00, '2024-12-10 18:54:08'),
(9, 'Рыба (минтай)', 79, 3.00, '2024-12-10 18:54:08'),
(10, 'Творог (5%)', 120, 2.00, '2024-12-10 18:54:08'),
(11, 'Молоко (3.2%)', 61, 1.00, '2024-12-10 18:54:08'),
(12, 'Кефир (2.5%)', 400, 70.00, '2024-12-10 18:54:08'),
(13, 'Сыр (чеддер)', 402, 4.00, '2024-12-10 18:54:08'),
(14, 'Йогурт (натуральный)', 59, 1.50, '2024-12-10 18:54:08'),
(15, 'Масло сливочное', 717, 2.50, '2024-12-10 18:54:08'),
(16, 'Масло растительное', 884, 2.00, '2024-12-10 18:54:08'),
(17, 'Яйцо куриное', 155, 0.30, '2024-12-10 18:54:08'),
(18, 'Гречка', 343, 1.00, '2024-12-10 18:54:08'),
(19, 'Рис белый', 130, 1.00, '2024-12-10 18:54:08'),
(20, 'Рис коричневый', 111, 1.50, '2024-12-10 18:54:08'),
(21, 'Макароны (паста)', 131, 1.00, '2024-12-10 18:54:08'),
(22, 'Хлеб белый', 265, 0.50, '2024-12-10 18:54:08'),
(23, 'Хлеб ржаной', 245, 0.75, '2024-12-10 18:54:08'),
(24, 'Овсянка', 389, 1.00, '2024-12-10 18:54:08'),
(25, 'Миндаль', 576, 3.00, '2024-12-10 18:54:08'),
(26, 'Арахис', 567, 2.00, '2024-12-10 18:54:08'),
(27, 'Кешью', 553, 4.00, '2024-12-10 18:54:08'),
(28, 'Семечки подсолнечника', 584, 1.50, '2024-12-10 18:54:08'),
(29, 'Шоколад черный (70%)', 546, 2.00, '2024-12-10 18:54:08'),
(30, 'Шоколад молочный', 535, 2.00, '2024-12-10 18:54:08'),
(31, 'Печенье овсяное', 450, 1.00, '2024-12-10 18:54:08'),
(32, 'Печенье сдобное', 480, 2.00, '2024-12-10 18:54:08'),
(33, 'Сахар', 387, 0.50, '2024-12-10 18:54:08'),
(34, 'Мед', 304, 3.00, '2024-12-10 18:54:08'),
(35, 'Соль', 0, 0.10, '2024-12-10 18:54:08'),
(36, 'Перец черный', 251, 0.50, '2024-12-10 18:54:08'),
(37, 'Мука пшеничная', 364, 1.00, '2024-12-10 18:54:08'),
(38, 'Мука кукурузная', 366, 1.50, '2024-12-10 18:54:08'),
(39, 'Мука ржаная', 327, 1.00, '2024-12-10 18:54:08'),
(40, 'Сода пищевая', 0, 0.20, '2024-12-10 18:54:08'),
(41, 'Разрыхлитель', 50, 0.30, '2024-12-10 18:54:08'),
(42, 'Какао-порошок', 220, 2.00, '2024-12-10 18:54:08'),
(43, 'Кофе растворимый', 95, 2.00, '2024-12-10 18:54:08'),
(44, 'Чай черный', 1, 1.00, '2024-12-10 18:54:08'),
(45, 'Чай зеленый', 1, 1.00, '2024-12-10 18:54:08'),
(46, 'Лимон', 29, 0.50, '2024-12-10 18:54:08'),
(47, 'Апельсин', 47, 0.75, '2024-12-10 18:54:08'),
(48, 'Мандарин', 53, 0.60, '2024-12-10 18:54:08'),
(49, 'Киви', 61, 1.00, '2024-12-10 18:54:08'),
(50, 'Базилик свежий', 23, 0.50, '2024-12-10 18:54:08'),
(51, 'Петрушка свежая', 49, 0.50, '2024-12-10 18:54:08'),
(52, 'Укроп свежий', 49, 0.50, '2024-12-10 18:54:08'),
(53, 'Лук репчатый', 40, 0.30, '2024-12-10 18:54:08'),
(54, 'Чеснок', 149, 0.50, '2024-12-10 18:54:08'),
(55, 'Помидор', 18, 0.50, '2024-12-10 18:54:08'),
(56, 'Огурец', 15, 0.30, '2024-12-10 18:54:08'),
(57, 'Перец болгарский (красный)', 26, 1.00, '2024-12-10 18:54:08'),
(58, 'Перец болгарский (желтый)', 27, 1.00, '2024-12-10 18:54:08'),
(59, 'Капуста белокочанная', 25, 0.30, '2024-12-10 18:54:08'),
(60, 'Капуста брокколи', 34, 1.00, '2024-12-10 18:54:08'),
(61, 'Капуста цветная', 28, 0.50, '2024-12-10 18:54:08'),
(62, 'Шпинат', 23, 1.00, '2024-12-10 18:54:08'),
(63, 'Морская капуста', 16, 1.00, '2024-12-10 18:54:08'),
(64, 'Свекла', 43, 0.50, '2024-12-10 18:54:08'),
(65, 'Редис', 16, 0.30, '2024-12-10 18:54:08'),
(66, 'Руккола', 25, 1.00, '2024-12-10 18:54:08'),
(67, 'Авокадо', 160, 2.00, '2024-12-10 18:54:08'),
(68, 'Грибы шампиньоны', 22, 1.00, '2024-12-10 18:54:08'),
(69, 'Грибы вешенки', 22, 1.00, '2024-12-10 18:54:08'),
(70, 'Грибы белые', 27, 2.00, '2024-12-10 18:54:08'),
(71, 'Клубника', 32, 1.00, '2024-12-10 18:54:08'),
(72, 'Малина', 52, 1.00, '2024-12-10 18:54:08'),
(73, 'Черника', 57, 1.00, '2024-12-10 18:54:08'),
(74, 'Ежевика', 43, 1.00, '2024-12-10 18:54:08'),
(75, 'Голубика', 57, 2.00, '2024-12-10 18:54:08'),
(76, 'Вишня', 50, 1.00, '2024-12-10 18:54:08'),
(77, 'Слива', 46, 1.00, '2024-12-10 18:54:08'),
(78, 'Абрикос', 48, 1.00, '2024-12-10 18:54:08'),
(79, 'Персик', 39, 1.00, '2024-12-10 18:54:08'),
(80, 'Груша', 57, 1.00, '2024-12-10 18:54:08'),
(81, 'Смородина черная', 38, 1.00, '2024-12-10 18:54:08'),
(82, 'Смородина красная', 43, 1.00, '2024-12-10 18:54:08'),
(83, 'Смородина белая', 43, 1.00, '2024-12-10 18:54:08'),
(84, 'Крыжовник', 43, 1.00, '2024-12-10 18:54:08'),
(85, 'Арбуз', 30, 1.00, '2024-12-10 18:54:08'),
(86, 'Дыня', 34, 1.00, '2024-12-10 18:54:08'),
(87, 'Ананас', 50, 2.00, '2024-12-10 18:54:08'),
(88, 'Манго', 60, 2.00, '2024-12-10 18:54:08'),
(89, 'Папайя', 43, 2.00, '2024-12-10 18:54:08'),
(90, 'Базилик сушеный', 265, 1.00, '2024-12-10 18:54:08'),
(91, 'Орегано сушеный', 265, 1.00, '2024-12-10 18:54:08'),
(92, 'Тимьян сушеный', 276, 1.00, '2024-12-10 18:54:08'),
(93, 'Розмарин сушеный', 331, 1.00, '2024-12-10 18:54:08'),
(94, 'Имбирь свежий', 80, 1.00, '2024-12-10 18:54:08'),
(95, 'Корица молотая', 247, 1.00, '2024-12-10 18:54:08'),
(96, 'Горчица', 59, 1.00, '2024-12-10 18:54:08'),
(97, 'Уксус яблочный', 21, 1.00, '2024-12-10 18:54:08'),
(98, 'Уксус бальзамический', 78, 2.00, '2024-12-10 18:54:08'),
(99, 'Соевый соус', 53, 1.00, '2024-12-10 18:54:08'),
(100, 'Томатная паста', 82, 1.00, '2024-12-10 18:54:08'),
(101, 'Майонез', 680, 2.00, '2024-12-10 18:54:08'),
(102, 'Кетчуп', 101, 1.00, '2024-12-10 18:54:08'),
(103, 'Сметана', 206, 1.00, '2024-12-10 18:54:08'),
(104, 'Творог обезжиренный', 79, 1.00, '2024-12-10 18:54:08'),
(105, 'Сыр пармезан', 431, 4.00, '2024-12-10 18:54:08'),
(106, 'Сыр гауда', 356, 3.00, '2024-12-10 18:54:08'),
(107, 'Сыр эдам', 357, 3.00, '2024-12-10 18:54:08'),
(108, 'Сыр рокфор', 364, 4.00, '2024-12-10 18:54:08'),
(110, 'Сыр камамбер', 300, 3.00, '2024-12-10 18:54:08'),
(111, 'Сыр фета', 264, 2.00, '2024-12-10 18:54:08'),
(112, 'Сыр бри', 340, 3.00, '2024-12-10 18:54:08');

-- --------------------------------------------------------

--
-- Структура таблицы `planning`
--

CREATE TABLE `planning` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `description`, `ingredients`, `instructions`, `image_url`, `duration`, `created_at`) VALUES
(1, 1, 'Омлет с овощами', 'Простой и вкусный омлет с овощами', 'Яйцо, Молоко, Помидор, Лук, Соль, Перец', '1. Взбейте яйца с молоком. 2. Обжарьте лук и помидоры. 3. Выложите смесь в сковороду и готовьте до готовности.', 'https://example.com/omlet.jpg', 20, '2024-12-10 20:12:31'),
(2, 2, 'Салат Цезарь', 'Классический салат Цезарь', 'Салат, Курица, Хлеб, Соус Цезарь, Пармезан', '1. Нарежьте курицу и подрумяньте. 2. Смешайте салат, курицу и хлеб. 3. Полейте соусом Цезарь и посыпьте пармезаном.', 'https://example.com/caesar.jpg', 15, '2024-12-10 20:12:31'),
(3, NULL, '1', '1', '1,2,3,4,5,6', '1', 'https://avatars.mds.yandex.net/i?id=1445e0e91c65851d13ec5dc9e0df72c5c535f344-10549345-images-thumbs&n=13', 12, '2024-12-10 20:53:45'),
(4, NULL, '2', '2', '7,8,10,11', '1', 'https://avatars.mds.yandex.net/i?id=1445e0e91c65851d13ec5dc9e0df72c5c535f344-10549345-images-thumbs&n=13', 13, '2024-12-10 20:55:48'),
(5, NULL, '2 +', '2 +', '19,18,17,16', '2 +', 'https://avatars.mds.yandex.net/i?id=1445e0e91c65851d13ec5dc9e0df72c5c535f344-10549345-images-thumbs&n=13', 14, '2024-12-10 21:29:03'),
(7, NULL, '2 3 4 5', '2 3 4 5', NULL, '2 3 4 5', 'https://avatars.mds.yandex.net/i?id=1445e0e91c65851d13ec5dc9e0df72c5c535f344-10549345-images-thumbs&n=13', 20, '2024-12-11 13:15:18');

-- --------------------------------------------------------

--
-- Структура таблицы `recipe_ingredients`
--

CREATE TABLE `recipe_ingredients` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `recipe_ingredients`
--

INSERT INTO `recipe_ingredients` (`id`, `recipe_id`, `ingredient_id`, `quantity`) VALUES
(1, 7, 12, 2000.00),
(2, 7, 11, 1500.00),
(3, 7, 10, 3000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `shopping_list`
--

CREATE TABLE `shopping_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ingredient` varchar(255) NOT NULL,
  `calories` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `preferences` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `preferences`, `created_at`) VALUES
(1, '1', 'anton_28282@mail.ru', '$2y$10$YhM3CgoRODSzc4cXMa.9oOEXRfJB2ts/q/4ZZr5WFVP77K1EC9Iry', NULL, '2024-12-10 19:01:26'),
(2, 'John Doe', 'john@example.com', '$2y$10$YhM3CgoRODSzc4cXMa.9oOEXRfJB2ts/q/4ZZr5WFVP77K1EC9Iry', 'Vegetarian', '2024-12-10 20:12:20'),
(3, 'Jane Smith', 'jane@example.com', '$2y$10$YhM3CgoRODSzc4cXMa.9oOEXRfJB2ts/q/4ZZr5WFVP77K1EC9Iry', 'Gluten-free', '2024-12-10 20:12:20');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`);

--
-- Индексы таблицы `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`),
  ADD KEY `idx_name` (`name`);

--
-- Индексы таблицы `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`);

--
-- Индексы таблицы `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Индексы таблицы `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Индексы таблицы `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT для таблицы `planning`
--
ALTER TABLE `planning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `shopping_list`
--
ALTER TABLE `shopping_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);

--
-- Ограничения внешнего ключа таблицы `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);

--
-- Ограничения внешнего ключа таблицы `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `recipe_ingredients`
--
ALTER TABLE `recipe_ingredients`
  ADD CONSTRAINT `recipe_ingredients_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `recipe_ingredients_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);

--
-- Ограничения внешнего ключа таблицы `shopping_list`
--
ALTER TABLE `shopping_list`
  ADD CONSTRAINT `shopping_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
