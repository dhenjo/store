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
                    array("id_detail" => $detail[0]->id_website_group_tour))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Sub Title</label>
                  <?php print $this->form_eksternal->form_input('sub_title', $detail[0]->sub_title, 'class="form-control input-sm" placeholder="Sub Title"');?>
                </div>

                <div class="control-group">
                  <label>Summary</label>
                  <?php print $this->form_eksternal->form_input('summary', $detail[0]->summary, 'class="form-control input-sm" placeholder="Summary"');?>
                </div>
                  
                <div class="control-group">
                  <label>Price</label>
                  <?php print $this->form_eksternal->form_input('price', $detail[0]->price, 'class="form-control input-sm" placeholder="Price"');?>
                </div>

                <div class="control-group">
                  <label>Category</label>
                  <?php print $this->form_eksternal->form_dropdown('category', array(1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran"), array($detail[0]->category), 'class="form-control input-sm"');?>
                </div>

                <div class="control-group">
                  <label>Sub Category</label>
                  <?php print $this->form_eksternal->form_dropdown('sub_category', array(1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China"), array($detail[0]->sub_category), 'class="form-control input-sm"');?>
                </div>

                <div class="control-group">
                  <label>PDF</label>
                    <?php print $this->form_eksternal->form_upload('link', $detail[0]->link, "class='form-control input-sm'");
                    if($detail[0]->link)
                      print "<br /><a href='".base_url()."files/antavaya/grouptour/{$detail[0]->link}' />{$detail[0]->link}</a>";
                    ?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                    <?php print $this->form_eksternal->form_dropdown('status', array('1' => "Aktif", '2' => "Promosi", '3' => 'Draft'), array($detail[0]->status), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>Gambar</label>
                  <?php print $this->form_eksternal->form_upload('file', $detail[0]->file, "class='form-control input-sm'");
                  if($detail[0]->file)
                    print "<br /><img src='".base_url()."files/antavaya/grouptour/{$detail[0]->file}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>Gambar Thumb</label>
                  <?php print $this->form_eksternal->form_upload('file_thumb', $detail[0]->file_thumb, "class='form-control input-sm'");
                  if($detail[0]->file_thumb)
                    print "<br /><img src='".base_url()."files/antavaya/grouptour/{$detail[0]->file_thumb}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>Detail</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"')?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("grouptour/master-grouptour")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->