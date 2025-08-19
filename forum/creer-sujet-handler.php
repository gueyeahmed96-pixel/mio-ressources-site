<?php
// Fichier : /forum/creer-sujet-handler.php

require_once '../includes/auth_config.php';

// --- SÉCURITÉ : Vérifier si l'utilisateur est connecté ---
if (!$auth->isLogged()) {
    $_SESSION['error_message'] = "Action non autorisée.";
    header('Location: /mio-ressources/pages/connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupérer et valider les données
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $categorie_id = (int)$_POST['categorie_id'];
    
    if (empty($titre) || empty($contenu) || $categorie_id === 0) {
        $_SESSION['error_message'] = "Veuillez remplir tous les champs.";
        header('Location: creer-sujet.php?cat_id=' . $categorie_id);
        exit();
    }

    // Récupérer l'ID de l'utilisateur connecté
    $auteur_id = $auth->getCurrentUID();

    // 2. Traitement en Transaction (pour la sécurité des données)
    try {
        // On démarre la transaction
        $pdo->beginTransaction();

        // Étape A : Insérer le nouveau sujet dans la table `forum_sujets`
        $sql_sujet = "INSERT INTO forum_sujets (titre, categorie_id, auteur_id) VALUES (?, ?, ?)";
        $query_sujet = $pdo->prepare($sql_sujet);
        $query_sujet->execute([$titre, $categorie_id, $auteur_id]);
        
        // On récupère l'ID du sujet que l'on vient de créer
        $nouveau_sujet_id = $pdo->lastInsertId();

        // Étape B : Insérer le premier message dans la table `forum_messages`
        $sql_message = "INSERT INTO forum_messages (sujet_id, auteur_id, contenu) VALUES (?, ?, ?)";
        $query_message = $pdo->prepare($sql_message);
        $query_message->execute([$nouveau_sujet_id, $auteur_id, $contenu]);

        // Si tout s'est bien passé, on valide la transaction
        $pdo->commit();
        
        // 3. Redirection vers le nouveau sujet
        header('Location: sujet.php?id=' . $nouveau_sujet_id);
        exit();

    } catch (PDOException $e) {
        // En cas d'erreur, on annule tout ce qui a été fait
        $pdo->rollBack();
        
        $_SESSION['error_message'] = "Une erreur est survenue lors de la création du sujet. " . $e->getMessage();
        header('Location: creer-sujet.php?cat_id=' . $categorie_id);
        exit();
    }
}