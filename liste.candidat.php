<?php
require_once 'db.php';

$query = "SELECT nomCandidat, prenomCandidat, DateNC 
          FROM Candidat 
          WHERE niveauScolaire = 'supérieur' 
          ORDER BY nomCandidat ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$candidats = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des candidats</title>
</head>
<body>
    <h1>Liste des candidats (niveau scolaire : supérieur)</h1>
    <table border="1">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Date de naissance</th>
        </tr>
        <?php foreach ($candidats as $candidat): ?>
        <tr>
            <td><?= htmlspecialchars($candidat['nomCandidat']); ?></td>
            <td><?= htmlspecialchars($candidat['prenomCandidat']); ?></td>
            <td><?= htmlspecialchars($candidat['DateNC']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
