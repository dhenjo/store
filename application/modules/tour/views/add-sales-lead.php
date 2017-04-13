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
                  <label>First Name</label>
                  <?php print $this->form_eksternal->form_input('first_name', "", 'class="form-control input-sm" placeholder="First Name"');?>
                </div>

                <div class="control-group">
                  <label>Last Name</label>
                  <?php print $this->form_eksternal->form_input('last_name', "", 'class="form-control input-sm" placeholder="Last Name"');?>
                </div>

                <div class="control-group">
                  <label>Email</label>
                  <?php print $this->form_eksternal->form_input('email', "", 'class="form-control input-sm" placeholder="Email"');?>
                </div>

                <div class="control-group">
                  <label>Telp</label>
                  <?php print $this->form_eksternal->form_input('telp', "", 'class="form-control input-sm" placeholder="Telp"');?>
                </div>

                <div class="control-group">
                  <label>Note</label>
                  <?php print $this->form_eksternal->form_textarea('note', "", 'class="form-control input-sm" placeholder="Note"');?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("tour/sales-lead")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->