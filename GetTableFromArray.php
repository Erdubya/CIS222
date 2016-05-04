<?php
ob_start();
require_once '_configuration.php';
include "class/ChromePhp.php";
/*
 * This file will generate a table based off an array of Items.
 */

session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted again!!!';
}
$alternate = 0;

echo '<table class="items">';
echo '<thead><tr>';

if (isset($_GET['remove'])) {
    echo '<th class="table-ops">&#x267A;</th>';
}

echo '<th>Item</th>';
echo '<th class="midd num">Item Number</th>';
echo '<th class="price">Price</th>';
echo '</tr></thead><tbody>';
foreach ($_SESSION['items'] as $key => $item) {
    //Set row color
    $alternate++;
    if ($alternate == 3)
        $alternate = 1;
    echo '<tr class="itemRow' . $alternate . '">';
    
    //Column for removal
    if (isset($_GET['remove'])) {
        echo '<td class=table-ops>';
        echo "<form class='removeItem' method='post' action='RemoveItemFromArray.php'>";
        echo "<input type='hidden' name='remItem' value='$key'>";
        echo "<input class='remove-in' type='submit' value='&#x2717'>";
        echo "</form></td>";
    }
    
    //Standard table
    echo '<td class="name">';
    echo $item->GetItem();
    echo '</td><td class="midd num">';
    echo $item->GetItemNum();
    echo "</td><td class='price'><form class='editItem' method='POST' action='PostItemToArray.php'><input name='Price' class='invEdit invPrice' type='text' maxlength='6' value='";
    echo $item->GetPrice();
    echo "' readonly><input type='submit' class='hide' name='element' value='$key'></form></td>";
    echo '</tr>';
}
echo '</tbody></table>';

ob_end_flush();

exit;
