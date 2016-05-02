<?php

/**
 * This class represents an external credit card processing agency. The card number and name fo the user are passed in, 
 *  and the validity of the card is returned
 */
class Bank
{
    /**
     * Description:
     *   Provides the validity of a credit card account for an external service.
     *   Uses data stored in a file to determine if an account can be used.
     * @param $number int The card number to check
     * @param $name String The name associated with the account
     * @return boolean Whether or not the number is valid and matches stored information
     */
    function CheckCard($number, $name)
    {
        $found = false;
//        var_dump($number);
        if (Bank::MOD10($number)) {
            $myfile = fopen('CustBank/clientcards.txt', 'r') or die("Unable to open file!");
            
            while (!feof($myfile) && !$found) {
                $test = fgetcsv($myfile);
//                var_dump($test);
                
                if ($test[0] == $number) {
                    if ($test[1] == $name) {
                        if ($test[2]) {
                            $found = true;
                        }
                    }
                }
            }
            
            if (!$found) {
                echo "Not found!";
            }
            
            fclose($myfile);
        }
        
        return $found;
    }

    /**
     * Description:
     *   Test for card number validity, using variation of the MOD 10 algorithm.
     * Preconditions:
     *   None.
     * Postconditions:
     *   Will return true if card number is valid.
     *   Otherwise, returns false.
     * @param $number int The card number to test.
     * @return bool The validity of the number.
     */
    public function MOD10($number)
    {
        if (is_numeric($number)) {
            $length = strlen($number);
            $curPos = $length - 2;
            $total = 0;
//            var_dump($length);
//            var_dump($curPos);

            if ($length != 0) {
                if ($length % 2 == 0) {
                    while ($curPos >= 2) {
                        $digit2 = 2 * substr($number, $curPos, 1);
                        $digit1 = substr($number, $curPos - 1, 1);

//                        var_dump($digit2);
//                        var_dump($digit1);

                        if ($digit2 >= 10) {
                            $digit2 = $digit2 - 9;
                        }

                        $total = $digit1 + $digit2 + $total;

                        $curPos = $curPos - 2;
                    }

                    $digit2 = 2 * substr($number, $curPos, 1);
                    if ($digit2 >= 10) {
                        $digit2 = $digit2 - 9;
                    }
                    $total = $total + $digit2;
//                    var_dump($total);
                } else {
                    while ($curPos >= 1) {
                        $digit2 = 2 * substr($number, $curPos, 1);
                        $digit1 = substr($number, $curPos - 1, 1);

//                        var_dump($digit2);
//                        var_dump($digit1);

                        if ($digit2 >= 10) {
                            $digit2 = $digit2 - 9;
                        }

                        $total = $digit1 + $digit2 + $total;

                        $curPos = $curPos - 2;
                    }
                }

                $checkInt = substr($total * 9, -1, 1);
                $check = $checkInt == substr($number, -1, 1);
            } else {
                $check = false;
            }
        } else {
            $check = false;
        }

        return $check;
    }
}
