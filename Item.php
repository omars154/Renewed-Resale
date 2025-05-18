<?php
session_start();
require("connection.php");

if (!isset($_SESSION["privilleged"]))
{
    header("location: sign_in.php");
    exit();
}
    $username=$_SESSION["privilleged"];
    $IDsql="SELECT UserID FROM users WHERE Username=:username";
    $IDstatement=$pdo->prepare($IDsql);
    $IDstatement->bindParam(":username",$username,PDO::PARAM_STR);
    $IDstatement->execute();
    $user=$IDstatement->fetch(PDO::FETCH_ASSOC);
    $userID=$user['UserID'];

    $sql="SELECT * FROM ad WHERE UserID=:userID";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":userID",$userID,PDO::PARAM_INT);
    $statement->execute();
    $items=$statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="Item.css">
    </head>
    <body>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a href="Final.php"><img src="./images/cyanlogo.png" class="navbar-brand img-fluid" style="max-width: 50px;" alt="Logo"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll text-center" style="--bs-scroll-height: 100px;">
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
                        <a class="nav-link active"  href="item.php">My Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="logout.php">Log Out</a>
                    </li>
                </ul>
              </div>        
            </div>
          </nav>
          <div class="animation-1"></div>
          <div class="animation-2"></div>
          <div class="animation2-2"></div>
          <div class="animation1-1"></div>
            <div class="cards-container">
                
                    <?php
                    foreach ($items as $row) {
                        echo '<div class="item-card">
                                <a class="Card" href="/Final/Item/Item.html">
                                    <img class="Card" src="data:image;base64,' .$row['img'].'" alt="Item Image">
                                    <div class="item-header">' . $row['Title'] . '</div>
                                    <div class="item-price">' . $row['Price'] . '</div>
                                    <div class="owner-phone">Contact:' . $row['Phone'] . '</div>
                                    <div class="owner-address">Address:'.$row['Address'].'</div>
                                </a>';
                                echo "<form action='Delete.php' method='post'>";
                            echo "<input type='hidden' name='ad_id' value='" . $row["ADID"] . "'>";
                            echo "<button type='submit' name='Delete'><p>DELETE</p></button>";
                            echo "</form>";
                        echo'</div>';
                    }
                    ?>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>