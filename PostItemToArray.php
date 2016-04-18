<?php
require_once '_configuration.php';
include_once '_Functions.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
}

if(isset($_POST['sign-in'])) {
    $empId = mysqli_real_escape_string($link, $_POST['empId']);
    $empPswd = mysqli_real_escape_string($link, $_POST['empPswd']);

    $empPswd = trim($empPswd);

    $res = mysqli_query($link, "SELECT UserID, Password, UserLevel FROM Users WHERE UserID='$empId'");
    if($res) {
        $row = mysqli_fetch_array($res);

        $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row

        if($count == 1 && $row['Password']==md5($empPswd)) {
            $_SESSION['employee'] = $row['UserID'];
            header("Location: ".$_GET["redirect"]);
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

if (UPCA_Check($_POST['item'])) {
    $strip = substr($_POST['item'], 0, -1);
    $temp = new Item();

    $qry = mysqli_query($link, "SELECT Name, Price, Restricted FROM Item WHERE ItemID=" . $strip);
    $info = mysqli_fetch_array($qry);
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
                            <td><button type="submit button" name="sign-in">Log In</button>
                        </tr>
                    </table>
                </form>
            </div>
        </dialog>
        <?php
        ob_end_flush();
    }
    if (!is_null($info)) {
        $temp->SetItem($info['Name']);
        $temp->SetItemNum($_POST['item']);
        $temp->SetPrice($info['Price']);

        $_SESSION['items'][count($_SESSION['items'])] = $temp;
    }
}

mysqli_close($link);

//header("Location: home.php");
exit();

?>
