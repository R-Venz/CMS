<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class User {
		protected static  $tblname = "tbl_user";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname) AS name FROM tbl_user
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT * FROM tbl_user
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$fname,$lname,$uname,$pass,$role,$status){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$uname = $mydb->escape_value($uname);
			$pass = $mydb->escape_value($pass);
			$role = $mydb->escape_value($role);
			$status = $mydb->escape_value($status);

			if(self::isDuplicateUsername($id,$uname)==false) return;
			if(self::isDuplicate($id,$fname,$lname)==false) return;
			if (empty($id)){
				$query = "INSERT INTO ".self::$tblname." (fname,lname,uname,pass,role,status)
						  VALUES('{$fname}','{$lname}','{$uname}',MD5('{$pass}'),'{$role}','{$status}')";
			}else{
				$addpass = "";
				if (!empty($pass)) {
					$addpass = "pass=MD5('{$pass}'),";
				}
				$query = "UPDATE ".self::$tblname." SET 
						  fname='{$fname}',
						  lname='{$lname}',
						  uname='{$uname}',
						  $addpass
						  role='{$role}',
						  status='{$status}'
						  WHERE id='{$id}'";
			}

			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return 1;
		}
		static function updateaccount($id,$uname,$pass){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$uname = $mydb->escape_value($uname);
			$pass = $mydb->escape_value($pass);

			if(self::isDuplicateUsername($id,$uname)==false) return;
			$query = "UPDATE tbl_user SET 
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
		static function isDuplicate($id,$fname,$lname){
			global $mydb;

			$query = "SELECT * FROM ".self::$tblname."
							WHERE fname='{$fname}' AND lname='{$lname}' AND NOT id='{$id}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "Duplicate data for " . $fname .' '. $lname;
				return false;
			}
			return true;
		}
		function single_view($id=""){
			global $mydb;
			$query = "SELECT * FROM tbl_user WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		static function single_view_condition($condition){
			global $mydb;
			$query = "SELECT *,CONCAT(fname,' ',lname) AS name FROM tbl_user
			WHERE 1 $condition";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function check_number_user($role){
			global $mydb;
			$query = "SELECT COUNT(*) FROM tbl_user WHERE role='{$role}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			return $mydb->num_rows($result);
		}
	}
?>