<?php

use Dom\Mysql;

require_once __DIR__ . '/../../config/connect.php';



 
if(isset($_POST["create"]))
{
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $author=mysqli_real_escape_string($conn,$_POST['author']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $desc=mysqli_real_escape_string($conn,$_POST['description']);

    // $sql="INSERT INTO books(title, author, type, description) 
    //         VALUES('$title', '$author', '$type', '$desc')";

$stmt = $conn->prepare("INSERT INTO books (title, author, type, description, cover) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $author, $type, $description, $coverFileName);
$stmt->execute();

    if(mysqli_query($conn, $sql)){
        // echo "inserted";
        
        session_start();
        $_SESSION["create"]="book added successfully";

        header("location:index.php");

    
    }
    else{
        die("error in insert ");
    }
}

if(isset($_POST["edit"]))
{
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $author=mysqli_real_escape_string($conn,$_POST['author']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $desc=mysqli_real_escape_string($conn,$_POST['description']);
    $id=mysqli_real_escape_string($conn,$_POST['id']);

    $sql = "UPDATE books SET title='$title', author='$author', type='$type', description='$desc' WHERE id='$id'";

    if(mysqli_query($conn, $sql)){
        //echo "updated the book  ";
        session_start();
        $_SESSION["update"]="book updated successfully";

        header("location:index.php");
        
    }

    else{
        die("error in update //edit.php ");
    }
}

//check this logic
if (!empty($_FILES['cover']['name'])) {
    // repeat validation & upload logic here...
    $updateCoverSQL = ", cover = ?";
}



$coverFileName = null; // default

if (!empty($_FILES['cover']['name'])) {
    $targetDir = "../../assets/uploads/";
    $fileName = basename($_FILES["cover"]["name"]);
    $fileTmpPath = $_FILES["cover"]["tmp_name"];
    $fileSize = $_FILES["cover"]["size"];
    $fileType = mime_content_type($fileTmpPath);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Validate file type
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (in_array($fileExt, $allowedExt) && str_starts_with($fileType, 'image/')) {

        // Validate file size (max 2MB)
        if ($fileSize <= 100 * 1024 * 1024) {
            // Unique name for safety
            $newFileName = uniqid('cover_', true) . '.' . $fileExt;
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $coverFileName = $newFileName;
            } else {
                echo "<div class='alert alert-danger'>Error uploading the image.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>File too large (max 2MB).</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Invalid file format. Please upload an image.</div>";
    }
}






?>
