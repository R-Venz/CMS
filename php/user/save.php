<?php  
	require_once("../../include/Initialize.php");

	//it creates a new objects of member
	$user = new User();
	$i=0;

	$id=$_POST['id'];
	$fname=strtoupper($_POST['fname']);
	$lname=strtoupper($_POST['lname']);
	$uname=$_POST['uname'];
	$pass=$_POST['pass'];
	$role=$_POST['role'];
	$status=$_POST['status'];

	$rs = $user->single_view($id)/*isset($user->single_view($id)->id)? 1:0*/;
	if (isset($rs->role)) {
		if ($rs->role == $role) {
			$i=1;
		}
		if ($rs->role == 'Admin' && $rs->role != $role) {
			echo "There must be 1 admin in the system to function!"; return;
		}
	}
	if ($role == 'Admin' && $status == 'Inactive') {
		echo "You cannot deactivate the adminnistrator account!";return;
	}
	/*check # of admin*/
	/*check # of secretary*/
	/*check # of treasurer*/
	if ($role != 'Collector') {
		if (($user->check_number_user($role)-$i) >= 1) {
			echo "Unable to add another " . $role . ". Please contact the system support.";return;
		}
	}
	if ($user::save($id,$fname,$lname,$uname,$pass,$role,$status)) {
		echo 1;
	}
?>