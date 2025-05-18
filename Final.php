<?php
session_start();
require("connection.php");

if (!isset($_SESSION['privilleged']))
{
    header("location:sign_in.php");
    exit();
}
    if(isset($_SESSION["privilleged"])){
        $username=$_SESSION["privilleged"];
        $sql="SELECT * FROM users WHERE Username=:username";
        $statement=$pdo->prepare($sql);
        $statement->bindParam(':username',$username,PDO::PARAM_STR);
        $statement->execute();
        $user=$statement->fetch(PDO::FETCH_ASSOC);
        if($user){
            $FullName=$user['firstName'].' '.$user['lastName'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewed&Resale</title>
    <meta name="description" content="Sell and buy your favorite used items.">
    <meta name="keywords" content="used">
    <meta name="keywords" content="ADS">
    <meta name="keywords" content="Ecommerce">
    <meta name="keywords" content="cars">
    <meta name="keywords" content="phones">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Home.css">
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
                        <a class="nav-link active" href="final.php">Home</a>
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
          <div class="animation-1"></div>
          <div class="animation-2"></div>
          <div class="animation2-2"></div>
          <div class="animation1-1"></div>
          <h1 id="HiUser">Hi
                    <?php
                        if (isset($FullName))
                        {
                            echo $FullName;
                        } 
                        else
                        {
                            echo"guest";
                        }
                        ?></h1>
          <div class="cards-container">
            <?php
            require("connection.php");
            $sql="select * from ad";
            $statemnt=$pdo->prepare($sql);
            $statemnt->execute();
            $data=$statemnt->fetchAll();

            foreach($data as $row)
            {
            echo'<div class="item-card">
                <img class="Card" src="data:image;base64,'.$row['img'].'" alt="Item Image">
                <div class="item-header">'.$row['Title'].'</div>
                <div class="item-price">Price:'.$row['Price'].'</div>
                <div class="owner-phone">Contact:'.$row['Phone'].'</div>
                <div class="owner-address">Address:'.$row['Address'].'</div>';
                
            echo "<form action='cart.php' method='post'>";
            echo "<input type='hidden' name='ad_id' value='".$row["ADID"]."'>";
            echo "<input type='hidden' name='title' value='".$row['Title']."'>";
            echo "<input type='hidden' name='price' value='".$row['Price']."'>";
            echo "<input type='hidden' name='phone' value='".$row['Phone']."'>";
            echo "<input type='hidden' name='address' value='".$row['Address']."'>";
            echo "<button type='submit' name='add_to_cart'><p>Like</p></button>";
            echo "</form>";
            echo '</div>';

            }
            $pdo=null;
            ?>
          </div>
            <div class="add-button">
                <a href="add.php" id="add">
                    <button>ADD ITEMS</button>
                </a>
            </div>

            <div class="background-object"></div>
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