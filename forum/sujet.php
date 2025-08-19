<?php
require_once '../includes/header.php';
// ... (logique PHP du haut, inchangée)
$sujet_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// ON AJOUTE L'INCRÉMENTATION DES VUES
$pdo->prepare("UPDATE forum_sujets SET nombre_vues = nombre_vues + 1 WHERE id = ?")->execute([$sujet_id]);
// On récupère le rôle de chaque auteur
$sql_messages = "SELECT m.contenu, m.date_post, u.username, u.photo_profil, u.role FROM forum_messages m JOIN phpauth_users u ON m.auteur_id = u.id WHERE m.sujet_id = ? ORDER BY m.date_post ASC";
$query_messages = $pdo->prepare($sql_messages); $query_messages->execute([$sujet_id]); $messages = $query_messages->fetchAll();
// ...
?>
<div class="forum-container">
<main class="container">
    <!-- ... (fil d'ariane et titre, inchangés) ... -->
    <?php foreach ($messages as $index => $message): ?>
    <div class="card post-card mb-3">
        <div class="row g-0">
            <div class="col-md-2 text-center p-3 post-author-info">
                <?php if (!empty($message['photo_profil'])): $avatar = '/mio-ressources/uploads/profiles/' . htmlspecialchars($message['photo_profil']); else: $avatar = "https://ui-avatars.com/api/?name=" . urlencode($message['username']) . "&background=random&color=fff&bold=true"; endif; ?>
                <img src="<?= $avatar ?>" alt="avatar" class="img-fluid rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                <h5 class="username mb-1"><?= htmlspecialchars($message['username']) ?></h5>
                <span class="user-role <?= htmlspecialchars($message['role']) ?>"><?= htmlspecialchars(ucfirst($message['role'])) ?></span>
            </div>
            <div class="col-md-10">
                <div class="card-body post-content"><p><?= nl2br(htmlspecialchars($message['contenu'])) ?></p></div>
                <div class="card-footer small d-flex justify-content-between align-items-center"><span>Posté le <?= date('d/m/Y à H:i', strtotime($message['date_post'])) ?></span></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <!-- ... (formulaire de réponse, inchangé) ... -->
</main>
</div>
<?php require_once '../includes/footer.php'; ?>