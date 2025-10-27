<!DOCTYPE html>
<html lang="en">
<head>
    
  <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>list of books here </title>
</head>
<body>
    
    <div class="container">
         <header class="d-flex justify-content-between my-4 ">
            <h1>list of books</h1>
            <div>
                <a href="./create.php" class="btn btn-primary">ADD NEW BOOK </a>
            </div>
        </header>

        <?php 
        session_start();
        if(isset($_SESSION['create'])){
                ?>
                <div class="alert alert-success">
        <?php 
          echo  $_SESSION["create"];
          unset($_SESSION["create"]);
        ?>
                </div>
        <?php
        }
        ?>

        <?php 

        if(isset($_SESSION['update'])){
                ?>
                <div class="alert alert-success">
        <?php 
          echo  $_SESSION["update"];
          unset($_SESSION["update"]);
        ?>
                </div>
        <?php
        }
        ?>

        <?php 
        
        if(isset($_SESSION['delete'])){
                ?>
                <div class="alert alert-success">
        <?php 
          echo  $_SESSION["delete"];
          unset($_SESSION["delete"]);
        ?>
                </div>
        <?php
        }
        ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#id</th>
                    <th>TITLE</th>
                    <th>Author</th>
                    <th>Type</th>
                    <!-- <th>Description</th> -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                 include("./connect.php");
                    $sql="SELECT * FROM BOOKS";
                    $result=mysqli_query($conn, $sql);

                   // $row=mysqli_fetch_assoc($result);
                    while($row=mysqli_fetch_array($result))
                     {
                    ?>
                        <tr>
                            <td><?php echo $row['id'] ?></td>
                             <td><?php echo $row['title'] ?></td>
                              <td><?php echo $row['author'] ?></td>
                               <td><?php echo $row['type'] ?></td>
                               
                                 <td style="text-align: center;  display: flex; justify-content: space-around"> 
                                    <a href="view.php?id=<?php echo $row['id'] ?> " class="btn btn-info">click 2 see Descripion</a>
                                    <a href="edit.php?id=<?php echo $row['id']?> " class="btn btn-warning"0>EDIT</a>
                                    <a href="delete.php ?id=<?php echo $row['id']?> " class="btn btn-danger">DLT</a>
                                 </td>
                        </tr>
                    <?php 
                        
                      
                     }

                ?>
            </tbody>
        </table>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

    <style>
        .ai-style-change-1 {
    td {
        text-align: center;
        display: flex;
        justify-content: space-around;
    }
}
    </style>
</body>
</html>