<?php
require_once '_configuration.php';
include_once '_Functions.php';
include "class/ChromePhp.php";
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

if (isset($_POST['element'])) {
    $key = $_POST['element'];
    if (!empty($_SESSION['items'][$key])) {
        $_SESSION['items'][$key]->SetPrice($_POST['Price']);
    }
    ChromePhp::log("IT HAPPENED");
}

if (isset($_POST['item'])) {
    if (UPCA_Check($_POST['item'])) {
        $strip = substr($_POST['item'], 0, -1);
        $temp = new Item();

        $qry = mysqli_query($link, "SELECT Name, Price, Restricted FROM Item WHERE ItemID=" . $strip);
        $info = mysqli_fetch_array($qry);
        
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

?>
