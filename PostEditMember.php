<?php
/**
 * User: erdub
 * Date: 3/9/2016
 * Time: 15:45
 */
require_once '_configuration.php';
session_start();
$link = db_connect();

if (isset($_POST['edit'])) {
    $sql = "SELECT * FROM Users WHERE UserID=" . $_SESSION['user'];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    if (md5($_POST['oldPass']) == $row['Password']) {
        var_dump($row);
    }

    foreach ($_POST as $key => $value) {
        var_dump($key);
        var_dump($value);
        if (!is_null($value) && $value != "") {
            switch ($key) {
                case "PhoneNum":
                    $insert = str_replace("-", "", $value);
                    break;
                case "State":
                    $insert = "'" . mysqli_real_escape_string($link, strtoupper($value)) . "'";
                    break;
                case "ZIP":
                    $insert = $value + 0;
                    break;
                default:
                    $insert = "'" . mysqli_real_escape_string($link, $value) . "'";
            }
            
            var_dump($insert);
            
            $sql = "UPDATE Users SET $key=$insert WHERE UserID=" . $_SESSION['user'];
            var_dump($sql);
            
            if ($key != "emailconf" && $key != "passconf" && $key != "oldPass" && $key != "edit") {
                $result = mysqli_query($link, $sql);
                var_dump($result);
            }
        }
    }

//    var_dump($fname);
//    var_dump($lname);
//    var_dump($addr1);
//    var_dump($addr2);
//    var_dump($city);
//    var_dump($state);
//    var_dump($zcode);
//    var_dump($email);
//    var_dump($phone);
//    var_dump($ccnum);
//    var_dump($upass);

//    if($fname == NULL){
//
//    }
//    $qry = "INSERT INTO Users(FName,LName,Addr1,Addr2,City,State,ZIP,EmailAddr,PhoneNum,CCNum,Password) VALUES($fname,'$lname','$addr1',$addr2,'$city','$state',$zcode,'$email',$phone,$ccnum,'$upass')";
//    var_dump($qry);
//
//    if($row = mysqli_query($link, $qry)) {
//        ?>
    <!--        <script>alert('Success');</script>-->
    <!--        --><?php
//    } else {
//        ?>
    <!--        <script>alert('Error');</script>-->
    <!--        --><?php
//    }
//
//    var_dump($row);

//    header("Location: home.php");
}
?>
