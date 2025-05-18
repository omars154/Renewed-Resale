<?php
require("connection.php");
if(isset($_POST['insert']))
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $firstName=$_POST['firstName'];
    $lastName=$_POST['lastName'];
    $check="SELECT * FROM users WHERE Username=:username";
    $check=$pdo->prepare($check);
    $check->bindParam(':username',$username,PDO::PARAM_STR);
    $check->execute();
    $exist=$check->fetch(PDO::FETCH_ASSOC);

    if($exist)
    {
        echo"<script>alert('Username already exists. Please choose a different username.');</script>";
    }
    else 
    {
        $sql="INSERT INTO users(Username,Password,firstName,lastName) VALUES (:username,:password,:firstName,:lastName)";
        $statement=$pdo->prepare($sql);
        $statement->bindParam(':username',$username,PDO::PARAM_STR);
        $statement->bindParam(':password',$password,PDO::PARAM_STR);
        $statement->bindParam(':firstName',$firstName,PDO::PARAM_STR);
        $statement->bindParam(':lastName',$lastName,PDO::PARAM_STR);
        $statement->execute();
        $pdo=null;

        header('location:sign_in.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="register.css">
    </head>
    <body>
        <div class="main">
            <div class="left">
                <form method="post">
                    <div class="SignUp">
                        <div class="img">
                            <img src="./images/cyanlogo.png" alt="Logo">
                        </div>
                        <div class="input fname floating-label">
                            <input type="text" id="firstName" name="firstName" required>
                            <label for="firstName">First Name</label>
                        </div>
                        <div class="input lname floating-label">
                            <input type="text" id="lastName" name="lastName" required>
                            <label for="lastName">Last Name</label>
                        </div>
                        <div class="input username floating-label">
                            <input type="text" id="username" name="username" required>
                            <label for="username">username</label>
                        </div>
                        <div class="input password floating-label">
                            <input type="password" id="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="input password2 floating-label">
                            <input type="password" id="rePassword" required>
                            <label for="rePassword">Re-enter Password</label>
                        </div>
                        <div class="input register">
                            <input id="submit" type="submit" name="insert" value="Create Account">
                        </div>
                    </div>
                </form>
            </div>
            <div class="right"></div>
            <div class="orbit-container">
                <div class="orbiting-element"></div>
            </div>
        </div>
        <script src="Register.js"></script>
    </body>
</html>