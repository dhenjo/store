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
            <h2 class="entry-title">Pembayaran Dengan Transfer Bank (BCA)</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">HOME</a></li>
            <li class="active">Pembayaran Dengan Transfer Bank (BCA)</li>
        </ul>
    </div>
</div>

<?php
                if($this->session->flashdata('notice')){
                ?>
                <div class="alert alert-danger alert-dismissable" style="color: black">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <b>Filed!</b> <?php print $this->session->flashdata('notice')?>
                </div>
                <?php
                }
                if($this->session->flashdata('success')){
                ?>
                <div class="alert alert-success alert-dismissable" style="color: black">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    <b>Success!</b> <?php print $this->session->flashdata('success')?>
                </div>
                <?php
                }?>
<section id="content" class="gray-area">
    <div class="container">
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <?php
                print $this->form_eksternal->form_open(site_url("payment/cek-bca"), 'role="form" ', 
                  array("id_tiket_payment" => $tiket[0]->id_tiket_payment));
                ?>
                <div class="booking-information travelo-box">
                    <h2>Transfer</h2>
                    <p>Silahkan Transfer ke BCA </p>
                    <dl class="term-description">
                        <dt>Bank</dt>
                          <dd>BCA</dd>
                        <dt>Atas Nama</dt>
                          <dd>Antonia</dd>
                        <dt>No Rekening</dt>
                          <dd>535-018-7938</dd>
                        <dt>Jumlah</dt>
                        <dd>Rp <?php print $this->global_models->format_angka_atas($tiket[0]->total)?></dd>
                        <dt>Status</dt>
                          <dd><?php 
                          $status = array(
                            1 => "<span class='label label-default'>Proses</span>",
                            2 => "<span class='label label-warning'>Cancel</span>",
                            3 => "<span class='label label-success'>Done</span>"
                          );
                          print $status[$tiket[0]->status];?></dd>
                    </dl>
                    <?php if($tiket[0]->status == 1){?>
                      <button class="btn btn-primary">Konfirmasi Transfer</button>
                    <?php }?>
                </div>
              </form>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>