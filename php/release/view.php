<?php
  require_once("../../include/Initialize.php");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);

  //it creates a new objects of member
  $rea = new Release();


  ## Search 
  $searchQuery = " AND dd.id='{$Data->id}'";
  
  $orderby = " GROUP BY r.id ORDER BY dt DESC ";


  ## Total number of records without filtering
  // $totalRecords = $rea->getMax();
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $rea->getMax($searchQuery);
  
  ## Fetch records
  $data='';
  $res = $rea->view($searchQuery,$orderby);
  foreach($res as $rs){
    $amt  = $rs->amt;
    $purpose  = $rs->purpose;
    $name  = $rs->receiver;
    $dt  = $rs->dt;
    $data .= '
      <tr>
        <td>'.date_format(date_create($dt),'M d, Y').'</td>
        <td>'.$amt.'</td>
        <td>'.$purpose.'</td>
        <td>'.$name.'</td>
      </tr>
    ';
  }
   
  echo $data;
?>