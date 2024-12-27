<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $membership = new Membership();

  $draw = $_POST['draw'];  
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = $mydb->escape_value($_POST['search']['value']); // Search value
  
  /*$draw = 1;  
  $row = 0;
  $rowperpage = 5; // Rows display per page
  $columnName = 'm.id'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value*/

  ## Search 
  $searchQuery = "  AND role='Head' ";

  if (isset($_GET['sr'])) {
    $searchQuery .= " AND CONCAT(lname, ', ', fname) LIKE '%".$mydb->escape_value($_GET['sr'])."%'";
  }

  /*if($searchValue != ''){
    $searchQuery .= " AND (CONCAT(lname, ', ', fname) LIKE '%".$searchValue."%')";
  }*/

  if($columnName == "action") $columnName='lname';
  
  $orderby = " GROUP BY mp.id ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $membership->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $membership->getMax($searchQuery);
  $totalRecordwithFilter = $membership->getMax($searchQuery);
   
  ## Fetch records
  $data = array();
  $res = $membership->view($searchQuery,$orderby);
  foreach($res as $rs){
    $id  = $rs->mpid;
    $fname  = $rs->fname;
    $lname  = $rs->lname;
    $name  = $rs->name;
    $cnum  = $rs->cnum;
    $member  = '
                  <button class="btn btn-sm btn-primary" onclick="open_member(\''.base64_encode($id).'\')">
                    '.$rs->member.'
                  </button>
              ';
    $btn = '
          <button class="btn btn-sm btn-info" title="View Bill" onclick="bill_details(\''.base64_encode($id).'\')"><i class="material-icons md-11 align-middle">attach_money</i>
          </button>
    ';
    $st = ($rs->mstatus == 'Active') ? 'checked':'';
    $addr  = $rs->addr;
    $data[] = array(
            "id"=>$id,
            "name"=>strtoupper($name),
            "cnum"=>strtoupper($cnum),
            "member"=>$member,
            "addr"=>strtoupper($addr),
            "status"=>'<input type="checkbox" id="st'.$id.'" name="bootstrap-switch" data-off-color="danger" '.$st.' onchange="updatestatus(\''.$id.'\')">',
            "action"=>'
                  <button class="btn btn-sm btn-info" onclick="details(\''.base64_encode($id).'\',\''.base64_encode($addr).'\')"><i class="material-icons md-11 align-middle">edit</i>
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