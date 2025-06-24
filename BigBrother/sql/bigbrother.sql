-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 24. Jun 2025 um 15:15
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
(3, 1, 'ITP Sprint Review 6', '2025-06-10', '2025-06-10'),
(4, 11, 'ITP Sprint Review 6', '2025-06-19', '2025-06-19'),
(5, 11, 'WEB Aufgabe', '2025-06-20', '2025-06-22'),
(6, 11, 'theath6rj 4w6n', '2025-06-30', '2025-06-30'),
(7, 1, 'ITP Artefacts Upload - Final deadline', '2025-06-24', '2025-06-24'),
(8, 1, 'WEB Übungsgespräch', '2025-06-27', '2025-06-27'),
(9, 1, 'ITP Final Presentation', '2025-06-30', '2025-06-30'),
(10, 1, 'TDD Übungsgespräch', '2025-07-01', '2025-07-01'),
(11, 1, 'ALGOS Exam', '2025-06-18', '2025-06-18'),
(12, 1, 'Mathe 2. Antritt', '2025-07-01', '2025-07-01'),
(13, 1, 'GLINF 3. Antritt', '2025-06-30', '2025-06-30');

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
(4, 'Smart Study Tips to Boost Your Learning', 'Whether you’re a high school student preparing for exams, a college student tackling coursework, or a lifelong learner brushing up on new skills, how you study can make a big difference. Good study habits are more about strategy than raw effort. Here are some practical tips to help you study smarter—not just harder.\r\n\r\n1. Create a Dedicated Study Space\r\nFind a quiet, organized space where you can focus without distractions. This doesn’t have to be a fancy office—a clean desk in a quiet corner works well. Keep your study space consistent so your brain associates that spot with focus and productivity.\r\n\r\n2. Use Active Recall\r\nInstead of rereading notes or textbooks, quiz yourself. Try to recall key points without looking. This process strengthens memory connections and is far more effective than passive review.\r\n\r\n3. Practice Spaced Repetition\r\nDon’t cram. Review material over multiple sessions spaced out over time. Apps like Anki or Quizlet use spaced repetition algorithms to help you review content just before you’re likely to forget it—maximizing retention.\r\n\r\n4. Break it Down (Pomodoro Technique)\r\nUse the Pomodoro Technique: 25 minutes of focused work followed by a 5-minute break. After four cycles, take a longer break. This method keeps your brain fresh and helps maintain motivation.\r\n\r\n5. Teach What You Learn\r\nExplaining concepts to someone else (or even pretending to) is a powerful way to understand them deeply. Teaching forces you to organize your thoughts and identify any gaps in your knowledge.\r\n\r\n6. Minimize Multitasking\r\nYour brain can’t fully focus on more than one thing at a time. Turn off notifications, silence your phone, and close unrelated tabs. Focus on one task until it’s done, then move to the next.\r\n\r\n7. Use a Study Schedule\r\nSet specific goals for what you want to accomplish and when. A well-planned study schedule prevents last-minute cramming and helps you balance study with breaks, meals, and sleep.\r\n\r\n8. Stay Healthy\r\nNever underestimate the importance of sleep, nutrition, and exercise. A well-rested and nourished brain performs better. Avoid all-nighters—they often do more harm than good.\r\n\r\nEffective studying is about quality, not quantity. With the right strategies, you can make the most of your time and retain information more efficiently. Test different approaches and adapt them to suit your style. The goal is progress, not perfection.', 'uploads/1750754057_feliphe-schiarolli-hes6nUC1MVc-unsplash.jpg', '2025-06-24 08:34:17'),
(5, 'Mastering Time Management: A Guide for Students', 'Time is one of the most valuable resources students have—but it’s also one of the easiest to waste. Between classes, assignments, social life, and personal responsibilities, managing time effectively can feel overwhelming. The good news? With a few strategies, you can take control of your schedule and reduce stress.\r\n\r\n1. Set Clear Priorities\r\nStart by identifying what matters most. Academic tasks should usually come first, but don’t forget to include time for rest, social interaction, and self-care. Knowing your priorities helps you say “no” to distractions and avoid overcommitting.\r\n\r\n2. Use a Planner or Digital Calendar\r\nKeep all your deadlines, appointments, and tasks in one place. Digital tools like Google Calendar, Notion, or Todoist can help you schedule your week, set reminders, and stay on track. Visualizing your time helps prevent last-minute panic.\r\n\r\n3. Break Down Big Tasks\r\nLarge projects or study goals can feel overwhelming. Break them into smaller steps and assign each to a specific day or block of time. This makes your workload feel more manageable and helps you stay motivated.\r\n\r\n4. Avoid Perfectionism\r\nWaiting for the “perfect moment” or trying to make everything flawless can eat up precious time. Do your best, but know when to move on. Progress is better than perfection.\r\n\r\n5. Plan for Flexibility\r\nLife happens—so build buffer time into your schedule. If something takes longer than expected or an emergency arises, you’ll be less likely to fall behind.\r\n\r\n6. Track How You Spend Time\r\nSpend a few days tracking your time to see where it actually goes. You might be surprised by how much time is lost to distractions like social media or unplanned breaks. Use this insight to adjust your habits.\r\n\r\n7. Use Time Blocks\r\nGroup similar tasks together into blocks. For example, you might check email at 10 a.m. and 4 p.m. rather than throughout the day. This reduces mental switching and improves focus.\r\n\r\n8. Reward Yourself\r\nAfter completing a task or sticking to your schedule, reward yourself with something small—a short walk, a snack, or a break. Positive reinforcement builds motivation and helps you associate productivity with satisfaction.\r\n\r\nTime management isn’t about squeezing productivity into every second—it’s about using your time intentionally. By setting goals, planning ahead, and making mindful choices, you can reduce stress and make space for the things that truly matter. Like any skill, time management improves with practice—start small, and stick with it.', 'uploads/1750754122_artem-maltsev-XE8Pe5uz_WI-unsplash.jpg', '2025-06-24 08:35:22'),
(6, 'How to Stay Motivated During Long Study Sessions', 'Studying for extended periods—whether for finals, a big project, or entrance exams—can be mentally and physically draining. It’s easy to start off strong, only to feel your focus fade after an hour or two. Staying motivated is a skill, and with the right approach, you can keep your energy and momentum going.\r\n\r\n1. Set Specific, Achievable Goals\r\nInstead of saying “I’m going to study all day,” break it into smaller goals like “Finish reading Chapter 5” or “Review biology flashcards for 30 minutes.” Clear goals provide direction and a sense of accomplishment when completed.\r\n\r\n2. Start with a Warm-Up Task\r\nDon’t dive into the hardest topic right away. Begin with a task that’s easy or familiar to ease into the study session. This builds confidence and gets your brain into learning mode.\r\n\r\n3. Use Visual Progress Trackers\r\nChecklists, timers, or progress bars can help you visualize your achievements. Whether it’s crossing off topics or seeing a timer count down, visual feedback creates a sense of momentum.\r\n\r\n4. Incorporate Variety\r\nSwitch between subjects, formats, or tasks to keep your mind engaged. Read for 30 minutes, then do flashcards, then solve practice problems. This technique—called interleaving—also boosts learning retention.\r\n\r\n5. Create a Study Ritual\r\nDevelop a routine that signals it\'s time to focus. For example: make tea, play a calming playlist, review your to-do list, and then start studying. A consistent pre-study ritual can trigger focus more quickly over time.\r\n\r\n6. Limit Distractions\r\nPhone on silent. Social media off. Use tools like Focus Mode, Forest, or website blockers to stay on track. Even small distractions can derail your motivation and stretch your study time unnecessarily.\r\n\r\n7. Use Positive Reinforcement\r\nReward yourself for completing tasks: a snack, a 10-minute break, or watching an episode of your favorite show. Rewards keep your brain engaged and give you something to look forward to.\r\n\r\n8. Remind Yourself of the “Why”\r\nWhen motivation dips, reconnect with your long-term goals. Are you working toward a scholarship? A career dream? A personal milestone? Keep a note or image nearby that reminds you what you’re working for.\r\n\r\nMotivation isn’t constant—it rises and falls. What matters most is creating habits and systems that help you keep going even when your energy fades. With structure, variety, and a little self-compassion, you can power through long study sessions and feel proud of your progress.', 'uploads/1750754202_dominic-kurniawan-suryaputra-vjprN8SZq14-unsplash.jpg', '2025-06-24 08:36:42');

-- --------------------------------------------------------

--
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
  `file_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `subject_id`, `title`, `content`, `image_path`, `created_at`, `updated_at`, `file_path`, `file_type`) VALUES
(5, 10, 8, 'fhstehteq', 'hello', '', '2025-06-04 15:13:41', '2025-06-04 15:13:41', NULL, NULL),
(6, 11, 9, '436362', 'vjhfsjzrjs', '', '2025-06-05 11:15:24', '2025-06-05 11:15:24', NULL, NULL),
(7, 11, 9, 'tshtrhrtajqej', 'hteajejaejeaj', '', '2025-06-09 21:34:25', '2025-06-09 21:34:25', NULL, NULL),
(8, 11, 9, 'reahrwhehweHH', 'NTDAHEAH%EAHE%HEH', '', '2025-06-09 21:34:30', '2025-06-09 21:34:30', NULL, NULL),
(10, 1, 1, 'Types and Representations of Formal Languages', 'Okay so Motivation: How do we represent languages \r\nin a machine-readable way?\r\n\r\nMethods:\r\n1. Enumerate the language (the set of words) \r\n\r\n→ not always possible because some are infinite\r\n\r\n1. Invent a “meta-language” to represent the original language →\r\nregEx → used by editors in search&replace, command-line tools etc)\r\n2. Grammars → the same way parsers work → In parsing, code is \r\ntaken from the preprocessor, broken into smaller pieces \r\nand analyzed so other software can understand it.\r\n    1. Example: <{A,B}, {a,b}, {A→aA, A→B, B→b}, A>\r\n3. Automation Models (state machines) → \r\nserves as more of a visualization for the human eye', '', '2025-06-24 10:50:58', '2025-06-24 13:18:05', NULL, NULL),
(11, 1, 1, 'DFA', 'DFA TRANSITION FUNCTION\r\n\r\n→ 2 representations possible \r\n\r\n→ state diagram\r\n\r\n→ state transition table\r\n\r\nSTATE DIAGRAM\r\n\r\n→ labeled directed graph for visualiztion of the transition \r\nfunction\r\n\r\n→ each node represents a state Qj\r\n\r\n→ each directed edge represents a transition from \r\none state to another (loops are also possible)\r\n\r\n→ edges are labeled with the input symbols that \r\ncause the transition\r\n\r\n→ the number of edges leaving a node (node degree) \r\nhas to be the same as the number of input symbols', '', '2025-06-24 10:51:23', '2025-06-24 13:17:22', NULL, NULL),
(12, 1, 13, 'Object Oriented Programming', 'Object-Oriented Programming (OOP) is a programming approach\r\nthat organizes code using objects, which are instances of classes. \r\nThese objects combine data (attributes) and functions (methods) into reusable \r\nstructures, making programs easier to understand, maintain, and extend. \r\nKey concepts include encapsulation, inheritance, polymorphism, and abstraction.', 'uploads/FGDI-0 Number Systems, Information Theory, Logic.pdf', '2025-06-24 11:06:52', '2025-06-24 13:16:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stress_levels`
--

CREATE TABLE `stress_levels` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stress_level` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `stress_levels`
--

INSERT INTO `stress_levels` (`id`, `user_id`, `stress_level`, `date`, `created_at`) VALUES
(1, 11, 5, '2025-06-18', '2025-06-18 13:52:47'),
(2, 11, 10, '2025-06-07', '2025-06-18 13:53:01'),
(4, 11, 7, '2025-06-08', '2025-06-19 11:14:42'),
(5, 11, 5, '2025-06-09', '2025-06-19 11:14:54'),
(6, 11, 8, '2025-06-10', '2025-06-19 11:15:06'),
(7, 11, 4, '2025-06-11', '2025-06-19 11:15:18'),
(8, 1, 3, '2025-06-01', '2025-06-24 08:39:49'),
(9, 1, 10, '2025-06-02', '2025-06-24 08:40:15'),
(10, 1, 4, '2025-06-03', '2025-06-24 08:40:24'),
(11, 1, 7, '2025-06-04', '2025-06-24 08:40:31'),
(12, 1, 8, '2025-06-05', '2025-06-24 08:40:36'),
(13, 1, 2, '2025-06-06', '2025-06-24 08:40:44'),
(14, 1, 8, '2025-06-07', '2025-06-24 08:40:50'),
(15, 1, 10, '2025-06-08', '2025-06-24 08:41:00'),
(16, 1, 5, '2025-06-09', '2025-06-24 08:41:11'),
(17, 1, 3, '2025-06-10', '2025-06-24 08:41:30'),
(18, 1, 6, '2025-06-11', '2025-06-24 08:41:48'),
(19, 1, 9, '2025-06-12', '2025-06-24 08:42:02'),
(20, 1, 1, '2025-06-13', '2025-06-24 08:42:12'),
(21, 1, 4, '2025-06-14', '2025-06-24 08:42:24'),
(22, 1, 6, '2025-06-15', '2025-06-24 08:42:35'),
(23, 1, 10, '2025-06-16', '2025-06-24 08:42:44'),
(24, 1, 10, '2025-06-17', '2025-06-24 08:42:54'),
(25, 1, 10, '2025-06-18', '2025-06-24 08:43:00'),
(26, 1, 8, '2025-06-19', '2025-06-24 08:43:12'),
(27, 1, 7, '2025-06-20', '2025-06-24 08:43:22'),
(28, 1, 8, '2025-06-21', '2025-06-24 08:43:33'),
(29, 1, 10, '2025-06-22', '2025-06-24 08:44:00'),
(30, 1, 7, '2025-06-23', '2025-06-24 08:44:08'),
(31, 1, 5, '2025-06-24', '2025-06-24 08:44:15'),
(32, 1, 6, '2025-06-25', '2025-06-24 08:44:20'),
(33, 1, 10, '2025-06-26', '2025-06-24 08:44:29'),
(34, 1, 10, '2025-06-27', '2025-06-24 08:44:39'),
(35, 1, 6, '2025-06-28', '2025-06-24 08:44:57'),
(36, 1, 8, '2025-06-29', '2025-06-24 08:45:17'),
(37, 1, 10, '2025-06-30', '2025-06-24 08:45:25'),
(38, 1, 5, '2025-07-01', '2025-06-24 08:45:34'),
(40, 1, 1, '2025-05-01', '2025-06-24 08:46:13'),
(41, 1, 4, '2025-05-02', '2025-06-24 08:46:21'),
(42, 1, 7, '2025-05-03', '2025-06-24 08:46:29'),
(43, 1, 7, '2025-05-04', '2025-06-24 08:46:37'),
(44, 1, 2, '2025-05-05', '2025-06-24 08:47:01'),
(45, 1, 6, '2025-05-06', '2025-06-24 08:47:11'),
(46, 1, 7, '2025-05-07', '2025-06-24 08:47:23'),
(47, 1, 6, '2025-05-08', '2025-06-24 08:47:31'),
(48, 1, 7, '2025-05-09', '2025-06-24 08:47:37'),
(49, 1, 7, '2025-05-10', '2025-06-24 08:47:49'),
(50, 1, 10, '2025-05-11', '2025-06-24 08:48:15'),
(51, 1, 6, '2025-05-12', '2025-06-24 08:48:22'),
(52, 1, 9, '2025-05-13', '2025-06-24 08:48:29'),
(53, 1, 8, '2025-05-14', '2025-06-24 08:48:35'),
(54, 1, 8, '2025-05-15', '2025-06-24 08:48:40'),
(55, 1, 4, '2025-05-16', '2025-06-24 08:48:46'),
(57, 1, 4, '2025-05-17', '2025-06-24 08:49:03'),
(58, 1, 10, '2025-05-24', '2025-06-24 08:49:15');

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
(2, 1, 'ALGOS', 5, 0),
(8, 10, 'GLIN', 5, 0),
(9, 11, 'GLINF', 5, 1),
(10, 1, 'ITP', 2, 0),
(11, 1, 'Agile Methoden', 3, 1),
(12, 1, 'KONFIG', 3, 1),
(13, 1, 'OOP', 5, 1),
(14, 1, 'TDD', 2, 0),
(15, 1, 'WEB', 5, 0),
(16, 1, 'Mathematik', 5, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `subject_grades`
--

CREATE TABLE `subject_grades` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `grade` decimal(4,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `subject_grades`
--

INSERT INTO `subject_grades` (`id`, `subject_id`, `user_id`, `grade`, `created_at`) VALUES
(1, 1, 1, 4.00, '2025-06-24 12:55:52'),
(2, 1, 1, 3.00, '2025-06-24 12:55:58'),
(12, 1, 1, 2.00, '2025-06-24 13:13:53'),
(13, 1, 1, 1.00, '2025-06-24 13:13:55'),
(14, 2, 1, 3.00, '2025-06-24 13:13:59'),
(15, 10, 1, 5.00, '2025-06-24 13:14:02'),
(16, 10, 1, 2.00, '2025-06-24 13:14:04'),
(17, 11, 1, 3.00, '2025-06-24 13:14:07'),
(18, 12, 1, 4.00, '2025-06-24 13:14:11'),
(19, 13, 1, 1.00, '2025-06-24 13:14:15'),
(20, 14, 1, 2.00, '2025-06-24 13:14:18'),
(21, 15, 1, 4.00, '2025-06-24 13:14:23'),
(22, 16, 1, 3.00, '2025-06-24 13:14:28');

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
(6, 11, 'make an airplane', '2025-05-02', 1),
(7, 11, 'tdhateheah', '2025-05-04', 1),
(8, 1, 'Prepare for WEB', '2025-06-26', 0),
(9, 1, 'ITP Final Assignment', '2025-06-24', 1),
(10, 1, 'TDD Ex. 1', '2025-06-10', 1),
(11, 1, 'TDD Ex. 2', '2025-06-17', 1),
(12, 1, 'TDD Ex. 3', '2025-06-24', 0),
(13, 1, 'TDD Ex. 4', '2025-07-02', 0),
(14, 1, 'GLINF Chapter 3', '2025-06-25', 0),
(15, 1, 'GLINF Chapter 4', '2025-06-25', 0),
(16, 1, 'Mathe Teil 1', '2025-06-26', 0),
(17, 1, 'Mathe Teil 2', '2025-06-26', 0),
(18, 1, 'ITP Video Presentation', '2025-06-24', 1);

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
(1, 'test', '$2y$10$3WZfEPAo5naD/709wOXC3Oq0C1lADSqoYExM5Tbr3/7FTC8.Wmhty', 0, 'user', 'test1', 'test2', '2003-01-01', 'test1@email.com', 'Female', 'Undergraduate'),
(10, 'test1', '$2y$10$jhV19L3B6/wtmcyIhl47hOHvd.3kvCaI7PXzcXHCH79ZjEYCr3m9y', 0, 'user', 'testi', 'test', '2000-01-01', 'test@gmail.com', 'Other', 'Undergraduate'),
(11, 'Alberta15', '$2y$10$VUbBuG/qlVskMRFeR3K1w.wrWvaGOemLD7On0OsqWnBejbkAWjD7K', 0, 'user', 'Alberta', 'Hasi', '2003-11-15', 'hasialberta15@gmail.com', 'Female', 'Undergraduate'),
(15, 'admin', '$2y$10$iJxal8RFFyHVXpCrB0W2Be1u4xT5SmKqPNDBxLF9AgRFRj3Avfr/m', 0, 'admin', 'admin', 'admin', '2003-06-24', 'admin@admin.com', 'Female', 'Undergraduate');

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
-- Indizes für die Tabelle `stress_levels`
--
ALTER TABLE `stress_levels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`date`);

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
-- Indizes für die Tabelle `subject_grades`
--
ALTER TABLE `subject_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_ibfk_1` (`user_id`);

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
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `help`
--
ALTER TABLE `help`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `stress_levels`
--
ALTER TABLE `stress_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT für Tabelle `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `subject_grades`
--
ALTER TABLE `subject_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT für Tabelle `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints der Tabelle `subject_grades`
--
ALTER TABLE `subject_grades`
  ADD CONSTRAINT `fk_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
