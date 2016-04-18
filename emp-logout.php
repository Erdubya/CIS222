<?php
session_start();

if(isset($_GET['logout']))
{
    $redirect =  $_GET["redirect"];

    unset($_SESSION['employee']);
    header("Location: ".$redirect);
}
