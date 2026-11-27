<!--Menu de navigation
en-tête de la page web-->

<?php
//Valeurs par défaut
$showIndex = $showIndex ?? false;
$showDashboard = $showDashboard ?? false;
$showProfile = $showProfile ?? false;
$showAuth = $showAuth ?? false;
$showLogout = $showLogout ?? false;
?>

<header>
    <h1>TeamBoard</h1>
    <nav>
        <?php if ($showIndex == true) { ?>
            <a href="index.php">Accueil</a>
        <?php } ?>

        <?php if ($showDashboard == true) { ?>
            <a href="dashboard.php">Tableau de bord</a>
        <?php } ?>

        <?php if ($showProfile == true) { ?>
            <a href="profile.php">Mon profil</a>
        <?php } ?>

        <?php if ($showAuth == true) { ?>
            <a href="auth.php?mode=login">Se connecter</a>
            <a href="auth.php?mode=register">Créer un compte</a>
        <?php } ?>

        <?php if ($showLogout == true) { ?>
            <a href="logout.php">Déconnexion</a>
        <?php } ?>

    </nav>
</header>
