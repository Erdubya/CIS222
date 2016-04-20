<?php
require_once '_configuration.php';
include_once '_Functions.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

$remove = $_POST['remItem'];

$_SESSION['last']['item'] = $_SESSION['items'][$remove];
$_SESSION['last']['remove'] = $remove;
var_dump($_SESSION['last']);

unset($_SESSION['items'][$remove]);
$_SESSION['items'] = array_values($_SESSION['items']);

mysqli_close($link);

header("Location: remove-item.php");

exit();
