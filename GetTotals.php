<?php
ob_start();
require_once '_configuration.php';
/*
 * Generates a short disabled form to display the running total of the Item array00
 */
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted again!!!';
}
?>

<form>
    <label for="totalField" onmouseup="selectInput()">Total:</label>
    <input type="text" id="totalField" name="total" required disabled value="$<?php
    $total = 0;
    foreach ($_SESSION['items'] as $item) {
        $total = $item->GetPrice() + $total;
    }
    echo $total;
    ?>">
</form>

<?php

ob_end_flush();

?>


