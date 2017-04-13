<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $page[0]->title?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active"><?php print $page[0]->title?></li>
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
            <div class="page">
                <span style="display: none;" class="entry-title page-title">Blog Left Sidebar</span>
                <span style="display: none;" class="vcard"><span class="fn"><a rel="author" title="Posts by admin" href="#">admin</a></span></span>
                <span style="display:none;" class="updated">2014-06-20T13:35:34+00:00</span>
                <div class="post-content">
                    <div class="blog-infinite">
                        <div class="post">
                            <div class="post-content-wrapper">
                                <div class="flexslider photo-gallery style4">
                                    <ul class="slides">
                                        <?php
                                        if($page[0]->file){
                                          print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/page/{$page[0]->file}' alt=''></a></li>";
                                        }
                                        if($gambar){
                                          foreach($gambar AS $gbr){
                                            print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/page/{$gbr->file}' alt=''></a></li>";
                                          }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="details">
                                    <h2 class="entry-title"><a href="<?php site_url("page/index/{$page[0]->nicename}")?>"><?php print $page[0]->title?></a></h2>
                                    <div class="excerpt-container">
                                        <?php print $page[0]->note?>
                                    </div>
<!--                                    <div class="post-meta">
                                        <div class="entry-date">
                                            <label class="date">29</label>
                                            <label class="month">Aug</label>
                                        </div>
                                        <div class="entry-author fn">
                                            <i class="icon soap-icon-user"></i> Posted By:
                                            <a href="#" class="author">Jessica Browen</a>
                                        </div>
                                        <div class="entry-action">
                                            <a href="#" class="button entry-comment btn-small"><i class="soap-icon-comment"></i><span>30 Comments</span></a>
                                            <a href="#" class="button btn-small"><i class="soap-icon-wishlist"></i><span>22 Likes</span></a>
                                            <span class="entry-tags"><i class="soap-icon-features"></i><span><a href="#">Adventure</a>, <a href="#">Romance</a></span></span>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>