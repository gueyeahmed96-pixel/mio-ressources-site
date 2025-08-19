<?php
// Fichier : /admin/partials/header.php (Version FINALE, complète et restaurée)
require_once __DIR__ . '/../auth_admin.php';
$current_page = basename($_SERVER['PHP_SELF']); $current_slug = $_GET['slug'] ?? '';
$is_resources_page = in_array($current_page, ['add-resource.php', 'list-resources.php', 'edit-resource.php']);
$is_content_page = in_array($current_page, ['edit-page.php', 'manage-appearance.php']);
$is_users_page = in_array($current_page, ['add-admin.php', 'list-admins.php', 'edit-admin.php']);
$is_forum_page = in_array($current_page, ['forum-categories.php', 'forum-sujets.php']);
$is_settings_page = ($current_page == 'settings.php');
$user_query = $pdo->prepare("SELECT username, photo_profil, email FROM phpauth_users WHERE id = ?");
$user_query->execute([$_SESSION['admin_id']]);
$current_user = $user_query->fetch();
$admin_display_name = $current_user['username'] ?? $current_user['email'];
$unread_count = $pdo->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0")->fetchColumn();
$notifications = $pdo->query("SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC LIMIT 5")->fetchAll();
?>
<!DOCTYPE html><html lang="fr" data-bs-theme="dark"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle).' - Admin MIO' : 'Administration MIO' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/mio-ressources/css/admin-style.css">
</head><body>
<div id="admin-wrapper" class="d-flex">
    <!-- Overlay pour mobile -->
    <div id="sidebar-overlay" class="d-lg-none"></div>
    
    <div class="d-flex flex-column flex-shrink-0 p-3" id="sidebar-wrapper">
        <a href="/mio-ressources/admin/index.php" class="d-flex align-items-center mb-3 pb-3 me-md-auto text-decoration-none sidebar-brand"><i class="bi bi-shield-shaded me-2"></i><span>MIO Admin</span></a>
        <div class="d-flex align-items-center mb-3 admin-profile">
            <img src="/mio-ressources/uploads/profiles/<?= htmlspecialchars($current_user['photo_profil'] ?? 'default.png') ?>" class="rounded-circle me-3" width="50" height="50" style="object-fit:cover;" alt="Profil">
            <div><span class="admin-name"><?= htmlspecialchars($admin_display_name) ?></span></div>
        </div>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"><a href="/mio-ressources/admin/index.php" class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>"><i class="bi bi-house-door"></i>Tableau de Bord</a></li>
            <li class="nav-item"><a href="#collapseResources" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center <?= $is_resources_page ? 'active' : '' ?>" aria-expanded="<?= $is_resources_page ? 'true' : 'false' ?>"><span><i class="bi bi-archive"></i>Ressources</span><i class="bi bi-chevron-right sidebar-chevron"></i></a><div class="collapse sidebar-submenu <?= $is_resources_page ? 'show' : '' ?>" id="collapseResources"><ul class="nav flex-column"><li class="nav-item"><a href="/mio-ressources/admin/add-resource.php" class="nav-link <?= ($current_page == 'add-resource.php') ? 'active' : '' ?>">Ajouter</a></li><li class="nav-item"><a href="/mio-ressources/admin/list-resources.php" class="nav-link <?= in_array($current_page, ['list-resources.php', 'edit-resource.php']) ? 'active' : '' ?>">Gérer</a></li></ul></div></li>
            <li class="nav-item"><a href="#collapseContent" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center <?= $is_content_page ? 'active' : '' ?>" aria-expanded="<?= $is_content_page ? 'true' : 'false' ?>"><span><i class="bi bi-palette"></i>Contenu</span><i class="bi bi-chevron-right sidebar-chevron"></i></a><div class="collapse sidebar-submenu <?= $is_content_page ? 'show' : '' ?>" id="collapseContent"><ul class="nav flex-column"><li class="nav-item"><a href="/mio-ressources/admin/manage-appearance.php" class="nav-link <?= ($current_page == 'manage-appearance.php') ? 'active' : '' ?>">Apparence</a></li><li class="nav-item"><a href="/mio-ressources/admin/edit-page.php?slug=a-propos" class="nav-link <?= ($current_page == 'edit-page.php' && $current_slug == 'a-propos') ? 'active' : '' ?>">Page "À Propos"</a></li><li class="nav-item"><a href="/mio-ressources/admin/edit-page.php?slug=club-mio" class="nav-link <?= ($current_page == 'edit-page.php' && $current_slug == 'club-mio') ? 'active' : '' ?>">Page "Club MIO"</a></li></ul></div></li>
            <li class="nav-item"><a href="#collapseForum" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center <?= $is_forum_page ? 'active' : '' ?>" aria-expanded="<?= $is_forum_page ? 'true' : 'false' ?>"><span><i class="bi bi-chat-square-dots-fill"></i>Forum</span><i class="bi bi-chevron-right sidebar-chevron"></i></a><div class="collapse sidebar-submenu <?= $is_forum_page ? 'show' : '' ?>" id="collapseForum"><ul class="nav flex-column"><li class="nav-item"><a href="/mio-ressources/admin/forum-categories.php" class="nav-link <?= ($current_page == 'forum-categories.php') ? 'active' : '' ?>">Catégories</a></li></ul></div></li>
            <li class="nav-item"><a href="#collapseUsers" data-bs-toggle="collapse" class="nav-link d-flex justify-content-between align-items-center <?= $is_users_page ? 'active' : '' ?>" aria-expanded="<?= $is_users_page ? 'true' : 'false' ?>"><span><i class="bi bi-people-fill"></i>Utilisateurs</span><i class="bi bi-chevron-right sidebar-chevron"></i></a><div class="collapse sidebar-submenu <?= $is_users_page ? 'show' : '' ?>" id="collapseUsers"><ul class="nav flex-column"><li class="nav-item"><a href="/mio-ressources/admin/add-admin.php" class="nav-link <?= ($current_page == 'add-admin.php') ? 'active' : '' ?>">Ajouter</a></li><li class="nav-item"><a href="/mio-ressources/admin/list-admins.php" class="nav-link <?= in_array($current_page, ['list-admins.php', 'edit-admin.php']) ? 'active' : '' ?>">Gérer</a></li></ul></div></li>
            <li class="nav-item"><a href="/mio-ressources/admin/settings.php" class="nav-link <?= ($current_page == 'settings.php') ? 'active' : '' ?>"><i class="bi bi-gear"></i>Paramètres</a></li>
        </ul>
    </div>
    <main id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg topbar"><div class="container-fluid">
            <button class="btn btn-toggle" id="sidebarToggle"><i class="bi bi-list fs-4"></i></button>
            
            <!-- Bouton pour le menu responsive (masqué par défaut) -->
            <button class="navbar-toggler ms-auto d-lg-none" type="button" data-bs-toggle="collapse" 
                    data-bs-target="#topbarCollapse" style="border: none; background: transparent; color: var(--text-secondary);">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="topbarCollapse">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="/mio-ressources/index.php" target="_blank">
                        <span class="d-none d-md-inline">Voir le site</span>
                        <i class="bi bi-eye-fill d-md-none"></i>
                    </a></li>
                    <li class="nav-item dropdown"><a class="nav-link" id="notificationBell" href="#" data-bs-toggle="dropdown"><i class="bi bi-bell-fill fs-5 position-relative"><?php if ($unread_count > 0):?><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;"><?= $unread_count ?></span><?php endif; ?></i></a><ul class="dropdown-menu dropdown-menu-end"><li><h6 class="dropdown-header">Notifications</h6></li><?php if(empty($notifications)):?><li><a class="dropdown-item" href="#">Aucune notification</a></li><?php else: foreach($notifications as $notif):?><li><a class="dropdown-item" href="/mio-ressources/admin/<?= $notif['link'] ?>"><?= $notif['message'] ?></a></li><?php endforeach; endif; ?></ul></li>
                    <li class="nav-item dropdown"><a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown"><img src="/mio-ressources/uploads/profiles/<?= htmlspecialchars($current_user['photo_profil'] ?? 'default.png') ?>" class="rounded-circle me-2" width="32" height="32" style="object-fit:cover;" alt="Profil"><span class="d-none d-sm-inline"><?= htmlspecialchars($admin_display_name) ?></span></a><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="/mio-ressources/admin/edit-admin.php?id=<?= $_SESSION['admin_id'] ?>">Mon Profil</a></li><li><a class="dropdown-item" href="/mio-ressources/admin/settings.php">Paramètres</a></li><li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="/mio-ressources/admin/logout.php">Déconnexion</a></li></ul></li>
                </ul>
            </div>
        </div></nav>
        <div class="container-fluid pt-4">