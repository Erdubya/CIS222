<?php
//REQUiRED CONSTANTS - DO NOT EDIT
require_once 'class/Item.class.php';
require_once '_Functions.php';
putenv("TZ=US/Eastern");
define("PAGE_TITLE", "ScanIt!");
define("MAIL_TO", 'ewilson@scan-it.com');
//END REQUIRED CONSTANTS

/*
 * DATABASE CONSTANTS
 * Edit these to match the information for the database being used.
 */
define("HOSTNAME", "localhost");
define("USERNAME", "Scan_It");
define("PASSWORD", "Nylon");
define("DATABASE", "ScanIt");

/*
 * LOGO CONSTANTS
 * Edit the 'src' attribute to point to the logo files for the company
 * Ensure that the files match the pre-established sizes of (300x800) and (100x267)
 */
define("MAIN_IMAGE", '<img class="logo" src="images/logo.png" alt="ScanIt!" height="300" width="800"/>');
define("SMALL_IMG", '<img class="logo" src="images/sml_logo.png" alt="ScanIt!" height="100" width="267"/>');

/*
 * HIERARCHY CONSTANTS
 * Defines the permissions hierarchy for employees.
 * Use form "Position" => ##,
 * Numbers from 1-254 are available; Higher number designates higher position.
 * "Customers" and "Administrators" are pre-defined elsewhere.
 */
define("HIERARCHY", serialize(array(
    "Employee" => 1,
    "Manager" => 10,
    "Owner" => 20
)));
