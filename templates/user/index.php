<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Auth;
use App\Domain\Auth\Security\UserChecker;
use App\Normalizer\Breadcrumb\Breadcrumb;

PHPSession::start();
UserChecker::UserNotConnected($r->url('login'));

    $title = "Mon compte";
    $nav = "profile";

    $pdo = App::getPDO();
    Auth::cookie($pdo);
    $user = App::getAuth()->user();

    $crumb = new Breadcrumb();
    $crumb
        ->addCrumb('Accueil', $r->url('index'))
        ->addCrumb('Profile', $r->url('profile'));

    $stmt = $pdo->prepare("SELECT * FROM reports WHERE user_id = ? AND status = 'en attente'");
    $stmt->execute([$user->getId()]);
    $reports = $stmt->fetch();

    ## Récupérer la date de début de la semaine actuelle
    $semaine = new DateTime();
    $semaine->setISODate($semaine->format('Y'), $semaine->format('W'));
    $date_debut_semaine = $semaine->format('Y-m-d');

    if($user->getStatus() === 'agence') {
        $result = $pdo->query("SELECT r.*, u.username
            FROM reports r
            JOIN users u ON u.id = r.user_id
            WHERE r.status = 'en attente'
            AND u.status = 'guichet'
            AND r.created_at >= $date_debut_semaine
        ")->fetchAll();
    }

    $reports_historiques = $pdo->prepare("SELECT r.*, u.username
        FROM reports r
        JOIN users u ON u.id = r.user_id
        WHERE r.user_id = ?
        ORDER BY r.created_at DESC
    ");
    $reports_historiques->execute([$user->getId()]);
    $historiques = $reports_historiques->fetchAll();

?>

<?= $crumb->render() ?>

<div class="container mb-3">
    <h6 class="display-6">Bienvenue guichet <span class="text-primary fw-bold"><?= $user->getUsername() ?></span></h6>
    <p class="lead">
        Commencez par soumettre vos rapports hebdomadaires ou consultez les rapports existants
    </p>
</div>

<nav-tabs class="nav-pills mb-4">
    <a href="#profil" aria-selected="true">Mon compte</a>
    <?php if($user->getStatus() === 'agence' || $user->getRole() === 'super admin'): ?>
    <a href="#rapports">Rapport de cette semaine</a>
    <?php endif; ?>
    <a href="#historiques">Historiques</a>
</nav-tabs>

<div class="container">
    <div id="profil">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h3 class="display-6">Rapport soumis cette semaine</h3>
            <a href="<?= $r->url('rapport.new') ?>" class="btn btn-primary">Soumettre un nouveau rapport</a>
        </div>

        <?php if(!$reports): ?>
            <div class="text-center mt-4">
                <h2>Aucun <span class="text-primary">rapport</span> :(</h2>
                <p class="lead">
                    Aucun rapport disponible pour cette période
                </p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Titre</th>
                    <th>Status</th>
                    <th>Date de soumission</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td><?= $reports['title'] ?></td>
                    <td><?= $reports['status'] ?></td>
                    <td><?= $reports['created_at'] ?></td>
                    <td>
                        <a href="<?= $r->url('rapport.show', ['id' => $reports['id']]) ?>" class="btn btn-sm btn-success">Voir</a>

                        <!-- Form -->
                        <a href="<?= $r->url('rapport.edit', ['id' => $reports['id']]) ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="<?= $r->url('rapport.delete', ['id' => $reports['id']]) ?>" class="btn btn-sm btn-warning">Supprimer</a>

                        <!-- ?rapport=" . urlencode($rapport) . " -->
                        <a href="" target='_blank'>Prévisualiser en pdf</a>
                    </td>
                </tr>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <?php if($user->getStatus() === 'agence' || $user->getRole() === 'super admin'): ?>
    <div id="rapports">
        <h2 class="display-5">Gestion des rapports de cette semaine</h2>
        <p class="lead">
            Consultez les rapports soumis par les guichets et validez ou rejetez-les
        </p>
        <a href="" class="btn btn-warning">Générer le rapport globale</a>
        <p class="lead">
            Si vous générez le rapport globale il prendra en compte que les rapports que vous avez validé
        </p>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guichet</th>
                    <th>Rapport</th>
                    <th>Date de soumission</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($result as $res): ?>
                <tr>
                    <td>#<?= $res['id'] ?></td>
                    <td><?= $res['username'] ?></td>
                    <td>Content</td>
                    <td><?= $res['created_at'] ?></td>
                    <td>
                        <a href="?action=valide" class="btn btn-outline-success">Valider</a> |
                        <a href="?action=rejete" class="btn btn-outline-danger">Rejeter</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div id="historiques">
        <!-- Ou utiliser JQuery -->
        <form action="" method="GET">
            <label for="nom_guichet">Nom de Guichet :</label>
            <input type="text" name="nom_guichet" id="nom_guichet">
            <label for="date_rapport">Date (ou semaine) :</label>
            <input type="date" name="date_rapport" id="date_rapport">
            <label for="statut">Statut :</label>
            <select name="statut" id="statut">
                <option value="">Tous</option>
                <option value="en attente">En attente</option>
                <option value="validé">Validé</option>
                <option value="rejeté">Rejeté</option>
            </select>
            <button type="submit">Rechercher</button>
        </form>

        <h5 class="display-5">Historique des rapports soumis</h5>
        <?php if(empty($historiques)): ?>
            <div class="text-center mt-4">
                <h2>Aucun <span class="text-primary">rapport</span> :(</h2>
                <p class="lead">
                    Aucun contenu ne correspond à votre recherche
                </p>
            </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Guichet</th>
                        <th>Date de soumission</th>
                        <th>Statut</th>
                        <th>Commentaire</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody> <!-- Afficher le commentaire associés -->
                    <?php foreach($historiques as $h): ?>
                    <tr>
                        <td><?= $h['username'] ?></td>
                        <td><?= $h['created_at'] ?></td>
                        <td><?= $h['status'] ?></td>
                        <td>Comment</td>
                        <td>
                            <a href="<?= $r->url('rapport.show', ['id' => $h['id']]) ?>">Voir</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>