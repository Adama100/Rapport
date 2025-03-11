<?php

use App\Helper\URLHelper;
use App\Http\Router;

    require dirname(__DIR__) . '/vendor/autoload.php';

    ## DEBUG
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();

    date_default_timezone_set('Africa/Abidjan');
    URLHelper::revomeParam('p');
    define('TEMPLATES_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates');
    define('ENV_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

    $router = new Router(TEMPLATES_PATH);
    $router->setbasePath('/Rapport/public');
    $router
        ->get('/', 'home/index', 'index')

        ->match('/connexion', 'auth/login', 'login')
        ->match('/mot_de_passe', 'auth/forget', 'forget')
        ->match('/renitialiser', 'auth/reset', 'reset')
        ->get('/deconnexion', 'auth/logout', 'logout')

        ->match('/profil', 'user/index', 'profile')

        ->match('/rapports/nouveau', 'home/rapports/new', 'rapport.new')
        ->match('/rapports/details/[i:id]', 'home/rapports/show', 'rapport.show')
        ->match('/rapports/modifier/[i:id]', 'home/rapports/edit', 'rapport.edit')
        ->match('/rapports/supprimer/[i:id]', 'home/rapports/delete', 'rapport.delete')

        ->get('/administration', 'admin/index', 'admin')

        ->get('/administration/utilisateurs', 'admin/users/index', 'admin.users')
        ->get('/administration/utilisateurs/users', 'admin/users/member/users', 'admin.users.users')
        ->get('/administration/utilisateurs/admin', 'admin/users/member/admin', 'admin.users.admin')
        ->match('/administration/utilisateur/nouveau', 'admin/users/new', 'admin.user.new')
        ->match('/administration/utilisateur/modifier/[i:id]', 'admin/users/edit', 'admin.user.edit')
        ->post('/administration/utilisateur/supprimer/[i:id]', 'admin/users/delete', 'admin.user.delete')

        ->get('/administration/rapports', 'admin/rapports/index', 'admin.rapports')

        ->get('/administration/statistiques', 'admin/statistiques/index', 'admin.statistiques')

        ->run()
    ;
