<?php
include '_Functions.php';
include 'CustBank/bank.php';
require_once '_configuration.php';

//if(isset($_POST['test'])) {
//    $test = UPCA_Check($_POST['test']);
//    var_dump($test);
//}
//
//$link = db_connect();

//htmlmail('erikrw96@gmail.com','Test mail','This is a test.  Only a test');
$bank = new bank();

$bank->CheckCard("5575965987658265", "Joe Schmoe");



//echo base64_encode("12");
//echo base64_decode("MTI=");
//echo urldecode("MTI%3D");

//?>
<!---->
<!--<html>-->
<!--<body>-->
<!--<form method="post">-->
<!--    <input type="text" name="test">-->
<!--</form>-->
<!--</body>-->
<!--</html>-->
