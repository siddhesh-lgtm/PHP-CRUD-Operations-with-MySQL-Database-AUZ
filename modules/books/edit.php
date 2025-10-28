<?php
require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../auth/auth-check.php';
require_once __DIR__ . '/../../auth/guard.php'; requireRole('admin'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// 	$title = $_POST['title'];
// 	$author = $_POST['author'];
// 	$type = $_POST['type'];
// 	$description = $_POST['description'];

// 	$sql = "UPDATE books SET title=?, author=?, type=?, description=? WHERE id=?";
// 	$stmt = $conn->prepare($sql);
// 	$stmt->bind_param("ssssi", $title, $author, $type, $description, $id);

// 	if ($stmt->execute()) {
// 		header("Location: ../../index.php");
// 		exit();
// 	} else {
// 		$error = "Error updating book: " . $conn->error;
// 	}
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = $_POST['title'];
	$author = $_POST['author'];
	$type = $_POST['type'];
	$description = $_POST['description'];

	$coverSql = "";
	$params = [$title, $author, $type, $description, $id];
	$types = "ssssi";

	if (!empty($_FILES['cover']['name']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
		$targetDir = __DIR__ . '/../../assets/uploads/';
		$fileName = basename($_FILES['cover']['name']);
		$tmp = $_FILES['cover']['tmp_name'];
		$size = $_FILES['cover']['size'];
		$ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		$allowed = ['jpg','jpeg','png','gif','webp'];

		if (in_array($ext, $allowed) && $size <= 5 * 1024 * 1024) { // allow up to 5MB
			$newName = uniqid('cover_', true) . '.' . $ext;
			if (move_uploaded_file($tmp, $targetDir . $newName)) {
				// delete old cover if exists
				if (!empty($book['cover'])) {
					$old = $targetDir . $book['cover'];
					if (is_file($old)) { @unlink($old); }
				}
				$coverSql = ", cover = ?";
				$params = [$title, $author, $type, $description, $newName, $id];
				$types = "sssssi";
			}
		} else {
			$error = "Invalid image or file too large (max 5MB).";
		}
	}

	$sql = "UPDATE books SET title=?, author=?, type=?, description=?{$coverSql} WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param($types, ...$params);

	if ($stmt->execute()) {
		header("Location: ../../index.php");
		exit();
	} else {
		$error = "Error updating book: " . $conn->error;
	}
}



$sql = "SELECT * FROM books WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
	header("Location: ../../index.php");
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book - CRUD Application</title>
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
        <h2>Edit Book</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" id="type" name="type" value="<?php echo htmlspecialchars($book['type']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($book['description']); ?></textarea>
            </div>

            <div class="mb-3">
            <label for="cover" class="form-label">Change Cover (optional)</label>
            <input type="file" name="cover" id="cover" class="form-control" accept="image/*">
            </div>

            <?php if (!empty($book['cover'])): ?>
            <p>Current cover:</p>
            <img src="../../assets/uploads/<?php echo htmlspecialchars($book['cover']); ?>" alt="Book Cover" width="120">
            <?php endif; ?>


            <button type="submit" class="btn btn-primary">Update Book</button>
            <a href="../../index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>