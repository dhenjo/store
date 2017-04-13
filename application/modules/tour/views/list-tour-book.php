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
                <label>Tour Code</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $info->tour->code,'class="form-control input-sm" disabled');
                ?>
              </div>
              <div class="col-xs-3">
                <label>Tour Schedule Code</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $info->information->code,'class="form-control input-sm" disabled');
                ?>
              </div>

              <div class="col-xs-6">
                <label>Tour Schedule</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', 
                  date("d M y", strtotime($info->information->start_date))." sd ".date("d M y", strtotime($info->information->end_date)),
                  'class="form-control input-sm" disabled');
                ?>
              </div>

              <div class="col-xs-12">
                <label>Tour Name</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $info->tour->title,'class="form-control input-sm" disabled');
                ?>
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
                <label>Status</label>
                <?php print $this->form_eksternal->form_dropdown('tour_book_status',
                  array(1 => '- All -', 2 => 'Deposit', 3 => 'Lunas', 4 => 'Deposit & Lunas', 5 => 'Book'),
                  array($this->session->userdata("tour_book_status")), 'class="form-control input-sm"');?>
              </div>
              
              <div class="col-xs-3">
                <label>Store</label>
                <?php print $this->form_eksternal->form_dropdown('tour_store_real',
                  $store_dd, array($this->session->userdata("tour_store_real")), 'class="form-control input-sm"');?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <br />
              <button class="btn btn-primary" type="submit">Search</button>
              <a href="<?php print site_url("tour/list-tour-book/{$info->information->code}")?>" class="btn btn-warning">Tour Book List</a>
              <a href="<?php print site_url("tour/room-list/{$info->information->code}")?>" class="btn btn-info">Room List</a>
              <a href="<?php print site_url("tour/password-list/{$info->information->code}")?>" class="btn btn-info">Passport List</a>
              <a href="#" class="btn btn-info">Tour Leader</a>
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
                      <th>Date</th>
                      <th>Book Code</th>
                      <th>Store</th>
                      <th>Contact Person</th>
                      <th>Status</th>
                      <th>Pax</th>
                      <th>TTL Sales</th>
                      <th>Payment/Disc</th>
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
                      <th colspan="5">Total</th>
                      <th style='text-align: right'><?php print number_format($total['pax'])?></th>
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
