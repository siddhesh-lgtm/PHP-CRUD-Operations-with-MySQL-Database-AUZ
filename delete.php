<?php 

if(isset($_GET['id'])){
    $id=$_GET['id'];
    include("connect.php");

    $sql="DELETE from books  WHERE id=$id";

    if(mysqli_query($conn,$sql)){
        // echo "deleted";

        session_start();
        $_SESSION["delete"]="book deleted successfully";

        header("location:index.php");

    }
    else
        echo "ERORR IN DLT ";
}


?>