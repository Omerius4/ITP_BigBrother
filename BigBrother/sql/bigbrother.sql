-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Jun 2025 um 04:35
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bigbrother`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `calendar_event_master`
--

CREATE TABLE `calendar_event_master` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `calendar_event_master`
--

INSERT INTO `calendar_event_master` (`event_id`, `user_id`, `event_name`, `event_start_date`, `event_end_date`) VALUES
(1, 11, 'WEB Aufgabe', '2025-06-11', '2025-06-11'),
(2, 11, 'ALGOS Aufgabe', '2025-06-11', '2025-06-11'),
(3, 1, 'ITP Sprint Review 6', '2025-06-10', '2025-06-10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `help`
--

CREATE TABLE `help` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `help`
--

INSERT INTO `help` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, NULL, 'Alberta Hasi', 'hasialberta15@gmail.com', 'cinnamonroll', 'hello', '2025-05-27 13:24:17'),
(2, 10, 'test', 'test@gmail.com', 'KOKO Folien - Alberta Hasi, Peyman', 'hallo hallo hallo', '2025-06-04 12:39:37'),
(3, 11, 'Alberta Hasi', 'hasialberta15@gmail.com', 'tdhy', 'gxngnfnygy', '2025-06-05 09:18:52');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image_path`, `created_at`) VALUES
(1, 'News', 'News', 'uploads/1748353522_WhatsApp Image 2025-05-22 at 11.35.34.jpeg', '2025-05-27 13:45:22'),
(2, 'sdaefgusgbj', 'fgehtejaethtehzqe', 'uploads/1748354212_WhatsApp Image 2025-05-22 at 11.35.35 (1).jpeg', '2025-05-27 13:56:52');

-- --------------------------------------------------------

-- Tabellenstruktur für Tabelle stress_levels
CREATE TABLE stress_levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    stress_level INT NOT NULL, -- z.B. 1-10
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE stress_levels ADD UNIQUE KEY unique_user_date (user_id, date);
-- Tabellenstruktur für Tabelle `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `subject_id`, `title`, `content`, `image_path`, `created_at`, `updated_at`, `file_path`, `file_type`) VALUES
(1, 1, 1, NULL, 'cvrfheatthjt', NULL, '2025-05-25 06:52:06', '2025-05-25 06:52:06', NULL, NULL),
(2, 1, 1, NULL, 'hgdshdhrah', NULL, '2025-05-25 07:39:31', '2025-05-25 07:39:31', 'uploads/6832ad13e60a6.jpeg', 'image/jpeg'),
(5, 10, 8, 'fhstehteq', 'hello', '', '2025-06-04 15:13:41', '2025-06-04 15:13:41', NULL, NULL),
(6, 11, 9, '436362', 'vjhfsjzrjs', '', '2025-06-05 11:15:24', '2025-06-05 11:15:24', NULL, NULL),
(7, 11, 9, 'tshtrhrtajqej', 'hteajejaejeaj', '', '2025-06-09 21:34:25', '2025-06-09 21:34:25', NULL, NULL),
(8, 11, 9, 'reahrwhehweHH', 'NTDAHEAH%EAHE%HEH', '', '2025-06-09 21:34:30', '2025-06-09 21:34:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `study_sessions`
--

CREATE TABLE `study_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `session_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `ects` int(11) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `subjects`
--

INSERT INTO `subjects` (`id`, `user_id`, `name`, `ects`, `is_completed`) VALUES
(1, 1, 'GLINF', 5, 0),
(2, 1, 'ALGOS', 5, 1),
(3, 1, 'test1', 3, 0),
(5, 7, 'GLINF', 5, 1),
(6, 7, 'ALGOS', 5, 0),
(8, 10, 'GLIN', 5, 0),
(9, 11, 'GLINF', 5, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `title`, `deadline`, `is_completed`) VALUES
(1, 1, 'sjgkrdhagjrhgjrkeag', '2025-05-25', 1),
(2, 1, 'edsfrgweg4wt', '2025-06-04', 1),
(5, 7, 'cgjkvzukgzhj', '2025-06-05', 0),
(6, 11, 'make an airplane', '2025-05-02', 1),
(7, 11, 'tdhateheah', '2025-05-04', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle 'subject_grades'
CREATE TABLE subject_grades (
    'id' int(11) NOT NULL,
    'subject_id' int(11) DEFAULT NULL,
    'user_id' INT NOT NULL,
    'grade' DECIMAL(4,2) NOT NULL,
    'created_at' TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `streak` int(11) DEFAULT 0,
  `role` enum('user','admin') DEFAULT 'user',
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `education` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `streak`, `role`, `name`, `surname`, `birthday`, `email`, `gender`, `education`) VALUES
(1, 'test', '$2y$10$XdBCcEdzIUCemxldsOoVSuUvaEYWDaxlip191Ai3gFkiiONEBupo6', 0, 'user', 'test1', 'test2', '2003-01-01', 'test1@email.com', 'Female', 'High School'),
(5, 'alberta', '$2y$10$vnvVU6qoR0ax1L8yOJyrTeTPM3pOXNmLSPcnxmsbA.q5d7fhUMl.K', 0, 'admin', 'Alberta', 'Hasi', '2003-11-15', 'hasialberta15@gmail.com', 'Female', 'Undergraduate'),
(7, 'ayum15', '$2y$10$MTDG.En5dx94/MD/laecPeFOkdvmPXNTwq5/DFjbea1dO0LymjnJ.', 0, 'user', 'Alberta', 'Hasi', '2003-11-15', 'hasialberta15@gmail.com', 'Female', 'Undergraduate'),
(10, 'test1', '$2y$10$jhV19L3B6/wtmcyIhl47hOHvd.3kvCaI7PXzcXHCH79ZjEYCr3m9y', 0, 'user', 'testi', 'test', '2000-01-01', 'test@gmail.com', 'Other', 'Undergraduate'),
(11, 'Alberta15', '$2y$10$VUbBuG/qlVskMRFeR3K1w.wrWvaGOemLD7On0OsqWnBejbkAWjD7K', 0, 'user', 'Alberta', 'Hasi', '2003-11-15', 'hasialberta15@gmail.com', 'Female', 'Undergraduate'),
(14, 'alberta.h', '$2a$12$p4MOapbmOYb4ZJURVzUV2Ope8uNlU/gneZUegy44NK90lJ3IefRpq', 0, 'admin', 'Alberta', 'Hasi', '2003-11-15', 'hasialberta15@gmail.com', 'Female', 'Undergraduate');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `help`
--
ALTER TABLE `help`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indizes für die Tabelle `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subjects_ibfk_1` (`user_id`);

--
-- Indizes für die Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`user_id`);

--
-- Indizes für die Tabelle `subject_grades`

ALTER TABLE `subject_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`);
--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `help`
--
ALTER TABLE `help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `calendar_event_master`
--
ALTER TABLE `calendar_event_master`
  ADD CONSTRAINT `calendar_event_master_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `help`
--
ALTER TABLE `help`
  ADD CONSTRAINT `help_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`);

--
-- Constraints der Tabelle `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

-- --------------------------------------------------------
ALTER TABLE subjects ADD COLUMN grade DECIMAL(4,2) NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
