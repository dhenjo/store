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
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">Range Tanggal Book (Start)</label>
                    <?php print $this->form_eksternal->form_input('tour_start', $this->session->userdata("tour_start"),'class="form-control input-sm tanggal" placeholder="Start Date"')?>
                  </div>
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">(End)</label>
                    <?php print $this->form_eksternal->form_input('tour_end', $this->session->userdata("tour_end"),'class="form-control input-sm tanggal" placeholder="End Date"')?>
                  </div>
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">Region</label>
                    <?php print $this->form_eksternal->form_dropdown('tour_region', array(NULL => "- Pilih -", 1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"), array($this->session->userdata("tour_region")), 'class="form-control input-sm"');?>
                  </div>
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">Store</label>
                    <?php print $this->form_eksternal->form_dropdown('tour_store', $store_dd, array($this->session->userdata("tour_store")), 'class="form-control input-sm"');?>
                  </div>
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">Tour Code</label>
                    <?php print $this->form_eksternal->form_input('tour_code', $this->session->userdata("tour_code"),'class="form-control input-sm" placeholder="Tour Code"')?>
                  </div>
                  <div class="col-xs-3">
                    <label for="exampleInputPassword1">Status</label>
                    <?php print $this->form_eksternal->form_dropdown('tour_status', array(NULL => "- Pilih -", 1 => "Book", 2 => "Deposit", 3 => "Lunas", 9 => "Deposit & Lunas", 4 => "Cancel"), array($this->session->userdata("tour_status")), 'class="form-control input-sm"');?>
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
                      <th>Region</th>
                      <th>Tour Name</th>
                      <th>Book Code</th>
                      <th>TC</th>
                      <th>Status</th>
                      <th>Pax</th>
                      <th>TTL Sales</th>
                      <th>Payment</th>
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
                      <th colspan="6">Total</th>
                      <th style='text-align: right'><?php print $total['pax']?></th>
                      <th style='text-align: right'><?php print number_format($total['penjualan'])?></th>
                      <th style='text-align: right'><?php print number_format($total['deposit'])?></th>
                      <th style='text-align: right'><?php print number_format(($total['penjualan']-$total['deposit']))?></th>
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
            <h3 class="box-title">Chart Penjualan (dalam jutaan rupiah)</h3>
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
            <h3 class="box-title">Chart Penjualan Pax</h3>
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
