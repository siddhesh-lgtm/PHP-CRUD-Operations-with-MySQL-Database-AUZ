<?php

use Dom\Mysql;

include("./connect.php");
 
if(isset($_POST["create"]))
{
    $title=mysqli_real_escape_string($conn,$_POST['title']);
    $author=mysqli_real_escape_string($conn,$_POST['author']);
    $type=mysqli_real_escape_string($conn,$_POST['type']);
    $desc=mysqli_real_escape_string($conn,$_POST['description']);

    $sql="INSERT INTO books(title, author, type, description) 
            VALUES('$title', '$author', '$type', '$desc')";

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

?>
