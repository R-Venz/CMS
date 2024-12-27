<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Settings {
		protected static  $tblname = "tbl_settings";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT * FROM tbl_settings
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
		static function save($id,$contribution){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$contribution = $mydb->escape_value($contribution);

			if (empty($id)){
				$query = "INSERT INTO ".self::$tblname." (contribution)
						  VALUES('{$contribution}')";
			}else{
				$query = "UPDATE ".self::$tblname." SET 
						  contribution='{$contribution}',
						  date_altered=CURRENT_TIMESTAMP()
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
		function single_view(){
			global $mydb;
			$query = "SELECT * FROM tbl_settings LIMIT 1";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
	}
?>