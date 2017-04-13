<script>
  function buka_form(){
    document.getElementById("isi").style.display = "block";
  }
</script>
<img src="<?php print base_url()."themes/antavaya/images/logo.png"?>" />
<br />
<div style='text-align: right'>
<?php
if($pdf){
  print "<a href='{$pdf}' target='_blank'>PDF</a>";
}
else{
  print "<a href='http://tms.antavaya.com/antavaya/antavaya-tour/tour-series-detail-print/{$kode}' target='_blank'>PDF</a>";
}
?>

  | <a href="#" onclick="buka_form()">Email</a></div>
<div style="display: none; text-align: right" id="isi">
  <?php
  print $this->form_eksternal->form_open();
  print "Email : ".$this->form_eksternal->form_input("email")."<br />";
  print "Nama : ".$this->form_eksternal->form_input("name")."<br />";
  print "<input type='submit' value='Send' />";
  print $this->form_eksternal->form_close();
  ?>
</div>
<?php
if($pdf){
  print "Silahkan Download <a href='{$pdf}'>PDF di link</a> ini";
}
else{
?>
<h1 style="text-align: center"><?php print $title?></h1>
<h3 style="text-align: center">
  <?php print $kedua?><br />
  <?php print $ketiga?><br />
  <?php print $keempat?><br />
</h3>
<br />
<?php
print $body;
?>
<hr />
<table width="100%" border="1">
  <tr>
    <th rowspan="2">Jadwal</th>
    <th rowspan="2">Dewasa <br />Triple / <br /> Twin</th>
    <th colspan="3">Anak-anak (2-11 Tahun)</th>
    <th rowspan="2">SGL <br />SUPP</th>
    <th rowspan="2">Airport <br /> Tax & <br />Flight</th>
    <th rowspan="2">Visa</th>
  </tr>
  <tr>
    <th>Twin Bed</th>
    <th>Extra Bed</th>
    <th>No Bed</th>
  </tr>
  <?php
  foreach($info AS $in){
    $adult = ($in->price->adult_triple_twin > 0 ? number_format($in->price->adult_triple_twin) : '-');
    $ctb = ($in->price->child_twin_bed > 0 ? number_format($in->price->child_twin_bed) : '-');
    $ceb = ($in->price->child_extra_bed > 0 ? number_format($in->price->child_extra_bed) : '-');
    $cnb = ($in->price->child_no_bed > 0 ? number_format($in->price->child_no_bed) : '-');
    $single = ($in->price->sgl_supp > 0 ? number_format($in->price->sgl_supp) : '-');
    $tax = ($in->price->airport_tax > 0 ? number_format($in->price->airport_tax) : '-');
    $visa = ($in->price->visa > 0 ? number_format($in->price->visa) : '-');
      
    print "<tr>"
      . "<td>".date("d M Y", strtotime($in->start_date))." - <br />".date("d M Y", strtotime($in->end_date))."</td>"
      . "<td>IDR <br />{$adult}</td>"
      . "<td>IDR <br />{$ctb}</td>"
      . "<td>IDR <br />{$ceb}</td>"
      . "<td>IDR <br />{$cnb}</td>"
      . "<td>IDR <br />{$single}</td>"
      . "<td>IDR <br />{$tax}</td>"
      . "<td>IDR <br />{$visa}</td>"
    . "</tr>";
  }
  ?>
</table>
<div>
  <br>
   <b> Syarat & Kondisi : </b>
<br> <b>-</b> Deposit tanda jadi adalah sebesar USD 300 per orang
<br> <b>-</b> Keberangkatan rombongan minimal 20 peserta, jika peserta kurang dari 20 orang AntaVaya berhak melakukan penyesuaian harga tour.
<br> <b>-</b> Jadwal perjalanan dan tanggal keberangkatan dapat berubah sesuai dengan kondisi demi kelancaran pelaksanaan tour.
<br> <b>-</b> Harga tour dapat berubah sewaktu waktu bilamana terjadi perubahan kurs mata uang asing atau kenaikan harga tiket pesawat, surcharge
(biaya tambahan) di periode convention dan fair dikota/negara tujuan.
<br> <b>-</b> Harga tour belum termasuk biaya yang dapat timbul apabila peserta melakukan deviasi tiket penerbangan dan juga acara tour.
<br> <b>-</b> Dalam hal visa ditolak, peserta tetap dikenakan biaya deposit pembukuan dan adiministrasi tiket yang terjadi dikarenakan adanya batas
waktu dalam penerbitan tiket group.
<br> <b>-</b> Biaya dan persyaratan visa dapat berubah sewaktu waktu mengikuti kurs, harga dan kebijakan dari pihak kedutaan.
<br> <b>-</b> Sesuai ketentuan dari Kedutaan biaya visa tetap dibayarkan walaupun visa ditolak.
<br> <b>-</b> Kategori Triple sharing yaitu 1 kamar ditempati 3 orang dewasa dan pada umumnya di beberapa hotel dapat berupa tambahan extra Bed /
Sofa Bed sesuai dengan standard hotel yang ada.
<br> <b>-</b> Pelunasan tour harus dilakukan paling lambat 14 hari sebelum tanggal keberangkatan tour
<br><br><b>Pembatalan :</b>
<br> <b>-</b> Hingga 45 hari = senilai uang muka pendaftaran
<br> <b>-</b> 44 -16 hari = 50 % dari harga tour
<br> <b>-</b> 15 -18 hari = 75 % dari harga tour
<br> <b>-</b> 07 - 01 hari = 85 % dari harga tour
<br> <b>-</b> hari H / No Show = 100 % dari harga tour
 <br> </div>
<!--<div style="font-size: 12px">
  <br><br>
  <b>Jakarta:</b> (021) Head Office: 625 3919, 386 2747 - Grand Indo 2358 1900 - Gandaria City 2900 7898 - Central Park 2920 0208 - Melawai 720 1888 - Klp Gading 450 0066
 <br><b>Bogor:</b> (0251) 835 6861 - <b>Bandung:</b> (022) Pasir Kaliki 423 7566 - Jl. Sunda 426 1739 - Trans Studio Mall 8734 1799 - <b>Surabaya:</b> (031) Jl. Bengawan 566 2346 / 561
9438 - Darmo Square 567 7979 - Tunjungan Plaza 531 8109 - <b>Bali:</b> (0361) Denpasar 235 581, 418 324 - Sanur 285 555 - <b>Balikpapan:</b> (0542) 872 626 - <b>Makassar:</b>
(0411) 361 8648 - Maros 556 575 / 481 3738 - Trans Studio Mall 811 7070 / 7064 - <b>Mega Travel Center (MTC):</b> Jakarta (021) 798 9348 - Malang (0341) 352 071 / 073 -
Yogyakarta (0274) 553 016 / 017
</div>-->
<?php }?>