<?php
require_once 'db.php';

// Récupérer les initiales des circonscriptions
$queryInitiales = "SELECT DISTINCT LEFT(nomCir, 1) AS initiale FROM Circonscription ORDER BY initiale";
$stmtInitiales = $pdo->prepare($queryInitiales);
$stmtInitiales->execute();
$initiales = $stmtInitiales->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les circonscriptions par initiale
$circonscriptions = [];
if (isset($_GET['initiale'])) {
    $initiale = $_GET['initiale'] . '%';
    $queryCir = "SELECT idCirconscription, nomCir FROM Circonscription WHERE nomCir LIKE ? ORDER BY nomCir";
    $stmtCir = $pdo->prepare($queryCir);
    $stmtCir->execute([$initiale]);
    $circonscriptions = $stmtCir->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer les partis pour une circonscription donnée
$partis = [];
if (isset($_GET['idCirconscription'])) {
    $idCir = $_GET['idCirconscription'];
    $queryPartis = "SELECT nomParti FROM Parti 
                    INNER JOIN Candidat ON Parti.idParti = Candidat.idParti 
                    WHERE idCirconscription = ? 
                    GROUP BY Parti.idParti";
    $stmtPartis = $pdo->prepare($queryPartis);
    $stmtPartis->execute([$idCir]);
    $partis = $stmtPartis->fetchAll(PDO::FETCH_COLUMN);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche des circonscriptions</title>
</head>
<body>
    <h1>Recherche des circonscriptions</h1>

    <h2>Initiales</h2>
    <?php foreach ($initiales as $initiale): ?>
        <a href="?initiale=<?= $initiale; ?>"><?= $initiale; ?></a>
    <?php endforeach; ?>

    <?php if (!empty($circonscriptions)): ?>
    <h2>Circonscriptions commençant par "<?= htmlspecialchars($_GET['initiale']); ?>"</h2>
    <ul>
        <?php foreach ($circonscriptions as $cir): ?>
            <li><a href="?idCirconscription=<?= $cir['idCirconscription']; ?>"><?= htmlspecialchars($cir['nomCir']); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php if (!empty($partis)): ?>
    <h2>Partis associés à la circonscription</h2>
    <ul>
        <?php foreach ($partis as $parti): ?>
            <li><?= htmlspecialchars($parti); ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total : <?= count($partis); ?> partis</strong></p>
    <?php endif; ?>
</body>
</html>
