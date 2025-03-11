<?php


    // Boutons pour générer le PDF ou Word
    echo "<a href='generate_pdf.php?rapport=" . urlencode($rapport) . "' target='_blank'>Prévisualiser en PDF</a> | ";
    echo "<a href='generate_word.php?rapport=" . urlencode($rapport) . "' target='_blank'>Prévisualiser en Word</a>";


use TCPDF;

if (isset($_GET['rapport'])) {
    $rapport = $_GET['rapport'];

    // Créer une instance de TCPDF
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Ajouter le contenu du rapport
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Write(0, $rapport);

    // Télécharger le PDF
    $pdf->Output('rapport.pdf', 'I');  // 'I' pour afficher dans le navigateur
} else {
    echo "Aucun rapport à afficher.";
}
