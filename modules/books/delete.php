<?php
require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../auth/auth-check.php';
 require_once __DIR__ . '/../../auth/guard.php'; requireRole('admin'); 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
	$sql = "DELETE FROM books WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $id);

	if ($stmt->execute()) {
		header("Location: ../../index.php?message=Book deleted successfully");
		exit();
	} else {
		header("Location: ../../index.php?error=Error deleting book");
		exit();
	}
} else {
	header("Location: ../../index.php");
	exit();
}

$id = $_GET['id'];
$getCover = $conn->prepare("SELECT cover FROM books WHERE id = ?");
$getCover->bind_param("i", $id);
$getCover->execute();
$result = $getCover->get_result();
$book = $result->fetch_assoc();

if (!empty($book['cover'])) {
    $filePath = "../../assets/uploads/" . $book['cover'];
    if (file_exists($filePath)) {
        unlink($filePath);
    }
}

// Delete from DB
$delete = $conn->prepare("DELETE FROM books WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();



$conn->close();