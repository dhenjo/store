<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => $detail[0]->id_master_sub_agent))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control input-sm" placeholder="Name"');?>
                </div>

                <div class="control-group">
                  <label>PIC</label>
                  <?php print $this->form_eksternal->form_input('pic', $detail[0]->pic, 'class="form-control input-sm" placeholder="PIC"');?>
                </div>

                <div class="control-group">
                  <label>Email</label>
                  <?php print $this->form_eksternal->form_input('email', $detail[0]->email, 'class="form-control input-sm" placeholder="Email"');?>
                </div>

                <div class="control-group">
                  <label>Telp</label>
                  <?php print $this->form_eksternal->form_input('telp', $detail[0]->telp, 'class="form-control input-sm" placeholder="Telp"');?>
                </div>

                <div class="control-group">
                  <label>Alamat</label>
                  <?php print $this->form_eksternal->form_textarea('alamat', $detail[0]->alamat, 'class="form-control input-sm" placeholder="Alamat"');?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                  <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Aktif", 2 => "Draft"), array($detail[0]->status), 'class="form-control input-sm"');?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("subagent/subagent-master")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->