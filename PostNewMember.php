<?php
/**
 * User: erdub
 * Date: 3/9/2016
 * Time: 15:45
 */

require_once '_configuration.php';
$link = db_connect();

if(isset($_POST['signup'])) {
    $fname = mysqli_real_escape_string($link, $_POST['fname']);
    if (empty($fname)) {
        $fname = mysqli_real_escape_string($link, 'NULL');
    } else {
        $fname = "'" . mysqli_real_escape_string($link, $_POST['fname']) .  "'";
    }
    $lname = mysqli_real_escape_string($link, $_POST['lname']);
    $addr1 = mysqli_real_escape_string($link, $_POST['addr1']);
    $addr2 = mysqli_real_escape_string($link, $_POST['addr2']);
    if (empty($addr2)) {
        $addr2 = mysqli_real_escape_string($link, 'NULL');
    } else {
        $addr2 = "'" . mysqli_real_escape_string($link, $_POST['addr2']) . "'";
    }
    $city = mysqli_real_escape_string($link, $_POST['city']);
    $state = mysqli_real_escape_string($link, strtoupper($_POST['state']));
    $zcode = intval($_POST['zip']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $phone = intval(str_replace("-", "", $_POST['phone']));
    $ccnum = intval($_POST['credit']);
    if (empty($ccnum)) {
        $ccnum = mysqli_real_escape_string($link, 'NULL');
    }
    $upass = md5(mysqli_real_escape_string($link, $_POST['pass']));
    
    $qry = "INSERT INTO Users(FName,LName,Addr1,Addr2,City,State,ZIP,EmailAddr,PhoneNum,CCNum,Password) VALUES($fname,'$lname','$addr1',$addr2,'$city','$state',$zcode,'$email',$phone,$ccnum,'$upass')";
    var_dump($qry);

    if($row = mysqli_query($link, $qry)) {
        ?>
        <script>alert('Success');</script>
        <?php
    } else {
        ?>
        <script>alert('Error');</script>
        <?php
    }

    var_dump($row);
    
    header("Location: home.php");
}
?>
