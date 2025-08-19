<?php
// Fichier : /includes/tracker.php
// Ce script enregistre une visite dans la base de données.

// On s'assure que la connexion BDD est disponible
// Le @ ignore l'erreur si le fichier a déjà été inclus ailleurs (peu probable ici).
@require_once __DIR__ . '/db.php';

// On ne fait rien si la connexion BDD n'a pas fonctionné.
if (isset($pdo)) {
    try {
        // On récupère les informations de la visite
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $page_visited = $_SERVER['REQUEST_URI'];

        // Pour éviter de surcharger la BDD, on peut décider de ne pas tracker
        // les visites sur les fichiers CSS, JS, etc. (optionnel mais bonne pratique).
        $extension = pathinfo($page_visited, PATHINFO_EXTENSION);
        if (in_array($extension, ['css', 'js', 'jpg', 'png', 'svg'])) {
            return; // On arrête le script si c'est un fichier de ressource
        }

        // On insère la visite dans la BDD
        $sql = "INSERT INTO visites (ip_address, page_visited) VALUES (?, ?)";
        $query = $pdo->prepare($sql);
        $query->execute([$ip_address, $page_visited]);

    } catch (PDOException $e) {
        // En cas d'erreur, on ne fait rien pour ne pas planter le site public.
        // On pourrait enregistrer l'erreur dans un fichier de log si nécessaire.
        // error_log('Tracker Error: ' . $e->getMessage());
    }
}