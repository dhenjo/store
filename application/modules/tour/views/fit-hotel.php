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
                <label>Tanggal Keberangkatan</label>
                <?php 
                if($this->session->userdata("fit_search_start"))
                  $str = $this->session->userdata("fit_search_start");
                else
                  $str = date("Y-m-d");

                if($this->session->userdata("fit_search_end"))
                  $edn = $this->session->userdata("fit_search_end");
                else
                  $edn = date("Y-m-t");
                print $this->form_eksternal->form_input('fit_search_start', $str,'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('fit_search_end', $edn,'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>
              <div class="col-xs-6">
                <label>Tour Name</label>
                <?php print $this->form_eksternal->form_input('fit_search_title', $this->session->userdata("tour_search_title"),
                  'class="form-control input-sm" placeholder="Tour Name"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Hotel</label>
                <?php print $this->form_eksternal->form_input('fit_search_hotel', $this->session->userdata("fit_search_hotel"),
                  'class="form-control input-sm" placeholder="Hotel Name"')?>
              </div>
              <div class="col-xs-6">
                <label>Ex</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_id_store_region', $store, array($this->session->userdata("fit_search_id_store_region")),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Tour Code</label>
                <?php print $this->form_eksternal->form_input('fit_search_kode', $this->session->userdata("fit_search_kode"),
                  'class="form-control input-sm" placeholder="Tour Code"')?>
              </div>
              <div class="col-xs-6">
                <label>Region</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_region', 
               array(NULL => "- Pilih -", 1 => "Europe", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"),
               array($this->session->userdata("fit_search_region")), 'class="form-control input-sm"')?>
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
            <h3 class="box-title">Tour List</h3>
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
                      <th>Validity</th>
                      <th>Tour Name & <br />
                        Hotel</th>
                      <th>Code</th>
                      <th>Days</th>
                      <th>B'Fast</th>
                      <th>TWN</th>
                      <th>SGL</th>
                      <th>X-BED</th>
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