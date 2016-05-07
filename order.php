<?php
require_once '_configuration.php';
/*
 * Confirm order page - gives users option to review order
 */
session_start();
$link = db_connect();

//Check for login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

//Generate employee options dialog
ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

if (!isset($_SESSION['items']) || empty($_SESSION['items'])){
    //If no items are selected, don't let continue to confirmation
    header("Location: home.php");
}

//Get user info
$res = mysqli_query($link, "SELECT * FROM Users WHERE UserID=" . $_SESSION['user']);
$userRow = mysqli_fetch_array($res);

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset=utf-8"/>
    <title><?= PAGE_TITLE ?> - Confirm</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>

<body>
<div id="all" class="center">
    <main class="table">
        <!-- Main table -->
        <div id="tableHolder" class="wrapper">
        </div>

        <!-- Total box -->
        <div class="totals" id="totals">
        </div>
    </main>

    <aside class="sidebar"> <!-- customer info/options -->
        <div class="center">
            <?= SMALL_IMG ?>
        </div>

        <!-- Buttons -->
        <div id="cust-options" class="center options">
            <div id="option-stack" class="center">
                <a href="PostOrder.php">
                    <button class="cust-options center" name="order" type="button">Confirm Order</button>
                </a><br>
                <a href="home.php">
                    <button class="cust-options center" name="cancel" type="button">Go Back</button>
                </a><br>
                <a href="#">
                    <button class="cust-options center" id="help-button" name="help" type="button">Request Assistance
                    </button>
                </a>
            </div>
            
            <!-- ui-dialog -->
            <dialog id="dialog" title="Help Is On The Way!">
                <p class="center">An Employee will be with you shortly.</p>
            </dialog>
        </div>
    </aside>
    
    <footer>
        <?php
        //Display employee options
        if (isset($_SESSION['employee'])) {
            echo $options;
        }
        ?>
    </footer>
</div>


<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>
<script type="text/javascript">

    var $items = $('table.items');

    //Initial table refresh
    $(document).ready(function () {
        refreshTable();
    });

    //Reload table and total box
    function refreshTable() {
        $('#tableHolder').load('GetTableFromArray.php', function () {
            var element = document.getElementById("tableHolder");
            element.scrollTop = element.scrollHeight;
        });

        $('#totals').load('GetTotals.php', function () {

        })
    }
</script>

</body>
</html>
