## Sécurisation des identifiants de la base de données\
\
Cette procédure explique comment protéger les identifiants de connexion à MariaDB dans le projet TeamBoard, et comment modifier le mot de passe d'un utilisateur de la base de données.\
\
### 1. Créer un fichier `.env`\
\
À la racine du projet, créer un fichier nommé `.env` contenant les variables utilisées par Docker Compose :\
\
```dotenv
MARIADB_USER=nom_utilisateur
MARIADB_PASSWORD=mot_de_passe_personnel
MARIADB_DATABASE=my_database
```
\
Remplacer les valeurs d'exemple par les valeurs utilisées dans le projet. Le mot de passe doit être personnel, unique et suffisamment robuste.\
\
Le fichier `.env` permet de séparer les identifiants du fichier de configuration Docker Compose.\
\
### 2. Configurer Docker Compose\
\
Vérifier que les variables définies dans `.env` sont utilisées dans le service `mariadb` du fichier `compose.yaml` :
\
```yaml
environment:
  - MARIADB_RANDOM_ROOT_PASSWORD=yes
  - MARIADB_USER=${MARIADB_USER}
  - MARIADB_PASSWORD=${MARIADB_PASSWORD}
  - MARIADB_DATABASE=${MARIADB_DATABASE}
```
\
L'option `MARIADB_RANDOM_ROOT_PASSWORD=yes` permet de générer un mot de passe aléatoire pour le compte `root` lors de l'initialisation de la base de données.\
\
**Attention :** ces variables servent principalement à initialiser une nouvelle base de données. Si le volume MariaDB existe déjà, modifier `.env` ne change pas automatiquement le mot de passe enregistré dans MariaDB.\
\
### 3. Créer le fichier de configuration PHP\
\
S'il n'existe pas encore, créer un dossier `config` à la racine du projet, en dehors du dossier public accessible depuis le navigateur.\
\
Créer ensuite le fichier `config/database.ini` :\
\
```ini
host = "mariadb"
port = 3306
database = "my_database"
username = "nom_utilisateur"
password = "mot_de_passe_personnel"
```
\
Les valeurs `username` et `password` doivent correspondre à celles du compte MariaDB utilisé par l'application.\
\
Le nom d'hôte `mariadb` correspond au nom du service MariaDB dans Docker Compose. Il est utilisé lorsque PHP s'exécute dans un conteneur du même réseau Docker.\
\
Le fichier `database.ini` contient des informations confidentielles : il ne doit pas être placé dans le dossier public ni être publié sur Git.\
\
### 4. Fichier d'exemple\
\
Le fichier `config/database.ini.example` contient des valeurs fictives :
\
```ini
host = "mariadb"
port = 3306
database = "my_database"
username = "example_user"
password = "change_me"
```
\
Ce fichier sert de modèle aux autres développeurs. Il peut être partagé dans le dépôt, car il ne contient pas de véritable mot de passe.\
\
### 5. Ajouter les fichiers confidentiels au `.gitignore`\
\
S'assurer que les lignes suivantes ont bien été ajoutées au fichier `.gitignore`, situé à la racine du projet :\
\
```gitignore
/.env
/config/database.ini
```
\
Git ignorera ainsi ces fichiers lors de l'ajout de nouveaux fichiers au dépôt.\
\
Le fichier `config/database.ini.example`, lui, peut être versionné.\
\
**Important :** `.gitignore` n'enlève pas un fichier déjà suivi par Git et ne supprime pas les secrets présents dans les anciens commits.\
\
### 6. Modifier le mot de passe MariaDB\
\
Dans le cas où la base de données a déjà été créée avec le même mot de passe que celui indiqué dans le fichier `database.ini.example`, il est important de modifier le mot de passe du compte utilisé par l'application :\
\
1\. Ouvrir un terminal dans le dossier contenant `compose.yaml`.\
\
2\. Se connecter au compte administrateur MariaDB :\
\
   ```bash
   docker compose exec mariadb mariadb -u root -p
   ```
\
3\. Saisir le mot de passe `root` lorsqu'il est demandé.\
\
4\. Vérifier le nom du compte à modifier :\
\
   ```sql
   SELECT User, Host
   FROM mysql.user
   WHERE User = 'nom_utilisateur';
   ```
\
5\. Modifier le mot de passe en utilisant le nom de compte et l'hôte retournés par la requête. Par exemple, si le résultat indique `nom_utilisateur` et `%` :\
\
   ```sql
   ALTER USER 'nom_utilisateur'@'%'
   IDENTIFIED BY 'nouveau_mot_de_passe_personnel';
   ```
\
6\. Quitter MariaDB :\
\
   ```sql
   EXIT;
   ```
\
Choisir un mot de passe robuste et ne pas utiliser littéralement le mot de passe de cet exemple.\
\
### 7. Mettre à jour les fichiers de configuration\
\
Après le changement de mot de passe, mettre à jour les fichiers suivants avec le même mot de passe :\
\
- `.env`, dans la variable `MARIADB_PASSWORD`.\
- `config/database.ini`, dans la propriété `password`.\
\
Cela permet à Docker Compose et à l'application PHP d'utiliser les bons identifiants.\
\
**Attention :** modifier `.env` ne modifie pas à lui seul le mot de passe dans une base MariaDB déjà initialisée. C'est la commande SQL `ALTER USER` qui effectue cette modification.\
\
### 8. Vérifier que les fichiers sont ignorés par Git\
\
Exécuter la commande suivante à la racine du projet :\
\
```bash
git check-ignore .env config/database.ini
```
\
Si les deux chemins apparaissent dans le résultat, Git confirme qu'ils sont ignorés par les règles actuelles.\
\
Pour vérifier également si ces fichiers sont déjà suivis par Git :\
\
```bash
git ls-files .env config/database.ini
```
\
Si cette dernière commande ne renvoie aucun résultat, ces fichiers ne sont pas suivis par Git dans l'index actuel.\
\
S'ils sont déjà suivis, les retirer de l'index sans supprimer les fichiers locaux :\
\
```bash
git rm --cached -- .env config/database.ini
```
\
Puis enregistrer ce changement dans un commit.\
\
### 9. Bonnes pratiques de sécurité\
\
- Ne jamais publier un véritable mot de passe dans le dépôt Git.\
- Ne jamais placer les fichiers contenant des secrets dans le dossier public.\
- Ne pas versionner le fichier `.env` ni `config/database.ini`.\
- Versionner uniquement le fichier d'exemple `config/database.ini.example`.\
