<?php
require_once __DIR__ . '/../src/autoload.php';
//Pour la réutilisation d'interfaces (fonction render).
require_once __DIR__ . '/../src/functions.php';


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

<?php
//head: utilisation de la fonction render() afin d'afficher le contenue du fichier head
render('head', ['title' => "TeamBoard - Nouveau projet", 'description' => "TeamBoard - Votre application web de gestion de projets - Nouveau projet"]);
?>

<body>
    <?php
    // Header : utilisation de la fonction render() afin d'intégrer le contenu du fichier header.
    render('header', [
        'showIndex' => true,
        'showDashboard' => true,
        'showProfile' => true,
        'showAuth' => false,
        'showLogout' => true
    ]);?>

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
