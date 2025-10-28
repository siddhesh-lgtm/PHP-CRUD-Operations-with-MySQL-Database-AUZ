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

$conn->close();