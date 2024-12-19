<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selection'])) {
    $fichier = "candidats_selectionnes.txt";
    $contenu = "";

    foreach ($_POST['selection'] as $candidat) {
        $contenu .= $candidat . PHP_EOL;
    }

    file_put_contents($fichier, $contenu);
    header("Content-Disposition: attachment; filename=$fichier");
    readfile($fichier);
    exit;
}
?>
