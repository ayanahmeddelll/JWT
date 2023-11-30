<?php
require_once '../config/database.php';


class User {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function register($username, $password, $role) {
         
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $username, $hashed_password, $role);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($username, $password) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $db_password);
            $stmt->fetch();
    
            // Verify the password
            if (password_verify($password, $db_password)) {
                return array("id" => $id, "username" => $db_username);
            }
        }
        return false;
    }
    
}
