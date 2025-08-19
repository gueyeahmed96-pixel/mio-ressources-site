<?php
// Fichier : /admin/logout.php
// Ce script gère la déconnexion de l'administrateur.

// 1. On démarre la session pour pouvoir la manipuler.
session_start();

// 2. On détruit toutes les variables de la session.
// $_SESSION devient un tableau vide.
session_unset();

// 3. On détruit la session elle-même côté serveur.
session_destroy();

// 4. (Optionnel mais recommandé) On crée une nouvelle session vide
// pour y mettre un message de succès pour la page de connexion.
session_start();
$_SESSION['success_message'] = "Vous avez été déconnecté avec succès.";

// 5. On redirige l'utilisateur vers la page de connexion.
header("Location: login.php");
exit();
?>