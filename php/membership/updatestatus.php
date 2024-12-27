<?php  
	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);

	//it creates a new objects of member
	$membership = new Membership();
	$i=0;

	$id=$Data->id;
	$st=$Data->st;
	if ($membership::updatestatus($id,$st)) {
		echo 1;
	}
?>