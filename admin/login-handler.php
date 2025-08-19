<?php
// Fichier : /admin/login-handler.php (Version simple, sans PHPAuth pour la connexion)
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['mot_de_passe']);

    if (empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Tous les champs sont requis.";
        header('Location: login.php');
        exit();
    }

    try {
        // On cherche l'utilisateur dans la table de PHPAuth
        $query = $pdo->prepare("SELECT * FROM phpauth_users WHERE email = ?");
        $query->execute([$email]);
        $user = $query->fetch();

        // On vérifie que l'utilisateur existe ET que le mot de passe correspond
        if ($user && password_verify($password, $user['password'])) {
            // Pour l'instant, on suppose que tout utilisateur dans cette table est un admin.
            // On pourrait ajouter une vérification de rôle ici plus tard.
            
            // On crée NOTRE propre session admin
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_identifiant'] = $user['username'] ?? $user['email'];
            
            header('Location: index.php');
            exit();
        } else {
            $_SESSION['error_message'] = "Adresse email ou mot de passe incorrect.";
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données.";
        header('Location: login.php');
        exit();
    }
}
?>