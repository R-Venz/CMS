<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$settings = new Settings();
	$i=0;

	$id=$_POST['id'];
	$contribution=$_POST['contribution'];

	if ($settings::save($id,$contribution)) {
		echo 1;
	}
?>