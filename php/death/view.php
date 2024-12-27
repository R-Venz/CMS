<?php
  require_once("../../include/Initialize.php");

  //it creates a new objects of member
  $death = new DeathRecord();
  $bill = new Bill();

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
  $searchQuery = " ";
  if (isset($_GET['ismember'])) {
    $searchQuery .= " AND NOT dstatus='Pending' AND NOT dstatus='Rejected'";
  }else if (isset($_GET['ismemberdashboard'])) {
    $searchQuery .= " AND dstatus='Posted'";
  }
  if (isset($_GET['sr'])) {
    $searchQuery .= " AND CONCAT(m.lname, ', ', m.fname) LIKE '%".$mydb->escape_value($_GET['sr'])."%'";
  }

  /*if($searchValue != ''){
    $searchQuery .= " AND (CONCAT(lname, ', ', fname) LIKE '%".$searchValue."%')";
  }*/

  if($columnName == "action" || $columnName == "status2") $columnName="CONCAT(m.lname,', ',m.fname,' ',m.mname)";
  
  $orderby = " GROUP BY d.id ORDER BY dstatus='Pending' DESC LIMIT ".$row.",".$rowperpage;


  /*$totalRecords = 0;
  $totalRecordwithFilter = 0;
*/
  ## Total number of records without filtering
  $totalRecords = $death->getMax();
  // $totalRecords=0;
   
  ## Total number of records with filtering
  // $totalRecordwithFilter = $death->getMax($searchQuery);
  $totalRecordwithFilter = $death->getMax($searchQuery);
  
  ## Fetch records
  $data = array();
  $res = $death->view($searchQuery,$orderby);
  foreach($res as $rs){
    $id  = $rs->did;
    $member_id  = $rs->member_id;
    $declarant_id  = $rs->declarant_id;
    $mmid  = $rs->mmid;
    $fname  = $rs->fname;
    $lname  = $rs->lname;
    $mname  = $rs->mname;
    $name  = strtoupper($rs->name);
    $cnum  = $rs->cnum;
    $role  = $rs->role;
    $relationship  = $rs->relationship;
    $dob  = date_format(date_create($rs->dob),'M d, Y');
    $dod  = date_format(date_create($rs->dod),'M d, Y');
    $cod  = strtoupper($rs->cod);
    $declerant  = strtoupper($rs->declerant);
    $age  = $rs->age;
    $status  = $rs->dstatus;
    $deadline  = date('M d, Y', strtotime($rs->date_added. ' + 7 days'));
    $color = 'green';
    if ($status=='Pending') {
      $color = 'btn-warning';
    }else if ($status=='Posted') {
      $color = 'btn-success';
    }else if ($status=='Rejected') {
      $color = 'btn-danger';
    }else if ($status=='Closed') {
      $color = 'btn-default';
    }
    $btn='';
    $status2  = '
                  <button class="btn btn-sm '.$color.'" style="height:20px!important;" title="Update Status" onclick="selectStatus(\''.base64_encode($id).'\',\''.base64_encode($status).'\')">'.$status.'
              ';
    if (isset($_GET['t'])) {
      if ($_GET['t']=='treasurer') {
        $totalContribution  = $bill->totalContribution($id);
        $totalReleased      = $bill->totalReleased($id);
        $btn =      '<button class="btn btn-sm btn-success" title="View Record" onclick="mngTransaction(\''.base64_encode($id).'\',\''.base64_encode($name).'\',\''.base64_encode($status).'\',\''.base64_encode($totalContribution).'\',\''.base64_encode($totalReleased).'\',\''.base64_encode(number_format($totalContribution-$totalReleased,2)).'\')">
                    <i class="material-icons md-11 align-middle">attach_money</i>
                  </button>
                  ';
      }
    }
    $data[] = array(
            "id"=>$id,
            "member_id"=>$member_id,
            "declarant_id"=>$declarant_id,
            "name"=>strtoupper($name),
            "dod"=>$dod,
            "cod"=>$cod,
            "cnum"=>$cnum,
            "declerant"=>$declerant,
            "age"=>$age,
            "status"=>$status,
            "status2"=>$status2,
            "deadline"=>$deadline,
            "action"=>'
                  <button class="btn btn-sm btn-info" title="View Record" onclick="details_death(\''.base64_encode($id).'\',\''.base64_encode($member_id).'\',\''.base64_encode($declarant_id).'\',\''.base64_encode($rs->dod).'\',\''.base64_encode($cod).'\')"><i class="material-icons md-11 align-middle">search</i>
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