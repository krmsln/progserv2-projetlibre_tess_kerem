<?php
// Classe qui gère les données du tableau de bord
class DashboardManager {
    private PDO $pdo;

    public function __construct(Database $database) {
        $this->pdo = $database->getConnection();
    }

    // Récupère le nombre de tâches selon leur statut
    public function getTaskCounts(?int $userId = null): array {
        $sql = "SELECT
                    status_types.label,
                    COUNT(tasks.id) AS total
                FROM status_types
                LEFT JOIN tasks
                    ON tasks.id_status_type = status_types.id";

        if ($userId !== null) {
            $sql .= " AND tasks.id_user = :id_user";
        }

        $sql .= " GROUP BY status_types.id, status_types.label";

        $stmt = $this->pdo->prepare($sql);

        if ($userId !== null) {
            $stmt->execute([
                'id_user' => $userId
            ]);
        } else {
            $stmt->execute();
        }

        $requestResults = $stmt->fetchAll();

        $taskCounts = [
            'À faire' => 0,
            'En cours' => 0,
            'Terminé' => 0
        ];

        foreach ($requestResults as $row) {
            $taskCounts[$row['label']] = (int) $row['total'];
        }

        return $taskCounts;
    }


    // Récupère le nombre total de projets
    public function getProjectCount(): int {
        $sql = "SELECT COUNT(*) FROM projects";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }


    // Récupère les échéances des 7 prochains jours
    // Aide de l'IA pour la requête SQL permettant récupèrer les échéances des 7 prochains jours
    public function getUpcomingTasks(?int $userId = null): array {
        $sql = "SELECT
                    tasks.id,
                    tasks.title,
                    projects.name AS project_name,
                    tasks.due_date,
                    priority_levels.label AS priority,
                    status_types.label AS status
                FROM tasks
                INNER JOIN projects
                    ON tasks.id_project = projects.id
                INNER JOIN priority_levels
                    ON tasks.id_priority_level = priority_levels.id
                INNER JOIN status_types
                    ON tasks.id_status_type = status_types.id
                WHERE tasks.due_date BETWEEN CURDATE()
                    AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";

        if ($userId !== null) {
            $sql .= " AND tasks.id_user = :id_user";
        }

        $sql .= " ORDER BY tasks.due_date ASC";

        $stmt = $this->pdo->prepare($sql);

        if ($userId !== null) {
            $stmt->execute([
                'id_user' => $userId
            ]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll();
    }


    // Récupère les projets
    public function getDashboardProjects(?int $userId = null): array {

        // Si aucun utilisateur n'est fourni, récupère tous les projets
        if ($userId === null) {
            $sql = "SELECT * FROM projects ORDER BY creation_date DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } else {
            // Récupère les projets auxquels les tâches de l'utilisateur sont rattachées
            $sql = "SELECT DISTINCT projects.*
                    FROM projects
                    INNER JOIN tasks
                        ON projects.id = tasks.id_project
                    WHERE tasks.id_user = :id_user
                    ORDER BY projects.creation_date DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'id_user' => $userId
            ]);
        }

        return $stmt->fetchAll();
    }
}
