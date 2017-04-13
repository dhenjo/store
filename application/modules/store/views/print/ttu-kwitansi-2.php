<style>
  body{
    font-size: smaller;
    font-family: arial;
  }
  table{
    font-size: smaller;
  }
  .atas{
    font-weight: bold;
    font-size: small;
  }
  .biasa{
    font-size: small;
  }
</style>
<body>
  <?php
  for($p = 0 ; $p < 3 ; $p++){
  ?>
  <br>
  <br>
  <table width="100%">
    <tr>
      <td style="width: 300px">
        <img src="<?php print base_url()."themes/antavaya/images/logo.png"?>" /><br />
        <?php print $store->alamat." <br /> Telp {$store->telp} Fax {$store->fax}"?>
      </td>
      <td style="text-align: center; vertical-align: bottom">
        <h1 style="text-decoration: underline">Kwitansi</h1>
        TTU : <?php print $ttu->no_ttu?>
      </td>
    </tr>
  </table>
  <hr />
  <table width="100%">
    <tr>
      <td style="width: 200px" class="atas">Telah terima dari</td>
      <td class="biasa">: <?php print $pax->first_name." ".$pax->last_name.$pax1[1]." ".$pax1[2]?></td>
    </tr>
    <tr>
      <td class="atas">Uang Sebesar</td>
      <td class="biasa">: IDR <?php 
      $nominal = 0;
      foreach ($payment AS $pay){
        $nominal += $pay->nominal;
      }
      print number_format($nominal)?></td>
    </tr>
    <tr>
      <td class="atas">Terbilang</td>
<!--       <td class="biasa">: <?php print $this->global_variable->terbilang(number_format($nominal))?> Rupiah </td> -->
<td class="biasa">: <?php print $this->global_variable->terbilang2($nominal);?> Rupiah</td>
    </tr>
<!--    <tr>
      <td class="atas">Note</td>
      <td class="biasa" style="font-size: 10">: <?php print nl2br($ttu->remark)?></td>
    </tr>-->
  </table>
  <table width="100%">
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: right"><?php print date("d F Y")?> <br />ANTAVAYA</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td style="text-align: right">(<?php print $this->session->userdata('name'); ?>)</td>
    </tr>
  </table>
  <hr style="border-top: dotted 1px;" />
  <?php
  }
  ?>
</body>