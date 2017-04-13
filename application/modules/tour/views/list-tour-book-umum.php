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
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover">
                  <tr>
                    <td>Tour Code</td>
                    <td><?php print $info->tour->code?></td>
                    <td>Tour Name</td>
                    <td><?php print $info->tour->title?></td>
                  </tr>
                  <tr>
                    <td>Tour Schedule Code</td>
                    <td><?php print $info->information->code?></td>
                    <td>Tour Schedule</td>
                    <td><?php print $info->information->start_date?> sd <?php print $info->information->end_date?></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><?php print $this->form_eksternal->form_dropdown("status", array(1 => '- All -', 2 => 'Deposit', 3 => 'Lunas', 4 => 'Deposit & Lunas', 5 => 'Book'), array($stat), "id='cari-status'")?></td>
                  </tr>
                  <tr>
                    <td><a href='<?php print site_url("tour/room-list-umum/{$info->information->code}")?>'>Room List</a></td>
                    <td><a href='<?php print site_url("tour/list-tour-book-umum/{$info->information->code}")?>'>Tour Book List</a></td>
                    <td><a href='<?php print site_url("tour/search")?>'>Search Product</a></td>
                    <td><a href="<?php print site_url("grouptour/product-tour/book-tour/{$info->information->code}")?>" class="btn btn-primary" type="submit">Book Now</a></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover" id="tableboxy">
                  <thead>
                    <tr>
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
                      <th colspan="4">Total</th>
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
