<?php
require_once '_configuration.php';
/*
 * Adds an item to the purchase array after a scan
 */
session_start();
$link = db_connect();

//Check if price was edited
if (isset($_POST['element'])) {
    $key = $_POST['element'];
    //Set new price
    if (!empty($_SESSION['items'][$key])) {
        $_SESSION['items'][$key]->SetPrice($_POST['Price']);
    }
}

//Check if item input was set
if (isset($_POST['item'])) {
    if (UPCA_Check($_POST['item'])) {
        //If item code is valid perform the following
        $strip = substr($_POST['item'], 0, -1);
        $temp = new Item();

        //Get item information
        $qry = mysqli_query($link, "SELECT Name, Price, Restricted FROM Item WHERE ItemID=" . $strip);
        $info = mysqli_fetch_array($qry);
        
        //If the item exists, set the information to the array
        if (!is_null($info)) {
            $temp->SetItem($info['Name']);
            $temp->SetItemNum($_POST['item']);
            $temp->SetPrice($info['Price']);
            $_SESSION['items'][count($_SESSION['items'])] = $temp;
        }
    }
}

header("Location: home.php");
mysqli_close($link);

exit();
