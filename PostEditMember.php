<?php
require_once '_configuration.php';
/*
 * Posts data to database after user edits their own account
 */
session_start();
$link = db_connect();

if (isset($_POST['edit'])) {
    //Get current user password
    $sql = "SELECT Password FROM Users WHERE UserID=" . $_SESSION['user'];
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_array($result);
    
    //Password must be correct
    if (md5($_POST['oldPass']) == $row['Password']) {
        //Do the following for each POST value
        foreach ($_POST as $key => $value) {
            //If the data was changed by the user do the following
            if (!is_null($value) && $value != "") {
                //Decide if input needs normalizing
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
                    case "Password": 
                    case "passconf":
                    case "oldPass":
                        $insert = "'" . md5(mysqli_real_escape_string($link, $value)) . "'";
                        break;
                    default:
                        $insert = "'" . mysqli_real_escape_string($link, $value) . "'";
                }
                
                //Set up SQL string using form names and normalized values
                $sql = "UPDATE Users SET $key=$insert WHERE UserID=" . $_SESSION['user'];

                //Only submit if the field should be submitted
                if ($key != "emailconf" && $key != "passconf" && $key != "oldPass" && $key != "edit") {
                    $result = mysqli_query($link, $sql);
                }
            }
        }
    }

    header("Location: edit-account.php");
}
