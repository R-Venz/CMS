<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $depo = new Deposit();

 /* $draw = $_POST['draw'];  
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = $mydb->escape_value($_POST['search']['value']); // Search value*/
  $id = $mydb->escape_value(base64_decode($_GET['id'])); // Search value
  
  $draw = 1;
  $row = 0;
  $rowperpage = 5; // Rows display per page
  $columnName = 'm_dt'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value

  ## Search 
  $searchQuery = " AND d.membership_id='{$id}' ";


  if($columnName == "action") $columnName='m_dt';
  
  $orderby = " GROUP BY m.id ORDER BY m_dt";


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $depo->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $depo->getMax($searchQuery);
  $totalRecordwithFilter = $depo->getMax($searchQuery);
  
  ## Fetch records
  $data = array();
  $data[] = array(
          "msg"=>'<input type="button" name="" value="Deposit" class="btn-primary btn btn-outine btn-sm" onclick="deposit(\''.base64_encode($id).'\')">',
          "balance"=>'&nbsp;',
          "status"=>'&nbsp;'
      );
  $res = $depo->view($searchQuery,$orderby);
  /*if ($res) {
    $data[] = array(
            "msg"=>'',
            "balance"=>'',
            "status"=>'<input type="button" name="" value="Deposit" class="btn-primary btn btn-outine btn-sm" onclick="deposit(\''.base64_encode($id).'\')">'
        );
  }*/
  foreach($res as $rs){
    $msg  = $rs->msg;
    $balance_amount  = $rs->balance_amount;
    $dt  = $rs->m_dt;
    $data[] = array(
            "msg"=>$msg,
            "balance"=>"Remaining balance: " . number_format($balance_amount,2),
            "status"=>$dt
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