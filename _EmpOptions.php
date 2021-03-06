<?php
require_once "_configuration.php";
/*
 * This file generates the options dialog for logged-in employees
 */
$link = db_connect();

ob_start();
?>
<!--Dialog popup for options-->
<dialog id='emp-options' title="Employee Options">
    <?php
    //Get redirect fot logout
    $red = basename($_SERVER['PHP_SELF']);
    
    //Get employee name
    $sql = "SELECT FName, LName FROM Users WHERE UserID=" . $_SESSION['employee'];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    
    //Display employee ID and name
    echo "<p class='center optdia'>Logged in as: " . $_SESSION['employee'] . "</p>";
    echo "<p class='center optdia'>". $row['FName'] . " " . $row['LName'] . "</p>";
    
    ?>
    <div id="emp-buttons" class="center options">
        <a href="home.php?override">
            <button class="emp-options center" name="cart" type="button" disabled>Price Override</button>
        </a><br>
        <a href="edit-user.php">
            <button class="emp-options center" name="customer" type="button">User Manager</button>
        </a><br>
        <a href="edit-inventory.php">
            <button class="emp-options center" name="inventory" type="button">Inventory Manager</button>
        </a><hr style="margin-top: 0">
        <a href="emp-logout.php?logout&redirect=<?php echo $red ?>">
            <button class="emp-options center" name="cancel" type="button">Logout</button>
        </a><br>
        <button class="emp-options center" id="emp-help-button" name="help" type="button">Request Assistance</button>
    </div>
</dialog>

<!--Splash text to note login; link to open options-->
<div id="emp-footer" class="center unselectable">
    <span>LOGGED ON</span>
</div>
<?php
ob_end_flush();
?>
