<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Table Report</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="row">
                  <div class="col-xs-6">
                    <label for="exampleInputPassword1">Range Tanggal Book (Start)</label>
                    <?php print $this->form_eksternal->form_input('tour_start', $this->session->userdata("tour_start"),'class="form-control input-sm tanggal" placeholder="Start Date"')?>
                  </div>
                  <div class="col-xs-6">
                    <label for="exampleInputPassword1">(End)</label>
                    <?php print $this->form_eksternal->form_input('tour_end', $this->session->userdata("tour_end"),'class="form-control input-sm tanggal" placeholder="End Date"')?>
                  </div>
                  
                  <div class="col-xs-6">
                    <label for="exampleInputPassword1">Status</label>
                    <?php 
                    $status = array(
                      NULL => "- Pilih -",
                      1 => "Request",
                      2 => "Proposal",
                      3 => "Book",
                      4 => "DP",
                      5 => "Cancel",
                      6 => "Lunas",
                      7 => "Quotation",
                      8 => "Req Timelimit",
                      9 => "Set Timellimit",
                    );
                    print $this->form_eksternal->form_dropdown('tour_status', $status, array($this->session->userdata("tour_status")), 'class="form-control input-sm"');
                    ?>
                  </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <br />
              <button class="btn btn-primary" type="submit">Search</button>
              <hr />
            </div>
          </div>
          </form>
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover" id="tableboxy">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Tour Name</th>
                      <th>Store</th>
                      <th>Status</th>
                      <th>Pax</th>
                      <th>Debit</th>
                      <th>Kredit</th>
                      <th>Balance</th>
                    </tr>
                  </thead>
                  <tbody id="data_list">
                    <?php
                    print $cetak;
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4">Total</th>
                      <th style='text-align: right'><span id="jml-pax"></span></th>
                      <th style='text-align: right'><span id="jml-debit"></span></th>
                      <th style='text-align: right'><span id="jml-kredit"></span></th>
                      <th style='text-align: right'><span id="jml-balance"></span></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>  
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-success">
        <div class="box-header">
          <h3 class="box-title"><a href='javascript: void(0)' id='gen'>Chart Penjualan Store (dalam jutaan rupiah)</a></h3>
          <div class="box-tools pull-right">
              <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div id="canvas" style="margin-top:5px; margin-left:-5px; width:100%; height:700px;"></div>
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-info">
        <div class="box-header">
          <h3 class="box-title"><a href='javascript: void(0)' id='gen'>Chart Pax</a></h3>
          <div class="box-tools pull-right">
              <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div id="canvas-pax" style="margin-top:5px; margin-left:-5px; width:100%; height:700px;"></div>
        </div>
    </div>
  </div>
</div>