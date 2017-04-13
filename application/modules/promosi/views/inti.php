<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">FIT & Packages</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active">FIT & Packages</li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us("leisure")?>
                <div class="toggle-container filters-container">
                  <div class="panel style1 arrow-right">
                      <h4 class="panel-title">
                          <a data-toggle="collapse" href="#price-filter" class="collapsed">Harga</a>
                      </h4>
                      <div id="price-filter" class="panel-collapse collapse">
                          <div class="panel-content">
                              <div id="price-range"></div>
                              <br />
                              <span class="min-price-label pull-left"></span>
                              <span class="max-price-label pull-right"></span>
                              <div class="clearer"></div>
                          </div><!-- end content -->
                      </div>
                  </div>
                  <div class="panel style1 arrow-right">
                      <?php
                      print $this->form_eksternal->form_input("hargaa", 0, "id='hargaa' style='display: none'");
                      print $this->form_eksternal->form_input("hargab", 8000, "id='hargab' style='display: none'");
                      ?>
                      <a href="javascript:void(0)" onclick="filter_promosi()" class="button" style="width: 100%; font-size: 20px">Filter</a>
                  </div>
                </div>
            </div>
            <div id="main" class="col-sm-8 col-md-9">
                <div class="sort-by-section clearfix box">
                    <h4 class="sort-by-title block-sm">Urut berdasarkan:</h4>
                    <?php
                    $sel = array();
                    if($this->session->userdata("promosi_sort") == 1){
                      $sel[1] = "selected";
                    }
                    else if($this->session->userdata("promosi_sort") == 2){
                      $sel[2] = "selected";
                    }
                    else if($this->session->userdata("promosi_sort") == 3){
                      $sel[3] = "selected";
                    }
                    else if($this->session->userdata("promosi_sort") == 4){
                      $sel[4] = "selected";
                    }
                    else{
                      $sel[3] = "selected";
                    }
                    ?>
                        <select id="sorting" name="search" style="margin: 15px">
                            <!--<option value="0">00</option>-->
                            <option value="1" <?php print $sel[1]?>>A-Z</option>
                            <option value="2" <?php print $sel[2]?>>Z-A</option>
                            <option value="3" <?php print $sel[3]?>>Harga Rendah-Tinggi</option>
                            <option value="4" <?php print $sel[4]?>>Harga Tinggi-Rendah</option>
                        </select>
                </div>
                <div class="image-box style9 column-3">
                    <?php
                    foreach($data AS $dt){
                    ?>
                    <article class="box">
                        <?php
                        if($dt->file_temp){
                        ?>
                        <figure>
                            <a href="<?php print site_url("promosi/detail/{$dt->nicename}")?>" title="" class="hover-effect yellow">
                                <img src="<?php print base_url()."files/antavaya/promosi/{$dt->file_temp}"?>" alt="" width="160" /></a>
                        </figure>
                        <?php
                        }
                        ?>
                        <div class="details">
                            <h4 style='min-height: 175px; color: #bd2330'><?php print $dt->title?><br />
                                <small style='color: black'><?php print $dt->sub_title?>
                                <br /><span style='font-size: 11px; color: #727070'><?php print $dt->summary?></span></small></h4>
                            <a style="margin-top: 0" href="<?php print site_url("promosi/detail/{$dt->nicename}")?>" title="" class="button">Detail</a>
                        </div>
                    </article>
                    <?php
                    }
                    ?>
                </div>
                <div id="lolo">
                  
                </div>
                <input type="text" value="<?php print $count?>" name="count" id="count" style="display: none" />
                <input type="text" value="8" name="kondisi" id="kondisi" style="display: none" />
                <?php
                if($count > 8){
                ?>
                <a href="javascript:void(0)" id="lainnya-b" class="button uppercase full-width btn-large" onclick="load_more()">Lainnya</a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>