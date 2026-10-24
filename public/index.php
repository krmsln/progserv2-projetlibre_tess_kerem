<?php
require_once __DIR__ . '/../src/autoload.php';

$db = new Database();
$pdo = $db->getConnection();

// requete test sur users
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamBoard</title>
</head>

<body>
    <h1>TeamBoard</h1>

    <p>Bienvenue dans votre projet PHP pour le cours ProgServ2 à la HEIG-VD !</p>

    <h2>Utilisateurs de la base de données :</h2>

    <ul>
        <?php foreach ($results as $row) { ?>
            <li>ID: <?= htmlspecialchars($row['id']) ?>
                <ul>
                    <li>Column1: <?= htmlspecialchars($row['name']) ?></li>
                    <li>Column2: <?= htmlspecialchars($row['email_address']) ?></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</body>

</html>
