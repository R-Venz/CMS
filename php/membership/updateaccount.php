<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$user = new User();
	$i=0;

	$id=$_POST['id'];
	$uname=$_POST['uname'];
	$pass=$_POST['pass'];
	$pass2=$_POST['pass2'];
	if ($pass != $pass2) {
		echo "Passwords are not matched!"; return;
	}
	if ($user::updateaccount($id,$uname,$pass)) {
		$_SESSION['CMS_admin_uname'] = $uname;
		echo 1;
	}
?>