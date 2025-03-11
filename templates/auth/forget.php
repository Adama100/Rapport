<?php

use App\Domain\App;
use App\Domain\Application\Session\Flash;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Entity\User;
use App\Helper\Helper;
use App\Infrastructure\Environment\EnvLoader;
use App\Infrastructure\Mailing\Mailer;

PHPSession::start();
EnvLoader::load(ENV_PATH);

    $errors = false;
    if(!empty($_POST) && !empty($_POST['email'])) {

        $pdo = App::getPDO();
        $email = htmlspecialchars(mb_strtolower(trim($_POST['email'])));

        $check = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $check->execute([$email]);
        $check->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $check->fetch();

        if($user) {

            $token = bin2hex(openssl_random_pseudo_bytes(64));
            $pdo->prepare('UPDATE users SET reset_password_token = ?, reset_password_at = NOW() WHERE id = ?')
                ->execute([$token, $user->getId()]);

            $link = EnvLoader::get('URL') . $r->url('reset') . '?id=' . $user->getId() . '&token=' . $token;

            $sujet = "Reinitialisation de votre mot de passe";
            $messages = Mailer::getPage('../templates/mails/auth/password_reset.php',[
                'link' => $link,
                'pseudo' => $user->getUsername()
            ] );
            try {
                $mail = new Mailer();
                $mail->token($email, $sujet, $messages);
                Helper::RedirectFlash('success', 'Les instructions du rappel du mot de passe vous ont été envoyé par email', $r->url('login'));
            } catch (Exception $e) {
                Flash::flash('danger', 'Message non envoyé: ' . $e->getMessage());
            }
        } else {
            $errors = true;
        }
    }
?>

<div class="container">
    <h6 class="display-6 text-center text-primary w-50 m-auto mb-3">Mot de passe oublié</h6>
    <div class="card m-auto w-50 p-3 border border-none">
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="email" class="form-label lead">EMAIL</label>
                    <input type="email" class="form-control <?= $errors ? 'is-invalid' : '' ?>" name="email" placeholder="Votre email" id="email" value="<?php if(isset($_POST['email'])): ?><?= htmlspecialchars($_POST['email']) ?><?php endif; ?>" autofocus autocomplete="off" required>
                    <?php if($errors): ?>
                    <div class="invalid-feedback">
                        Aucun compte ne correspond à cette adresse
                    </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary mt-3">M'envoyer les instructions</button>
            </form>
        </div>
    </div>
</div>