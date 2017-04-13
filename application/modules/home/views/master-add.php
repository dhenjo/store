<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => $detail[0]->id_guide_master))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Privilege</label>
                  <?php 
                  $privilege = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name", TRUE, array("parent >" => 0));
                  print $this->form_eksternal->form_dropdown('id_privilege', $privilege, array($detail[0]->id_privilege), 'class="form-control input-sm"');?>
                </div>
                
                <div class="control-group">
                  <label>Note</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"');?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("pameran/transaksi/{$id_tour_pameran}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->