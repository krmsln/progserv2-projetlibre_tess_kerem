<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamBoard - Accueil</title>
</head>

<body>
    <header>
        <h1>TeamBoard</h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Tableau de bord</a> |
                <a href="profile.php">Mon profil</a> |
                <a href="logout.php">Déconnexion</a>
            <?php else: ?>
                <a href="auth.php?mode=login">Se connecter</a> |
                <a href="auth.php?mode=register">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <section>
            <h2>Présentation de TeamBoard</h2>
            <p>
                TeamBoard est une application web de gestion de projets et de tâches destinée aux petites équipes.
                Son objectif est de centraliser le suivi de vos projets et de vos tâches dans une interface simple et claire.
            </p>
        </section>

        <section>
            <h2>Fonctionnement général</h2>
            <ul>
                <li>Manager : Crée, modifie et supprime les projets et les tâches, et les assigne aux collaborateurs.</li>
                <li>Collaborateur : Consulte les projets auxquels il a accès, suit les tâches qui lui sont assignées et met à jour leur statut.</li>
            </ul>
        </section>

        <section>
            <h2>Principales fonctionnalités</h2>
            <ul>
                <li>Suivi de l'état d'avancement des projets et des tâches (À faire, En cours, Terminé).</li>
                <li>Gestion des échéances et des priorités (Faible, Urgente).</li>
                <li>Tableau de bord personnalisé avec aperçu des échéances dans les 7 prochains jours.</li>
                <li>Notifications par e-mail lors de l'assignation d'une tâche.</li>
            </ul>
        </section>

        <section>
            <h2>Accès à l'application</h2>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>
                    <a href="dashboard.php">Accéder au tableau de bord</a> |
                    <a href="logout.php">Se déconnecter</a>
                </p>
            <?php else: ?>
                <p>
                    <a href="auth.php?mode=login">Connexion</a> |
                    <a href="auth.php?mode=register">Création de compte</a>
                </p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>Projet réalisé dans le cadre du cours ProgServ2 à la HEIG-VD.</p>
    </footer>
</body>

</html>
