<?php
  require_once("../../include/Initialize.php");
  $Data = file_get_contents('php://input');       
  $Data = json_decode($Data);

  //it creates a new objects of member
  $m = new Bill();
  $totalCollectible=0;
  $totalCollected=0;
  $totalContribution=0;
  $totalRelease=0;
  $totalAmount=0;
  echo "
    <thead>
      <tr>
        <th>Deceased</th>
        <th>Date of Death</th>
        <th>Cause of Death</th>
        <th>Declarant</th>
        <th>Contribution</th>
        <th>Release</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
  ";
  $res = $m->getAllReport(" AND date_format(dd.date_added,'%Y-%m-%d') BETWEEN '{$Data->dt1}' AND '{$Data->dt2}'","GROUP BY dd.id ORDER BY dd.date_added DESC");
  foreach($res as $rs){
    echo '
      <tr>
        <td>'.strtoupper($rs->name).'</td>
        <td>'.strtoupper($rs->dod).'</td>
        <td>'.strtoupper($rs->cod).'</td>
        <td>'.strtoupper($rs->name2).'</td>
        <td>
          <math>
              <msup>
                  <mn>'.number_format($rs->collected,2).'</mn>
                  <mn><b style="color:red;">('.number_format($rs->collectible).')</b></mn>
              </msup>
          </math>
        </td>
        <td>'.number_format($rs->released,2).'</td>
        <td>'.number_format(($rs->collected+$rs->collectible) - $rs->released,2).'</td>
      </tr>
    ';

    $totalCollectible +=$rs->collectible;
    $totalCollected +=$rs->collected;
    $totalContribution+=($rs->collected+$rs->collectible);
    $totalRelease+=$rs->released;
    $totalAmount+=(($rs->collected+$rs->collectible)-$rs->released);
  }
  echo "
    </tbody>
    <tfoot>
      <tr align=right>
        <th colspan=4></th>
        <th>
          <h5>".number_format($totalCollected,2)."</h5>
          <h5 style='border-bottom:solid 1px black;color:red;'>".number_format($totalCollectible,2)."</h5>
          <h4>".number_format($totalContribution,2)."</h4>
        </th>
        <th><h3>".number_format($totalRelease,2)."</h3></th>
        <th><h3>".number_format($totalAmount,2)."</h3></th>
      </tr>
    </tfoot>
  ";
?>