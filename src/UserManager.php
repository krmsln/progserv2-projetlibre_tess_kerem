
<?php
//Classe pour gérer les utilisateurs.
class UserManager {
    private PDO $pdo;

    public function __construct(Database $database) {
        $this->pdo = $database->getConnection();
    }

    //Récupère tous les utilisateurs.
    public function getUsers(): array {
        $sql = "SELECT * FROM users";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $requestResults = $stmt->fetchAll();

        $users = [];
        //1 ligne = tous les attributs d’un objet.
        //un objet et ses attributs dans une cellule du tableau
        foreach ($requestResults as $row) {
            $users[] = new User(
                $row['id'],
                $row['name'],
                $row['email_address'],
                $row['password'],
                $row['id_role_type']
            );
        }

        return $users;
    }

    //Récupère un utilisateur grâce à son identifiant.
    public function getUserById(int $id): ?User {
        $sql = "SELECT * FROM users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);

        $row = $stmt->fetch();
        //Si aucun utilisateur n'a été trouvé, retourne null
        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['name'],
            $row['email_address'],
            $row['password'],
            $row['id_role_type']
        );
    }

    //Récupère un utilisateur grâce à son adresse e-mail.
    public function getUserByEmail(string $email): ?User {
        $sql = "SELECT * FROM users WHERE email_address = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new User(
            $row['id'],
            $row['name'],
            $row['email_address'],
            $row['password'],
            $row['id_role_type']
        );
    }

    //Ajoute un utilisateur.
    public function addUser(User $user): bool {
        $sql = "INSERT INTO users (name, email_address, password, id_role_type)
                VALUES (:name, :email_address, :password, :id_role_type)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'name' => $user->getName(),
            'email_address' => $user->getEmailAddress(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'id_role_type' => $user->getIdRoleType()
        ]);
    }

    //Modifie les informations d'un utilisateur.
    public function updateUser(User $user): bool {
        $sql = "UPDATE users
                SET name = :name,
                    email_address = :email_address,
                    id_role_type = :id_role_type
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'name' => $user->getName(),
            'email_address' => $user->getEmailAddress(),
            'id_role_type' => $user->getIdRoleType(),
            'id' => $user->getId()
        ]);
    }

    //Supprime un utilisateur grâce à son identifiant.
    public function removeUser(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
