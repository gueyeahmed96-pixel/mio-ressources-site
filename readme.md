
# Présentation du Projet : MIO-Ressources

## Concept Général

MIO-Ressources est une plateforme web dynamique, conçue pour les étudiants de la filière Management Informatisé des Organisations (MIO) de l'Université Iba Der Thiam de Thiès. Elle vise à :
- Faciliter l'accès aux supports de cours.
- Construire une communauté d'entraide entre étudiants et professeurs.

Le projet a évolué d'une simple bibliothèque de ressources vers un portail communautaire riche en fonctionnalités, entièrement administrable via un tableau de bord moderne.

---

## Fonctionnalités Clés

La plateforme se divise en deux espaces distincts :

### I. Espace Public (Étudiants & Visiteurs)

- **Accueil Dynamique :**
	- Slider d'images administrable (actualités, messages de bienvenue).
	- Grille des semestres (L1, L2, L3) avec images personnalisables.
	- Section "Dernières Discussions" du forum.

- **Authentification Sécurisée :**
	- Inscription et connexion pour étudiants et professeurs.
	- Récupération de mot de passe (simulée en local, fonctionnelle en production).
	- Profils personnalisables (photo, informations).

- **Bibliothèque de Ressources :**
	- Navigation par semestre et matière.
	- Affichage clair des ressources (Cours, TD, Vidéos).
	- Options "Voir" (consultation rapide) et "Télécharger".

- **Forum Communautaire :**
	- Discussions par catégories (niveau, matière, général).
	- Création/réponse aux sujets pour les membres connectés.
	- Identification des rôles (Étudiant, Professeur, Admin).
	- Modification/suppression de ses propres messages.

- **Pages Dynamiques :**
	- Pages "À Propos" et "Club MIO" éditables depuis l'administration.

---

### II. Espace d'Administration (Dashboard)

- **Design Moderne :**
	- Thème sombre par défaut ("Rocker").
	- Sélecteur de thème pour personnaliser les couleurs.

- **Analyse de Données :**
	- Statistiques clés (visites, ressources, matières).
	- Graphiques d'activité (trafic, répartition des ressources).
	- Tableau des pages les plus populaires.

- **Gestion du Contenu (CMS) :**
	- CRUD sur les ressources.
	- Gestion de l'apparence (slider, fonds, logo).
	- Édition des pages statiques.

- **Modération & Communauté :**
	- Gestion des utilisateurs (modification, changement de rôle, bannissement).
	- Gestion du forum (catégories, épinglage, modération).
	- Notifications en temps réel pour l'administrateur.

---

## Architecture Technique & Sécurité

- **Backend :** PHP 8 (POO), PDO pour la base de données.
- **Base de Données :** MySQL/MariaDB (structure relationnelle, clés étrangères).
- **Frontend :** Bootstrap 5, CSS personnalisé, JavaScript.
- **Sécurité :**
	- Mots de passe hachés (Argon2/Bcrypt via PHPAuth).
	- Protection contre l'injection SQL (requêtes préparées).
	- Protection XSS (htmlspecialchars).
	- Contrôle d'accès strict (pages admin).
	- Gestion sécurisée des uploads.
- **Dépendances :** Composer, PHPAuth pour l'authentification.

---

