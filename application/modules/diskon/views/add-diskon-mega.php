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
                    array("id_detail" => $detail[0]->id_website_hemat_mega))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Diskon</label>
                  <?php print $this->form_eksternal->form_input('diskon', $detail[0]->hemat, 'class="form-control input-sm" placeholder="Diskon"');?>
                </div>

                <div class="control-group">
                  <label>Diskon Nominal</label>
                  <?php print $this->form_eksternal->form_input('nilai', $detail[0]->nilai, 'class="form-control input-sm" placeholder="Diskon Nominal"');?>
                </div>

                <div class="control-group">
                  <label>Time Start</label>
                  <?php print $this->form_eksternal->form_input('waktumulai', $detail[0]->waktumulai, 'class="form-control input-sm" placeholder="Waktu Mulai"');?>
                </div>

                <div class="control-group">
                  <label>Time End</label>
                  <?php print $this->form_eksternal->form_input('waktuselesai', $detail[0]->waktuselesai, 'class="form-control input-sm" placeholder="Waktu Selesai"');?>
                </div>

                <div class="control-group">
                  <label>Start</label>
                  <?php print $this->form_eksternal->form_input('periodestart', $detail[0]->mulai, 
                    'id="start_date" class="form-control input-sm" placeholder="Periode Start"');?>
                </div>

                <div class="control-group">
                  <label>End</label>
                  <?php print $this->form_eksternal->form_input('periodeend', $detail[0]->akhir, 
                    'id="end_date" class="form-control input-sm" placeholder="Periode End"');?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Aktif", '2' => "Draft"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>
                  
                <div class="control-group">
                  <label>Detail</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"')?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("diskon/diskon-mega")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->