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
                      array("id_detail" => $detail[0]->id_menu))?>
                  <div class="box-body">
                    <div class="form-group">
                      <label class="control-label">Name</label>
                      <?php print $this->form_eksternal->form_input('name', $detail[0]->name, 'class="form-control" placeholder="Name"')?>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Link</label>
                      <?php print $this->form_eksternal->form_input('link', $detail[0]->link, 'class="form-control" placeholder="Link"')?>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Parent</label>
                      <?php print $this->form_eksternal->form_dropdown('parent', $kate, $detail[0]->parent, 'class="form-control" placeholder="Parent"')?>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Sort</label>
                      <?php print $this->form_eksternal->form_input('sort', $detail[0]->sort, 'class="form-control" placeholder="Sort"')?>
                    </div>
                    <div class="form-group">
                      <label class="control-label">Icon</label>
                      <?php print $this->form_eksternal->form_input('icon', $detail[0]->icon, 'class="form-control" placeholder="Icon"')?>
                    </div>
                  </div>
                  <div class="box-footer">
                      <button class="btn btn-primary" type="submit">Save changes</button>
                      <a href="<?php print site_url("menu")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
                  </div>
                </form>
            </div><!-- /.box -->
        </div><!--/.col (left) -->
    </div>   <!-- /.row -->
</section>