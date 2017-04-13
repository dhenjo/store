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
        The body of the box
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
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Tanggal")?></th>
              <th><?php print lang("TTU")?></th>
              <th><?php print lang("Rek")?></th>
              <th><?php print lang("TC")?></th>
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
            <form action="<?php print site_url("tour/tour-payment/tour-payment-cancel")?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
<!--                            <span class="input-group-addon">Note Cancel:</span>-->
                            <input name="id" class="form-control" id="id-tour-payment" style="display: none">
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