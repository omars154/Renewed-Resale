<?php
session_start();

if (isset($_SESSION['privilleged'])) {
    unset($_SESSION['privilleged']);
}

session_destroy();

header("location:sign_in.php");
?>