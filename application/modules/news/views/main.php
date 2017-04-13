
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $page[0]->title?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active"><a href="<?php print site_url()."news"; ?>">News</a></li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3" style="padding-top:3%">
                <?php
                if($page[0]->nicename == 'tour_%26_leisure'){
                  print $this->global_models->alamat_contact_us("leisure");
                }
                else if($page[0]->nicename == 'conference_%26_exhibition'){
                  print $this->global_models->alamat_contact_us("conference");
                }
                else if($page[0]->nicename == 'inbound_services'){
                  print $this->global_models->alamat_contact_us("destination");
                }
                else{
                  print $this->global_models->alamat_contact_us("corporate");
                }
                ?>
            </div>
            <div id="main" class="col-sm-8 col-md-9">
            <div class="page">
                <span style="display: none;" class="entry-title page-title">Blog Left Sidebar</span>
                <span style="display: none;" class="vcard"><span class="fn"><a rel="author" title="Posts by admin" href="#">admin</a></span></span>
                <span style="display:none;" class="updated">2014-06-20T13:35:34+00:00</span>
                <div class="post-content">
                                   
<div class="hotel-list">
                  <div class="row image-box hotel listing-style1">
                    <div id="data_list"></div>
                    
                      <?php
                     foreach ($list as $value) {
                    ?> 
                  <!--  <div class="col-sm-6 col-md-4">
                          <article class="box">
                              <figure>
                               <?php if($value->file){
                                          print "<a href='javascript:void(0)' class='hover-effect popup-gallery'><img style=' max-width:270px; max-height:160px;' src='".base_url()."files/antavaya/news/{$value->file}' alt=''></a>";
                                            }
                                              ?>
                                  
                              </figure>
                              <div class="details">

                                  <h5 class="box-title"><a href="<?php print site_url()."news/detail/{$value->nicename}"; ?>"><?php print $value->title; ?></a></h5>

                                  <p class="description"><?php 
                                  $words = explode(" ", $value->note);
                                 print implode(" ", array_splice($words, 0, 25));
                                 print "  <a style='font-size: 12px; margin-top: 0' href='".site_url("news/detail/{$value->nicename}")."' title='' class='button'>Read More</a>" 
                                 ?> </p>

                              </div>
                          </article>
                      </div> -->
                    <?php } ?>
                  </div>
              </div>
                    
                    <div class="box-footer clearfix" id="halaman_set">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
    </ul>
                        </div>
                  <!--  <div class="blog-infinite">
                        <div class="post">
                            <div class="post-content-wrapper">
                                            <figure class="image-container">
                                              <?php
                                   foreach ($list as $value) {
                                                                
                                     if($value->file){
                                          print "<a href='javascript:void(0)' class='hover-effect'><img style=' max-width:870px; max-height:342px;' src='".base_url()."files/antavaya/news/{$value->file}' alt=''></a>";
                                            }
                                              ?>
                                              
                                            </figure>
                                            <div class="details">
                                                <h2 class="entry-title"><a href="pages-blog-read.html"><?php print $value->title ?></a></h2>
                                                <div class="excerpt-container">
                                                    <p><?php print $value->note; ?></p>
                                                </div>
                                             
                                               <div class="entry-date">
                                                        <label class="date"><?php print date("d", strtotime($value->create_date));?></label>
                                                        <label class="month"><?php print date("M", strtotime($value->create_date));?></label>
                                                    </div>
                                              
                                            </div>
                              <br>
                                    <?php } ?>
                                        </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div> 
    </div>
</section>