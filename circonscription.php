<?php
require_once 'db.php';

// Récupérer les circonscriptions pour la liste déroulante
$queryCir = "SELECT idCirconscription, nomCir FROM Circonscription";
$stmtCir = $pdo->prepare($queryCir);
$stmtCir->execute();
$circonscriptions = $stmtCir->fetchAll(PDO::FETCH_ASSOC);

// Afficher les candidats en tête
$candidats = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCir = $_POST['idCirconscription'];
    $queryCand = "SELECT nomCandidat, prenomCandidat, niveauScolaire 
                  FROM Candidat 
                  WHERE idCirconscription = ? AND NumOrdreListe = 1";
    $stmtCand = $pdo->prepare($queryCand);
    $stmtCand->execute([$idCir]);
    $candidats = $stmtCand->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Candidats en tête</title>
</head>
<body>
    <h1>Candidats en tête des listes</h1>
    <form method="POST">
        <label for="idCirconscription">Choisissez une circonscription :</label>
        <select name="idCirconscription" id="idCirconscription" required>
            <option value="">--Sélectionner--</option>
            <?php foreach ($circonscriptions as $cir): ?>
            <option value="<?= $cir['idCirconscription']; ?>"><?= htmlspecialchars($cir['nomCir']); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Afficher</button>
    </form>

    <?php if (!empty($candidats)): ?>
    <form method="POST" action="produire_fichier.php">
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Niveau scolaire</th>
                <th>Sélection</th>
            </tr>
            <?php foreach ($candidats as $candidat): ?>
            <tr>
                <td><?= htmlspecialchars($candidat['nomCandidat']); ?></td>
                <td><?= htmlspecialchars($candidat['prenomCandidat']); ?></td>
                <td><?= htmlspecialchars($candidat['niveauScolaire']); ?></td>
                <td><input type="checkbox" name="selection[]" value="<?= htmlspecialchars($candidat['nomCandidat']); ?>"></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Produire</button>
    </form>
    <?php endif; ?>
</body>
</html>
