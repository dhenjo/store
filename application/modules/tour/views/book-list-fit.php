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
                print $this->form_eksternal->form_input('tour_search_start', $this->session->userdata("tour_search_start"),
                  'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('tour_search_end', $this->session->userdata("tour_search_end"),
                  'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>
              <div class="col-xs-6">
                <label>Tour Name</label>
                <?php print $this->form_eksternal->form_input('tour_search_title', $this->session->userdata("tour_search_title"),
                  'class="form-control input-sm" placeholder="Tour Name"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Kategori Product</label>
                <?php print $this->form_eksternal->form_dropdown('tour_search_category_product', 
                  array(NULL => "- Pilih -", 1 => "Viesta", 2 => "Premium"), array($this->session->userdata("tour_search_category_product")),
                  'class="form-control input-sm"')?>
              </div>
              <div class="col-xs-6">
                <label>Ex</label>
                <?php print $this->form_eksternal->form_dropdown('tour_search_id_store_region', $store, array($this->session->userdata("tour_search_id_store_region")),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Kota Tujuan</label>
                <?php print $this->form_eksternal->form_input('tour_search_destination', $this->session->userdata("tour_search_destination"),
                  'class="form-control input-sm" placeholder="Kota-kota Tujuan"')?>
              </div>
              <div class="col-xs-6">
                <label>Object Landmark</label>
                <?php print $this->form_eksternal->form_input('tour_search_landmark', $this->session->userdata("tour_search_landmark"),
                  'class="form-control input-sm" placeholder="Object Landmark"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $this->session->userdata("tour_master_status");
                if(!$stat)
                  $stat = 1;
                print $this->form_eksternal->form_dropdown('tour_master_status', array(0 => "- All -", 1 => "Publish", 2 => "Draft"),
                array($stat),'class="form-control input-sm"');
                ?>
              </div>
              <div class="col-xs-6">
                <label>Region</label>
                <?php print $this->form_eksternal->form_dropdown('tour_search_sub_category', 
               array(NULL => "- Pilih -", 1 => "Europe", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"),
               array($this->session->userdata("tour_search_sub_category")), 'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Tour Code</label>
                <?php print $this->form_eksternal->form_input('tour_search_kode', $this->session->userdata("tour_search_kode"),
                  'class="form-control input-sm" placeholder="Tour Code"')?>
              </div>
              <div class="col-xs-6">
                <label>Product News</label>
                <?php print $this->form_eksternal->form_input('tour_search_no_pn', $this->session->userdata("tour_search_no_pn"),
                  'class="form-control input-sm" placeholder="Product News"')?>
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