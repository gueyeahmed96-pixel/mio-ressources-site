# MIO-Ressources - Plateforme de Partage de Cours

MIO-Ressources est une application web complète développée en PHP/MySQL, conçue pour les étudiants de la filière **Management Informatisé des Organisations (MIO)** de l'Université Iba Der Thiam de Thiès. Elle centralise les ressources pédagogiques et est entièrement gérée via un tableau de bord d'administration avancé.

Le projet a été construit étape par étape, en partant d'une simple page d'accueil pour aboutir à un système de gestion de contenu (CMS) complet avec des fonctionnalités d'analyse et de personnalisation.

## Fonctionnalités

### 🚀 Côté Visiteur (Étudiant)
- **Accueil Dynamique :** Slider d'images et grille des semestres entièrement administrables.
- **Navigation Intuitive :** Parcours logique par semestre, puis par matière.
- **Consultation de Ressources :** Affichage des cours et TD avec double option : **"Voir"** dans le navigateur (pour les PDF) et **"Télécharger"**.
- **Contenu Dynamique :** Pages "À Propos", "Club MIO", et "Contact" dont le contenu textuel et les informations (email, téléphone, carte) sont gérés depuis l'admin.
- **Footer Intelligent :** Affiche dynamiquement les informations de contact et les icônes de réseaux sociaux renseignées dans l'administration.
- **Design Responsive :** Interface optimisée pour une expérience parfaite sur mobile, tablette et ordinateur.

### 👑 Côté Administrateur (Dashboard)
- **Tableau de Bord "Business Intelligence" :**
    - Statistiques clés (visites, visiteurs uniques, nombre de ressources).
    - **Graphique d'activité** montrant l'évolution des visites sur les 7 derniers jours.
    - **Graphique circulaire** montrant la répartition des types de ressources (Cours, TD, Vidéos).
    - Liste des **5 pages les plus populaires** du site.
- **Design Moderne et Personnalisable :**
    - Interface inspirée des meilleurs templates de dashboards modernes (Thème sombre "Rocker").
    - **Thème personnalisable :** L'administrateur peut changer toutes les couleurs principales du dashboard depuis les paramètres.
    - **Mode Jour/Nuit** avec sauvegarde des préférences de l'utilisateur.
- **Gestion Complète des Ressources (CRUD) :**
    - Ajout, modification et suppression de fichiers (Cours, TD) ou de liens (Vidéos).
- **Gestion Complète des Utilisateurs :**
    - Ajout et suppression de comptes administrateurs.
    - Modification de l'identifiant et **réinitialisation du mot de passe**.
    - Sécurité renforcée : un admin ne peut pas se supprimer lui-même, et le **Super Admin (ID 1) est protégé**.
    - Gestion des **photos de profil** pour chaque administrateur.
- **Gestion du Contenu et de l'Apparence :**
    - Édition du contenu des pages "À Propos" et "Club MIO" via un éditeur de texte riche (WYSIWYG TinyMCE).
    - Modification des images du slider de la page d'accueil.
    - Modification des images de fond pour chaque niveau de licence (L1, L2, L3).
- **Notifications :**
    - Une cloche de notification informe l'admin de l'ajout de nouvelles ressources.
    - Système de "marquage comme lu" automatique.
- **Interface Ergonomique :**
    - Barre latérale pliable pour maximiser l'espace de travail.
    - Menus déroulants intelligents qui restent ouverts sur la section active.

## Technologies Utilisées

- **Backend :** PHP 8, PDO pour les interactions avec la base de données.
- **Base de données :** MySQL / MariaDB.
- **Frontend :** HTML5, CSS3 (avec variables CSS pour le theming), Bootstrap 5, JavaScript.
- **Serveur local :** XAMPP.
- **Librairies JS :**
    - **Chart.js :** Pour les graphiques dynamiques.
    - **TinyMCE :** Pour l'éditeur de texte riche.
    - **DataTables :** Pour les tableaux interactifs (non implémenté dans la version finale, mais prévu).

## Installation

Suivez ces étapes pour lancer le projet sur votre machine locale.

### Prérequis
- Un serveur web local comme [XAMPP](https://www.apachefriends.org/fr/index.html).

### Étapes
1.  **Placer les Fichiers :**
    Copiez le dossier `mio-ressources` dans le répertoire `htdocs` de votre installation XAMPP.

2.  **Démarrer les Services :**
    Lancez le panneau de contrôle XAMPP et démarrez les services **Apache** et **MySQL**.

3.  **Base de Données :**
    - Allez sur `http://localhost/phpmyadmin/`.
    - Créez une nouvelle base de données nommée `mio_db`.
    - Sélectionnez `mio_db`, allez dans l'onglet **SQL** et exécutez le script SQL complet fourni pour créer toutes les tables et les données initiales.

4.  **Dossiers d'Upload :**
    - Dans `mio-ressources/uploads/`, créez les dossiers suivants : `backgrounds`, `profiles`, et `slider`.
    - Placez-y les images par défaut (ex: `slider_default_1.jpg`) pour éviter les erreurs d'affichage au premier lancement.

5.  **Lancer le Site :**
    - **Site Public :** `http://localhost/mio-ressources/`
    - **Administration :** `http://localhost/mio-ressources/admin/`

## Accès Administrateur

Les identifiants par défaut du Super Administrateur sont :
- **Identifiant :** `admin`
- **Mot de passe :** `admin123`

---
_Ce projet représente un parcours de développement complet, allant de la conception à la réalisation d'une application web dynamique et entièrement fonctionnelle. Un grand merci pour cette collaboration instructive._