<?php
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
    <title><?= PAGE_TITLE ?> - Remove Item</title>
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
<!--        <form class="removal center" method="post" id="remove" action="UndoRemove.php">-->
<!--            <table class="removal fill center">-->
<!--                <tr>-->
<!--                    <td colspan="2"><input type="text" name="item" value="--><?php
//                        if (!is_null($_SESSION['last']['item'])) {
//                            echo $_SESSION['last']['item']->GetItem();
//                        }
//                        ?><!--" disabled></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td><label for="value">Value:</label></td>-->
<!--                    <td><input type="text" id="value" name="value" value="$--><?php
//                        if (!is_null($_SESSION['last']['item'])) {
//                            echo $_SESSION['last']['item']->GetPrice();
//                        }
//                        ?><!--" disabled></td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td colspan="2">-->
<!--                        <input type="submit" value="Undo">-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
<!--        </form>-->

        <div id="cust-options" class="center options">
            <div id="option-stack" class="center">
<!--                <button class="cust-options center" name="order" type="submit" form="remove">Confirm Remove</button>-->
<!--                <br>-->
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
    var $value;

    
    $(function () {
        $("#cust-info").accordion({
            heightStyle: "fill"
        });
    });
    
    $( document ).ready(function () {
        $('.removeItem').on('submit', function (e) {
            e.preventDefault();
            console.log($(this));
            $.ajax({
                type: 'post',
                url: 'RemoveItemFromArray.php',
                data: $('form').serialize(),
                success: function () {
                    refreshTable();
                    $items.floatThead('reflow');
                }
            });
            alert("Ajax not running")
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
