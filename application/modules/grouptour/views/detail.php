<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $group[0]->title?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li><a href="<?php print site_url("grouptour")?>">Group Tour</a></li>
            <li class="active"><?php print $group[0]->title?></li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3">
                <?php
                print $this->global_models->alamat_contact_us("leisure");
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
                                        if($group[0]->file){
                                          print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/grouptour/{$group[0]->file}' alt=''></a></li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="details">
                                    <h2 class="entry-title" style="text-align: center"><a href="<?php site_url("grouptour/detail/{$group[0]->nicename}")?>"><?php print $group[0]->title?></a></h2>
                                    <h4 class="entry-title" style="text-align: center"><?php print $group[0]->sub_title?><br /><?php print $group[0]->summary?></h4>
                                    <div class="excerpt-container">
                                        <?php print $group[0]->note;
//                                        if($group[0]->link){
//                                          print "<iframe width='100%' style='height: 500px' src='{$group[0]->link}'></iframe>";
//                                        }
                                        ?>
                                        <div id="dialog-form" title="Book Now">
                                          <form>
                                            <fieldset>
                                              <label for="name">Nama</label>
                                              <input type="text" name="name" id="name" style="width: 100%">
                                              <input type="text" value="<?php print $group[0]->id_website_group_tour?>" name="idwebsite_group_tour" id="id_website_group_tour" style="display: none">
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
                                              <?php if($group[0]->link){?>
                                            <a target="_blank" class="button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" href="<?php print base_url()."files/antavaya/grouptour/{$group[0]->link}"?>">Download Itinerary</a><?php }?>
                                          </div>
                                              
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
    </div>
</section>