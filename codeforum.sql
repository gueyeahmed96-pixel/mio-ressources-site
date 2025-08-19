--
-- Script d'extension pour MIO-Ressources
-- Ajoute les fonctionnalités de communauté : comptes utilisateurs, forum, etc.
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table 1 : `comptes`
-- Stocke tous les utilisateurs non-administrateurs (étudiants, professeurs).
--
CREATE TABLE `comptes` (
  `id` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('etudiant','professeur') NOT NULL DEFAULT 'etudiant',
  `avatar_path` varchar(255) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` enum('actif','banni') NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table 2 : `forum_categories`
-- Organise le forum en grandes sections.
--
CREATE TABLE `forum_categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour les catégories du forum.
--
INSERT INTO `forum_categories` (`id`, `nom`, `description`, `ordre`) VALUES
(1, 'Discussions Générales', 'Pour parler de tout et de rien concernant la vie étudiante à l''UIDT.', 10),
(2, 'Licence 1', 'Entraide et questions pour toutes les matières de L1.', 20),
(3, 'Licence 2', 'Entraide et questions pour toutes les matières de L2.', 30),
(4, 'Licence 3', 'Entraide et questions pour toutes les matières de L3.', 40),
(5, 'Annonces des Professeurs', 'Informations officielles et clarifications postées par le corps enseignant.', 5);

-- --------------------------------------------------------

--
-- Table 3 : `forum_sujets`
-- Stocke chaque fil de discussion (thread) créé par un utilisateur.
--
CREATE TABLE `forum_sujets` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `est_epingle` tinyint(1) NOT NULL DEFAULT 0,
  `meilleure_reponse_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table 4 : `forum_messages`
-- Stocke chaque réponse (post) à l'intérieur d'un sujet.
--
CREATE TABLE `forum_messages` (
  `id` int(11) NOT NULL,
  `sujet_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_post` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Configuration des clés primaires, index et AUTO_INCREMENT
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `forum_categories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `forum_sujets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `auteur_id` (`auteur_id`);

ALTER TABLE `forum_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sujet_id` (`sujet_id`),
  ADD KEY `auteur_id` (`auteur_id`);

ALTER TABLE `comptes` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `forum_categories` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `forum_sujets` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `forum_messages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ajout des contraintes (liens logiques entre les tables)
--
ALTER TABLE `forum_sujets`
  ADD CONSTRAINT `sujets_fk_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sujets_fk_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `forum_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `forum_messages`
  ADD CONSTRAINT `messages_fk_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_fk_sujet` FOREIGN KEY (`sujet_id`) REFERENCES `forum_sujets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;