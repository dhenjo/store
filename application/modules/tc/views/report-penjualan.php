<?php

//print "<pre>";
//print_r($data); 
//print "</pre>";
//die; 

//print $before_table;
?>


<thead>
    <tr>
      <th>TC</th>
      <th>Store</th>
      <th>Tanggal</th>
      <th>Nama Tour</th>
      <th>Kode Book</th>
      <th>Nama Pemesan </th>
      <th>Beban Biaya </th>
      <th>Pembayaran </th>
      <th>Tanggungan </th>
    </tr>
</thead>
<tbody>
  <?php
   if($data->status == 2){
   
    foreach ($data->book as $key => $value) {
     $beban_biaya = $value->beban - $value->potongan;
     $beban_biaya_all += $beban_biaya;
     $tanggungan = $value->beban - ($value->potongan + $value->pembayaran);
     $pembayaran_all += $value->pembayaran;
     $tanggungan_all += $tanggungan; 
      if($value->currency == "IDR"){
        $nom_idr = $value->nominal;
        $nom_idr_tot += $value->nominal;
      }elseif($value->currency == "USD"){
        $nom_usd = $value->nominal;
        $nom_usd_tot += $value->nominal;
      }
        
      print '
      <tr>
      <td>'.$value->tc.'</td>
        <td>'.$value->store.'</td>
        <td>'.date("Y-m-d H:i:s", strtotime($value->tanggal)).'</td>
        <td>'.$value->tour.'</td>
        <td>'.$value->code.'</td>
        <td>'.$value->first_name.' '.$value->last_name.'</td>
        <td>'.number_format($beban_biaya,0,".",",").'</td>
        <td>'.number_format($value->pembayaran,0,".",",").'</td>
        <td>'.number_format($tanggungan,0,".",",").'</td>
         </tr>';
//      $total['harga_tiket'] += $value->harga_bayar + $value->diskon;
//      $total['diskon'] += $value->diskon;
//      $total['uang_terima'] += ($value->harga_bayar);
//      $r++;
    }
  }
  ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="6" style="text-align: center"><b>TOTAL</b></td>
        <td style="text-align: right"><b><?php print number_format($beban_biaya_all,0,".",",")?></b></td>
        <td style="text-align: right"><b><?php print number_format($pembayaran_all,0,".",",")?></b></td>
        <td style="text-align: right"><b><?php print number_format($tanggungan_all,0,".",",")?></b></td>
    </tr>
</tfoot>
