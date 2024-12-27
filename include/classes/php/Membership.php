<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Membership {
		protected static  $tblname = "tbl_membership";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname) AS name,mp.id AS mpid,m.id AS mid,getNumMember(mp.id) AS member
			FROM tbl_membership mp
			LEFT JOIN tbl_mm mm ON mp.id=mm.membership_id
			LEFT JOIN tbl_member m ON mm.member_id=m.id
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname) AS name 
			FROM tbl_membership mp
			LEFT JOIN tbl_mm mm ON mp.id=mm.membership_id
			LEFT JOIN tbl_member m ON mm.member_id=m.id
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$fname,$mname,$lname,$dob,$email,$cnum,$addr){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$fname = $mydb->escape_value($fname);
			$mname = $mydb->escape_value($mname);
			$lname = $mydb->escape_value($lname);
			$dob = $mydb->escape_value($dob);
			$email = $mydb->escape_value($email);
			$cnum = $mydb->escape_value($cnum);
			$addr = $mydb->escape_value($addr);

			if (empty($id)){
				$query = "INSERT INTO ".self::$tblname." (addr)
						  VALUES('{$addr}')";
			}else{
				$query = "UPDATE ".self::$tblname." SET 
						  addr='{$addr}'
						  WHERE id='{$id}'";
			}
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			$id = $mydb->insert_id();
			$member = new Member();
			$mid = $member::addMember($fname,$mname,$lname,$dob,$email,$cnum);
			if (!$mid) {
				$query = "DELETE FROM tbl_membership
						  WHERE id='{$id}'";
				$mydb->setQuery($query);
				$cur = $mydb->executeQuery();
				echo "Member was not saved! Please try again.";
				return;
			}
			// add to mm
			if (self::addMM('',$id,$mid,'Head',NULL)==false) return false;
			return 1;
		}
		static function saveAddr($id,$addr){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$addr = $mydb->escape_value($addr);

			$query = "UPDATE ".self::$tblname." SET 
		  	addr='{$addr}'
		  	WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return true;
		}
		static function addMM($id,$mpid,$mid,$role,$relationship){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$mpid = $mydb->escape_value($mpid);
			$mid = $mydb->escape_value($mid);
			$role = $mydb->escape_value($role);
			$relationship = $mydb->escape_value($relationship);

			if (self::isDuplicateMM($id,$mid,$mpid)==false) return false;
			if ($role == 'Head') {
				// update other head to member
				$query = "UPDATE tbl_mm SET role='Member'
						  WHERE membership_id='{$mpid}'";
				$mydb->setQuery($query);
				$cur = $mydb->executeQuery();
				if($cur==false){
					echo $mydb->error_msg;
					return false;
				}
			}
			if (empty($id)){
				$query = "INSERT INTO tbl_mm (member_id,membership_id,role,relationship)
						  VALUES('{$mid}','{$mpid}','{$role}','{$relationship}')";
			}else{
				$query = "UPDATE tbl_mm SET 
						  role='{$role}',
						  relationship='{$relationship}'
						  WHERE id='{$id}'";
			}
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return true;
		}
		static function updateaccount($id,$uname,$pass){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$uname = $mydb->escape_value($uname);
			$pass = $mydb->escape_value($pass);

			if(self::isDuplicateUsername($id,$uname)==false) return;
			$query = "UPDATE tbl_membership SET 
					uname='{$uname}',
					pass=MD5('{$pass}')
					WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return 1;
		}
		static function updatestatus($id,$st){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$st = $mydb->escape_value($st);

			$query = "UPDATE tbl_membership SET 
			mstatus='{$st}'
			WHERE id='{$id}'";

			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return true;
		}
		static function isDuplicateUsername($id,$uname){
			global $mydb;

			$query = "SELECT * FROM ".self::$tblname."
							WHERE uname='{$uname}' AND NOT id='{$id}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "Username is already taken!";
				return false;
			}
			return true;
		}
		static function isDuplicateMM($id,$mid,$mpid){
			global $mydb;

			$query = "SELECT * FROM tbl_mm
			WHERE member_id='{$mid}' AND membership_id='{$mpid}' AND NOT id='{$id}'";
			// echo $query;
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "Member is already added";
				return false;
			}
			return true;
		}
		/*static function isDuplicate($id,$fname,$lname){
			global $mydb;

			$query = "SELECT * FROM tbl_member m
			WHERE fname='{$fname}' AND lname='{$lname}' AND NOT id='{$id}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "Duplicate data for " . $fname .' '. $lname;
				return false;
			}
			return true;
		}*/
		function single_view($id=""){
			global $mydb;
			$query = "SELECT * FROM tbl_membership WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function single_view_member_condition($condition){
			global $mydb;
			$query = "SELECT *,mp.id AS mpid
			FROM tbl_membership mp
			INNER JOIN tbl_mm mm ON mp.id=mm.membership_id
			INNER JOIN tbl_member m ON mm.member_id=m.id
			WHERE 1 $condition";
			// echo $query;
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		static function single_view_condition($condition){
			global $mydb;
			$query = "SELECT * FROM tbl_membership
			WHERE 1 $condition";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		static function save_da($id,$uid){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$uid = $mydb->escape_value($uid);
			if(!self::isDuplicate($id)) return;
			$query = "INSERT INTO tbl_deactivation_account(membership_id,user_id)
			VALUES('{$id}','{$uid}')";
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return true;
		}
		static function isDuplicate($id){
			global $mydb;

			$query = "SELECT * FROM tbl_deactivation_account
			WHERE membership_id='{$id}' AND status='Pending'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "This member have pending request. Please wait for the Administrator's response.";
				return false;
			}
			return true;
		}
		static function updateda($id,$st){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$st = $mydb->escape_value($st);

			$query = "UPDATE tbl_deactivation_account SET 
		  	status='{$st}'
		  	WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return 1;
		}
		/*static function updateAccount($id,$email,$password){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$email = $mydb->escape_value($email);
			$password = $mydb->escape_value($password);

			$query = "UPDATE tbl_membership SET 
			username='{$email}',
			pass='{$password}'
			WHERE id='{$id}'";

			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return true;
		}*/
	}
?>