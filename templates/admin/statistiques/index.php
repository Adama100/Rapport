<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::checkRoles(['super admin', 'admin'], $r->url('login'));

    $title = "Administration | Statistiques";
    $nav = "admin.statistiques";
    $pdo = App::getPDO();

?>

<div class="container">
    <h5 class="display-6 mb-3">Mes statistiques</h5>

</div>