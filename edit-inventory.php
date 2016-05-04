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
    <header>
        <?= SMALL_IMG ?>
        <h1 style="display: inline-block; vertical-align: 50%; margin: 0 10%; font-size: 3em">Inventory Manager</h1>
    </header>

    <main class="itemTable">
        <div id="tableHolder" class="wrapper inventory">

        </div>
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
        <div class="center" id="button-right">
            <button type="button" id="barcode">Generate</button>
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
            //Set id for correct validation
            that.setAttribute("id", "updateID");
            //If it validates, perform AJAX call.
            if (updateInventory()) {
                $.ajax({
                    type: 'post',
                    url: 'PostItemToInventory.php',
                    data: $(that).closest('form').serialize(),
                    success: function () {
                        window.alert("Saved!");
                    },
                    complete: function () {
                        refreshTable();
                    }
                });
            } else {
                refreshTable()
            }
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
    
    $(document).ready(function () {
        $("#barcode").on("click", function (e) {
            //Create array of checked generation option checkboxes
            var params = $("input[name=generate]:checked").map(function () {
                return this.value;
            });
            console.log(params);
            e.preventDefault();
            
            if (params.length > 0) {
                //Create and submit dummy for for redirect
                var formStr = '<form action="GenerateBarcodes.php" method="post">';
                for (var i = 0; i < params.length; i++) {
                    formStr += '<input type="hidden" name="' + i + '" value="' + params[i] + '">';
                }
                formStr += '</form>';
                var form = $(formStr);
                console.log(formStr);
                $('body').append(form);
                $(form).submit();
            } else {
                window.alert("Select some items!");
            }
        })
    });

    $(document).ready(function () {
        $(document).on("click", "#selectAll", function () {
            console.log("INSIDE");
            $("input:checkbox[name=generate]").prop('checked', $(this).prop("checked"));
        });
    });
</script>

</body>
</html>
<?php
ob_end_flush();
?>
