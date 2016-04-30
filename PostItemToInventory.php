<?php
require_once '_configuration.php';
include "class/ChromePhp.php";
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

$item = $_POST['ItemID'];
$name = $_POST['Name'];
$desc = $_POST['Description'];
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
    ChromePhp::log($sql);
    $result = mysqli_query($link, $sql);
    ChromePhp::log($result);
} else {
    $sql = "INSERT INTO Item(Name, Description, Available, Restricted, Price) VALUES ('$name', '$desc', $aval, $rstc, $prce)";
    ChromePhp::log($sql);
    $result = mysqli_query($link, $sql);
    ChromePhp::log($result);
}
