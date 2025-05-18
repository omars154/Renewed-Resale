<?php
session_start();
require("connection.php");

if (isset($_POST['add_to_cart']) && isset($_SESSION['privilleged'])) {
    $username = $_SESSION['privilleged'];
    $ad_id    = $_POST['ad_id'];
    $title    = $_POST['title'];
    $price    = $_POST['price'];
    $phone    = $_POST['phone'];
    $address  = $_POST['address'];
    
    $check_sql = "
      SELECT * FROM cart WHERE UserID = (SELECT UserID FROM users WHERE Username = :username) AND ADID = :ad_id";
    $check_statement = $pdo->prepare($check_sql);
    $check_statement->bindParam(':username', $username, PDO::PARAM_STR);
    $check_statement->bindParam(':ad_id',     $ad_id,    PDO::PARAM_INT);
    $check_statement->execute();
    $existingItem = $check_statement->fetch(PDO::FETCH_ASSOC);

    if (!$existingItem) {
        $ad_sql    = "SELECT * FROM ad WHERE ADID = :ad_id";
        $statement = $pdo->prepare($ad_sql);
        $statement->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
        $statement->execute();
        $ad_info = $statement->fetch(PDO::FETCH_ASSOC);
        
        $title = $ad_info['Title'];
        $price = $ad_info['Price'];
        $description = $ad_info['Description'];
        $phone = $ad_info['Phone'];
        $address = $ad_info['Address'];

        $cart_sql = "
          INSERT INTO cart
            (UserID, ADID, Title, Price, Description, Phone, Address, Liked)
          VALUES
            (
              (SELECT UserID FROM users WHERE Username = :username),
              :ad_id, :title, :price, :description, :phone, :address, 1
            )
          ON DUPLICATE KEY UPDATE
            Liked = NOT Liked
        ";
        $statement = $pdo->prepare($cart_sql);
        $statement->bindParam(':username',    $username,              PDO::PARAM_STR);
        $statement->bindParam(':ad_id',       $ad_id,                 PDO::PARAM_INT);
        $statement->bindParam(':title',       $ad_info['Title'],      PDO::PARAM_STR);
        $statement->bindParam(':price',       $ad_info['Price'],      PDO::PARAM_INT);
        $statement->bindParam(':description', $ad_info['Description'],PDO::PARAM_STR);
        $statement->bindParam(':phone',       $ad_info['Phone'],      PDO::PARAM_INT);
        $statement->bindParam(':address',     $ad_info['Address'],    PDO::PARAM_STR);
        $statement->execute();

        header('Location: final.php');
        exit();
    }
    else
    {
        $delete_sql = "
          DELETE FROM cart
          WHERE UserID = (
            SELECT UserID FROM users WHERE Username = :username
          )
          AND ADID = :ad_id
        ";
        $delete_statement = $pdo->prepare($delete_sql);
        $delete_statement->bindParam(':username', $username, PDO::PARAM_STR);
        $delete_statement->bindParam(':ad_id',    $ad_id,    PDO::PARAM_INT);
        $delete_statement->execute();

        header('Location: cart.php');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="liked.css">
    <title>Cart</title>
</head>

<body>
<?php
    include("connection.php");
    if (!isset($_SESSION['privilleged'])) {
        header("Location: sign_in.php");
        exit();
    }

    $username = $_SESSION['privilleged'];
    $sql = "SELECT * FROM cart WHERE UserID = (SELECT UserID FROM users WHERE Username = :username)";
    $statement = $pdo->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
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
                        <a class="nav-link active" href="cart.php">Liked</a>
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
        <div class="cards-container">
    <?php
        foreach ($cartItems as $item) {
            echo '
            <div class="item-card">
                <div class="item-header">' . htmlspecialchars($item['Title']) . '</div>
                <div class="item-price">'    . htmlspecialchars($item['Price']) . '</div>
                <div class="owner-phone">Contact: ' . htmlspecialchars($item['Phone'])   . '</div>
                <div class="owner-address">Address: ' . htmlspecialchars($item['Address']) . '</div>
                <form action="cart.php" method="post">
                    <input type="hidden" name="ad_id" value="' . (int)$item['ADID'] . '">
                    <button type="submit" name="add_to_cart"><p>UnLike</p></button>
                </form>
            </div>
            ';
        }
        $pdo = null;
    ?>
    </div>

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
