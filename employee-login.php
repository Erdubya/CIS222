<?php
require_once '_configuration.php';
/*
 * Employee login page
 */
session_start();
$link = db_connect();

//Generate employee options dialog
ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

if (isset($_POST['sign-in'])) {
    //On sign-in...
    $empId = mysqli_real_escape_string($link, $_POST['empId']);
    $empPswd = trim(mysqli_real_escape_string($link, $_POST['empPswd']));

    //Get required information
    $res = mysqli_query($link, "SELECT UserID, Password, UserLevel FROM Users WHERE UserID='$empId'");
    if ($res) {
        $row = mysqli_fetch_array($res);

        $count = mysqli_num_rows($res); // if uname/pass correct it must be 1 row

        //Confirms user is an employee and that password is correct
        if ($count == 1 && $row['Password'] == md5($empPswd) && $row['UserLevel'] > 0) {
            $_SESSION['employee'] = $row['UserID'];
            header("Location: " . $_GET["redirect"]);
        } else {
            ?>
            <script>alert('ID / Password Seems Wrong !');</script>
            <?php
        }
    } else {
        ?>
        <script>alert('ID / Password Seems Wrong !');</script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8"/>
    <title><?= PAGE_TITLE ?> Employee Login</title>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
</head>

<body>
<div id="all" class="center">
    <header id="lower">
        <?= MAIN_IMAGE ?>
    </header>

    <main>
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
                        <td><button type="submit button" name="sign-in">Log In</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

    <footer class="center">
        <?php
        //Display employee options
        if (isset($_SESSION['employee'])) {
            echo $options;
        }
        ?>

        <!-- Back Button -->
        <div class="center" id="button-left">
            <a class="center" href="<?php
            $redirect = $_GET["redirect"];
            if ($redirect == "employee-login.php") {
                $redirect = "index.php";
            }
            echo $redirect;
            ?>">Return</a>
        </div>

        <!-- Dialog link -->
        <div class="center">
            <a href="#" id="dialog-link" class="ui-state-default ui-corner-all">?</a>
        </div>

        <!-- ui-dialog -->
        <dialog id="dialog" title="Help Is On The Way!">
            <p>An administrator will be with you shortly.</p>
        </dialog>
    </footer>
</div>

<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>

</body>
</html>
