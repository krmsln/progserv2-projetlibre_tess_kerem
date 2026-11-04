<?php
require_once __DIR__ . '/../src/autoload.php';

// Bloque les utilisateurs non connectés
SessionManager::requireLogin();

// Connexion à la base de données
$db = new Database();

$dashboardManager = new DashboardManager($db);

// Récupérer les informations de l'utilisateur connecté
$userId = SessionManager::getUserId();
$userName = SessionManager::getUserName();
$userRole = SessionManager::getUserRole();

// Vérifier le rôle de l'utilisateur
$isManager = false;

if ($userRole == SessionManager::ROLE_MANAGER) {
    $isManager = true;
}

// Récupérer les données du tableau de bord
if ($isManager) {

    // Données du manager
    $projectCount = $dashboardManager->getProjectCount();
    $taskCounts = $dashboardManager->getTaskCounts();
    $upcomingTasks = $dashboardManager->getUpcomingTasks();
    $projects = $dashboardManager->getDashboardProjects();
} else {

    // Données du collaborateur
    $taskCounts = $dashboardManager->getTaskCounts($userId);
    $upcomingTasks = $dashboardManager->getUpcomingTasks($userId);
    $projects = $dashboardManager->getDashboardProjects($userId);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamBoard - Tableau de bord</title>
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

        <h2>Bonjour <?= htmlspecialchars($userName) ?> !</h2>

        <?php if ($isManager): ?>

            <!-- isManager === true => Tableau de bord manager -->

            <section>
                <h2>Vue d'ensemble</h2>

                <p>
                    <strong>Total des projets :</strong>
                    <?= $projectCount ?>
                </p>

                <p>
                    <strong>Tâches à faire :</strong>
                    <?= $taskCounts['À faire'] ?>
                </p>

                <p>
                    <strong>Tâches en cours :</strong>
                    <?= $taskCounts['En cours'] ?>
                </p>

                <p>
                    <strong>Tâches terminées :</strong>
                    <?= $taskCounts['Terminé'] ?>
                </p>
            </section>

        <?php else: ?>

            <!-- //isManager === false => Tableau de bord collaborateur -->

            <section>
                <h2>Vue d'ensemble</h2>

                <p>
                    <strong>Tâches à faire :</strong>
                    <?= $taskCounts['À faire'] ?>
                </p>

                <p>
                    <strong>Tâches en cours :</strong>
                    <?= $taskCounts['En cours'] ?>
                </p>

                <p>
                    <strong>Tâches terminées :</strong>
                    <?= $taskCounts['Terminé'] ?>
                </p>
            </section>

        <?php endif; ?>


        <!-- échéances des 7 prochain jours -->

        <section>
            <h2>Échéances des 7 prochains jours</h2>

            <?php if (count($upcomingTasks) > 0): ?>

                <table>
                    <thead>
                        <tr>
                            <th>Tâche</th>
                            <th>Projet</th>
                            <th>Échéance</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($upcomingTasks as $task): ?>

                            <tr>
                                <td>
                                    <?= htmlspecialchars($task['title']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($task['project_name']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($task['due_date']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($task['priority']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($task['status']) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>

                <p>Aucune échéance prévue dans les 7 prochains jours.</p>

            <?php endif; ?>
        </section>


        <!-- Liste des projets -->

        <section>
            <h2>Mes projets</h2>

            <?php if (count($projects) > 0): ?>

                <ul>
                    <?php foreach ($projects as $project): ?>

                        <li>
                            <?= htmlspecialchars($project['name']) ?>
                        </li>

                    <?php endforeach; ?>
                </ul>

            <?php else: ?>

                <p>Aucun projet à afficher.</p>

            <?php endif; ?>
        </section>


        <!-- Bouton manager -->

        <?php if ($isManager): ?>

            <section>
                <h2>Gestion</h2>

                <a href="project.php?mode=create">
                    <button type="button">Nouveau projet</button>
                </a>

                <a href="task.php?mode=create">
                    <button type="button">Nouvelle tâche</button>
                </a>
            </section>

        <?php endif; ?>

    </main>

</body>

</html>
