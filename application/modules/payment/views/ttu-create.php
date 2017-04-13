<?php
//print "<pre>";
//print_r($data);
//print "</pre>"; 

?>
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array('tanggal' => date("Y-m-d H:i:s")))?>
            
              <div class="box-body">
                <div class="control-group">
                  <label>Pameran</label>
                 <br>
                  <?php print $this->form_eksternal->form_dropdown('id_tour_pameran', $pameran, array($this->session->userdata("id_tour_pameran")), 'class="form-control input-sm select2"');?>
                </div>
                <div class="control-group">
                  <label>Remarks</label>
                 <br>
                  <?php print $this->form_eksternal->form_textarea('remark', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Nominal Bayar</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('nominal', "", 'onkeyup="FormatCurrency(this)" class="form-control input-sm" placeholder="Nominal"');?>
                </div>
              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Submit</button>
                  <a href="<?php print site_url("payment/ttu/{$id_inventory}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->