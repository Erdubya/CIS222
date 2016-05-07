<?php
require_once '_configuration.php';
/*
 * The script posts a new order
 */

//This file mimics an external bank.
require_once 'CustBank/Bank.php';

session_start();
$link = db_connect();
$bank = new Bank();

//Get necessary information from database
$sql = "SELECT FName, LName, CCNum FROM Users WHERE UserID=" . $_SESSION['user'];
$qry = mysqli_query($link, $sql);
$result = mysqli_fetch_array($qry);

//Utilize the bank to confirm that the credit card account is valid
$check = $bank->CheckCard($result['CCNum'], $result['FName'] . " " . $result['LName']);

if (isset($_SESSION['items']) && $check) {
    //If the array exists and the credit check is true, create a new order
    $createOrder = "INSERT INTO Orders(OrderID, UserID, TotPrice) VALUES (NULL," . $_SESSION['user'] . ", 0)";
    $qry = mysqli_query($link, $createOrder);
    if (!$qry) {
        //If it doesn't work, display error message
        printf("Error message: " . mysqli_error($link));
    }

    //retrieve the new order ID
    $orderID = mysqli_insert_id($link);

    //Initiate the post process
    $totPrice = 0;
    //Perform the following for each item in the array
    foreach ($_SESSION['items'] as $item) {
        //remove
        $strip = substr($item->GetItemNum(), 0, -1);
        $exists = false;

        //Get item information
        $res = mysqli_query($link, "SELECT ItemNum, Quantity FROM PurchItem WHERE OrderID=" . $orderID);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

        //Repeat for each item to check if it is already counted
        while ($row && !$exists) {
            if ($row['ItemNum'] == $strip) {
                //If it does exist, increment the quantity and total price
                $exists = true;
                echo "Exists!<br>";
                mysqli_query($link, "UPDATE PurchItem SET Quantity=" . ++$row['Quantity'] . " WHERE ItemNum=" . $strip . " AND OrderID=" . $orderID);
                $totPrice = $totPrice + $item->GetPrice();
            }
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        }

        //If the item does not already exist in the order, add to the order and increase total price
        if (!$exists) {
            $sql = "INSERT INTO PurchItem (ItemNum, OrderID, PurchPrice, Quantity) VALUES(" . $strip . ", " . $orderID . ", " . $item->GetPrice() . ", 1)";
            $qry = mysqli_query($link, $sql);
            $totPrice = $totPrice + $item->GetPrice();
        }
    }

    //set the total price of the order
    $sql = "UPDATE Orders SET TotPrice=" . $totPrice . " WHERE OrderID=" . $orderID;
    $qry = mysqli_query($link, $sql);

    //clear the order array
    unset($_SESSION['items']);
    mysqli_close($link);
}

//Encode order number and redirect to receipt
header("Location: receipt.php?order=" . urlencode(base64_encode($orderID)));
