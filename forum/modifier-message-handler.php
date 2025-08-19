<?php
require_once '../includes/auth_config.php';
if (!$auth->isLogged()) { header('Location: /mio-ressources/pages/connexion.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message_id = (int)$_POST['message_id'];
    $sujet_id = (int)$_POST['sujet_id'];
    $contenu = trim($_POST['contenu']);
    $uid = $auth->getCurrentUID();

    if (empty($contenu)) { header('Location: modifier-message.php?id=' . $message_id); exit(); }

    // Double sécurité : on vérifie à nouveau que le message appartient bien à l'utilisateur
    $check = $pdo->prepare("SELECT auteur_id FROM forum_messages WHERE id = ?");
    $check->execute([$message_id]);
    if ($check->fetchColumn() == $uid) {
        $update = $pdo->prepare("UPDATE forum_messages SET contenu = ? WHERE id = ?");
        $update->execute([$contenu, $message_id]);
    }
    
    header('Location: sujet.php?id=' . $sujet_id);
    exit();
}