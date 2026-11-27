<?php
//Pour la réutilisation d'interfaces (fonction render).
require_once __DIR__ . '/../src/functions.php';
session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<?php
// Head : utilisation de la fonction render() afin d'afficher le contenu du fichier head.
render('head', ['title' => "TeamBoard - Accueil", 'description' => "TeamBoard - Votre application web de gestion de projets - Page d'accueil"]);
?>

<body>

    <?php
    // Header : utilisation de la fonction render() afin d'intégrer le contenu du fichier header.
    render('header', [
        'showIndex' => false,
        'showDashboard' => isset($_SESSION['user_id']),
        'showProfile' => isset($_SESSION['user_id']),
        'showAuth' => !isset($_SESSION['user_id']),
        'showLogout' => isset($_SESSION['user_id'])
    ]);
    ?>

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

    <?php
    //footer: utilisation de la fonction render() afin d'ajouter  le fichiers footer
    render('footer'); ?>

</body>

</html>
