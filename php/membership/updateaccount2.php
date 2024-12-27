<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$member = new Membership();
	$i=0;

	$id=$_POST['id'];
	$uname=$_POST['uname'];
	$pass=$_POST['pass'];
	$pass2=$_POST['pass2'];
	if ($pass != $pass2) {
		echo "Passwords are not matched!"; return;
	}
	if ($member::updateaccount($id,$uname,$pass)) {
		$_SESSION['CMS_member_uname'] = $uname;
		echo 1;
	}
?>