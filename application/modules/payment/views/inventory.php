<div class="row">
  <div class="col-md-12">
    <div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Search</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <?php print $this->form_eksternal->form_open();?>
        <div class="row">
            <div class="col-xs-6">
              <?php
              print $this->form_eksternal->form_input('awal', ($post['awal'] ? $post['awal'] : date("Y-m-01")),'class="form-control input-sm tanggal" placeholder="Start Date"');
              ?>
            </div>
            <div class="col-xs-6">
              <?php
//                      print $this->form_eksternal->form_dropdown("akhir", $mulai2, array(), "class='form-control input-sm'");
              print $this->form_eksternal->form_input('akhir', ($post['akhir'] ? $post['akhir'] : date("Y-m-t")),'class="form-control input-sm tanggal" placeholder="End Date"');
              ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <hr />
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
        <?php print $this->form_eksternal->form_close();?>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a href="<?php print site_url("payment/inventory-create")?>" class="btn btn-box-tool"><i class="fa fa-plus"></i></a>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Tanggal")?></th>
              <th><?php print lang("Type")?></th>
              <th><?php print lang("Title")?></th>
              <th><?php print lang("Book Code")?></th>
              <th><?php print lang("Agent")?></th>
              <th><?php print lang("Nominal")?></th>
              <th><?php print lang("Status")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="edit-keterangan-cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Note Cancel</h4>
            </div>
            <form action="<?php print site_url("payment/inventory-void")?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
<!--                            <span class="input-group-addon">Note Cancel:</span>-->
                            <input name="id" class="form-control" id="dt_id" style="display: none">
                           
                            <textarea name="note_cancel" placeholder="Note Cancel" style="margin: 0px; width: 553px; height: 227px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                    <button type="submit" class="btn btn-primary pull-left"> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
