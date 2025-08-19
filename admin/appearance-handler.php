<?php
// Fichier : /admin/appearance-handler.php

require_once 'auth.php';
require_once '../includes/db.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // --- CAS 1 : MISE À JOUR D'UN SLIDE ---
    if ($_POST['action'] === 'update_slide') {
        $id = (int)$_POST['id'];
        $titre = trim($_POST['titre']);
        $description = trim($_POST['description']);
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/slider/';
            // ... (logique d'upload et de suppression de l'ancienne image du slide) ...
            $query_old = $pdo->prepare("SELECT image_path FROM slider_images WHERE id = ?");
            $query_old->execute([$id]);
            $old_image = $query_old->fetchColumn();
            if ($old_image && file_exists($upload_dir . $old_image) && strpos($old_image, '_default') === false) { unlink($upload_dir . $old_image); }

            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = 'slide_' . time() . '_' . $id . '.' . $extension;
            move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $new_filename);

            $sql = "UPDATE slider_images SET titre = ?, description = ?, image_path = ? WHERE id = ?";
            $params = [$titre, $description, $new_filename, $id];
        } else {
            $sql = "UPDATE slider_images SET titre = ?, description = ? WHERE id = ?";
            $params = [$titre, $description, $id];
        }

        $query = $pdo->prepare($sql);
        $query->execute($params);
        $_SESSION['success_message'] = "Le slide a été mis à jour.";
    }

    // --- CAS 2 : MISE À JOUR DES IMAGES DE FOND ---
    if ($_POST['action'] === 'update_backgrounds') {
        $upload_dir = '../uploads/backgrounds/';
        
        foreach ($_FILES as $input_name => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                // ... (logique d'upload et de suppression pour les images de fond) ...
                $query_old = $pdo->prepare("SELECT valeur_param FROM parametres WHERE nom_param = ?");
                $query_old->execute([$input_name]);
                $old_image = $query_old->fetchColumn();
                if ($old_image && file_exists($upload_dir . $old_image) && strpos($old_image, '_default') === false) { unlink($upload_dir . $old_image); }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = $input_name . '_' . time() . '.' . $extension;
                move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename);

                // Mettre à jour la BDD
                $sql = "UPDATE parametres SET valeur_param = ? WHERE nom_param = ?";
                $pdo->prepare($sql)->execute([$new_filename, $input_name]);
            }
        }
        $_SESSION['success_message'] = "Les images de fond ont été mises à jour.";
    }

    header('Location: manage-appearance.php');
    exit();

} else {
    // Redirection si le script est appelé de manière incorrecte
    header('Location: index.php');
    exit();
}
?>