USE my_database;

-- TABLES DE REFERENCES --

-- Rôles
CREATE TABLE IF NOT EXISTS role_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL UNIQUE
);

-- Niveaux de priorité
CREATE TABLE IF NOT EXISTS priority_levels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL UNIQUE
);

-- Status 
CREATE TABLE IF NOT EXISTS status_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL UNIQUE
);

-- TABLES PRINCIPALES --

-- Utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email_address VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_role_type INT NOT NULL,
    FOREIGN KEY (id_role_type) REFERENCES role_types(id)
);

-- Projets
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_status_type INT NOT NULL,
    FOREIGN KEY (id_status_type) REFERENCES status_types(id)
);

-- Tâches
CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    due_date DATE NOT NULL,
    id_user INT NULL,
    id_project INT NOT NULL,
    id_priority_level INT NOT NULL,
    id_status_type INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (id_project) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (id_priority_level) REFERENCES priority_levels(id),
    FOREIGN KEY (id_status_type) REFERENCES status_types(id) 
);

-- INSERTION DES DONNEES --
INSERT INTO role_types (label) VALUES 
('Manager'), 
('Collaborateur');

INSERT INTO priority_levels (label) VALUES 
('Faible'), 
('Urgente');

INSERT INTO status_types (label) VALUES 
('À faire'), 
('En cours'), 
('Terminé');

-- compte admin pour test 
INSERT INTO users (name, email_address, password, id_role_type) VALUES
('admintest', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1); -- IA pour la génération du mdp sécurisé (voir readme)

