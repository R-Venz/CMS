<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$membership = new Membership();
	$i=0;
	$id=$_POST['id'];
	if (isset($_GET['t'])) {
		$addr=$_POST['addr2'];
		if ($membership::saveAddr($id,$addr)) {
			echo 1;
		}
	}else{
		$fname=strtoupper($_POST['fname']);
		$mname=strtoupper($_POST['mname']);
		$lname=$_POST['lname'];
		$dob=$_POST['dob'];
		$email=$_POST['email'];
		$cnum=$_POST['cnum'];
		$addr=$_POST['addr'];
		if ($membership::save($id,$fname,$mname,$lname,$dob,$email,$cnum,$addr)) {
			echo 1;
		}
	}

?>