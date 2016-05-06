<?php
require_once 'class/Item.class.php';

//Global Constants
define("PAGE_TITLE", "ScanIt!");
define("MAIN_IMAGE", '<img class="logo" src="images/logo.png" alt="ScanIt!" height="300" width="800"/>');
define("SMALL_IMG", '<img class="logo" src="images/sml_logo.png" alt="ScanIt!" height="100" width="267"/>');
define("TOP_HEADING", 'ScanIt!');
define("MAIL_TO", 'ewilson0403@live.sunyjefferson.edu');

putenv("TZ=US/Eastern");

define("HOSTNAME", "localhost");
define("USERNAME", "Scan_It");
define("PASSWORD", "Nylon");
define("DATABASE", "ScanIt");

//Connect to database
function db_connect() {
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD);
    if (!$conn) {
        echo 'Can Not Connect to DB Server!!!';
    } else {
        $db = mysqli_select_db($conn, DATABASE);
        if (!$db) {
            echo 'Can Not Select Database!!!';
        }
    }
    return $conn;
}
