<?php
// Fichier : /admin/list-resources.php

// --- 1. LOGIQUE & DONNÉES ---
require_once '../includes/db.php';
require_once 'auth_admin.php';

// On récupère toutes les ressources avec les infos des matières et semestres associés
// C'est une requête complexe avec 2 jointures pour avoir toutes les infos d'un coup.
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%'; // Ligne 20
$query = $pdo->prepare("SELECT 
                            r.id, 
                            r.nom AS ressource_nom, 
                            r.type, 
                            r.date_ajout,
                            m.nom AS matiere_nom,
                            s.niveau,
                            s.nom AS semestre_nom
                        FROM ressources AS r
                        JOIN matieres AS m ON r.matiere_id = m.id
                        JOIN semestres AS s ON m.semestre_id = s.id
                        WHERE r.nom LIKE ? OR m.nom LIKE ?
                        ORDER BY r.date_ajout DESC");
$query->execute([$search, $search]); // Ligne 30
$ressources = $query->fetchAll();

// Définir le titre de la page
$pageTitle = "Gérer les Ressources";


// --- 2. AFFICHAGE (VUE) ---
require_once 'partials/header.php';
?>

<!-- Intégration des CSS pour DataTables depuis un CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

<h1 class="mt-4">Gestion des Ressources</h1>
<p class="lead">Consultez, modifiez ou supprimez les ressources du site.</p>



<form action="list-resources.php" method="GET" class="mb-4"> 
    <input type="text" name="search" placeholder="Rechercher une ressource..." class="form-control">
    <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
</form>

<?php
// Ce bloc vérifie s'il y a des messages en attente dans la session et les affiche.
// On s'assure que la session est bien démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On cherche un message de succès
if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); // On le supprime après affichage ?>
<?php endif; ?>

<?php // On cherche un message d'erreur
if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); // On le supprime après affichage ?>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Liste de toutes les ressources</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- On donne un ID à notre table pour que DataTables puisse la trouver -->
            <table id="resources-table" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Titre de la ressource</th>
                        <th>Matière</th>
                        <th>Type</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ressources as $ressource): ?>
                        <tr>
                            <td><?= htmlspecialchars($ressource['ressource_nom']) ?></td>
                            <td>
                                <small class="d-block"><?= htmlspecialchars($ressource['niveau'] . ' - ' . $ressource['semestre_nom']) ?></small>
                                <?= htmlspecialchars($ressource['matiere_nom']) ?>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= htmlspecialchars($ressource['type']) ?></span>
                            </td>
                            <td>
                                <!-- On formate la date pour qu'elle soit plus lisible -->
                                <?= date('d/m/Y à H:i', strtotime($ressource['date_ajout'])) ?>
                            </td>
                            <td>
                                <!-- Liens pour les actions (Modifier/Supprimer) -->
                                <!-- Pour l'instant, ils ne mènent nulle part -->
                               <a href="edit-resource.php?id=<?= $ressource['id'] ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                </a>
                                <!-- Le lien pointe maintenant vers notre script de suppression, en passant l'ID -->
                                <a href="delete-resource.php?id=<?= $ressource['id'] ?>" 
                                       class="btn btn-sm btn-danger delete-btn" 
                                       title="Supprimer">
                                       <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
// On inclut le pied de page avant d'ajouter les scripts JS
require_once 'partials/footer.php';
?>

<!-- Intégration des JS pour DataTables et Bootstrap 5 (jQuery est nécessaire pour DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- Notre script personnalisé -->
<script>
    // $(document).ready(...) est une fonction jQuery qui s'assure que le code
    // à l'intérieur ne s'exécutera que lorsque la page entière sera chargée.
    $(document).ready(function() {

        // --- PARTIE 1 : Initialisation de DataTables ---
        $('#resources-table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
            },
            order: [[3, 'desc']]
        });


        // --- PARTIE 2 : Logique pour la confirmation de suppression ---
        // C'est le code que vous devez ajouter.
        
        // 1. On sélectionne TOUS les boutons qui ont la classe 'delete-btn'
        //    et on leur attache un "écouteur d'événement" qui attend un clic.
        $('.delete-btn').on('click', function(event) {

            // 2. event.preventDefault() : C'est la ligne la plus importante.
            //    Elle dit au navigateur : "Stop ! N'exécute pas l'action par défaut de ce lien
            //    (qui est de naviguer vers delete-resource.php). Attends mes instructions."
            event.preventDefault(); 
            
            // 3. On récupère l'URL qui est dans l'attribut 'href' du bouton sur lequel on a cliqué.
            //    'this' fait référence au bouton spécifique qui a déclenché l'événement.
            const deleteUrl = $(this).attr('href');
            
            // 4. On utilise la fonction 'confirm()' de JavaScript. Elle affiche une petite
            //    boîte de dialogue native du navigateur avec un message et deux boutons : "OK" et "Annuler".
            if (confirm('Êtes-vous sûr de vouloir supprimer cette ressource ? Cette action est irréversible.')) {
                
                // 5. Si l'utilisateur clique sur "OK", la fonction confirm() renvoie 'true'.
                //    Alors, on exécute la redirection manuellement en utilisant JavaScript.
                window.location.href = deleteUrl;

            }
            // 6. Si l'utilisateur clique sur "Annuler", la fonction confirm() renvoie 'false',
            //    la condition 'if' n'est pas remplie, et le script s'arrête.
            //    Comme on a fait event.preventDefault(), il ne se passe rien du tout.
        });

    });
</script>