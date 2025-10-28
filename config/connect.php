<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'books_db';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

?>