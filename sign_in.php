<?php

require("connection.php");
session_start();

if(isset($_POST['insert']))
{
    $username=$_POST["username"];
    $password=$_POST["password"];

    $sql="SELECT * FROM users WHERE Username=:username AND Password=:password";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(":username",$username,PDO::PARAM_STR);
    $statement->bindParam(":password",$password,PDO::PARAM_STR);
    $statement->execute();
    $user=$statement->fetch(PDO::FETCH_ASSOC);
    $count=$statement->rowCount();

    if($count==1)
    {
        $_SESSION['privilleged']=$username;
        $_SESSION['enter']=$user['UserID'];

        header("location:final.php");
    }
    else
    {
        echo"<script> alert('wrong password or username')</script>";
    }
    $pdo=null;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="sign.css">
    </head>
    <body>
        <div class="main">
            <div class="left">
                <form action="" method="post">
                    <div class="Sign">
                        <div class="img"><img src="./images/cyanlogo.png" alt="logo"></div>
                        <div class="input username floating-label">
                            <input type="text" id="username" name="username" required>
                            <label for="username">username</label>
                        </div>
                        <div class="input password floating-label">
                            <input type="password" id="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="new-account">
                            <p class="SignUp">Dont have an account? <a href="register.php">Sign Up</a></p>
                        </div>
                        <div class="new-password">
                            <p class="change-password">forgot Your Password? <a href="change.php">Change</a></p>
                        </div>
                        <div class="input login">
                            <input id="submit" type="submit" name="insert" value="Login">
                        </div>
                    </div>
                </form>
            </div>
            <div class="orbit-container">
                <div class="orbiting-element"></div>
            </div>
            <div class="right">
            </div>
        </div>
    </body>
</html>