<?php  
	require_once("../../include/Initialize.php");
	$ms = new Membership();
	//it creates a new objects of member
	$login = new UserLog();
	$fname = trim($_POST['fname']);
	$lname  = trim($_POST['lname']);
	$dob = trim($_POST['dob']);
	$email  = trim($_POST['email']);
	$pass1 = $_POST['pass1'];
	$pass2  = $_POST['pass2'];
	if ($pass1 != $pass2) {
		echo "Password not matched";return;
	}
	// check if the data is good
	$rs = $ms->single_view_member_condition(" AND fname='{$fname}' AND lname='{$lname}' AND dob='{$dob}' AND email='{$email}' AND role='Head'");
	if (!isset($rs->mpid)) {
		echo "Data not found! Please try again.";return;
	}
	if ($ms->updateaccount($rs->mpid,$email,$pass1)) {
		echo 1;
	}
	// update account
?>