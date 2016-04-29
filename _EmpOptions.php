<?php
ob_start();

?>
<!--Dialog popup for options-->
<dialog id='emp-options' title="Employee Options">
    <?php
    $red = basename($_SERVER['PHP_SELF']);
    echo "<p class='center optdia'>Logged in as: " . $_SESSION['employee'] . "</p>";
    ?>
    <div id="emp-buttons" class="center options">
        <a href="confirmation.php">
            <button class="emp-options center" name="birth" type="button">Confirm Birthdate</button>
        </a><br>
        <a href="edit-cart.php">
            <button class="emp-options center" name="cart" type="button">Edit Cart</button>
        </a><br>
        <a href="edit-user.php">
            <button class="emp-options center" name="customer" type="button">Edit User</button>
        </a><br>
        <a href="edit-inventory.php">
            <button class="emp-options center" name="inventory" type="button">Edit Inventory</button>
        </a><br>
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
