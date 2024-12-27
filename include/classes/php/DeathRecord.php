<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class DeathRecord {
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *, CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name, m.id AS mid, mm.id AS mmid, mm.membership_id AS mpid, d.id AS did, 
			TIMESTAMPDIFF(YEAR, m.dob, dod) AS age,CONCAT(de.lname,', ',de.fname,' ',de.mname) AS declerant
			FROM tbl_member m
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
			INNER JOIN tbl_declared_death d ON m.id=d.member_id
			INNER JOIN tbl_member de ON d.declarant_id=de.id
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name, m.id AS mid, mm.id AS mmid, mm.membership_id AS mpid, 
			TIMESTAMPDIFF(YEAR, m.dob, dod) AS age,CONCAT(de.lname,', ',de.fname,' ',de.mname) AS declerant
			FROM tbl_member m
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
			INNER JOIN tbl_declared_death d ON m.id=d.member_id
			INNER JOIN tbl_member de ON d.declarant_id=de.id
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		static function save($id,$mid,$dec,$dod,$cod,$uid){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$mid = $mydb->escape_value($mid);
			$dec = $mydb->escape_value($dec);
			$dod = $mydb->escape_value($dod);
			$cod = $mydb->escape_value($cod);
			$uid = $mydb->escape_value($uid);
			if(self::isDuplicate($id,$mid)==false) return;
			// return;
			if (empty($id)){
				$query = "INSERT INTO tbl_declared_death (member_id,declarant_id,dod,cod,user_id)
						  VALUES('{$mid}','{$dec}','{$dod}','{$cod}','{$uid}')";
			}else{
				// if(self::isPending($id)==false) return;
				// check if death record has been posted. if posted or rejected. not allowed to make changes
				$query = "UPDATE tbl_declared_death SET 
						  member_id='{$mid}', 
						  declarant_id='{$dec}', 
						  dod='{$dod}', 
						  cod='{$cod}'
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
		function single_view($id){
			global $mydb;
			$id = $mydb->escape_value($id);
			$query = "SELECT *, CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name, m.id AS mid, mm.id AS mmid, mm.membership_id AS mpid, d.id AS did, 
			TIMESTAMPDIFF(YEAR, m.dob, dod) AS age,CONCAT(de.lname,', ',de.fname,' ',de.mname) AS declerant
			FROM tbl_member m
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
			INNER JOIN tbl_declared_death d ON m.id=d.member_id
			INNER JOIN tbl_member de ON d.declarant_id=de.id
		  	WHERE d.id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		static function isPending($id){
			global $mydb;

			$query = "SELECT * FROM tbl_declared_death
			WHERE NOT dstatus='Pending' AND id='{$id}'";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			if ($result > 0) {
				echo "This record is locked! You cannot alter this data.";
				return false;
			}
			return true;
		}
		static function isDuplicate($id,$mid){
			global $mydb;

			$query = "SELECT * FROM tbl_declared_death
			WHERE member_id='{$mid}' AND NOT id='{$id}'";
			// echo $query;
			$mydb->setQuery($query);
			$rs = $mydb->loadSingleResult();
			if(isset($rs->id)){
				if ($rs->dstatus == 'Posted') {
					echo 'Duplicate declaration! This member\'s death has already posted.';return false;
				}else if ($rs->dstatus == 'Closed') {
					echo 'Duplicate declaration. Family Member\'s already received the contribution.';return false;
				}else if ($rs->dstatus == 'Pending') {
					echo 'This member has a pending process. Please wait for the administrator to approve or reject.';return false;
				}
			}
			return true;
		}
		static function updatestatus($id,$status){
			global $mydb;
			$isNew = false;
			$id = $mydb->escape_value($id);
			$status = $mydb->escape_value($status);

			$query = "UPDATE tbl_declared_death SET 
					  dstatus='{$status}'
					  WHERE id='{$id}'";
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