<?php
// Fichier : /admin/edit-page-handler.php
// Traite le formulaire de modification de page.

require_once 'auth.php';
require_once '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On vérifie que le formulaire a bien été soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- 1. RÉCUPÉRATION ET VALIDATION DES DONNÉES ---
    $slug = trim($_POST['slug']);
    $titre = trim($_POST['titre']);
    // Le contenu de TinyMCE peut contenir des balises HTML, c'est normal.
    // Nous n'utilisons PAS htmlspecialchars() ici car nous voulons sauvegarder le HTML.
    $contenu = $_POST['contenu'];

    // Validation simple
    if (empty($slug) || empty($titre)) {
        $_SESSION['error_message'] = "Erreur : Le titre de la page est obligatoire.";
        // On redirige vers la page d'édition de la page concernée
        header('Location: edit-page.php?slug=' . urlencode($slug));
        exit();
    }

    // --- 2. MISE À JOUR DANS LA BASE DE DONNÉES ---
    try {
        // On prépare une requête UPDATE pour la table 'pages'
        // On met à jour les colonnes 'titre' et 'contenu' pour la ligne qui a le bon 'slug'
        $sql = "UPDATE pages SET titre = ?, contenu = ? WHERE slug = ?";
        $query = $pdo->prepare($sql);
        
        // On exécute la requête avec les nouvelles données
        $query->execute([$titre, $contenu, $slug]);
        
        // On crée un message de succès
        $_SESSION['success_message'] = "La page '" . htmlspecialchars($titre) . "' a été mise à jour avec succès.";
        header('Location: edit-page.php?slug=' . urlencode($slug));
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur avec la base de données
        $_SESSION['error_message'] = "Erreur de base de données : " . $e->getMessage();
        header('Location: edit-page.php?slug=' . urlencode($slug));
        exit();
    }

} else {
    // Si la page est accédée directement, on redirige vers le tableau de bord
    header('Location: index.php');
    exit();
}
?>