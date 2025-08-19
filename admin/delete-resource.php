<?php
// Fichier : /admin/delete-resource.php
// Gère la suppression d'une ressource.

// On inclut nos fichiers de sécurité et de base de données
require_once 'auth_admin.php';
require_once '../includes/db.php';

// On démarre la session pour les messages flash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Valider l'ID de la ressource
// On s'attend à recevoir l'ID via la méthode GET (ex: delete-resource.php?id=12)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    // Si l'ID est invalide ou manquant, on renvoie une erreur.
    $_SESSION['error_message'] = "Erreur : ID de ressource invalide.";
    header('Location: list-resources.php');
    exit();
}

try {
    // 2. Récupérer les informations de la ressource AVANT de la supprimer
    // On a besoin du nom du fichier pour pouvoir le supprimer du disque dur.
    $query = $pdo->prepare("SELECT chemin_fichier, type FROM ressources WHERE id = ?");
    $query->execute([$id]);
    $ressource = $query->fetch();

    if ($ressource) {
        // 3. Supprimer le fichier physique s'il ne s'agit pas d'une vidéo
        if ($ressource['type'] !== 'Vidéo') {
            $file_path = '../uploads/' . $ressource['chemin_fichier'];
            // On vérifie que le fichier existe avant d'essayer de le supprimer
            if (file_exists($file_path)) {
                unlink($file_path); // unlink() est la fonction PHP pour supprimer un fichier
            }
        }

        // 4. Supprimer l'enregistrement de la ressource dans la base de données
        $delete_query = $pdo->prepare("DELETE FROM ressources WHERE id = ?");
        $delete_query->execute([$id]);

        // 5. Créer un message de succès et rediriger
        $_SESSION['success_message'] = "La ressource a été supprimée avec succès.";
        header('Location: list-resources.php');
        exit();

    } else {
        // Si la ressource avec cet ID n'existe pas dans la BDD
        $_SESSION['error_message'] = "La ressource que vous essayez de supprimer n'existe pas.";
        header('Location: list-resources.php');
        exit();
    }

} catch (PDOException $e) {
    // En cas d'erreur de base de données
    $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
    header('Location: list-resources.php');
    exit();
}
?>