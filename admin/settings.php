<?php
// Fichier : /admin/settings.php (Version finale complète et corrigée)
require_once '../includes/db.php';
require_once 'auth_admin.php';

$query = $pdo->query("SELECT nom_param, valeur_param FROM parametres");
$params = $query->fetchAll(PDO::FETCH_KEY_PAIR);

$pageTitle = "Paramètres du Site";
require_once 'partials/header.php';
?>

<h1 class="h3 mb-4 card-title">Paramètres du Site</h1>

<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert"><?= htmlspecialchars($_SESSION['success_message']); ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<form action="settings-handler.php" method="POST" enctype="multipart/form-data">
    <!-- Section 1 : Personnalisation du Thème -->
    <div class="card mb-4">
        <div class="card-header"><h6 class="m-0">Personnalisation du Thème</h6></div>
        <div class="card-body">
            <p class="text-secondary">Copiez-collez les codes hexadécimaux des couleurs de votre thème.</p>
            <div class="row">
                <?php
                // Fonction pour générer un champ de couleur proprement
                function render_color_input($name, $label, $default_color, $params) {
                    $value = htmlspecialchars($params[$name] ?? $default_color);
                    echo '
                    <div class="col-md-4 mb-3">
                        <label for="'.$name.'" class="form-label">'.$label.'</label>
                        <div class="input-group">
                            <span class="input-group-text color-preview" style="background-color: '.$value.'"></span>
                            <input type="text" class="form-control color-input" id="'.$name.'" name="'.$name.'" value="'.$value.'">
                        </div>
                    </div>';
                }

                render_color_input('theme_bg_main', 'Fond Principal', '#0f172a', $params);
                render_color_input('theme_bg_sidebar', 'Fond Menu Latéral', '#17253c', $params);
                render_color_input('theme_bg_card', 'Fond des Cartes', '#1f2937', $params);
                render_color_input('theme_accent_primary', 'Couleur d\'Accentuation', '#3b82f6', $params);
                render_color_input('theme_text_primary', 'Texte Principal (Titres)', '#e5e7eb', $params);
                render_color_input('theme_text_secondary', 'Texte Secondaire', '#9ca3af', $params);
                ?>
            </div>
        </div>
    </div>
    
    <!-- Section 2 : Informations de Contact -->
    <div class="card mb-4">
        <div class="card-header"><h6 class="m-0">Informations de Contact</h6></div>
        <div class="card-body">
            <div class="mb-3"><label for="contact_email" class="form-label">Email</label><input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= htmlspecialchars($params['contact_email'] ?? '') ?>"></div>
            <div class="mb-3"><label for="contact_telephone" class="form-label">Téléphone</label><input type="tel" class="form-control" id="contact_telephone" name="contact_telephone" value="<?= htmlspecialchars($params['contact_telephone'] ?? '') ?>"></div>
            <div class="mb-3"><label for="contact_adresse" class="form-label">Adresse</label><textarea class="form-control" id="contact_adresse" name="contact_adresse" rows="3"><?= htmlspecialchars($params['contact_adresse'] ?? '') ?></textarea></div>
            <div class="mb-3"><label for="contact_iframe_maps" class="form-label">Code Iframe Google Maps</label><textarea class="form-control" id="contact_iframe_maps" name="contact_iframe_maps" rows="5"><?= htmlspecialchars($params['contact_iframe_maps'] ?? '') ?></textarea></div>
        </div>
    </div>

    <!-- Section 3 : Réseaux Sociaux -->
    <div class="card mb-4">
        <div class="card-header"><h6 class="m-0">Réseaux Sociaux</h6></div>
        <div class="card-body">
            <div class="mb-3"><label for="social_facebook_url" class="form-label"><i class="bi bi-facebook me-2"></i>URL Facebook</label><input type="url" class="form-control" id="social_facebook_url" name="social_facebook_url" value="<?= htmlspecialchars($params['social_facebook_url'] ?? '') ?>"></div>
            <div class="mb-3"><label for="social_twitter_url" class="form-label"><i class="bi bi-twitter-x me-2"></i>URL Twitter (X)</label><input type="url" class="form-control" id="social_twitter_url" name="social_twitter_url" value="<?= htmlspecialchars($params['social_twitter_url'] ?? '') ?>"></div>
            <div class="mb-3"><label for="social_linkedin_url" class="form-label"><i class="bi bi-linkedin me-2"></i>URL LinkedIn</label><input type="url" class="form-control" id="social_linkedin_url" name="social_linkedin_url" value="<?= htmlspecialchars($params['social_linkedin_url'] ?? '') ?>"></div>
            <div class="mb-3"><label for="social_youtube_url" class="form-label"><i class="bi bi-youtube me-2"></i>URL YouTube</label><input type="url" class="form-control" id="social_youtube_url" name="social_youtube_url" value="<?= htmlspecialchars($params['social_youtube_url'] ?? '') ?>"></div>
            <div class="mb-3"><label for="social_github_url" class="form-label"><i class="bi bi-github me-2"></i>URL GitHub</label><input type="url" class="form-control" id="social_github_url" name="social_github_url" value="<?= htmlspecialchars($params['social_github_url'] ?? '') ?>"></div>
        </div>
    </div>
    
    <!-- Bouton d'enregistrement -->
    <div class="d-flex justify-content-end my-4">
        <button type="submit" class="btn btn-primary btn-lg">Enregistrer tous les Paramètres</button>
    </div>
</form>

<!-- Style pour l'aperçu de couleur -->
<style>.color-preview { width: 40px; border-top-left-radius: .375rem; border-bottom-left-radius: .375rem; transition: background-color 0.3s; }</style>

<!-- Script pour mettre à jour l'aperçu en temps réel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInputs = document.querySelectorAll('.color-input');
    colorInputs.forEach(input => {
        input.addEventListener('input', function() {
            const preview = this.closest('.input-group').querySelector('.color-preview');
            // Vérifie si le code couleur est valide avant de l'appliquer
            if (/^#([0-9A-F]{3}){1,2}$/i.test(this.value)) {
                preview.style.backgroundColor = this.value;
            }
        });
    });
});
</script>

<?php require_once 'partials/footer.php'; ?>