<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::checkRoles(['admin', 'super admin'] ,$r->url('login'));

    $user = App::getAuth()->user();
    $auth = App::getAuth();

    $title = "Administration";
    $pdo = App::getPDO();

    $rapports = $pdo->query("SELECT COUNT(id) as count FROM reports")->fetchColumn();
    $users = $pdo->query("SELECT COUNT(id) as count FROM users WHERE role != 'super admin'")->fetchColumn();

?>

<div class="container">
    <h5 class="display-6 mb-4">Administration</h5>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5><a style="text-decoration: none;" href="<?= $r->url('admin.rapports') ?>">Rapports</a></h5>
                </div>
                <div class="card-footer">
                    <a href="<?= $r->url('admin.rapports') ?>" class="btn btn-lg btn-primary">
                        <?= $rapports ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>
                        <a href="<?= $r->url('admin.users') ?>" style="text-decoration: none;">
                            Utilisateurs
                        </a>
                    </h5>
                </div>
                <div class="card-footer">
                    <a href="<?= $r->url('admin.users') ?>" class="btn btn-lg btn-primary">
                        <?= $users ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>