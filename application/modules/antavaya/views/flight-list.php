<style>
    #table1 .header{
        background-image: url('<?php print $url."images/icon/sort.png"?>');
        background-repeat: no-repeat;
        background-size: 20px;
        background-position: 90% 30%;
    }
    #table1 td{
        line-height: 1.5 !important;
    }
    #table1{
        font-size: 15px !important;
    }
</style>
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Hasil Pencarian</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Hasil Pencarian</li>
        </ul>
    </div>
</div>
<section id="content">
    <div class="container">
        <div id="main">
            <?php
            print $this->form_eksternal->form_open(site_url("antavaya/book"), 'id="book_form" role="form"', array("pp" => 1));
//            if(!$data[0][0]->dari){
//              $data[0][0]->dari = $this->session->userdata("flight_dari");
//              $data[0][0]->ke = $this->session->userdata("flight_ke");
//            }
            ?>
              <div class="row" id="rangkuman">

              </div>
            </form>
            <div id="loading-flight" style="display: none"><img src="<?php print $url?>images/ajax-loader.gif" /></div>
            <div class="row">
                    <div id="main" class="col-md-12">
                        <div class="tab-container style1">
                            <ul class="tabs">
                                <li id="pencarian"><a href="javascript:void(0)">Ulangi Pencarian</a></li>
                                <li><a href="javascript:void(0)" style="background-color: #1a6ea5; color : white; text-transform: none">
                                    Tiket Untuk : <?php
                                print $this->session->userdata("flight_adl")." Adult {$this->session->userdata("flight_chd")} Child {$this->session->userdata("flight_inf")} Infant (Departure & Arrive Menggunakan Waktu Setempat)"
                                ?></a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id='hasil_pencarian' style="background-color: #bd2330">
                                    <form name="form_search" method="post" onsubmit="return validasi()" action="<?php print site_url("antavaya/flight-list")?>">
                                      <div class="row">
                                          <div class="col-md-3">
                                              <!--<h4 class="title">Where</h4>-->
                                              <div class="form-group">
                                                  <label style="color: white">Dari</label>
                                                  <input value="<?php print $this->global_models->array_kota($this->session->userdata("flight_dari"))?>" id="autocomplete" name="tdr" type="text" class="drdr input-text full-width" placeholder="city, district or specific airport" />
                                              </div>
                                              <div class="form-group">
                                                  <label style="color: white">Ke</label>
                                                  <input value="<?php print $this->global_models->array_kota($this->session->userdata("flight_ke"))?>" id="autocomplete" name="tke" type="text" class="keke input-text full-width" placeholder="city, district or specific airport" />
                                              </div>
                                          </div>

                                          <div class="col-md-4">
                                              <!--<h4 class="title">When</h4>-->
                                              <label style="color: white">Berangkat</label>
                                              <div class="form-group row">
                                                  <div class="col-xs-6" style="width: 100%">
                                                      <div class="datepicker-wrap">
                                                          <input value="<?php print date("d F Y", strtotime($this->session->userdata("flight_berangkat")))?>" type="text" id="tgl" name="tgl" class="input-text full-width" placeholder="dd MM YY" />
                                                      </div>
                                                      <input type="hidden" name="tnow" id="tnow" value="<?php print $key?>">
                                                      <input type="hidden" name="agen" id="agen" value="testya">
                                                  </div>
                                                  <!--<div class="col-xs-6">
                                                      <div class="selector">
                                                          <select class="full-width">
                                                              <option value="1">anytime</option>
                                                              <option value="2">morning</option>
                                                          </select>
                                                      </div>
                                                  </div>-->
                                              </div>
                                              <label style="color: white"><input value="Round trip" id="rdotrip" name="rdotrip" type="checkbox" > Pulang</label>
                                              <div class="form-group row">
                                                  <div class="col-xs-6" style="width: 100%">
                                                      <div class="datepicker-wrapo" id="tanggal_back" style="display: none">
                                                          <input value="" type="text" id="tglr" name="tglr" class="input-text full-width" placeholder="dd MM YY" />
                                                      </div>
                                                  </div>
                                                  <!--<div class="col-xs-6">
                                                      <div class="selector">
                                                          <select class="full-width">
                                                              <option value="1">anytime</option>
                                                              <option value="2">morning</option>
                                                          </select>
                                                      </div>
                                                  </div>-->
                                              </div>
                                          </div>

                                          <div class="col-md-4">
                                              <!--<h4 class="title">Who</h4>-->
                                              <div class="form-group row">
                                                  <div class="col-xs-3">
                                                      <label style="color: white">Dewasa</label>
                                                      <div class="selector">
                                                          <select name="adl" id="adl" class="full-width">
                                                              <!--<option value="0">00</option>-->
                                                              <option value="1">01</option>
                                                              <option value="2">02</option>
                                                              <option value="3">03</option>
                                                              <option value="4">04</option>
                                                              <option value="5">05</option>
                                                              <option value="6">06</option>
                                                              <option value="7">07</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <label style="color: white">Anak</label>
                                                      <div class="selector">
                                                          <select name="chd" id="chd" class="full-width">
                                                              <option value="0">00</option>
                                                              <option value="1">01</option>
                                                              <option value="2">02</option>
                                                              <option value="3">03</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <div class="col-xs-3">
                                                      <label style="color: white">Bayi</label>
                                                      <div class="selector">
                                                          <select name="inf" id="inf" class="full-width">
                                                              <option value="0">00</option>
                                                              <option value="1">01</option>
                                                              <option value="2">02</option>
                                                              <option value="3">03</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  <!--<div class="col-xs-6">
                                                      <label>Promo Code</label>
                                                      <input type="text" class="input-text full-width" placeholder="type here" />
                                                  </div>-->
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-xs-9">
                                                      <button id="cari" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
                                                          CARI TIKET
                                                      </button>
      <!--                                                <button id="cari" onclick="testopen()" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
                                                          CARI TIKET
                                                      </button>-->
                                                  </div>
                                              </div>
                                          </div>


      <!--									<div class="col-md-4">
                                              <img src="<?php print base_url()."files/antavaya/ads/dua.png"?>" width="100%"/>
                                          </div>-->

                                      </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row" style="display: block" id="tampilkan">
                <div class="col-sm-6 col-lg-12 table-cell cruise-itinerary">
                    <ul class='nav nav-wizard'>
                      <li class='active'><a href='javascript:void(0)'>Cari Penerbangan</a></li>
                      <li><a>Informasi Penumpang</a></li>
                      <li><a>Proses Booking</a></li>
                      <li><a>Hasil Booking</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-lg-12 table-cell cruise-itinerary">
                    <div class="travelo-box">
                        <h4 class="box-title"><?php print $this->global_models->array_kota($this->session->userdata("flight_dari"))?> ke <?php print $this->global_models->array_kota($this->session->userdata("flight_ke"))?>
                            <small style="font-size: 13px"><?php print date("d F Y", strtotime($this->session->userdata("flight_berangkat")))?></small>
                        </h4>
                        <?php
                        print $this->form_eksternal->form_open(site_url("antavaya/book"), 'id="book_form" role="form"', array())
                        ?>
                        <table id="table1">
                            <thead>
                                <tr>
                                    <th class="urut">Maskapai</th>
                                    <th>Flight No</th>
                                    <th>Berangkat</th>
                                    <th>Tiba</th>
                                    <th>Fasilitas</th>
                                    <th colspan="2">Hemat</th>
                                    <?php
//                                    $data_diskon = $this->global_variable->curl_mentah(
//                                      array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s")), 
//                                      URLSERVER."json/cek-diskon-payment");
//                                    $data_diskon_array = json_decode($data_diskon);
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran Khusus</th>
                                    <?php }
                                    if($data_diskon_dest_array->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran Khusus</th>
                                    <?php }
                                    ?>
                                    <th colspan="2">Harga</th>
                                    <!--<th></th>-->
                                </tr>
                            </thead>
                            <tbody id="list">
                                <?php
                                $maskapai = array(
                                  "GA"    => "Garuda Indonesia",
                                  "JT"    => "Lion Air",
                                  "QG"    => "Citilink",
                                  "QZ"    => "Air Asia",
                                  "SJ"    => "Sriwijaya Air",
                                  "IW"    => "Wings Air",
                                  "ID"    => "Batik Air",
                                );
                                $fasilitas = array(
                                  "GA"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                                              <i class='soap-icon-breakfast' style='text-transform: none'></i>",
                                  "SJ"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                                              <i class='soap-icon-breakfast' style='text-transform: none'></i>",
                                  "ID"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                                              <i class='soap-icon-breakfast' style='text-transform: none'></i>",
                                  "IW"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>10</span></i>",
                                  "JT"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>",
                                  "QG"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>15</span></i>",
                                  "QZ"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                                              <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>15</span></i>",
                                );
                                $r = "A";
                                $h = 1;
                                foreach($data[0] AS $key => $dt){
                                  $kali_dewasa = $this->session->userdata("flight_adl") * $dt->price;
                                  $kali_anak = $this->session->userdata("flight_chd") * $dt->child;
                                  $kali_bayi = $this->session->userdata("flight_inf") * $dt->infant;
                                  $dewasa_anak = $kali_dewasa + $kali_anak;
                                  $dewasa_anak_bayi = $dewasa_anak + $kali_bayi;
//                                  $diskon_dewasa_anak = $this->global_models->diskon($dt->maskapai, $dewasa_anak);
                                  $diskon_dewasa_anak = $dt->hemat;
                                  $harga_bayar = $dt->jual - $diskon_dewasa_anak;
                                  
                                  $items = $this->global_models->get_query("SELECT *"
                                    . " FROM website_flight_temp_items AS A"
                                    . " WHERE id_website_flight_temp = '{$dt->id_website_flight_temp}'"
                                    . " GROUP BY flight_no");
                                  $fnomor = $berangkat = $tiba = "";
                                  foreach($items AS $tt){
                                    $fnomor .= $tt->flight_no."<br />";
                                    $berangkat .= date("H:i", strtotime($tt->take_off))."<br />{$tt->dari}<br />";
                                    $tiba .= date("H:i", strtotime($tt->landing))."<br />{$tt->ke}<br />";
                                  }
                                ?>
                                <tr>
                                    <td>
                                      <span style="display: none"><?php print $maskapai[$dt->maskapai]?></span>
                                      <img src="<?php print $url."maskapai/{$dt->img}"?>" width="70px" />
                                    </td>
                                    <td><?php print $fnomor?></td>
                                    <td><?php print $berangkat?></td>
                                    <td><?php print $tiba?></td>
                                    <td style="font-size: 18px">
                                      <?php print $fasilitas[$dt->maskapai]?>
                                    </td>
                                    <td><span style="display: none"><?php print $dt->hemat?></span></td>
                                    <td>Rp <?php print $this->global_models->format_angka_atas($dt->hemat, 0, ",", ".")?></td>
                                    <?php
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <td><span style="display: none">
                                      <?php print $harga_bayar?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_array->diskon AS $dda){
                                          if($dda->type == 1){
                                            $diskon_persen = $dda->diskon/100 * $harga_bayar;
                                            $diskon_cetak = $harga_bayar - $diskon_persen;
                                          }
                                          else{
                                            $diskon_cetak = $harga_bayar - $dda->diskon;
                                          }
                                          print "<img src='{$dda->logo}' width='50' />"
                                          . "Rp {$this->global_models->format_angka_atas($diskon_cetak, 0, ",", ".")} <br />";
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    }
                                    if($data_diskon_dest_array->status == 2){
                                    ?>
                                    <td><span style="display: none">
                                      <?php print $harga_bayar?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_dest_array->diskon AS $msk => $dda){
                                          if($msk == $dt->maskapai){
                                            if($dda->type == 1){
                                              $diskon_persen = $dda->diskon/100 * $harga_bayar;
                                              $diskon_cetak = $harga_bayar - $diskon_persen;
                                            }
                                            else{
                                              $diskon_cetak = $harga_bayar - $dda->diskon;
                                            }
                                            print "<img src='{$dda->logo}' width='20' />"
                                            . " Rp {$this->global_models->format_angka_atas($diskon_cetak, 0, ",", ".")} <br />";
                                          }
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    }
                                    ?>
                                    <td><span style="display: none"><?php print $harga_bayar?></span></td>
                                    <td>
<!--                                      <span style="display: none"><?php 
                                      if($r == "AA"){
                                        $r = "A";
                                        $h++;
                                      }
                                      print $h.$r;
                                      $r++;
                                      ?></span>-->
                                      <s>Rp <?php print $this->global_models->format_angka_atas($dt->jual, 0, ",", ".")?></s><br />
                                      <span style="font-size: 18px; color: #1a6ea5">
                                          <a href="javascript:void(0)" id='harga_list<?php print $key?>'>
                                              Rp <?php print $this->global_models->format_angka_atas($harga_bayar, 0, ",", ".")?>
                                          </a>
                                          <span style='display: none' id='isiharga_list<?php print $key?>'>
                                            <table width='100%'>
                                              <tr>
                                                <td>Dewasa </td>
                                                <td style='text-align: right'>
                                                  <?php print $this->session->userdata("flight_adl")." X Rp ".$this->global_models->format_angka_atas($dt->price, 0, ",", ".")?>
                                                </td>
                                                <td style='text-align: right'>
                                                    Rp <?php print $this->global_models->format_angka_atas($kali_dewasa, 0, ",", ".")?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Child </td>
                                                <td style='text-align: right'>
                                                <?php print $this->session->userdata("flight_chd")." X Rp ".$this->global_models->format_angka_atas($dt->child, 0, ",", ".")?>
                                                </td>
                                                <td style='text-align: right'>
                                                    Rp <?php print $this->global_models->format_angka_atas($kali_anak, 0, ",", ".")?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Infant </td>
                                                <td style='text-align: right'>
                                                <?php print $this->session->userdata("flight_inf")." X Rp ".$this->global_models->format_angka_atas($dt->infant, 0, ",", ".")?>
                                                </td>
                                                <td style='text-align: right'>
                                                    Rp <?php print $this->global_models->format_angka_atas($kali_bayi, 0, ",", ".")?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Hemat </td>
                                                <td style='text-align: right'></td>
                                                <td style='text-align: right'>
                                                    Rp <?php print $this->global_models->format_angka_atas($diskon_dewasa_anak, 0, ",", ".")?>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>Total </td>
                                                <td style='text-align: right'></td>
                                                <td style='text-align: right'>
                                                    Rp <?php print $this->global_models->format_angka_atas($harga_bayar, 0, ",", ".")?>
                                                </td>
                                              </tr>
                                            </table>
                                          </span>
                                          <script>
                                          $(function() {
                                            $('#harga_list<?php print $key?>').tooltipster({
                                                content: $('#isiharga_list<?php print $key?>').html(),
                                                minWidth: 300,
                                                maxWidth: 300,
                                                contentAsHTML: true,
                                                interactive: true
                                            });
                                          });
                                          </script>
                                      </span>
                                    </td>
                                    <td style="text-align: center">
                                        <?php
                                        $button_default = "<input name='doce[{$key}]' value='".$this->encrypt->encode($dt->id_website_flight_temp)."' "
                                          . "style='display: none' />"
                                          . "<button name='submit' value='{$key}' class='button btn-small full-width'>Pesan</button>";
                                        $empat_hari = strtotime("+4 days");
                                        if($dt->maskapai == "QZ"){
                                          if(strtotime($dt->take_off) < $empat_hari){
                                            $button_default = "<span style='text-transform: none'>Dapat Book <br />4 Hari dari Hari ini</span>";
                                          }
                                        }
                                        print $button_default;
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>