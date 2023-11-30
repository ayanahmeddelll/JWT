<?php
require '../includes/Headers.php';



define('DB_HOST', 'localhost'); 
define('DB_USER', 'root'); 
define('DB_PASS', ''); 
define('DB_NAME', 'faisal_db'); 


// Create a database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to UTF-8 (optional)
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}
