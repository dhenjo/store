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
                  <label>First Name</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('first_name', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Last Name</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('last_name', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Telp</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('telp', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                
                <div class="control-group">
                  <label>Alamat</label>
                 <br>
                  <?php print $this->form_eksternal->form_textarea('alamat', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Title</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('title', $data->book->title, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Code</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('kode', $data->book->remark, 'class="form-control input-sm"');?>
                </div>
                <div class="control-group">
                  <label>Type</label>
                 <br>
                  <?php print $this->form_eksternal->form_dropdown('type', array(1 => "Tiket", 2 => "Hotel", 3 => "Tour", 4 => "Umroh", 5 => "Transport"), array(), 'class="form-control input-sm select2"');?>
                </div>
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
                  <label>Nominal Inventory</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('harga', "", 'onkeyup="FormatCurrency(this)" class="form-control input-sm" placeholder="Nominal"');?>
                </div>
                <div class="control-group">
                  <label>Nominal Bayar</label>
                 <br>
                  <?php print $this->form_eksternal->form_input('nominal', "", 'onkeyup="FormatCurrency(this)" class="form-control input-sm" placeholder="Nominal"');?>
                </div>
              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Submit</button>
                  <a href="<?php print site_url("payment/inventory")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->