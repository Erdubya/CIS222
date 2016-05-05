<?php
require_once '_configuration.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

$item = $_POST['ItemID'];
$name = mysqli_escape_string($link, $_POST['Name']);
$desc = mysqli_escape_string($link, $_POST['Description']);
$aval = $_POST['Available'];
if (is_null($aval)) {
    $aval = 0;
}
$rstc = $_POST['Restricted'];
if (is_null($rstc)) {
    $rstc = 0;
}
$prce = $_POST['Price'];

if (isset($_POST['ItemID'])) {
    $sql = "UPDATE Item SET Name='$name', Description='$desc', Available=$aval, Restricted=$rstc, Price=$prce WHERE ItemID=$item";
    $result = mysqli_query($link, $sql);
} else {
    $sql = "INSERT INTO Item(Name, Description, Available, Restricted, Price) VALUES ('$name', '$desc', $aval, $rstc, $prce)";
    $result = mysqli_query($link, $sql);
}
