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
                    <ul data-role='listview' data-theme='c'>
                            <?php
                            foreach($data[1] AS $r => $dt){
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