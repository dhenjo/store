<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => $detail[0]->id_tour_pameran))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Code</label>
                  <?php print $this->form_eksternal->form_input('code', $detail[0]->kode, 'class="form-control input-sm" placeholder="Code"');?>
                </div>

                <div class="control-group">
                  <label>Start</label>
                  <?php print $this->form_eksternal->form_input('date_start', $detail[0]->date_start, 'class="form-control input-sm tanggal" placeholder="Start"');?>
                </div>

                <div class="control-group">
                  <label>End</label>
                  <?php print $this->form_eksternal->form_input('date_end', $detail[0]->date_end, 'class="form-control input-sm tanggal" placeholder="End"');?>
                </div>

                <div class="control-group">
                  <label>Location</label>
                  <?php print $this->form_eksternal->form_input('location', $detail[0]->location, 'class="form-control input-sm" placeholder="Location"');?>
                </div>

                <div class="control-group">
                  <label>Status</label>
                  <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Active", 2 => "Non Active"), array($detail[0]->status), 'class="form-control"')?></td>
                </div>  

                <div class="control-group">
                  <label>Note</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" placeholder="Note"');?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("tour/pameran/master")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->