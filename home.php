<?php
ob_start();
require_once '_configuration.php';
session_start();
$link = db_connect();

//Check for login
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

ob_start();
?>
<div>
    <dialog id="override" title="Price Override">
    </dialog>
</div>
<?php
$override = ob_get_clean();

if (!isset($_SESSION['items']))
    $_SESSION['items'] = array();

//Get user info
$res = mysqli_query($link, "SELECT * FROM Users WHERE UserID=" . $_SESSION['user']);

$userRow = mysqli_fetch_array($res);

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset=utf-8"/>
    <title><?= PAGE_TITLE ?> - Main</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/font-hack/2.019/css/hack.min.css">

</head>

<body onclick="selectInput()" class="unselectable">
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
            Hello, <?php echo $userRow['FName'] . " " . $userRow['LName']; ?>
        </div>

        <div class="cust-info center">
            <div id="cust-info">
                <h3 onmouseup="selectInput()">Account</h3>
                <div>
                    <p class="info">Name:</p>
                    <p class="info cont"><?php echo $userRow['FName'] . " " . $userRow['LName']?></p>
                    <p class="info">Email:</p>
                    <p class="info cont"><?php echo $userRow['EmailAddr'] ?></p>
                    <p class="info">Phone:</p>
                    <p class="info cont">
                        <?php
                        //Format the phone number for display
                        $phone = "(" . substr($userRow['PhoneNum'],0,3) . ") " . substr($userRow['PhoneNum'],3,3) . "-"
                            . substr($userRow['PhoneNum'],6,4);
                        echo $phone;
                        ?>
                    </p>
                </div>
                <h3 onmouseup="selectInput()">Billing</h3>
                <div>
                    <p class="info">Address:</p>
                    <p class="info cont"><?php echo $userRow['Addr1']?></p>
                    <?php 
                    if (!is_null($userRow['Addr2'])){
                        echo "<p class=\"info cont\">" . $userRow['Addr2'] . "</p>";
                    } 
                    ?>
                    <p class="info cont"><?php echo $userRow['City'] . ", " . $userRow['State'] . " " . $userRow['ZIP'] ?></p>
                    <p class="info">Credit Card:</p>
                    <?php
                    if (!is_null($userRow['CCNum'])){
                        echo "<p class=\"info cont\">************" . substr($userRow['CCNum'], -4) . "</p>";
                    } 
                    ?>
                </div>
            </div>
        </div>
        
        <div id="cust-options" class="center options">
            <a href="order.php">
                <button class="cust-options center" name="order" type="button">Order Now</button>
            </a><br>
            <a href="remove-item.php">
                <button class="cust-options center" name="remove" type="button">Remove Item</button>
            </a><br>
            <a href="edit-account.php">
                <button class="cust-options center" name="change" type="button">Change Account Information
                </button>
            </a><br>
            <a href="logout.php?logout">
                <button class="cust-options center" name="cancel" type="button">Cancel Order / Logout</button>
            </a><br>
            <button class="cust-options center" id="help-button" name="help" type="button">Request Assistance</button>

            <!-- ui-dialog -->
            <dialog id="dialog" title="Help Is On The Way!">
                <p class="center">An Employee will be with you shortly.</p>
            </dialog>
        </div>
    </aside>

    <div>
        <form id="itemForm" class="item_input hide" method="post" action="PostItemToArray.php">
            <input type="text" id="itemIn" name="item" required autofocus autocomplete="off">
            <input type="submit" value="Submit">
        </form>
    </div>

    <footer>
        <?php
        if (isset($_SESSION['employee'])) {
            echo $options;
            if (isset($_GET['override']))
                echo $override;
        }
        ?>
    </footer>
</div>

<?php
if ($info['Restricted'] = 1) {
ob_start();
?>
<dialog id="bconfirm">
    <div>
        <form method="POST" id="loginform">
            <table class="center fill">
                <tr>
                    <td><input type="text" name="empId" max="5" placeholder="Employee ID" required autofocus></td>
                </tr>
                <tr>
                    <td><input type="password" name="empPswd" placeholder="Password" required></td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="sign-in">Log In</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</dialog>
<?php
ob_end_flush();
}
?>

<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>
<script src="scripts/jquery.floatThead.js"></script>
<script type="text/javascript">
    
    var $items = $('table.items');
    var input = document.getElementById('itemIn');
    var price;
    
    $( document ).ready(function () {
        $items.floatThead({
            scrollContainer: function($items){
                return $items.closest('.wrapper');
            },
            debug: true
        });
    });    

    $( document ).ready(function () {
        $('#itemForm').on('submit', function (e) {
            var data = $('#itemForm').serialize();
            console.log(data);
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: ''
            })
            $.ajax({
                type: 'post',
                url: 'PostItemToArray.php',
                data: data,
                success: function () {
                    refreshTable();
                    $("#itemForm")[0].reset();
                    $items.floatThead('reflow');
                }
            });
        });
    });

    function selectInput() {
        input.focus();
    }

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
            $items.floatThead('reflow');
            price = $(this).find(".invPrice");
            price.attr("readonly");
        });
        
        $('#totals').load('GetTotals.php', function () {
            
        })
    }
    
    var override = $("#override");
    override.on("dialogclose", allowOverride);
    override.on("dialogopen", allowOverride);

    function allowOverride() {
        var body = $("body");
        console.log(price);
        if (!!body.attr("onclick")) {
            body.removeAttr("onclick");
        } else {
            body.attr("onclick", "selectInput()");
        }
    }
    
    $(document).on("click", function() {
        if ($("#override").dialog("isOpen") == true)
            price.removeAttr("readonly");
    });

    $(document).ready(function () {
        override.dialog({
            autoOpen: true,
            dialogClass: "no-close overrideBox",
            closeOnEscape: false,
            draggable: false,
            position: {my: "center bottom", at: "center bottom"},
            modal: false,
            resizable: false,
            width: 300,
            height: 100,
            buttons: [
                {
                    text: "Close",
                    click: function () {
                        $(this).dialog("close");
                        refreshTable();
                        selectInput();
                    }
                }
            ]
        })
    });
</script>

</body>
</html>
<?php
ob_end_flush();
?>
