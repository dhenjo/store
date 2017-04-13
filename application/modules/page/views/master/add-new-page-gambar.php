<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_website_page_picture, "id_website_page" => $id_website_page))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Gambar</label>
                  <?php print $this->form_eksternal->form_upload('file', $detail[0]->file, "class='form-control input-sm'");
                  if($detail[0]->file)
                    print "<br /><img src='".base_url()."files/antavaya/page/{$detail[0]->file}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("page/master-page/gambar/{$id_website_page}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->