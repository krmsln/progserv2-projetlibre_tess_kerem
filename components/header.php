<!--Menu de navigation
en-tête de la page web-->
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
