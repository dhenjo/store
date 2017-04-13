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
                <label>Tanggal Keberangkatan</label>
                <?php 
                print $this->form_eksternal->form_input('fit_search_tanggal', $this->session->userdata("fit_search_tanggal"),
                  'class="form-control input-sm tanggal" placeholder="Tanggal"');?>
              </div>
              <div class="col-xs-6">
                <label>Tour Code</label>
                <?php print $this->form_eksternal->form_input('fit_search_kode', $this->session->userdata("fit_search_kode"),
                  'class="form-control input-sm" placeholder="Tour Code"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Stars</label>
                <?php print $this->form_eksternal->form_dropdown('fit_search_stars', array(NULL => "- All -", 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, ),
                  array($this->session->userdata("fit_search_stars")), 'class="form-control input-sm"')?>
              </div>
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $this->session->userdata("fit_search_status");
//                if(!$stat)
//                  $stat = 1;
                print $this->form_eksternal->form_dropdown('fit_search_status', array(0 => "- All -", 1 => "Publish", 2 => "Draft"),
                array($stat),'class="form-control input-sm"');
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Hotel</label>
                <?php print $this->form_eksternal->form_input('fit_search_hotel', $this->session->userdata("fit_search_hotel"),
                  'class="form-control input-sm" placeholder="Hotel"')?>
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
                <a href="<?php print site_url("tour/tour-master/add-schedule-fit/{$kode}")?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i></a>
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
                      <th>Validity</th>
                      <th>Code</th>
                      <th>Hotel</th>
                      <th>Stars</th>
                      <th>Days/Nights</th>
                      <th>B'Fast</th>
                      <th>TWN</th>
                      <th>SGL</th>
                      <th>X-BED</th>
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
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
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