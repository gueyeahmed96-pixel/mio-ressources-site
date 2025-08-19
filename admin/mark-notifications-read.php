<?php
// Fichier: /admin/mark-notifications-read.php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/db.php';

// On met à jour toutes les notifications non lues
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->query("UPDATE notifications SET is_read = 1 WHERE is_read = 0");
    // On renvoie une réponse de succès (optionnel)
    echo json_encode(['status' => 'success']);
}