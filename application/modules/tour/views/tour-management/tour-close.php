<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Tour List</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
      <?php
      print $this->form_eksternal->form_open();
      ?>
        <div class="box-body">
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <div class="row">
                    <div class="col-xs-6">
                      <?php
                      print $this->form_eksternal->form_input('awal', $awal,'class="form-control input-sm tanggal" placeholder="Start Date"');
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <?php
//                      print $this->form_eksternal->form_dropdown("akhir", $mulai2, array(), "class='form-control input-sm'");
                      print $this->form_eksternal->form_input('akhir', $akhir,'class="form-control input-sm tanggal" placeholder="Start Date"');
                      ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                      <hr />
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
              </div>
            </div>
          </div> 
        </div>
      <?php
      print $this->form_eksternal->form_close();
      ?>
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
                      <th>No</th>
                      <th style="width: 400px">Group</th>
                      <th>Dep Date</th>
                      <th>T. Pax</th>
                      <th>Airline</th>
                      <?php
                      foreach($store AS $st){
                        print "<th>{$st->title}</th>";
                        $foot .= "<th><span id='store{$st->id_store}'>0</span><br /><span id='store-tharga{$st->id_store}'>0</span></th>";
                      }
                      ?>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">
                        TOTAL
                      </th>
                      <?php print $foot;?>
                    </tr>
                  </tfoot>
                </table>
                <input style="display: none" type="text" id="nomor" value="1" />
              </div>
            </div>
          </div> 
        </div>
    </div>
  </div>
</div>