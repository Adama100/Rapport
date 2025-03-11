<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Helper\Helper;

PHPSession::start();

    $id = (int)$params['id'];
    $pdo = App::getPDO();
    $user = App::getAuth()->user();

    $date_semaine = Helper::yearDate();

    $query = $pdo->prepare("SELECT * FROM reports WHERE user_id = :user_id AND created_at >= :created_at AND status = 'en attente' AND id = :id");
    $query->execute([
        'user_id' => $user->getId(),
        'created_at' => $date_semaine,
        'id' => $id
    ]);
    $report = $query->fetch();

    if (!$report) {
        Helper::RedirectFlash('warning', "Aucun rapport à modifier ou le rapport est déjà validé/rejeté", $r->url('login'));
    }

    if(!empty($_POST)) {

        echo "Votre rapport a été modifié avec succès!";
    }



?>

<div class="container">
    <h5 class="display-5">Modifier le rapport</h5>
</div>