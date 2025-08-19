<?php
// Fichier : /pages/contact.php (Version finale corrigée)

require_once '../includes/db.php';

// On récupère tous les paramètres d'un coup
$query = $pdo->query("SELECT nom_param, valeur_param FROM parametres");
$params_db = $query->fetchAll(PDO::FETCH_KEY_PAIR);

// On assigne les valeurs à des variables pour une utilisation plus simple, avec des valeurs par défaut
$email = $params_db['contact_email'] ?? 'Non défini';
$telephone = $params_db['contact_telephone'] ?? 'Non défini';
$adresse = $params_db['contact_adresse'] ?? 'Non définie';
// On s'assure que le code HTML de l'iframe est bien interprété
$iframe_maps = $params_db['contact_iframe_maps'] ?? '<p class="text-center p-5">Carte non disponible. Veuillez la configurer dans l\'espace d\'administration.</p>';

$pageTitle = "Contact";
require_once '../includes/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1>Nous Contacter</h1>
            <p class="lead">N'hésitez pas à nous joindre pour toute question ou suggestion.</p>
        </div>
    </div>
    <div class="row">
        <!-- Colonne des informations -->
        <div class="col-lg-5 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="card-title mb-4">Informations de Contact</h4>
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-geo-alt-fill h4 me-3 text-primary"></i>
                        <div>
                            <strong>Adresse :</strong><br>
                            <?= htmlspecialchars($adresse) ?>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-start mb-3">
                        <i class="bi bi-telephone-fill h4 me-3 text-primary"></i>
                        <div>
                            <strong>Téléphone :</strong><br>
                            <a href="tel:<?= htmlspecialchars($telephone) ?>"><?= htmlspecialchars($telephone) ?></a>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex align-items-start">
                        <i class="bi bi-envelope-fill h4 me-3 text-primary"></i>
                        <div>
                            <strong>Email :</strong><br>
                            <a href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de la carte -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-0">
                    <!-- On affiche l'iframe directement depuis la BDD -->
                    <!-- Il ne faut PAS utiliser htmlspecialchars() ici car c'est du HTML pur -->
                    <?= $iframe_maps ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>