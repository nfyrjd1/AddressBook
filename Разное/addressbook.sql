-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 18 2020 г., 12:42
-- Версия сервера: 10.4.14-MariaDB
-- Версия PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `addressbook`
--
CREATE DATABASE IF NOT EXISTS `addressbook` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `addressbook`;

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

CREATE TABLE `contact` (
  `Id_Contact` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Phone` varchar(16) NOT NULL,
  `Address` varchar(80) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Image` varchar(260) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`Id_Contact`, `Name`, `Phone`, `Address`, `Email`, `Birthday`, `Image`) VALUES
(1, 'Танков Алексей Дмитриевич', '+7-983-682-37-12', 'Красноярск, ул. Уличная 118', 'nfyrjd1@gmail.com', '2001-03-27', 'кит.jpg'),
(2, 'Яблочкова Аза Вячеславовна', '+7-829-576-57-67', '', 'sobaka@mail.ru', '2020-10-08', '2firewatch-game-forest-sunset-artwork-moon-sky-kumo-cloud-nig.jpeg'),
(3, 'Овсова Инесса Алексеевна', '+7-696-409-77-50', NULL, NULL, '2020-10-15', '3кем я стал.jpg'),
(4, 'Жвиков Егор Игоревич', '+7-653-580-07-29', NULL, NULL, NULL, '4каничива.jpg'),
(5, 'Чиграков Константин Артемиевич', '+7-771-571-94-05', NULL, NULL, NULL, '5topoboi.com-46444.jpg'),
(6, 'Ясавеева Ираида Николаевна', '+7-564-392-34-58', NULL, NULL, NULL, '68Acv9NlpFw0.jpg'),
(7, 'Иванова Римма Владленовна', '+7-389-969-78-22', NULL, NULL, NULL, NULL),
(8, 'Гурин Эммануил Саввевич', '+7-411-759-39-27', NULL, NULL, '2020-10-07', NULL),
(9, 'Набиуллина Виктория Георгиевна', '+7-030-237-24-82', NULL, NULL, NULL, NULL),
(10, 'Волгин Виктор Несторович', '+7-779-026-44-79', NULL, NULL, NULL, NULL),
(11, 'Яцкевича Таисия Степановна', '+7-739-212-34-53', NULL, NULL, '2020-10-17', '11Безымянный.png'),
(12, 'Яминский Измаил Герасимович', '+7-646-554-54-64', NULL, NULL, NULL, NULL),
(13, 'Картавый Таисия Иосифовна', '+7-787-997-56-75', NULL, NULL, NULL, NULL),
(14, 'Дураничев Артём Эмилевич', '+7-456-544-56-34', NULL, NULL, NULL, NULL),
(15, 'Шабанова Дарья Станиславовна', '+7-676-565-67-57', NULL, NULL, NULL, NULL),
(16, 'Косомова Аза Юлиевна', '+7-567-567-54-35', NULL, NULL, NULL, NULL),
(17, 'Шипулин Рюрик Миронович', '+7-435-645-64-56', NULL, NULL, NULL, NULL),
(18, 'Рунов Богдан Самсонович', '+7-546-456-45-64', NULL, NULL, NULL, NULL),
(19, 'Графова Татьяна Станиславовна', '+7-453-363-46-34', NULL, NULL, NULL, NULL),
(20, 'Тукаева Светлана Ипполитовна', '+7-545-345-64-56', NULL, NULL, NULL, NULL),
(21, 'Ильин Феофан Юриевич', '+7-353-453-45-65', NULL, NULL, NULL, NULL),
(22, 'Шелыгина Алиса Давидовна', '+7-653-436-54-56', NULL, NULL, NULL, NULL),
(23, 'Копылов Феликс Натанович', '+7-456-457-45-45', NULL, NULL, NULL, NULL),
(24, 'Щукин Эрнест Анатолиевич', '+7-985-467-56-57', NULL, NULL, NULL, NULL),
(25, 'Брязгина Пелагея Иосифовна', '+7-464-564-57-22', NULL, NULL, NULL, NULL),
(26, 'Евремович Потап Яковович', '+7-235-434-63-46', NULL, NULL, NULL, NULL),
(27, 'Петрищева Лиана Никитевна', '+7-343-634-64-63', NULL, NULL, NULL, NULL),
(28, 'Шеповалов Архип Данилевич', '+7-546-745-74-45', NULL, NULL, NULL, NULL),
(29, 'Курепина Марианна Антониновна', '+7-457-457-45-74', NULL, NULL, NULL, NULL),
(30, 'Печкина Елизавета Елизаровна', '+7-436-457-54-45', NULL, NULL, NULL, NULL),
(31, 'Ишутин Лука Никифорович', '+7-467-456-45-25', NULL, NULL, NULL, NULL),
(32, 'Русанов Прохор Никифорович', '+7-654-356-54-35', NULL, NULL, NULL, NULL),
(33, 'Крыжов Ираклий Глебович', '+7-235-456-36-34', NULL, NULL, NULL, NULL),
(34, 'Пашин Николай Федотович', '+7-456-745-67-45', NULL, NULL, NULL, NULL),
(35, 'Натарова Лидия Андрияновна', '+7-343-463-46-34', NULL, NULL, NULL, NULL),
(36, 'Низовцева Яна Брониславовна', '+7-636-346-36-32', NULL, NULL, NULL, NULL),
(37, 'Седегов Никифор Игнатиевич', '+7-346-456-56-46', NULL, NULL, NULL, NULL),
(38, 'Миков Всеволод Сигизмундович', '+7-452-152-35-26', NULL, NULL, NULL, NULL),
(39, 'Яклашкина Кристина Давидовна', '+7-423-553-32-52', NULL, NULL, NULL, NULL),
(40, 'Маланова Ариадна Ефимовна', '+7-346-345-34-62', NULL, NULL, NULL, NULL),
(41, 'Эйлера Эмилия Всеволодовна', '+7-345-646-12-12', NULL, NULL, NULL, NULL),
(42, 'Вихорева Валерия Кузьмевна', '+7-234-523-52-35', NULL, NULL, NULL, NULL),
(43, 'Потапова Евдокия Мироновна', '+7-214-235-62-14', NULL, NULL, NULL, NULL),
(44, 'Кемоклидзе Регина Михеевна', '+7-547-454-34-63', NULL, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`Id_Contact`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `contact`
--
ALTER TABLE `contact`
  MODIFY `Id_Contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
