<?php
require_once '_configuration.php';
include_once '_Functions.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

if (!is_null($_SESSION['last']['item'])) {
    array_slice($_SESSION['items'], $_SESSION['last']['remove'], 0, $_SESSION['last']['item']);
}

mysqli_close($link);

header("Location: remove-item.php");

exit();
