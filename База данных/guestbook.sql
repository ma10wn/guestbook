-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3334
-- Время создания: Июн 24 2024 г., 21:03
-- Версия сервера: 5.6.51
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `guestbook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `username`, `email`, `text`, `ip_address`, `user_agent`, `created_at`) VALUES
(3, 'Иван', 'ivan@example.com', 'Привет, это сообщение от Ивана.', '', '', '2024-06-24 16:06:59'),
(4, 'Мария', 'maria@example.com', 'Здравствуйте! Это сообщение от Марии.', '', '', '2024-06-24 16:06:59'),
(5, 'Петр', 'petr@example.com', 'Добрый день, Петр здесь.', '', '', '2024-06-24 16:06:59'),
(6, 'Елена', 'elena@example.com', 'Приветствую всех! Это Елена.', '', '', '2024-06-24 16:06:59'),
(7, 'Алексей', 'alexey@example.com', 'Доброго времени суток! Алексей пишет.', '', '', '2024-06-24 16:06:59'),
(8, 'Ольга', 'olga@example.com', 'Здравствуйте! Ольга приветствует вас.', '', '', '2024-06-24 16:06:59'),
(9, 'Андрей', 'andrey@example.com', 'Добрый день, Андрей пишет вам.', '', '', '2024-06-24 16:06:59'),
(10, 'Наталья', 'natalia@example.com', 'Привет от Натальи!', '', '', '2024-06-24 16:06:59'),
(11, 'Сергей', 'sergey@example.com', 'Здравствуйте! Сергей здесь.', '', '', '2024-06-24 16:06:59'),
(12, 'Татьяна', 'tatiana@example.com', 'Доброго времени суток! Татьяна приветствует всех.', '', '', '2024-06-24 16:06:59'),
(13, 'Дмитрий', 'dmitry@example.com', 'Приветствую! Это сообщение от Дмитрия.', '', '', '2024-06-24 16:06:59'),
(14, 'Евгения', 'evgenia@example.com', 'Здравствуйте, Евгения пишет вам.', '', '', '2024-06-24 16:06:59');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
