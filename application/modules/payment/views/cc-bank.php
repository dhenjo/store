<style>
  .ui-datepicker-month{
      color: black !important;
  }
  .ui-datepicker-year{
      color: black !important;
  }
</style>
<?php
$title = array(
  3 => "Pembayaran Dengan Master/VISA",
  2 => "Pembayaran Dengan Credit Card MEGA",
  4 => "Pembayaran Dengan MEGA Priority",
);
?>
<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title"><?php print $title[$type]?></h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active"><?php print $title[$type]?></li>
        </ul>
    </div>
</div>
<section id="content" class="gray-area">
    <div class="container">
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <?php
                print $this->form_eksternal->form_open(site_url("payment/konfirm-cc-bank"), 'role="form" ', 
                  array("id_tiket_payment" => $tiket[0]->id_tiket_payment));
                ?>
                <div class="booking-information travelo-box">
                    <h2>Detail Pembayaran</h2>
                    <dl class="term-description">
                        <dt>Book Code</dt>
                          <dd><?php print $book_code?></dd>
                        <dt>Harga Tiket</dt>
                          <dd>Rp <?php print $this->global_models->format_angka_atas($tiket[0]->price)?></dd>
                        <dt>Diskon</dt>
                          <dd>Rp <?php print $this->global_models->format_angka_atas(($tiket[0]->diskon*-1))?></dd>
                        <dt>Convenience Fee</dt>
                          <dd>Rp <?php print $this->global_models->format_angka_atas($tiket[0]->conf_fee)?></dd>
                        <dt><b>Yang Harus Dibayar</b></dt>
                          <dd style="color: #bd2330; font-size: 20px; font-weight: bold">
                              Rp <?php print $this->global_models->format_angka_atas($tiket[0]->total)?></dd>
                    </dl>
                    <button class="btn btn-primary">Lanjutkan</button>
                </div>
              </form>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>