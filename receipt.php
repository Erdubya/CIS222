<?php
ob_start();
require_once '_configuration.php';
session_start();
$link = db_connect();

$orderID = base64_decode($_GET['order']);

$qry = mysqli_query($link, "SELECT * FROM Orders WHERE OrderID=$orderID AND UserID=" . $_SESSION['user']);
$order = mysqli_fetch_array($qry);

$qry = mysqli_query($link, "SELECT * FROM Users WHERE UserID=" . $_SESSION['user']);
$user = mysqli_fetch_array($qry);

if (is_null($order)) {
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset=utf-8"/>
    <title><?= PAGE_TITLE ?> - Order Receipt</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/receipt.css"/>
</head>

<body>
<div id="all center">
    <div class="center">
        <a href="index.php"><?= SMALL_IMG ?></a>
    </div>
    <table class="receipt center">
        <thead>
            <tr>
                <th colspan="4" style="border-bottom: 1px solid black">
                    <h1>Details for Order</h1>
                    <p>A copy has been sent to your provided email</p>
                </th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="leftSide header">
                <div class="leftAlign">
                    <p><strong>Order Number:</strong></p><br>
                    <p><strong>Order Date:</strong></p><br>
                    <p><strong>Order Total:</strong></p><br>
                </div>
            </td>
            <td>
                <div class="leftAlign">
                    <p><?php echo "\t" . $order['OrderID']?></p><br>
                    <p><?php echo "\t" . $order['Date']?></p><br>
                    <p><?php echo "\t$" . $order['TotPrice']?></p><br>
                </div>
            </td>
            <td class="header">
                <div class="leftAlign">
                    <p><strong>Name:</strong></p><br>
                    <p><strong>Email:</strong></p><br>
                    <p><strong>Phone:</strong></p><br>
                </div>
            </td>
            <td class="rightSide">
                <div class="leftAlign">
                    <p><?php echo $user['FName'] . " " . $user['LName']?></p><br>
                    <p><?php echo $user['EmailAddr']?></p><br>
                    <p>
                        <?php
                        $phone = "(" . substr($user['PhoneNum'],0,3) . ") " . substr($user['PhoneNum'],3,3) . "-"
                            . substr($user['PhoneNum'],6,4);
                        echo $phone;
                        ?>
                    </p><br>
                </div>
            </td>
        </tr>
        <tr class="borders">
            <td colspan="4">
                
            </td>
        </tr>
        <tr class="items">
            <td colspan="3">
                <div class="leftAlign">
                    <p><strong>Items:</strong></p>
                </div>
            </td>
            <td>
                <div class="rightAlign">
                    <p><strong>Price/Unit:</strong></p>
                </div>
            </td>
        </tr>
        <?php
        ob_start();
        
        $sql = "SELECT PurchItem.ItemNum, PurchItem.PurchPrice, PurchItem.Quantity, Item.Name FROM PurchItem JOIN Item ON PurchItem.ItemNum = Item.ItemID WHERE PurchItem.OrderID=$orderID";
        $result = mysqli_query($link, $sql);

        while (!is_null($row = mysqli_fetch_array($result))) {
            echo '<tr class="items"><td colspan="3"><div class="leftAlign">';
            echo '<p><em>' . $row['ItemNum'] . '</em></p><br>';
            echo '<p>' . $row['Name'] . '</p><br>';
            echo '<p class="rowQ">Quantity: ' . $row['Quantity'] . '</p>';
            echo '</div></td><td><div class="rightAlign">';
            echo '<p>$' . $row['PurchPrice'] . '</p>';
            echo '</div></td>';
            echo '</tr>';
        }
        
        ?>
        </tbody>
    </table> 
</div>
</body>
</html>
<?php
$receipt = ob_get_clean();

echo $receipt;

?>
