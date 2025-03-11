<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Helper\Helper;

PHPSession::start();

    $id = (int)$params['id'];
    $pdo = App::getPDO();
    $user = App::getAuth()->user();

    $query = $pdo->prepare("SELECT * FROM reports WHERE id = :id AND user_id = :user_id");
    $query->execute([
        'id' => $id,
        'user_id' => $user->getId()
    ]);
    $report = $query->fetch();

    if (!$report) {
        Helper::RedirectFlash('danger', "Rapport introuvable ou vous n'avez pas accès à ce rapport", $r->url('profile'));
    }


?>

<div class="container">
    <h1>Rapport complet</h1>
</div>