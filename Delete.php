<?php
session_start();
require("connection.php");

if (isset($_POST['Delete']) && isset($_SESSION['privilleged']))
{
    $username=$_SESSION['privilleged'];
    $ad_id=$_POST['ad_id'];
    $sql="DELETE FROM ad WHERE ADID=:ad_id AND UserID=(SELECT UserID FROM users WHERE Username=:username)";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(':username',$username,PDO::PARAM_STR);
    $statement->bindParam(':ad_id',$ad_id,PDO::PARAM_INT);
    $statement->execute();
    header('location: item.php');
}
?>