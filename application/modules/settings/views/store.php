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
                <?php print $this->form_eksternal->form_open("", 'role="form"')?>
                  <div class="box-body">
                    
                    <div class="control-group">
                      <h4>Privilege</h4>
                      <div class="input-group">
                          <?php 
                          print $this->form_eksternal->form_input("privilege", $this->global_models->get_field("m_privilege", "name", 
                            array("id_privilege" => $detail["id_privilege"])), 
                            'id="privilege" class="form-control input-sm" placeholder="Privilege"', true);
                          print $this->form_eksternal->form_input("id_privilege", $detail["id_privilege"], 
                            'id="id_privilege" style="display: none"');
                          ?>
                      </div>
										</div>
                    
                  </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>