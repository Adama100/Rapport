<?php

use App\Domain\Application\Session\PHPSession;
use App\Infrastructure\Environment\EnvLoader;

PHPSession::start();
EnvLoader::load(ENV_PATH);

    unset($_SESSION['USER']);
    setcookie('auth', '', time() - 3600, '/', EnvLoader::get('APP_URL'), true, true); # 'localhost'
    header('Location: ' . $r->url('index'));