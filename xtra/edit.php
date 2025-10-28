<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>EDIT BOOK</title> 

</head>
<body>
   
    <div class="conatainer">
        <header class="d-flex justify-content-between my-4 ">
            <h1> EDIT A BOOK</h1>
            <div>
                <a href="./index.php" class="btn btn-primary">GO BACK </a>
            </div>
        </header>

        <?php 
        if(isset($_GET["id"])){
            $id=$_GET["id"];
            include("connect.php");
            $sql="SELECT * FROM books WHERE id=$id";
            $result=mysqli_query($conn,$sql);
            $row=mysqli_fetch_array($result );

        }

    


?>

    <form action="./process.php" method="post">
            <div class="form-element my-4">
                <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>" placeholder="book title goes here: ">
            </div>

            <div class="form-element my-4">
                <input type="text" class="form-control" name="author" value="<?php echo $row['author'];?>" placeholder="author name goes here: ">
            </div>
            <div class="form-element my-4"> 
                <select name="type" class="form-control">
                    <option value="">Select Book Type</option>
                    <option value="adventure" <?php if($row['type']=="adventure"){echo "selected";} ?>   >adventure</option>
                    <option value="novel" <?php if($row['type']=="novel"){echo "selected";} ?>           >novel</option>
                    <option value="sci fi" <?php if($row['type']=="sci fi"){echo "selected";} ?>         >sci fi</option>
                    <option value="horror" <?php if($row['type']=="horror"){echo "selected";} ?>         >horror</option>
                </select>
            </div>

            <div class="form-element my-4">
                <input type="text" class="form-control" name="description" value="<?php echo $row['description'];?>" placeholder="enter the description of the book nigger    ">
            </div>

            <input type="hidden" name="id" value="<?php echo $row['id'];  ?>">

            <div class="form-element">
                <input type="submit"  class="btn btn-success" name="edit" value="click 2 submit" >
             </div>


        </form>



        
</div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>
</html>