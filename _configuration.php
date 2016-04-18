<?php

require_once 'class/Item.class.php';

define("PAGE_TITLE", "ScanIt!");
define("MAIN_IMAGE", '<img class="logo" src="images/logo.png" alt="ScanIt!" height="300px" width="800px"/>');
define("SMALL_IMG", '<img class="logo" src="images/sml_logo.png" alt="ScanIt!" height="100px" width="267px"/>');
define("TOP_HEADING", 'ScanIt!');
define("MAIL_TO", 'ewilson0403@live.sunyjefferson.edu');

putenv("TZ=US/Eastern");


function db_connect()
{
    $conn = mysqli_connect('localhost', 'Scan_It', 'Nylon');
    if (!$conn) {
        echo 'Can Not Connect to DB Server!!!';
    } else {
        $db = mysqli_select_db($conn, 'ScanIt');
        if (!$db) {
            echo 'Can Not Select Database!!!';
        }
        return $conn;
    }
}
