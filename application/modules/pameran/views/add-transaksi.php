<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => $detail[0]->id_tour_pameran))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Name TTU</label>
                  <?php print $this->form_eksternal->form_input('name', $detail[0]->title, 'class="form-control input-sm" placeholder="TTU"');?>
                </div>

                <div class="control-group">
                  <label>No TTU</label>
                  <?php print $this->form_eksternal->form_input('no', $detail[0]->title, 'class="form-control input-sm" placeholder="Nomor"');?>
                </div>

                <div class="control-group">
                  <label>Tanggal</label>
                  <?php print $this->form_eksternal->form_input('tanggal', date("Y-m-d"), 'class="form-control input-sm tanggal" placeholder="Tanggal"');?>
                </div>

                <div class="control-group">
                  <label>Type</label>
                  <?php print $this->form_eksternal->form_dropdown('type', array(
                    2 => "Tiket Maskapai",
                    3 => "Voucher Hotel",
                    4 => "Tiket Kerata Api",
                    9 => "Lainnya",
                  ), array($detail[0]->type), 'class="form-control input-sm"');?>
                </div>

                <div class="control-group">
                  <label>Payment Type</label>
                  <?php 
                  print $this->form_eksternal->form_dropdown('payment', array(
                    1 => "Cash",
                    2 => "BCA",
                    3 => "Mega",
                    4 => "Mandiri",
                    5 => "CC"
                  ), array($detail[0]->payment), 'class="form-control input-sm"');?>
                </div>
                
                <div class="control-group">
                  <label>Nominal</label>
                  <?php print $this->form_eksternal->form_input('nominal', $detail[0]->title, 'class="form-control input-sm harga" placeholder="Nominal"');?>
                </div>
                
                <div class="control-group">
                  <label>Note</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm"');?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("pameran/transaksi/{$id_tour_pameran}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->