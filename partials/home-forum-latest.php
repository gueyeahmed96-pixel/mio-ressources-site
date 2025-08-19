<?php
// Fichier : /partials/home-forum-latest.php
// Affiche les derniers sujets du forum sur la page d'accueil.
?>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Dernières Discussions</h2>
            <p class="lead text-muted">Rejoignez la conversation et partagez vos connaissances.</p>
        </div>

        <?php if (empty($derniers_sujets)): ?>
            <div class="text-center">
                <p>Le forum est encore calme... Soyez le premier à lancer une discussion !</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach($derniers_sujets as $sujet): ?>
                    <div class="col-lg-6">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body d-flex">
                                <div class="me-3">
                                    <?php if (!empty($sujet['photo_profil'])): ?>
                                        <img src="/mio-ressources/uploads/profiles/<?= htmlspecialchars($sujet['photo_profil']) ?>" alt="avatar" class="rounded-circle" width="50" height="50">
                                    <?php else: ?>
                                        <i class="bi bi-person-circle fs-2 text-secondary"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="w-100">
                                    <h5 class="card-title mb-1">
                                        <a href="/mio-ressources/forum/sujet.php?id=<?= $sujet['id'] ?>" class="text-decoration-none">
                                            <?= htmlspecialchars($sujet['titre']) ?>
                                        </a>
                                    </h5>
                                    <p class="card-text small text-muted mb-2">
                                        Par <strong><?= htmlspecialchars($sujet['username']) ?></strong> dans 
                                        <span class="badge bg-secondary"><?= htmlspecialchars($sujet['categorie_nom']) ?></span>
                                    </p>
                                    <small class="text-muted"><?= date('d F Y', strtotime($sujet['date_creation'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <a href="/mio-ressources/forum/index.php" class="btn btn-primary btn-lg">
                Explorer tout le Forum <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>