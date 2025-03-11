<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Auth;

PHPSession::start();

    $title = 'Acceuil';
    $nav = 'index';
    $pdo = App::getPDO();
    Auth::cookie($pdo);



?>

<main class="container">
    <section class="text-center">
        <div class="row py-lg-5">
            <div class="col-lg-8 col-md-8 mx-auto">
                <h1 class="text-warning">RAPPORT</h1>
                <p class="lead">
                    Bienvenue sur la plateforme de soumission des rapports des guichets de l'agence AEJ Abobo
                </p>
                <p>
                    <a href="#" class="btn btn-warning rounded-pill my-2">Soumettre</a>
                    <a href="#" class="btn btn-secondary rounded-pill my-2">Tableau de bord</a>
                </p>
            </div>
        </div>
    </section>
</main>