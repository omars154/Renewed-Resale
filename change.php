<?php
require("connection.php");

if(isset($_POST['insert'])) {
    $username=$_POST["username"];
    $newPassword=$_POST["password"];

    $sql="UPDATE users SET Password=:newPassword WHERE Username=:username";
    $Statement=$pdo->prepare($sql);
    $Statement->bindParam(":newPassword",$newPassword,PDO::PARAM_STR);
    $Statement->bindParam(":username",$username,PDO::PARAM_STR);
    $Statement->execute();
    header("location: sign_in.php");
    $pdo = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="test.css">
</head>
<body>
    <div class="main">
        <div class="left">
            <form action="" method="post">
                <div class="Sign">
                    <div class="img"><img src="./images/cyanlogo.png" alt="logo"></div>
                    <div class="input username floating-label">
                        <input type="text" id="username" name="username" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="input password floating-label">
                        <input type="password" id="password" name="password" required>
                        <label for="password"> New Password</label>
                    </div>
                    <div class="input login">
                        <input id="submit" type="submit" name="insert" value="Change">
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