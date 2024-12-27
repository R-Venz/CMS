<?php  
	require_once("../../include/Initialize.php");
	//it creates a new objects of member
	$login = new UserLog();
	$uname = trim($_POST['u']);
	$upass  = trim($_POST['p']);

    // initiate
	$login->initiateSessionsLoginAttempt('admin');

	//unset if can login again
	$login->ifPassTime('admin');
	$login->ifCanLoginAgain('admin');

	//check if there are 3 attempts already
	if ($login->ifReachedAttemptLimit('admin') == true) {
		$login->addTimeAttemptCount('admin');
		// $_SESSION['error'] = 'Attempt limit reached.';
		echo 'Attempt limit reached.';
		return;
	}

	if ($uname == '' || $upass == '') {
		// $_SESSION['error'] = "INVALID USERNAME AND PASSWORD!";
		echo "INVALID USERNAME AND PASSWORD!";
	} else {  
		//make use of the static function, and we passed to parameters
		$res = $login::loginAuthentication($uname, $upass, 'admin');
		if ($res==true) {
			$login->unsetSessionsLoginAttempt('admin');
			echo 1;
		}else{
			$login->addTimeAttemptCount('admin');

			//set the time to allow login if third attempt is reach
			if ($login->ifReachedAttemptLimit('admin') == true) {
				// $_SESSION['error'] = 'Attempt limit reached.';
				echo 'Attempt limit reached.';
			}else{
				// $_SESSION['error'] = "INVALID USERNAME AND PASSWORD! Attempt(s): " . $_SESSION['login_admin_attempt'];
				echo "INVALID USERNAME AND PASSWORD!";
			}
		}
	}
?>