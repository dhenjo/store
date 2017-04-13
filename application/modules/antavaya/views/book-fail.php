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
            <h2 class="entry-title">Gagal</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Gagal</li>
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
                    <h2>Booking Gagal</h2>
                    <hr />
                    <div class="booking-confirmation clearfix">
                        <i class="icon circle"></i>
                        <div class="message">
                            <h4 class="main-message">Mohon Maaf Proses Booking Gagal.</h4>
                            <p>Terjadi kesalahan dalam proses atau waktu proses telah habis.<br />
                                Silahkan melakukan <a href="<?php print site_url()?>" style="color: blue">Booking Ulang</a></p>
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