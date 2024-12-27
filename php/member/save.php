<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$member = new Member();
	$i=0;
	$id=$_POST['id'];
	$mmid=$_POST['mmid'];
	$mpid=$_POST['mpid'];
	$fname=strtoupper($_POST['fname']);
	$mname=strtoupper($_POST['mname']);
	$lname=$_POST['lname'];
	$dob=$_POST['dob'];
	$email=$_POST['email'];
	$cnum=$_POST['cnum'];
	$role=$_POST['role'];
	$relationship=$_POST['relationship'];
	if ($member::save($id,$fname,$mname,$lname,$dob,$email,$cnum,$mpid,$role,$relationship,$mmid)) {
		echo 1;
	}

?>