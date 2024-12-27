<?php
require_once(LIB_PATH.DS."dbConfig/Database.php");
class UserLog {
	protected static  $tblname = "tbl_employees";

	static function loginAuthentication($U_NAME,$U_PASS, $role){
		global $mydb;
		$U_NAME = $mydb->escape_value($U_NAME);
		$U_PASS = $mydb->escape_value($U_PASS);
		$query = "SELECT * FROM tbl_user
		WHERE pass=MD5('{$U_PASS}') AND status='Active' 
		AND uname='{$U_NAME}' AND role='{$role}'";
		$mydb->setQuery($query);
		$cur = $mydb->executeQuery();
		if($cur==false){
			echo $mydb->error_msg;
		}
		$row_count = $mydb->num_rows($cur);//get the number of count
		 if ($row_count == 1){
		 	$user_found = $mydb->loadSingleResult();
		 	$_SESSION['CMS_'.$role.'_id']		= base64_encode($user_found->id);
		 	$_SESSION['CMS_'.$role.'_fname']   = $user_found->fname;
		 	$_SESSION['CMS_'.$role.'_lname'] 	= $user_found->lname;
		 	$_SESSION['CMS_'.$role.'_role'] 	= $user_found->role;
		 	$_SESSION['CMS_'.$role.'_uname'] 	= $user_found->uname;
		 	$_SESSION['CMS_'.$role.'_status'] 	= $user_found->status;
		   return true;
		 }else{
		 	return false;
		 }
	}
	static function loginAuthenticationMember($U_NAME,$U_PASS, $role){
		global $mydb;
		$U_NAME = $mydb->escape_value($U_NAME);
		$U_PASS = $mydb->escape_value($U_PASS);
		$query = "SELECT *,mp.id AS mpid FROM tbl_membership mp
		INNER JOIN tbl_mm mm ON mp.id=mm.membership_id
		INNER JOIN tbl_member m ON mm.member_id=m.id
		WHERE pass=MD5('{$U_PASS}')
		AND uname='{$U_NAME}' GROUP BY mp.id";
		// echo $query;
		$mydb->setQuery($query);
		$cur = $mydb->executeQuery();
		if($cur==false){
			echo $mydb->error_msg;
		}
		$row_count = $mydb->num_rows($cur);//get the number of count
		 if ($row_count == 1){
		 	$user_found = $mydb->loadSingleResult();
		 	$_SESSION['CMS_'.$role.'_id']		= base64_encode($user_found->mpid);
		 	$_SESSION['CMS_'.$role.'_fname']   = $user_found->fname;
		 	$_SESSION['CMS_'.$role.'_lname'] 	= $user_found->lname;
		 	$_SESSION['CMS_'.$role.'_uname'] 	= $user_found->uname;
		 	$_SESSION['CMS_'.$role.'_status'] 	= $user_found->mstatus;
		   return true;
		 }else{
		 	return false;
		 }
	}
	public function initiateSessionsLoginAttempt($user){
		// for counter
		if(!isset($_SESSION['login_'.$user.'_attempt'])){
			$_SESSION['login_'.$user.'_attempt'] = 0;
		}
	}
	public function unsetSessionsLoginAttempt($user){
		unset($_SESSION['login_'.$user.'_attempt_again']);
		unset($_SESSION['login_'.$user.'_last_attempt']);
		unset($_SESSION['login_'.$user.'_attempt']);
		unset($_SESSION['error']);
	}
	public function ifReachedAttemptLimit($user){
		//check if there are 3 attempts already
		if (isset($_SESSION['login_'.$user.'_attempt'])) {
			if($_SESSION['login_'.$user.'_attempt'] == 5){
				// set it to 60 seconds lang sa for admin ang faculty pwidi e 2 mins. or taas pa
				$_SESSION['login_'.$user.'_attempt_again'] = time() + (60);
				//note 5*60 = 5mins, 60*60 = 1hr, to set to 2hrs change it to 2*60*60
				return true;
			}else{
				return false;
			}
		}
	}
	public function addTimeAttemptCount($user){
		// if error add 1 to attempt
		$_SESSION['login_'.$user.'_attempt'] += 1;
		// if error add last attempt time
		$_SESSION['login_'.$user.'_last_attempt'] = time() + (60);
	}
	public function ifPassTime($user){
		if(isset($_SESSION['login_'.$user.'_last_attempt'])){
		    if(time() >= $_SESSION['login_'.$user.'_last_attempt']){
		        $this->unsetSessionsLoginAttempt($user);
		        return true;
		    }else{
		    	return false;
		    }
		}
	}
	public function ifCanLoginAgain($user){
		//check if can login again
		if(isset($_SESSION['login_'.$user.'_attempt_again'])){
		    if(time() >= $_SESSION['login_'.$user.'_attempt_again']){
		        $this->unsetSessionsLoginAttempt($user);
		        return true;
		    }else{
		    	return false;
		    }
		}
		return true;
	}

}
?>