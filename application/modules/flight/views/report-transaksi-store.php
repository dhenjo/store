<?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => ""))?>
<div class="box-body col-sm-6">

      <div class="control-group">
        <label>Start Date</label>
        <?php print $this->form_eksternal->form_input('booking_from', $this->session->userdata('flight_report_transaksi_store_booking_from'), 
        'id="start_date" class="form-control input-sm" placeholder="Start Date"');?>      
      </div>

      <div class="control-group">
        <label>Book Code</label>
        <?php print $this->form_eksternal->form_input('book_code', $this->session->userdata('flight_report_transaksi_store_book_code'), 'class="form-control" placeholder="Book Code"')?>
      </div>
      
    </div>

<div class="box-body col-sm-6" >

      <div class="control-group">
          <label>End Date</label>
        <?php print $this->form_eksternal->form_input('booking_to', $this->session->userdata('flight_report_transaksi_store_booking_to'), 
        'id="end_date" class="form-control input-sm" placeholder="End Date"');?>
      </div>

      
    </div>

<!--<div class="box-body col-sm-6"></div>-->

      
         
<!--      <div class="control-group" style="margin-top: 50%;">
        
    </div>-->
<div class="box-footer col-sm-12">
      <div class="control-group">
        <button class="btn btn-primary" type="submit">Search</button> 
      </div>
</div>
</form>
<br />

<?php
if($this->uri->segment(3) == 1){
    $sort = 2;
}elseif($this->uri->segment(3) == 2){
    $sort = 1;
}else{
    $sort = 1;
}
?>

<thead>
    <tr>
        <th><a href="<?php print site_url("flight/report-transaksi-store/$sort/1")?>">Tanggal Book</a></th>
        <th>Book Code</th>
        <th>Tiket No</th>
        <th><a href="<?php print site_url("flight/report-transaksi-store/$sort/2")?>">Harga Tiket</a></th>
        <th><a href="<?php print site_url("flight/report-transaksi-store/$sort/6")?>">HPP</a></th>
        <th>Rugi/Laba</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $r = date("Y-m-d");
    $detail_harga = "";
    $total = array();
    foreach ($data as $key => $value) {
      $hemat_mega = 0;
      if(substr($value->cara_bayar, 0, 4) == "MEGA"){
        $mega = $this->global_models->get("website_hemat_mega", array("id_website_hemat_mega" => $value->id_website_hemat_mega));
        $hn = ($value->price+$value->child)-$value->infant;
        if($mega[0]->hemat > 0)
          $hemat_mega = ceil($hn * $mega[0]->hemat/100);
        else if($mega[0]->nilai > 0)
          $hemat_mega = $mega[0]->nilai;
//        $hemat_mega = $hn;
//        $hemat_mega = ceil($hn - $hemat_mega);
      }
      print '
      <tr>
        <td>'.date("Y-m-d H:i:s", strtotime($value->tanggal)).'</td>
        <td>
          '.$value->book_code.' '.$value->book2nd.'
        </td>
        <td>'.$value->tiket_no.'</td>
        <td style="text-align: right">'.number_format(($value->harga_bayar),0,",",".").'</td>
        <td style="text-align: right">'.number_format(($value->hpp+$value->hpp2nd),0,",",".").'</td>
        <td style="text-align: right">'.number_format((($value->harga_bayar)-($value->hpp+$value->hpp2nd)),0,",",".").'</td>
      </tr>';
      $total['uang_terima'] += ($value->harga_bayar);
      $total['hpp'] += ($value->hpp+$value->hpp2nd);
      $total['rugilaba'] += (($value->harga_bayar)-($value->hpp+$value->hpp2nd));
      $r++;
    }
  }
  ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="3" style="text-align: center"><b>TOTAL</b></td>
        <td style="text-align: right"><b><?php print number_format($total['uang_terima'],0,",",".")?></b></td>
        <td style="text-align: right"><b><?php print number_format($total['hpp'],0,",",".")?></b></td>
        <td style="text-align: right"><b><?php print number_format($total['rugilaba'],0,",",".")?></b></td>
    </tr>
</tfoot>