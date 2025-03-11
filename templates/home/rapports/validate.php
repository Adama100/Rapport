<?php

use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;
use App\Helper\Helper;

PHPSession::start();
UserChecker::statusCheck('agence', $r->url('profile'));

    $id = (int)$params['id'];

    if (isset($_GET['action'])) {

        $action = (int)$_GET['action'];

        if ($action !== 'valide' && $action !== 'rejete') {
            Helper::RedirectFlash('danger', 'Action invalide', $r->url('profile'));
        }
        $new_status = $action === 'valide' ? 'valide' : 'rejete';


        $comment = isset($_POST['comment']) ? $_POST['comment'] : '';


        $query = $pdo->prepare("UPDATE reports SET status = :status, updated_at = NOW() WHERE id = :id");
        $query->execute(['status' => $new_status, 'id' => $id]);


        $query = $pdo->prepare("SELECT user_id FROM reports WHERE id = ?");
        $query->execute([$id]);
        $guichet = $query->fetch();
        $guichet_id = $guichet['user_id'];

        $query = $pdo->prepare("INSERT INTO reports_comments (report_id, user_id, action, comment) VALUES (:report_id, :user_id, :action, :comment)");
        $stmt->execute([
            'report_id' => $id,
            'user' => $guichet_id,
            'action' => $new_status,
            'comment' => $comment
        ]);


        $query = $pdo->prepare("SELECT email FROM users WHERE id = ?");
        $query->execute([$guichet_id]);
        $guichet_email = $query->fetchColumn();

        ## Envoi de la notification par email
        $subject = "Votre rapport a été " . ($new_status === 'validé' ? 'validé' : 'rejeté');
        $message = "Bonjour,\n\nVotre rapport a été " . ($new_status === 'validé' ? 'validé' : 'rejeté') . " par l'agence.\n\nCordialement,\nL'équipe de gestion.";

        Helper::redirectFlash('success', "Le rapport a été $new_status avec succès", $r->url('profile'));
    } else {
        Helper::redirectFlash('danger', "Aucun rapport ou action spécifiée", $r->url('profile'));
    }

?>

<div class="container">
    <h5>Ajouter un commentaire</h5> <!-- Modal -->

</div>