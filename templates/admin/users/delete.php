<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\Security\UserChecker;
use App\Helper\Helper;

PHPSession::start();
UserChecker::checkRoles(['super admin', 'admin'], $r->url('login'));

    $id = (int)$params['id'];
    $pdo = App::getPDO();

    $user = new UserRepository($pdo);
    $u = $user->find($id);
    $user->delete($u->getId());
    // Avatar::detach($u->getId(), $u->getAvatar());

    Helper::RedirectFlash('success', 'l\'utilisateur a bien été supprimé', $r->url('admin.users'));
