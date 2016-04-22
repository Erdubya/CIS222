<?php

require_once '_configuration.php';
session_start();
$link = db_connect();

if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
}

ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

if (isset($_POST['sign-in'])) {
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $upass = mysqli_real_escape_string($link, $_POST['pswd']);

    $email = trim($email);
    $upass = trim($upass);

    $res = mysqli_query($link, "SELECT UserID, EmailAddr, Password FROM Users WHERE EmailAddr='$email'");
    if ($res) {
        $row = mysqli_fetch_array($res);

        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

        if ($count == 1 && $row['Password'] == md5($upass)) {
            $_SESSION['user'] = $row['UserID'];
            header("Location: home.php");
        } else {
            ?>
            <script>alert('Username / Password Seems Wrong !');</script>
            <?php
        }
    } else {
        ?>
        <script>alert('Username / Password Seems Wrong !');</script>
        <?php
    }
}

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8"/>
    <title><?= PAGE_TITLE ?> Login</title>
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
                <table class="fill center">
                    <tr>
                        <td>
                            <input type="email" name="email" placeholder="Email Address" required autofocus>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="pswd" placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button type="submit" name="sign-in">Log In</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>

    <footer class="center">
        <?php
        if (isset($_SESSION['employee'])) {
            echo $options;
        }
        ?>
        
        <div class="center" id="button-left">
            <a class="center" href="register.php">Sign Up Here!</a>
        </div>
        
        <div class="center">
            <a href="#" id="dialog-link" class="ui-state-default ui-corner-all">?</a>
        </div>

        <!-- ui-dialog -->
        <dialog id="dialog" title="Help Is On The Way!">
            <p class="center">An Employee will be with you shortly.</p>
        </dialog>
    </footer>
</div>

<script src="scripts/jquery.js"></script>
<script src="scripts/jquery-ui.js"></script>
<script src="scripts/FuncScripts.js"></script>


</body>
</html>
