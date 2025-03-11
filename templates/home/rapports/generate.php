<?php

use App\Domain\App;
use App\Domain\Application\Session\PHPSession;
use App\Domain\Auth\Security\UserChecker;

PHPSession::start();
UserChecker::statusCheck('agence', $r->url('profile'));

    $pdo = App::getPDO();

    $query = $pdo->prepare("SELECT * FROM reports WHERE status = 'valide'");
    $query->execute();
    $rapports = $query->fetchAll();


    /*

    SELECT 
        SUM(inscrits) AS total_inscrits,
        SUM(places) AS total_places,
        SUM(suivis) AS total_suivis,
        SUM(offres_traitees) AS total_offres,
        GROUP_CONCAT(DISTINCT difficulties SEPARATOR '\n') AS toutes_difficultes,
        GROUP_CONCAT(DISTINCT recommandations SEPARATOR '\n') AS toutes_recommandations,
        GROUP_CONCAT(DISTINCT objectifs SEPARATOR '\n') AS objectifs_fusionnes,
        GROUP_CONCAT(DISTINCT activites_prevues SEPARATOR '\n') AS activites_fusionnees
    FROM rapports_guichets
    WHERE semaine = (SELECT MAX(semaine) FROM rapports_guichets WHERE statut = 'validé')
    AND statut = 'validé';

    $rapport = $query->fetch(PDO::FETCH_ASSOC);

    */

ob_start();
?>

<div class="container">
    <h1>Rapport Global de la Semaine</h1>

    <h2>1. Statistiques Générales</h2>
    <ul>
        <li><strong>Nombre total de nouveaux inscrits :</strong> <?= $rapport['total_inscrits'] ?></li>
        <li><strong>Nombre de jeunes placés :</strong> <?= $rapport['total_places'] ?></li>
        <li><strong>Nombre de jeunes suivis :</strong> <?= $rapport['total_suivis'] ?></li>
        <li><strong>Nombre d'offres traitées :</strong> <?= $rapport['total_offres'] ?></li>
    </ul>

    <h2>2. Difficultés et Recommandations</h2>
    <p><strong>Difficultés :</strong><br> <?= nl2br($rapport['toutes_difficultes']) ?></p>
    <p><strong>Recommandations :</strong><br> <?= nl2br($rapport['toutes_recommandations']) ?></p>

    <h2>3. Justificatifs</h2>
    <p><strong>Objectifs Principaux :</strong><br> <?= nl2br($rapport['objectifs_fusionnes']) ?></p>
    <p><strong>Activités Prévues :</strong><br> <?= nl2br($rapport['activites_fusionnees']) ?></p>

    <h2>4. Conclusion</h2>
    <p>Résumé général des performances et recommandations pour la semaine prochaine.</p>
</div>

<?php
$html = ob_get_clean();
echo $html; ## Affichage HTML (peut être transformé en PDF ou Word ensuite)


/*
$options = new Options();
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("rapport_global.pdf", ["Attachment" => false]);



use PhpOffice\PhpWord\PhpWord;

$phpWord = new PhpWord();
$section = $phpWord->addSection();
$section->addText("Rapport Global de la Semaine", ['bold' => true, 'size' => 16]);
$section->addText("Nombre total de nouveaux inscrits : " . $rapport['total_inscrits']);
$section->addText("Nombre de jeunes placés : " . $rapport['total_places']);
$section->addText("Difficultés : " . $rapport['toutes_difficultes']);
$section->addText("Recommandations : " . $rapport['toutes_recommandations']);

$file = "rapport_global.docx";
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($file);

header("Content-Disposition: attachment; filename=$file");
readfile($file);
unlink($file);
exit;


Automatiser l’envoi du rapport par email

Verrouillage des rapports

- Lors de la génération du rapport global, les rapports individuels doivent être verrouillés
- Les rapports verrouillés ne doivent pas pouvoir être modifiés ou supprimés par les utilisateurs

*/