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
                    array("code" => $code))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Store</label>
                  <?php 
                  print $this->form_eksternal->form_dropdown('id_store', $store, array(), 'id="id-store" class="form-control users"');?>
                </div>

              </div>
              <div class="box-body">

                <div class="control-group">
                  <label>Users</label>
                  <div id="users-view">
                    
                  </div>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("store/book")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->