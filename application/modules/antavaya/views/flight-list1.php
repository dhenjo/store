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
<!--                <div class="col-sm-4 col-md-3">
                    <h4 class="search-results-title"><i class="soap-icon-search"></i><b><?php print count($data[0])?></b> hasil.</h4>
                </div>-->
                <div class="col-sm-8 col-md-12">
                    <div class="sort-by-section clearfix box">
                        <h4 class="sort-by-title block-sm">Urut berdasarkan:</h4>
                        <ul class="sort-bar clearfix block-sm">
                            <?php
                            $price_link = "jual/ASC";
                            $dep_link = "take_off/ASC";
                            $arr_link = "landing/ASC";
                            if($sort == "jual"){
                              if($type == "ASC"){
                                $price_link = "jual/DESC";
                              }
                            }
                            else if($sort == "take_off"){
                              if($type == "ASC"){
                                $dep_link = "take_off/DESC";
                              }
                            }
                            else{
                              if($type == "ASC"){
                                $arr_link = "landing/DESC";
                              }
                            }
                            ?>
                            <li class="sort-by-name"><a class="sort-by-container" href="<?php print site_url("antavaya/flight-list/{$dep_link}")?>"><span>Keberangkatan</span></a></li>
                            <li class="sort-by-name"><a class="sort-by-container" href="<?php print site_url("antavaya/flight-list/{$arr_link}")?>"><span>Tiba</span></a></li>
                            <li class="sort-by-price"><a class="sort-by-container" href="<?php print site_url("antavaya/flight-list/{$price_link}")?>"><span>Harga</span></a></li>
                            <li id="loading-flight" style="display: none"><img src="<?php print $url?>images/ajax-loader.gif" /></li>
                        </ul>

                    </div>
                    <?php
                    print $this->form_eksternal->form_open(site_url("antavaya/book"), 'id="book_form" role="form"', array())
                    ?>
                    <div class="flight-list listing-style3 flight" id="list">
                      <?php
                      if($data[0]){
                        foreach($data[0] AS $key => $dt){
                          $items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $dt->id_website_flight_temp));
                          $dari_cetak = "";
                          $time_view = "";
                          $time_view_a = "";
                          $fligh_cetak = "";
                          foreach($items AS $t){
                            $dari_cetak .= $this->global_models->array_kota($t->dari)." ke ".$this->global_models->array_kota($t->ke)."<br />";
                            $time_view .= "<li>".date("d M y H:i", strtotime($t->take_off))."</li>";
                            $time_view_a .= "<li>".date("d M y H:i", strtotime($t->landing))."</li>";
                            $fligh_cetak .= "<li>{$t->flight_no}</li>";
                          }
                        ?>
          <article class='box'>
            <figure class='col-xs-3 col-sm-2'>
              <span><img style='max-width: 100px;' alt='' src='<?php print $url."/maskapai/{$dt->img}"?>'></span>
            </figure>
            <div class='details col-xs-9 col-sm-10'>
              <div class='details-wrapper'>
                <div class='first-row'>
                  <div>
                    <h4 class='box-title'><?php print $this->global_models->array_kota($dt->dari)." ke ".$this->global_models->array_kota($dt->ke)?>
                    <small style='text-transform: none'><?php print $dari_cetak?></small></h4>
                    <a class='button btn-mini stop'>
                      <?php 
                      $stop_cetak = "Langsung";
                      if($dt->stop > 1){
                        $stop_cetak = ($dt->stop - 1)." Transit";
                      }
                      print $stop_cetak;?>
                    </a>
                  </div>
                <div>
                  <span class='price' style='text-transform: none'><small style='text-transform: none'><s><?php 
                  if($dt->hemat > 0)
                    print "Rp ".$this->global_models->format_angka_atas($dt->price, 0, ",", ".")
                  ?></s></small>Rp <?php print $this->global_models->format_angka_atas($dt->jual, 0, ",", ".");
                  
                  $diskon_bank = $this->global_models->get_query("SELECT hemat, nilai"
                    . " FROM website_hemat_mega"
                    . " WHERE ('".date("Y-m-d H:i:s")."' BETWEEN mulai AND akhir) AND status = 1");
                  if($diskon_bank[0]->hemat > 0){
                      $dis_mega = $dt->jual * $diskon_bank[0]->hemat/100;
                      $jadi_dis = ceil($dt->jual - $dis_mega);
                    ?>
                    <br />
                    <span style="color: #bd2330">
                        <img src="<?php print $url."images/mega.png"?>" style="max-width: 40px" />Rp <?php print $this->global_models->format_angka_atas($jadi_dis, 0, ",", ".")?></span>
                  <?php 
                  }
                  if($diskon_bank[0]->nilai > 0){
                      $dis_mega = $diskon_bank[0]->nilai;
                      $jadi_dis = ceil($dt->jual - $dis_mega);
                    ?>
                    <br />
                    <span style="color: #bd2330">
                        <img src="<?php print $url."images/mega.png"?>" style="max-width: 40px" />Rp <?php print $this->global_models->format_angka_atas($jadi_dis, 0, ",", ".")?></span>
                  <?php 
                  }
                  ?>
                  </span>
                </div>
              </div>
              <div class='second-row'>
                <div class='time'>
                  <div class='take-off col-sm-4'>
                    <div class='icon'><i class='soap-icon-plane-right yellow-color'></i></div>
                    <div>
                      <span class='skin-color'>Berangkat</span>
                      <ul style="list-style: inherit">
                          <?php print $time_view?>
                      </ul>
                    </div>
                  </div>
                  <div class='landing col-sm-4'>
                    <div class='icon'><i class='soap-icon-plane-right yellow-color'></i></div>
                    <div>
                      <span class='skin-color'>Tiba</span>
                      <ul style="list-style: inherit">
                          <?php print $time_view_a?>
                      </ul>
                    </div>
                  </div>
                  <div class='total-time col-sm-4'>
                    <div class='icon'></div>
                    <div>
                      <span class='skin-color' style='text-transform: none; color: #bd2330;'>
                         <?php
                         if($dt->hemat > 0)
                           print "Hemat Rp ".  $this->global_models->format_angka_atas($dt->hemat, 0, ",", ".");
                         ?>
                      </span>
                        <br />
                      <ul style="list-style: inherit">
                          <?php print $fligh_cetak?>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class='action'>
                  <input name="doce[<?php print $key?>]" value="<?php print $this->encrypt->encode($dt->id_website_flight_temp)?>" style="display: none" />
                  <button name="submit" value="<?php print $key?>" class='button btn-small full-width'>Pesan</button>
                </div>
              </div>
            </div>
          </article>
                        <?php
                        }
                      }
                      ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>