# Utilisation d'outils d'intelligence artificielle

**Mot de passe administrateur (script.sql) :** J'ai demandé à l'IA de générer la
chaîne hachée du mot de passe (`password`) avec l'algorithme BCRYPT pour le
compte de test. Le cahier des charges exigeant un stockage sécurisé, cela me
permet d'avoir un compte prêt à l'emploi dès l'initialisation de la base, en
attendant de développer la logique de hachage `password_hash()` moi-même en PHP.
J'ai revu, compris et validé chaque ligne du code généré pour m'assurer qu'il
reflète exactement nos règles métier.

**Sécurisation et destruction de session (SessionManager.php) :** J'ai demandé à
l'IA de m'aider sur deux aspects précis de la sécurité des sessions PHP: la
régénération de l'identifiant lors de la connexion
(`session_regenerate_id(true)`) pour éviter les failles d'ID fixe, ainsi que la
suppression complète des cookies de session (`session_get_cookie_params()` et
`setcookie()`) lors de la déconnexion. Cela me permet de garantir une
authentification sécurisée et une fermeture de session propre tant côté serveur
que sur le navigateur. J'ai revu, compris et validé chaque ligne du code généré
pour m'assurer qu'il reflète exactement nos règles métier.
