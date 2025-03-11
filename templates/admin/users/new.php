<?php

use App\Domain\Application\Builder\Form;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::checkRoles(['super admin'], $r->url('admin'));

    $title = "Administration | Utilisateurs";

    $user = new User();
    $errors = [];
    $roles = User::ROLE;

    if(!empty($_POST)) {

        dump('OK');
    }

    $form = new Form($user, $errors);
?>

<div class="container">
    <h2 class="display-5">Créer un nouveau guichet</h2>
    <form action="" method="post">
        <div class="row">
            <div class="col-md-4">
                <?= $form->input('text', 'username', 'Nom d\'utilisateur', ['required' => '']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->input('email', 'email', 'Email', ['required' => '']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->input('password', 'password', 'Mot de passe', ['required' => '']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->select('role', 'Role', $roles, ['required' => '']) ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
    </form>
</div>