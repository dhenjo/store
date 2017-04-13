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
                    <td><?php print $data->tour->code_tour?></td>
                    <td>Tour Name</td>
                    <td><?php print $data->tour->title?></td>
                  </tr>
                  <tr>
                    <td>Tour Schedule Code</td>
                    <td><?php print $data->tour->code_schedule?></td>
                    <td>Tour Schedule</td>
                    <td><?php print $data->tour->start_date?> sd <?php print $data->tour->end_date?></td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><?php print $this->form_eksternal->form_dropdown("status", array(1 => '- All -', 2 => 'Deposit', 3 => 'Lunas', 4 => 'Deposit & Lunas', 5 => 'Book'), array($status), "id='cari-status'")?></td>
                    <td>Seats</td>
                    <td><?php print $data->tour->seats?></td>
                  </tr>
                  <tr>
                      
                    <td><a href='<?php print site_url("tour/tour-inventory/room-list-umum/{$id_inventory}/{$data->tour->code_schedule}")?>'>Room List</a></td>
                    <td><a href='<?php print site_url("tour/tour-inventory/list-tour-book-umum/{$id_inventory}/{$data->tour->code_schedule}")?>'>Tour Book List</a></td>
                    <td><a href='<?php print site_url("tour/tour-inventory/search/{$id_inventory}")?>'>Search Product</a></td>
                    <td><a href="<?php print site_url("tour/tour-inventory/book-tour/{$id_inventory}/{$info->information->code}")?>" class="btn btn-primary" type="submit">Book Now</a></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover" id="tableboxy">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Book Code</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Room Type</th>
                      <th>Room No</th>
                      <th>Passport No</th>
                      <th>Passport <br /> Expired Date</th>
                      <th>Date Of <br /> Birth</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    print $data_table;
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>  
        </div>
    </div>
  </div>
</div>