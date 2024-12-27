<?php
  require_once("../../include/Initialize.php");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);

  //it creates a new objects of member
  $m = new Member();

  $res = $m->view(" AND mstatus='Active' AND membership_id='{$Data->mpid}' AND NOT member_id='{$Data->mid}'"," GROUP BY m.id ORDER BY CONCAT(lname,fname,mname)");
  foreach($res as $rs){
    echo '
      <option value="'.$rs->mid.'">'.strtoupper($rs->name).'</option>
    ';
  }
?>