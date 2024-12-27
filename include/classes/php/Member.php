<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Member {
		protected static  $tblname = "tbl_member";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname,' ',mname) AS name, m.id AS mid, mm.id AS mmid, mm.membership_id AS mpid FROM tbl_member m
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT * FROM tbl_member m
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$fname,$mname,$lname,$dob,$email,$cnum,$mpid,$role,$relationship,$mmid=''){
			global $mydb;
			$fname = $mydb->escape_value($fname);
			$mname = $mydb->escape_value($mname);
			$lname = $mydb->escape_value($lname);
			$dob = $mydb->escape_value($dob);
			$email = $mydb->escape_value($email);
			$cnum = $mydb->escape_value($cnum);
			$mpid = $mydb->escape_value($mpid);
			$role = $mydb->escape_value($role);
			$mmid = $mydb->escape_value($mmid);
			$relationship = $mydb->escape_value($relationship);

			if(self::isDuplicate($id,$fname,$lname,$mname)==false) return;
			if (empty($id)) {
				$query = "INSERT INTO tbl_member (fname,mname,lname,dob,email,cnum)
			  	VALUES('{$fname}','{$mname}','{$lname}','{$dob}','{$email}','{$cnum}')";

				$mydb->setQuery($query);
				$cur = $mydb->executeQuery();
				if($cur==false){
					echo $mydb->error_msg;
					return false;
				}
				$id = $mydb->insert_id();
			}else{
				$query = "UPDATE tbl_member 
				SET fname='{$fname}',
				mname='{$mname}',
				lname='{$lname}',
				dob='{$dob}',
				email='{$email}',
				cnum='{$cnum}'
				WHERE id='{$id}'";
				$mydb->setQuery($query);
				$cur = $mydb->executeQuery();
				if($cur==false){
					echo $mydb->error_msg;
					return false;
				}
			}
			$membership = new membership();
			$membership::addMM($mmid,$mpid,$id,$role,$relationship);
			return true;
		}
		static function addMember($fname,$mname,$lname,$dob,$email,$cnum){
			global $mydb;
			$fname = $mydb->escape_value($fname);
			$mname = $mydb->escape_value($mname);
			$lname = $mydb->escape_value($lname);
			$dob = $mydb->escape_value($dob);
			$email = $mydb->escape_value($email);
			$cnum = $mydb->escape_value($cnum);

			if(self::isDuplicate(0,$fname,$lname,$mname)==false) return;
			$query = "INSERT INTO tbl_member (fname,mname,lname,dob,email,cnum)
						  VALUES('{$fname}','{$mname}','{$lname}','{$dob}','{$email}','{$cnum}')";
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return $mydb->insert_id();
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
		static function isDuplicate($id,$fname,$lname,$mname){
			global $mydb;

			$query = "SELECT * FROM tbl_member m
			WHERE fname='{$fname}' AND lname='{$lname}' AND mname='{$mname}' AND NOT id='{$id}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "Duplicate data for " . $fname .' '. $lname . '<br>';
				return false;
			}
			return true;
		}
		function single_view($id=""){
			global $mydb;
			$query = "SELECT * FROM tbl_membership WHERE id='{$id}'";
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
	}
?>