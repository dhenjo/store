<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Pencarian</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-3">
                <label>Tanggal Book</label>
                <?php 
                print $this->form_eksternal->form_input('fit_search_start', $this->session->userdata("fit_search_start"),
                  'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('fit_search_end', $this->session->userdata("fit_search_end"),
                  'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>
              <div class="col-xs-6">
                <label>Book Code</label>
                <?php print $this->form_eksternal->form_input('fit_search_code', $this->session->userdata("fit_search_code"),
                  'class="form-control input-sm" placeholder="Book Code"')?>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-xs-6">
                <label>FIT Code</label>
                <?php print $this->form_eksternal->form_input('fit_search_fit_code', $this->session->userdata("fit_search_fit_code"),
                  'class="form-control input-sm" placeholder="FIT Code"')?>
              </div>
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $this->session->userdata("fit_search_status");
//                if(!$stat)
//                  $stat = 1;
                print $this->form_eksternal->form_dropdown('fit_search_status', array(234 => "- Pilih -", 1 => "Book", 2 => "Request Price", 3 => "Add Price", 4 => "Confirm", 5 => "Cancel", 6 => "Departured"),
                array($stat),'class="form-control input-sm"');
                ?>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-xs-6">
                <label>Name</label>
                <?php print $this->form_eksternal->form_input('fit_search_name', $this->session->userdata("fit_search_name"),
                  'class="form-control input-sm" placeholder="Name"')?>
              </div>
              <div class="col-xs-6">
                <label>Email</label>
                <?php print $this->form_eksternal->form_input('fit_search_email', $this->session->userdata("fit_search_email"),
                  'class="form-control input-sm" placeholder="Email"')?>
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
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class="box-title">Master Tour List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <div class="widget-control pull-left">
              <span style="display: none; margin-left: 10px;" id="loader-page"><img width="35px" src="<?php print $url?>img/ajax-loader.gif" /></span>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover" id="tableboxy">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Book Code</th>
                      <th>FIT Code</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="data_list">
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div> 
        </div>
    </div>
  </div>
</div>
<div id="script-tambahan">
  
</div>