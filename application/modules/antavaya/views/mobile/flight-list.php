<!--<link rel="stylesheet" href="<?php print $url?>css/jquery.ui.autocomplete.css" type="text/css" />

<link rel="stylesheet" href="<?php print $url?>css/jquery.ui.datepicker.mobile.css" type="text/css"/>

<script type="text/javascript" src="<?php print $url?>js/jquery.mobile-1.0a4.1.min.js"></script>
<script type="text/javascript" src="<?php print $url?>js/jquery.ui.datepicker.mobile.js"></script>-->
<script>
$(document).ready(function(){
  
  $("#book_form").submit(function(){
      if($("input[name=flight]:checked").is(":checked")){
        var isirdbtn1 =  $('input[name=flight]:checked').val();
        var hrgrdo = isirdbtn1.split("/");
        //alert(hrgrdo[5]);
        if(hrgrdo[5]!="-"){
          if( $("input[name=flight2]").length != 0 ){ 
            if($("input[name=flight2]:checked").is(":checked")){
              var isirdbtn2 =  $('input[name=flight2]:checked').val();
              var hrgrdo1 = isirdbtn2.split("/");
              if(hrgrdo1[5]!="-"){
                 return true;
                
              
              }else{ alert("Pilih jadwal kedatangan yang ada harganya"); return false; }
            }else{ alert("Pilih jadwal kedatangan"); return false; }
          }else{ /* alert("jadwal PP tidak ada");   $.mobile.pageLoading(); */ return true; }
        }else{ alert("Pilih jadwal keberangkatan yang ada harganya"); return false; }
      }else{ alert("Pilih jadwal keberangkatan"); return false; }
    });
   
});
</script>

<?php
print $this->form_eksternal->form_open(site_url("antavaya/book"), 'id="book_form" role="form"', array("pp" => $pp));
?>
<div data-role="page" data-theme="c" id="page1">
 <div data-role="header">
    <h1>Flight Detail</h1>
    <a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home1">Home</a>
    <a data-role="button" data-direction="reverse" data-rel="back" data-icon="back" class="kembali">Back</a>
    <img src="<?php print $url?>img/tiketdomestik_logo.png" width="150">
 </div><!-- /header -->
            
<div data-role="content">
    <div id="loading-flight" style="display: none"><img src="<?php print base_url()."themes/antavaya/"?>images/ajax-loader.gif" /></div>
    <div data-role="collapsible-set" data-theme='c' data-content-theme='d'>
        <div data-role="collapsible" data-collapsed="false">
            <h3>OUTGOING TRIP</h3>
            <table id='myTable' width='100%'>
                <tr>
                    <td>
                        <ul data-role='listview' data-theme='c'>
                            <?php
                            foreach($data[0] AS $r => $dt){
                            ?>
                            <li>
                                <input type='radio' name='flight' value='<?php print $this->encrypt->encode($dt->id_website_flight_temp)?>' id='rdbtn<?php print $r?>' class='rdo1' />
                                <label for='rdbtn<?php print $r?>'>
                                    <strike><?php print $this->global_models->format_angka_atas($dt->price)?></strike> 
                                  <?php print $this->global_models->format_angka_atas($dt->jual)?> </label>
                                <div><img width='100' height='25' src='<?php print base_url()."themes/antavaya/maskapai/{$dt->img}"?>'/></div>
                                Flight :<?php print $dt->flight_no?><br><?php print $this->global_models->array_kota($dt->dari)."-".$this->global_models->array_kota($dt->ke)?>
                                <br><?php print date("d M y H:i", strtotime($dt->take_off))." - ".date("H:i", strtotime($dt->landing))?>
                                <br>Your save : <?php print $this->global_models->format_angka_atas($dt->hemat)?>
                            </li>
                            <?php }?>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <?php
        if($pp == 2){
        ?>
        <div data-role="collapsible" data-collapsed="false">
            <h3>RETURN TRIP</h3>
            <table id='myTable2' width='100%'>
                <tr>
                 <!--   <ul data-role='listview' data-theme='c'>
                            <li>
                                <input type='radio' name='rdbtn2' id='rdbtna12' value='JT 29/DENPASAR(DPS)/JAKARTA(CGK)/1150/1245/689400/2015-03-17/1/X/JT/0/0/0/0/6894/6894/0' />
                                <label for='rdbtna12'><strike>689,400</strike> 682,506 </label>
                                <div><img width='100' height='25' src='<?php print base_url()?>themes/antavaya/maskapai/image/JT.gif'/></div>
                                Flight :JT 29<br>DENPASAR - JAKARTA
                                <br>2015/03/17 1150 - 1245
                                <br>Your save : 6,894
                            </li>
                            <li>
                                <input type='radio' name='rdbtn2' id='rdbtna10' value='JT 17/DENPASAR(DPS)/JAKARTA(CGK)/1050/1145/689400/2015-03-17/1/X/JT/0/0/0/0/6894/6894/0' />
                                <label for='rdbtna10'><strike>689,400</strike> 682,506 </label>
                                <div><img width='100' height='25' src='<?php print base_url()?>themes/antavaya/maskapai/image/JT.gif'/></div>
                                Flight :JT 17<br>DENPASAR - JAKARTA
                                <br>2015/03/17 1050 - 1145
                                <br>Your save : 6,894
                            </li>
                        </ul> -->
                   <ul data-role='listview' data-theme='c'>
                            <?php
                            foreach($data[1] AS $r2 => $dt2){
                            ?>
                            <li>
                                <input type='radio' name='flight2' value='<?php print $this->encrypt->encode($dt2->id_website_flight_temp)?>' id='rdbtnww<?php print $r2?>' class='rdo1' />
                                <label for='rdbtnww<?php print $r2?>'>
                                    <strike><?php print $this->global_models->format_angka_atas($dt2->price)?></strike> 
                                  <?php print $this->global_models->format_angka_atas($dt2->jual)?> </label>
                                <div><img width='100' height='25' src='<?php print base_url()."themes/antavaya/maskapai/{$dt2->img}"?>'/></div>
                                Flight :<?php print $dt2->flight_no?><br><?php print $this->global_models->array_kota($dt2->dari)."-".$this->global_models->array_kota($dt2->ke)?>
                                <br><?php print date("d M y H:i", strtotime($dt2->take_off))." - ".date("H:i", strtotime($dt2->landing))?>
                                <br>Your save : <?php print $this->global_models->format_angka_atas($dt2->hemat)?>
                            </li>
                            <?php }?>
                        </ul>
                </tr>
            </table>
        </div>
        <?php }?>
    </div>
    <input type='hidden' name='adl' id='adl' value='1' />
    <input type='hidden' name='chd' id='chd' value='0' />
    <input type='hidden' name='inf' id='inf' value='0' />
    <input type='submit' name='sendtest1' id='sendtest1' value='Book' />
    </form>

</div> 