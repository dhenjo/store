<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Terms & Contidions</h2>
        </div>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <!--<h2>Accordions 01</h2>-->
                <div class="toggle-container box" id="accordion1">
                    <?php
                    foreach($terms AS $ky => $fq){
                    ?>
                    <div class="panel style1">
                        <h4 class="panel-title">
                            <a class="collapsed" href="#acc<?php print $ky?>" data-toggle="collapse" data-parent="#accordion1"><?php print $fq->title?></a>
                        </h4>
                        <div class="panel-collapse collapse" id="acc<?php print $ky?>">
                            <div class="panel-content">
                                <?php print str_replace("<ul>", "<ul class='decimal box'>", $fq->note)?>
                            </div><!-- end content -->
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>