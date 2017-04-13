<?php


?>
<div class="row">
 <div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div><!-- /.box-header -->
    <div class="box-body">
      <table class="table table-condensed">
        <tr>
            <th style="width: 20%;">Nama Pemesan</th>
              <td><?php print $data->book->first_name." ".$data->book->last_name; ?></td><br>
          </tr>  
        <tr>
            <th style="width: 20%;">Kode Book</th>
              <td><?php print $data->book->code; ?></td><br>
          </tr>
        <tr>
              <th style="width: 20%;">Tanggungan</th>
              <?php 

                  
                  if($data->book->total_visa > 0){
                    if($data->tour->information->price->currency == "USD"){
                      $total_visa = ($data->tour->information->price->visa * $data->book->total_visa) * $data->currency_rate;
                    }elseif($data->tour->information->price->currency == "IDR"){
                      $total_visa = $data->tour->information->price->visa * $data->book->total_visa;
                    }
                  }
                 
                foreach($data->payment AS $dp){
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

                ?>
              <td><?php 
           
         
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
                <div class="control-group">
                  <label>No Refund</label>
               <br>  <?php print $this->form_eksternal->form_input('no_refund', "", ' style="width:100%" class="form-control input-sm" placeholder="No Refund"');?>
                </div>
                <div class="control-group">
                  <label>Nominal</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('nominal', "", 'onkeyup="FormatCurrency(this)" class="form-control input-sm" placeholder="Nominal"');?>
                </div>
                
                <div class="control-group">
                <label>Payment Type</label>
              <?php 
              $channel = array(
                  1 => "Cash",
                  6 => "Transfer",
                );
              print $this->form_eksternal->form_dropdown('payment', $channel, "", 'class="form-control" placeholder=""');?>
            </div>
                <div class="control-group">
                  <label>Note</label>
                  <?php print $this->form_eksternal->form_textarea('note', "", 'class="form-control input-sm" ')?>
                </div>
              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Refund</button>
                  <a href="<?php print site_url("grouptour/product-tour/book-list")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->