<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$death = new DeathRecord();
	$id=$_POST['id'];
	$mid=$_POST['mid'];
	$dec=$_POST['dec'];
	$dod=$_POST['dod'];
	$cod=strtoupper($_POST['cod']);
	$uid=base64_decode($_SESSION['CMS_secretary_id']);
	if ($death::save($id,$mid,$dec,$dod,$cod,$uid)) {
		echo 1;
	}

?>