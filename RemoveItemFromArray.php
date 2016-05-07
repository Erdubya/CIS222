<?php
require_once '_configuration.php';
/*
 * Script to facilitate the removal of an item from the order array
 */
session_start();

//Set which Item to remove
$remove = $_POST['remItem'];

//Unset that item
unset($_SESSION['items'][$remove]);

//Renumber the array
$_SESSION['items'] = array_values($_SESSION['items']);

header("Location: remove-item.php");

exit();
