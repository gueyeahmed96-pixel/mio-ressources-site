<?php
require_once 'auth_admin.php';
require_once '../../includes/db.php';

$id_to_delete = (int)$_GET['id'];
if ($id_to_delete == $_SESSION['admin_id']) { $_SESSION['error_message'] = "Action impossible : vous ne pouvez pas vous supprimer."; header('Location: list-admins.php'); exit(); }
$count_query = $pdo->query("SELECT COUNT(*) FROM utilisateurs");
if ($count_query->fetchColumn() <= 1) { $_SESSION['error_message'] = "Action impossible : impossible de supprimer le dernier admin."; header('Location: list-admins.php'); exit(); }

try {
    $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?")->execute([$id_to_delete]);
    $_SESSION['success_message'] = "Admin supprimé.";
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la suppression.";
}
header('Location: list-admins.php');
exit();