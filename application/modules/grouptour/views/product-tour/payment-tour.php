<?php
//print "<pre>";
//print_r($data);
//print "</pre>"; 

?>
<div class="row">
 <div class="col-md-12">
    <div class="box">
    <div class="box-body">
      <table class="table table-condensed">
        <tr>
            <th style="width: 20%;">Nama Pemesan</th>
              <td><?php print $data->book->first_name." ".$data->book->last_name; ?></td>
          </tr>  
        <tr>
            <th style="width: 20%;">Kode Book</th>
              <td><?php print $data->book->code; ?></td>
          </tr>
        <tr>
              <th style="width: 20%;">Tanggungan</th>
              <?php 
             
//                $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                $total_debit = $total_kredit = 0;
//                if($data->tour->information->price->currency == "IDR"){
//                  $data_tax_idr = $total_person * $data->tour->information->price->tax_and_insurance;
//                 
//                }elseif($data->tour->information->price->currency == "USD"){
//                  $data_tax_idr = $total_person * $data->tour->information->price->tax_and_insurance * $data->currency_rate;
                 
//                }
            
              //  print_r($data->book->additional);
//                foreach($data->book->additional AS $add){
//                   if($add->id_currency == 1){
//                        $nom_add0_usd = $add->nominal_additional;
//                        $nom_add0_idr = $add->nominal_additional * $data->currency_rate;
//                      }elseif($add->id_currency == 2){
//                        $nom_add0_usd = $add->nominal_additional/$data->currency_rate;
//                        $nom_add0_idr = $add->nominal_additional;
//                      }
//                      if($add->pos == 1){
//                      $total_kredit2_usd += $nom_add0_usd;
//                      $total_kredit2_idr += $nom_add0_idr;
//                    }else{
//                      $total_debit2_usd += $nom_add0_usd;
//                      $total_debit2_idr += $nom_add0_idr;
//                    }
//                 
//                  }
                  
                  if($data->book->total_visa > 0){
                    if($data->tour->information->price->currency == "USD"){
                      $total_visa = ($data->tour->information->price->visa * $data->book->total_visa) * $data->currency_rate;
                    }elseif($data->tour->information->price->currency == "IDR"){
                      $total_visa = $data->tour->information->price->visa * $data->book->total_visa;
                    }
                  }
                 
                foreach($data->payment AS $dp){
                  if($dp->status != 3){
                    if($dp->currency == 1){
                          $nom1_usd = $dp->nominal;
                          $nom1_idr = $dp->nominal * $data->currency_rate;
                        }elseif($dp->currency == 2){
                          $nom1_usd = $dp->nominal/$data->currency_rate;
                          $nom1_idr = $dp->nominal;
                        }
                    if($dp->pos == 1){
                      $debit_usd = number_format($nom1_usd, 2, ".", ",");
                      $kredit_usd = "";
                      $total_debit_usd += $nom1_usd;

                      $debit_idr = number_format($nom1_idr, 2, ".", ",");
                      $kredit_idr = "";
                      $total_debit_idr += $nom1_idr;
                    }
                    else{
                      $kredit_usd = number_format($nom1_usd, 2, ".", ",");
                      $debit_usd = "";
                      $total_kredit_usd += $nom1_usd;

                      $kredit_idr = number_format($nom1_idr, 2, ".", ",");
                      $debit_idr = "";
                      $total_kredit_idr += $nom1_idr;
                    }
                  }
                }
//                $status_price1="";
//                if($data->book->status_discount == "Persen"){
//                  $status_price = $data->book->discount;
//                  $tot_disc_price1_usd =  (($total_debit_usd * $data->book->discount)/100);
//                  $tot_disc_price1_idr =  (($total_debit_idr * $data->book->discount)/100);
//                }elseif($data->book->status_discount == "Nominal") {
//                 $tot_disc_price1_usd = number_format($data->book->discount,2,".",",");
//                 $tot_disc_price1_idr = number_format($data->book->discount,2,".",",");
//                }
                
//                if($data->book->status_discount_tambahan == "Apprave"){
//                    if($data->book->st_discount_tambahan == 1){
//                          $stnb_tambahan = "[Persen]";
//                     $tot_disc_price =  (($total_debit * $data->book->discount_tambahan)/100);
//                   }elseif($data->book->st_discount_tambahan == 2) {
//                   
//                       $stnb_tambahan = "[Nominal]";
//                     $tot_disc_price = $data->book->discount_tambahan;
//                   } 
//                }
                
                ?>
              <td><?php 
           
            
            // $tot_all = (($total_debit + $total_debit2 + $data_tax + $ppn) - ($total_kredit2+$total_kredit+$tot_disc_price1));
            // $tot_all_rp = ($data->currency_rate * $tot_all);
            //  print "USD ".number_format($tot_all, 2, ".", ",")."<br>";
//              print $total_debit_idr.".<br>".$total_debit2_idr."..<br>".$data_tax_idr."...<br>".$ppn_idr."<br>";
//              print $total_kredit2_idr.".<br>".$total_kredit_idr."..<br>".$tot_disc_price1_idr."...<br>";
              $tot_all = (($total_debit_idr) - ($total_kredit_idr));
              print "IDR ".number_format($tot_all, 2, ".", ",")."<br>";
              ?>
              </td>           
            </tr>
            <?php
                if($data->payment[1]->pos < "2" AND $data->payment[1]->nominal < "1"){
                if($data->book->info_disc){
                ?>
             <tr>
                  <th>Total Customer Tour</th>
                  <td><?php print $data->book->total_customer." People"; ?></td>
                </tr>
           <tr>
            <th style="width: 20%;">Info Discount</th>
              <td><?php
                  $dt_status_disc2 = array("1" => "Persen",
                                            "2" => "Nominal");
                  $no = 1;
                        foreach ( $data->book->info_disc as $dval) {
                             $batas = ($dt_dis + 1);
                             $bts +=  $dval->batas_discount;
                            if($no == 1){
                                $dt = "Pertama";
                                $batas_all = $dval->batas_discount;
                                $dt_dis = $dval->batas_discount;
                            }else{
                                $dt = "Selanjutnya";
                                $batas_all = $batas." - ".$bts;
                               
                            }
                            print "Untuk ".$batas_all." Orang Deposit {$dt} Akan mendapatkan discount ".$dval->discount." ".$dt_status_disc2[$dval->status_discount]."<br>";
                            $dt_dis = $bts;
                            $no++;
                            }
                  ?></td>
          </tr>
          <?php } } ?>
        </table>
    </div>
    </div>
  </div>
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("book_code" => $book_code, 'tanggal' => date("Y-m-d H:i:s"), 'currency' => 2))?>
              <div class="box-body">
<!--                <div class="control-group">
                  <label>No TTU</label>
               <br>  <?php print $this->form_eksternal->form_input('no_ttu', "", ' style="width:100%" class="form-control input-sm" placeholder="No TTU"');?>
                </div>
                <div class="control-group">
                  <label>No Deposit</label>
               <br>  <?php print $this->form_eksternal->form_input('no_deposit', "", ' style="width:100%" class="form-control input-sm" placeholder="No Deposit"');?>
                </div>-->
                <div class="control-group">
                  <label>Pameran</label>
                 <br>
                  <?php print $this->form_eksternal->form_dropdown('id_tour_pameran', $pameran, array($this->session->userdata("id_tour_pameran")), 'class="form-control input-sm select2"');?>
                </div>
                <div class="control-group">
                  <label>Remark</label>
                 <br>
                  <?php print $this->form_eksternal->form_textarea('remark', "", array(), 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Nominal</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('nominal', "", 'onkeyup="FormatCurrency(this)" class="form-control input-sm" placeholder="Nominal"');?>
                </div>
                
<!--                <div class="control-group">
                <label>Payment Type</label>
              <?php 
              $channel = array(
                  1 => "Cash",
                  2 => "BCA",
                  3 => "Mega",
                  4 => "Mandiri",
                  5 => "CC"
                );
              print $this->form_eksternal->form_dropdown('payment', $channel, "", 'class="form-control" placeholder="Flight"');?>
            </div>-->
      
              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Payment</button>
                  <a href="<?php print site_url("grouptour/product-tour/book-information/{$data->book->code}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->