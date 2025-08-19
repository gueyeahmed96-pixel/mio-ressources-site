<?php
// Fichier: /admin/partials/theme-style-injector.php
$theme_query = $pdo->query("SELECT nom_param, valeur_param FROM parametres WHERE nom_param LIKE 'theme_%'");
$theme_params = $theme_query->fetchAll(PDO::FETCH_KEY_PAIR);

// On définit les valeurs par défaut du thème "Rocker"
$bg_main = $theme_params['theme_bg_main'] ?? '#0f172a';
$bg_sidebar = $theme_params['theme_bg_sidebar'] ?? '#17253c';
$bg_card = $theme_params['theme_bg_card'] ?? '#1f2937';
$border_color = $theme_params['theme_border_color'] ?? '#374151';
$text_primary = $theme_params['theme_text_primary'] ?? '#e5e7eb';
$text_secondary = $theme_params['theme_text_secondary'] ?? '#9ca3af';
$accent_primary = $theme_params['theme_accent_primary'] ?? '#3b82f6';
?>
<style>
    :root {
        --bg-main: <?= htmlspecialchars($bg_main) ?>;
        --bg-sidebar: <?= htmlspecialchars($bg_sidebar) ?>;
        --bg-card: <?= htmlspecialchars($bg_card) ?>;
        --border-color: <?= htmlspecialchars($border_color) ?>;
        --text-primary: <?= htmlspecialchars($text_primary) ?>;
        --text-secondary: <?= htmlspecialchars($text_secondary) ?>;
        --accent-primary: <?= htmlspecialchars($accent_primary) ?>;
    }
</style>