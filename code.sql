--
-- Base de données : `mio_db`
-- Structure et données initiales complètes
--

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
-- Stocke les informations des administrateurs
--
CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `photo_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `utilisateurs`
-- L'utilisateur avec id=1 est le Super Admin
--
INSERT INTO `utilisateurs` (`id`, `identifiant`, `mot_de_passe`, `photo_profil`) VALUES
(1, 'admin', '$2y$10$9.B2/lP7ANVpJnaA4Iu1UuJML.oV47sPt2dAVM227iwX46zUaO7.O', NULL); -- Mot de passe : admin123

-- --------------------------------------------------------

--
-- Structure de la table `semestres`
--
CREATE TABLE `semestres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `niveau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `semestres`
--
INSERT INTO `semestres` (`id`, `nom`, `niveau`) VALUES
(1, 'Semestre 1', 'L1'), (2, 'Semestre 2', 'L1'),
(3, 'Semestre 3', 'L2'), (4, 'Semestre 4', 'L2'),
(5, 'Semestre 5', 'L3'), (6, 'Semestre 6', 'L3');

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--
CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `code_matiere` varchar(50) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `semestre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `matieres`
--
INSERT INTO `matieres` (`id`, `code_matiere`, `nom`, `semestre_id`) VALUES
(1, 'MIO 1111', 'Statistiques pour l''Economie et la Gestion', 1), (2, 'MIO 1112', 'Comptabilité Financière 1', 1),
(3, 'MIO 1121', 'Economie Générale', 1), (4, 'MIO 1122', 'Introduction à l''Etude du Droit', 1), (5, 'MIO 1123', 'Anglais', 1),
(6, 'MIO 1131', 'Mathématiques Générales', 1), (7, 'MIO 1132', 'Algorithmique', 1), (8, 'MIO 1141', 'Recherche Documentaire', 1),
(9, 'MIO1142', 'Projet Personnel Professionnel', 1), (10, 'MIO1143', 'Sport, Culture et Pédagogie', 1),
(11, 'MIO 1211', 'Economie de l''Entreprise', 2), (12, 'MIO 1212', 'Comptabilité Financière 2', 2),
(13, 'MIO 1221', 'Systèmes d''information de Gestion', 2), (14, 'MIO 1222', 'Techniques de Communication', 2),
(15, 'MIO 1231', 'Mathématiques Discrètes', 2), (16, 'MIO 1232', 'Calcul de Probabilités', 2),
(17, 'MIO 1241', 'Algorithmique et Programmation', 2), (18, 'MIO 1242', 'Applications Informatiques (Tableurs et Logiciels Com)', 2),
(19, 'MIO1251', 'Visite d''Entreprise/Stage', 2), (20, 'MIO 2311', 'Méthodes d''Optimisation pour la Gestion', 3),
(21, 'MIO 2312', 'Comptabilité de Gestion', 3), (22, 'MIO 2321', 'Management Stratégique et Opérationnel', 3),
(23, 'MIO 2322', 'Anglais', 3), (24, 'MIO 2323', 'Introduction au Marketing', 3),
(25, 'MIO 2331', 'Analyse et Conception et Systèmes d''information', 3), (26, 'MIO 2332', 'Langages pour le Développement Web', 3),
(27, 'MIO 2411', 'Langages pour le Développement Web Avancé', 4), (28, 'MIO 2412', 'Techniques de Communication', 4),
(29, 'MIO 2413', 'Droit des Obligations et Commercial', 4), (30, 'MIO 2421', 'Estimation de Tests et Statistiques', 4),
(31, 'MIO2422', 'Analyse de Données', 4), (32, 'MIO 2431', 'Analyse et Conception de Systèmes Orientés Objet', 4),
(33, 'MIO 2432', 'Base de Données', 4), (34, 'MIO2441', 'Visite d''Entreprise / Stage', 4),
(35, 'MIO3511', 'Analyse Financière', 5), (36, 'MIO3512', 'Gestion des Ressources Humaines', 5),
(37, 'MIO3513', 'Création d''Entreprises', 5), (38, 'MIO 3521', 'Fiscalité', 5),
(39, 'MIO 3522', 'Gestion Budgétaire', 5), (40, 'MIO 3523', 'Comptabilité des Sociétés', 5),
(41, 'MIO3533', 'Langage Orienté Objet', 5), (42, 'MIO3531', 'Outils pour le Développement et l''Administration Web', 5),
(43, 'MIO3532', 'Réseaux et Protocoles', 5), (44, 'MIO3613', 'Methodologie de Rédaction de Projet de Fin de Cycle (PFC)', 6),
(45, 'MIO3611', 'Management de Projets', 6), (46, 'MIO3612', 'Econométrie', 6),
(47, 'MIO3621', 'Projet de Fin de Cycle/ Rapport', 6);

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--
CREATE TABLE `ressources` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `type` enum('Cours','TD','Vidéo','Autre') NOT NULL,
  `chemin_fichier` varchar(255) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--
CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text DEFAULT NULL,
  `date_modif` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `pages`
--
INSERT INTO `pages` (`slug`, `titre`, `contenu`) VALUES
('a-propos', 'À Propos de MIO-Ressources', '<p>Contenu initial de la page <strong>À Propos</strong>. Vous pouvez modifier ce texte depuis l\'espace d\'administration.</p>'),
('club-mio', 'Le Club MIO', '<p>Présentation du <em>Club MIO</em>. Vous pouvez modifier ce texte depuis l\'espace d\'administration.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `slider_images`
--
CREATE TABLE `slider_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `slider_images`
--
INSERT INTO `slider_images` (`image_path`, `titre`, `description`, `ordre`) VALUES
('slider_default_1.jpg', 'Bienvenue sur MIO Ressources', 'Votre hub central pour tous les cours, TD et ressources de la filière MIO.', 1),
('slider_default_2.jpg', 'Partage et Entraide', 'Une plateforme créée par les étudiants, pour les étudiants.', 2),
('slider_default_3.jpg', 'Réussissez Votre Licence', 'Accédez facilement aux supports de cours et préparez sereinement vos examens.', 3);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--
CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `nom_param` varchar(100) NOT NULL,
  `valeur_param` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Données initiales pour la table `parametres`
--
INSERT INTO `parametres` (`nom_param`, `valeur_param`) VALUES
('contact_email', 'contact@mio-ressources.sn'),
('contact_telephone', '+221 77 000 00 00'),
('contact_adresse', 'Université Iba Der Thiam, Thiès, Sénégal'),
('contact_iframe_maps', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3852.277873527231!2d-16.93179298580856!3d14.75296097943485!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec11d2170390141%3A0x77c22502f901115e!2sUniversit%C3%A9%20Iba%20Der%20Thiam%20de%20Thi%C3%A8s!5e0!3m2!1sfr!2sfr!4v1663162793741!5m2!1sfr!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'),
('bg_image_l1', 'bg_l1_default.jpg'), ('bg_image_l2', 'bg_l2_default.jpg'), ('bg_image_l3', 'bg_l3_default.jpg'),
('social_facebook_url', ''), ('social_twitter_url', ''), ('social_linkedin_url', ''), ('social_youtube_url', ''), ('social_github_url', ''),
('theme_bg_main', '#f8f9fc'), ('theme_bg_sidebar', '#ffffff'), ('theme_bg_card', '#ffffff'),
('theme_border_color', '#e3e6f0'), ('theme_text_primary', '#5a5c69'), ('theme_text_secondary', '#858796'), ('theme_accent_primary', '#4e73df');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `visites`
--
CREATE TABLE `visites` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `page_visited` varchar(255) NOT NULL,
  `visit_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index et AUTO_INCREMENT pour les tables
--
ALTER TABLE `utilisateurs` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `identifiant` (`identifiant`);
ALTER TABLE `semestres` ADD PRIMARY KEY (`id`);
ALTER TABLE `matieres` ADD PRIMARY KEY (`id`), ADD KEY `semestre_id` (`semestre_id`);
ALTER TABLE `ressources` ADD PRIMARY KEY (`id`), ADD KEY `matiere_id` (`matiere_id`);
ALTER TABLE `pages` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `slug` (`slug`);
ALTER TABLE `slider_images` ADD PRIMARY KEY (`id`);
ALTER TABLE `parametres` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `nom_param` (`nom_param`);
ALTER TABLE `notifications` ADD PRIMARY KEY (`id`);
ALTER TABLE `visites` ADD PRIMARY KEY (`id`);

ALTER TABLE `utilisateurs` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `semestres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `matieres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
ALTER TABLE `ressources` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `slider_images` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `parametres` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `notifications` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `visites` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables
--
ALTER TABLE `matieres` ADD CONSTRAINT `matieres_ibfk_1` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `ressources` ADD CONSTRAINT `ressources_ibfk_1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;