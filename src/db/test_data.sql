
USE my_database;

-- UTILISATEURS DE TEST --

-- Mot de passe de test : password
-- Hash bcrypt utilisé pour les comptes de test.

INSERT INTO users (name, email_address, password, id_role_type) VALUES
('AdminTest', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1),  -- IA pour la génération du mdp sécurisé (voir readme)
('Alice', 'alice@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),
('Thomas', 'thomas@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2),
('Sophie', 'sophie@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2);


-- PROJETS DE TEST --

INSERT INTO projects (name, description, id_status_type) VALUES
('Site web', 'Développement du nouveau site web.', 2),
('Application mobile', 'Création d une application mobile.', 1),
('Marketing', 'Gestion des campagnes marketing.', 2);


-- TACHES DE TEST --

INSERT INTO tasks
(title, description, due_date, id_user, id_project, id_priority_level, id_status_type)
VALUES

-- Projet Site web
('Créer la page d accueil', 'Développer la page principale.', DATE_ADD(CURDATE(), INTERVAL 1 DAY), 2, 1, 2, 1),
('Créer le formulaire de connexion', 'Développer le formulaire.', DATE_ADD(CURDATE(), INTERVAL 2 DAY), 2, 1, 1, 2),
('Créer la base de données', 'Préparer les tables SQL.', DATE_ADD(CURDATE(), INTERVAL 3 DAY), 3, 1, 2, 3),

-- Projet Application mobile
('Créer les maquettes', 'Préparer les maquettes graphiques.', DATE_ADD(CURDATE(), INTERVAL 4 DAY), 3, 2, 1, 1),
('Développer la navigation', 'Créer la navigation principale.', DATE_ADD(CURDATE(), INTERVAL 5 DAY), 4, 2, 2, 2),

-- Projet Marketing
('Préparer les publications', 'Créer les publications des réseaux sociaux.', DATE_ADD(CURDATE(), INTERVAL 6 DAY), 4, 3, 1, 1),
('Analyser les résultats', 'Analyser les performances des campagnes.', DATE_ADD(CURDATE(), INTERVAL 10 DAY), 2, 3, 2, 3),

-- Tâche sans utilisateur attribué
('Préparer le cahier des charges', 'Rédiger les besoins du projet.', DATE_ADD(CURDATE(), INTERVAL 2 DAY), NULL, 1, 1, 1);
