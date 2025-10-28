<?php
require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../auth/guard.php'; requireAuth(); 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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
    <title>View Book - CRUD Application</title>
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
        .detail-label {
            font-weight: bold;
            color: #666;
        }
        .detail-value {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book Details</h2>
        
        <div class="mb-3">
            <div class="detail-label">ID</div>
            <div class="detail-value"><?php echo htmlspecialchars($book['id']); ?></div>
        </div>
        
        <div class="mb-3">
            <div class="detail-label">Title</div>
            <div class="detail-value"><?php echo htmlspecialchars($book['title']); ?></div>
        </div>
        
        <div class="mb-3">
            <div class="detail-label">Author</div>
            <div class="detail-value"><?php echo htmlspecialchars($book['author']); ?></div>
        </div>
        
        <div class="mb-3">
            <div class="detail-label">Type</div>
            <div class="detail-value"><?php echo htmlspecialchars($book['type']); ?></div>
        </div>
        
        <div class="mb-3">
            <div class="detail-label">Description</div>
            <div class="detail-value"><?php echo nl2br(htmlspecialchars($book['description'])); ?></div>
        </div>
        
        <?php if (!empty($book['cover'])): ?>
        <div class="text-center mb-3">
            <img src="../../assets/uploads/<?php echo htmlspecialchars($book['cover']); ?>" class="img-fluid rounded shadow-sm" style="max-height: 400px;" alt="Book Cover">
        </div>
        <?php endif; ?>


        <div class="mb-3">
            <!-- <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $book['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a> -->
           
           <?php if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="edit.php?id=<?php echo $book['id']; ?>" class="btn btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $book['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
           <?php endif; ?>
            <a href="../../index.php" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

            


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>