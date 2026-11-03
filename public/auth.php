<?php
require_once __DIR__ . '/../src/autoload.php';
session_start();

if (isset($_SESSION['user_id'])) { //rediriges sur le dahsboard si co
    header('Location: dashboard.php');
    exit;
}

$db = new Database();
$userManager = new UserManager($db);

$error = '';
$success = '';

$mode = $_GET['mode'] ?? 'login';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $mode = 'register';
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $error = "Tous les champs sont obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse e-mail n'est pas valide.";
        } elseif ($userManager->getUserByEmail($email) !== null) {
            $error = "Cette adresse e-mail est déjà associée à un compte.";
        } else {
            try {
                $newUser = new User(null, $name, $email, $password, 2);
                if ($userManager->addUser($newUser)) {
                    $success = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
                    $mode = 'login';
                } else {
                    $error = "Erreur lors de la création du compte.";
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
    } elseif ($action === 'login') {
        $mode = 'login';
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Veuillez renseigner votre adresse e-mail et votre mot de passe.";
        } else {
            $user = $userManager->getUserByEmail($email);


            if ($user !== null && password_verify($password, $user->getPassword())) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getName();
                $_SESSION['user_role'] = $user->getIdRoleType();

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Adresse e-mail ou mot de passe incorrect.";
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
    <title>TeamBoard - Authentification</title>
</head>

<body>
    <header>
        <h1>TeamBoard</h1>
        <nav>
            <a href="index.php">Retour à l'accueil</a> |
            <a href="auth.php?mode=login">Connexion</a> |
            <a href="auth.php?mode=register">Créer un compte</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <?php if ($mode === 'register'): ?>
            <section>
                <h2>Créer un compte</h2>
                <form method="POST" action="auth.php?mode=register">
                    <input type="hidden" name="action" value="register">

                    <div>
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
                    </div>

                    <div>
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div>
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">S'inscrire</button>
                </form>
                <p>Déjà un compte ? <a href="auth.php?mode=login">Se connecter</a></p>
            </section>
        <?php else: ?>
            <section>
                <h2>Connexion</h2>
                <form method="POST" action="auth.php?mode=login">
                    <input type="hidden" name="action" value="login">

                    <div>
                        <label for="email">Adresse e-mail :</label>
                        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>

                    <div>
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit">Se connecter</button>
                </form>
                <p>Pas encore de compte ? <a href="auth.php?mode=register">Créer un compte</a></p>
            </section>
        <?php endif; ?>
    </main>
</body>

</html>
