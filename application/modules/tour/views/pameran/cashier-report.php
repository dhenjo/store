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
                      <label>Jenis</label>
                      <?php
                      print $this->form_eksternal->form_dropdown("jenis", array(NULL => "- Pilih -", 1 => "Tiket", 2 => "Hotel", 3 => "Tour", 4 => "Umroh", 5 => "Transport"), array($detail['jenis']), "class='form-control input-sm select2'");
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label>Penerima</label>
                      <?php
                      $return = array(
                        NULL => "- Pilih -",
                        1   => "Tunai",
                        3   => "Transfer Mega",
                        2   => "Transfer BCA",
                        4   => "Transfer Mandiri",
                        7   => "Debit BCA",
                        14  => "Debit Mandiri",
                        15  => "Debit BNI",
                        9   => "Kartu Kredit BCA",
                        5   => "Kartu Kredit Mega",
                        21  => "Mega First Infinite",
                        11  => "Kartu Kredit BNI",
                        12  => "Kartu Kredit Mandiri",
                        13  => "Kartu Kredit Citibank",
                        10  => "Kartu Kredit Lainnya",
                        16  => "Travel Certificate",
                        17  => "Travel Voucher",
                        18  => "Voucher CT Corp",
                        19  => "Point Rewards",
                        20  => "Kupon",
                      );
                      print $this->form_eksternal->form_dropdown("type", $return, array($detail['type']), "class='form-control input-sm select2'");
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
                      <th>No</th>
                      <th>Date</th>
                      <th>Pemesan</th>
                      <th>No TTU</th>
                      <th>Booking<br />Code</th>
                      <th>Branch</th>
                      <th>Jenis</th>
                      <th>Penerima</th>
                      <th>Nominal</th>
                      <th>Handle By</th>
                      <th>Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $kode_type = $this->global_variable->payment_type();
                    $jenis = array(
                      1 => "Tiket",
                      2 => "Hotel",
                      3 => "Tour",
                    );

                    $no = 1;
                    foreach($data AS $key => $dt){
                      if($dt->nominal > 0){
                          if($dt->pemesan){
                              $pemesan = $dt->pemesan;
                          }else{
                              $pemesan = $dt->book_pemesan;
                          }
                        print "<tr>"
                          . "<td>{$no}</td>"
                          . "<td>".date("Y-m-d", strtotime($dt->tanggal))."</td>"
                          . "<td>{$pemesan}</td>"        
                          . "<td>{$dt->no_ttu}</td>"
                          . "<td>{$dt->inventory}{$dt->tour}</td>"
                          . "<td>{$dt->store}</td>"
                          . "<td>{$jenis[$dt->jenis]}</td>"
                          . "<td>{$kode_type[$dt->type]}</td>"
                          . "<td style='text-align: right'>".number_format($dt->nominal)."</td>"
                          . "<td>{$this->global_models->get_field("m_users", "name", array("id_users" => $dt->id_users_confirm))}</td>"
                          . "<td>{$dt->number}</td>"
                        . "</tr>";
                        $jumlah[$dt->type] += $dt->nominal;

                        $no++;
                      }
                    }
                    ?>
                  </tbody>
                </table>
                <input style="display: none" type="text" id="nomor" value="1" />
              </div>
            </div>
          </div>
          <div class="row" id="summary">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Penerima</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $r = 1;
              foreach ($jumlah AS $kjml => $jml){
                print "<tr>"
                  . "<td>{$kode_type[$kjml]}</td>"
                  . "<td style='text-align: right'>".number_format($jml)."</td>"
                . "</tr>";
                $total += $jml;
                $r++;
              }
              ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>TOTAL</th>
                  <th style="text-align: right"><?php print number_format($total)?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
    </div>
  </div>
</div>
<span id="tttt"></span>