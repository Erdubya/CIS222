<?php
require_once '_configuration.php';
session_start();
$link = db_connect();

if (!$link) {
    echo 'BOO!!! Not conncted again!!!';
}

exit;
