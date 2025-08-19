<?php
// Fichier : /pages/matiere.php
require_once '../includes/db.php';

$matiere_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($matiere_id === 0) {
    header('Location: /mio-ressources/index.php');
    exit();
}

// La requête SQL avec la jointure est cruciale
$sql = "SELECT 
            matieres.*, 
            semestres.nom AS semestre_nom, 
            semestres.niveau AS semestre_niveau
        FROM matieres 
        JOIN semestres ON matieres.semestre_id = semestres.id 
        WHERE matieres.id = ?";
$query_matiere = $pdo->prepare($sql);
$query_matiere->execute([$matiere_id]);
$matiere = $query_matiere->fetch();

if (!$matiere) {
    header('Location: /mio-ressources/index.php');
    exit();
}

$query_ressources = $pdo->prepare("SELECT * FROM ressources WHERE matiere_id = ? ORDER BY type, nom ASC");
$query_ressources->execute([$matiere_id]);
$ressources = $query_ressources->fetchAll();

$ressources_par_type = [];
foreach ($ressources as $ressource) {
    $ressources_par_type[$ressource['type']][] = $ressource;
}

$bg_classes = ['L1' => 'bg-l1', 'L2' => 'bg-l2', 'L3' => 'bg-l3'];
// On utilise bien la clé 'semestre_niveau' qui vient de la requête
$background_class = $bg_classes[$matiere['semestre_niveau']] ?? 'bg-dark';

$pageTitle = htmlspecialchars($matiere['nom']);

require_once '../includes/header.php';
?>

<header class="hero-banner text-white text-center py-5 <?= $background_class ?>">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center bg-transparent p-0 m-0">
                <li class="breadcrumb-item"><a href="/mio-ressources/index.php" class="text-white">Accueil</a></li>
                <li class="breadcrumb-item">
                    <a href="/mio-ressources/pages/semestre.php?id=<?= $matiere['semestre_id'] ?>" class="text-white">
                        <?= htmlspecialchars($matiere['semestre_niveau'] . ' - ' . $matiere['semestre_nom']) ?>
                    </a>
                </li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">
                    <?= htmlspecialchars($matiere['nom']) ?>
                </li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mt-3"><?= htmlspecialchars($matiere['nom']) ?></h1>
        <p class="lead">Code : <?= htmlspecialchars($matiere['code_matiere']) ?></p>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <?php if (empty($ressources_par_type)): ?>
            <div class="text-center">
                <i class="bi bi-cloud-slash-fill" style="font-size: 5rem; color: #6c757d;"></i>
                <h3 class="mt-4">Aucune ressource disponible</h3>
                <p class="lead text-muted">Il n'y a pas encore de cours ou de TD pour cette matière.<br>L'administrateur en ajoutera bientôt !</p>
            </div>
        <?php else: ?>
            <?php foreach ($ressources_par_type as $type => $liste_ressources): ?>
                <h2 class="mb-3"><i class="bi bi-folder2-open"></i> <?= htmlspecialchars($type) ?></h2>
                <div class="list-group mb-5">
                    <?php foreach ($liste_ressources as $ressource): 
                        $icon_class = 'bi-file-earmark-text';
                        if ($type === 'Cours') $icon_class = 'bi-book';
                        if ($type === 'TD') $icon_class = 'bi-pencil-square';
                        if ($type === 'Vidéo') $icon_class = 'bi-youtube';
                    ?>
                         <!-- Fichier : /pages/matiere.php (Version avec 2 boutons) -->

<!-- On remplace la balise <a> par une <div> car l'élément entier n'est plus un seul lien -->
<div class="list-group-item d-flex justify-content-between align-items-center p-3">
    
    <!-- Partie gauche : Icône et Titre de la ressource -->
    <div class="d-flex align-items-center">
        <i class="bi <?= $icon_class ?> h3 me-3 text-primary"></i>
        <span class="fw-bold"><?= htmlspecialchars($ressource['nom']) ?></span>
    </div>
    
    <!-- Partie droite : Le groupe de boutons d'action -->
    <div class="ms-3">
        <?php if ($type === 'Vidéo'): ?>
            <!-- Cas spécial pour les vidéos : un seul bouton "Visionner" -->
            <a href="<?= htmlspecialchars($ressource['chemin_fichier']) ?>" target="_blank" class="btn btn-primary">
                <i class="bi bi-play-btn-fill me-1"></i> Visionner
            </a>
        <?php else: ?>
            <!-- Pour tous les autres types de fichiers : deux boutons -->
            <div class="btn-group" role="group" aria-label="Actions pour la ressource">
                
                <!-- Bouton "Voir" : lien standard sans l'attribut download -->
                <a href="../uploads/<?= htmlspecialchars($ressource['chemin_fichier']) ?>" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-eye-fill me-1"></i> Voir
                </a>
                
                <!-- Bouton "Télécharger" : le même lien, MAIS avec l'attribut download -->
                <a href="../uploads/<?= htmlspecialchars($ressource['chemin_fichier']) ?>" class="btn btn-primary" download>
                    <i class="bi bi-download me-1"></i> Télécharger
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="text-center mt-5">
            <a href="/mio-ressources/pages/semestre.php?id=<?= $matiere['semestre_id'] ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
                Retour à la liste des matières
            </a>
        </div>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>