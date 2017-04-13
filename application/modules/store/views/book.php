<?php

//print "<pre>";
//print_r($data); 
//print "</pre>";
//die; 
?>
<thead>
    <tr>
        <th>Tanggal</th>
        <th>Bookers</th>
        <th>Code</th>
        <th>Name</th>
        <th>Email</th>
        <th>Telphone</th>
        <th>Status</th>
        <th>Tanggungan</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  $status = array(
    1 => "<span class='label label-warning'>Book</span>",
    2 => "<span class='label label-info'>Deposite</span>",
    3 => "<span class='label label-success'>Lunas</span>",
    4 => "<span class='label label-danger'>Cancel</span>",
    5 => "<span class='label label-danger'>Cancel Tanggungan</span>",
  );
  foreach($data AS $dt){
    $action = "<div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='".site_url('grouptour/product-tour/book-information/'.$dt->kode)."'>Detail</a></li>
              <li><a href='".site_url('store/move-bookers/'.$dt->kode)."'>Pindah TC</a></li>
              <li><a href='".site_url('store/cancel-book/'.$dt->kode)."'>Cancel Tour</a></li>
            </ul>
          </div>";
  ?>
  <tr>
    <td><?php print $dt->tanggal?></td>
    <td><?php print $dt->bookers?></td>
    <td><?php print $dt->kode?></td>
    <td><?php print $dt->first_name." ".$dt->last_name?></td>
    <td><?php print $dt->email?></td>
    <td><?php print $dt->telphone?></td>
    <td><?php print $status[$dt->status]?></td>
    <td style="text-align: right"><?php print number_format($dt->saldo)?></td>
    <td><?php print $action?></td>
  </tr>
  <?php
  }
  ?>
</tbody>
