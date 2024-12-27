<?php
	require_once(LIB_PATH.DS."dbConfig/Database.php");
	class Dashboard {
		function getBalance(){
			global $mydb;
			$query = "SELECT getBalance() AS balance";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getContribution(){
			global $mydb;
			$query = "SELECT contribution FROM tbl_settings";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getTotalMembers($st){
			global $mydb;
			$st = $mydb->escape_value($st);
			$query = "SELECT COUNT(*) AS total FROM tbl_membership WHERE mstatus='{$st}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getTotalDeceased($st){
			global $mydb;
			$st = $mydb->escape_value($st);
			$query = "SELECT COUNT(*) AS total FROM tbl_declared_death WHERE dstatus='{$st}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getTotalUnpaid($ext=''){
			global $mydb;
			if (!empty($ext)) {
				$ext = " AND membership_id='{$ext}'";
			}
			$query = "SELECT CASE WHEN SUM(amt) IS NOT NULL THEN SUM(amt) ELSE 0 END as total FROM tbl_bill
			WHERE id NOT IN (SELECT bill_id FROM tbl_contribution) $ext";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getUnpaidMembers($searchQuery,$orderby){
			global $mydb;
			$query = "SELECT SUM(amt) AS totalamount,CONCAT(lname,', ',fname,' ',mname) AS name,b.id AS bid,mp.id AS mpid,mstatus
			FROM tbl_bill b
			INNER JOIN tbl_membership mp ON b.membership_id=mp.id 
			INNER JOIN tbl_mm mm ON mp.id=mm.membership_id AND role='Head'
			INNER JOIN tbl_member m ON mm.member_id=m.id
			WHERE b.id NOT IN (SELECT bill_id FROM tbl_contribution)
			$searchQuery $orderby";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getTotalForDeactivation(){
			global $mydb;
			$query = "SELECT COUNT(*) as total FROM tbl_deactivation_account da
			INNER JOIN tbl_membership mp ON da.membership_id=mp.id
			WHERE status='Pending' AND mstatus='Active'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getForDeactivation($searchQuery,$orderby){
			global $mydb;
			$query = "SELECT SUM(amt) AS totalamount,CONCAT(lname,', ',fname,' ',mname) AS name,b.id AS bid,mp.id AS mpid,mstatus,da.id AS daid
			FROM tbl_bill b
			INNER JOIN tbl_membership mp ON b.membership_id=mp.id AND mstatus='Active'
			INNER JOIN tbl_mm mm ON mp.id=mm.membership_id AND role='Head'
			INNER JOIN tbl_member m ON mm.member_id=m.id
			INNER JOIN tbl_deactivation_account da ON mp.id=da.membership_id AND da.status='Pending'
			$searchQuery $orderby";
			$mydb->setQuery($query);
			$cur = $mydb->loadResultList();
			return $cur;
		}
		function getTotalFamilyMembers($id){
			global $mydb;
			$id = $mydb->escape_value($id);
			$query = "SELECT COUNT(*) AS total FROM tbl_mm WHERE membership_id='{$id}' AND status='Active'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
		function getMyBalance($id){
			global $mydb;
			$id = $mydb->escape_value($id);
			$query = "SELECT balance AS total FROM tbl_deposit WHERE membership_id='{$id}'";
			$mydb->setQuery($query);
			$cur = $mydb->loadSingleResult();
			return $cur;
		}
	}
?>