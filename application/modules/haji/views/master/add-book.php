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
                    array("id_detail" => $detail[0]->id_website_haji_book, "id_website_haji" => $detail[0]->id_website_haji))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Nama</label>
                  <?php print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control input-sm" placeholder="Name"');?>
                </div>

                <div class="control-group">
                  <label>Email</label>
                  <?php print $this->form_eksternal->form_input('email', $detail[0]->email, 'class="form-control input-sm" placeholder="Email"');?>
                </div>

                <div class="control-group">
                  <label>Telephone</label>
                  <?php print $this->form_eksternal->form_input('telp', $detail[0]->telp, 'class="form-control input-sm" placeholder="Telephone"');?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Proses", '2' => "Deal", 3 => "Cancel"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>
                  
                <div class="control-group">
                  <label>Detail</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"')?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("haji/master-haji/book")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->