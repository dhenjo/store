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
            <li class="active">Terima Kasih</li>
        </ul>
    </div>
</div>
<section id="content" class="gray-area">
    <div class="container">
        <div class="row">
            <div id="main" class="col-sm-8 col-md-9">
                <div class="booking-information travelo-box">
                    <h2>Terima Kasih</h2>
                    <hr />
                    <div class="booking-confirmation clearfix">
                        <i class="soap-icon-recommend icon circle"></i>
                        <div class="message">
                            <h4 class="main-message">Berikut adalah pembayaran yang telah anda lakukan.</h4>
                            <?php
                            if($tiket[0]->sts == 3){
                              print "<p></p>";
                            }
                            else if($tiket[0]->status == 3){
                              print "<p>Issued Tiket Gagal. Mohon Hubungi nugroho.budi@antavaya.com dan sertakan Code Book {$tiket[0]->book_code}</p>";
                            }
                            else{
                              print "<p>Mohon Lunasi Tagihan Anda</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <hr />
                    <h2>Detail Pembayaran</h2>
                    <table width="100%">
                        <?php
                        $debit = $kredit = 0;
                        foreach($tiket AS $tkt){
                        ?>
                        <tr>
                            <td><?php print date("d F Y",strtotime($tkt->create_date))?></td>
                            <td><?php print $tkt->book_code?></td>
                            <td style="text-align: right"><?php print number_format($tkt->total,0,",",".")?></td>
                            <td style="text-align: right"></td>
                        </tr>
                        <?php
                          $debit += $tkt->total;
                        }
                        
                        foreach($tiket2 AS $tkt2){
                          $type = array(
                            1 => "Transfer BCA",
                            3 => "Master/VISA",
                            2 => "Credit Card MEGA",
                            4 => "MEGA Priority"
                          );
                        ?>
                        <tr>
                            <td><?php print date("d F Y",strtotime($tkt2->create_date))?></td>
                            <td><?php print $type[$tkt2->type]?></td>
                            <td style="text-align: right"></td>
                            <td style="text-align: right"><?php print number_format($tkt2->total,0,",",".")?></td>
                        </tr>
                        <?php
                          $kredit += $tkt2->total;
                        }
                        ?>
                        <tfoot>
                          <tr>
                              <td colspan="2"></td>
                              <td style="text-align: right"></td>
                              <td style="text-align: right">&nbsp;</td>
                          </tr>
                          <tr>
                              <td colspan="2"><b>TOTAL</b></td>
                              <td style="text-align: right"><b><?php print number_format($debit,0,",",".")?></b></td>
                              <td style="text-align: right"><b><?php print number_format($kredit,0,",",".")?></b></td>
                          </tr>
                          <tr>
                              <td colspan="2"><b>BALANCE</b></td>
                              <td style="text-align: right"></td>
                              <td style="text-align: right"><b><?php print number_format(($kredit-$debit),0,",",".")?></b></td>
                          </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us();?>
            </div>
        </div>
    </div>
</section>