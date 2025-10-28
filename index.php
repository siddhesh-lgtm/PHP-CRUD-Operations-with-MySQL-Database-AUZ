
<?php
require_once __DIR__ . '/config/connect.php';
require_once __DIR__ . '/auth/auth-check.php';
require_once __DIR__ . '/auth/guard.php'; requireAuth(); 

// Fetch all books from database
$sql = "SELECT * FROM books";
$result = $conn->query($sql); ?>
<!DOCTYPE html>
<html>
<head>
    
    <title>Books Library - CRUD Application</title>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <!-- App CSS -->
    <link href="assets/css/app.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        /* table-actions style moved to assets/css/app.css for responsiveness */
    </style>
</head>
<body>
    
    <?php include 'auth/auth-check.php'; ?>

    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
        <h2 class="page-title mb-3 mb-md-0">📚 Books Library Management</h2>
        
        <div class="text-end">
            <div class="fw-bold">
            <?php echo htmlspecialchars($_SESSION['user']['full_name']); ?>
            <span class="badge bg-secondary"><?php echo htmlspecialchars($_SESSION['user']['role']); ?></span>
            </div>
            <a href="auth/logout.php" class="btn btn-sm btn-danger mt-2 mt-md-0">Logout</a>
        </div>
    </div>




        <!-- <div class="mb-3"><a href="./modules/books/create.php" class="btn btn-success">Add New Book</a></div> -->

        <?php if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
        <div class="mb-3">
        <a href="modules/books/create.php" class="btn btn-success">Add New Book</a>
        </div>
        <?php endif; ?>
        <div class="table-responsive">
        <table id="booksTable" class="table table-striped table-bordered align-middle w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Cover</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) 
                {
                    while($row = $result->fetch_assoc()) 
                    {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";

                        //cover logic
                        echo "<td>";
                    if (!empty($row['cover'])) {
                        echo "<img src='assets/uploads/" . htmlspecialchars($row['cover']) . "' width='60' height='80' class='rounded shadow-sm'>";
                    } else {
                        echo "<span class='text-muted'>No Cover</span>";
                    }
                    echo "</td>";





                        // echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        // echo "<td class='table-actions'>";
                        // echo "<a href='modules/books/view.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>View</a> ";
                        // echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        // echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>";

                        // echo "<a href='modules/books/view.php?id=" . urlencode($row['id']) . "' class='btn btn-info btn-sm'>View</a> ";
                        // echo "<a href='modules/books/edit.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a> ";
                        // echo "<a href='modules/books/delete.php?id=" . urlencode($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>";
                        
                        echo "<td class='table-actions'>";
                        echo "<a href='modules/books/view.php?id=" . urlencode($row['id']) . "' class='btn btn-info btn-sm'>View Details</a> ";

                        if (!empty($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') {
                            echo "<a href='modules/books/edit.php?id=" . urlencode($row['id']) . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<a href='modules/books/delete.php?id=" . urlencode($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this book?\")'>Delete</a>";
                        }

                        echo "</td>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                } 
                else 
                { 
                            echo "<tr><td colspan='6' class='text-center'>No books found</td></tr>";
                }
                        $conn->close();
                        ?>
            </tbody>
        </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                responsive: true,
                autoWidth: false,
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "order": [[0, "asc"]],
                "columnDefs": [
                    {
                        "targets": 4,
                        "orderable": false,
                        "searchable": false
                    }
                ],
                "language": {
                    "search": "Search books:",
                    "lengthMenu": "Show _MENU_ books per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ books",
                    "infoEmpty": "No books available",
                    "infoFiltered": "(filtered from _MAX_ total books)",
                    "zeroRecords": "No matching books found"
                }
            });
        });
    </script>
</body>

</html>