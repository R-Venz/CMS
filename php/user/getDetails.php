<?php
	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);
	$id = $Data->id;
	$class = new User();
	$rs = $class->single_view(base64_decode($id));
	if (!isset($rs->id)) {
		echo "Data data not found!";
		return;
	}
  	$DataString = '{
                  "user_id":"'.base64_encode($rs->id).'",
                  "fname":"'.base64_encode($rs->fname).'",
                  "lname":"'.base64_encode($rs->lname).'",
                  "mname":"'.base64_encode($rs->mname).'",
                  "sname":"'.base64_encode($rs->sname).'",
                  "citizenship":"'.base64_encode($rs->citizenship).'",
                  "sex":"'.base64_encode($rs->sex).'",
                  "dob":"'.base64_encode($rs->dob).'",
                  "pob":"'.base64_encode($rs->pob).'",
                  "cnum":"'.base64_encode($rs->cnum).'",
                  "email":"'.base64_encode($rs->email).'",
                  "addr":"'.base64_encode($rs->addr).'",
                  "department_id":"'.base64_encode($rs->department_id).'",
                  "status":"'.base64_encode($rs->status).'",
                  "uname":"'.base64_encode($rs->uname).'",
                  "pass":"'.base64_encode($rs->pass).'",
                  "role":"'.base64_encode($rs->role).'",
                  "account_status":"'.base64_encode($rs->account_status).'",
                  "person_id":"'.base64_encode($rs->person_id).'",
                  "personnel_id":"'.base64_encode($rs->personnel_id).'",
                  "role_id":"'.base64_encode($rs->role_id).'",
                  "name":"'.base64_encode($rs->name).'"
                }';
  	echo $DataString;
?>