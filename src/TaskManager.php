
<?php
//Gérer les tâches dans la base de données.
class TaskManager {
    private PDO $pdo;

    public function __construct(Database $database) {
        $this->pdo = $database->getConnection();
    }

//Récupère toutes les tâches.
    public function getTasks(): array {
        $sql = "SELECT * FROM tasks";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $requestResults = $stmt->fetchAll();

        $tasks = [];

        foreach ($requestResults as $row) {
            $tasks[] = new Task(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['creation_date'],
                $row['due_date'],
                $row['id_user'],
                $row['id_project'],
                $row['id_status_type'],
                $row['id_priority_level']
            );
        }

        return $tasks;
    }

//Récupère une tâche grâce à son identifiant.
    public function getTaskById(int $id): ?Task {
        $sql = "SELECT * FROM tasks WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Task(
            $row['id'],
            $row['title'],
            $row['description'],
            $row['creation_date'],
            $row['due_date'],
            $row['id_user'],
            $row['id_project'],
            $row['id_status_type'],
            $row['id_priority_level']
        );
    }

//Récupère les tâches d'un projet.
    public function getTasksByProjectId(int $projectId): array {
        $sql = "SELECT * FROM tasks WHERE id_project = :id_project";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_project' => $projectId
        ]);

        $requestResults = $stmt->fetchAll();

        $tasks = [];

        foreach ($requestResults as $row) {
            $tasks[] = new Task(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['creation_date'],
                $row['due_date'],
                $row['id_user'],
                $row['id_project'],
                $row['id_status_type'],
                $row['id_priority_level']
            );
        }

        return $tasks;
    }

//Récupère les tâches attribuées à un utilisateur.
    public function getTasksByUserId(int $userId): array {
        $sql = "SELECT * FROM tasks WHERE id_user = :id_user";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id_user' => $userId
        ]);

        $requestResults = $stmt->fetchAll();

        $tasks = [];

        foreach ($requestResults as $row) {
            $tasks[] = new Task(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['creation_date'],
                $row['due_date'],
                $row['id_user'],
                $row['id_project'],
                $row['id_status_type'],
                $row['id_priority_level']
            );
        }

        return $tasks;
    }

//Ajoute une tâche.
    public function addTask(Task $task): bool {
        $sql = "INSERT INTO tasks
                (title, description, creation_date, due_date, id_user,
                 id_project, id_status_type, id_priority_level)
                VALUES
                (:title, :description, :creation_date, :due_date, :id_user,
                 :id_project, :id_status_type, :id_priority_level)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'creation_date' => $task->getCreationDate(),
            'due_date' => $task->getDueDate(),
            'id_user' => $task->getIdUser(),
            'id_project' => $task->getIdProject(),
            'id_status_type' => $task->getIdStatusType(),
            'id_priority_level' => $task->getIdPriorityLevel()
        ]);
    }

//Modifie les informations d'une tâche.
    public function updateTask(Task $task): bool {
        if ($task->getId() === null) {
            return false;
        }

        $sql = "UPDATE tasks
                SET title = :title,
                    description = :description,
                    creation_date = :creation_date,
                    due_date = :due_date,
                    id_user = :id_user,
                    id_project = :id_project,
                    id_status_type = :id_status_type,
                    id_priority_level = :id_priority_level
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'creation_date' => $task->getCreationDate(),
            'due_date' => $task->getDueDate(),
            'id_user' => $task->getIdUser(),
            'id_project' => $task->getIdProject(),
            'id_status_type' => $task->getIdStatusType(),
            'id_priority_level' => $task->getIdPriorityLevel(),
            'id' => $task->getId()
        ]);
    }

//Modifie le statut d'une tâche attribuée à un utilisateur.
    public function updateTaskStatusForUser(
        int $taskId,
        int $userId,
        int $statusId
    ): bool {
        $sql = "UPDATE tasks
                SET id_status_type = :id_status_type
                WHERE id = :id
                AND id_user = :id_user";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id_status_type' => $statusId,
            'id' => $taskId,
            'id_user' => $userId
        ]);
    }

//Supprime une tâche grâce à son identifiant.
    public function removeTask(int $id): bool {
        $sql = "DELETE FROM tasks WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
