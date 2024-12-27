<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$rel = new Release();
	$i=0;

	$id=$_POST['id'];
	$did=$_POST['did'];
	$purpose=strtoupper($_POST['purpose']);
	$receiver=strtoupper($_POST['receiver']);
	$amount=$_POST['amount'];
	$uid=base64_decode($_SESSION['CMS_treasurer_id']);
	if ($rel::save($id,$did,$purpose,$receiver,$amount,$uid)) {
		echo 1;
	}
?>