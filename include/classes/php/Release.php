<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Release {
		protected static  $tblname = "tbl_settings";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *,CONCAT(fname, ' ', lname) AS user_name
			FROM tbl_declared_death dd
			INNER JOIN tbl_release r ON dd.id=r.death_id
			INNER JOIN tbl_user u ON r.user_id=u.id
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT * FROM tbl_settings
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$did,$purpose,$receiver,$amount,$uid,$type='Expenses'){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$did = $mydb->escape_value($did);
			$purpose = $mydb->escape_value($purpose);
			$receiver = $mydb->escape_value($receiver);
			$amount = $mydb->escape_value($amount);
			$uid = $mydb->escape_value($uid);

			if (empty($id)){
				$query = "INSERT INTO tbl_release (death_id,purpose,user_id,receiver,amt,type)
						  VALUES('{$did}','{$purpose}','{$uid}','{$receiver}','{$amount}','{$type}')";
			}else{
				echo "You cannot update the payment";return;
				/*$query = "UPDATE tbl_release SET 
						  death_id = '{$did}',
						  purpose = '{$purpose}',
						  user_id = '{$uid}',
						  receiver = '{$receiver}',
						  amt = '{$amount}'
						  WHERE id='{$id}'";*/
			}
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return 1;
		}
	}
?>