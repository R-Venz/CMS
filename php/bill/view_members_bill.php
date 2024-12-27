<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $dash = new Dashboard();

  
  $draw = 1;
  $row = 0;
  $rowperpage = 5; // Rows display per page
  $columnName = 'name'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value

  ## Search 
  $searchQuery = "  AND (CONCAT(lname, ', ' , fname) LIKE '%{$searchValue}%' OR CONCAT(fname, ' ' , lname) LIKE '%{$searchValue}%') ";


  if($columnName == "action") $columnName='lname';
  
  $orderby = " GROUP BY mp.id ORDER BY SUM(amt) DESC ";


  $totalRecords = 0;
  $totalRecordwithFilter = 0;

  ## Total number of records without filtering
  // $totalRecords = $dash->getMax();
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $dash->getMax($searchQuery);
  
  ## Fetch records
  $data = array();
  if (isset($_GET['t'])) {
    $res = $dash->getForDeactivation($searchQuery,$orderby);
  }else{
    $res = $dash->getUnpaidMembers($searchQuery,$orderby);
  }
  foreach($res as $rs){
    $id  = $rs->bid;
    $mpid  = $rs->mpid;
    $name  = $rs->name;
    $totalamount  = $rs->totalamount;
    $status = $rs->mstatus;
    $btn='';
    if (!isset($_GET['t'])) {
      if (!isset($_GET['iscollector'])) {
        if ($status == 'Active') {
          $btn = '
                      <button class="btn btn-sm btn-danger" title="Remove from membership" onclick="remove(\''.base64_encode($mpid).'\',\''.base64_encode(strtoupper($name)).'\')"><i class="material-icons md-11 align-middle">remove_circle</i>
                      </button>
          ';
        }
      }
    }else{
      $daid  = $rs->daid;
      $btn = '
                    <button class="btn btn-sm btn-danger" title="Deactivate account" onclick="remove(\''.base64_encode($daid).'\',\''.base64_encode(strtoupper($name)).'\')"><i class="material-icons md-11 align-middle">remove_circle</i>
                    </button>
      ';
    }
    $data[] = array(
            "id"=>$id,
            "name"=>strtoupper($name),
            "totalamount"=>$totalamount,
            "action"=>'
                  <button class="btn btn-sm btn-info" onclick="bill_details(\''.base64_encode($mpid).'\',\''.base64_encode(strtoupper($name)).'\')"><i class="material-icons md-11 align-middle">attach_money</i>
                  </button>
            '.$btn
        );
  }
   
  ## Response
  $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordwithFilter,
      "aaData" => $data
  );
  echo json_encode($response);
?>