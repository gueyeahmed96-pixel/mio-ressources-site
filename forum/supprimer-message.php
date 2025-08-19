<?php
require_once '../includes/auth_config.php';
if (!$auth->isLogged()) { header('Location: /mio-ressources/pages/connexion.php'); exit(); }

$message_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$uid = $auth->getCurrentUID();

if ($message_id > 0) {
    // On récupère l'ID du sujet pour pouvoir y retourner
    $sujet_query = $pdo->prepare("SELECT sujet_id FROM forum_messages WHERE id = ? AND auteur_id = ?");
    $sujet_query->execute([$message_id, $uid]);
    $sujet_id = $sujet_query->fetchColumn();

    if ($sujet_id) {
        // On supprime le message
        $delete = $pdo->prepare("DELETE FROM forum_messages WHERE id = ? AND auteur_id = ?");
        $delete->execute([$message_id, $uid]);
        header('Location: sujet.php?id=' . $sujet_id);
        exit();
    }
}
// Si l'ID est invalide ou n'appartient pas à l'utilisateur, on le renvoie à l'accueil du forum
header('Location: index.php');
exit();