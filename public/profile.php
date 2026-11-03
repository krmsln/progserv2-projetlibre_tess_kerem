<?php
require_once __DIR__ . '/../src/autoload.php';

// Pour bloquer les utilisateurs non connectés
SessionManager::requireLogin();

// Connexion à la base de données
$db = new Database();
$userManager = new UserManager($db);

// Récupérer l'utilisateur connecté
$user = $userManager->getUserById((int) $_SESSION['user_id']);

$error = '';
$success = '';

$name = $user->getName();
$email = $user->getEmailAddress();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($email)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (strlen($name) > 20) {
        $error = "Le nom ne peut pas dépasser 20 caractères.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'adresse e-mail n'est pas valide.";
    } elseif ($userManager->emailAlreadyUsed($email, (int) $user->getId())) {
        $error = "Cette adresse e-mail est déjà associée à un autre compte.";
    } else {
        try {
            // Mise à jour des informations de l'utilisateur.
            $user->setName($name);
            $user->setEmailAddress($email);

            if ($userManager->updateProfileUser($user)) {
                $_SESSION['user_name'] = $user->getName();

                $success = "Votre profil a été modifié avec succès.";
            } else {
                $error = "Erreur lors de la modification du profil.";
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamBoard - Mon profil</title>
</head>

<body>
    <header>
        <h1>TeamBoard</h1>
        <nav>
            <a href="index.php">Retour à l'accueil</a> |
            <a href="dashboard.php">Tableau de bord</a> |
            <a href="profile.php">Mon profil</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <section>
            <h2>Gestion de mon profil</h2>

            <form method="POST" action="profile.php">

                <div>
                    <label for="name">Nom :</label>
                    <input type="text" id="name" name="name" required maxlength="20"
                        value="<?= htmlspecialchars($name) ?>">
                </div>

                <div>
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" required maxlength="40"
                        value="<?= htmlspecialchars($email) ?>">
                </div>

                <button type="submit">Enregistrer les modifications</button>
            </form>

            <p><a href="dashboard.php">Retour au tableau de bord</a></p>
        </section>
    </main>
</body>

</html>
