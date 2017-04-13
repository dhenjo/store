<style>
  .ui-datepicker-month{
      color: black !important;
  }
  .ui-datepicker-year{
      color: black !important;
  }
</style>
<?php
$set_email = $set_depan = $set_belakang = $set_telphone = "";
if($this->session->userdata("id")){
  $bookers = $this->global_models->get("tiket_book", array("id_users" => $this->session->userdata("id")));
  if($bookers){
    $set_email = $bookers[0]->email;
    $set_telphone = $bookers[0]->telphone;
    $set_depan = $bookers[0]->first_name;
    $set_belakang = $bookers[0]->last_name;
  }
  else{
    $set_email = $this->session->userdata("email");
  }
}
?>

<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Penumpang</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Penumpang</li>
        </ul>
    </div>
</div>
<section id="content" class="gray-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-9">
                <ul class='nav nav-wizard'>
                  <li><a href='<?php print site_url()?>'>Cari Penerbangan</a></li>
                  <li class='active'><a>Informasi Penumpang</a></li>
                  <li><a>Proses Booking</a></li>
                  <li><a>Hasil Booking</a></li>
                </ul>
                <br />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <?php
                print $this->form_eksternal->form_open(site_url("antavaya/book-code"), 'id="book_form" role="form" onsubmit="return filter()"', array(
                  "pp" => $pp,
                  "id_website_flight_temp2" => $id_website_flight_temp2
                  ))
                ?>
                <h2 style="background-color: #1a6ea5; color: white; padding: 10px">Informasi Pemesan</h2>
                <?php
                if(!$this->session->userdata("id")){
                ?>
                <div class="toggle-container question-list" id="penumpang_login">

                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#inin">Login</a>
                        </h4>
                        <div id="inin" class="panel-collapse collapse">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Email</label>
                                        <input type="text" class="input-text full-width" name="email" placeholder="Email" id="email_ajax" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Password</label>
                                        <input type="password" class="input-text full-width" name="pass" placeholder="Password" id="pass_ajax" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <a href="javascript:void(0)" onclick="login_ajax()" class="button">Login</a>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#daftar">Daftar</a>
                        </h4>
                        <div id="daftar" class="panel-collapse collapse">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama</label>
                                        <input type="text" class="input-text full-width" name="nama_daftar" placeholder="Nama" id="nama_daftar" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Email</label>
                                        <input type="text" class="input-text full-width" name="email_daftar" placeholder="Email" id="email_daftar" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Password</label>
                                        <input type="password" class="input-text full-width" name="sandi_daftar" placeholder="Password" id="sandi_daftar" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Ulangi Password</label>
                                        <input type="password" class="input-text full-width" name="ulang_sandi_daftar" placeholder="Ulangi Password" id="ulang_sandi_daftar" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label style="text-transform: none"><input id="berita_daftar" type="checkbox" name="berita_daftar" value="2"> Menerima berita dari AntaVaya</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <a href="javascript:void(0)" onclick="daftar_ajax()" class="button">Daftar</a>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <div class="booking-section travelo-box">
                    <div class="panel style1" style="padding: 10px; background-color: #ccccff">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="">Pemesan</a>
                        </h4>
                    </div>
                        <div class="person-information">
                            <div class="form-group row">
                              <div class="col-sm-6 col-md-5">
                                <label>Nama Depan</label>
                                <input type="text" onblur="set_nama()" class="input-text full-width" name="depan" value="<?php print $set_depan?>" placeholder="Nama Depan" id="pemesan_depan" />
                              </div>
                              <div class="col-sm-6 col-md-5">
                                <label>Nama Belakang</label>
                                <input type="text" onblur="set_nama()" class="input-text full-width" name="belakang" value="<?php print $set_belakang?>" placeholder="Nama Belakang" id="pemesan_belakang" />
                              </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-6 col-md-5">
                                    <label>Email</label>
                                    <input type="text" class="input-text full-width" name="tmail" value="<?php print $set_email?>" placeholder="Email" id="mail" />
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <label>No Telepon</label>
                                    <input type="text" class="input-text full-width" name="thp2" value="<?php print $set_telphone?>" placeholder="Telepon" id="telp" />
                                </div>
                            </div>
<!--                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I want to receive <span class="skin-color">Travelo</span> promotional offers in the future
                                    </label>
                                </div>
                            </div>-->
                        </div>
                </div>
                <h2 style="background-color: #1a6ea5; color: white; padding: 10px">Informasi Penumpang</h2>
                <div class="toggle-container question-list">

                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#tgg1">Penumpang 1</a>
                        </h4>
                        <div id="tgg1" class="panel-collapse collapse in">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Titel</label>
                                        <div class="selector">
                                            <select class="full-width" name="dtitle[1]">
                                                <option>Mr</option>
                                                <option>Ms</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Depan</label>
                                        <input type="text" class="input-text full-width" name="tfirst[1]" value="<?php print $set_depan?>" placeholder="Nama Depan" id="tfirst1" />
                                        <input type="text" value="<?php print $id_website_flight_temp?>" name="id_website_flight_temp" style="display: none" />
                                        <input type="text" value="<?php print $this->session->userdata("flight_adl")?>" name="batas_dewasa" style="display: none" id="batas_dewasa" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="input-text full-width" name="tlast[1]" value="<?php print $set_belakang?>" placeholder="Nama Belakang" id="tlast1" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-7">
                                        <label>Tanggal Lahir</label>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dtgl[1]" id="lahirtgl1">
                                                <?php
                                                for($r = 1; $r <= 31 ; $r++){
                                                  print "<option>{$r}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-6">
                                            <select class="full-width" name="dbln[1]" id="lahirbln1">
                                                <?php
                                                for($r = 1; $r <= 12 ; $r++){
                                                  print "<option value='{$r}'>".date("F", strtotime("2015-{$r}-01"))."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dthn[1]" id="lahirthn1">
                                                <?php
                                                for($r = (date("Y")-80) ; $r <= (date("Y")-12) ; $r++){
                                                  print "<option>{$r}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <?php
                    if($this->session->userdata("flight_adl") > 1){
                      for($r = 2 ; $r <= $this->session->userdata("flight_adl") ; $r++){
                    ?>
                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#tgg<?php print $r;?>">Penumpang <?php print $r;?></a>
                        </h4>
                        <div id="tgg<?php print $r;?>" class="panel-collapse collapse">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Titel</label>
                                        <div class="selector">
                                            <select class="full-width" name="dtitle[<?php print $r;?>]">
                                                <option>Mr</option>
                                                <option>Ms</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Depan</label>
                                        <input type="text" class="input-text full-width" name="tfirst[<?php print $r;?>]" id="tfirst<?php print $r;?>" value="" placeholder="Nama Depan" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="input-text full-width" name="tlast[<?php print $r;?>]" value="" id="tlast<?php print $r;?>" placeholder="Nama Belakang" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-7">
                                        <label>Tanggal Lahir</label>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dtgl[<?php print $r;?>]" id="lahirtgl<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 31 ; $ro++){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-6">
                                            <select class="full-width" name="dbln[<?php print $r;?>]" id="lahirbln<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 12 ; $ro++){
                                                  print "<option value='{$ro}'>".date("F", strtotime("2015-{$ro}-01"))."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dthn[<?php print $r;?>]" id="lahirthn<?php print $r;?>">
                                                <?php
                                                for($ro = (date("Y")-80) ; $ro <= (date("Y")-13) ; $ro++){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    }
                    
                    if($this->session->userdata("flight_chd") > 0){
                      print $this->form_eksternal->form_input("batas_anak", $this->session->userdata("flight_chd"), "id='batas_anak' style='display:none'");
                      for($r = 1 ; $r <= $this->session->userdata("flight_chd") ; $r++){
                    ?>
                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#tggc<?php print $r;?>">Penumpang Anak <?php print $r;?></a>
                        </h4>
                        <div id="tggc<?php print $r;?>" class="panel-collapse collapse">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Titel</label>
                                        <div class="selector">
                                            <select class="full-width" name="dtitlec[<?php print $r;?>]">
                                                <option>Mstr</option>
                                                <option>Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Depan</label>
                                        <input type="text" class="input-text full-width" id="tfirstc<?php print $r;?>" name="tfirstc[<?php print $r;?>]" value="" placeholder="Nama Depan" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="input-text full-width" id="tlastc<?php print $r;?>" name="tlastc[<?php print $r;?>]" value="" placeholder="Nama Belakang" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-7">
                                        <label>Tanggal Lahir</label>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dtglc[<?php print $r;?>]" id="lahirtglc<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 31 ; $ro++){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-6">
                                            <select class="full-width" name="dblnc[<?php print $r;?>]" id="lahirblnc<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 12 ; $ro++){
                                                  print "<option value='{$ro}'>".date("F", strtotime("2015-{$ro}-01"))."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dthnc[<?php print $r;?>]" id="lahirthnc<?php print $r;?>">
                                                <?php
                                                for($ro = (date("Y")-2) ; $ro >= (date("Y")-12) ; $ro--){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    }
                    
                    if($this->session->userdata("flight_inf") > 0){
                      print $this->form_eksternal->form_input("batas_bayi", $this->session->userdata("flight_inf"), "id='batas_bayi' style='display:none'");
                      for($r = 1 ; $r <= $this->session->userdata("flight_inf") ; $r++){
                    ?>
                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#tggi<?php print $r;?>">Penumpang Bayi <?php print $r;?></a>
                        </h4>
                        <div id="tggi<?php print $r;?>" class="panel-collapse collapse">
                            <div class="booking-section travelo-box">
                              <div class="person-information">
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Titel</label>
                                        <div class="selector">
                                            <select class="full-width" name="dtitlei[<?php print $r;?>]">
                                                <option>Mstr</option>
                                                <option>Miss</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Depan</label>
                                        <input type="text" class="input-text full-width" id="tfirsti<?php print $r;?>" name="tfirsti[<?php print $r;?>]" value="" placeholder="Nama Depan" />
                                    </div>
                                    <div class="col-sm-6 col-md-5">
                                        <label>Nama Belakang</label>
                                        <input type="text" class="input-text full-width" id="tlasti<?php print $r;?>" name="tlasti[<?php print $r;?>]" value="" placeholder="Nama Belakang" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-7">
                                        <label>Tanggal Lahir</label>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dtgli[<?php print $r;?>]" id="lahirtgli<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 31 ; $ro++){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-6">
                                            <select class="full-width" name="dblni[<?php print $r;?>]" id="lahirblni<?php print $r;?>">
                                                <?php
                                                for($ro = 1; $ro <= 12 ; $ro++){
                                                  print "<option value='{$ro}'>".date("F", strtotime("2015-{$ro}-01"))."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="selector col-md-3">
                                            <select class="full-width" name="dthni[<?php print $r;?>]" id="lahirthni<?php print $r;?>">
                                                <?php
                                                for($ro = date("Y") ; $ro >= (date("Y")-2) ; $ro--){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <label>Passanger Assoc.</label>
                                        <div class="selector col-md-12">
                                            <select class="full-width" name="dpax[<?php print $r;?>]">
                                                <?php
                                                for($ro = 1 ; $ro <= 7 ; $ro++){
                                                  print "<option>{$ro}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    }
                    ?>
                </div>
                <div class="booking-section travelo-box">
                        
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input id="setuju_terms" type="checkbox" name="checkbox1"> Menyetujui <a href="#"><span class="skin-color">Syarat & Ketentuan</span></a>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 col-md-5">
                                <input type="text" name="tadl" value="1" style="display: none" />
                                <button type="submit" name="submit" value="Book" class="full-width btn-large">LANJUTKAN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
<!--            <div id="main" class="col-sms-6 col-sm-8 col-md-9">
                
            </div>-->
            <div class="sidebar col-sms-6 col-sm-4 col-md-3">
                <div class="booking-details travelo-box">
                    <h4>Detail Penerbangan</h4>
                    <h6><?php print $this->global_models->array_kota($flight[0]->dari)." ke ".$this->global_models->array_kota($flight[0]->ke)?></h6>
                    <article class="flight-booking-details">
                        <figure class="clearfix">
                            <a title="" href="javascript:void(0)" class="middle-block">
                                <img style="max-width: 75px; height: auto" class="middle-item" alt="" src="<?php print $url."/maskapai/{$flight[0]->img}"?>"></a>
                            <div class="travel-title">
                                <h5 class="box-title">
                                    <small>
                                    <?php 
                                    $maskapai = array(
                                      "GA"    => "Garuda Indonesia",
                                      "JT"    => "Lion Air",
                                      "QG"    => "Citilink",
                                      "QZ"    => "Air Asia",
                                      "SJ"    => "Sriwijaya Air",
                                      "ID"    => "Batik Air",
                                      "IW"    => "Wings Air"
                                    );
                                    $j = 0;
                                    foreach($items AS $it){
                                      if($j > 0){
                                        print " - ";
                                      }
                                      print $it->flight_no."<br />";
                                    }
                                    ?>
                                    <?php print $maskapai[$flight[0]->maskapai]?>
                                    </small>
                                    <!--<small>Oneway flight</small>-->
                                </h5>
                                <a href="javascript:void(0)" class="button">
                                  <?php 
                                  $stop_cetak = "Langsung";
                                  if($flight[0]->stop > 1){
                                    $stop_cetak = ($flight[0]->stop - 1)." Transit";
                                  }
                                  print $stop_cetak;?></a>
                            </div>
                        </figure>
                        <div class="details">
                            <div class="constant-column-3 timing clearfix">
                                <div class="check-in">
                                    <label>Barangkat</label>
                                    <span>
                                        <input name="berang" id="tglberangkat" value="<?php print date("d F Y", strtotime($flight[0]->take_off))?>" style="display: none" />
                                      <?php print date("d M y", strtotime($flight[0]->take_off))?>
                                        <br /><?php print date("H:i", strtotime($flight[0]->take_off))?></span>
                                </div>
                                <div class="duration text-center">
                                    <i class="soap-icon-clock"></i>
                                    <!--<span>13h, 40m</span>-->
                                </div>
                                <div class="check-out">
                                    <label>Tiba</label>
                                    <span><?php print date("d M y", strtotime($flight[0]->landing))?>
                                        <br /><?php print date("H:i", strtotime($flight[0]->landing))?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                    
                    <?php if($flight2){?>
                    <h6><?php print $this->global_models->array_kota($flight2[0]->dari)." ke ".$this->global_models->array_kota($flight2[0]->ke)?></h6>
                    <article class="flight-booking-details">
                        <figure class="clearfix">
                            <a title="" href="javascript:void(0)" class="middle-block">
                                <img style="max-width: 75px; height: auto" class="middle-item" alt="" src="<?php print $url."/maskapai/{$flight2[0]->img}"?>"></a>
                            <div class="travel-title">
                                <h5 class="box-title">
                                    <small>
                                    <?php 
                                    $maskapai = array(
                                      "GA"    => "Garuda Indonesia",
                                      "JT"    => "Lion Air",
                                      "QG"    => "Citilink",
                                      "QZ"    => "Air Asia",
                                      "SJ"    => "Sriwijaya Air",
                                      "ID"    => "Batik Air",
                                      "IW"    => "Wings Air"
                                    );
                                    $j = 0;
                                    foreach($items2 AS $it2){
                                      if($j > 0){
                                        print " - ";
                                      }
                                      print $it2->flight_no."<br />";
                                    }
                                    ?><br />
                                    <?php print $maskapai[$flight2[0]->maskapai]?>
                                    </small>
                                    <!--<small>Oneway flight</small>-->
                                </h5>
                                <a href="javascript:void(0)" class="button">
                                  <?php 
                                  $stop_cetak = "Langsung";
                                  if($flight2[0]->stop > 1){
                                    $stop_cetak = ($flight2[0]->stop - 1)." Transit";
                                  }
                                  print $stop_cetak;?></a>
                            </div>
                        </figure>
                        <div class="details">
                            <div class="constant-column-3 timing clearfix">
                                <div class="check-in">
                                    <label>Barangkat</label>
                                    <span><?php print date("d M y", strtotime($flight2[0]->take_off))?>
                                        <br /><?php print date("H:i", strtotime($flight2[0]->take_off))?></span>
                                </div>
                                <div class="duration text-center">
                                    <i class="soap-icon-clock"></i>
                                    <!--<span>13h, 40m</span>-->
                                </div>
                                <div class="check-out">
                                    <label>Tiba</label>
                                    <span><?php print date("d M y", strtotime($flight2[0]->landing))?>
                                        <br /><?php print date("H:i", strtotime($flight2[0]->landing))?></span>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php }?>

                    <h4>Rincian Harga Berangkat</h4>
                    <dl class="other-details">
                        <dt class="feature">Kelas</dt><dd class="value"><?php 
                        $harga_adult = $flight[0]->price * $this->session->userdata("flight_adl");
                        $harga_child = $flight[0]->child * $this->session->userdata("flight_chd");
                        $harga_infant = $flight[0]->infant * $this->session->userdata("flight_inf");
                        $diskon = $this->global_models->diskon($flight[0]->maskapai, $harga_adult);
                        $diskon_child = $this->global_models->diskon($flight[0]->maskapai, $harga_child);
                        $harga_jual = $harga_adult + $harga_child + $harga_infant - $flight[0]->hemat;
                        print $flight[0]->class." ({$flight[0]->code})";?></dd>
                        <dt class="feature">Dewasa (<?php print $this->session->userdata("flight_adl")?> X <?php print $this->global_models->format_angka_atas($flight[0]->price,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_adult,0,",",".")?></dd>
                        <dt class="feature">Anak (<?php print $this->session->userdata("flight_chd")?> X <?php print $this->global_models->format_angka_atas($flight[0]->child,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_child,0,",",".")?></dd>
                        <dt class="feature">Bayi (<?php print $this->session->userdata("flight_inf")?> X <?php print $this->global_models->format_angka_atas($flight[0]->infant,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_infant,0,",",".")?></dd>
                        <dt class="feature">Diskon</dt><dd class="value">Rp <?php print $this->global_models->format_angka_atas($flight[0]->hemat,0,",",".")?></dd>
                        <dt class="feature">Admin Fee</dt><dd class="value">Rp <?php print $this->global_models->format_angka_atas(0,0,",",".")?></dd>
                        <dt class="total-price">Total</dt><dd class="total-price-value" style="color: #bd2330">Rp <?php print $this->global_models->format_angka_atas($harga_jual,0,",",".")?></dd>
                        <?php
                        if($data_diskon_array->status == 2){
                          foreach($data_diskon_array->diskon AS $dda){
                            if($dda->type == 1){
                              $diskon_persen = $dda->diskon/100 * $harga_jual;
                              $diskon_cetak = $harga_jual - $diskon_persen;
                            }
                            else{
                              $diskon_cetak = $harga_jual - $dda->diskon;
                            }
                            print "<dt class='feature' style='background: url({$dda->logo}) no-repeat left center; background-size: 50px; width: 40%; font-size: 1.4em;' >&nbsp;</dt>"
                            . "<dd class='total-price-value' style='color: #bd2330'>"
                            . "Rp ".$this->global_models->format_angka_atas($diskon_cetak,0,",",".")."</dd>";
                          }
                        }
                           
                        if($data_diskon_dest_array->status == 2){
                          foreach($data_diskon_dest_array->diskon AS $msk => $dda){
                            if($msk == $flight[0]->maskapai){
                              if($dda->type == 1){
                                $diskon_persen = $dda->diskon/100 * $harga_jual;
                                $diskon_cetak = $harga_jual - $diskon_persen;
                              }
                              else{
                                $diskon_cetak = $harga_jual - $dda->diskon;
                              }
                              print "<dt class='feature' style='background: url({$dda->logo}) no-repeat left center; background-size: 20px; width: 40%; font-size: 1.4em;' >&nbsp;</dt>"
                              . "<dd class='total-price-value' style='color: #bd2330'>"
                              . "Rp ".$this->global_models->format_angka_atas($diskon_cetak,0,",",".")."</dd>";
                            }
                          }
                        }
                           
                        ?>
                    </dl>
                </div>
                <?php
                if($flight2){
                ?>
                <div class="booking-details travelo-box">
                    
                    <h4>Rincian Harga Pulang/Kembali</h4>
                    <dl class="other-details">
                        <dt class="feature">Kelas</dt><dd class="value"><?php 
                        $harga_adult = $flight2[0]->price * $this->session->userdata("flight_adl");
                        $harga_child = $flight2[0]->child * $this->session->userdata("flight_chd");
                        $harga_infant = $flight2[0]->infant * $this->session->userdata("flight_inf");
                        $diskon = $this->global_models->diskon($flight2[0]->maskapai, $harga_adult);
                        $diskon_child = $this->global_models->diskon($flight2[0]->maskapai, $harga_child);
                        $harga_jual2 = $harga_adult + $harga_child + $harga_infant - $flight2[0]->hemat;
                        print $flight2[0]->class." ({$flight2[0]->code})";?></dd>
                        <dt class="feature">Dewasa (<?php print $this->session->userdata("flight_adl")?> X <?php print $this->global_models->format_angka_atas($flight2[0]->price,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_adult,0,",",".")?></dd>
                        <dt class="feature">Anak (<?php print $this->session->userdata("flight_chd")?> X <?php print $this->global_models->format_angka_atas($flight2[0]->child,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_child,0,",",".")?></dd>
                        <dt class="feature">Bayi (<?php print $this->session->userdata("flight_inf")?> X <?php print $this->global_models->format_angka_atas($flight2[0]->infant,0,",",".")?>)</dt>
                          <dd class="value">Rp <?php print $this->global_models->format_angka_atas($harga_infant,0,",",".")?></dd>
                        <dt class="feature">Diskon</dt><dd class="value">Rp <?php print $this->global_models->format_angka_atas($flight[0]->hemat,0,",",".")?></dd>
                        <dt class="feature">Admin Fee</dt><dd class="value">Rp <?php print $this->global_models->format_angka_atas(0,0,",",".")?></dd>
                        <dt class="total-price">Total</dt><dd class="total-price-value" style="color: #bd2330">Rp <?php print $this->global_models->format_angka_atas($harga_jual2,0,",",".")?></dd>
                        <?php
                        if($data_diskon_array->status == 2){
                          foreach($data_diskon_array->diskon AS $dda){
                            if($dda->type == 1){
                              $diskon_persen = $dda->diskon/100 * $harga_jual2;
                              $diskon_cetak = $harga_jual2 - $diskon_persen;
                            }
                            else{
                              $diskon_cetak = $harga_jual2 - $dda->diskon;
                            }
                            print "<dt class='feature' style='background: url({$dda->logo}) no-repeat left center; background-size: 50px; width: 40%;   font-size: 1.4em;'>&nbsp;</dt>"
                            . "<dd class='total-price-value' style='color: #bd2330'>"
                            . "Rp ".$this->global_models->format_angka_atas($diskon_cetak,0,",",".")."</dd>";
                          }
                        }
                        ?>
                    </dl>
                        <dl class="other-details">
                            <dt class="total-price">Total Harga</dt><dd class="total-price-value" style="color: #1a6ea5; font-size: 20px">Rp <?php print $this->global_models->format_angka_atas(($harga_jual+$harga_jual2),0,",",".")?></dd>
                            <?php
                        if($data_diskon_array->status == 2){
                          foreach($data_diskon_array->diskon AS $dda){
                            if($dda->type == 1){
                              $diskon_persen = $dda->diskon/100 * ($harga_jual+$harga_jual2);
                              $diskon_cetak = ($harga_jual+$harga_jual2) - $diskon_persen;
                            }
                            else{
                              $diskon_cetak = ($harga_jual+$harga_jual2) - $dda->diskon;
                            }
                            print "<dt class='feature' style='background: url({$dda->logo}) no-repeat left center; background-size: 50px; width: 40%; font-size: 20px;'>&nbsp;</dt>"
                            . "<dd class='total-price-value' style='color: #1a6ea5; font-size: 20px'>"
                              . "Rp ".$this->global_models->format_angka_atas($diskon_cetak,0,",",".")."</dd>";
                          }
                        }
                        
                        ?>
                        </dl>
                    </dl>
                </div>

                <?php }
                print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>