<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $member = new Member();

  $draw = $_POST['draw'];  
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = $mydb->escape_value($_POST['search']['value']); // Search value
  $mpid = $mydb->escape_value(base64_decode($_GET['mpid'])); // Search value
  
  /*$draw = 1;
  $row = 0;
  $rowperpage = 5; // Rows display per page
  $columnName = 'm.id'; // Column name
  $columnSortOrder = 'ASC'; // asc or desc
  $searchValue = ""; // Search value*/

  ## Search 
  $searchQuery = " AND membership_id='{$mpid}' ";

  if (isset($_GET['sr'])) {
    $searchQuery .= " AND CONCAT(lname, ', ', fname) LIKE '%".$mydb->escape_value($_GET['sr'])."%'";
  }

  /*if($searchValue != ''){
    $searchQuery .= " AND (CONCAT(lname, ', ', fname) LIKE '%".$searchValue."%')";
  }*/

  if($columnName == "action") $columnName='lname';
  
  $orderby = " GROUP BY m.id ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ".$row.",".$rowperpage;


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $member->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $member->getMax($searchQuery);
  $totalRecordwithFilter = $member->getMax($searchQuery);
  
  ## Fetch records
  $data = array();
  $res = $member->view($searchQuery,$orderby);
  foreach($res as $rs){
    $id  = $rs->mid;
    $mmid  = $rs->mmid;
    $fname  = $rs->fname;
    $lname  = $rs->lname;
    $mname  = $rs->mname;
    $name  = $rs->name;
    $cnum  = $rs->cnum;
    $role  = $rs->role;
    $relationship  = $rs->relationship;
    $dob  = date_format(date_create($rs->dob),'M d, Y');
    $email  = $rs->email;
    $data[] = array(
            "id"=>$id,
            "name"=>strtoupper($name),
            "dob"=>$dob,
            "email"=>$email,
            "cnum"=>$cnum,
            "role"=>$role,
            "relationship"=>$relationship,
            "action"=>'
                  <button class="btn btn-sm btn-info" onclick="details_member(\''.base64_encode($id).'\',\''.base64_encode($fname).'\',\''.base64_encode($mname).'\',\''.base64_encode($lname).'\',\''.base64_encode($rs->dob).'\',\''.base64_encode($email).'\',\''.base64_encode($cnum).'\',\''.base64_encode($role).'\',\''.base64_encode($relationship).'\',\''.base64_encode($mmid).'\')"><i class="material-icons md-11 align-middle">edit</i>
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