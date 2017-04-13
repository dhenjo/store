<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"')?>
              <div class="box-body">

                <div class="control-group">
                  <label>Tanggal</label>
                  <?php print $this->form_eksternal->form_input('tanggal', date("Y-m-d H:i"), 'id="tanggal" class="form-control input-sm" placeholder="Tanggal"');?>
                </div>

                <div class="control-group">
                  <label>Jenis Pembayaran</label>
                    <?php print $this->form_eksternal->form_dropdown('payment', array(1 => "Cash", 2 => "Bank Mega", 3 => "Bank BCA"), array(), 'class="form-control input-sm"')?>
                </div>
                  
                <div class="control-group">
                  <label>Saldo</label>
                  <?php print $this->form_eksternal->form_input('saldo', 0, 'id="saldo" class="form-control input-sm" placeholder="Saldo"');?>
                </div>
                  
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("flight/report-agent/{$id_users}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->