<?php

use App\Domain\App;
use App\Domain\Application\Session\Flash;
use App\Domain\Application\Session\PHPSession;
use App\Helper\Helper;

PHPSession::start();

    $title = 'Réinitialisation de mot de passe';
    $id = (int)$_GET['id'];
    $token = htmlspecialchars($_GET['token']);
    $pdo = App::getPDO();

    $query = $pdo->prepare('SELECT * FROM users WHERE id = :id AND reset_password_token IS NOT NULL AND reset_password_token = :token AND reset_password_at > DATE_SUB(NOW(), INTERVAL 20 MINUTE)'); 
    $query->execute([
        'id' => $id,
        'token' => $token
    ]);
    $user = $query->fetch();

    if($user === false) {
        Helper::RedirectFlash('danger', 'Ce token n\'est pas valide', $r->url('forget'));
    }

    if (!empty($_POST)) {
        $password = htmlspecialchars($_POST['password']);
        $password_repeat = htmlspecialchars($_POST['password_repeat']);

        if (!empty($password) && !empty($password_repeat)) {
            if($password === $password_repeat) {
                if(mb_strlen($password) > 4) {

                    $password = password_hash($password, PASSWORD_ARGON2ID);
                    $query = $pdo->prepare('UPDATE users SET password = ?, reset_password_token = NULL, reset_password_at = NULL WHERE id = ?');
                    $query->execute([$password, $user['id']]);

                    $_SESSION['USER'] = $user['id'];
                    Helper::RedirectFlash('success', 'Votre mot de passe a bien été modifié', $r->url('profile'));
                } else {
                    Flash::flash('danger', "Le mot de passe est trop court"); 
                }
            } else {
                Flash::flash('danger', "les mots de passe ne sont pas identiques"); 
            }
        } else {
            Flash::flash('danger', 'Merci de remplir les champs');
        }
    }

?>

<div class="container mt-4">
    <div class="card m-auto w-75 text-center p-3">
        <div class="card-body">
            <h6 class="display-6 mb-3">Rénitialiser mon mot de passe</h6>
            <form action="" method="post">
                <div class="form-group mb-2">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="form-group mb-2">
                    <input type="password" class="form-control" name="password_repeat" placeholder="Rétaper le mot de passe" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Modifier</button>
            </form>
        </div>
    </div>
</div>