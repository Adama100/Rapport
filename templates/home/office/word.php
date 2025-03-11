<?php

use PhpOffice\PhpWord\PhpWord;

if (isset($_GET['rapport'])) {
    $rapport = $_GET['rapport'];
    // Créer une nouvelle instance de PHPWord
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Ajouter le contenu du rapport
    $section->addText($rapport);

    // Sauvegarder le fichier Word
    $file = 'rapport.docx';
    $phpWord->save($file, 'Word2007');

    // Télécharger le fichier Word
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file); // Supprimer le fichier après téléchargement
} else {
    echo "Aucun rapport à afficher.";
}
