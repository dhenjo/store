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
                print $this->form_eksternal->form_input('tour_code', $data->tour->code_tour,'class="form-control input-sm" disabled');
                ?>
              </div>
              <div class="col-xs-3">
                <label>Tour Schedule Code</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $data->tour->code_schedule,'class="form-control input-sm" disabled');
                ?>
              </div>

              <div class="col-xs-6">
                <label>Tour Schedule</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', 
                  date("d M y", strtotime($data->tour->start_date))." sd ".date("d M y", strtotime($data->tour->end_date)),
                  'class="form-control input-sm" disabled');
                ?>
              </div>

              <div class="col-xs-9">
                <label>Tour Name</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $data->tour->title,'class="form-control input-sm" disabled');
                ?>
              </div>
              
              <div class="col-xs-3">
                <label>Seats</label>
                <?php 
                print $this->form_eksternal->form_input('tour_code', $data->tour->seats,'class="form-control input-sm" disabled');
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
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <br />
              <button class="btn btn-primary" type="submit">Search</button>
              <a href="<?php print site_url("tour/list-tour-book/{$data->tour->code_schedule}")?>" class="btn btn-info">Tour Book List</a>
              <a href="<?php print site_url("tour/room-list/{$data->tour->code_schedule}")?>" class="btn btn-warning">Room List</a>
              <a href="<?php print site_url("tour/password-list/{$data->tour->code_schedule}")?>" class="btn btn-info">Passport List</a>
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

<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
<!--<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">-->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Pax</h4>
            </div>
            <form action="<?php print site_url("tour/edit-book-pax")?>" method="post">
              <div class="box-body" style="padding: 10px !important">
                <div class="form-group">
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('first_name', "", 'id="edit-first-name" class="form-control input-sm" placeholder="Nama Depan"');
                      print $this->form_eksternal->form_input('code', "", "id='edit-code' style='display: none'");
                      print $this->form_eksternal->form_input('book_code', "", "id='edit-book-code' style='display: none'");
                      print $this->form_eksternal->form_input('visa', "", 'id="edit-visa" style="display: none"');
                      print $this->form_eksternal->form_input('less_ticket', "", 'id="edit-less-ticket" style="display: none"');
                      print $this->form_eksternal->form_input('room', "", 'id="edit-room" style="display: none"');
                      print $this->form_eksternal->form_input('type', "", 'id="edit-type" style="display: none"');
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('last_name', "", 'id="edit-last-name" class="form-control input-sm" placeholder="Nama Belakang"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('telp', "", 'class="form-control input-sm" id="edit-telp" placeholder="No Telp"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Room No</label>
                      <?php print $this->form_eksternal->form_input('room_no', "", 'id="edit-room" class="form-control input-sm" placeholder="Room"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Tempat Lahir</label>
                      <?php print $this->form_eksternal->form_input('tempat_lahir', "", 'id="edit-tempat-lahir" class="form-control input-sm" placeholder="Place Of Birth"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Tanggal Lahir</label>
                      <?php print $this->form_eksternal->form_input('tanggal_lahir', "", 'id="edit-tanggal-lahir" class="form-control input-sm child_date" placeholder="Tanggal Lahir"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Passport</label>
                      <?php print $this->form_eksternal->form_input('passport', "", 'id="edit-passport" class="form-control input-sm" placeholder="No Passport"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Place Of Issued</label>
                      <?php print $this->form_eksternal->form_input('place_of_issued', "", 'id="edit-place-of-issued" class="form-control input-sm" placeholder="Place Of Issue"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Date Of Issued</label>
                      <?php print $this->form_eksternal->form_input('date_of_issued', "", 'id="edit-date-of-issued" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Date Of Expired</label>
                      <?php print $this->form_eksternal->form_input('date_of_expired', "", 'id="edit-date-of-expired" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="edit-note" class="form-control input-sm" placeholder="Note"');?>
                    </div>
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