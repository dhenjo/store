<section class="content">
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
                        array("id_detail" => $detail[0]->id_controller))?>
                  <div class="box-body">
                    
                    <div class="control-group">
                      <h4>Name</h4>
                      <div class="input-group">
                          <?php
                          print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control" placeholder="Name"');?>
                      </div>
										</div>
                    
										<div class="control-group">
                      <h4>Code</h4>
                      <div class="input-group">
                          <?php print $this->form_eksternal->form_input('link', $detail[0]->link, 'class="form-control" placeholder="Code"')?>
                      </div>
										</div>
                    
										<div class="control-group">
                      <h4>Module</h4>
                      <div class="input-group">
                        <?php print $this->form_eksternal->form_dropdown('id_module', $module, array($detail[0]->id_module), 'class="form-control"')?>
                      </div>
										</div>
                    
                  </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                      <a href="<?php print site_url("settings/control")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>