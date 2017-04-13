<?php
if($gagal_status == 1){
?>

<div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Failed!</b> Nominal Yang Akan Dibayarkan Tidak Boleh Kosong
                </div>
<?php }elseif($gagal_status == 2){ ?>
<div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Failed!</b> Nominal Kekurangan Yang dibayarkan tidak boleh melebihi total price
                </div>
<?php } ?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
              <div class="box-body">
               
                 <br>
                  
                  
                  <div class="control-group">
                      <label>Customer Payment  [ <?php print $data[0]->first_name ?> <?php print $data[0]->last_name ?> ]</label>
                      
                  </div>
                 <?php
               
                 $price_adult = $data_tour[0]->price_adult * $data[0]->adult;
                 $price_child = $data_tour[0]->price_child * $data[0]->child;
                 $price_infant = $data_tour[0]->price_infant * $data[0]->infant;
                 
                 $total_price = $price_adult + $price_child + $price_infant;
                 $dp = (10 * $total_price)/100;
                 
                 ?> 
                  <div class="control-group">
                      
                  <table class="table">
                    <tr>
                       <th style="width: 50px;">ID</th>
                       <th>Pos</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    <?php
                 $no = 1;
             foreach ($data_payment as $value) {
                 
                 if($value->pos == 1){
                     $pos = "Kredit";
                 }elseif($value->pos == 2){
                     $pos = "Debet";
                 }
                 $total_payment += $value->nominal;
                 
                 if($value->status == 1){
                     $status = "Book";
                 }elseif($value->status == 2){
                     $status = "DP";
                 }elseif($value->status == 3){
                     $status = "Lunas";
                 }
                 $date = date('d M Y H:i:s', strtotime($value->tanggal));
                  print "<tr>";
                  print "<td>".$value->id_product_tour_book."</td>";
                  print "<td>".$pos."</td>";
                  print "<td>".  number_format($value->nominal, 0, ".", ",")."</td>";
                  print "<td>".$status."</td>";
                  print "<td>".$date."</td>";
                 print "</tr >";
                 }
                 $kekurangan = $total_price - $total_payment;
                 ?>
                    
                    <tr>
                        <td colspan="2"><center><b>Total Payment</b></center></td>
                  <td colspan="3"><b><?php print number_format($total_payment, 0, ".", ",") ?></b></td>
                        
                    </tr>
                    <tr>
                        <td colspan="2"><center><b>Total Price</b></center></td>
                        <td colspan="3"><b><?php print number_format($total_price,0,".",",") ?></b></td>
                        
                    </tr>
                    <tr>
                        <td colspan="2"><center><b>Kekurangan</b></center></td>
                        <td colspan="3"><b><?php print number_format($kekurangan,0,".",",") ?></b></td>
                        
                    </tr>
                    </table>
                </div>
                  <br>
                  <br>
               <?php
               if($data[0]->status != 3){
               ?>
                   <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => $data[0]->id_product_tour_book))?>
              <div class="box-body">
                  <div class="control-group">
                  <label>Nominal Yang Akan Dibayarkan</label><br>
                  <?php print $this->form_eksternal->form_input('nominal',$nominal, ' style="width:30%" class="form-control input-sm" placeholder="Nominal Yang Akan Dibayarkan"');?>
                  <?php print $this->form_eksternal->form_hidden('total_price',$total_price, ' style="width:30%" class="form-control input-sm" placeholder="total_price"');?>
                  <?php print $this->form_eksternal->form_hidden('total_payment',$total_payment, ' style="width:30%" class="form-control input-sm" placeholder="total_payment"');?>
                  <?php print $this->form_eksternal->form_hidden('dp',$dp, ' style="width:30%" class="form-control input-sm" placeholder="dp"');?>
                
                  </div>
              </div>
                 <div class="box-footer">
              <center>    <button class="btn btn-primary" type="submit">Payment</button> </center>
                  </div>
                 </form>
                <?php } ?>  
                  </div>
              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->