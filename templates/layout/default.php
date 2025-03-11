<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(isset($description)): ?>
        <meta name="description" content="<?= $description ?? '' ?>">
    <?php endif; ?>
    <?php if(isset($keywords)): ?>
        <meta name="keywords" content="<?= $keywords ?? '' ?>">
    <?php endif; ?>
    <?php if(isset($author)): ?>
        <meta name="author" content="<?= $author ?? '' ?>">
    <?php endif; ?>
    <title><?= isset($title) ? htmlentities($title) : 'Rapport' ?></title>
    <link rel="icon" href="" type="image/svg+xml">
    <link rel="stylesheet" href="/Rapport/public/dist/app.css?v=<?= filemtime('dist/app.css') ?>">
    <script src="/Rapport/public/dist/app.js?v=<?= filemtime('dist/app.js') ?>" defer></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net/2.2.1/dataTables.min.js" integrity="sha512-j0JNzzcT4VrPZe1L2nLrJpaQqH5FHhG7dG2P+yOcIRxwm5G5NDf3em4rd3pFEfTs6ta5itVC49GE1+r7Ej/bSw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-md navbar-light bg-warning mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $r->url('index') ?>">RAPPORT</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#index" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="index">
                <ul class="navbar-nav me-auto mb-lg-0">
                    <li class="nav-item">
                        <a href="<?= $r->url('index') ?>" class="nav-link <?php if(isset($nav) && $nav === "index"): ?>active<?php endif; ?>">Accueil</a>
                    </li>
                    <?php if(!isset($_SESSION['USER'])): ?>
                    <li class="nav-item">
                        <a href="<?= $r->url('login') ?>" class="nav-link <?php if(isset($nav) && $nav === "login"): ?>active<?php endif; ?>">
                            Se connecter
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['USER'])): ?>
                    <li class="nav-item">
                        <a href="<?= $r->url('profile') ?>" class="nav-link <?php if(isset($nav) && $nav === "profile"): ?>active<?php endif; ?>">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= $r->url('logout') ?>" class="nav-link">Deconnexion</a>
                    </li>
                    <?php endif; ?>
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

    <div>
        <?= $content ?>
    </div>

</body>
</html>