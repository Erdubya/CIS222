<?php
require_once '_configuration.php';
/*
 * Adds a new or edited item to the inventory
 */
session_start();
$link = db_connect();

//Set item data to variables
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
    //If editing, perform update
    $sql = "UPDATE Item SET Name='$name', Description='$desc', Available=$aval, Restricted=$rstc, Price=$prce WHERE ItemID=$item";
    $result = mysqli_query($link, $sql);
} else {
    //If new item, insert into table
    $sql = "INSERT INTO Item(Name, Description, Available, Restricted, Price) VALUES ('$name', '$desc', $aval, $rstc, $prce)";
    $result = mysqli_query($link, $sql);
}
