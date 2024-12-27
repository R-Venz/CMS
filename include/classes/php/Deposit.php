<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Deposit {
		protected static  $tblname = "tbl_deposit";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT * FROM tbl_msg m
			INNER JOIN tbl_deposit d ON m.deposit_id=d.id
		  	WHERE 1 $condition ORDER BY m_dt DESC";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT * FROM tbl_msg m
			INNER JOIN tbl_deposit d ON m.deposit_id=d.id
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$amt){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$amt = $mydb->escape_value($amt);

			$query = "UPDATE tbl_deposit SET balance = ($amt+balance) WHERE membership_id='{$id}'";
			// echo $query;
			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
			return 1;
		}
		function single_view($id=""){
			global $mydb;
			$query = "SELECT * FROM tbl_membership WHERE id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
	}
?>