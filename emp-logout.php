<?php
session_start();

if(isset($_GET['logout']))
{
    $redirect =  $_GET["redirect"];
    //Logout the employee only
    unset($_SESSION['employee']);
    if ($redirect == "employee-login.php") {
        header("Location: " . $redirect . "?redirect=index.php");
    } else {
        header("Location: " . $redirect);
    }
}
