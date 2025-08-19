<?php
require_once '../includes/header.php';
// ... (logique PHP du haut, inchangée)
$categorie_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
// ...
$sql_sujets = "SELECT suj.id, suj.titre, suj.date_creation, suj.est_epingle, suj.nombre_vues, aut.username AS nom_utilisateur, aut.photo_profil AS avatar_path, COUNT(mes.id) AS nombre_reponses FROM forum_sujets AS suj JOIN phpauth_users AS aut ON suj.auteur_id = aut.id LEFT JOIN forum_messages AS mes ON suj.id = mes.sujet_id WHERE suj.categorie_id = ? GROUP BY suj.id ORDER BY suj.est_epingle DESC, suj.date_creation DESC";
$query_sujets = $pdo->prepare($sql_sujets); $query_sujets->execute([$categorie_id]); $sujets = $query_sujets->fetchAll(PDO::FETCH_ASSOC);
// ...
?>
<div class="forum-container">
<main class="container">
    <!-- ... (fil d'ariane et titre, inchangés) ... -->
    <div class="list-group">
        <?php foreach ($sujets as $sujet): ?>
        <a href="sujet.php?id=<?= $sujet['id'] ?>" class="list-group-item list-group-item-action bg-transparent border-secondary p-3 mb-2 rounded">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex align-items-center">
                    <?php if (!empty($sujet['avatar_path'])): $avatar = '/mio-ressources/uploads/profiles/' . htmlspecialchars($sujet['avatar_path']); else: $avatar = "https://ui-avatars.com/api/?name=" . urlencode($sujet['nom_utilisateur']) . "&background=random&color=fff"; endif; ?>
                    <img src="<?= $avatar ?>" alt="avatar" class="rounded-circle me-3" width="50" height="50" style="object-fit:cover;">
                    <div><h5 class="mb-1 text-white"><?php if ($sujet['est_epingle']): ?><i class="bi bi-pin-angle-fill text-warning" title="Épinglé"></i> <?php endif; ?><?= htmlspecialchars($sujet['titre']) ?></h5><small>Par <?= htmlspecialchars($sujet['nom_utilisateur']) ?> le <?= date('d/m/Y', strtotime($sujet['date_creation'])) ?></small></div>
                </div>
                <div class="col-md-2 text-center small"><i class="bi bi-chat-left-dots me-1"></i> <?= $sujet['nombre_reponses'] ?> réponses</div>
                <div class="col-md-2 text-center small"><i class="bi bi-eye me-1"></i> <?= $sujet['nombre_vues'] ?> vues</div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>
</div>
<?php require_once '../includes/footer.php'; ?>