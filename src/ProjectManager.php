<?php

// Classe qui gère les projets.
class ProjectManager {
    private PDO $pdo;

    public function __construct(Database $database) {
        $this->pdo = $database->getConnection();
    }


    //Récupère tous les projets.
    public function getProjects(): array {
        $sql = "SELECT * FROM projects";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $requestResults = $stmt->fetchAll();

        $projects = [];

        foreach ($requestResults as $row) {
            $projects[] = new Project(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['creation_date'],
                $row['id_status_type']
            );
        }

        return $projects;
    }


    // Récupère un projet grâce à son identifiant.
    public function getProjectById(int $id): ?Project {
        $sql = "SELECT * FROM projects WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Project(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['creation_date'],
            $row['id_status_type']
        );
    }

    //Ajoute un projet.
    public function addProject(Project $project): bool {
        $sql = "INSERT INTO projects (name, description, creation_date, id_status_type)
                VALUES (:name, :description, :creation_date, :id_status_type)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'creation_date' => $project->getCreationDate(),
            'id_status_type' => $project->getIdStatusType()
        ]);
    }

    // Modifie les informations d'un projet.
    public function updateProject(Project $project): bool {
        if ($project->getId() === null) {
            return false;
        }

        $sql = "UPDATE projects
                SET name = :name,
                    description = :description,
                    creation_date = :creation_date,
                    id_status_type = :id_status_type
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'name' => $project->getName(),
            'description' => $project->getDescription(),
            'creation_date' => $project->getCreationDate(),
            'id_status_type' => $project->getIdStatusType(),
            'id' => $project->getId()
        ]);
    }

    //Supprime un projet grâce à son identifiant.
    public function removeProject(int $id): bool {
        $sql = "DELETE FROM projects WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
