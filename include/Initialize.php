<?php
    ob_start();
	//define the core paths
	//Define them as absolute peths to make sure that require_once works as expected

	//DIRECTORY_SEPARATOR is a PHP Pre-defined constants:
	//(\ for windows, / for Unix)

	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	
	/*ONLINE*/

	// defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS);

	/*OFFLINE*/

	defined('SITE_ROOT') ? null : define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'01_THESIS\ZDSPGC\2024\CMS');

	defined('LIB_PATH') ? null : define ('LIB_PATH',SITE_ROOT.DS.'include');



	// load the database configuration first.
	require_once(LIB_PATH.DS."Config.php");
	require_once(LIB_PATH.DS."F&V/Variables.php");
	require_once(LIB_PATH.DS."F&V/Function.php");
	require_once(LIB_PATH.DS."dbConfig/Database.php");
  	require_once(LIB_PATH.DS."classes/php/printpdf/PDF_LineGraph.php"); // para ni sa pdf
	require_once(LIB_PATH.DS."classes/PHPSpreadsheet/autoload.php"); // para sa excel

	// actual classes
	require_once(LIB_PATH.DS."classes/php/Login.php");
	require_once(LIB_PATH.DS."classes/php/Dashboard.php");
	require_once(LIB_PATH.DS."classes/php/User.php");
	require_once(LIB_PATH.DS."classes/php/Settings.php");
	require_once(LIB_PATH.DS."classes/php/Membership.php");
	require_once(LIB_PATH.DS."classes/php/Member.php");
	require_once(LIB_PATH.DS."classes/php/DeathRecord.php");
	require_once(LIB_PATH.DS."classes/php/Bill.php");
	require_once(LIB_PATH.DS."classes/php/Release.php");
	require_once(LIB_PATH.DS."classes/php/Deposit.php");
?>


