<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Bill {
		protected static  $tblname = "tbl_membership";

		function dbfields () {
			global $mydb;
			return $mydb->getfieldsononetable(self::$tblname);
		}
		function view($condition,$ext){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname) AS name,mp.id AS mpid,m.id AS MID,getNumMember(mp.id) AS member,b.id AS bid,c.id AS cid
			FROM tbl_membership mp
			LEFT JOIN tbl_mm mm ON mp.id=mm.membership_id
			INNER JOIN tbl_bill b ON mp.id=b.membership_id
			LEFT JOIN tbl_contribution c ON b.id=c.bill_id
			INNER JOIN tbl_declared_death d ON b.death_id=d.id
			LEFT JOIN tbl_member m ON d.member_id=m.id
		  	WHERE 1 $condition $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMax($condition=''){
			global $mydb;
			$query = "SELECT *,CONCAT(lname,', ',fname) AS name,mp.id AS mpid,m.id AS MID,getNumMember(mp.id) AS member,b.id AS bid,c.id AS cid
			FROM tbl_membership mp
			LEFT JOIN tbl_mm mm ON mp.id=mm.membership_id
			INNER JOIN tbl_bill b ON mp.id=b.membership_id
			LEFT JOIN tbl_contribution c ON b.id=c.bill_id
			INNER JOIN tbl_declared_death d ON b.death_id=d.id
			LEFT JOIN tbl_member m ON d.member_id=m.id
		  	WHERE 1 $condition";
			$mydb->setQuery($query);
			$result = $mydb->executeQuery();
			$result = $mydb->num_rows($result);
			return $result;
		}
		function totalContribution($id){
			global $mydb;
			$query = "SELECT getCollectedByDeath('{$id}') AS total";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur->total;
		}
		function totalReleased($id,$t=''){
			global $mydb;
			$query = "SELECT getReleasedByDeath('{$id}','{$t}') AS total";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur->total;
		}
		static function save($amt,$bill_id,$uid){
			global $mydb;
			$isNew = false;
			$amt = $mydb->escape_value($amt);
			$bill_id = $mydb->escape_value($bill_id);
			$uid = $mydb->escape_value($uid);

			$query = "INSERT INTO tbl_contribution (amount,user_id,bill_id)
		  	VALUES('{$amt}','{$uid}','{$bill_id}')";

			$mydb->setQuery($query);
			$cur = $mydb->executeQuery();
			if($cur==false){
				echo $mydb->error_msg;
				return false;
			}
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
		static function single_view_condition($condition){
			global $mydb;
			$query = "SELECT * FROM tbl_membership
			WHERE 1 $condition";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getMemberContribution($searchQuery,$orderby){
			global $mydb;
			$query = "SELECT CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name,b.id AS bid,mp.id AS mpid,mstatus,CONCAT(m2.lname,', ',m2.fname,' ',m2.mname) AS name2,CONCAT(u.lname,', ',u.fname) AS name3,c.*
			FROM tbl_bill b
			INNER JOIN tbl_membership mp ON b.membership_id=mp.id 
			INNER JOIN tbl_mm mm ON mp.id=mm.membership_id AND role='Head'
			INNER JOIN tbl_member m ON mm.member_id=m.id
			INNER JOIN tbl_contribution c ON b.id=c.bill_id
			INNER JOIN tbl_declared_death dd ON b.death_id=dd.id
			INNER JOIN tbl_member m2 ON dd.member_id=m2.id
			INNER JOIN tbl_user u ON c.user_id=u.id
			WHERE 1
			$searchQuery $orderby";
			// echo $query;
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getMemberReleased($searchQuery,$orderby){
			global $mydb;
			$query = "SELECT CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name,mp.id AS mpid,mstatus,CONCAT(u.lname,', ',u.fname) AS name2,r.*
			FROM tbl_declared_death dd
			INNER JOIN tbl_member m ON dd.member_id=m.id
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
			INNER JOIN tbl_member m2 ON dd.declarant_id=m2.id
			INNER JOIN tbl_release r ON dd.id=r.death_id
			INNER JOIN tbl_user u ON r.user_id=u.id
			WHERE 1
			$searchQuery $orderby";
			// echo $query;
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getAllReport($searchQuery,$orderby){
			global $mydb;
			$query = "SELECT CONCAT(m.lname,', ',m.fname,' ',m.mname) AS name,mstatus,CONCAT(m2.lname,', ',m2.fname) AS name2,dd.*,getCollectedByDeath(dd.id) AS collected,getCollectibleByDeath(dd.id) AS collectible,getReleasedByDeath(dd.id,'') AS released
			FROM tbl_declared_death dd
			INNER JOIN tbl_member m ON dd.member_id=m.id
			INNER JOIN tbl_mm mm ON m.id=mm.member_id
			INNER JOIN tbl_membership mp ON mm.membership_id=mp.id
			INNER JOIN tbl_member m2 ON dd.declarant_id=m2.id
			WHERE 1
			$searchQuery $orderby";
			// echo $query;
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
	}
?>