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
                        array("id_detail" => $detail[0]->id_privilege))?>
                  <div class="box-body">
                    <div class="control-group">
                      <h4>Name</h4>
                      <div class="input-group">
                          <?php 
                          $name = explode("-", $detail[0]->name);
                          if(!trim($name[1])){
                            $name[1] = $name[0];
                          }
                          print $this->form_eksternal->form_input('name', trim($name[1]), 'class="form-control" placeholder="Name"');?>
                      </div>
										</div>
                    
										<div class="control-group">
                      <h4>Dashbord</h4>
                      <div class="input-group">
                          <?php print $this->form_eksternal->form_input('dashbord', $detail[0]->dashbord, 'class="form-control" placeholder="Dashbord"')?>
                      </div>
										</div>
                    
										<div class="control-group">
                      <h4>Parent</h4>
                      <div class="input-group">
                        <?php print $this->form_eksternal->form_dropdown('parent', $dropdown[0], array($detail[0]->parent), 'class="form-control" placeholder="Parent"')?>
                      </div>
										</div>
                    
                  </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                      <a href="<?php print site_url("privilege")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>