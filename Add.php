<?php
session_start();
require("connection.php");

if (isset($_POST['insert']) && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK)
{
    $username    = $_SESSION['privilleged'];
    $price       = $_POST['price'];
    $name        = $_POST['name'];
    $description = $_POST['description']; 
    $phone       = $_POST['phone'];
    $address     = $_POST['address'];

    $imgData = file_get_contents($_FILES['image']['tmp_name']);

    $IDsql       = "SELECT UserID FROM users WHERE Username = :username";
    $IDstatement = $pdo->prepare($IDsql);
    $IDstatement->bindParam(":username", $username, PDO::PARAM_STR);
    $IDstatement->execute();
    $user        = $IDstatement->fetch(PDO::FETCH_ASSOC);
    $userID      = $user['UserID'];

    $sql    = "
      INSERT INTO ad
        (UserID, Price, Title, Description, Phone, Address, img)
      VALUES
        (:userID, :price, :name, :description, :phone, :address, :imgData)
    ";
    $statemnt = $pdo->prepare($sql);
    $statemnt->bindParam(':userID',      $userID,      PDO::PARAM_INT);
    $statemnt->bindParam(':price',       $price,       PDO::PARAM_INT);
    $statemnt->bindParam(':name',        $name,        PDO::PARAM_STR);
    $statemnt->bindParam(':description', $description, PDO::PARAM_STR);
    $statemnt->bindParam(':phone',       $phone,       PDO::PARAM_INT);
    $statemnt->bindParam(':address',     $address,     PDO::PARAM_STR);
    $statemnt->bindParam(':imgData',     $imgData,     PDO::PARAM_LOB);
    $statemnt->execute();

    $pdo = null;
    header('Location: Final.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="add.css">
    </head>
    <body>
        <div class="main">
        <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a href="Final.php"><img src="./images/cyanlogo.png" class="navbar-brand img-fluid" style="max-width: 50px;" alt="Logo"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                        <a class="nav-link" href="final.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Liked</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="item.php">My Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="logout.php">Log Out</a>
                    </li>
                </ul>
              </div>        
            </div>
          </nav>
            <form method="post" enctype="multipart/form-data">
                <div class="form-box">
                    <div class="input price floating-label">
                        <input class="price" id="price" type="number" name="price">
                        <label for="price">Price</label>
                    </div>
                    <div class="input name floating-label">
                        <input class="name" id="name" type="text" name="name" >
                        <label for="name">Title</label>
                    </div>
                    <div class="input address floating-label">
                        <input class="address" id="address" type="text" name="address">
                        <label for="address">Address</label>
                    </div>
                    <div class="input contact floating-label">
                        <input class="contact" id="contact" type="number" name="phone">
                        <label for="contact">Phone</label>
                    </div>
                    <div>
                        <input type="file" class="add-file" name="image" id="image" accept="image/*">
                    </div>
                    <div class="input register">
                        <input class="submit" type="submit" name="insert" placeholder="Add Sale">
                    </div>
                </div>
            </form>
        </div>
        <footer>
            <div class="footer flogo">
                <img src="./images/cyanlogo.png" alt="logo">
            </div>
            <div class="footer fabout">
                <h1>About</h1>
                <a href="about.html">Learn about us</a>
                <a href="about.html">Who does the website belogns to</a>
                <a href="about.html">what is the website</a>
            </div>
        </footer>
    </body>
</html>