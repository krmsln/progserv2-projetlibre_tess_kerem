# Déploiement de TeamBoard sur Infomaniak

## 1. URL de l'application

L'application TeamBoard est accessible en ligne à l'adresse suivante :

[**https://teamboard.hortulus-intus.ch**](https://teamboard.hortulus-intus.ch)

L'application utilise PHP pour le traitement côté serveur et MariaDB pour stocker et récupérer les données.

## 2. Prérequis

Pour déployer l'application, il faut disposer de :

- Un hébergement web Infomaniak compatible avec PHP.
- Un domaine ou un sous-domaine associé à l'hébergement.
- Une base de données MariaDB.
- Un accès FTP/SFTP à l'hébergement, par exemple avec WinSCP.
- Les fichiers du projet TeamBoard disponibles dans le dépôt Git.

## 3. Configuration de l'hébergement

Dans le Manager Infomaniak :

1. Créer un site web avec un projet vierge.
2. Configurer le site avec Apache/PHP et sélectionner une version de PHP compatible avec le projet.
3. Associer le site à un domaine ou à un sous-domaine.
4. Configurer la racine du site pour qu'elle pointe vers le dossier `public` du projet.

Le dossier `public` constitue la racine accessible depuis le navigateur. Les fichiers de configuration et les autres fichiers internes doivent rester en dehors de cette racine.

## 4. Transfert des fichiers

Les fichiers nécessaires au fonctionnement de TeamBoard sont transférés vers l'hébergement à l'aide d'un logiciel de transfert de fichiers, tel que WinSCP, via FTP/SFTP.

L'organisation des fichiers sur le serveur doit respecter les chemins utilisés par l'application. Elle comprend notamment :

- `public/` : point d'entrée web de l'application, notamment `index.php`.
- `config/` : configuration de la connexion à la base de données.
- `src/` : code source et scripts SQL nécessaires au projet.

Les fichiers réservés au développement local, comme les configurations de l'environnement de développement, ne sont généralement pas nécessaires en production, sauf si l'application en dépend.

## 5. Configuration de la base de données MariaDB

La base de données MariaDB doit être créée depuis le Manager Infomaniak.

### 5.1. Adaptation du fichier `config/database.ini`

Le fichier `config/database.ini` contient les paramètres de connexion à la base de données. Il doit être configuré avec les informations fournies par Infomaniak :

- `host` : l'hôte du serveur MariaDB.
- `port` : le port du serveur MariaDB, si nécessaire.
- `database` : le nom de la base de données.
- `username` : le nom d'utilisateur de la base de données.
- `password` : le mot de passe associé à cet utilisateur.

Les valeurs présentes dans les fichiers du dépôt Git peuvent donc nécessiter des adaptations pour correspondre à la base de données utilisée sur l'hébergement Infomaniak.

Le fichier `config/database.ini.example` sert de modèle pour préparer cette configuration. Il ne doit contenir aucun identifiant réel ni aucun mot de passe secret.

**Important :** le fichier `config/database.ini` contenant les identifiants réels doit rester exclu du dépôt Git.

### 5.2. Adaptation du script SQL

Le script SQL du projet se trouve dans `src/db/script.sql`. Il permet de créer les tables nécessaires à l'application.

Si le script contient une commande `USE`, celle-ci doit désigner le nom de la base de données créée sur Infomaniak. Cette adaptation peut être nécessaire lorsque le nom de la base de données diffère de celui utilisé dans l'environnement de développement.

La base de données doit exister avant l'exécution du script. Si les tables ne sont pas encore créées, le script peut être importé dans la base de données appropriée à l'aide de phpMyAdmin, accessible depuis la plateforme Infomaniak.

La connexion entre PHP et MariaDB est réalisée à l'aide de PDO.

## 6. Vérification du déploiement

Après le transfert des fichiers et la configuration de la base de données, les points suivants doivent être vérifiés :

- L'application est accessible à l'adresse [https://teamboard.hortulus-intus.ch](https://teamboard.hortulus-intus.ch).
- Le code PHP s'exécute correctement.
- La connexion à la base de données MariaDB fonctionne.
- Les données sont récupérées depuis la base de données et affichées dans l'application.

Le déploiement est considéré comme fonctionnel lorsque l'application est accessible en ligne et que les données sont correctement affichées.

## 7. Sécurité

- Le fichier `config/database.ini`, contenant les identifiants réels, est exclu du dépôt Git.
- Le fichier `config/database.ini.example` ne contient aucune information secrète.
- La racine web pointe vers `public/` afin de limiter l'accès direct aux fichiers internes.
- Les données affichées par l'application sont correctement échappées afin de limiter les risques d'injection HTML.

## 8. Mise à jour de l'application

Pour mettre à jour TeamBoard :

1. Modifier et tester les fichiers dans l'environnement de développement.
2. Enregistrer les modifications dans Git.
3. Transférer les fichiers modifiés sur l'hébergement avec WinSCP.
4. Vérifier que l'application et la connexion à la base de données fonctionnent toujours.

Les modifications de la structure de la base de données doivent être appliquées séparément lorsque cela est nécessaire.
