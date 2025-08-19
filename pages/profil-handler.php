<?php
// Fichier : /pages/profil-handler.php (Version corrigée)
require_once '../includes/auth_config.php';

// Sécurité : si l'utilisateur n'est pas connecté, on arrête tout
if (!$auth->isLogged()) {
    header('Location: connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $auth->getCurrentUID();
    $user_data = $auth->getUser($uid);

    // --- 1. Mettre à jour le mot de passe ---
    // On ne le fait que si les 3 champs de mot de passe sont remplis
    if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        $result_pass = $auth->changePassword($uid, $_POST['current_password'], $_POST['new_password'], $_POST['confirm_password']);
        handle_auth_result($result_pass);
    }
    
    // --- 2. Mettre à jour le nom d'utilisateur ---
    $new_username = trim($_POST['username']);
    if ($new_username != $user_data['username'] && !empty($new_username)) {
        try {
            // On vérifie d'abord que le nouveau nom d'utilisateur n'est pas déjà pris
            $check_user = $pdo->prepare("SELECT COUNT(*) FROM phpauth_users WHERE username = ? AND id != ?");
            $check_user->execute([$new_username, $uid]);
            if ($check_user->fetchColumn() > 0) {
                $_SESSION['error_message'] = "Ce nom d'utilisateur est déjà pris.";
            } else {
                // S'il est libre, on met à jour
                $update_user = $pdo->prepare("UPDATE phpauth_users SET username = ? WHERE id = ?");
                $update_user->execute([$new_username, $uid]);
                $_SESSION['success_message'] = "Nom d'utilisateur mis à jour.";
            }
        } catch(PDOException $e) {
             $_SESSION['error_message'] = "Erreur lors de la mise à jour du nom d'utilisateur.";
        }
    }
    
    // --- 3. Mettre à jour la photo de profil ---
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
        
        // On supprime l'ancienne photo s'il y en a une
        if ($user_data['photo_profil'] && file_exists($upload_dir . $user_data['photo_profil'])) {
            unlink($upload_dir . $user_data['photo_profil']);
        }

        $file = $_FILES['photo'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $allowed_ext)) {
            $filename = 'user_' . $uid . '_' . time() . '.' . $extension;
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
                $pdo->prepare("UPDATE phpauth_users SET photo_profil = ? WHERE id = ?")->execute([$filename, $uid]);
                if(!isset($_SESSION['success_message'])) { $_SESSION['success_message'] = "Photo de profil mise à jour."; }
            } else {
                $_SESSION['error_message'] = "Erreur lors de l'upload de la photo.";
            }
        } else {
            $_SESSION['error_message'] = "Format de fichier non autorisé pour la photo.";
        }
    }
    
    header('Location: profil.php');
    exit();
}