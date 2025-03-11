<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Admin' ?></title>
    <link rel="stylesheet" href="/Rapport/public/dist/admin.css?v=<?= filemtime('dist/admin.css') ?>">
    <script src="/Rapport/public/dist/admin.js?v=<?= filemtime('dist/admin.js') ?>" defer></script>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light bg-primary mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $r->url('admin') ?>">Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#admin" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="admin">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="<?= $r->url('admin.rapports') ?>" class="nav-link <?php if(isset($nav) && $nav === "admin.rapports"): ?>active<?php endif; ?>">Rapports</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $r->url('admin.users') ?>" class="nav-link <?php if(isset($nav) && $nav === "admin.users"): ?>active<?php endif; ?>">Utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $r->url('admin.statistiques') ?>" class="nav-link <?php if(isset($nav) && $nav === "admin.statistiques"): ?>active<?php endif; ?>">Statistiques</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $r->url('logout') ?>" class="nav-link">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if(isset($_SESSION['flash'])): ?>
        <div class="container d-flex justify-content-center mt-3">
            <?php foreach($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type ?> alert-dismissible text-<?= $type ?> text-center lead fade show" role="alert">
                    <strong><?= $message ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']) ?>
        </div>
    <?php endif; ?>

    <main>
        <div class="mt-4">
            <?= $content ?>
        </div>
    </main>

</body>
</html>