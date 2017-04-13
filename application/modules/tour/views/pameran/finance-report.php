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
                      <label>Tanggal</label>
                      <?php
                      print $this->form_eksternal->form_input('awal', $awal,'class="form-control input-sm tanggal" placeholder="Start Date"');
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label>&nbsp;</label>
                      <?php
                      print $this->form_eksternal->form_input('akhir', $akhir,'class="form-control input-sm tanggal" placeholder="Start Date"');
                      ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                      <label>Pameran</label>
                      <?php
                      print $this->form_eksternal->form_dropdown("id_tour_pameran", $pameran, array($detail['id_tour_pameran']), "class='form-control input-sm select2'");
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label>Branch</label>
                      <?php
                      print $this->form_eksternal->form_dropdown("id_store", $store, array($detail['id_store']), "class='form-control input-sm select2'");
                      ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                      <hr />
                      <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                    <div class="col-xs-6">
                      <hr />
                      <button class="btn btn-primary" type="submit" name="sbt" value="xls">Export</button>
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
                      <th rowspan="2">No</th>
                      <th rowspan="2">Date</th>
                      <th rowspan="2">No TTU</th>
                      <th rowspan="2">Booking<br />Code</th>
                      <th rowspan="2">Branch</th>
                      <th rowspan="2">Pax Name</th>
                      <th rowspan="2">Deposit</th>
                      <th rowspan="2">Tunai</th>
                      <th colspan="3">Transfer</th>
                      <th colspan="6">Credit Card</th>
                      <th colspan="3">Debit Card</th>
                      <th colspan="5">Others</th>
                      <th rowspan="2">Handle By</th>
                      <th rowspan="2">Remarks</th>
                      <th rowspan="2">No Invoice</th>
                    </tr>
                    <tr>
                      <th>MEGA</th>
                      <th>BCA</th>
                      <th>Mandiri</th>
                      <th>BCA</th>
                      <th>Mandiri</th>
                      <th>BNI</th>
                      <th>BCA</th>
                      <th>MEGA</th>
                      <th>BNI</th>
                      <th>Mandiri</th>
                      <th>Citibank</th>
                      <th>Lainnya</th>
                      <th>Travel <br />Certificate</th>
                      <th>Travel <br />Voucher</th>
                      <th>Voucher <br />CT Corp</th>
                      <th>Point Rewards</th>
                      <th>Kupon</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="6">
                        TOTAL
                      </th>
                      <th style="text-align: right"><span id="deposite">0</span></th>
                      <?php
                      $kode_type = array(
                        1   => array("id" => "tunai", "col" => 7),
                        3   => array("id" => "mega", "col" => 8),
                        2   => array("id" => "bca", "col" => 9),
                        4   => array("id" => "mandiri", "col" => 10),
                        7   => array("id" => "dbca", "col" => 11),
                        14  => array("id" => "dmandiri", "col" => 12),
                        15  => array("id" => "dbni", "col" => 13),
                        9   => array("id" => "ccbca", "col" => 14),
                        5   => array("id" => "ccmega", "col" => 15),
                        11  => array("id" => "ccbni", "col" => 16),
                        12  => array("id" => "ccmandiri", "col" => 17),
                        13  => array("id" => "cccity", "col" => 18),
                        10  => array("id" => "cclain", "col" => 19),
                        16  => array("id" => "certificate", "col" => 20),
                        17  => array("id" => "voucher", "col" => 21),
                        18  => array("id" => "ctcorp", "col" => 22),
                        19  => array("id" => "point", "col" => 23),
                        20  => array("id" => "kupon", "col" => 24),
                      );
                      foreach($kode_type AS $kt){
                        print "<th style='text-align: right'><span id='{$kt["id"]}'>0</span></th>";
                      }
                      ?>
                      <th></th>
                      <th></th>
                      <th></th>
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
<span id="tttt"></span>