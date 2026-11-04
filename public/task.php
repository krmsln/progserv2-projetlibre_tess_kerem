<?php
require_once __DIR__ . '/../src/autoload.php';

// Seul le manager peut créer une tâche
SessionManager::requireManager();

$db = new Database();
$taskManager = new TaskManager($db);
$projectManager = new ProjectManager($db);
$userManager = new UserManager($db);

// Récupérer les listes pour les menus déroulants
$projects = $projectManager->getProjects();
$users = $userManager->getUsers();
$statusTypes = $taskManager->getStatusTypes();
$priorityLevels = $taskManager->getPriorityLevels();

$error = '';

$title = '';
$description = '';
$dueDate = '';
$idProject = '';
$idUser = '';
$idPriorityLevel = '';
$idStatusType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $dueDate = trim($_POST['due_date'] ?? '');
    $idProject = $_POST['id_project'] ?? '';
    $idUser = $_POST['id_user'] ?? '';
    $idPriorityLevel = $_POST['id_priority_level'] ?? '';
    $idStatusType = $_POST['id_status_type'] ?? '';

    if (empty($title) || empty($dueDate) || empty($idProject) || empty($idPriorityLevel) || empty($idStatusType)) {
        $error = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Vérifier que le projet existe
        $projectExists = $projectManager->getProjectById((int) $idProject) !== null;

        // Vérifier que l'utilisateur existe (si un utilisateur est sélectionné)
        $assignedUserId = null;
        $userValid = true;
        if ($idUser !== '') {
            $assignedUserId = (int) $idUser;
            if ($userManager->getUserById($assignedUserId) === null) {
                $userValid = false;
            }
        }

        // Vérifier que la priorité existe
        $priorityExists = false;
        foreach ($priorityLevels as $priority) {
            if ((int) $priority['id'] === (int) $idPriorityLevel) {
                $priorityExists = true;
                break;
            }
        }

        // Vérifier que le statut existe
        $statusExists = false;
        foreach ($statusTypes as $status) {
            if ((int) $status['id'] === (int) $idStatusType) {
                $statusExists = true;
                break;
            }
        }

        if (!$projectExists) {
            $error = "Le projet sélectionné n'existe pas.";
        } elseif (!$userValid) {
            $error = "L'utilisateur sélectionné n'existe pas.";
        } elseif (!$priorityExists) {
            $error = "La priorité sélectionnée n'existe pas.";
        } elseif (!$statusExists) {
            $error = "Le statut sélectionné n'existe pas.";
        } else {
            try {
                $newTask = new Task(
                    null,
                    $title,
                    $description,
                    date('Y-m-d H:i:s'),
                    $dueDate,
                    $assignedUserId,
                    (int) $idProject,
                    (int) $idStatusType,
                    (int) $idPriorityLevel
                );

                if ($taskManager->addTask($newTask)) {
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = "Erreur lors de la création de la tâche.";
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
    <title>TeamBoard - Nouvelle tâche</title>
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
            <h2>Créer une nouvelle tâche</h2>

            <?php if (!empty($error)): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="task.php">
                <div>
                    <label for="title">Titre de la tâche :</label>
                    <input type="text" id="title" name="title" required maxlength="150"
                        value="<?= htmlspecialchars($title) ?>">
                </div>

                <div>
                    <label for="description">Description :</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($description) ?></textarea>
                </div>

                <div>
                    <label for="due_date">Date d'échéance :</label>
                    <input type="date" id="due_date" name="due_date" required
                        value="<?= htmlspecialchars($dueDate) ?>">
                </div>

                <div>
                    <label for="id_project">Projet :</label>
                    <select id="id_project" name="id_project" required>
                        <option value="">-- Choisir un projet --</option>
                        <?php foreach ($projects as $project): ?>
                            <option value="<?= $project->getId() ?>"
                                <?= (string) $idProject === (string) $project->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($project->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="id_user">Assigner à un utilisateur (optionnel) :</label>
                    <select id="id_user" name="id_user">
                        <option value="">-- Aucun utilisateur --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user->getId() ?>"
                                <?= (string) $idUser === (string) $user->getId() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="id_priority_level">Priorité :</label>
                    <select id="id_priority_level" name="id_priority_level" required>
                        <option value="">-- Choisir une priorité --</option>
                        <?php foreach ($priorityLevels as $priority): ?>
                            <option value="<?= $priority['id'] ?>"
                                <?= (string) $idPriorityLevel === (string) $priority['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($priority['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="id_status_type">Statut :</label>
                    <select id="id_status_type" name="id_status_type" required>
                        <option value="">-- Choisir un statut --</option>
                        <?php foreach ($statusTypes as $status): ?>
                            <option value="<?= $status['id'] ?>"
                                <?= (string) $idStatusType === (string) $status['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($status['label']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit">Créer la tâche</button>
            </form>

            <p>
                <a href="dashboard.php">Retour au tableau de bord</a>
            </p>
        </section>
    </main>
</body>

</html>
