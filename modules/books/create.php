<?php
require_once __DIR__ . '/../../auth/auth-check.php';
require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../auth/guard.php'; requireRole('admin'); 

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = $_POST['title'];
	$author = $_POST['author'];
	$type = $_POST['type'];
	$description = $_POST['description'];

	$sql = "INSERT INTO books (title, author, type, description) VALUES (?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);

	if ($stmt === false) {
		die('Prepare failed: ' . htmlspecialchars($conn->error));
	}

	$stmt->bind_param("ssss", $title, $author, $type, $description);

	if ($stmt->execute()) {
		header("Location: ../../index.php?message=Book added successfully");
		$stmt->close();
		$conn->close();
		exit();
	} else {
		$error = "Error adding book: " . $stmt->error;
		$stmt->close();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Book - CRUD Application</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Book</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="create.php">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-success">Add Book</button>
            <a href="../../index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// The connection is closed either during POST success or at the end of script execution.
$conn->close();
?>