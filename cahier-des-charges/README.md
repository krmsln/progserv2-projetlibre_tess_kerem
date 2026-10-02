# Cahier des charges : TeamBoard

## 1. Informations générales

- **Nom du projet :** TeamBoard
- **Membres de l'équipe :** Triponez Tess, Saylan Kerem
- **Cadre :** Projet libre — Cours de Programmation Serveur 2 (ProgServ2), HEIG-VD.

---

## 2. Description du projet

TeamBoard est une application web de gestion de projets et de tâches destinée aux petites équipes.

L'objectif de la plateforme est de centraliser les projets, de créer et d'assigner des tâches aux membres d'une équipe et de permettre un suivi clair de leur état d'avancement.

L'application permet aux utilisateurs de consulter les projets auxquels ils participent et de suivre les tâches qui leur sont attribuées. Les managers disposent de droits supplémentaires leur permettant de gérer les projets et les tâches de l'équipe.

**Spécificité du projet :**

TeamBoard se concentre sur une gestion simple et claire des projets et des tâches. L'objectif est de proposer une interface permettant de visualiser rapidement les tâches, leurs responsables, leurs échéances et leur état d'avancement, sans ajouter de fonctionnalités complexes qui ne sont pas nécessaires au fonctionnement principal de l'application.

---

# 3. Fonctionnalités principales

## A. Gestion des utilisateurs et de l'authentification

### Création de compte

L'utilisateur peut créer un compte à l'aide de :

- son nom
- son adresse e-mail
- son mot de passe

Les mots de passe sont stockés de manière sécurisée dans la base de données.

### Connexion

L'utilisateur peut se connecter à son compte à l'aide de son adresse e-mail et de son mot de passe.

### Déconnexion

L'utilisateur peut se déconnecter à tout moment.

### Gestion du profil

L'utilisateur peut consulter et modifier les informations de son profil.

---

# 4. Rôles et autorisations

L'application possède deux rôles distincts.

## A. Manager

Le manager possède des droits de gestion sur les projets et les tâches.

Il peut :

- créer des projets
- consulter les projets
- modifier les projets
- supprimer les projets
- créer des tâches
- consulter les tâches
- modifier les tâches
- supprimer les tâches
- assigner des tâches aux collaborateurs.

Le manager peut également consulter les tâches de l'équipe.

## B. Collaborateur

Le collaborateur peut :

- avoir accès à un projet uniquement s’il possède au moins une tâche qui lui est assignée dans ce projet
- consulter les projets auxquels il a accès
- consulter les tâches qui lui sont assignées
- consulter le détail de ces tâches
- modifier le statut des tâches qui lui sont assignées

Les droits d'accès sont contrôlés selon le rôle de l'utilisateur connecté.

---

# 5. Gestion des projets

Un projet permet de regrouper plusieurs tâches autour d'un même objectif.

Un projet contient notamment :

- un nom
- une description
- une date de création
- un statut

Le manager peut :

- créer un projet
- consulter un projet
- modifier un projet
- supprimer un projet

Un projet peut contenir plusieurs tâches.

---

# 6. Gestion des tâches

Une tâche est associée à un projet et peut être assignée à un collaborateur.

Une tâche contient notamment :

- un titre
- une description
- une date de création
- une date d'échéance
- une priorité
- un statut
- un projet associé
- un utilisateur assigné

### Création

Le manager peut créer une tâche et renseigner ses différentes informations.

### Assignation

Le manager peut assigner une tâche à un collaborateur.

### Consultation

Les utilisateurs peuvent consulter les tâches auxquelles ils ont accès.

La page de détail d'une tâche affiche notamment :

- son titre
- sa description
- le projet associé
- la personne assignée
- sa priorité
- son statut
- son échéance

### Modification

Le manager peut modifier les informations d'une tâche.

Le collaborateur peut modifier le statut des tâches qui lui sont assignées.

Les statuts disponibles sont :

- À faire
- En cours
- Terminée

### Suppression

Le manager peut supprimer une tâche.

---

# 7. Tableau de bord

Une fois connecté, l'utilisateur dispose d'un tableau de bord adapté à son rôle.

Le tableau de bord permet notamment de visualiser rapidement :

- les projets accessibles
- les tâches à faire
- les tâches en cours
- les tâches terminées
- les tâches arrivant prochainement à échéance

Le contenu affiché dépend des droits de l'utilisateur connecté.

---

# 8. Pages de l'application

## A. Pages publiques

L'application possède au minimum deux pages accessibles sans connexion.

### Page d'accueil

La page d'accueil présente :

- le but de TeamBoard
- le fonctionnement général de l'application
- les principales fonctionnalités
- un accès à la connexion
- un accès à la création de compte

### Page d'authentification

Cette page permet :

- de se connecter
- de créer un compte

## B. Pages privées

Les utilisateurs connectés disposent de plusieurs pages privées selon leur rôle :

- **Tableau de bord** : vue d'ensemble des projets et tâches.
- **Liste des projets** : consultation des projets accessibles.
- **Détail d'un projet** : informations du projet et tâches associées.
- **Liste des tâches** : consultation des tâches accessibles.
- **Détail d'une tâche** : informations détaillées d'une tâche.
- **Gestion du profil** : consultation et modification des informations personnelles.
- **Gestion des projets et des tâches** : interface réservée au manager.

---

# 9. Relations entre les données

L'application gère plusieurs types de ressources liés entre eux :

- **Utilisateurs**
- **Projets**
- **Tâches**

Les relations principales sont les suivantes :

- un utilisateur peut être assigné à plusieurs tâches
- une tâche est assignée à un utilisateur
- un projet peut contenir plusieurs tâches
- une tâche appartient à un projet

Ces relations permettent de gérer l'organisation des tâches au sein des différents projets.

La base de données comporte au minimum trois tables correspondant à ces différentes ressources.

---

# 10. Communication par e-mail

L'application permet d'envoyer des e-mails aux utilisateurs.

Lorsqu'un manager assigne une nouvelle tâche à un collaborateur, celui-ci reçoit un e-mail l'informant de cette nouvelle tâche.

Les e-mails sont envoyés directement depuis l'application.

---

# 11. Sécurité

L'application doit être protégée contre les principales vulnérabilités web.

Les mesures mises en place comprennent notamment :

- protection contre les injections SQL
- protection contre les attaques XSS
- validation des données envoyées par les utilisateurs
- nettoyage et traitement des entrées utilisateur
- stockage sécurisé des mots de passe
- contrôle des droits d'accès selon le rôle
- protection des pages privées par authentification

---

# 12. Fonctionnalités optionnelles

Ces fonctionnalités seront développées uniquement si le temps disponible le permet et après avoir terminé les fonctionnalités principales.

### Commentaires

Permettre aux utilisateurs d'ajouter des commentaires sur une tâche.

### Étiquettes

Ajouter des étiquettes permettant de catégoriser les tâches.

Par exemple :

- Marketing
- Développement
- RH
- Documentation

### Recherche, filtrage et tri

Permettre de rechercher, filtrer ou trier les tâches selon différents critères :

- statut
- priorité
- projet
- utilisateur assigné
- date d'échéance

---

# 13. Contraintes techniques et méthodologiques

### Technologies

L'application est développée avec :

- PHP
- MySQL/MariaDB
- HTML
- CSS
- JavaScript si nécessaire

Aucun framework PHP externe tel que Laravel ou Symfony n'est utilisé.

### Programmation orientée objet

L'application utilise les principes de la programmation orientée objet.

Les différentes responsabilités de l'application sont réparties dans des classes.

Les classes sont chargées automatiquement grâce à un système d'autoload.

### Base de données

Les données sont stockées dans une base de données MySQL/MariaDB.

Les informations de connexion à la base de données sont stockées dans un fichier de configuration séparé du reste du code.

### Déploiement

L'application est déployée sur Internet à l'aide d'Infomaniak et utilise une base de données MySQL/MariaDB dédiée.

### Collaboration

Le développement est réalisé en équipe à l'aide de Git et GitHub.

Le projet utilise notamment :

- des issues pour organiser les tâches
- des branches pour développer les fonctionnalités
- des pull requests pour proposer les modifications
- des merges pour intégrer les fonctionnalités
- une gestion des conflits lors du travail simultané

---

# 14. Gestion multilingue

L'application est disponible dans deux langues :

- **Français**
- **Anglais**

L'ensemble des pages de l'application est disponible dans ces deux langues.

L'utilisateur peut changer la langue de l'interface.

La langue choisie est mémorisée à l'aide d'un **cookie** afin que l'application puisse se souvenir de la préférence linguistique de l'utilisateur lors de ses prochaines visites.
