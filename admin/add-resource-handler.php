<?php
// Fichier : /admin/add-resource-handler.php
// Traite le formulaire d'ajout de ressource.

// On inclut le garde du corps et la connexion BDD
require_once 'auth_admin.php';
require_once '../includes/db.php';

// On démarre la session pour pouvoir stocker les messages de succès/erreur
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On vérifie que le formulaire a été soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- 1. RÉCUPÉRATION ET VALIDATION DES DONNÉES ---
    $nom = trim($_POST['nom']);
    $matiere_id = (int)$_POST['matiere_id'];
    $type = $_POST['type'];
    $lien_video = trim($_POST['lien_video']);
    
    // Validation simple : on vérifie que les champs obligatoires ne sont pas vides
    if (empty($nom) || empty($matiere_id) || empty($type)) {
        $_SESSION['error_message'] = "Erreur : Tous les champs marqués d'un * sont obligatoires.";
        header('Location: add-resource.php');
        exit();
    }

    $allowedTypes = ['pdf', 'docx', 'jpg', 'png']; // Ligne 30
    $fileExtension = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
     // Ligne 31
    if (!in_array($fileExtension, $allowedTypes)) { // Ligne 32
    $_SESSION['error_message'] = "Type de fichier non autorisé."; // Ligne 33
    header('Location: add-resource.php'); // Ligne 34
    exit(); // Ligne 35
}


    $chemin_fichier = ''; // On initialise la variable

    // --- 2. GESTION DE LA RESSOURCE (FICHIER OU LIEN) ---
    
    // Cas 1 : La ressource est une vidéo
    if ($type === 'Vidéo') {
        if (empty($lien_video) || !filter_var($lien_video, FILTER_VALIDATE_URL)) {
            $_SESSION['error_message'] = "Pour une vidéo, veuillez fournir un lien URL valide.";
            header('Location: add-resource.php');
            exit();
        }
        $chemin_fichier = $lien_video; // Pour une vidéo, le "chemin" est simplement le lien.

    // Cas 2 : La ressource est un fichier à uploader
    } else {
        // On vérifie si un fichier a bien été envoyé et s'il n'y a pas d'erreur
        if (!isset($_FILES['fichier']) || $_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['error_message'] = "Erreur lors de l'upload du fichier. Veuillez réessayer.";
            header('Location: add-resource.php');
            exit();
        }

        $file = $_FILES['fichier'];
        $upload_dir = '../uploads/'; // Le dossier où stocker les fichiers
        
        // Sécurité : On génère un nom de fichier unique pour éviter les conflits et les problèmes de sécurité.
        // On garde l'extension originale du fichier.
        $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        // On crée un nom unique basé sur le temps actuel + un nombre aléatoire.
        $unique_filename = uniqid('mio_', true) . '.' . $file_extension;
        $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)"; // Ligne 70
        $query = $pdo->prepare($sql); // Ligne 71
        $query->execute([$_SESSION['admin_id'], "Nouvelle ressource ajoutée : $nom"]); // Ligne 72 
       
        $destination_path = $upload_dir . $unique_filename;
        // On déplace le fichier temporaire vers sa destination finale
        if (move_uploaded_file($file['tmp_name'], $destination_path)) {
            // Si le déplacement réussit, on stocke le nom unique du fichier.
            $chemin_fichier = $unique_filename;
        } else {
            $sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)"; // Ligne 80
$query = $pdo->prepare($sql); // Ligne 81
$query->execute([$_SESSION['admin_id'], "Ressource modifiée : $nom"]); // Ligne 82
            // Si le déplacement échoue, c'est souvent un problème de permissions sur le dossier 'uploads'.
            $_SESSION['error_message'] = "Erreur critique : Impossible de déplacer le fichier uploadé.";
            header('Location: add-resource.php');
            exit();
        }
    }

    // --- 3. INSERTION DANS LA BASE DE DONNÉES ---
    
    // Si on a bien un chemin (de fichier ou de lien), on peut insérer.
    if (!empty($chemin_fichier)) {
        try {
            $sql = "INSERT INTO ressources (nom, type, chemin_fichier, matiere_id) VALUES (?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute([$nom, $type, $chemin_fichier, $matiere_id]);
             // On crée la notification associée
            $message = "Nouvelle ressource ajoutée : '" . htmlspecialchars($nom) . "'";
            $link = "list-resources.php"; // Lien vers la page des ressources
            $notif_sql = "INSERT INTO notifications (message, link) VALUES (?, ?)";
            $notif_query = $pdo->prepare($notif_sql);
            $notif_query->execute([$message, $link]);

            // Si tout s'est bien passé, on crée un message de succès.
            $_SESSION['success_message'] = "La ressource '" . htmlspecialchars($nom) . "' a été ajoutée avec succès !";
            header('Location: add-resource.php'); // On redirige vers la même page pour pouvoir en ajouter une autre.
            exit();

        } catch (PDOException $e) {
            // En cas d'erreur avec la base de données
            $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
            header('Location: add-resource.php');
            exit();
        }
    } else {
        // Ce cas ne devrait pas arriver si la logique est bonne, mais c'est une sécurité.
        $_SESSION['error_message'] = "Une erreur inconnue est survenue.";
        header('Location: add-resource.php');
        exit();
    }

} else {
    // Si la page est accédée directement, on redirige.
    header('Location: index.php');
    exit();
}
?>