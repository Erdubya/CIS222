<?php
ob_start();
require_once '_configuration.php';
/*
 * This file will generate an HTML table from the items database table.
 */
session_start();
$link = db_connect();

//Get items from table
$sql = "SELECT * FROM Item";
$result = mysqli_query($link, $sql);

//Set row color iteration
$alternate = 1;

?>
<table class="items">
    <thead class="tableRow">
    <tr>
        <th class="table-ops">
            Options
            <input type="checkbox" class="invCheck" id="selectAll" name="selectAll">
        </th>
        <th class="itemId">Item No.</th>
        <th class="itemName">Item Name</th>
        <th class="itemDesc">Description</th>
        <th class="itemAvail">In Stock</th>
        <th class="itemRstrc">18+</th>
        <th class="itemPrice">Price</th>
    </tr>
    </thead>
    <tbody>
    <?php
    //Build table
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr class='itemRow$alternate tableRow'>";
        //Nested table to hold forms
        echo "<td colspan='7'><form class='editItem' method='POST' action='PostItemToInventory.php'><table class='inner'><tbody><tr>";
        
        //Column for options
        echo '<td class=table-ops>';
        echo "<input name='submitItem' class='remove-in' type='submit' value='&#x2713'>";
        echo "<input class='remove-in' type='reset' value='&#x274C'>";
        echo "<input name='generate' class='invCheck' type='checkbox' value='" . $row['ItemID'] ."'>";
        echo "</td>";
        
        echo "<td class='itemId'><input name='ItemID' class='invNum invEdit' type='text' value='" . $row['ItemID'] . "' readonly></td>";
        echo "<td class='itemName'><input name='Name' class='invEdit' type='text' maxlength='20' value='" . $row['Name'] . "'></td>";
        echo "<td class='itemDesc'><input name='Description' class='invEdit' type='text' maxlength='80' value='" . $row['Description'] . "'></td>";
        
        echo "<td class='itemAvail'><input name='Available' class='invCheck' type='checkbox' value='1'";
        if ($row['Available'] == 1) {
            echo "checked";
        }
        echo "></td>";
        
        echo "<td class='itemRstrc'><input name='Restricted' class='invCheck' type='checkbox' value='1'";
        if ($row['Restricted'] == 1) {
            echo "checked";
        }
        echo "></td>";
        
        echo "<td class='itemPrice'><input name='Price' class='invEdit invPrice' type='text' maxlength='6' value='" . $row['Price'] . "'></td>";
        echo "</tr></tbody></table></form></td></tr>";
        
        //Sets Item number for the empty row
        $nextRow = $row['ItemID'] + 1;

        //Set row color
        $alternate++;
        if ($alternate == 3)
            $alternate = 1;
    }
?>
    <!-- Table and Form for New Item   -->
        <tr class='itemRow<?echo $alternate?> tableRow'>
            <td colspan='7'>
                <form name='new' class='editItem' method='post' action='PostItemToInventory.php'>
                    <table class='inner'>
                        <tbody>
                        <tr>
                            <td class=table-ops>
                                <input name='submitItem' class='remove-in' type='submit' value='&#x2713'>
                                <input class='remove-in' type='reset' value='&#x274C'>
                            </td>
                            <td class='itemId'>New Item</td>
                            <td class='itemName'><input name='Name' class='invEdit' type='text' maxlength="20" placeholder="New Item"></td>
                            <td class='itemDesc'><input name='Description' class='invEdit' type='text' maxlength="80" placeholder="New Item"></td>
                            <td class='itemAvail'><input name='Available' class='invCheck' type='checkbox' value='1' title="In Stock?"></td>
                            <td class='itemRstrc'><input name='Restricted' class='invCheck' type='checkbox' value='1' title="18 and Up?"></td>
                            <td class='itemPrice'><input name='Price' class='invEdit invPrice' type='text' maxlength="6" placeholder="999.99"></td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </td>
        </tr>
    
    </tbody>
</table>
<?

ob_end_flush();

exit;

