<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user_role'] != 'admin') {
    header('Location: index.php');
    exit();
}

require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "INSERT INTO crud (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
    
    if (mysqli_query($conn, $sql)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>