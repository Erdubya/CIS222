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
