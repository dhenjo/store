<?php
if($gagal_status == 1){
?>
<div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Failed!</b> Nominal Yang Akan Dibayarkan Tidak Boleh Kosong
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
                      <label>Book Detail</label>
                      
                  </div>
                 <?php
               
                 $total_price_inf   = $detail[0]->infant * $detail[0]->price_infant;
                 $total_price_chl   = $detail[0]->child * $detail[0]->price_child;
                 $total_price_adl   = $detail[0]->adult * $detail[0]->price_adult;
                 $total_all         = $total_price_inf + $total_price_chl + $total_price_adl;
                 $total_dp         = (($detail[0]->dp * $total_all)/100);
                 ?> 
                  <div class="control-group">
                      <table class="table">
                          <tr>
                              
                          </tr>
                          <tr>
                              <td>Nama Pemesan</td>
                              <td><?php print $detail[0]->first_name." ".$detail[0]->last_name; ?></td>
                          </tr>
                          <tr>
                              <td>No. Telp</td>
                              <td><?php print $detail[0]->telphone; ?></td>
                          </tr>
                          
                          <tr>
                              <td>Fee Adult</td>
                              <td><span><?php print $detail[0]->adult; ?></span> * <span><?php print $detail[0]->price_adult; ?></span> = <?php print number_format($total_price_adl, 0, ".", ","); ?></td>
                          </tr>
                          <?if($detail[0]->child){?>
                          <tr>
                              <td>Fee Child</td>
                              <td><span><?php print $detail[0]->child; ?></span> * <span><?php print $detail[0]->price_child; ?></span> = <?php print number_format($total_price_chl, 0, ".", ","); ?></td>
                          </tr>
                          <?php 
                          if($detail[0]->infant){ ?>
                          <tr>
                              <td>Fee Infant</td>
                              <td><span><?php print $detail[0]->infant; ?></span> * <span><?php print $detail[0]->price_infant; ?></span> = <?php print number_format($total_price_inf, 0, ".", ","); ?></td>
                          </tr>
                          <?php } ?>
                          <tr>
                              <td><b>Total Payment</b></td>
                              <td><span><b><?php print number_format($total_all, 0, ".", ","); ?></b></span></td>
                          </tr>
                         <?php if($detail[0]->dp){ ?>
                          <tr>
                              <td><b>Untuk Book Minimal DP <?php print $detail[0]->dp;?>%</b></td>
                              <td><span><b><?php print number_format($total_dp, 0, ".", ","); ?></b></span></td>
                          </tr>
                          <?php } ?>
                      </table>
                 
                </div>
                  <br>
                  <br>
                   <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_product_tour_book))?>
              <div class="box-body">
                  <div class="control-group">
                  <label>Nominal Yang Akan Dibayarkan</label><br>
                  <?php print $this->form_eksternal->form_input('nominal',"", ' style="width:30%" class="form-control input-sm" placeholder="Nominal Yang Akan Dibayarkan"');?>
                <?php print $this->form_eksternal->form_hidden('dp',$total_dp, ' style="width:30%" class="form-control input-sm" placeholder="dp"');?>
                <?php print $this->form_eksternal->form_hidden('total_all',$total_all, ' style="width:30%" class="form-control input-sm" placeholder="dp"');?>
                
                  </div>
              </div>
                 <div class="box-footer">
              <center>    <button class="btn btn-primary" type="submit">Payment</button> </center>
                  </div>
                 </form>
                  
                  </div>
              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->