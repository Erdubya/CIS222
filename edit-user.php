<?php
require_once '_configuration.php';
/*
 * Page where employees can edit user accounts
 */
session_start();
$link = db_connect();
ob_start();

if (!isset($_SESSION['employee'])) {
    //Redirect if employee is not logged in
    header("Location: index.php");
}

//Get logged in employee's information
$sql = "SELECT UserID, UserLevel FROM Users WHERE UserID=" . $_SESSION['employee'];
$result = mysqli_query($link, $sql);
$employee = mysqli_fetch_array($result);

//This array sets the user levels available for use.  255 and 0 must always exist, other levels set in config
$avail_levels = array("Customer" => 0);
$avail_levels = array_merge($avail_levels, unserialize(HIERARCHY));
$avail_levels["Administrator"] = 255;

//Generate employee options dialog
ob_start();
echo '<div>';
include '_EmpOptions.php';
echo '</div>';
$options = ob_get_clean();

//Get user list
$sql = "SELECT UserID, LName, FName FROM Users ORDER BY LName";
$result = mysqli_query($link, $sql);

if (isset($_POST['select'])) {
    $_SESSION['edit'] = $_POST['users'];
    //Get user information
    $sql = "SELECT * FROM Users WHERE UserID=" . $_POST['users'];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    
    //If the row is found, set the form placeholders to the current values
    $userID = $row['UserID'];
    if (!is_null($row['FName'])) {
        $fname = $row['FName'];
    } else {
        $fname = "First Name";
    }
    $lname = $row['LName'];
    $addr1 = $row['Addr1'];
    if (!is_null($row['Addr2'])) {
        $addr2 = $row['Addr2'];
    } else {
        $addr2 = "Address 2";
    }
    $city = $row['City'];
    $state = $row['State'];
    $zcode = $row['ZIP'];
    $email = $row['EmailAddr'];
    $phone = substr($row['PhoneNum'],0,3) . "-" . substr($row['PhoneNum'],3,3) . "-" . substr($row['PhoneNum'],6,4);
    if (!is_null($row['CCNum'])) {
        $ccnum = "************" . substr($row['CCNum'], -4);
    } else {
        $ccnum = "Credit Card";
    }
    $ulevel = $row['UserLevel'];
}

?>
    <!DOCTYPE html>
    <html lang="en-us">
    <head>
        <meta charset="utf-8">
        <title><?= PAGE_TITLE ?> - Edit User</title>
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>

    <body>
    <div id="all" class="center">
        <header class="center">
            <a href="index.php" id="headerimg"><?= MAIN_IMAGE ?></a>
            <h2>Edit User Account</h2>
        </header>
        
        <?php
        
        //Generate selection dialog
        if (!isset($_POST['select'])) {
            echo '<dialog id="input-dialog" title="Select User" class="center">';
            echo '<form method="post">';
            echo '<select name="users" size="10" id="userSelect">';
            while($row = mysqli_fetch_array($result)) {
                echo "<option value='" . $row['UserID'] . "'>" . $row['LName'] . ", " . $row['FName'] . "</option>";
            }
            echo '</select>';
            echo '<button type="submit" name="select" value="true">Select</button>';
            echo '</form>';
            echo '</dialog>';
        }
        
        ob_start();
        ?>
        <main>
            <form method="post" class="tabbed" id="reg-sub" onsubmit="return updateAccount()" action="PostEditUser.php">
                <div id="tabs" class="center">
                    <ul style="margin-top: auto; margin-bottom: auto;">
                        <li class="clearImage"><a href="#tabs-1">Account</a></li>
                        <li class="clearImage"><a href="#tabs-2">Address</a></li>
                        <li class="clearImage"><a href="#tabs-3">Payment</a></li>
                        <li class="clearImage"><a href="#tabs-4">Permissions</a></li>
                    </ul>
                    <div id="tabs-1" class="tabbs">
                        <div id="reg-form-1" class="reg-form">
                            <table class="fill" align="center" border="0">
                                <tr>
                                    <td><input type="email" name="EmailAddr" id="email" placeholder="<?= htmlspecialchars($email) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="email" name="emailconf" id="emailconf" placeholder="<?= htmlspecialchars($email) ?>" value=""/></td>
                                </tr>
                            </table>
                            <table class="fill" 3 align="center" border="0" id="passwords">
                                <tr>
                                    <td><input type="password" name="Password" id="pass" placeholder="New Password"/></td>
                                </tr>
                                <tr>
                                    <td><input type="password" name="passconf" id="passconf" placeholder="Confirm Password"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="tabs-2" class="tabbs">
                        <div id="reg-form-2" class="reg-form">
                            <table class="fill" align="center" border="0">
                                <tr>
                                    <td><input type="tel" name="PhoneNum" id="phone" placeholder="<?= htmlspecialchars($phone) ?>" maxlength="12" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="Addr1" id="addr1" placeholder="<?= htmlspecialchars($addr1) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="Addr2" id="addr2" placeholder="<?= htmlspecialchars($addr2) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="City" id="city" placeholder="<?= htmlspecialchars($city) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="State" id="state" placeholder="<?= htmlspecialchars($state) ?>" value="" maxlength="2"/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="ZIP" id="zip" placeholder="<?= htmlspecialchars($zcode) ?>" value="" maxlength="5"/></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="tabs-3" class="tabbs">
                        <div id="reg-form-3" class="reg-form">
                            <table class="fill" align="center" border="0">
                                <tr>
                                    <td><input type="text" name="FName" id="fname" placeholder="<?= htmlspecialchars($fname) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="LName" id="lname" placeholder="<?= htmlspecialchars($lname) ?>" value=""/></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="CCNum" id="credit" placeholder="<?= htmlspecialchars($ccnum) ?>" maxlength="16" value="" disabled  /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="tabs-4" class="tabbs">
                        <div id="reg-form-4" class="reg-form">
                            <table class="fill" align="center" border="0">
                                <tr>
                                    <td><select name="UserLevel" id="ulevel"">
                                            <?php
                                            foreach ($avail_levels as $key => $value){
                                                echo "<option value='$value' ";
                                                if ($value == $ulevel) {
                                                    echo "selected ";
                                                }
                                                if ($employee['UserLevel'] <= $value || $employee['UserLevel'] <= $ulevel)  {
                                                    if ($employee['UserLevel'] != 255 || $userID == 00001)
                                                        echo "disabled";
                                                }
                                                echo ">$key</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="editSub">
                    <input type="password" name="oldPass" id="oldPass" placeholder="Employee Password">
                    <input type="hidden" name="userID" id="userID" value="<? echo $userID ?>">
                    <button type="submit" name="edit">Confirm</button>
                </div>
            </form>
        </main>
        <?php
        if (isset($_POST['select'])) {
            //If selected, show table
            ob_end_flush();
        } else {
            ob_end_clean();
        }
        ?>

        <footer class="center">
            <?php
            //Display employee options
            if (isset($_SESSION['employee'])) {
                echo $options;
            }
            ?>

            <div class="center" id="button-left">
                <a class="center" href="home.php">Back</a>
            </div>

            <!-- Dialog link -->
            <div class="center">
                <a href="#" id="dialog-link" class="ui-state-default ui-corner-all">?</a>
            </div>

            <!-- ui-dialog -->
            <dialog id="dialog" title="Help Is On The Way!">
                <p>An Employee will be with you shortly.</p>
            </dialog>
        </footer>
    </div>

    <script src="scripts/jquery.js"></script>
    <script src="scripts/jquery-ui.js"></script>
    <script src="scripts/validation.js"></script>
    <script src="scripts/FuncScripts.js"></script>
    <script>
        $("#tabs").tabs();

        var data = [
            "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC", "DE", "FL",
            "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA",
            "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",
            "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "RI",
            "SC", "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV",
            "WY"
        ];
        
        $(document).on("click", function () {
            if ($("input[name=userID]").val() == 1) {
                $("input").prop("disabled", true);
            }
        });

        $("#state").autocomplete({
            source: function (req, responseFn) {
                var re = $.ui.autocomplete.escapeRegex(req.term);
                var matcher = new RegExp("^" + re, "i");
                var a = $.grep(data, function (item, index) {
                    return matcher.test(item);
                });
                responseFn(a);
            }
        });

        $("#input-dialog").dialog({
            autoOpen: true,
            closeOnEscape: false,
            dialogClass: "no-close",
            draggable: false,
            resizable: false,
            modal: true,
            width: 400,
            height: 400
        });
    </script>
    </body>
    </html>

<?php
ob_end_flush();
