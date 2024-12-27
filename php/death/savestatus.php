<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$death = new DeathRecord();
	$id=$_POST['id'];
	$status=$_POST['status'];
	if ($death::updatestatus($id,$status)) {
		echo 1;
	}

?>