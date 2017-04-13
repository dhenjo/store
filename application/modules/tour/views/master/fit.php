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
                <label>Code</label>
                <?php 
                print $this->form_eksternal->form_input('fit_search_code', $this->session->userdata("fit_search_code"),
                  'class="form-control input-sm" placeholder="Code"');?>
              </div>
              <div class="col-xs-6">
                <label>Tour Name</label>
                <?php print $this->form_eksternal->form_input('fit_search_title', $this->session->userdata("fit_search_title"),
                  'class="form-control input-sm" placeholder="Tour Name"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>EX</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_ex', $store, 
                  array($this->session->userdata("fit_search_ex")), 'class="form-control input-sm"')?>
              </div>
              <div class="col-xs-6">
                <label>Region</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_region', array(NULL => "- Pilih -", 1 => "Europe", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"), array($this->session->userdata("fit_search_region")),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $this->session->userdata("fit_search_status");
                if(!$stat)
                  $stat = 1;
                print $this->form_eksternal->form_dropdown('fit_search_status', array(1 => "Publish", 2 => "Draft"),
                array($stat),'class="form-control input-sm"');
                ?>
              </div>
              <div class="col-xs-6">
                <label>Destination</label>
                <?php print $this->form_eksternal->form_input('fit_search_destination', $this->session->userdata("fit_search_destination"),
                  'class="form-control input-sm" placeholder="Destination"')?>
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
                <a href="<?php print site_url("tour/tour-master/add-fit")?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                      <th>&nbsp;</th>
                      <th>Code</th>
                      <th>Tour Name</th>
                      <th>Ex</th>
                      <th>Region</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="data_list">
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3">
                        <button type='button' class='btn btn-warning btn-flat'>Set Draft</button>
                        <button type='button' class='btn btn-danger btn-flat'>Delete</button>
                      </td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
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
<div id="script-tambahan">
  
</div>