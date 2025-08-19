<?php
require_once '../includes/db.php'; require_once 'auth_admin.php';
$sujet_id = (int)$_GET['id'];
if ($sujet_id > 0) {
    // On inverse la valeur actuelle avec une astuce SQL
    $pdo->prepare("UPDATE forum_sujets SET est_epingle = 1 - est_epingle WHERE id = ?")->execute([$sujet_id]);
}
// On redirige l'utilisateur vers la page d'où il venait
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();