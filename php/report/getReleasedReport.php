<?php
  require_once("../../include/Initialize.php");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);

  //it creates a new objects of member
  $m = new Bill();
  $totalAmount=0;
  echo "
    <thead>
      <tr>
        <th>Deceased</th>
        <th>Type</th>
        <th>Purpose</th>
        <th>Receiver</th>
        <th>Released By</th>
        <th>Date</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
  ";
  $res = $m->getMemberReleased(" AND date_format(r.dt,'%Y-%m-%d') BETWEEN '{$Data->dt1}' AND '{$Data->dt2}'","GROUP BY r.id ORDER BY r.dt DESC");
  foreach($res as $rs){
    echo '
      <tr>
        <td>'.strtoupper($rs->name).'</td>
        <td>'.strtoupper($rs->type).'</td>
        <td>'.strtoupper($rs->purpose).'</td>
        <td>'.strtoupper($rs->receiver).'</td>
        <td>'.strtoupper($rs->name2).'</td>
        <td>'.date_format(date_create($rs->dt),'M d, Y').'</td>
        <td>'.number_format($rs->amt,2).'</td>
      </tr>
    ';
    $totalAmount+=$rs->amt;
  }
  echo "
    </tbody>
    <tfoot>
      <tr>
        <th colspan=6></th>
        <th><h3>".number_format($totalAmount,2)."</h3></th>
      </tr>
    </tfoot>
  ";
?>