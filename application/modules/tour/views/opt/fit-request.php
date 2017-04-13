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
              <div class="col-xs-6">
                <label>Request Date</label>
                <?php 
                if($this->session->userdata("fit_search_start"))
                  $str = $this->session->userdata("fit_search_start");
                else
                  $str = date("Y-m-01");

                if($this->session->userdata("fit_search_end"))
                  $edn = $this->session->userdata("fit_search_end");
                else
                  $edn = date("Y-m-t");
                print $this->form_eksternal->form_input('fit_search_start', $str,'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-6">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('fit_search_end', $edn,'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Project Name</label>
                <?php print $this->form_eksternal->form_input('fit_search_title', $this->session->userdata("fit_search_title"),
                  'class="form-control input-sm" placeholder="Project Name"')?>
              </div>
              <div class="col-xs-6">
                <label>Code</label>
                <?php print $this->form_eksternal->form_input('fit_search_code', $this->session->userdata("fit_search_code"),
                  'class="form-control input-sm" placeholder="Code"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Client</label>
                <?php print $this->form_eksternal->form_input('fit_search_client', $this->session->userdata("fit_search_client"),
                  'class="form-control input-sm" placeholder="Client"')?>
              </div>
              <div class="col-xs-6">
                <label>Status</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_status', array(0 => "All", 1 => "Request", 2 => "Proposal", 3 => "Book", 4 => "DP", 5 => "Cancel", 6 => "Lunas", 7 => "Quotation", 8 => "Req Timelimit", 9 => "Set Timelimit"), array($this->session->userdata("fit_search_status")),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Destination</label>
                <?php print $this->form_eksternal->form_input('fit_search_destination', $this->session->userdata("fit_search_destination"),
                  'class="form-control input-sm" placeholder="Destination"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Project Date</label>
                <?php 
                print $this->form_eksternal->form_input('fit_search_p_start', $this->session->userdata("fit_search_p_start"),'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-6">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('fit_search_p_end', $this->session->userdata("fit_search_p_end"),'class="form-control input-sm tanggal" placeholder="End Date"')?>
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
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class="box-title">Quotation Request</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <a href="<?php print site_url("tour/tour-fit/add-quotation-request")?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                      <th>Code</th>
                      <th>Client</th>
                      <th>Agent</th>
                      <th>Project Name</th>
                      <th>Project Date</th>
                      <th>Days</th>
                      <th>Destination</th>
                      <th>Status</th>
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