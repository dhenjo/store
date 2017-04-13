<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $list[0]->title?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li><a href="<?php print site_url("news")?>">News</a></li>
            <li class="active"><?php print $list[0]->title?></li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3">
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
                        <div class="post">
                            <figure class="image-container">
                               <?php if($list[0]->file){
                                          print "<a href='javascript:void(0)'><img style=' max-width:870px; max-height:342px;' src='".base_url()."files/antavaya/news/{$list[0]->file}' alt=''></a>";
                                            }
                                              ?>
                                
                            </figure>
                            <div class="details" style='  background: #fff;
  padding: 20px 20px 10px;'>
                                <h1 class="entry-title"><?php print $list[0]->title; ?></h1>
                                <div class="post-content">
                                    <p><?php print $list[0]->note; ?></p></div>
                               <?php if($list[0]->file){ ?>
                                  <div class="post-meta">
                                      <div class="entry-date">
                                          <label class="date"><?php print date("d", strtotime($list[0]->create_date));?></label>
                                          <label class="month"><?php print date("M", strtotime($list[0]->create_date));?></label>
                                      </div>
                                  </div>
                                <?php } ?>
                            </div>
                          <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_detail" => $list[0]->id_website_news))?>
                            <div class="single-navigation block">
                               <?php print $this->form_eksternal->form_hidden('title', $list[0]->title);?>
            
                                <div class="row">
                                  <?php if($list[0]->id_website_news != $data[0]->min){ ?>
                                  <div class="col-xs-6"><button value='data' name='previous' class=" button btn-large prev full-width" type="submit"><i class="soap-icon-longarrow-left"></i><span>Previous Post</span></button></div>
                                  <?php } if($list[0]->id_website_news != $data[0]->max){ ?>
                                  <div class="col-xs-6"><button value='data1' name='next' class=" button btn-large next full-width" type="submit"><i class="soap-icon-longarrow-right"></i><span>Next Post</span></button></div>
                                  <?php } ?>
                                </div>
                            </div>
                            </form>
                          

                        </div>
                    </div>
            </div>
    </div>
</section>