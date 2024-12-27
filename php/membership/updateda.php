<?php  
	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);

	//it creates a new objects of member
	$membership = new Membership();
	$id=base64_decode($Data->id);
	$st=$Data->st;
	if ($membership::updateda($id,$st)) {
		echo 1;
	}

?>