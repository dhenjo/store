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
                    array("id_detail" => $detail[0]->id_website_haji))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Sub Title</label>
                  <?php print $this->form_eksternal->form_input('sub_title', $detail[0]->sub_title, 'class="form-control input-sm" placeholder="Sub Title"');?>
                </div>

<!--                <div class="control-group">
                  <label>Link</label>
                    <?php print $this->form_eksternal->form_input("link", $detail[0]->link, 'class="form-control" placeholder="Link"');?>
                </div>-->

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Aktif", '2' => "Draft"), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>Gambar</label>
                  <?php print $this->form_eksternal->form_upload('file', $detail[0]->file, "class='form-control input-sm'");
                  if($detail[0]->file)
                    print "<br /><img src='".base_url()."files/antavaya/haji/{$detail[0]->file}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>Gambar Temp</label>
                  <?php print $this->form_eksternal->form_upload('file_temp', $detail[0]->file_temp, "class='form-control input-sm'");
                  if($detail[0]->file_temp)
                    print "<br /><img src='".base_url()."files/antavaya/haji/{$detail[0]->file_temp}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>File PDF</label>
                  <?php print $this->form_eksternal->form_upload('file_pdf', $detail[0]->file_pdf, "class='form-control input-sm'");
                  if($detail[0]->file_pdf)
                    print "<br /><a href='".base_url()."files/antavaya/haji/{$detail[0]->file_pdf}' />{$detail[0]->file_pdf}</a>";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>Detail</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"')?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("haji/master-haji")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->