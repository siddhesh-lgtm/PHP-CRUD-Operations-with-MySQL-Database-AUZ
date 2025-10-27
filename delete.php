<?php
include 'connect.php';

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?message=Book deleted successfully");
        exit();
    } else {
        header("Location: index.php?error=Error deleting book");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>