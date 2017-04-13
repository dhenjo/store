<div data-role="page" data-theme="c" id="page2">
 <div data-role="header">
    <h1>Guest Detail</h1>
    <a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home1">Home</a>
    <img src="<?php print $url?>img/tiketdomestik_logo.png" width="150">
 </div>
 <div data-role="content">
     <table data-role="table" width="100%">
         <tr>
             <td colspan="4"><h3>Informasi Pemesan</h3></td>
         </tr>
         <tr>
             <td width="50%" colspan="2">No Book</td>
             <td width="50%" colspan="2"><?php print $book[0]->book_code?></td>
         </tr>
         <tr>
             <td colspan="2">Penerbangan </td>
             <td colspan="2"><?php print $this->global_models->array_kota($flight[0]->dari)." - ".$this->global_models->array_kota($flight[0]->ke)?></td>
         </tr>
         <tr>
             <td colspan="2">No Penerbangan </td>
             <td colspan="2"><?php 
                      foreach($flight_items AS $fi){
                        print $fi->flight_no." ({$fi->dari}-{$fi->ke}) ".date("Y/M/d H:i", strtotime($fi->departure))."-".date("H:i", strtotime($fi->arrive))."<br />";
                      }?></td>
         </tr>
          <?php
          if($flight2nd){
           if($book[0]->book2nd){
          ?>
          <tr>
             <td colspan="2">Nomor Booking Kembali </td>
             <td colspan="2"><?php print $book[0]->book2nd?></td>
         </tr>
          <?php }?>
         <tr>
             <td colspan="2">Penerbangan Kembali</td>
             <td colspan="2"><?php print $this->global_models->array_kota($flight2nd[0]->dari)." - ".$this->global_models->array_kota($flight2nd[0]->ke)?></td>
         </tr>
         <tr>
             <td colspan="2">No Penerbangan Kembali</td>
             <td colspan="2"><?php 
          foreach($flight_items_2nd AS $fi2nd){
            print $fi2nd->flight_no." ({$fi2nd->dari}-{$fi2nd->ke}) ".date("Y/M/d H:i", strtotime($fi2nd->departure))."-".date("H:i", strtotime($fi2nd->arrive))."<br />";
          }?></td>
         </tr>
          <?php }?>
         <tr>
             <td colspan="2">Batas Waktu Pembayaran </td>
             <td colspan="2"><?php print date("d F Y H:i:s",strtotime($book[0]->timelimit))?></td>
         </tr>
         <tr>
             <td colspan="2">Nama</td>
             <td colspan="2"><?php print $passenger[0]->title." ".$passenger[0]->first_name." ".$passenger[0]->last_name?></td>
         </tr>
         <tr>
             <td colspan="2">Telepon</td>
             <td colspan="2"><?php print $passenger[0]->telphone?></td>
         </tr>
         <tr>
             <td colspan="2">E-mail</td>
             <td colspan="2"><?php print $passenger[0]->email?></td>
         </tr>
         
         <tr>
             <td colspan="4"><h3>Information Penumpang</h3></td>
         </tr>
         <?php
          $type = array(
            1 => "Adult",
            2 => "Child",
            3 => "Infant"
          );
          foreach($passenger AS $r => $kp){
          ?>
         <tr>
             <td colspan="2">Name</td>
             <td colspan="2"><?php print "{$kp->title} {$kp->first_name} {$kp->last_name}"?></td>
         </tr>
         <tr>
             <td colspan="2">Tanggal Lahir</td>
             <td colspan="2"><?php print date("d F Y",strtotime($kp->tanggal_lahir))?></td>
         </tr>
         <tr>
             <td colspan="2">Type</td>
             <td colspan="2"><?php print $type[$kp->type]?></td>
         </tr>
         <?php
          if($kp->type == 3)
            print '<tr>
             <td colspan="2">No Book</td>
             <td colspan="2">'.$kp->pax.'</td>
            </tr>';
          }?>
         
         <tr>
             <td colspan="4"><h3>Rincian Harga</h3></td>
         </tr>
         <tr>
             <td colspan="2">Harga</td>
             <td colspan="2">Rp <?php print $this->global_models->format_angka_atas(($book[0]->harga_bayar+$book[0]->infant), 0, ",", ".")?></td>
         </tr>
         <tr>
             <td colspan="2">Diskon</td>
             <td colspan="2">Rp <?php print $this->global_models->format_angka_atas($book[0]->infant, 0, ",", ".")?></td>
         </tr>
         <tr>
             <td colspan="2">Total Harga</td>
             <td colspan="2">Rp <?php print $this->global_models->format_angka_atas(($book[0]->harga_bayar), 0, ",", ".")?></td>
         </tr>
         <?php
          $diskon_bank = $this->global_models->get_query("SELECT hemat, nilai"
            . " FROM website_hemat_mega"
            . " WHERE ('".date("Y-m-d H:i:s")."' BETWEEN mulai AND akhir) AND status = 1");
          if($diskon_bank[0]->hemat > 0){
            $disk_mega = $diskon_bank[0]->hemat/100 * ($book[0]->harga_bayar);
            $harga_mega = ($book[0]->harga_bayar) - $disk_mega;
            print '<tr>
                  <td colspan="2">Harga CC Mega</td>
                  <td colspan="2">Rp '.$this->global_models->format_angka_atas($harga_mega, 0, ",", ".").'</td>
              </tr>';
          }
          if($diskon_bank[0]->nilai > 0){
            $disk_mega = $diskon_bank[0]->nilai;
            $harga_mega = ($book[0]->harga_bayar) - $disk_mega;
            print '<tr>
                  <td colspan="2">Harga CC Mega</td>
                  <td colspan="2">Rp '.$this->global_models->format_angka_atas($harga_mega, 0, ",", ".").'</td>
              </tr>';
          }
          ?>
         <tr>
             <td colspan="4"><h3>Bayar Dengan</h3></td>
         </tr>
         <tr>
             <td style="text-align: center"><a href="http://tiket.antavaya.com/index.php/component/bayar/?view=bayar&layout=byr" target="_blank"><img src="<?php print $url."images/bca.png"?>" style="max-width: 100px" />
              <br /> Transfer BCA</a></td>
            <td colspan="2" style="text-align: center"><a href="http://tiket.antavaya.com/index.php/component/mandiripayment/?view=mandiripayment&layout=default&thepnr=<?php print $book[0]->book_code?>" target="_blank"><img src="<?php print $url."images/mandiri.png"?>" style="max-width: 100px" />
          <br /> Mandiri ClickPay</a></td>
             <td style="text-align: center"><a href="http://tiket.antavaya.com/index.php/component/bankmega/?view=bankmega&layout=index&thepnr=<?php print $book[0]->book_code?>" target="_blank"><img src="<?php print $url."images/visa.png"?>" style="max-width: 100px" />
              <br /> Credit Card (Visa/Master)</a></td>
         </tr>
         <tr>
             <td colspan="2" style="text-align: center"><a href="http://tiket.antavaya.com/index.php/component/bankmegainfinite/?view=bankmegainfinite&layout=index&cc=1&thepnr=<?php print $book[0]->book_code?>" target="_blank"><img src="<?php print $url."images/mega.png"?>" style="max-width: 100px" />
          <br /> Credit Card Bank Mega</a></td>
            
            <td colspan="2" style="text-align: center"><a href="http://tiket.antavaya.com/index.php/component/bankmegainfinite/?view=bankmegainfinite&layout=index&cc=2&thepnr=<?php print $book[0]->book_code?>" target="_blank"><img src="<?php print $url."images/mega.png"?>" style="max-width: 100px" />
          <br /> MegaFirst Infinite CC</a></td>
         </tr>
     </table>
</div> <!-- /collapsible-set -->

</div>

<div data-role="page" data-theme="c" id="page1">
 <div data-role="header">
    <h1><h2>Hasil Booking</h2></h1>
    <a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home1">Home</a>
    <a data-role="button" data-direction="reverse" data-rel="back" data-icon="back" class="kembali">Back</a>
    <img src="<?php print $url?>img/tiketdomestik_logo.png" width="150">
 </div><!-- /header -->
            
<div data-role="content">
 
    <ul data-role='listview' data-inset='true' data-dividertheme='c' >
<li data-role="list-divider"><h2>Terima Kasih</h2></li>
<li>
 <h4>Terima Kasih. Booking tiket telah berhasil.</h4>
 <p>Detail dan metode pembayaran telah diinformasikan ke email anda.</p>
</li>
<div data-role="collapsible" data-collapsed="false">
            <h3>Information Pemesan</h3>
            <table id='myTable2' width='100%'>
                <tr>
                   <ul data-role='listview' data-theme='c'>
                            <li>
                                Nomor Booking : <?php print $book[0]->book_code?>
                                <br>Penerbangan : <?php print $this->global_models->array_kota($flight[0]->dari)." - ".$this->global_models->array_kota($flight[0]->ke)?>
                                <br>No Penerbangan : <?php 
                        foreach($flight_items AS $fi){
                          print $fi->flight_no." ({$fi->dari}-{$fi->ke}) ".date("Y/M/d H:i", strtotime($fi->departure))."-".date("H:i", strtotime($fi->arrive))."<br />";
                        }?>
                                <?php
                        if($flight2nd){
                          if($book[0]->book2nd){
                        ?>
                        <br>Nomor Booking Kembali : <?php print $book[0]->book_code?>
                        <?php }?>
                        <br>Penerbangan Kembali : <?php print $this->global_models->array_kota($flight2nd[0]->dari)." - ".$this->global_models->array_kota($flight2nd[0]->ke)?>
                        <br>No Penerbangan Kembali : <?php 
                        foreach($flight_items_2nd AS $fi2nd){
                          print $fi2nd->flight_no." ({$fi2nd->dari}-{$fi2nd->ke}) ".date("Y/M/d H:i", strtotime($fi2nd->departure))."-".date("H:i", strtotime($fi2nd->arrive))."<br />";
                        }?>
                        <?php }?>
                         Batas Waktu Pembayaran : <?php print date("d F Y H:i:s",strtotime($book[0]->timelimit))?>
                         <br>Nama : <?php print $passenger[0]->title." ".$passenger[0]->first_name." ".$passenger[0]->last_name?>
                         <br>Telepon : <?php print $passenger[0]->telphone?>
                         <br>Tanggal Lahir : <?php print date("d F Y", strtotime($passenger[0]->tanggal_lahir))?>
                         <br>E-mail : <?php print $passenger[0]->email?>
                            </li>
                        </ul> 
                  
                </tr>
            </table>
        </div>
<div data-role="collapsible" data-collapsed="true">
    <h3>Information Penumpang</h3>
    <table id='myTable2' width='100%'>
        <tr>
        <ul data-role='listview' data-theme='c'>
            <li>
               <?php
                    $type = array(
                      1 => "Adult",
                      2 => "Child",
                      3 => "Infant"
                    );
                    foreach($passenger AS $kp){
                    ?>
                    
                        Name : <?php print "{$kp->title} {$kp->first_name} {$kp->last_name}"?>
                        <br>Tanggal Lahir : <?php print date("d F Y",strtotime($kp->tanggal_lahir))?>
                        <br>Type : <?php print $type[$kp->type]?>
                        <?php
                        if($kp->type == 3)
                          print "<br>Pax : {$kp->pax}";
                        ?>
                   <br><br>
                    <?php }?>
            </li>
        </ul>
        </tr>
    </table>
</div>
<div data-role="collapsible" data-collapsed="true">
    <h3>Rincian Harga</h3>
    <table id='myTable2' width='100%'>
        <tr>
        <ul data-role='listview' data-theme='c'>
            <li>
                Harga Keberangkatan : Rp <?php print $this->global_models->format_angka_atas($book[0]->price, 0, ",", ".")?>
                <br>Harga Kembali/Pulang : Rp <?php print $this->global_models->format_angka_atas($book[0]->child, 0, ",", ".")?>
                <br>Diskon : Rp <?php print $this->global_models->format_angka_atas($book[0]->infant, 0, ",", ".")?>
                <br> <div style="color: #bd2330; font-size: 15px">Total Harga : Rp <?php print $this->global_models->format_angka_atas((($book[0]->price + $book[0]->child)-$book[0]->infant), 0, ",", ".")?></div>
                
                    <?php
            $diskon_bank = $this->global_models->get_query("SELECT hemat, nilai"
              . " FROM website_hemat_mega"
              . " WHERE ('".date("Y-m-d H:i:s")."' BETWEEN mulai AND akhir) AND status = 1");
            if($diskon_bank[0]->hemat > 0){
              $disk_mega = $diskon_bank[0]->hemat/100 * (($book[0]->price + $book[0]->child)-$book[0]->infant);
              $harga_mega = (($book[0]->price + $book[0]->child)-$book[0]->infant) - $disk_mega;
              print "<br><div style='color: #bd2330; font-size: 15px'>Rp ".$this->global_models->format_angka_atas($harga_mega, 0, ",", ".")."</div>";
            }
            if($diskon_bank[0]->nilai > 0){
              $disk_mega = $diskon_bank[0]->nilai;
              $harga_mega = (($book[0]->price + $book[0]->child)-$book[0]->infant) - $disk_mega;
              print "<br><div style='color: #bd2330; font-size: 15px'>Rp ".$this->global_models->format_angka_atas($harga_mega, 0, ",", ".")."</div>";
            }
            ?>
                
            </li>
        </ul>
        </tr>
    </table>
</div>
</ul>

</div> 
 
 <div data-role="content">
 
    <ul data-role='listview' data-inset='true' data-dividertheme='c' >
       <li data-role="list-divider"><h2>Bayar Dengan</h2></li>
<li>
    <div style="text-transform: none;width: 20%;">
            <a href="http://tiket.antavaya.com/index.php/component/bayar/?view=bayar&layout=byr" target="_blank">
            <img src="<?php print $url2; ?>images/bca.png" width="100"><br />
           Transfer BCA
           </a>
  </div>
    <div style="padding-left: 150px;margin-top: -45px;">
            <a href="http://tiket.antavaya.com/index.php/component/mandiripayment/?view=mandiripayment&layout=default&thepnr=<?php print $book[0]->book_code?>" target="_blank">
            <img src="<?php print $url2; ?>images/mandiri.png" width="100"><br />
            Mandiri ClickPay
          </a>
  </div>
    <div style="padding-left: 300px;margin-top: -54px; ">
        
            <a href="http://tiket.antavaya.com/index.php/component/bankmega/?view=bankmega&layout=index&thepnr=<?php print $book[0]->book_code?>" target="_blank">
            <img src="<?php print $url2; ?>images/visa.png" width="100"><br />
            Credit Card (Visa/Master)
          </a>
        
  </div>
    <div style="padding-left: 500px;margin-top: -60px;">
       
            <a href="http://tiket.antavaya.com/index.php/component/bankmegainfinite/?view=bankmegainfinite&layout=index&cc=1&thepnr=<?php print $book[0]->book_code?>" target="_blank">
            <img src="<?php print $url2; ?>images/mega.png" width="80"><br />
            Credit Card Bank MEGA
          </a>
  </div>
    <div  style="padding-left: 700px;margin-top: -68px;">
        <a href="http://tiket.antavaya.com/index.php/component/bankmegainfinite/?view=bankmegainfinite&layout=index&cc=2&thepnr=<?php print $book[0]->book_code?>" target="_blank">
        <img src="<?php print $url2; ?>images/mega.png" width="80"><br />
        MegaFirst Infinite CC
      </a>
  </div>
    
</li> 
     </ul>
  </div>   
<br/> <br/> 
</div>
