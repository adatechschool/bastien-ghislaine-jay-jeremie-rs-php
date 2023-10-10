-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2023 at 09:12 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialnetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(10) UNSIGNED NOT NULL,
  `followed_user_id` int(10) UNSIGNED NOT NULL,
  `following_user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `followed_user_id`, `following_user_id`) VALUES
(1, 5, 3),
(2, 5, 6),
(3, 5, 7),
(4, 1, 5),
(5, 2, 5),
(6, 4, 5),
(7, 1, 2),
(8, 1, 3),
(9, 1, 7),
(10, 1, 6),
(11, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) NOT NULL,
  `name` varchar(128) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `bin` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(96, 1, 4),
(95, 1, 8),
(11, 1, 9),
(12, 2, 9),
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(13, 4, 9),
(14, 5, 9),
(22, 6, 1),
(21, 6, 2),
(20, 6, 3),
(19, 6, 4),
(18, 6, 5),
(17, 6, 6),
(16, 6, 7),
(15, 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `created`, `parent_id`) VALUES
(1, 5, '#JavaScript Une enquête géante auprès des développeurs JavaScript montre quels outils ils utilisent et pourquoi. L\'enquête annuelle sur JavaScript, dont Google fait partie des sponsors, met en évidence les nouveaux frameworks front-end, tels que Solid et Qwik, qui défient des piliers comme #React. Elle examine également les frameworks de rendu, les outils de test, le développement mobile et de bureau, ainsi que divers outils de construction.\r\n\r\n', '2020-02-05 18:19:12', NULL),
(2, 2, 'Microsoft continue à surveiller et à ajuster #Python dans Excel afin d\'assurer la sécurité des utilisateurs et de leurs données.', '2020-04-06 18:19:12', NULL),
(3, 5, '#Python 3.12 : la dernière version apporte des modifications du langage et de la bibliothèque standard.\r\nElle comporte aussi une amélioration des messages d\'erreur. Les modifications apportées à la bibliothèque se concentrent sur le nettoyage des API obsolètes, la facilité d\'utilisation et la correction. À noter que le paquet distutils a été supprimé de la bibliothèque standard. La prise en charge des systèmes de fichiers dans os et pathlib a fait l\'objet d\'un certain nombre d\'améliorations, et plusieurs modules sont plus performants.', '2020-07-12 18:21:49', NULL),
(4, 1, 'Tailwind #CSS v3.3 est désormais disponible, et apporte un large éventail de nouvelles fonctionnalités dont une palette de couleurs étendue pour les tons sombres et un support pour ESM/TS. Bon nombre de ces nouveautés étaient demandées depuis longtemps par les utilisateurs. ', '2020-08-04 18:21:49', NULL),
(5, 3, 'La version 3.2 du langage de programmation #Ruby est disponible. Elle apporte de nombreuses fonctionnalités et améliore les performances. Dans cette nouvelle version du langage multiparadigme, on trouve un algorithme de correspondance Regexp amélioré et le support de WebAssembly basé sur WASI.', '2020-09-25 18:24:30', NULL),
(6, 6, '#Node.js 20.6, la dernière mise à jour de ce populaire moteur d\'exécution JavaScript, a été publiée. Parmi les nouvelles fonctionnalités, il y a la possibilité de configurer des variables d\'environnement dans un fichier transmis à l\'application lors de son lancement, ainsi qu\'une prise en charge expérimentale du langage C++ ramassant les miettes (garbage-collected) via un projet V8 appelé Oilpan. V8 est le moteur JavaScript et WebAssembly également utilisé par Google Chrome, Deno et de nombreux autres projets.', '2020-10-15 00:35:42', NULL),
(7, 6, 'C\'est en fin juillet que JetBrains a publié WebStorm 2023.2, la deuxième mise à jour majeure de l\'année de son EDI pour les développeurs #JavaScript. Cette version est venue avec un bon lot de nouvelles fonctionnalités et améliorations. Parmi celles-ci, on peut citer une amélioration de la façon dont l\'EDI présente les erreurs pour JavaScript et TypeScript, la prise en charge de l\'imbrication CSS, la prise en charge du serveur de langages Vue (Volar), une nouvelle interface utilisateur stable et une intégration de GitLab. Les autres nouveautés incluent la prise en charge du protocole LSP pour le développement de plugins, des améliorations concernant Svelte, Preact et SolidJS, et bien plus.\r\n', '2020-10-25 00:35:39', NULL),
(8, 7, 'Le 8 septembre, #Bun a atteint le statut de version stable prête pour la production. À la fois runtime et boîte à outils tout-en-un pour créer, tester, déboguer et exécuter des applications JavaScript et TypeScript, Bun se positionne comme alternative directe à Node.js. « En tant qu’exécutable unique, Bun est capable de rendre toutes les fonctionnalités « formidables » de JavaScript moins complexes et plus rapides », ont déclaré les développeurs de Bun. Selon eux, Bun est un moteur d\'exécution JavaScript rapide qui simplifie le développement JavaScript en faisant l’économie des « couches et des couches d\'outils qui se sont accumulées les unes sur les autres ».', '2020-11-10 18:26:12', NULL),
(9, 1, 'Google a annoncé une mise à jour importante du langage de programmation #Go avec le lancement de Go 1.18, qui introduit un support natif pour le « fuzz testing » (une technique pour tester des logiciels), le premier langage de programmation majeur à le faire. Comme l\'explique Google, le fuzz testing, ou « fuzzing », est un moyen de tester la vulnérabilité d\'un logiciel en lui envoyant des données arbitraires ou invalides afin d\'exposer les bugs et les erreurs inconnues. Cela ajoute une couche de sécurité supplémentaire au code de Go, qui le protégera au fur et à mesure de l\'évolution de ses fonctionnalités, ce qui est crucial à l\'heure où les attaques contre les logiciels continuent d\'augmenter en fréquence et en complexité.', '2020-11-20 18:26:50', NULL),
(10, 1, 'Microsoft annonce la disponibilité de #TypeScript 5.3 Beta et présente une liste rapide des nouveautés de TypeScript 5.3 Beta.', '2020-11-30 18:31:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts_tags`
--

CREATE TABLE `posts_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts_tags`
--

INSERT INTO `posts_tags` (`id`, `post_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 6),
(6, 6, 7),
(7, 7, 8),
(8, 8, 8),
(9, 9, 9),
(10, 10, 5),
(11, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `label`) VALUES
(6, 'bun'),
(3, 'css'),
(7, 'go'),
(1, 'javascript'),
(5, 'node.js'),
(2, 'python'),
(9, 'react'),
(4, 'ruby'),
(8, 'typescript');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `alias`) VALUES
(1, 'ghislaine@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Ghislaine'),
(2, 'bastien@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Bastien'),
(3, 'jeremie@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Jérémie'),
(4, 'jay@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Jay'),
(5, 'abelson@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Abelson'),
(6, 'laura@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Laura'),
(7, 'zineb@youpi.com', '098f6bcd4621d373cade4e832627b4f6', 'Zineb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_has_users_users2_idx` (`following_user_id`),
  ADD KEY `fk_users_has_users_users1_idx` (`followed_user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_post` (`user_id`,`post_id`),
  ADD KEY `fk_users_has_posts_posts1_idx` (`post_id`),
  ADD KEY `fk_users_has_posts_users1_idx` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_users_idx` (`user_id`),
  ADD KEY `fk_posts_posts1_idx` (`parent_id`);

--
-- Indexes for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_has_tags_tags1_idx` (`tag_id`),
  ADD KEY `fk_posts_has_tags_posts1_idx` (`post_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `label_UNIQUE` (`label`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `alias_UNIQUE` (`alias`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts_tags`
--
ALTER TABLE `posts_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `fk_users_has_users_users1` FOREIGN KEY (`followed_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_users_has_users_users2` FOREIGN KEY (`following_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_users_has_posts_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_users_has_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_posts1` FOREIGN KEY (`parent_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_posts_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `fk_posts_has_tags_posts1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `fk_posts_has_tags_tags1` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
