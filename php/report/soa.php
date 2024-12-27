<?php
  require_once("../../include/initialize.php");
  date_default_timezone_set('Asia/Manila');
  header("Content-Type: text/html;charset=utf-8");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);
  $id=str_replace("'","__", $_GET['id']);
    
  $pdf = new PDF_MC_Table('P','mm',array(215.9,330.2));

  $dth = new DeathRecord();
  $release = new Release();

  $name = "";
  $declerant = "";
  $dod = "";
  $cod = "";

  $rs = $dth->single_view($id);
  if (!isset($rs->name)) {
    $name = "Member's data not found!";
  }else{
    $name = strtoupper(utf8_decode($rs->name));
    $declerant = strtoupper(utf8_decode($rs->declerant));
    $dod = date_format(date_create($rs->dod),'M d, Y');
    $cod = strtoupper(utf8_decode($rs->cod));
  }

  $pdf->AddPage();
  $totalUnits=0;
  $totalSub=0;
  $pdf -> SetTitle($name,True);
  $pdf -> SetAuthor("CMS",True);

  $pdf->SetFont("Courier",'B', 15);
  $pdf->SetTextColor(0,0,0);
  $pdf->Cell(0,5,strtoupper("La-Victoria Kapunongan"),0,1,"C");
  $pdf->SetFont("Courier",'', 10);
  $pdf->SetTextColor(0,0,0);
  $pdf->Cell(0,4,"La-Victoria, Aurora, Zamboanga del Sur",0,1,"C");
  $pdf->SetFont("Courier",'B', 12);
  $pdf->SetTextColor(10,0,255);
  $pdf->Cell(0,5,"STATEMENT OF ACCOUNT",0,1,"C");
  $pdf->Line(79,$pdf->GetY() ,137,$pdf->GetY());

  $pdf->SetTextColor(0,0,0);

  $pdf->SetFont("Courier",'', 8);
  $pdf->Cell(0,3,"Printed on " . date('M d, Y h:i:s a'),0,1,"C");
  $pdf->Cell(0,3,"",0,1,"L");

  $pdf->SetFont("Courier",'', 8);
  $pdf->Cell(20,3,"Member: ",0,0,"L");
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(155,3,$name,0,1,"L");   //<---------------------------
  $pdf->SetFont("Courier",'', 8);
  $pdf->Cell(20,3,"Declerant: ",0,0,"L");
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(155,3,$declerant,0,1,"L"); //<---------------------------
  $pdf->SetFont("Courier",'', 8);
  $pdf->Cell(25,3,"Date of Death: ",0,0,"L");
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(0,3,$dod,0,1,"L");   //<---------------------------
  $pdf->SetFont("Courier",'', 8);
  $pdf->Cell(26,3,"Cause of Death: ",0,0,"L");
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(0,3,$cod,0,1,"L");   //<---------------------------
  $pdf->SetFont("Courier",'', 8);
  // =====================================================================//
  $pdf->SetFont("Courier",'B', 12);
  $pdf->SetTextColor(10,0,255);
  $pdf->Cell(0,5,"EXPENSES",0,1,"C");
  $pdf->SetTextColor(0,0,0);
  // =====================================================================//
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(20,5,"DATE",1,0,"L");
  $pdf->Cell(70,5,"PURPOSE",1,0,"L");
  $pdf->Cell(70,5,"RECEIVED BY",1,0,"L");
  $pdf->Cell(0,5,"AMOUNT",1,1,"L");
  $pdf->SetFont("Courier",'', 8);

  $pdf->SetWidths(Array(20,70,70,0));
  //set alignment
  //$pdf->SetAligns(Array('','R','C','','',''));
  //set line height. This is the height of each lines, not rows.
  $pdf->SetLineHeight(5);
  $totalExpenses=0;
  $totalReleased=0;
  $subData  = array();  
  $res = $release->view(" AND dd.id='{$id}' AND r.type='Expenses'"," ORDER BY dt ASC");
  foreach ($res as $rs) {
    $subData[] = array(
      "dt"      =>           date_format(date_create($rs->dt),'M-d-y'),
      "purpose"     =>        $rs->purpose,
      "receiver"      =>        $rs->receiver,
      "amt"        =>       number_format($rs->amt,2)
    );
    $totalExpenses += $rs->amt;
  }
  $subData[] = array(
    "dt"      =>          "******",
    "purpose"     =>        "*********************************",
    "receiver"      =>        "TOTAL EXPENSES",
    "amt"        =>       number_format($totalExpenses,2)
  );
  foreach($subData as $item){
      //write data using Row() method containing array of values.
      $pdf->Row(Array(
          $item['dt'],
          $item['purpose'],
          $item['receiver'],
          $item['amt'],
      ));
  }
  // =====================================================================//
  $pdf->SetFont("Courier",'B', 12);
  $pdf->SetTextColor(10,0,255);
  $pdf->Cell(0,5,"RELEASED",0,1,"C");
  $pdf->SetTextColor(0,0,0);
  // =====================================================================//
  $pdf->SetFont("Courier",'B', 8);
  $pdf->Cell(20,5,"DATE",1,0,"L");
  $pdf->Cell(70,5,"RECEIVED BY",1,0,"L");
  $pdf->Cell(70,5,"RELEASED BY",1,0,"L");
  $pdf->Cell(0,5,"AMOUNT",1,1,"L");
  $pdf->SetFont("Courier",'', 8);

  $subData  = array();  
  $res = $release->view(" AND dd.id='{$id}' AND r.type='Released'"," ORDER BY dt ASC");
  foreach ($res as $rs) {
    $subData[] = array(
      "dt"      =>           date_format(date_create($rs->dt),'M-d-y'),
      "receiver"      =>        $rs->receiver,
      "user"     =>        $rs->user_name,
      "amt"        =>       number_format($rs->amt,2)
    );
    $totalReleased += $rs->amt;
  }
  $subData[] = array(
    "dt"      =>          "******",
    "receiver"     =>        "*********************************",
    "user"      =>        "TOTAL RELEASED",
    "amt"        =>       number_format($totalReleased,2)
  );
  foreach($subData as $item){
      //write data using Row() method containing array of values.
      $pdf->Row(Array(
          $item['dt'],
          $item['receiver'],
          $item['user'],
          $item['amt'],
      ));
  }
  $bill = new Bill();
  $totalContribution  = $bill->totalContribution($id);
  $totalExpenses      = $bill->totalReleased($id,'Expenses');
  $totalReleased      = $bill->totalReleased($id,'Released');
  $treasurername = "Treasurer data not found";
  $adminname = "Administrator data not found";
  $uid = base64_decode($_SESSION['CMS_treasurer_id']);
  $user = new User();
  $rs = $user->single_view_condition(" AND id='{$uid}'");
  if(isset($rs->name)){
      $treasurername = $rs->name;
  }
  $rs = $user->single_view_condition(" AND role='Admin'");
  if(isset($rs->name)){
      $adminname = $rs->name;
  }

  $pdf->Cell(0,3,"",0,1,"L");
  $pdf->SetFont("Courier",'B', 12);
  $pdf->Cell(0,5,"SUMMARY",0,1,"L");
  $pdf->SetFont("Courier",'I', 12);
  $pdf->Cell(45,5,"GROSS:",0,0,"L");
  $pdf->Cell(30,5,number_format($totalContribution,2),0,1,"R");
  $pdf->SetTextColor(255,0,0);
  $pdf->Cell(45,5,"TOTAL EXPENSES:",0,0,"L");
  $pdf->Cell(30,5,number_format($totalExpenses,2),0,1,"R");
  $pdf->SetTextColor(0,0,0);
  $pdf->Line(11,$pdf->GetY() ,85,$pdf->GetY());
  $pdf->SetFont("Courier",'B', 12);
  $pdf->Cell(45,5,"NET",0,0,"L");
  $pdf->Cell(30,5,number_format($totalContribution-$totalExpenses,2),0,1,"R");
  $pdf->Cell(0,2,"",0,1,"R");

  $pdf->SetFont("Courier",'I', 12);
  $pdf->Cell(45,5,"RELEASED:",0,0,"L");
  $pdf->Cell(30,5,number_format($totalReleased,2),0,1,"R");
  $pdf->Line(11,$pdf->GetY() ,85,$pdf->GetY());
  $pdf->SetFont("Courier",'B', 12);
  $pdf->Cell(45,5,"REMAINING BALANCE:",0,0,"L");
  $pdf->Cell(30,5,number_format((($totalContribution-$totalExpenses)-$totalReleased),2),0,1,"R");
  
  $pdf->Cell(0,10,"",0,1,"C");
  $pdf->SetFont("Courier",'B', 12);
  $pdf->Cell(43,5,$treasurername,0,1,"C");
  $pdf->Line(10,$pdf->GetY() ,53,$pdf->GetY());
  $pdf->SetFont("Courier",'', 12);
  $pdf->Cell(43,5,"Treasurer",0,1,"C");

  $pdf->Cell(0,10,"",0,1,"C");
  $pdf->SetFont("Courier",'B', 12);
  $pdf->Cell(43,5,$adminname,0,1,"C");
  $pdf->Line(10,$pdf->GetY() ,53,$pdf->GetY());
  $pdf->SetFont("Courier",'', 12);
  $pdf->Cell(43,5,"Administrator",0,1,"C");
  // =====================================================================//
  $pdf->Output('_' . $name . "-SOA.pdf",'I');
  ob_end_flush();
?>