<?php
ob_start();
require_once '_configuration.php';
session_start();
$link = db_connect();

//Check for login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

//if (!is_null($_SESSION['last']['item'])) {
//    $_SESSION['last']['item'] = null;
//    $_SESSION['last']['remove'] = null;
//}

ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

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
    <title><?= PAGE_TITLE ?> - Remove Item</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>

</head>

<body>
<div id="all" class="center">
    <main class="table">
        <div id="tableHolder" class="wrapper">
    
        </div>

        <div class="totals" id="totals">
            
        </div>
    </main>

    <aside class="sidebar"> <!-- customer info/options -->
        <div class="center">
            <?= SMALL_IMG ?><br>
        </div>

        <div id="cust-options" class="center options">
            <a href="home.php">
                <button class="cust-options center" name="cancel" type="button">Go Back</button>
            </a><br>
            <a href="#">
                <button class="cust-options center" id="help-button" name="help" type="button">Request Assistance
                </button>
            </a>
            <!-- ui-dialog -->
            <dialog id="dialog" title="Help Is On The Way!">
                <p class="center">An Employee will be with you shortly.</p>
            </dialog>
        </div>
    </aside>


    <footer>
        <?php
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
    var $value;

    
    $(function () {
        $("#cust-info").accordion({
            heightStyle: "fill"
        });
    });
    
    $( document ).ready(function () {
        $(document).on('submit', '.removeItem', function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                type: 'post',
                url: 'RemoveItemFromArray.php',
                data: $('form').serialize(),
                success: function () {
                    refreshTable();
                }
            });
        });
    });

    $( document ).ready(function () {
        $('#remove').on('submit', function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                type: 'post',
                url: 'UndoRemove.php',
                data: $('form').serialize(),
                success: function () {
                    refreshTable();
                }
            });
//            alert("Ajax not running")
        });
    });
    
    $(document).ready(function () {
        refreshTable();
    });

    function refreshTable() {
        $('#tableHolder').load('GetTableFromArray.php?remove', function () {
            var element = document.getElementById("tableHolder");
            element.scrollTop = element.scrollHeight;
        });

        $('#totals').load('GetTotals.php', function () {

        })
    }
</script>

</body>
</html>
<?php
ob_end_flush();
?>
