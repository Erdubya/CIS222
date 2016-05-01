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

global $fname, $lname, $addr1, $addr2, $city, $state, $zcode, $email, $phone, $ccnum, $upass;
function resetFields()
{
    $fname = null;
    $lname = null;
    $addr1 = null;
    $addr2 = null;
    $city = null;
    $state = null;
    $zcode = null;
    $email = null;
    $phone = null;
    $ccnum = null;
    $upass = null;
}

resetFields();

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <title><?= PAGE_TITLE ?> Register</title>
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
</head>

<body>
<div id="all" class="center">
    <header id="lower">
        <a href="index.php" id="headerimg"><?= MAIN_IMAGE ?></a>
    </header>

    <main>
        <div id="tabs" class="center">
            <ul style="margin-top: auto; margin-bottom: auto;">
                <li class="clearImage"><a href="#tabs-1">Account</a></li>
                <li class="clearImage"><a href="#tabs-2">Address</a></li>
                <li class="clearImage"><a href="#tabs-3">Payment</a></li>
                <li class="clearImage"><a href="#tabs-4">Sign Up</a></li>
            </ul>
            <form method="post" class="tabbed" id="reg-sub" onsubmit="return registerAccount()" action="PostNewMember.php">
                <div id="tabs-1" class="tabbs">
                    <div id="reg-form-1" class="reg-form">
                        <table class="fill" align="center" border="0">
                            <tr>
                                <td><input type="email" name="email" id="email" placeholder="Your Email" value="<?= htmlspecialchars($email) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="email" name="emailconf" id="emailconf" placeholder="Confirm Email" value="<?= htmlspecialchars($email) ?>"/></td>
                            </tr>
                        </table>
                        <table class="fill" align="center" border="0" id="passwords">
                            <tr>
                                <td><input type="password" name="pass" id="pass" placeholder="Your Password"/></td>
                            </tr>
                            <tr>
                                <td><input type="password" name="passconf" id="passconf"
                                           placeholder="Confirm Password"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="tabs-2" class="tabbs">
                    <div id="reg-form-2" class="reg-form">
                        <table class="fill" align="center" border="0">
                            <tr>
                                <td><input type="tel" name="phone" id="phone" placeholder="555-555-5555" maxlength="12"
                                           value="<?= htmlspecialchars($phone) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="addr1" id="addr1" placeholder="Address 1"
                                           value="<?= htmlspecialchars($addr1) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="addr2" id="addr2" placeholder="Address 2"
                                           value="<?= htmlspecialchars($addr2) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="city" id="city" placeholder="City"
                                           value="<?= htmlspecialchars($city) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="state" id="state" placeholder="State"
                                           value="<?= htmlspecialchars($state) ?>" maxlength="2"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="zip" id="zip" placeholder="ZIP Code"
                                           value="<?= htmlspecialchars($zcode) ?>" maxlength="5"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="tabs-3" class="tabbs">
                    <div id="reg-form-3" class="reg-form">
                        <table class="fill" align="center" border="0">
                            <tr>
                                <td><input type="text" name="fname" id="fname" placeholder="First Name"
                                           value="<?= htmlspecialchars($fname) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="lname" id="lname" placeholder="Last Name"
                                           value="<?= htmlspecialchars($lname) ?>"/></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="credit" id="credit" placeholder="Credit Card"
                                           maxlength="16"/></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="tabs-4" class="tabbs">
                    <div id="reg-form-4" class="reg-form">
                        <table class="fill" align="center" border="0">
                            <tr>
                                <td><p>tab 1 complete</p></td>
                            </tr>
                            <tr>
                                <td><p>tab 2 complete</p></td>
                            </tr>
                            <tr>
                                <td><p>tab 3 complete</p></td>
                            </tr>
                            <tr>
                                <td>
                                    <button type="submit" class="center" name="signup">Confirm</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
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
            <a class="center" href="index.php">Log In!</a>
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
</script>
</body>
</html>
