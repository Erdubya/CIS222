<?php
/*
 * Logout script: logs out both current user and employee
 */
session_start();

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	unset($_SESSION['items']);
	header("Location: index.php");
}
