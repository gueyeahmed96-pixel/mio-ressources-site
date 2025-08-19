<?php
// Fichier : /admin/login.php (Version finale et corrigée)
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin-style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Connexion Admin</h3></div>
            <div class="card-body">
                
                <?php
                // Affichage des messages de succès ou d'erreur
                if (isset($_SESSION['success_message'])) {
                    echo '<div class="alert alert-success">'.$_SESSION['success_message'].'</div>';
                    unset($_SESSION['success_message']);
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger">'.$_SESSION['error_message'].'</div>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <form action="login-handler.php" method="POST">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" name="email" type="email" placeholder="admin@exemple.com" required />
                        <label for="email">Adresse Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="mot_de_passe" name="mot_de_passe" type="password" placeholder="Mot de passe" required />
                        <label for="mot_de_passe">Mot de passe</label>
                    </div>
                    <div class="d-grid mt-4 mb-0">
                         <button type="submit" class="btn btn-primary btn-block">Se Connecter</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                <div class="small"><a href="../index.php">Retour au site public</a></div>
            </div>
        </div>
    </div>

</body>
</html>