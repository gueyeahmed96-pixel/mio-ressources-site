<?php
// Fichier: /admin/generate-reset-link.php
require_once '../includes/db.php';
require_once 'auth.php'; // Sécurité : seul l'admin peut faire ça
require_once '../vendor/autoload.php'; // Pour charger PHPAuth

// On récupère l'email de l'utilisateur à qui on veut envoyer le lien
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id === 0) { die("ID utilisateur invalide."); }

$user_query = $pdo->prepare("SELECT email FROM phpauth_users WHERE id = ?");
$user_query->execute([$user_id]);
$user_email = $user_query->fetchColumn();

if (!$user_email) { die("Utilisateur non trouvé."); }

// On initialise PHPAuth
$config = new PHPAuth\Config($pdo);
$auth = new PHPAuth\Auth($pdo, $config);

// On force la création d'un token de réinitialisation
$result = $auth->requestReset($user_email, true);

if ($result['error']) {
    die("Erreur lors de la génération du lien : " . $result['message']);
}

// On affiche le lien à l'admin
$reset_url = "http://localhost/mio-ressources/pages/reinitialiser-mot-de-passe.php?key=" . urlencode($result['key']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lien de Réinitialisation Généré</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100 d-flex align-items-center justify-content-center">
    <div class="container text-center">
        <div class="card shadow">
            <div class="card-body p-5">
                <h1 class="h3">Lien de Réinitialisation Généré</h1>
                <p class="lead">Copiez ce lien et envoyez-le à l'utilisateur <strong><?= htmlspecialchars($user_email) ?></strong>.</p>
                <p class="text-muted">Ce lien est à usage unique et expirera bientôt.</p>
                <div class="input-group mt-4">
                    <input type="text" class="form-control" value="<?= htmlspecialchars($reset_url) ?>" id="resetLink" readonly>
                    <button class="btn btn-primary" onclick="copyLink()">Copier</button>
                </div>
                <a href="users/list-admins.php" class="btn btn-secondary mt-3">Retour à la liste</a>
            </div>
        </div>
    </div>
    <script>
        function copyLink() {
            const linkInput = document.getElementById('resetLink');
            linkInput.select();
            document.execCommand('copy');
            alert('Lien copié dans le presse-papiers !');
        }
    </script>
</body>
</html>