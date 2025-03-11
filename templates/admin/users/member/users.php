<?php

use App\Domain\App;
use App\Domain\Application\Builder\PaginatedQuery;
use App\Domain\Application\Builder\QueryBuilder;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Security\UserChecker;
use App\Helper\FilterHelper;

PHPSession::start();
UserChecker::checkRoles(['admin'] ,$r->url('login'));

    $title = "Administration | Utilisateurs";
    $nav = "admin.users";
    $pdo = App::getPDO();

    $query = (new QueryBuilder($pdo, User::class))
        ->from('users', 'u')
        ->where("u.role = 'guichet'")
    ;

    if(!empty($_GET['q'])) {
        $query
            ->where("u.username LIKE :name")
            ->setParam('name', '%' . htmlspecialchars($_GET['q']) . '%');
    }

    $tableQuery = new PaginatedQuery($query, $_GET, 30);
    $tableQuery
        ->sortable('id', 'username', 'email');
    [$users, $pages] = $tableQuery->queryFetchRender();

?>

<div class="container">
    <form action="" method="get">
        <div class="form-group">
            <input type="text" class="form-control" name="q" placeholder="Rechercher par nom .." value="<?php if(isset($_GET['q'])): ?><?= $_GET['q'] ?><?php endif; ?>">
        </div>
        <button class="btn btn-primary mt-2 mb-3">Rechercher</button>
    </form>

    <h5 class="display-6 mb-3">Gestion des utilisateurs</h5>

    <?php if(empty($users)): ?>
        <div class="text-center mt-4">
            <h2>Aucun <span class="text-primary">utilisateur</span> :(</h2>
            <p class="lead">
                Aucun contenu ne correspond à votre recherche
            </p>
        </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped table-borderless">
            <thead class="table-light">
                <tr>
                    <th><?= FilterHelper::sort('id', 'ID', $_GET) ?></th>
                    <th><?= FilterHelper::sort('username', 'Nom', $_GET) ?></th>
                    <th><?= FilterHelper::sort('email', 'Email', $_GET) ?></th>
                    <th>Role</th>
                    <th class="lead">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $u): ?>
                <tr>
                    <td>#<?= $u->getId() ?></td>
                    <td><?= $u->getUsername() ?></td>
                    <td><?= $u->getEmail() ?></td>
                    <td><?= $u->getRole() ?></td>
                    <td class="d-flex gap-1">
                        <form action="<?= $r->url('admin.user.edit', ['id' => $u->getId()]) ?>" method="post">
                            <button type="submit" class="btn btn-primary btn-sm">Editer</button>
                        </form>
                        <form action="<?= $r->url('admin.user.delete', ['id' => $u->getId()]) ?>" method="post" onsubmit="return confirm('Voulez vous vraiment supprimer l\'utilisateur')">
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center gap-1 my-5">
        <?= $tableQuery->previousLink($pages) ?>
        <?php $tableQuery->renderPageLinks($pages) ?>
        <?= $tableQuery->nextLink($pages) ?>
    </div>
</div>
