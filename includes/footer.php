<?php
// Fichier : /includes/footer.php (Version finale et complète avec JS)

@require_once __DIR__ . '/db.php';

$params = [];
if (isset($pdo)) {
    $query = $pdo->query("SELECT nom_param, valeur_param FROM parametres");
    $params = $query->fetchAll(PDO::FETCH_KEY_PAIR);
}
?>
    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <!-- ... (tout le code HTML du footer, qui est correct) ... -->
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">MIO Ressources</h5><p>Plateforme d'entraide pour les étudiants de la filière MIO de l'Université Iba Der Thiam de Thiès.</p></div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Navigation</h5><p><a href="/mio-ressources/index.php" class="text-white-50 text-decoration-none">Accueil</a></p><p><a href="/mio-ressources/pages/a-propos.php" class="text-white-50 text-decoration-none">À Propos</a></p><p><a href="/mio-ressources/pages/club-mio.php" class="text-white-50 text-decoration-none">Club MIO</a></p><p><a href="/mio-ressources/pages/contact.php" class="text-white-50 text-decoration-none">Contact</a></p></div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Contact</h5><?php if (!empty($params['contact_adresse'])): ?><p><i class="bi bi-geo-alt-fill me-3"></i><?= htmlspecialchars($params['contact_adresse']) ?></p><?php endif; ?><?php if (!empty($params['contact_email'])): ?><p><i class="bi bi-envelope-fill me-3"></i><a href="mailto:<?= htmlspecialchars($params['contact_email']) ?>" class="text-white-50 text-decoration-none"><?= htmlspecialchars($params['contact_email']) ?></a></p><?php endif; ?><?php if (!empty($params['contact_telephone'])): ?><p><i class="bi bi-telephone-fill me-3"></i><a href="tel:<?= htmlspecialchars($params['contact_telephone']) ?>" class="text-white-50 text-decoration-none"><?= htmlspecialchars($params['contact_telephone']) ?></a></p><?php endif; ?></div>
            </div>
            <hr class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8"><p>Copyright &copy;<?= date('Y') ?> Tous droits réservés par : <a href="/mio-ressources/index.php" class="text-decoration-none"><strong class="text-primary">MIO-Ressources</strong></a></p></div>
                <div class="col-md-5 col-lg-4"><div class="text-center text-md-end"><ul class="list-unstyled list-inline"><?php if (!empty($params['social_facebook_url'])): ?><li class="list-inline-item"><a href="<?= htmlspecialchars($params['social_facebook_url']) ?>" target="_blank" class="text-white footer-social-icon"><i class="bi bi-facebook"></i></a></li><?php endif; ?><?php if (!empty($params['social_twitter_url'])): ?><li class="list-inline-item"><a href="<?= htmlspecialchars($params['social_twitter_url']) ?>" target="_blank" class="text-white footer-social-icon"><i class="bi bi-twitter-x"></i></a></li><?php endif; ?><?php if (!empty($params['social_linkedin_url'])): ?><li class="list-inline-item"><a href="<?= htmlspecialchars($params['social_linkedin_url']) ?>" target="_blank" class="text-white footer-social-icon"><i class="bi bi-linkedin"></i></a></li><?php endif; ?><?php if (!empty($params['social_youtube_url'])): ?><li class="list-inline-item"><a href="<?= htmlspecialchars($params['social_youtube_url']) ?>" target="_blank" class="text-white footer-social-icon"><i class="bi bi-youtube"></i></a></li><?php endif; ?><?php if (!empty($params['social_github_url'])): ?><li class="list-inline-item"><a href="<?= htmlspecialchars($params['social_github_url']) ?>" target="_blank" class="text-white footer-social-icon"><i class="bi bi-github"></i></a></li><?php endif; ?></ul></div></div>
            </div>
        </div>
    </footer>

    <!-- Bouton "Retour en haut" -->
    <button id="backToTopBtn" title="Retour en haut"><i class="bi bi-arrow-up"></i></button>
    
    <!-- ========================================================== -->
    <!-- ====    CES SCRIPTS SONT ESSENTIELS POUR LE MENU HAMBURGER, LE SLIDER, ETC.   ==== -->
    <!-- ========================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script JavaScript pour le bouton "Retour en haut" -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let backToTopButton = document.getElementById('backToTopBtn');
            if (backToTopButton) {
                window.onscroll = function() {
                    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                        backToTopButton.classList.add('show');
                    } else {
                        backToTopButton.classList.remove('show');
                    }
                };
                backToTopButton.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });
    </script>
</body>
</html>