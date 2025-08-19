Présentation du Projet : MIO-Ressources
Concept Général
MIO-Ressources est une plateforme web complète et dynamique, développée spécifiquement pour les étudiants de la filière Management Informatisé des Organisations (MIO) de l'Université Iba Der Thiam de Thiès. Conçu comme un écosystème pédagogique centralisé, le site a pour double mission de faciliter l'accès aux supports de cours et de construire une communauté d'entraide active et solidaire entre les étudiants et les professeurs.
Le projet a évolué d'une simple bibliothèque de ressources en un portail communautaire riche en fonctionnalités, entièrement administrable via un tableau de bord puissant et moderne.
Fonctionnalités Clés
La plateforme est divisée en deux expériences distinctes : l'interface publique pour les étudiants et les visiteurs, et le panneau d'administration sécurisé.
I. Espace Public (Côté Étudiant)
L'interface publique est conçue pour être engageante, intuitive et parfaitement responsive sur tous les appareils (mobiles, tablettes, ordinateurs).
Accueil Dynamique et Immersif :
Un slider d'images entièrement administrable pour mettre en avant les actualités ou des messages de bienvenue.
Une grille visuelle des semestres (L1, L2, L3) avec des images de fond personnalisables, invitant à l'exploration.
Une section "Dernières Discussions" qui met en avant l'activité récente du forum, créant un sentiment de communauté vivante.
Système d'Authentification Complet et Sécurisé :
Inscription et Connexion pour les étudiants et les professeurs.
Système de récupération de mot de passe (simulé en local, fonctionnel en production).
Profils Utilisateurs Personnalisables où chaque membre peut ajouter sa propre photo de profil et modifier ses informations.
Bibliothèque de Ressources Structurée :
Navigation logique par semestre puis par matière.
Affichage clair des ressources (Cours, TD, Vidéos) avec une double option : "Voir" pour une consultation rapide dans le navigateur (PDFs) et "Télécharger" pour une sauvegarde locale.
Forum d'Échange Communautaire (Cœur du Site) :
Un espace de discussion structuré en catégories (par niveau, par matière, ou généraliste).
Possibilité pour les utilisateurs connectés de créer des sujets et de répondre aux discussions.
Identification visuelle des rôles (Étudiant, Professeur, Admin) pour valoriser les contributions.
Possibilité pour les utilisateurs de modifier ou supprimer leurs propres messages.
Pages de Contenu Dynamiques :
Les pages "À Propos" et "Club MIO" sont entièrement éditables depuis l'administration via un éditeur de texte riche.
II. Espace d'Administration (Dashboard)
Le tableau de bord est le centre de contrôle total du site, conçu pour être à la fois puissant, esthétique et facile à utiliser.
Design Moderne et Personnalisable :
Un thème sombre par défaut, inspiré des meilleurs designs de dashboards ("Rocker"), pour un confort visuel optimal.
Un sélecteur de thème permettant à l'administrateur de changer toutes les couleurs de l'interface (fonds, textes, couleurs d'accentuation) pour créer sa propre palette.
Analyse de Données (Business Intelligence) :
Cartes de statistiques affichant les indicateurs clés : visites totales, visiteurs uniques, nombre de ressources et de matières.
Graphique d'activité en temps réel montrant l'évolution du trafic sur les 7 derniers jours.
Graphique circulaire de répartition des ressources par type.
Tableau des 5 pages les plus populaires pour comprendre le comportement des utilisateurs.
Gestion Complète du Contenu (CMS) :
Gestion des Ressources (CRUD) : Ajout, modification et suppression de tous les supports de cours.
Gestion de l'Apparence : Modification des images du slider, des fonds d'écran, et du logo.
Gestion des Pages : Édition du contenu textuel des pages statiques.
Outils de Modération et de Gestion Communautaire :
Gestion des Utilisateurs : Lister tous les comptes (étudiants, professeurs, admins), modifier leurs informations, changer leur rôle, et les bannir si nécessaire.
Gestion du Forum : Créer/modifier/supprimer les catégories du forum, épingler les sujets importants, et modérer les messages.
Notifications : Un système de cloche informe l'administrateur en temps réel des nouvelles activités sur le site (ex: nouvelle ressource ajoutée).
Architecture Technique et Sécurité
La sécurité a été une priorité à chaque étape du développement.
Backend : PHP 8 avec une approche orientée objet pour la logique et PDO pour les interactions avec la base de données.
Base de Données : MySQL / MariaDB avec une structure relationnelle propre (clés étrangères).
Frontend : Bootstrap 5 pour un design responsive robuste, complété par du CSS personnalisé et du JavaScript pour l'interactivité.
Sécurité :
Mots de passe hachés (Argon2/Bcrypt via PHPAuth).
Protection systématique contre l'Injection SQL (requêtes préparées).
Protection contre le XSS (htmlspecialchars).
Contrôle d'accès strict pour les pages admin.
Gestion sécurisée des uploads de fichiers.
Dépendances : Gérées via Composer, avec l'intégration de la librairie professionnelle PHPAuth pour une authentification robuste et sécurisée.

