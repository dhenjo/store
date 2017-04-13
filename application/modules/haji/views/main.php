<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Haji</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active">Haji</li>
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
                <div class="image-box style9 column-4">
                    <?php
                    foreach($data AS $dt){
                    ?>
                    <article class="box" style="height: 300px">
                        <?php
                        if($dt->file_temp){
                        ?>
                        <figure>
                            <a href="<?php print site_url("haji/detail/{$dt->nicename}")?>" title="" class="hover-effect yellow">
                                <img src="<?php print base_url()."files/antavaya/haji/{$dt->file_temp}"?>" alt="" width="160" height="160" style="max-height: 160px" /></a>
                        </figure>
                        <?php
                        }
                        ?>
                        <div class="details">
                            <h4 class="box-title" style="height: 75px"><?php print $dt->title?>
                                <small><?php print $dt->sub_title?></small></h4>
                            <a href="<?php print site_url("haji/detail/{$dt->nicename}")?>" title="" class="button">Detail</a>
                        </div>
                    </article>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>