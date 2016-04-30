<?php
require_once '_configuration.php';
include_once '_Functions.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted!!!';
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
                            <td><button type="submit" name="sign-in">Log In</button>
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
