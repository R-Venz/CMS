<?php

	/*ONLINE*/

	// require_once('dbConfig/dbConfig.php');

	/*OFFLINE*/

	$server="127.0.0.1";
	$user="root";
	$pass="";
	$db="thesis_cms";



	defined('server') ? null : define("server", $server);
	defined('user') ? null : define ("user", $user);
	defined('pass') ? null : define("pass", $pass);
	defined('database_name') ? null : define("database_name", $db);

	$this_file = str_replace('\\', '/', __File__) ;
	$doc_root = $_SERVER['DOCUMENT_ROOT'];

	$web_root =  str_replace (array($doc_root, "include/Config.php") , '' , $this_file);
	$server_root = str_replace ('include/Config.php' ,'', $this_file);


	define ('web_root' , $web_root);
	define('server_root' , $server_root);
?>