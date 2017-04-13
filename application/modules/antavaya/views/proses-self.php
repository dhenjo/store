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
            <h2 class="entry-title">Proses Booking</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Proses Booking</li>
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
                  <li class='active'><a>Proses Booking</a></li>
                  <li><a>Hasil Booking</a></li>
                </ul>
                <br />
            </div>
        </div>
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <h2>Mohon Tunggu <small>Proses Booking Sedang Dilakukan</small></h2>
                <label>Proses <span id="info_proses">1</span> dari 4 (<span id="info_persen">1</span>%)<span id="catatan"></span></label>
                <div class="progress sm progress-striped active">
                    <div id="bar_proses" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 1%; background-color: #1a6ea5">
                    </div>
                </div>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>