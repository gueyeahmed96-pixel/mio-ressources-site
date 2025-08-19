<?php
require_once '../includes/db.php';
require_once 'auth_admin.php';
  $pageTitle = "Tableau de Bord";
$stats = $pdo->query("SELECT (SELECT COUNT(*) FROM visites) as total_visites, (SELECT COUNT(DISTINCT ip_address) FROM visites) as visiteurs_uniques, (SELECT COUNT(*) FROM ressources) as total_ressources, (SELECT COUNT(*) FROM matieres) as total_matieres")->fetch(PDO::FETCH_ASSOC);
$query_graph_visits = $pdo->query("SELECT DATE(visit_date) as jour, COUNT(*) as nombre_visites FROM visites WHERE visit_date >= CURDATE() - INTERVAL 6 DAY GROUP BY jour ORDER BY jour ASC");
$visites_par_jour = $query_graph_visits->fetchAll(PDO::FETCH_KEY_PAIR);
$chart_labels = []; $chart_data = []; for ($i = 6; $i >= 0; $i--) { $date = date('Y-m-d', strtotime("-$i days")); $chart_labels[] = date('d/m', strtotime($date)); $chart_data[] = $visites_par_jour[$date] ?? 0; }
$query_types = $pdo->query("SELECT type, COUNT(*) as count FROM ressources GROUP BY type");
$type_counts = ['Cours' => 0, 'TD' => 0, 'Vidéo' => 0, 'Autre' => 0]; foreach ($query_types->fetchAll(PDO::FETCH_ASSOC) as $type) { $type_counts[$type['type']] = $type['count']; }
$top_pages = $pdo->query("SELECT page_visited, COUNT(*) as view_count FROM visites GROUP BY page_visited ORDER BY view_count DESC LIMIT 5")->fetchAll();
require_once 'partials/header.php';
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0">Tableau de Bord</h1>
    <a href="add-resource.php" class="btn btn-primary btn-sm shadow-sm"><i class="bi bi-plus-lg me-2"></i>Ajouter une Ressource</a>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4"><div class="card border-start-primary shadow h-100"><div class="card-body"><div class="row align-items-center"><div class="col"><div class="text-xs fw-bold text-primary text-uppercase mb-1">Visites Totales</div><div class="h5 mb-0 fw-bold text-body-secondary"><?= htmlspecialchars($stats['total_visites']) ?></div></div><div class="col-auto"><i class="bi bi-bar-chart-line-fill fs-2 text-gray-300"></i></div></div></div></div></div>
    <div class="col-lg-3 col-md-6 mb-4"><div class="card border-start-success shadow h-100"><div class="card-body"><div class="row align-items-center"><div class="col"><div class="text-xs fw-bold text-success text-uppercase mb-1">Visiteurs Uniques</div><div class="h5 mb-0 fw-bold text-body-secondary"><?= htmlspecialchars($stats['visiteurs_uniques']) ?></div></div><div class="col-auto"><i class="bi bi-people-fill fs-2 text-gray-300"></i></div></div></div></div></div>
    <div class="col-lg-3 col-md-6 mb-4"><div class="card border-start-info shadow h-100"><div class="card-body"><div class="row align-items-center"><div class="col"><div class="text-xs fw-bold text-info text-uppercase mb-1">Ressources</div><div class="h5 mb-0 fw-bold text-body-secondary"><?= htmlspecialchars($stats['total_ressources']) ?></div></div><div class="col-auto"><i class="bi bi-collection-fill fs-2 text-gray-300"></i></div></div></div></div></div>
    <div class="col-lg-3 col-md-6 mb-4"><div class="card border-start-warning shadow h-100"><div class="card-body"><div class="row align-items-center"><div class="col"><div class="text-xs fw-bold text-warning text-uppercase mb-1">Matières</div><div class="h5 mb-0 fw-bold text-body-secondary"><?= htmlspecialchars($stats['total_matieres']) ?></div></div><div class="col-auto"><i class="bi bi-bookmark-star-fill fs-2 text-gray-300"></i></div></div></div></div></div>
</div>
<div class="row">
    <div class="col-xl-8 col-lg-7 mb-4"><div class="card shadow h-100"><div class="card-header"><h6 class="m-0 fw-bold text-primary">Activité des 7 derniers jours</h6></div><div class="card-body"><canvas id="activityChart"></canvas></div></div></div>
    <div class="col-xl-4 col-lg-5 mb-4"><div class="card shadow mb-4"><div class="card-header"><h6 class="m-0 fw-bold text-primary">Répartition des Ressources</h6></div><div class="card-body d-flex align-items-center justify-content-center"><canvas id="resourceTypeChart" style="max-height: 180px;"></canvas></div></div><div class="card shadow"><div class="card-header"><h6 class="m-0 fw-bold text-primary">Pages les plus populaires</h6></div><div class="card-body p-2"><?php if (empty($top_pages)): ?><p class="text-center m-3 text-muted">Pas de données.</p><?php else: ?><div class="list-group list-group-flush"><?php foreach ($top_pages as $page): ?><div class="list-group-item d-flex justify-content-between align-items-center py-2"><span class="small" title="<?= htmlspecialchars($page['page_visited']) ?>"><?= htmlspecialchars(substr($page['page_visited'], 0, 25)) . (strlen($page['page_visited']) > 25 ? '...' : '') ?></span><span class="badge bg-primary rounded-pill"><?= $page['view_count'] ?></span></div><?php endforeach; ?></div><?php endif; ?></div></div></div>
</div>
<?php require_once 'partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxActivity = document.getElementById('activityChart'); if (ctxActivity) { new Chart(ctxActivity, { type: 'line', data: { labels: <?= json_encode($chart_labels) ?>, datasets: [ { label: "Pages vues", data: <?= json_encode($chart_data) ?>, lineTension: 0.3, backgroundColor: "rgba(78, 115, 223, 0.05)", borderColor: "rgba(78, 115, 223, 1)", pointRadius: 3, pointBackgroundColor: "rgba(78, 115, 223, 1)", pointBorderColor: "rgba(78, 115, 223, 1)", fill: true } ] }, options: { maintainAspectRatio: false, scales: { x: { grid: { display: false } } }, plugins: { legend: { display: false } } } }); }
    const ctxResources = document.getElementById('resourceTypeChart'); if (ctxResources) { new Chart(ctxResources, { type: 'doughnut', data: { labels: ["Cours", "TDs", "Vidéos", "Autres"], datasets: [ { data: [<?= implode(',', $type_counts) ?>], backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'], hoverBorderColor: "rgba(234, 236, 244, 1)" } ] }, options: { maintainAspectRatio: false, plugins: { legend: { display: true, position: 'bottom' } }, cutout: '80%' } }); }
});
</script>