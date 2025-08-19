<?php
require_once '../includes/header.php';
$message_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// Sécurité : vérifier que l'utilisateur est connecté
if (!$is_student_logged_in) { header('Location: /mio-ressources/pages/connexion.php'); exit(); }

// Récupérer le message et vérifier que l'utilisateur en est bien l'auteur
$uid = $auth->getCurrentUID();
$query = $pdo->prepare("SELECT * FROM forum_messages WHERE id = ? AND auteur_id = ?");
$query->execute([$message_id, $uid]);
$message = $query->fetch();

// Si le message n'existe pas ou n'appartient pas à l'utilisateur, on le renvoie
if (!$message) { header('Location: index.php'); exit(); }

$pageTitle = "Modifier mon message";
?>
<main class="container py-5">
    <h1 class="mb-4">Modifier mon message</h1>
    <div class="card shadow-sm"><div class="card-body p-4">
        <?= show_auth_messages(); ?>
        <form action="modifier-message-handler.php" method="POST">
            <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
            <input type="hidden" name="sujet_id" value="<?= $message['sujet_id'] ?>">
            <div class="mb-3">
                <textarea class="form-control" name="contenu" rows="10" required><?= htmlspecialchars($message['contenu']) ?></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <a href="sujet.php?id=<?= $message['sujet_id'] ?>" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div></div>
</main>
<?php require_once '../includes/footer.php'; ?>