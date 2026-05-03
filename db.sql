-- Database Setup

DROP DATABASE IF EXISTS iq_degrader_db;

CREATE DATABASE iq_degrader_db;
USE iq_degrader_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0 NOT NULL,
    
    starting_iq INT DEFAULT 100 NOT NULL,
    final_iq INT DEFAULT NULL,
    game_1_completed TINYINT(1) DEFAULT 0 NOT NULL,
    game_2_completed TINYINT(1) DEFAULT 0 NOT NULL,
    game_3_completed TINYINT(1) DEFAULT 0 NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 

-- Initial Admin set up

-- Insert Default Administrator with the correct hash for 'admin123'
INSERT INTO users (username, password, email, first_name, is_admin, starting_iq)
VALUES (
    'admin', 
    '$2y$10$TnpUAFynU7C4W6mQfYE.quuD5s3WLgD3RRogXDckAXCAVt1nIxoKi', 
    'admin@admin.com', 
    'Admin', 
    1, 
    100
);