<?php
require_once __DIR__ . '/../src/autoload.php';


SessionManager::requireManager();

$db = new Database();
$projectManager = new ProjectManager($db);

// Récupérer les statuts disponibles
$statusTypes = $projectManager->getStatusTypes();

$error = '';
$success = '';

$name = '';
$description = '';
$idStatusType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des données du formulaire
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $idStatusType = $_POST['id_status_type'] ?? '';

    // Validation des données.
    if (empty($name) || empty($idStatusType)) {
        $error = "Le nom et le statut du projet sont obligatoires.";
    } elseif ($idStatusType === '') {
        $error = "Le statut sélectionné est invalide.";
    } else {

        // Vérifie que le statut existe dans la base de données
        $statusExists = false;

        foreach ($statusTypes as $status) {
            if ((int) $status['id'] === (int) $idStatusType) {
                $statusExists = true;
                break;
            }
        }

        if (!$statusExists) {
            $error = "Le statut sélectionné n'existe pas.";
        } else {

            try {
                // Création d'un nouvel objet Project
                $newProject = new Project(null, $name, $description, date('Y-m-d H:i:s'), (int) $idStatusType);

                // Ajout du projet dans la base de données
                if ($projectManager->addProject($newProject)) {

                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = "Erreur lors de la création du projet.";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamBoard - Nouveau projet</title>
</head>

<body>
    <header>
        <h1>TeamBoard</h1>

        <nav>
            <a href="index.php">Accueil</a> |
            <a href="dashboard.php">Tableau de bord</a> |
            <a href="profile.php">Mon profil</a> |
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main>

        <section>
            <h2>Créer un nouveau projet</h2>

            <?php if (!empty($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="project.php">

                <div>
                    <label for="name">Nom du projet :</label>

                    <input
                        type="text" id="name" name="name" required maxlength="100" value="<?= htmlspecialchars($name) ?>">
                </div>

                <div>
                    <label for="description">Description :</label>

                    <textarea
                        id="description" name="description"><?= htmlspecialchars($description) ?></textarea>
                </div>

                <div>
                    <label for="id_status_type">Statut :</label>

                    <select id="id_status_type" name="id_status_type" required>

                        <option value="">-- Choisir un statut --</option>

                        <?php foreach ($statusTypes as $status): ?>

                            <option
                                value="<?= $status['id'] ?>"
                                <?= (string) $idStatusType === (string) $status['id'] ? 'selected' : '' ?>>

                                <?= htmlspecialchars($status['label']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <button type="submit">Créer le projet</button>

            </form>

            <p>
                <a href="dashboard.php">Retour au tableau de bord</a>
            </p>

        </section>

    </main>

</body>

</html>
