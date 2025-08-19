<?php
// Fichier : /index.php (Version finale avec section forum)

// --- 1. LOGIQUE & DONNÉES ---
require_once 'includes/db.php';

// Récupération des semestres (inchangé)
$query_semestres = $pdo->query('SELECT * FROM semestres ORDER BY id ASC');
$semestres = $query_semestres->fetchAll();

// --- NOUVELLE REQUÊTE : Récupérer les 4 derniers sujets du forum ---
$sql_forum = "SELECT 
                    s.id, s.titre, s.date_creation,
                    u.username, u.photo_profil,
                    c.nom AS categorie_nom
                FROM forum_sujets AS s
                JOIN phpauth_users AS u ON s.auteur_id = u.id
                JOIN forum_categories AS c ON s.categorie_id = c.id
                ORDER BY s.date_creation DESC
                LIMIT 4";
$query_forum = $pdo->query($sql_forum);
$derniers_sujets = $query_forum->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = "Accueil";

// --- 2. AFFICHAGE (VUE) ---
require_once 'includes/header.php';
?>
<div class.container mt-4">
    <?= show_auth_messages(); ?>
</div>
<?php
require_once 'partials/home-carousel.php';
require_once 'partials/home-semesters-list.php';

// --- NOUVEL AJOUT : On inclut le nouveau partial pour le forum ---
require_once 'partials/home-forum-latest.php';

require_once 'includes/footer.php';
?>