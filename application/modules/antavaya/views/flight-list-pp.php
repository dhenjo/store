<style>
    #table1 .header{
        background-image: url('<?php print $url."images/icon/sort.png"?>');
        background-repeat: no-repeat;
        background-size: 20px;
        background-position: 90% 30%;
    }
    #table2 .header{
        background-image: url('<?php print $url."images/icon/sort.png"?>');
        background-repeat: no-repeat;
        background-size: 20px;
        background-position: 90% 30%;
    }
    #table1 td{
        line-height: 1.5 !important;
    }
    #table2 td{
        line-height: 1.5 !important;
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
                                              <label style="color: white"><input value="Round trip" id="rdotrip" name="rdotrip" type="checkbox" checked="" > Pulang</label>
                                              <div class="form-group row">
                                                  <div class="col-xs-6" style="width: 100%">
                                                      <div class="datepicker-wrapo" id="tanggal_back">
                                                          <input value="<?php print date("d F Y", strtotime($this->session->userdata("flight_pulang")))?>" type="text" id="tglr" name="tglr" class="input-text full-width" placeholder="dd MM YY" />
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
            <div class="row">
                <div class="col-sm-6 col-lg-12 table-cell cruise-itinerary">
                    <ul class='nav nav-wizard'>
                      <li class='active'><a href='javascript:void(0)'>Cari Penerbangan</a></li>
                      <li><a>Informasi Penumpang</a></li>
                      <li><a>Proses Booking</a></li>
                      <li><a>Hasil Booking</a></li>
                    </ul>
                </div>
            </div>
          
            <?php
            print $this->form_eksternal->form_open(site_url("antavaya/book"), 'id="book_form" role="form"', array("pp" => 2))
            ?>
              <div class="row" id="rangkuman">
              </div>
            </form>
            <div id="loading-flight" style="display: none"><img src="<?php print $url?>images/ajax-loader.gif" /></div>
            <div class="row" style="display: block" id="tampilkan">
                <div class="col-sm-6 col-lg-6 table-cell cruise-itinerary">
                    <div class="travelo-box">
                        <h4 class="box-title"><?php print $this->global_models->array_kota($this->session->userdata("flight_dari"))?> ke <?php print $this->global_models->array_kota($this->session->userdata("flight_ke"))?>
                            <small><?php print date("d F Y", strtotime($this->session->userdata("flight_berangkat")));?></small>
                        </h4>
                        <table id="table1">
                            <thead>
                                <tr>
                                    <th>Maskapai</th>
                                    <th>Berangkat</th>
                                    <th>Tiba</th>
                                    <th colspan='2'>Hemat</th>
                                    <?php
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran <br />Khusus</th>
                                    <?php }
                                    if($data_diskon_dest_array->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran <br />Khusus</th>
                                    <?php }?>
                                    <th colspan='2'>Harga</th>
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
                                  "ID"    => "Batik Air"
                                );
                                $r = "A";
                                $h = 1;
                                foreach($data[0] AS $key => $dt){
                                  $kali_dewasa = $this->session->userdata("flight_adl") * $dt->price;
                                  $kali_anak = $this->session->userdata("flight_chd") * $dt->child;
                                  $kali_bayi = $this->session->userdata("flight_inf") * $dt->infant;
                                  $dewasa_anak = $kali_dewasa + $kali_anak;
                                  $dewasa_anak_bayi = $dewasa_anak + $kali_bayi;
                                  $diskon_dewasa_anak = $this->global_models->diskon($dt->maskapai, $dewasa_anak);
                                  $harga_bayar = $dewasa_anak_bayi - $diskon_dewasa_anak;
                                  $fitems = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $dt->id_website_flight_temp));
                                ?>
                                <tr>
                                    <td>
                                      <span style="display: none"><?php print $maskapai[$dt->maskapai]?></span>
                                      <?php
                                      $empat_hari = strtotime("+4 days");
                                      $stat = "<input type='radio' onclick='cekback()' name='go' value='".$this->encrypt->encode($dt->id_website_flight_temp)."' />";
                                      if($dt->maskapai == "QZ"){
                                        if(strtotime($dt->take_off) < $empat_hari){
                                          $stat = "";
                                        }
                                      }
                                      print $stat;
                                      ?>
                                      <img src="<?php print $url."maskapai/{$dt->img}"?>" width="50px" />
                                    </td>
                                    <td><?php 
                                      foreach($fitems AS $ft){
                                        print date("H:i", strtotime($ft->take_off))."<br />({$ft->dari})<br />";
                                      }
                                    ?></td>
                                    <td><?php 
                                      foreach($fitems AS $ft){
                                        print date("H:i", strtotime($ft->landing))."<br />({$ft->ke})<br />";
                                      }
                                    ?></td>
                                    <td>
                                      <span style="display: none"><?php print $dt->hemat?></span>
                                    </td>
                                    <td>
                                      Rp <?php print $this->global_models->format_angka_atas($dt->hemat, 0, ",", ".")?>
                                    </td>
                                    <?php
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <td><span style="display: none">
                                      <?php print $dt->price?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_array->diskon AS $dda){
                                          if($dda->type == 1){
                                            $diskon_persen = $dda->diskon/100 * $dt->jual;
                                            $diskon_cetak = $dt->jual - $diskon_persen;
                                          }
                                          else{
                                            $diskon_cetak = $dt->jual - $dda->diskon;
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
                                      <?php print $dt->price?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_dest_array->diskon AS $msk => $dda){
                                          if($msk == $dt->maskapai){
                                            if($dda->type == 1){
                                              $diskon_persen = $dda->diskon/100 * $dt->jual;
                                              $diskon_cetak = $dt->jual - $diskon_persen;
                                            }
                                            else{
                                              $diskon_cetak = $dt->jual - $dda->diskon;
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
                                    <td>
                                      <span style="display: none"><?php print $dt->jual?></span>
                                    </td>
                                    <td>
                                      <s>Rp <?php print $this->global_models->format_angka_atas($dt->price, 0, ",", ".")?></s>
                                      <br />
                                      <span style="font-size: 17px; color: #1a6ea5">
                                          <a href="javascript:void(0)" id='harga_list1st<?php print $key?>'>
                                            Rp <?php print $this->global_models->format_angka_atas($harga_bayar, 0, ",", ".")?>
                                          </a>
                                          <span style='display: none' id='isiharga_list1st<?php print $key?>'>
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
                                            $('#harga_list1st<?php print $key?>').tooltipster({
                                                content: $('#isiharga_list1st<?php print $key?>').html(),
                                                minWidth: 300,
                                                maxWidth: 300,
                                                contentAsHTML: true,
                                                interactive: true
                                            });
                                          });
                                          </script>
                                      </span>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6 table-cell cruise-itinerary">
                    <div class="travelo-box">
                        <h4 class="box-title"><?php print $this->global_models->array_kota($this->session->userdata("flight_ke"))?> ke <?php print $this->global_models->array_kota($this->session->userdata("flight_dari"))?>
                            <small><?php print date("d F Y", strtotime($this->session->userdata("flight_pulang")));
                            $code_dest = $this->session->userdata("flight_ke")."-".$this->session->userdata("flight_dari");?></small>
                        </h4>
                        <table id="table2">
                            <thead>
                                <tr>
                                    <th>Maskapai</th>
                                    <th>Berangkat</th>
                                    <th>Tiba</th>
                                    <th colspan='2'>Hemat</th>
                                    <?php
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran <br />Khusus</th>
                                    <?php }
                                    if($data_diskon_dest_array2->status == 2){
                                    ?>
                                    <th colspan="2">Penawaran <br />Khusus</th>
                                    <?php }
                                    ?>
                                    <th colspan='2'>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="list1">
                                <?php
                                $r = "A";
                                $h = 1;
                                foreach($data[1] AS $key => $dt){
                                  $kali_dewasa = $this->session->userdata("flight_adl") * $dt->price;
                                  $kali_anak = $this->session->userdata("flight_chd") * $dt->child;
                                  $kali_bayi = $this->session->userdata("flight_inf") * $dt->infant;
                                  $dewasa_anak = $kali_dewasa + $kali_anak;
                                  $dewasa_anak_bayi = $dewasa_anak + $kali_bayi;
                                  $diskon_dewasa_anak = $this->global_models->diskon($dt->maskapai, $dewasa_anak);
                                  $harga_bayar = $dewasa_anak_bayi - $diskon_dewasa_anak;
                                  $fitems = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $dt->id_website_flight_temp));
                                ?>
                                <tr>
                                    <td>
                                      <span style="display: none"><?php print $maskapai[$dt->maskapai]?></span>
                                      <?php
                                      $empat_hari = strtotime("+4 days");
                                      $stat = "<input type='radio' onclick='cekback()' name='back' value='".$this->encrypt->encode($dt->id_website_flight_temp)."' />";
                                      if($dt->maskapai == "QZ"){
                                        if(strtotime($dt->take_off) < $empat_hari){
                                          $stat = "";
                                        }
                                      }
                                      print $stat;
                                      ?>
                                      <img src="<?php print $url."maskapai/{$dt->img}"?>" width="50px" />
                                    </td>
                                    <td><?php 
                                      foreach($fitems AS $ft){
                                        print date("H:i", strtotime($ft->take_off))."<br />({$ft->dari})<br />";
                                      }
                                    ?></td>
                                    <td><?php 
                                      foreach($fitems AS $ft){
                                        print date("H:i", strtotime($ft->landing))."<br />({$ft->ke})<br />";
                                      }
                                    ?></td>
                                    <td>
                                      <span style="display: none"><?php print $dt->hemat?></span>
                                    </td>
                                    <td>
                                      Rp <?php print $this->global_models->format_angka_atas($dt->hemat, 0, ",", ".")?>
                                    </td>
                                    <?php
                                    if($data_diskon_array->status == 2){
                                    ?>
                                    <td><span style="display: none">
                                      <?php print $dt->price?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_array->diskon AS $dda){
                                          if($dda->type == 1){
                                            $diskon_persen = $dda->diskon/100 * $dt->jual;
                                            $diskon_cetak = $dt->jual - $diskon_persen;
                                          }
                                          else{
                                            $diskon_cetak = $dt->jual - $dda->diskon;
                                          }
                                          print "<img src='{$dda->logo}' width='50' />"
                                          . "Rp {$this->global_models->format_angka_atas($diskon_cetak, 0, ",", ".")} <br />";
                                        }
                                        ?>
                                    </td>
                                    <?php }
                                    if($data_diskon_dest_array2->status == 2){
                                    ?>
                                    <td><span style="display: none">
                                      <?php print $dt->price?></span>
                                    </td>
                                    <td style="color: #bd2330; font-size: 15px; font-weight: bold">
                                        <?php
                                        foreach($data_diskon_dest_array2->diskon AS $msk => $dda){
                                          if($msk == $dt->maskapai){
                                            if($dda->type == 1){
                                              $diskon_persen = $dda->diskon/100 * $dt->jual;
                                              $diskon_cetak = $dt->jual - $diskon_persen;
                                            }
                                            else{
                                              $diskon_cetak = $dt->jual - $dda->diskon;
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
                                    <td>
                                      <span style="display: none"><?php print $dt->jual?></span>
                                    </td>
                                    <td>
                                      <s>Rp <?php print $this->global_models->format_angka_atas($dt->price, 0, ",", ".")?></s>
                                      <br />
                                      <span style="font-size: 17px; color: #1a6ea5">
                                          <a href="javascript:void(0)" id='harga_list2nd<?php print $key?>'>
                                            Rp <?php print $this->global_models->format_angka_atas($harga_bayar, 0, ",", ".")?>
                                          </a>
                                          <span style='display: none' id='isiharga_list2nd<?php print $key?>'>
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
                                            $('#harga_list2nd<?php print $key?>').tooltipster({
                                                content: $('#isiharga_list2nd<?php print $key?>').html(),
                                                minWidth: 300,
                                                maxWidth: 300,
                                                contentAsHTML: true,
                                                interactive: true
                                            });
                                          });
                                          </script>
                                      </span>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>