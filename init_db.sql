-- Création de la base de données
CREATE DATABASE IF NOT EXISTS carteIdentite
-- CHARACTER SET utf8mb4
-- COLLATE utf8mb4_general_ci;

-- Utiliser la base
USE carteIdentite;

-- Création de la table personne
CREATE TABLE IF NOT EXISTS personne (
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    numeroCarte VARCHAR(20) NOT NULL UNIQUE,
    
    nom VARCHAR(30) NOT NULL,
    prenom VARCHAR(30) NOT NULL,
    dateNaissance DATE NOT NULL,
    
    pere VARCHAR(50) NOT NULL,
    mere VARCHAR(50) NOT NULL,
    
    province VARCHAR(20) NOT NULL,
    commune VARCHAR(20) NOT NULL,
    zoneRes VARCHAR(20) NOT NULL,
    
    etatCivil VARCHAR(15) NOT NULL,
    fonction VARCHAR(40) NOT NULL,
    
    residenceActuel VARCHAR(150) NOT NULL,
    nationalite VARCHAR(15) NOT NULL,
    
    sexe VARCHAR(10) NOT NULL,
    
    dateEnregistrement TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);