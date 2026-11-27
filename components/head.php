<!--Méthadonnée et lien vers les fichier CSS
Block head de la page web -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Le titre change en fonction de ma page-->
    <title><?= htmlspecialchars($title ?? 'TeamBoard') ?></title>
    <meta name="description" content="<?= htmlspecialchars($description ?? "TeamBoard - Votre application web de gestion de projets") ?>">
</head>
