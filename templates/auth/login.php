<?php

use App\Domain\App;
use App\Domain\Application\Security\TokenCsrf;
use App\Domain\Application\Session\Flash;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::UserConnected($r->url('profile'));

    $title = "Se connecter";
    $nav = "login";
    $error = false;

    if(!empty($_POST)) {

        if (!TokenCsrf::validateToken($_POST['csrf'])) {
            Flash::flash('danger', 'Token CSRF invalide');
            header('Location: ' . $r->url('login')); exit;
        }

        $pdo = App::getPDO();
        $auth = App::getAuth();

        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $remeber = $_POST['remember'] ?? null;

        try {
            $user = $auth->login($username, $password, $remeber);
        } catch(Exception $e) {
            Flash::flash('danger', $e->getMessage());
            header('Location: ' . $r->url('login')); exit;
        }
        if($user) {
            header('Location: ' . $r->url('profile')); exit; 
        } else {
            password_hash($password, PASSWORD_ARGON2I);
            $error = true;
        }
    }

?>

<main>
    <p class="lead text-center">
        Entrez vos informations de connexion pour accéder à votre compte et continuer votre tableau de bord
    </p>
    <div class="form-signin w-100 m-auto">
        <form action="" method="post">
            <?= TokenCSRF::getFormField() ?>
            <h1 class="display-6 mb-3 fw-normal">Se connecter</h1>
            <div class="form-floating">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" autofocus required autocomplete="off" value="<?= isset($_POST['username']) ? htmlentities($_POST['username']) : '' ?>">
                <label class="label" for="floatingInput">NOM D'UTILISATEUR OU EMAIL</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required autocomplete="off">
                <label class="label" for="floatingPassword">MOT DE PASSE</label>
            </div>
            <?php if($error): ?>
                <div class="text-danger text-center p-2 rounded-3 bg-danger-subtle lead mt-3">
                    Identifiant ou mot de passe incorrect &#41;&#58;
                </div>
            <?php endif; ?>
            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Se souvenir de moi
                </label>
                <div class="mt-3">
                    <a class="text-decoration-none text-danger" href="<?= $r->url('forget') ?>">Mot de passe oublié !</a>
                </div>
            </div>
            <button class="btn btn-warning w-100 py-2" type="submit">Se connecter</button>
        </form>
    </div>
</main>