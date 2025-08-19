<?php
// Fichier : /admin/edit-admin-handler.php (Version finale avec suppression de photo)
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $identifiant = trim($_POST['identifiant']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $delete_photo = isset($_POST['delete_photo']); // Vrai si la case est cochée, faux sinon

    if (empty($identifiant) || $id === 0) {
        $_SESSION['error_message'] = "L'identifiant est obligatoire.";
        header('Location: edit-admin.php?id=' . $id);
        exit();
    }

    $sql_parts = ["identifiant = ?"];
    $params = [$identifiant];
    
    // --- NOUVELLE LOGIQUE DE GESTION DE LA PHOTO ---

    // Cas 1 : Une nouvelle photo est uploadée (prioritaire)
    if (isset($_FILES['photo_profil']) && $_FILES['photo_profil']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        
        $old_photo_query = $pdo->prepare("SELECT photo_profil FROM utilisateurs WHERE id = ?");
        $old_photo_query->execute([$id]);
        $old_photo = $old_photo_query->fetchColumn();
        if ($old_photo && file_exists($upload_dir . $old_photo)) {
            unlink($upload_dir . $old_photo);
        }

        $file = $_FILES['photo_profil'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $new_photo_name = 'user_' . $id . '_' . time() . '.' . $extension;
        move_uploaded_file($file['tmp_name'], $upload_dir . $new_photo_name);
        
        $sql_parts[] = "photo_profil = ?";
        $params[] = $new_photo_name;
    } 
    // Cas 2 : La case "Supprimer" est cochée ET aucune nouvelle photo n'est envoyée
    elseif ($delete_photo) {
        $upload_dir = '../uploads/profiles/';
        
        $old_photo_query = $pdo->prepare("SELECT photo_profil FROM utilisateurs WHERE id = ?");
        $old_photo_query->execute([$id]);
        $old_photo = $old_photo_query->fetchColumn();
        if ($old_photo && file_exists($upload_dir . $old_photo)) {
            unlink($upload_dir . $old_photo);
        }

        $sql_parts[] = "photo_profil = ?";
        $params[] = null; // On met la valeur à NULL dans la base de données
    }

    // --- MISE À JOUR MOT DE PASSE (inchangé) ---
    if (!empty($mot_de_passe)) {
        $sql_parts[] = "mot_de_passe = ?";
        $params[] = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    }
    
    // --- EXÉCUTION DE LA REQUÊTE ---
    $params[] = $id;
    $sql = "UPDATE utilisateurs SET " . implode(', ', $sql_parts) . " WHERE id = ?";
    
    try {
        $pdo->prepare($sql)->execute($params);
        $_SESSION['success_message'] = "Le profil a été mis à jour.";
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de mise à jour.";
    }
    header('Location: edit-admin.php?id=' . $id);
    exit();
}