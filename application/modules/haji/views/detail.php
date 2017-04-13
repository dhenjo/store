<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $haji[0]->title?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li><a href="<?php print site_url('haji')?>">Haji</a></li>
            <li class="active"><?php print $haji[0]->title?></li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us("haji")?>
            </div>
            <div id="main" class="col-sm-8 col-md-9">
                <div class="page">
                  <style>
                      #nbs td {
                          padding-left: 10px;
                      }
                      #nbs th {
                          text-align: center;
                      }
                      #nbs ul {
                          list-style: disc outside;
                          margin-left: 25px;
                          font-size: 14px;
                      }
                  </style>
                  <div class="post-content">
                      <div class="blog-infinite">
                          <div class="post">
                              <div class="post-content-wrapper">
                                  <div class="flexslider photo-gallery style4">
                                      <ul class="slides">
                                          <?php
                                        if($haji[0]->file){
                                          print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/haji/{$haji[0]->file}' alt=''></a></li>";
                                        }
                                        if($gambar){
                                          foreach($gambar AS $gbr){
                                            print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/haji/{$gbr->file}' alt=''></a></li>";
                                          }
                                        }
                                        ?>
                                      </ul>
                                  </div>
                              </div>
                              <div class="details" id="nbs">
                                <h3><?php print $haji[0]->title?></h3>
                                <h4><?php print $haji[0]->sub_title?></h4>
                                <?php 
                                print $haji[0]->note;
//                                if($promosi[0]->file_pdf){
//                                  print "<iframe width='100%' style='height: 500px' src='".base_url()."files/antavaya/promosi/{$promosi[0]->file_pdf}'></iframe>";
//                                }
                                ?>
                                <div id="dialog-form" title="Book Now">
                                  <form>
                                    <fieldset>
                                      <label for="name">Nama</label>
                                      <input type="text" name="name" id="name" style="width: 100%">
                                      <input type="text" value="<?php print $haji[0]->id_website_haji?>" name="id_website_haji" id="id_website_haji" style="display: none">
                                      <br />
                                      <label for="email">Email *</label>
                                      <input type="text" name="email" id="email" style="width: 100%">
                                      <br />
                                      <label for="password">No Telp</label>
                                      <input type="text" name="telp" id="telp" style="width: 100%">
                                      <br />
                                      <label for="note">Note</label>
                                      <textarea name="note" id="note" style="width: 100%;background-color: white" rows="9"></textarea>
                                    </fieldset>
                                  </form>
                                </div>
                                <p>&nbsp;</p>
                                <div class="row">
                                  <div class="col-md-6" style="text-align: left; font-size: 16px">
                                    <a target="_blank" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" href="<?php print base_url()."files/antavaya/haji/{$haji[0]->file_pdf}"?>">Download Itinerary</a></div>
                                <div class="col-md-6" style="text-align: right; font-size: 16px"><a id="book-now" class="button" href="javascript:void(0)">Inquiry</a></div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>