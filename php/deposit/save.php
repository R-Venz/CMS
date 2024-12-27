<?php  
	require_once("../../include/Initialize.php");

	$depo = new Deposit();
	$uid = base64_decode($_SESSION['CMS_treasurer_id']);
	$id = $_POST['id'];
	$amt = $_POST['amt'];
	if ($depo::save($id,$amt)) {
		echo 1;
	}

?>