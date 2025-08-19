<?php
// Fichier : /admin/edit-resource-handler.php
// Traite le formulaire de modification de ressource.

require_once 'auth.php';
require_once '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- 1. RÉCUPÉRATION ET VALIDATION DES DONNÉES ---
    $id = (int)$_POST['id'];
    $nom = trim($_POST['nom']);
    $matiere_id = (int)$_POST['matiere_id'];
    $type = $_POST['type'];

    if (empty($id) || empty($nom) || empty($matiere_id) || empty($type)) {
        $_SESSION['error_message'] = "Erreur : Tous les champs sont obligatoires.";
        header('Location: edit-resource.php?id=' . $id);
        exit();
    }

    // --- 2. GESTION DU FICHIER (SI UN NOUVEAU EST FOURNI) ---
    $nouveau_chemin_fichier = null; // Variable pour le nouveau chemin

    // On vérifie si un nouveau fichier a été uploadé et s'il n'y a pas d'erreur
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
        
        
        
        
        $allowedTypes = ['pdf', 'docx', 'jpg', 'png']; // Ligne 40
        $fileExtension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION); // Ligne 41
       if (!in_array($fileExtension, $allowedTypes)) { // Ligne 42
           $_SESSION['error_message'] = "Type de fichier non autorisé."; // Ligne 43
           header('Location: edit-resource.php?id=' . $id); // Ligne 44
          exit(); // Ligne 45
        }
        
        // D'ABORD, on supprime l'ancien fichier pour faire de la place.
        // On récupère le chemin de l'ancien fichier depuis la BDD.
        $query_old_file = $pdo->prepare("SELECT chemin_fichier, type FROM ressources WHERE id = ?");
        $query_old_file->execute([$id]);
        $old_ressource = $query_old_file->fetch();

        if ($old_ressource && $old_ressource['type'] !== 'Vidéo') {
            $old_file_path = '../uploads/' . $old_ressource['chemin_fichier'];
            if (file_exists($old_file_path)) {
                unlink($old_file_path);
            }
        }
        
        // ENSUITE, on gère le nouvel upload (même logique que pour add-resource-handler)
        $file = $_FILES['fichier'];
        $upload_dir = '../uploads/';
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $unique_filename = uniqid('mio_', true) . '.' . $file_extension;
        $destination_path = $upload_dir . $unique_filename;

        if (move_uploaded_file($file['tmp_name'], $destination_path)) {
            $nouveau_chemin_fichier = $unique_filename;
        } else {
            $_SESSION['error_message'] = "Erreur lors du déplacement du nouveau fichier.";
            header('Location: edit-resource.php?id=' . $id);
            exit();
        }
    }

    // --- 3. PRÉPARATION ET EXÉCUTION DE LA REQUÊTE UPDATE ---
    
    try {
        // On prépare la base de la requête SQL
        $sql = "UPDATE ressources SET nom = ?, matiere_id = ?, type = ?";
        $params = [$nom, $matiere_id, $type];

        // Si un nouveau fichier a été uploadé, on ajoute la mise à jour du chemin à la requête
        if ($nouveau_chemin_fichier !== null) {
            $sql .= ", chemin_fichier = ?";
            $params[] = $nouveau_chemin_fichier;
        }

        // On termine la requête
        $sql .= " WHERE id = ?";
        $params[] = $id;

        // On exécute la requête préparée
        $query = $pdo->prepare($sql);
        $query->execute($params);
        
        $_SESSION['success_message'] = "La ressource a été modifiée avec succès.";
        header('Location: list-resources.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
        header('Location: edit-resource.php?id=' . $id);
        exit();
    }

} else {
    // Si la page est accédée directement, on redirige.
    header('Location: list-resources.php');
    exit();
}
?>