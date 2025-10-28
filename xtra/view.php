<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>BOOK DETAILS </title>

    <style>
        .book-details{
            background: grey;
            padding: 50px;
        }

    </style>


</head>
<body>
    <div class="container">
        <header class="d-flex justify-content-between my-4 ">
            <h1>BOOK DETAILS  </h1>
            <div>
                <a href="./index.php" class="btn btn-primary">click to go back </a>
            </div>
        </header> 
    
     <div class="book-details my-4 ai-style-change-1">
           


            <?php 
            if(isset($_GET['id'])){
                    include("./connect.php");
                    $id=$_GET['id'];
                    $sql="SELECT * FROM BOOKS WHERE id=$id   ";


                $result = mysqli_query($conn, $sql);
                $row=mysqli_fetch_array($result);
            }
            ?>

            <h2>TITLE</h2>
            <p><?php echo $row['title'];?></p>

            <h2>Description</h2>
            <p><?php echo $row['description'];?></p>

            <h2>TYPE</h2>
            <p><?php echo $row['type'];?></p>

            <h2>AUTHOR</h2>
            <p><?php echo $row['author'];?></p>


         
        </div>
    
    </div>
    

</body>
</html>