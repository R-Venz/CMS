<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $user = new User();

  $draw = $_POST['draw'];  
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = $mydb->escape_value($_POST['search']['value']); // Search value
  
/*  $draw = 1;  
  $row = 0;
  $rowperpage = 5; // Rows display per page
  $columnName = 'id'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value*/
  $uid = '';
  /*if (isset($_SESSION['CMS_admin_id'])) {
    $uid = base64_decode($_SESSION['CMS_admin_id']);
    $rs = $user->single_view($uid);
    if (isset($rs->department_id)) {
      $did = $rs->department_id;
    }
  }*/

  ## Search 
  $searchQuery = "";

  if (isset($_GET['sr'])) {
    $searchQuery .= " AND (CONCAT(lname, ', ', fname) LIKE '%".$mydb->escape_value($_GET['sr'])."%')";
  }

  /*if($searchValue != ''){
    $searchQuery .= " AND (CONCAT(lname, ', ', fname) LIKE '%".$searchValue."%')";
  }*/

  if($columnName == "action") $columnName='lname';
  
  $orderby = " ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $user->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $user->getMax($searchQuery);
  $totalRecordwithFilter = $user->getMax($searchQuery);
   
  ## Fetch records
  $data = array();
  $res = $user->view($searchQuery,$orderby);
  foreach($res as $rs){
    $id  = $rs->id;
    $fname  = $rs->fname;
    $lname  = $rs->lname;
    $name  = $rs->name;
    $uname  = $rs->uname;
    $pass  = $rs->pass;
    $role  = $rs->role;
    $status  = $rs->status;
    $data[] = array(
            "id"=>$id,
            "name"=>strtoupper($name),
            "uname"=>strtoupper($uname),
            "pass"=>strtoupper($pass),
            "role"=>strtoupper($role),
            "status"=>strtoupper($status),
            "action"=>'
                  <button class="btn btn-sm btn-info" onclick="details(\''.base64_encode($id).'\',\''.base64_encode($fname).'\',\''.base64_encode($lname).'\',\''.base64_encode($uname).'\',\''.base64_encode($pass).'\',\''.base64_encode($role).'\',\''.base64_encode($status).'\')"><i class="material-icons md-11 align-middle">edit</i>
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