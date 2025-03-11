<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;
use App\Helper\Helper;

PHPSession::start();
UserChecker::UserNotConnected($r->url('login'));

    $pdo = App::getPDO();
    $user = App::getAuth()->user();

    $date_debut_semaine = Helper::yearDate();

    ## Vérifier si un rapport a déjà été soumis cette semaine par ce guichet
    $query = $pdo->prepare("SELECT * FROM reports WHERE user_id = :user_id AND created_at >= :created_at AND status = 'en attente'");
    $query->execute([
        'user_id' => $user->getId(),
        'created_at' => $date_debut_semaine
    ]);
    $existing_report = $query->fetch();

    if(!empty($_POST)) {
        if (!$existing_report) {
            /*
            $query = "INSERT INTO guichet_reports (guichet_id, date_debut_semaine, rapport) VALUES (:guichet_id, :date_debut_semaine, :rapport)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'guichet_id' => $_SESSION['id'],
                'date_debut_semaine' => $date_debut_semaine,
                'rapport' => $rapport
            ]); status en attente
            */

            ## Envoyer un email à l'administrateur

            Helper::RedirectFlash('success', 'Votre rapport a été soumis avec succès !', $r->url('rapport.new'));
        } else {
            Helper::RedirectFlash('warning', 'Vous avez déjà soumis un rapport cette semaine', $r->url('rapport.new'));
        }

    }

?>

<div class="container">
    <h5 class="display-5">Créer un nouveau rapport (Rapport Hebdomadaire d'Activités)</h5>
    <form action="" method="post">
        <h4>REUNION, CEREMONIES, SEMINAIRES, ATELIER, RENCONTRES (SEANCES DE TRAVAIL)</h4>
        <hr>
        <p class="lead">Rencontres et Partenariats</p>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="" class="form-label">Nom</label>
                <input type="text" name="" id="" class="form-control">
            </div>
        </div>
        <hr>
        <p class="lead">Rencontres avec les employeurs</p>

        <hr>
        <h4>CEREMONIES, SEMINAIRES ET ATELIER</h4>
        <hr>
        <p class="lead"></p>

        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>