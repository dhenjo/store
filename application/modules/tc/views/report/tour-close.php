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
              <div class="col-xs-3">
                <label>Departure Date</label>
                <?php 
                if($this->session->userdata("tour_start"))
                  $str = $this->session->userdata("tour_start");
                else
                  $str = date("Y-m-")."01";

                if($this->session->userdata("tour_end"))
                  $edn = $this->session->userdata("tour_end");
                else
                  $edn = date("Y-m-t");
                print $this->form_eksternal->form_input('tour_start', $str,'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('tour_end', $edn,'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>

              <div class="col-xs-3">
                <label>Book Date</label>
                <?php print $this->form_eksternal->form_input('tour_book_start', $this->session->userdata("tour_book_start"),
                  'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('tour_book_end', $this->session->userdata("tour_book_end"),
                  'class="form-control input-sm tanggal" placeholder="End Date"');?>
              </div>

              <div class="col-xs-3">
                <label>Region</label>
                <?php print $this->form_eksternal->form_dropdown('tour_region', array(NULL => "- Pilih -", 1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"), array($this->session->userdata("tour_region")), 'class="form-control input-sm"');?>
              </div>
              <div class="col-xs-3">
                <label>Ex</label>
                <?php print $this->form_eksternal->form_dropdown('tour_store', $store_dd, array($this->session->userdata("tour_store")), 'class="form-control input-sm"');?>
              </div>
              <div class="col-xs-3">
                <label>Tour Code</label>
                <?php print $this->form_eksternal->form_input('tour_code', $this->session->userdata("tour_code"),'class="form-control input-sm" placeholder="Tour Code"')?>
              </div>
              <div class="col-xs-3">
                <label>Status</label>
                <?php print $this->form_eksternal->form_dropdown('tour_status', array(NULL => "- Pilih -", 1 => "Active",3 => "Cancel", 4 => "Close", 5 => "Push Selling"), array($this->session->userdata("tour_status")), 'class="form-control input-sm"');?>
              </div>
              <div class="col-xs-3" id="tour-book-status2">
                <label>Status Book</label>
                <?php print $this->form_eksternal->form_dropdown('tour_book_status2',
                  array(
                    0 => '- All -',
                    1 => 'Book',
                    5 => "Book & Deposit",
                    6 => "Book & Lunas",
                    7 => "Book & Deposit & Lunas",
                    2 => 'Deposit',
                    3 => "Lunas",
                    4 => "Deposit & Lunas",
                  ), 
                  array($this->session->userdata("tour_book_status2")), 'class="form-control input-sm" id="tour-book-status4"');?>
              </div>
              <div class="col-xs-3">
                <label>Store</label>
                <?php print $this->form_eksternal->form_dropdown('tour_store_real', $store_dd_real, array($this->session->userdata("tour_store_real")), 'class="form-control input-sm"');?>
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
                      <!--<th>No</th>-->
                      <th>Dept</th>
                      <th>Arrv</th>
                      <th>Tour Name</th>
                      <th>Region</th>
                      <th>Ex</th>
                      <th>Status</th>
                      <th>Seat</th>
                      <th>Book</th>
                      <th>DP</th>
                      <th>FP</th>
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
                      <th colspan="4">Total</th>
                      <th colspan="2" style='text-align: right'><?php print number_format(($total['all']-1))?> Tour</th>
                      <th style='text-align: right'><?php print number_format($total['open'])?></th>
                      <th style='text-align: right'><?php print number_format($total['book'])?></th>
                      <th style='text-align: right'><?php print number_format($total['deposit'])?></th>
                      <th style='text-align: right'><?php print number_format($total['lunas'])?></th>
                      <th style='text-align: right'><?php print number_format($total['penjualan'])?></th>
                      <th style='text-align: right'><?php print number_format($total['payment'])?></th>
                      <th style='text-align: right'><?php print number_format(($total['penjualan']-$total['payment']))?></th>
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
            <h3 class="box-title">Chart Penjualan Store (dalam jutaan rupiah)</h3>
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
