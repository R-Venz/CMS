<?php  
	require_once("../../include/Initialize.php");

	if (isset($_POST['bill'])) {
		$bill = new Bill();
		$uid = '';
		if (isset($_SESSION['CMS_treasurer_id'])) {
			$uid = base64_decode($_SESSION['CMS_treasurer_id']);
		}else{
			$uid = base64_decode($_SESSION['CMS_collector_id']);
		}
		$isError = false;
		foreach ($_POST['bill'] as $val) {
			$bill_id=explode('*_*', base64_decode($val))[0];
			$amt=explode('*_*', base64_decode($val))[1];
			if (!$bill::save($amt,$bill_id,$uid)) {
				$isError = true;
			}
		}
		if (!$isError) {
			echo 1;
			return;
		}
	}else{
		echo "No data selected";
	}

?>