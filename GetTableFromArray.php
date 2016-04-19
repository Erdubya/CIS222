<?php
ob_start();
require_once '_configuration.php';

session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted again!!!';
}

$alternate = 0;
if (isset($_GET['remove'])) {
    echo '<form class="remove-select">';
}
echo '<table class="items">';
echo '<thead><tr>';
if (isset($_GET['remove'])) {
    echo '<th class="radio">&#x267A;</th>';
}
echo '<th>Item</th>';
echo '<th class="midd num">Item Number</th>';
echo '<th class="price">Price</th>';
echo '</tr></thead><tbody>';
foreach ($_SESSION['items'] as $key => $item) {
    $alternate++;
    if ($alternate == 3)
        $alternate = 1;
    echo '<tr class="itemRow' . $alternate . '">';
    if (isset($_GET['remove'])) {
        echo '<td class=radio>';
        echo "<form id='removeForm$key' class='removeItem' name='removeItem'>";
        echo "<input type='checkbox' name='select' value='$key' checked hidden>";
        echo "<input class='remove-in' type='button' name='submit' value='&#x2717'>";
        echo "</form></td>";
    }
    echo '<td class="name">';
    echo $item->GetItem();
    echo '</td><td class="midd num">';
    echo $item->GetItemNum();
    echo '</td><td class="price">';
    echo $item->GetPrice();
    echo '</td>';
    echo '</tr>';
}
echo '</tbody></table>';
if (isset($_GET['remove']))
    echo '</form>';

ob_end_flush();

exit;
