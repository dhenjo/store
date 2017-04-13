<?php print $this->load->view("mobile/book-js"); ?>
<div data-role="page" data-theme="c" id="page2">
 <div data-role="header">
    <h1>Guest Detail</h1>
    <a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home1">Home</a>
    <img src="<?php print $url?>img/tiketdomestik_logo.png" width="150">
 </div><!-- /header -->
            
 <div data-role="content">
<div data-role="collapsible-set" data-theme="c" data-content-theme="d">
    <div data-role="collapsible" data-inset="false" >
        <h3>Depart <?php print date("d F Y", strtotime($flight[0]->take_off))?></h3>
        <input name="berang" id="tglberangkat" value="<?php print date("d F Y", strtotime($flight[0]->take_off))?>" style="display: none" />
      
       
        Flight <?php print $flight[0]->flight_no?><br><?php print $this->global_models->array_kota($flight[0]->dari)." - ".$this->global_models->array_kota($flight[0]->ke)?>
        <br>Depart <?php print date("H:i", strtotime($flight[0]->take_off))?>
        <br>Arrive <?php print date("H:i", strtotime($flight[0]->landing))?>
        <br>Admin fee Gratis
        <br>Adult  : <strike><?php print $this->global_models->format_angka_atas($flight[0]->price)?></strike> 
          <?php print $this->global_models->format_angka_atas($flight[0]->jual)?> x <?php print $this->session->userdata("flight_adl")?> = 
          <strike><?php 
          $total_adl_s = $flight[0]->price*$this->session->userdata("flight_adl");
          print $this->global_models->format_angka_atas($total_adl_s)?></strike> 
          <?php 
          $total_adl = $flight[0]->jual*$this->session->userdata("flight_adl");
          print $this->global_models->format_angka_atas($total_adl)?>
        <?php
        if($this->session->userdata("flight_chd") > 0){
          $total_chd_s = $flight[0]->child*$this->session->userdata("flight_chd");
          $diskon_chd = $this->global_models->diskon($flight[0]->maskapai, $flight[0]->child);
        ?>
          <br>Child  : <strike><?php print $this->global_models->format_angka_atas($flight[0]->child)?></strike> 
          <?php print $this->global_models->format_angka_atas(($flight[0]->child - $diskon_chd))?>
          x <?php print $this->session->userdata("flight_chd")?> 
          = <strike><?php print $this->global_models->format_angka_atas($total_chd_s)?></strike>
          <?php 
          $total_chd = (($flight[0]->child - $diskon_chd) * $this->session->userdata("flight_chd"));
          print $this->global_models->format_angka_atas($total_chd);?>
        <?php }
        if($this->session->userdata("flight_inf") > 0){
          $total_inf_s = $flight[0]->infant*$this->session->userdata("flight_inf");
          $diskon_inf = $this->global_models->diskon($flight[0]->maskapai, $flight[0]->infant);
          ?>
        <br>Infant : 
        <?php print $this->global_models->format_angka_atas($flight[0]->infant)?> 
        x <?php print $this->session->userdata("flight_inf")?>  
        = <?php 
        $total_inf = ($flight[0]->infant * $this->session->userdata("flight_inf"));
        print $this->global_models->format_angka_atas($total_inf)?>
        <?php }?>
        <br>Class x
        <br><strike><?php print $this->global_models->format_angka_atas(($total_adl_s+$total_chd_s+$total_inf_s))?></strike> 
        <?php print $this->global_models->format_angka_atas(($total_adl+$total_chd+$total_inf))?>
    </div>
<!--</div>
<div data-role="collapsible-set" data-theme="c" data-content-theme="d">-->
    <?php
    if($pp == 2){
    ?>
    <div data-role="collapsible">
        <h3>Return <?php print date("d F Y", strtotime($flight2[0]->take_off))?></h3>
        Flight <?php print $flight2[0]->flight_no?><br><?php print $this->global_models->array_kota($flight2[0]->dari)." - ".$this->global_models->array_kota($flight2[0]->ke)?>
        <br>Depart <?php print date("H:i", strtotime($flight2[0]->take_off))?>
        <br>Arrive <?php print date("H:i", strtotime($flight2[0]->landing))?>
        <br>Admin fee Gratis
        <br>Adult  : <strike><?php print $this->global_models->format_angka_atas($flight2[0]->price)?></strike> 
          <?php print $this->global_models->format_angka_atas($flight2[0]->jual)?> x <?php print $this->session->userdata("flight_adl")?> = 
          <strike><?php 
          $total_adl_s = $flight2[0]->price*$this->session->userdata("flight_adl");
          print $this->global_models->format_angka_atas($total_adl_s)?></strike> 
          <?php 
          $total_adl = $flight2[0]->jual*$this->session->userdata("flight_adl");
          print $this->global_models->format_angka_atas($total_adl)?>
        <?php
        if($this->session->userdata("flight_chd") > 0){
          $total_chd_s = $flight2[0]->child*$this->session->userdata("flight_chd");
          $diskon_chd = $this->global_models->diskon($flight2[0]->maskapai, $flight2[0]->child);
        ?>
          <br>Child  : <strike><?php print $this->global_models->format_angka_atas($flight2[0]->child)?></strike> 
          <?php print $this->global_models->format_angka_atas(($flight2[0]->child - $diskon_chd))?>
          x <?php print $this->session->userdata("flight_chd")?> 
          = <strike><?php print $this->global_models->format_angka_atas($total_chd_s)?></strike>
          <?php 
          $total_chd = (($flight2[0]->child - $diskon_chd) * $this->session->userdata("flight_chd"));
          print $this->global_models->format_angka_atas($total_chd);?>
        <?php }
        if($this->session->userdata("flight_inf") > 0){
          $total_inf_s = $flight2[0]->infant*$this->session->userdata("flight_inf");
          $diskon_inf = $this->global_models->diskon($flight2[0]->maskapai, $flight2[0]->infant);
          ?>
        <br>Infant : 
        <?php print $this->global_models->format_angka_atas($flight2[0]->infant)?> 
        x <?php print $this->session->userdata("flight_inf")?>  
        = <?php 
        $total_inf = ($flight2[0]->infant * $this->session->userdata("flight_inf"));
        print $this->global_models->format_angka_atas($total_inf)?>
        <?php }?>
        <br>Class x
        <br><strike><?php print $this->global_models->format_angka_atas(($total_adl_s+$total_chd_s+$total_inf_s))?></strike> 
        <?php print $this->global_models->format_angka_atas(($total_adl+$total_chd+$total_inf))?>
    </div>
    <?php }
print "</div>";
    print $this->form_eksternal->form_open("antavaya/mobilebookcode", 'id="book_form" role="form" ', array(
      "pp" => $pp,
      "id_website_flight_temp2" => $id_website_flight_temp2
      ));
                
    for($a = 1 ; $a <= $this->session->userdata("flight_adl") ; $a++){
     
    ?>

    <div data-role="collapsible" data-collapsed="false">
    <h3>Detail Penumpang <?php print $a?></h3>    
    <div data-role="fieldcontain">
            <ul data-role="listview" data-theme="c">
                <li data-role="list-nasted">
                    <label for="dtitle1">Title</label>
                    <select name="dtitle[<?php print $a?>]" id="dtitle1">
                        <option  value="Mr" selected>Mr</option>
                        <option  value="Ms">Ms</option>
                    </select>
                    <label for="fname<?php print $a?>">Firstname</label>
                    <input type="text" name="tfirst[<?php print $a?>]" id="fname<?php print $a?>" class="required" value="" />
                     <input type="text" value="<?php print $id_website_flight_temp?>" name="id_website_flight_temp" style="display: none" />
                   <input type="text" value="<?php print $this->session->userdata("flight_adl")?>" name="batas_dewasa" style="display: none" id="batas_dewasa" />
                  
                  <!-- <input type="text" value="3" name="batas_dewasa" style="display: none" id="batas_dewasa" />
                  -->
                    <label for="lname<?php print $a?>">Lastname</label>
                    <input type="text" name="tlast[<?php print $a?>]" id="lname<?php print $a?>" class="required" value="" />
                    <fieldset data-role="controlgroup">
                        <h3>Date of Birth</h3>
                        <label for="dtgl<?php print $a?>">Date</label>
                        <select name='dtgl[<?php print $a?>]' id='dtgl<?php print $a?>' value=''>
                            <?php
                            for($d = 1 ; $d <= 31 ; $d++){
                              print "<option value='$d' selected>$d</option>";
                            }
                            ?>
                        </select>
                        <label for="dbln<?php print $a?>">Month</label>
                        <select name='dbln[<?php print $a?>]' id='dbln<?php print $a?>' value=''>
                            <?php
                            for($m = 1 ; $m <= 12 ; $m++){
                              print "<option value='$m' selected>$m</option>";
                            }
                            ?>
                        </select>
                        <label for="dthn<?php print $a?>">Year</label>
                        <select name='dthn[<?php print $a?>]' id='dthn<?php print $a?>' value=''>
                            <?php
                            for($ro = (date("Y")-80) ; $ro <= (date("Y")-13) ; $ro++){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                    </fieldset>
                </li>
            </ul>
    </div>
    </div>
    <?php }
    
    if($this->session->userdata("flight_chd") > 0){
        print $this->form_eksternal->form_input("batas_anak", $this->session->userdata("flight_chd"), "id='batas_anak' style='display:none'");
        for($r = 1 ; $r <= $this->session->userdata("flight_chd") ; $r++){
      ?>
    
    <div data-role="collapsible" data-collapsed="false">
    <h3>Penumpang Anak <?php print $r?></h3>    
    <div data-role="fieldcontain">
            <ul data-role="listview" data-theme="c">
                <li data-role="list-nasted">
                    <label for="dtitle1">Title</label>
                    <select name="dtitlec[<?php print $r;?>]">
                        <option>Mstr</option>
                        <option>Miss</option>
                    </select>
                    <label for="tfirstc<?php print $r;?>">Firstname</label>
                    <input type="text" class="required" id="tfirstc<?php print $r;?>" name="tfirstc[<?php print $r;?>]" value="" />
                    <label for="tlastc<?php print $r;?>">Lastname</label>
                    <input type="text" class="required" id="tlastc<?php print $r;?>" name="tlastc[<?php print $r;?>]" value="" />
                    <fieldset data-role="controlgroup">
                        <h3>Date of Birth</h3>
                        <label for="lahirtglc<?php print $r;?>">Date</label>
                        <select name="dtglc[<?php print $r;?>]" id="lahirtglc<?php print $r;?>">
                            <?php
                            for($ro = 1; $ro <= 31 ; $ro++){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                        <label for="lahirblnc<?php print $r;?>">Month</label>
                        <select name="dblnc[<?php print $r;?>]" id="lahirblnc<?php print $r;?>">
                            <?php
                            for($ro = 1; $ro <= 12 ; $ro++){
                              print "<option value='{$ro}'>".date("F", strtotime("2015-{$ro}-01"))."</option>";
                            }
                            ?>
                        </select>
                        <label for="lahirthnc<?php print $r;?>">Year</label>
                        <select name="dthnc[<?php print $r;?>]" id="lahirthnc<?php print $r;?>">
                            <?php
                            for($ro = (date("Y")-2) ; $ro >= (date("Y")-12) ; $ro--){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                    </fieldset>
                </li>
            </ul>
    </div>
    </div>
    
      <?php
        }
      }
    
    if($this->session->userdata("flight_inf") > 0){
        print $this->form_eksternal->form_input("batas_bayi", $this->session->userdata("flight_inf"), "id='batas_bayi' style='display:none'");
        for($r = 1 ; $r <= $this->session->userdata("flight_inf") ; $r++){
      ?>
    
      <div data-role="collapsible" data-collapsed="false">
    <h3>Penumpang Bayi <?php print $r?></h3>    
    <div data-role="fieldcontain">
            <ul data-role="listview" data-theme="c">
                <li data-role="list-nasted">
                    <label for="dtitle1">Title</label>
                    <select name="dtitlei[<?php print $r;?>]">
                        <option>Mstr</option>
                        <option>Miss</option>
                    </select>
                    <label for="tfirsti<?php print $r;?>">Firstname</label>
                    <input type="text" class="required" id="tfirsti<?php print $r;?>" name="tfirsti[<?php print $r;?>]" value="" />
                    <label for="tlasti<?php print $r;?>">Lastname</label>
                    <input type="text" class="required" id="tlasti<?php print $r;?>" name="tlasti[<?php print $r;?>]" value="" />
                    <fieldset data-role="controlgroup">
                        <h3>Date of Birth</h3>
                        <label for="lahirtgli<?php print $r;?>">Date</label>
                        <select name="dtgli[<?php print $r;?>]" id="lahirtgli<?php print $r;?>">
                            <?php
                            for($ro = 1; $ro <= 31 ; $ro++){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                        <label for="lahirblni<?php print $r;?>">Month</label>
                        <select name="dblni[<?php print $r;?>]" id="lahirblni<?php print $r;?>">
                            <?php
                            for($ro = 1; $ro <= 12 ; $ro++){
                              print "<option value='{$ro}'>".date("F", strtotime("2015-{$ro}-01"))."</option>";
                            }
                            ?>
                        </select>
                        <label for="lahirthni<?php print $r;?>">Year</label>
                        <select name="dthni[<?php print $r;?>]" id="lahirthni<?php print $r;?>">
                            <?php
                            for($ro = date("Y") ; $ro >= (date("Y")-2) ; $ro--){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                        <label for="lahirthni<?php print $r;?>">Passanger Assoc.</label>
                        <select name="dpax[<?php print $r;?>]">
                            <?php
                            for($ro = 1 ; $ro <= 7 ; $ro++){
                              print "<option>{$ro}</option>";
                            }
                            ?>
                        </select>
                    </fieldset>
                </li>
            </ul>
    </div>
    </div>
      <?php
        }
      }
      ?>

    <div data-role="collapsible" data-collapsed="false">
      <h3>Detail Pemesan</h3>
      <div data-role="fieldcontain">
              <ul data-role="listview" data-theme="c">
                  <li data-role="list-nasted">
                      <label for="firstname">Nama Pertama</label> <input type="text" name="depan" id="firstname" class="required" value="" />
                      <label for="firstname">Nama Belakang</label> <input type="text" name="belakang" id="lastname" class="required" value="" />
                      <label for="hp">HP no.</label> <input type="text" name="thp2" id="hp" class="required" value="" />
                      <label for="mail">Email</label> <input type="text" name="tmail" id="mail" class="required email" value="" />
                  </li>
                  <li>
                    <input type="text" value="on" name="checkbox1" style="display: none" />
                    <input type="submit" name="submit" value="Book" />
                  </li>
              </ul>
      </div>
    </div>
    
</form>

 <!-- /fieldcontain -->
<!--</div>  /collapsible -->
<!--</div>  /collapsible-set -->

</div> 
</div> 