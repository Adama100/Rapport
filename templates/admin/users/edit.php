<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\Security\UserChecker;
use App\Helper\Helper;

PHPSession::start();
UserChecker::checkRoles(['super admin', 'admin'], $r->url('login'));

    $id = (int)$params['id'];
    $pdo = App::getPDO();
    $item = new UserRepository($pdo);
    try {
        $user = $item->find($id);
    } catch(Exception $e) {
        Helper::RedirectFlash('danger', "Aucun utilisateur ne correspond à cet id $id", $r->url('admin.users'));
    }
    $roleUser = User::ROLE;
    $statusUser = USER::STATUS;

    if(!empty($_POST)) {

        $status = htmlspecialchars($_POST['status']);
        $role = htmlspecialchars($_POST['role']);
        if(!in_array($role, $roleUser)) {
            Helper::RedirectFlash('danger', 'Role invalide', $r->url('admin.users'));
        }
        if(!in_array($status, $statusUser)) {
            Helper::RedirectFlash('danger', 'Status invalide', $r->url('admin.users'));
        }
        $update = $pdo->prepare('UPDATE users SET status = ?, role = ? WHERE id = ?');
        $update->execute([$status, $role, $id]);
        Helper::RedirectFlash('success', 'Role d\'utilisateur modifié avec succès', $r->url('admin.users'));
    }

?>

<div class="container">
    <h5 class="display-6">Editer l'utilisateur <?= $user->getId() ?> <span class="text-primary"><?= $user->getEmail() ?></span></h5>
    <form action="" method="post">
        <div class="row">
            <div class="col-md-6 form-group mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <?php foreach($statusUser as $value): ?>
                        <option <?php if($user->getStatus() === $value): ?>selected<?php endif; ?> value="<?= $value ?>"><?= ucfirst($value) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 form-group mb-3">
                <div class="form-label">
                    <label for="role" class="form-label">Rôle</label>
                    <select name="role" class="form-control">
                        <?php foreach($roleUser as $value): ?>
                            <option <?php if($user->getRole() === $value): ?>selected<?php endif; ?> value="<?= $value ?>"><?= ucfirst($value) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>
    </form>
</div>