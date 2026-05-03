<?php
// models/UserModel.php

$dbPath = dirname(__DIR__) . '/config/db.php';

if (file_exists($dbPath)) {
    require_once $dbPath;
} else {
    die("Error: db.php could not be found at: " . htmlspecialchars($dbPath));
}

class UserModel {
    private $db;

    public function __construct() {
        if (!class_exists('Database')) {
            die("Error: The 'Database' class was not found in db.php.");
        }
        $database = new Database(); 
        $this->db = $database->getConnection();

    }


  
    public function userExists($username, $email) {
        $sql = "SELECT id FROM users WHERE username = :username OR email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username, ':email' => $email]);
        return $stmt->fetch() !== false;
    }

 
     //* Register a new user into the database.
    
    public function registerUser($firstName, $username, $email, $password) {
        $sql = "INSERT INTO users (first_name, username, email, password, starting_iq, is_admin) 
                VALUES (:first_name, :username, :email, :password, 100, 0)";
        
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':first_name' => $firstName,
            ':username'   => $username,
            ':email'      => $email,
            ':password'   => $hashedPassword
        ]);
    }

    /**
     * Mark Game 1 as complete and update the user's final IQ.
     * This is the exact method Step 3 was looking for!
     */
    public function updateGameOneScore($userId, $newIq) {
        $sql = "UPDATE users 
                SET game_1_completed = 1, final_iq = :final_iq 
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':final_iq' => $newIq,
            ':id'       => $userId
        ]);
    }


    // Retrieve a user by username or email for login validation.

    public function getUserByLogin($login) {
        // Determine if login is an email or username
        $isEmail = strpos($login, '@') !== false;
        $column = $isEmail ? 'email' : 'username';

        $sql = "SELECT id, username, first_name, password, is_admin, starting_iq, final_iq
                FROM users
                WHERE $column = :login";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':login' => $login]);
        
        return $stmt->fetch();
    }


     // Retrieve all users for the admin dashboard.
    public function getAllUsers() {
        $sql = "SELECT id, username, email, first_name, is_admin, starting_iq, final_iq FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

}