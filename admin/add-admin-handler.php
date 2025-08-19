<?php
require_once '../auth.php';
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant']); $mot_de_passe = trim($_POST['mot_de_passe']);
    if (empty($identifiant) || empty($mot_de_passe)) { $_SESSION['error_message'] = "Champs obligatoires."; header('Location: add-admin.php'); exit(); }
    $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    try {
        $pdo->prepare("INSERT INTO utilisateurs (identifiant, mot_de_passe) VALUES (?, ?)")->execute([$identifiant, $hashed_password]);
        $_SESSION['success_message'] = "Admin ajouté."; header('Location: list-admins.php'); exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { $_SESSION['error_message'] = "Cet identifiant existe déjà."; } else { $_SESSION['error_message'] = "Erreur BDD."; }
        header('Location: add-admin.php'); exit();
    }
}