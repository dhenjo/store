<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Group Tour</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active">Group Tour</li>
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
            <div id="main" class="col-sm-8 col-md-9 travelo-box travel-ideas">
            <div class="page">
                <div class="post-content">
                    <div class="blog-infinite">
                        <div class="post">
                            <div class="post-content-wrapper">
                                <div class="flexslider photo-gallery style4">
                                  <a href='javascript:void(0)'><img src='<?php print base_url("files/antavaya/html/1412224683.jpg");?>' alt=''></a>  
                                 <!-- <ul class="slides">
                                      
                                      <?php
                                        print "<li><a href='javascript:void(0)'><img src='".base_url()."files/antavaya/html/1412224683.jpg' alt=''></a></li>";
                                        ?>
                                    </ul> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
              <?php
             
              if($category == 1){
                $category1 = "selected-effect";
              }else{
                $category1 = "hover-effect";
              }
              
              if($category == 2){
                 $category2 = "selected-effect";
              }else{
                $category2 = "hover-effect";
              }
              
              if($category == 3){
                 $category3 = "selected-effect";
              }else{
                $category3 = "hover-effect";
              }
              
              if($category == 4){
                 $category4 = "selected-effect";
              }else{
                $category4 = "hover-effect";
              }
              ?>
                <h2 class="idea-title"><span class="index">1</span>Pilih Season</h2>
                <div class="column-4 image-box suggestions">
                    <div class="box">
                        <input id="hight1_cek" type="text" value="2" style="display: none" />
                       <!-- <a href="javascript:void(0)" id="hight1" class="selected-effect style1 season" onclick="cek_show(1)"> -->
                       <a href="<?php echo base_url("grouptour/index/1/{$sub_category}");?>" id="hight1" class="<?php print $category1; ?> style1 season" >     
                              <img src="<?php print $url."images/low-season.png"?>" alt="">
                        </a>
                    </div>
                    <div class="box">
                        <input id="hight2_cek" type="text" value="1" style="display: none" />
                       <!-- <a href="javascript:void(0)" id="hight2" class="<?php print $category1; ?> style1 season" onclick="cek_show(2)"> -->
                        <a href="<?php print base_url("grouptour/index/2/{$sub_category}");?>" id="hight2" class="<?php print $category2; ?> style1 season">    
                            <img src="<?php print $url."images/hight-season.png"?>" alt="">
                        </a>
                    </div>
                    <div class="box">
                        <input id="hight3_cek" type="text" value="1" style="display: none" />
                       <!-- <a href="javascript:void(0)" id="hight3" class="<?php print $category1; ?> style1 season" onclick="cek_show(3)"> -->
                        <a href="<?php print base_url("grouptour/index/3/{$sub_category}");?>" id="hight3" class="<?php print $category3; ?> style1 season">    
                        <img src="<?php print $url."images/hight-season1.png"?>" alt="">
                        </a>
                    </div>
                    <div class="box">
                        <input id="hight4_cek" type="text" value="1" style="display: none" />
                        <a href="javascript:void(0)" id="hight4" class="<?php print $category1; ?> style1 season" onclick="cek_show(4)">
                         <!-- <a href="javascript:void(0)" id="hight4" class="<?php print $category1; ?> style1 season" onclick="cek_show(4)"> -->
                          <a href="<?php print base_url("grouptour/index/4/{$sub_category}");?>" id="hight4" class="<?php print $category4; ?> style1 season">  
                          <img src="<?php print $url."images/school-season.png"?>" alt="">
                        </a>
                    </div>
                </div>
                
                <h2 class="idea-title"><span class="index">2</span>Pilih Tujuan</h2>
              
                 <?php
       
              if($sub_category == 1){
                $sub_category1 = "selected-effect";
              }else{
                $sub_category1 = "hover-effect";
              }
              
              if($sub_category == 2){
                 $sub_category2 = "selected-effect";
              }else{
                $sub_category2 = "hover-effect";
              }
              
              if($sub_category == 3){
                 $sub_category3 = "selected-effect";
              }else{
                $sub_category3 = "hover-effect";
              }
              
              if($sub_category == 4){
                 $sub_category4 = "selected-effect";
              }else{
                $sub_category4 = "hover-effect";
              }
              
              if($sub_category == 5){
                 $sub_category5 = "selected-effect";
              }else{
                $sub_category5 = "hover-effect";
              }
              
              if($sub_category == 6){
                 $sub_category6 = "selected-effect";
              }else{
                $sub_category6 = "hover-effect";
              }
              ?>
                <div class="row image-box style1 add-clearfix" >
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                            <a href="<?php print base_url("grouptour/index/{$category}/1");?>" title="" class="<?php print $sub_category1;?> tujuan">    
                              <img src="<?php print base_url()."files/antavaya/html/eropa.png"?>" alt=""/></a>
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/1");?>">Eropa</a></h6>
                            </div>
                        </article>
                    </div>
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                            <a href="<?php print base_url("grouptour/index/{$category}/2");?>"  title="" class="<?php print $sub_category2;?> tujuan"><img src="<?php print base_url()."files/antavaya/html/africa.png"?>" alt=""/></a>
                           
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/2");?>">Middle East & Africa</a></h6>
                            </div>
                        </article>
                    </div>
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                            <a href="<?php print base_url("grouptour/index/{$category}/3");?>" title="" class="<?php print $sub_category3;?> tujuan"><img src="<?php print base_url()."files/antavaya/html/america.png"?>" alt=""/></a>
                            
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/3");?>">America</a></h6>
                            </div>
                        </article>
                    </div>
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                             <a href="<?php print base_url("grouptour/index/{$category}/4");?>" title="" class="<?php print $sub_category4;?> tujuan"><img src="<?php print base_url()."files/antavaya/html/australia.png"?>" alt=""/></a>
                            
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/4");?>">Australia & New Zealand</a></h6>
                            </div>
                        </article>
                    </div>
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                            <a href="<?php print base_url("grouptour/index/{$category}/5");?>" title=""  class="<?php print $sub_category5;?> tujuan"><img src="<?php print base_url()."files/antavaya/html/asia.png"?>" alt=""/></a>
                            
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/5");?>" >Asia</a></h6>
                            </div>
                        </article>
                    </div>
                    <div class="col-sms-6 col-sm-6 col-md-2">
                        <article class="box">
                            <a href="<?php print base_url("grouptour/index/{$category}/6");?>" title="" class="<?php print $sub_category6;?> tujuan"><img src="<?php print base_url()."files/antavaya/html/china.png"?>" alt=""/></a>
                            
                            <div class="details">
                                <h6 class="box-title"><a href="<?php print base_url("grouptour/index/{$category}/6");?>">China</a></h6>
                            </div>
                        </article>
                    </div>
                </div>
                
                <h2 class="idea-title"><span class="index">3</span>Pilih Paket</h2>
                <?php
                
                foreach($list AS $ke => $ls){
                  foreach($ls AS $yg => $st){
                    
                ?>
                <div  class="suggested-places paket" id="paket_eropa<?php print $ke?>_<?php print $yg?>">
                    <div class="overflow-hidden">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="check-square box">
                                    <?php print $st?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                  }
                }
                ?>
            </div>
        </div>
    </div>
</section>