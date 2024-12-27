<?php  
	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);

	//it creates a new objects of member
	$membership = new Membership();
	$id=base64_decode($Data->id);
	$uid=base64_decode($_SESSION['CMS_treasurer_id']);
	if ($membership::save_da($id,$uid)) {
		echo 1;
	}

?>