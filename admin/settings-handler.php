<?php
// Fichier : /admin/settings-handler.php

require_once 'auth.php';
require_once '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $upload_dir = '../uploads/backgrounds/';
        if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }

        foreach ($_FILES as $input_name => $file) {
            if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
                $query_old = $pdo->prepare("SELECT valeur_param FROM parametres WHERE nom_param = ?");
                $query_old->execute([$input_name]);
                $old_image_name = $query_old->fetchColumn();
                if ($old_image_name && file_exists($upload_dir . $old_image_name) && strpos($old_image_name, '_default') === false) {
                    unlink($upload_dir . $old_image_name);
                }
                
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = $input_name . '_' . time() . '.' . $extension;
                
                if (move_uploaded_file($file['tmp_name'], $upload_dir . $new_filename)) {
                    $_POST[$input_name] = $new_filename;
                }
            }
        }
        
        $sql = "INSERT INTO parametres (nom_param, valeur_param) VALUES (:nom, :valeur) ON DUPLICATE KEY UPDATE valeur_param = :valeur";
        $query = $pdo->prepare($sql);
        
        foreach ($_POST as $nom => $valeur) {
            $query->execute(['nom' => $nom, 'valeur' => trim($valeur)]);
        }

        $_SESSION['success_message'] = "Les paramètres ont été mis à jour avec succès.";
        header('Location: settings.php');
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
        header('Location: settings.php');
        exit();
    }
}
?>