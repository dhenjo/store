<style>
  .ui-datepicker-month{
      color: black !important;
  }
  .ui-datepicker-year{
      color: black !important;
  }
</style>
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Hasil Booking</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Hasil Booking</li>
        </ul>
    </div>
</div>
<section id="content" class="gray-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-9">
                <ul class='nav nav-wizard'>
                  <li><a href='<?php print site_url()?>'>Cari Penerbangan</a></li>
                  <li><a>Informasi Penumpang</a></li>
                  <li><a>Proses Booking</a></li>
                  <li class='active'><a>Hasil Booking</a></li>
                </ul>
                <br />
            </div>
        </div>
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <div class="booking-information travelo-box">
                    <h2>Mohon Maaf</h2>
                    <hr />
                    <div class="booking-confirmation clearfix">
                        <i class="soap-icon-recommend icon circle"></i>
                        <div class="message">
                            <h4 class="main-message">Mohon Maaf. System Sedang dalam Perbaikan.</h4>
                            
                        </div>
                    </div>
                    <hr />
                    
                    
                </div>
                
               
               
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>