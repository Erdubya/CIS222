<?php
session_start();

if(isset($_GET['logout']))
{
    $redirect =  $_GET["redirect"];
    //Logout the employee only
    unset($_SESSION['employee']);
    header("Location: ".$redirect);
}
