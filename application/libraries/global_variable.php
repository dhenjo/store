<?php
class Global_variable{
  function __construct(){
      
  }
  function bulan(){
    $bulan = array(
      1 => array("id" => "Januari", "en" => "January"),
      2 => array("id" => "Februari", "en" => "February"),
      3 => array("id" => "Maret", "en" => "March"),
      4 => array("id" => "April", "en" => "April"),
      5 => array("id" => "Mei", "en" => "May"),
      6 => array("id" => "Juni", "en" => "June"),
      7 => array("id" => "Juli", "en" => "July"),
      8 => array("id" => "Agustus", "en" => "August"),
      9 => array("id" => "September", "en" => "September"),
      10 => array("id" => "Oktober", "en" => "October"),
      11 => array("id" => "Nopember", "en" => "November"),
      12 => array("id" => "Desember", "en" => "December"),
    );
    return $bulan;
  }
  function payment_type(){
    $return = array(
      1   => "Tunai",
      3   => "Transfer Mega",
      2   => "Transfer BCA",
      4   => "Transfer Mandiri",
      7   => "Debit BCA",
      14  => "Debit Mandiri",
      15  => "Debit BNI",
      9   => "Kartu Kredit BCA",
      5   => "Kartu Kredit Mega",
      21  => "Mega First Infinite",
      11  => "Kartu Kredit BNI",
      12  => "Kartu Kredit Mandiri",
      13  => "Kartu Kredit Citibank",
      10  => "Kartu Kredit Lainnya",
      16  => "Travel Certificate",
      17  => "Travel Voucher",
      18  => "Voucher CT Corp",
      19  => "Point Rewards",
      20  => "Kupon",
    );
    return $return;
  }
  function region(){
    $return = array(
      1=>"Eropa",
      2=>"Africa",
      3=>"America",
      4=>"Australia",
      5=>"Asia",
      6=>"China",
      7=>"New Zealand",
    );
    return $return;
  }
  
  function inventory_status($r = NULL){
    if($r == 1){
      return array(
        1 => "<label class='label label-primary'>Create</label>",
        2 => "<label class='label label-success'>DP</label>",
        3 => "<label class='label label-success'>Lunas</label>",
        4 => "<label class='label label-warning'>Cancel</label>",
        5 => "<label class='label label-danger'>Refound</label>",
      );
    }
    else{
      
    }
  }
  
  function tour_schedule_status($r = NULL){
    if($r == 1){
      return array(
        1 => "<label class='label label-primary'>Active</label>",
        2 => "<label class='label label-default'>Draft</label>",
        3 => "<label class='label label-danger'>Cancel</label>",
        4 => "<label class='label label-success'>Close</label>",
        5 => "<label class='label label-warning'>Push Selling</label>",
      );
    }
    else{
      
    }
  }
  
  function tour_schedule_public_sales($r = NULL){
    if($r == 1){
      return array(
        2 => "<label class='label label-primary'>Umum</label>",
        1 => "<label class='label label-success'>Internal</label>",
        NULL => "<label class='label label-success'>Internal</label>",
        0 => "<label class='label label-success'>Internal</label>",
      );
    }
    else{
      
    }
  }
  
  function curl_mentah($pst, $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function terbilang($nilai){
    $angka = explode(",", $nilai);
    $nol = array(
      0 => "",
      1 => "ribu",
      2 => "juta",
      3 => "miliar",
      4 => "triliun",
    );
    $no = 0;
    for($i = (count($angka) - 1) ; $i >= 0 ; $i--){
      if($angka[$i] >= 1){
        $nilai_baru = trim($this->hitung_terbilang_ratusan($angka[$i]))." ".$nol[$no]." ".$nilai_baru;
      }
      $no++;
    }
    return ucwords($nilai_baru);
  }
  
  function hitung_terbilang_ratusan($nilai){
//    satuan
    $satuan = array(
      1 => "satu",
      2 => "dua",
      3 => "tiga",
      4 => "empat",
      5 => "lima",
      6 => "enam",
      7 => "tujuh",
      8 => "delapan",
      9 => "sembilan",
    );
    
    $panjang = strlen($nilai);
    $belakang = array(
      0 => "",
      1 => "puluh",
      2 => "ratus",
    );
    $paten = array(
      1 => "sepuluh",
      2 => "seratus",
    );
    $ganti = array(
      1 => "satu puluh",
      2 => "satu ratus",
    );
    $no = 0;
    for($t = ($panjang - 1) ; $t >= 0 ; $t--){
      if($nilai[$t] >= 1){
        $hasil = str_replace($ganti[$no], $paten[$no], $satuan[$nilai[$t]]." ".$belakang[$no])." ".$hasil;
      }
//      $debug[] = $no;
      $no++;
    }
    return $hasil;
  }
  
  function terbilang2($x, $style=3) {
    if($x<0) {
        $hasil = "minus ". trim($this->kekata($x));
    } else {
        $hasil = ucwords(trim($this->kekata($x)));
    }      
    return $hasil;
}

  function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = $this->kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . $this->kekata($x - 100);
    } else if ($x <1000) {
        $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . $this->kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
}
?>
