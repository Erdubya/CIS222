<?php
ob_start();
require_once '_configuration.php';
session_start();
$link = db_connect();

//Check for login
if (!isset($_SESSION['employee'])) {
    header("Location: index.php");
}

ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

if (!isset($_SESSION['items']))
    $_SESSION['items'] = array();

//Get user info


?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset=utf-8"/>
    <title><?= PAGE_TITLE ?> - Inventory</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/font-hack/2.019/css/hack.min.css">

</head>

<body>
<div id="all" class="center">

    <main class="itemTable">
        <div id="tableHolder" class="wrapper">

        </div>

<!--        <div class="totals" id="totals">-->

<!--        </div>-->
    </main>

    <footer>
        <?php
        if (isset($_SESSION['employee'])) {
            echo $options;
        }
        ?>
        <div class="center" id="button-left">
            <a class="center" href="home.php">Back</a>
        </div>
        
    </footer>
</div>


<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>
<script src="scripts/validation.js"></script>
<script type="text/javascript">

    var $items = $('table.items');

    $( document ).ready(function () {
        $(document).on('submit', 'form.editItem', function (e) {
            e.preventDefault();
            var that = this;
            $.ajax({
                type: 'post',
                url: 'PostItemToInventory.php',
                data: $(that).closest('form').serialize(),
                success: function () {
                    alert("It Worked!");
                    refreshTable();
                }
            });
        });
    });

    $(document).ready(function () {
        refreshTable();
    });

    function refreshTable() {
        $('#tableHolder').load('GetInventoryList.php', function () {
            var element = document.getElementById("tableHolder");
            element.scrollTop = element.scrollHeight;
        });
    }
</script>

</body>
</html>
<?php
ob_end_flush();
?>
