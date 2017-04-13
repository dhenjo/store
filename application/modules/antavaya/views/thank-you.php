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
                    <h2>Terima Kasih</h2>
                    <hr />
                    <div class="booking-confirmation clearfix">
                        <i class="soap-icon-recommend icon circle"></i>
                        <div class="message">
                            <h4 class="main-message">Terima Kasih. Booking tiket telah berhasil.</h4>
                            <p>Detail dan metode pembayaran telah diinformasikan ke email anda.</p>
                        </div>
                    </div>
                    <hr />
                    <h2>Information Pemesan</h2>
                    <dl class="term-description">
                        <dt>Nomor Booking </dt><dd><?php print $tiket_book->flight[0]->book_code?></dd>
                        <dt>Penerbangan </dt><dd><?php print $this->global_models->array_kota($tiket_book->flight[0]->dari)." - ".$this->global_models->array_kota($tiket_book->flight[0]->ke)?></dd>
                        <dt>No Penerbangan </dt><dd><?php 
                        foreach($tiket_book->flight[0]->penerbangan AS $fi){
                          print $fi->flight_no." ({$fi->dari}-{$fi->ke}) ".date("Y/M/d H:i", strtotime($fi->departure))."-".date("H:i", strtotime($fi->arrive))."<br />";
                        }?></dd>
                        
                        <?php
                        if($tiket_book->flight[1]){?>
                        <dt>Nomor Booking Kembali</dt><dd><?php print $tiket_book->flight[1]->book_code?></dd>
                        <dt>Penerbangan Kembali</dt><dd><?php print $this->global_models->array_kota($tiket_book->flight[1]->dari)." - ".$this->global_models->array_kota($tiket_book->flight[1]->ke)?></dd>
                        <dt>No Penerbangan Kembali</dt><dd><?php 
                        foreach($tiket_book->flight[1]->penerbangan AS $fi2nd){
                          print $fi2nd->flight_no." ({$fi2nd->dari}-{$fi2nd->ke}) ".date("Y/M/d H:i", strtotime($fi2nd->departure))."-".date("H:i", strtotime($fi2nd->arrive))."<br />";
                        }?></dd>
                        <?php }?>
                        <dt>Batas Waktu Pembayaran </dt><dd><?php print date("d F Y H:i:s",strtotime($tiket_book->book->timelimit))?></dd>
                        <dt>Nama</dt><dd><?php print $tiket_book->pemesan->title." ".$tiket_book->pemesan->first_name." ".$tiket_book->pemesan->last_name?></dd>
                        <dt>Telepon</dt><dd><?php print $tiket_book->pemesan->phone?></dd>
                        <dt>E-mail</dt><dd><?php print $tiket_book->pemesan->email?></dd>
                    </dl>
                </div>
                <div class="booking-information travelo-box">
                    <h2>Information Penumpang</h2>
                    <?php
                    $type = array(
                      1 => "Adult",
                      2 => "Child",
                      3 => "Infant"
                    );
                    foreach($tiket_book->passenger AS $kp){
                    ?>
                    <dl class="term-description">
                        <dt>Name</dt><dd><?php print "{$kp->title} {$kp->first_name} {$kp->last_name}"?></dd>
                        <dt>Tanggal Lahir</dt><dd><?php print date("d F Y",strtotime($kp->tanggal_lahir))?></dd>
                        <dt>Type</dt><dd><?php print $type[$kp->type]?></dd>
                        <?php
                        if($kp->type == 3)
                          print "<dt>Pax</dt><dd>{$kp->pax}</dd>";
                        ?>
                    </dl>
                    <?php }?>
                </div>
                <div class="booking-information travelo-box">
                    <h2>Rincian Harga</h2>
                    <dl class="term-description">
                        <dt>Harga</dt><dd>Rp <?php print $this->global_models->format_angka_atas(($tiket_book->book->harga_bayar + $tiket_book->book->diskon), 0, ",", ".")?></dd>
                        <dt>Diskon</dt><dd>Rp <?php print $this->global_models->format_angka_atas($tiket_book->book->diskon, 0, ",", ".")?></dd>
                        <dt>Total Harga</dt><dd style='color: #bd2330; font-size: 20px'>Rp <?php print $this->global_models->format_angka_atas($tiket_book->book->harga_bayar, 0, ",", ".")?></dd>
                        <?php
                        if($tiket_book->book->status == 1){
                          $bank_payment = array(
                            1 => array("bca.png", "BCA"),
                            2 => array("mega.png", "Credit Card Mega"),
                            3 => array("visa.png", "Visa/Master"),
                            4 => array("mega.png", "Mega Priority"),
                          );
                          foreach($tiket_book->diskon_payment AS $k => $dp){
                            print "<dt><img src='{$url}images/{$bank_payment[$k][0]}' width='50' /> <br />{$bank_payment[$k][1]}</dt><dd style='color: #1a6ea5; font-size: 22px'>Rp ".$this->global_models->format_angka_atas(($tiket_book->book->harga_bayar - $dp->diskon), 0, ",", ".")."</dd>";
                          }
                        }
                        
                        $status_tiket = array(
                          1 => "Book",
                          2 => "Expired",
                          3 => "Issued",
                          4 => "Expired",
                          5 => "Issued",
                        );
                        ?>
                        <dt>Status</dt><dd><?php print $status_tiket[$tiket_book->book->status]?></dd>
                        <?php
                        $payment = $this->global_models->get("tiket_payment", array("book_code" => $tiket_book->flight[0]->book_code));
                        if($payment){
                          $this->session->set_userdata(array("temp_id_tiket_payment" => $payment[0]->id_tiket_payment));
                          $payment_method = array(
                            1 => "<a href='".site_url("payment/gunakan-bca/{$tiket_book->flight[0]->book_code}")."'>Transfer BCA</a>",
                            3 => "<a href='".site_url("payment/gunakan-cc-bank/3/{$tiket_book->flight[0]->book_code}")."'>Visa/Master</a>",
                            2 => "<a href='".site_url("payment/gunakan-cc-bank/2/{$tiket_book->flight[0]->book_code}")."'>Mega Credit Card</a>",
                            4 => "<a href='".site_url("payment/gunakan-cc-bank/4/{$tiket_book->flight[0]->book_code}")."'>Mega Priority</a>"
                          );
                          $payment_status = array(
                            1 => "<span class='label label-warning'>Proses</span>",
                            2 => "<span class='label label-danger'>Cancel</span>",
                            3 => "<span class='label label-success'>Done</span>"
                          );
                          foreach($payment AS $py){
                            print "<dt>Payment Methode</dt><dd style='color: blue'>"
                            . "{$payment_method[$py->type]}"
                            . "</dd>"
                            . "<dt>Payment Status</dt><dd>{$payment_status[$py->status]}</dd>";
                          }
                        }
                        ?>
                    </dl>
                </div>
                <?php
                if($tiket_book->book->status == 1){
                ?>
                <div class="booking-information travelo-box">
                    <h2>Bayar Dengan</h2>
                    <hr />
                    <dl class="term-description" style="text-transform: none; text-align: center">
                        <?php
                        $agent_privilege = $this->nbscache->get_explode("store", "privilege");
                        if($this->session->userdata("id_privilege") != $agent_privilege[1]){
                        ?>
                        <dd style="text-transform: none;width: 20%;">
                          <a href="<?php print site_url("payment/gunakan-bca/{$tiket_book->flight[0]->book_code}")?>">
                            <img src="<?php print $url."images/bca.png"?>" style="max-width: 100px" /><br />
                            Transfer BCA
                          </a>
                        </dd>
                        <dd style="text-transform: none;width: 20%;">
                          <a href="http://tiket.antavaya.com/index.php/component/mandiripayment/?view=mandiripayment&layout=default&thepnr=<?php print $tiket_book->flight[0]->book_code?>" target="_blank">
                            <img src="<?php print $url."images/mandiri.png"?>" style="max-width: 100px" /><br />
                            Mandiri ClickPay
                          </a>
                        </dd>
                        
                        <dd style="text-transform: none;width: 20%;">
                          <a href="<?php print site_url("payment/gunakan-cc-bank/3/{$tiket_book->flight[0]->book_code}")?>">
                            <img src="<?php print $url."images/visa.png"?>" style="max-width: 100px" /><br />
                            Credit Card (Visa/Master)
                          </a>
                        </dd>
                        <dd style="text-transform: none;width: 20%;">
                          <a href="<?php print site_url("payment/gunakan-cc-bank/2/{$tiket_book->flight[0]->book_code}")?>">
                            <img src="<?php print $url."images/mega.png"?>" style="max-width: 100px" /><br />
                            Credit Card Bank MEGA
                          </a>
                        </dd>
                        <dd style="text-transform: none;width: 20%;">
                          <a href="<?php print site_url("payment/gunakan-cc-bank/4/{$tiket_book->flight[0]->book_code}")?>">
                            <img src="<?php print $url."images/mega.png"?>" style="max-width: 100px" /><br />
                            MegaFirst Infinite CC
                          </a>
                        </dd>
                        <?php
                        }
                        else{
                        ?>
                        <dd style="text-transform: none;width: 20%;">
                          <a href="<?php print site_url("flight/book-store")?>" target="_blank">
                            <img src="<?php print $url."images/logo.png"?>" style="max-width: 100px" /><br />
                            Agent AntaVaya
                          </a>
                        </dd>
                        <?php
                        }
                        ?>
                    </dl>
                </div>
                <?php }?>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>