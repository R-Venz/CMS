<?php  
	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);

	//it creates a new objects of member
	$rel = new Release();

	$id='';
	$did=$Data->id;
	$purpose="RELEASED";
	$receiver=$Data->receiver;
	$amount=$Data->amt;
	$uid=base64_decode($_SESSION['CMS_treasurer_id']);
	if ($rel::save($id,$did,$purpose,$receiver,$amount,$uid,'Released')) {
		echo 1;
	}
?>