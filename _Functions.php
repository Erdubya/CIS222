<?php
/*
 * A collection of functions used in multiple scripts 
 */

/**
 * Description:
 *   Connects to the selected database.
 * @return mysqli The mysqli object used in query statements.
 */
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

/**
 * Description:
 *   Checks the validity of a UPC-A code. Returns the result of this check.
 * @param $number int The code to check
 * @return bool If the code is correct
 */
function UPCA_Check($number)
{
    if (is_numeric($number)) {
        $length = strlen($number);

        if ($length == 12) {
            $check = CalcUPC($number) == substr($number, -1, 1);
        } else {
            $check = false;
        }
    } else {
        $check = false;
    }

    return $check;
}

/**
 * Description:
 *   Calculates the UPC-A check digit for an 11-or-12 digit number representing the value to encode
 * @param $number int The number to calculate
 * @return int The calculated check digit
 */
function CalcUPC($number) {
    $curPos = 0;
    $total = 0;

    while ($curPos <= 10) {
        $digit = substr($number, $curPos, 1);

        $total = $digit + $total;

        $curPos = $curPos + 2;
    }

    $total = $total * 3;
    $curPos = 1;

    while ($curPos <= 9) {
        $digit = substr($number, $curPos, 1);

        $total = $digit + $total;

        $curPos = $curPos + 2;
    }

    if ($total % 10 != 0) {
        $checkInt = 10 - ($total % 10);
    } else {
        $checkInt = 0;
    }
    
    return $checkInt;
}
