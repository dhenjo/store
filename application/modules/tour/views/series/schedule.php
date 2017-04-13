<div class="row">
  <div class="col-xs-6">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Itin</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="box">
              <dl class="dl-horizontal">
                  <dt>Title</dt>
                  <dd><?php print $itin->title?></dd>
                  <dt>Region</dt>
                  <dd><?php 
                  $region = $this->global_variable->region();
                  print $region[$itin->sub_category];?></dd>
                  <dt>Kota Tujuan</dt>
                  <dd><?php print $itin->destination?></dd>
                  <dt>Tour Termasuk</dt>
                  <dd><?php print $itin->landmark?></dd>
                  <dt>Days</dt>
                  <dd><?php print $itin->days?> days <?php print $itin->night?> nights</dd>
              </dl>
              <div class="row">
                <div class="col-xs-6" style="text-align: right">
                  <a href="<?php print site_url("tour/tour-master")?>" class="btn btn-warning"><?php print lang("Back")?></a>
                </div>
              </div>
            </div>
          </div> 
        </div>
    </div>
  </div>
  <div class="col-xs-6">
    <div class="box box-solid box-warning collapsed-box">
        <div class="box-header">
            <h3 class="box-title">Close & Cancel</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
            </div>
            <div class="widget-control pull-left">
              <span style="display: none; margin-left: 10px;" id="loader-page"><img width="35px" src="<?php print $url?>img/ajax-loader.gif" /></span>
            </div>
        </div>
      <div class="box-body" style="display: none">
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover" id="tableboxy-close">
                  <thead>
                    <tr>
                      <th>Dep Date</th>
                      <th>Flight</th>
                      <th>Seat</th>
                      <th>Status</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div> 
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class="box-title">Schedule</h3>
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
                      <th>Dep Date</th>
                      <th>Arr Date</th>
                      <th>Flight</th>
                      <th>Avl. Seat</th>
                      <th>Conf. Seat</th>
                      <th>Adult Triple/Twin</th>
                      <th>Status</th>
                      <th>Public Sales</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
                <input style="display: none" type="text" id="nomor" value="1" />
              </div>
            </div>
          </div> 
        </div>
    </div>
  </div>
</div>