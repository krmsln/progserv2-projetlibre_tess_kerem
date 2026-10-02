# Cahier des charges : TeamBoard

## Table des matières

1. [Informations générales](#1-informations-générales)
2. [Présentation du projet](#2-présentation-du-projet)
   1. [Description](#21-description)
   2. [Objectif](#22-objectif)
3. [Utilisateurs et autorisations](#3-utilisateurs-et-autorisations)
   1. [Manager](#31-manager)
   2. [Collaborateur](#32-collaborateur)
4. [Gestion des utilisateurs et de l'authentification](#4-gestion-des-utilisateurs-et-de-lauthentification)
   1. [Création de compte](#41-création-de-compte)
   2. [Connexion](#42-connexion)
   3. [Déconnexion](#43-déconnexion)
   4. [Gestion du profil](#44-gestion-du-profil)
5. [Gestion des projets](#5-gestion-des-projets)
   1. [Informations d'un projet](#51-informations-dun-projet)
   2. [Gestion](#52-gestion)
6. [Gestion des tâches](#6-gestion-des-tâches)
   1. [Informations d'une tâche](#61-informations-dune-tâche)
   2. [Création et assignation](#62-création-et-assignation)
   3. [Consultation](#63-consultation)
   4. [Modification](#64-modification)
   5. [Suppression](#65-suppression)
7. [Tableau de bord](#7-tableau-de-bord)
8. [Communication par e-mail](#8-communication-par-e-mail)
9. [Pages de l'application](#9-pages-de-lapplication)
   1. [Pages publiques](#91-pages-publiques)
   2. [Pages privées](#92-pages-privées)
10. [Modèle de données](#10-modèle-de-données)
    1. [Utilisateur](#101-utilisateur)
    2. [Projet](#102-projet)
    3. [Tâche](#103-tâche)
    4. [Relations](#104-relations)
11. [Sécurité](#11-sécurité)
12. [Gestion multilingue](#12-gestion-multilingue)
13. [Fonctionnalités optionnelles](#13-fonctionnalités-optionnelles)
    1. [Commentaires](#131-commentaires)
    2. [Étiquettes](#132-étiquettes)
    3. [Recherche, filtrage et tri](#133-recherche-filtrage-et-tri)
14. [Contraintes techniques](#14-contraintes-techniques)
    1. [Technologies](#141-technologies)
    2. [Programmation orientée objet](#142-programmation-orientée-objet)
    3. [Base de données](#143-base-de-données)
15. [Déploiement](#15-déploiement)
16. [Organisation du développement](#16-organisation-du-développement)

## 1. Informations générales

- **Nom du projet :** TeamBoard
- **Membres de l'équipe :** Triponez Tess, Saylan Kerem
- **Cadre :** Projet libre - Cours de Programmation Serveur 2 (ProgServ2), HEIG-VD.

---

# 2. Présentation du projet

## 2.1 Description

TeamBoard est une application web de gestion de projets et de tâches destinée aux petites équipes.

L'application permet de centraliser les projets, de créer et d'assigner des tâches aux collaborateurs et de suivre leur état d'avancement.

Les collaborateurs peuvent consulter les projets auxquels ils ont accès ainsi que les tâches qui leur sont assignées. Les managers disposent de droits supplémentaires leur permettant de gérer les projets et les tâches de leur équipe.

## 2.2 Objectif

L'objectif de TeamBoard est de proposer une interface simple et claire permettant de visualiser rapidement :

- les projets accessibles ;
- les tâches ;
- les personnes responsables des tâches ;
- les échéances ;
- les priorités ;
- l'état d'avancement.

L'application doit permettre aux petites équipes de centraliser leur suivi de projets et de tâches dans une même interface.

---

# 3. Utilisateurs et autorisations

L'application possède deux rôles : **manager** et **collaborateur**.

## 3.1 Manager

Le manager dispose des droits de gestion sur les projets et les tâches.

Il peut :

- consulter les projets et les tâches ;
- créer, modifier et supprimer des projets ;
- créer, modifier et supprimer des tâches ;
- assigner ou réassigner des tâches aux collaborateurs ;
- modifier le statut des tâches.

## 3.2 Collaborateur

Le collaborateur dispose de droits limités.

Il peut :

- consulter les projets auxquels il a accès ;
- consulter les tâches qui lui sont assignées ;
- consulter les informations détaillées de ses tâches ;
- modifier le statut des tâches qui lui sont assignées.

### Règle d'accès aux projets

Un collaborateur peut accéder à un projet uniquement lorsqu'au moins une tâche de ce projet lui est assignée.

Un projet peut exister sans contenir de tâche et reste alors uniquement accessible au manager.

Les droits d'accès sont contrôlés en fonction du rôle de l'utilisateur connecté.

---

# 4. Gestion des utilisateurs et de l'authentification

## 4.1 Création de compte

Un utilisateur peut créer un compte à l'aide des informations suivantes :

- nom ;
- adresse e-mail ;
- mot de passe.

L'adresse e-mail doit être associée à un seul compte.

Les mots de passe sont stockés de manière sécurisée dans la base de données.

## 4.2 Connexion

L'utilisateur peut se connecter à son compte à l'aide de son adresse e-mail et de son mot de passe.

Les pages privées sont accessibles uniquement aux utilisateurs authentifiés.

## 4.3 Déconnexion

L'utilisateur peut se déconnecter à tout moment.

## 4.4 Gestion du profil

L'utilisateur peut consulter et modifier les informations de son profil.

## 4.5 Gestion des sessions et des autorisations

Après connexion, une session utilisateur est maintenue afin d'identifier l'utilisateur sur l'ensemble des pages privées de l'application.

Les autorisations sont vérifiées côté serveur à chaque accès à une ressource protégée afin de garantir que chaque utilisateur ne puisse accéder qu'aux fonctionnalités et données correspondant à son rôle.

---

# 5. Gestion des projets

Un projet permet de regrouper des tâches, mais peut également exister sans aucune tâche.

## 5.1 Informations d'un projet

Un projet contient notamment :

- un nom ;
- une description ;
- une date de création ;
- un statut.

Les statuts disponibles sont :

- **À venir**
- **En cours**
- **Terminé**

## 5.2 Gestion

Les opérations disponibles sont définies par le rôle de l'utilisateur :

- le manager peut créer, consulter, modifier et supprimer des projets ;
- le collaborateur peut consulter les projets auxquels il a accès.

Un projet peut contenir plusieurs tâches ou aucune tâche.

---

# 6. Gestion des tâches

Une tâche appartient à un projet et peut être assignée à un collaborateur.

## 6.1 Informations d'une tâche

Une tâche contient notamment :

- un titre ;
- une description ;
- une date de création ;
- une date d'échéance ;
- une priorité ;
- un statut ;
- un projet associé ;
- un utilisateur assigné, le cas échéant.

### Priorités disponibles

- **Faible**
- **Urgente**

### Statuts disponibles

- **À faire**
- **En cours**
- **Terminée**

## 6.2 Création et assignation

Le manager peut créer une tâche et l'associer à un projet.

L'assignation d'une tâche à un collaborateur est facultative lors de sa création.

Le manager peut assigner ou réassigner une tâche à un collaborateur ultérieurement.

Lorsqu'une tâche est assignée à un collaborateur, celui-ci reçoit un e-mail l'informant de cette nouvelle tâche.

## 6.3 Consultation

Les utilisateurs peuvent consulter les tâches auxquelles ils ont accès.

Dans la liste des tâches, une tâche peut être développée afin d'afficher ses informations détaillées, notamment :

- le titre ;
- le projet associé ;
- la date de création ;
- la date d'échéance ;
- la description ;
- l'utilisateur assigné, le cas échéant ;
- la priorité ;
- le statut.

## 6.4 Modification

Le manager peut modifier les informations d'une tâche, notamment son titre, sa description, sa date d'échéance, sa priorité, son statut et son utilisateur assigné.

Le collaborateur peut uniquement modifier le statut des tâches qui lui sont assignées.

## 6.5 Suppression

Le manager peut supprimer une tâche.

---

# 7. Tableau de bord

Une fois connecté, l'utilisateur dispose d'un tableau de bord adapté à son rôle.

Le tableau de bord permet notamment de visualiser :

- les projets accessibles ;
- les tâches à faire ;
- les tâches en cours ;
- les tâches terminées ;
- les tâches dont l'échéance est prévue dans les 7 prochains jours.

Le contenu affiché dépend des droits de l'utilisateur connecté.

---

# 8. Communication par e-mail

L'application permet d'envoyer des e-mails aux utilisateurs.

Lorsqu'un manager assigne une tâche à un collaborateur, celui-ci reçoit un e-mail l'informant de cette nouvelle assignation.

L'e-mail est envoyé au moment de l'assignation, que celle-ci soit effectuée lors de la création de la tâche ou ultérieurement.

Aucun e-mail n'est envoyé tant qu'une tâche n'est pas assignée à un collaborateur.

Les e-mails sont envoyés directement depuis l'application.

---

# 9. Pages de l'application

## 9.1 Pages publiques

L'application comporte au minimum deux pages publiques accessibles sans authentification : une page d'accueil et une page d'authentification permettant la connexion et la création de compte.

### Page d'accueil

La page d'accueil présente :

- le but de TeamBoard ;
- le fonctionnement général de l'application ;
- les principales fonctionnalités ;
- un accès à la connexion ;
- un accès à la création de compte.

### Page d'authentification

Cette page permet :

- de se connecter ;
- de créer un compte.

## 9.2 Pages privées

L'application comporte au minimum cinq pages privées accessibles après authentification. Leur contenu et leur accès peuvent varier selon le rôle de l'utilisateur.

### Tableau de bord

Vue d'ensemble des projets et des tâches accessibles à l'utilisateur.

### Liste des projets

Liste des projets auxquels l'utilisateur a accès.

### Détail d'un projet

Présentation des informations du projet et des tâches qui lui sont associées.

### Liste des tâches

Liste des tâches auxquelles l'utilisateur a accès.

### Détail d'une tâche 

Informations détaillées d'une tâche.

### Gestion du profil

Consultation et modification des informations personnelles de l'utilisateur.

### Gestion des projets et des tâches

Interface réservée au manager permettant de gérer les projets, les tâches et leur assignation.

---

# 10. Modèle de données

L'application repose principalement sur trois types de ressources :

- **Utilisateurs**
- **Projets**
- **Tâches**

## 10.1 Utilisateur

Un utilisateur possède notamment :

- un nom ;
- une adresse e-mail ;
- un mot de passe ;
- un rôle.

## 10.2 Projet

Un projet possède notamment :

- un nom ;
- une description ;
- une date de création ;
- un statut.

Un projet peut exister sans aucune tâche.

## 10.3 Tâche

Une tâche possède notamment :

- un titre ;
- une description ;
- une date de création ;
- une date d'échéance ;
- une priorité ;
- un statut ;
- un projet associé ;
- un utilisateur assigné, le cas échéant.

## 10.4 Relations

Les relations principales sont les suivantes :

- un utilisateur peut être assigné à plusieurs tâches ;
- une tâche peut être assignée à un utilisateur ou ne pas être assignée ;
- un projet peut contenir plusieurs tâches ou aucune tâche ;
- une tâche appartient à un seul projet.

Un collaborateur peut accéder à un projet uniquement lorsqu'au moins une tâche de ce projet lui est assignée.

---

# 11. Sécurité

L'application doit être protégée contre les principales vulnérabilités web.

Les mesures mises en place comprennent notamment :

- utilisation de requêtes préparées afin de limiter les risques d'injection SQL ;
- protection contre les attaques XSS ;
- validation des données saisies par l'utilisateur côté client et côté serveur ;
- traitement et nettoyage appropriés des entrées utilisateur ;
- stockage sécurisé des mots de passe ;
- contrôle des droits d'accès selon le rôle de l'utilisateur ;
- protection des pages privées par authentification.

Les contrôles d'autorisation doivent également être effectués côté serveur afin qu'un utilisateur ne puisse pas accéder directement à une ressource à laquelle il n'a pas droit.

---

# 12. Gestion multilingue

L'application est disponible dans deux langues :

- **Français**
- **Anglais**

L'ensemble des pages et fonctionnalités de l'application doit être disponible dans ces deux langues.

L'utilisateur peut changer la langue de l'interface.

La langue choisie est mémorisée à l'aide d'un cookie afin de conserver la préférence linguistique de l'utilisateur lors de ses prochaines visites.

---

# 13. Fonctionnalités optionnelles

Ces fonctionnalités seront développées uniquement si le temps disponible le permet et après avoir terminé les fonctionnalités principales.

## 13.1 Commentaires

Permettre aux utilisateurs d'ajouter des commentaires sur une tâche.

## 13.2 Étiquettes

Permettre d'ajouter des étiquettes afin de catégoriser les tâches.

Exemples :

- Marketing
- Développement
- RH
- Documentation

## 13.3 Recherche, filtrage et tri

Permettre de rechercher, filtrer et trier les tâches selon différents critères :

- statut ;
- priorité ;
- projet ;
- utilisateur assigné ;
- date d'échéance.

---

# 14. Contraintes techniques

## 14.1 Technologies

L'application est développée avec :

- PHP ;
- MySQL/MariaDB ;
- HTML ;
- CSS ;
- JavaScript lorsque nécessaire.

Aucun framework PHP externe tel que Laravel ou Symfony n'est utilisé.

## 14.2 Programmation orientée objet

L'application utilise les principes de la programmation orientée objet et les classes sont chargées automatiquement.

Les différentes responsabilités de l'application sont réparties dans des classes.

## 14.3 Base de données

Les données de l'application sont stockées dans une base de données MySQL/MariaDB.

Les informations de connexion à la base de données sont stockées dans un fichier de configuration séparé du reste du code.

---

# 15. Déploiement

L'application est déployée sur Internet à l'aide d'Infomaniak.

Une base de données MySQL/MariaDB dédiée est utilisée pour l'application.

---

# 16. Organisation du développement

Le développement est réalisé en équipe à l'aide de Git et GitHub.

Le projet utilise notamment :

- des **issues** pour organiser et suivre les tâches ;
- des **branches** pour développer les fonctionnalités ;
- des **pull requests** pour proposer et revoir les modifications ;
- des **merges** pour intégrer les fonctionnalités ;
- une gestion des conflits lors du travail simultané.
