<?php
/**
 * User: erdub
 * Date: 3/6/2016
 * Time: 20:33
 */

/**
 * Description:
 *   Calculates the check value of the input barcode. Returns the result of this check.
 * @param $number int The code to check
 * @return bool If the code is correct
 */
function UPCA_Check($number)
{
    if (is_numeric($number)) {
        $length = strlen($number);
        $curPos = 0;
        $total = 0;

        if ($length == 12) {
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

            $checkInt = 10 - ($total % 10);
            $check = $checkInt == substr($number, -1, 1);
        } else {
            echo "second";
            $check = false;
        }
    } else {
        echo "first";
        $check = false;
    }

    var_dump($check);

    return $check;
}

/**
 * @param $to string address of the recipient
 * @param $subject  string line of the email
 * @param $message  string body content
 * @param null $headers Defaults all headers
 * @return bool 
 */
function htmlmail($to, $subject, $message, $headers = NULL)
{
    $headers .= "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html;charset=utf-8" . "\r\n";

// prepended HTML
    $newmessage = '
        <body style="margin:0">
        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td bgcolor="#ffffff" valign="top">
        <table width="750" border="0" cellpadding="0" cellspacing="0" align="center">
        <tr>
        <td bgcolor="#ffffff" width="750">
    ';

// HTML message that was passed to this function
    $newmessage .= $message;

// appended HTML
    $newmessage .= '</td></tr></table></td></tr></table></body>';
    return mail($to, $subject, $newmessage, $headers);
}
