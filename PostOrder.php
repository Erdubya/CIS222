<?php
require_once '_configuration.php';
include_once '_Functions.php';

//This file mimics an external bank.
include_once 'CustBank/bank.php';

session_start();
$link = db_connect();
$bank = new bank();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

$sql = "SELECT FName, LName, CCNum FROM Users WHERE UserID=" . $_SESSION['user'];
$qry = mysqli_query($link, $sql);
$result = mysqli_fetch_array($qry);

$check = $bank->CheckCard($result['CCNum'], $result['FName'] . " " . $result['LName']);
var_dump($check);

if (isset($_SESSION['items']) && $check) {
    //Create new order
    $createOrder = "INSERT INTO Orders(OrderID, UserID, TotPrice) VALUES (NULL," . $_SESSION['user'] . ", 0)";
    $qry = mysqli_query($link, $createOrder);
    if (!$qry) {
        printf("Error message: " . mysqli_error($link));
    }
    
    var_dump($createOrder);
    var_dump($qry);

    $orderID = mysqli_insert_id($link);
    var_dump($orderID);

    $totPrice = 0;
    foreach ($_SESSION['items'] as $item) {
        $strip = substr($item->GetItemNum(), 0, -1);
        var_dump($strip);
        $exists = false;

        $res = mysqli_query($link, "SELECT ItemNum, Quantity FROM PurchItem WHERE OrderID=" . $orderID);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

        while ($row && !$exists) {
            if ($row['ItemNum'] == $strip) {
                $exists = true;
                echo "Exists!<br>";
                mysqli_query($link, "UPDATE PurchItem SET Quantity=" . ++$row['Quantity'] . " WHERE ItemNum=" . $strip . " AND OrderID=" . $orderID);
                $totPrice = $totPrice + $item->GetPrice();
            }
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        }

        if (!$exists) {
            $sql = "INSERT INTO PurchItem (ItemNum, OrderID, PurchPrice, Quantity) VALUES(" . $strip . ", " . $orderID . ", " . $item->GetPrice() . ", 1)";
            $qry = mysqli_query($link, $sql);
            $totPrice = $totPrice + $item->GetPrice();
        }

        var_dump($sql);
        var_dump($qry);
    }

    $sql = "UPDATE Orders SET TotPrice=" . $totPrice . " WHERE OrderID=" . $orderID;
    $qry = mysqli_query($link, $sql);
    var_dump($sql);
    var_dump($qry);

    unset($_SESSION['items']);
    mysqli_close($link);
}

echo '<a href="home.php">Home</a><br>';
echo '<a href="logout.php?logout">Logout</a>';

header("Location: receipt.php?order=" . urlencode(base64_encode($orderID)));
exit();
