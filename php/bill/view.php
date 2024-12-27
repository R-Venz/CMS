<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $bill = new Bill();

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
  $columnName = 'm.id'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value

  ## Search 
  $searchQuery = " AND b.membership_id='{$id}' ";


  if($columnName == "action") $columnName='lname';
  
  $orderby = " GROUP BY b.id ORDER BY c.id";


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $bill->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $bill->getMax($searchQuery);
  $totalRecordwithFilter = $bill->getMax($searchQuery);
  
  ## Fetch records
  $data = array();
  $res = $bill->view($searchQuery,$orderby);
  if ($res) {
    if (!isset($_GET['ismember'])) {
      $data[] = array(
              "id"=>'',
              "name"=>'',
              "amt"=>'',
              "status"=>'<input type="submit" name="" value="Submit Payment" class="btn-primary btn btn-outine btn-sm">',
              "action"=>'
              '
          );
    }
  }
  foreach($res as $rs){
    $bid  = $rs->bid;
    $name  = $rs->name;
    $amt  = $rs->amt;
    $status = 'Paid last ' . date_format(date_create($rs->dt_paid), 'M. d-Y');
    if (!isset($rs->cid)) {      
      if (!isset($_GET['ismember'])) {
        $status = '<input type="checkbox" name="bill[]" data-off-color="danger" value="'.base64_encode($bid.'*_*'.$amt).'">';
      }else{
        $status = "<span class='badge badge-warning'>Unpaid</span>";
      }
      if (isset($_GET['t'])) {
        if (empty($rs->dt_paid)) {
          // $status = "Unpaid";
        }
      }
    }

    $data[] = array(
            "id"=>$bid,
            "name"=>strtoupper($name),
            "amt"=>$amt,
            "status"=>$status,
            "action"=>'
                  <button class="btn btn-sm btn-info" onclick="details_member(\''.base64_encode($bid).'\')"><i class="material-icons md-11 align-middle">edit</i>
                  </button>
            '
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