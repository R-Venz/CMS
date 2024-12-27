<?php
  require_once("../../include/Initialize.php");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);

  //it creates a new objects of member
  $m = new Bill();
  $totalAmount=0;
  $ext = "";
  if (isset($Data->id)) {
    $ext = " AND u.id='{$Data->id}'";
  }
  echo "
    <thead>
      <tr>
        <th>Name</th>
        <th>Deceased</th>
        <th>Date</th>
        <th>Collected By</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
  ";
  $res = $m->getMemberContribution(" AND date_format(dt_paid,'%Y-%m-%d') BETWEEN '{$Data->dt1}' AND '{$Data->dt2}' " . $ext," GROUP BY c.id ORDER BY dt_paid DESC");
  foreach($res as $rs){
    echo '
      <tr>
        <td>'.strtoupper($rs->name).'</td>
        <td>'.strtoupper($rs->name2).'</td>
        <td>'.date_format(date_create($rs->dt_paid),'M d, Y').'</td>
        <td>'.strtoupper($rs->name3).'</td>
        <td>'.number_format($rs->amount,2).'</td>
      </tr>
    ';
    $totalAmount+=$rs->amount;
  }
  echo "
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><h3>".number_format($totalAmount,2)."</h3></th>
      </tr>
    </tfoot>
  ";
?>