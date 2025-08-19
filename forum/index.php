<?php
$pageTitle = "Forum d'Entraide";
require_once '../includes/header.php';
// ... (La requête SQL reste la même)
$sql = "SELECT cat.id, cat.nom, cat.description, COUNT(DISTINCT suj.id) AS nombre_sujets, COUNT(mes.id) AS nombre_messages FROM forum_categories AS cat LEFT JOIN forum_sujets AS suj ON cat.id = suj.categorie_id LEFT JOIN forum_messages AS mes ON suj.id = mes.sujet_id GROUP BY cat.id ORDER BY cat.ordre ASC";
$categories = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="forum-container">
<main class="container">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div><h1 class="display-5 fw-bold">Forum d'Entraide</h1><p class="lead">L'espace d'échange pour tous les étudiants de la filière MIO.</p></div>
        <div><a href="creer-sujet.php" class="btn btn-primary btn-lg"><i class="bi bi-plus-circle me-2"></i>Nouveau Sujet</a></div>
    </div>
    <?php foreach ($categories as $categorie): ?>
    <a href="categorie.php?id=<?= $categorie['id'] ?>" class="text-decoration-none">
        <div class="card forum-card mb-3"><div class="card-body p-4">
            <div class="row align-items-center"><div class="col-md-6 d-flex align-items-center"><i class="bi bi-folder2-open fs-1 text-primary me-4"></i><div><h5 class="mb-1 fw-bold"><?= htmlspecialchars($categorie['nom']) ?></h5><p class="mb-0 text-muted"><?= htmlspecialchars($categorie['description']) ?></p></div></div>
            <div class="col-md-3 text-center"><span class="badge bg-secondary me-2"><?= $categorie['nombre_sujets'] ?></span>Sujets<br><span class="badge bg-secondary me-2"><?= $categorie['nombre_messages'] ?></span>Messages</div>
            <div class="col-md-3 text-center text-muted d-none d-md-block"><small>Dernier message<br>à venir...</small></div>
        </div></div></div>
    </a>
    <?php endforeach; ?>
</main>
</div>
<?php require_once '../includes/footer.php'; ?>