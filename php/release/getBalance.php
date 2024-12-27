<?php  
  	require_once("../../include/Initialize.php");
	$Data = file_get_contents('php://input');       
	$Data = json_decode($Data);
  	$id = $Data->id;

  	$bill = new Bill();
    $totalContribution  = $bill->totalContribution($id);
    $totalReleased      = $bill->totalReleased($id);
    $ispaid = false;
    $balance = ($totalContribution-$totalReleased);
    if ($balance <= 0) {
        $ispaid = true;
    }
	$DataString = '{
                "totalCollection":"'.base64_encode($totalContribution).'",
                "totalRelease":"'.base64_encode($totalReleased).'",
                "balance":"'.base64_encode(number_format($totalContribution-$totalReleased,2)).'",
                "ispaid":"'.$ispaid.'",
                "balance":"'.base64_encode($balance).'"
              }';
	echo $DataString;
?>