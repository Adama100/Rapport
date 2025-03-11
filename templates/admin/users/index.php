<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::checkRoles(['admin', 'super admin'] ,$r->url('login'));

    $title = "Administration | Utilisateurs";
    $nav = "admin.users";
    $pdo = App::getPDO();
    $user = App::getAuth()->user();

    $users = $pdo->query("SELECT COUNT(id) as count FROM users WHERE role = 'guichet'")->fetchColumn();
    $admin = $pdo->query("SELECT COUNT(id) as count FROM users WHERE role = 'admin'")->fetchColumn();

?>

<div class="container">
    <h5 class="display-6 mb-4">Tous les utilisateurs</h5>
    <p class="lead">
        Consultez et gérez tous les utilisateurs inscrits sur la plateforme. Vous pouvez valider les maîtres, modifier ou supprimer un utilisateur en fonction de leur statut
    </p>
    <a href="<?= $r->url('admin.user.new') ?>" class="btn btn-primary">Nouveau</a>
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5><a style="text-decoration: none;" href="<?= $r->url('admin.users.users') ?>">Guichets</a></h5>
                </div>
                <div class="card-footer">
                    <a href="<?= $r->url('admin.users.users') ?>" class="btn btn-lg btn-primary">
                        <?= $users ?>
                    </a>
                </div>
            </div>
        </div>
        <?php if($user->getRole() === 'super admin'): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>
                        <a href="<?= $r->url('admin.users.admin') ?>" style="text-decoration: none;">
                            Admin
                        </a>
                    </h5>
                </div>
                <div class="card-footer">
                    <a href="<?= $r->url('admin.users.admin') ?>" class="btn btn-lg btn-primary">
                        <?= $admin ?>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>