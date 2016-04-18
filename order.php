<?php
require_once '_configuration.php';
session_start();
$link = db_connect();

//Check for login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

if (isset($_SESSION['employee'])) {
    include '_EmpOptions.php';
}

if (!isset($_SESSION['items'])) {
    ?>
    <script>alert("No order!")</script>
    <?php
    header("Location: index.php");
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
<?php
if (isset($_SESSION['employee'])) {
    include '_EmpOptions.php';
}
?>
<div id="all" class="center">
    <main class="table">
        <div id="tableHolder" class="wrapper">

        </div>

        <div class="totals" id="totals">

        </div>
    </main>

    <aside class="sidebar"> <!-- customer info/options -->
        <div class="center">
            <?= SMALL_IMG ?>
        </div>
        <div id="cust-options" class="center options">
            <div id="option-stack" class="center">
                <a href="PostOrder.php">
                    <button class="cust-options center" name="order" type="button">Confirm Order</button>
                </a></br>
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

</div>

<footer>

</footer>


<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>
<script type="text/javascript">

    var $items = $('table.items');

    $(function () {
        $("#cust-info").accordion({
            heightStyle: "fill"
        });
    });

    $(document).ready(function () {
        refreshTable();
    });

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
