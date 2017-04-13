<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight_umum extends MX_Controller {
    
  function __construct() {      
    
  }
  public function status_tiket(){
    $cookie_jar = tempnam('/tmp','cookie');
    
    $this->login_curl($cookie_jar);
    $book = $this->global_models->get_query("SELECT *"
      . " FROM tiket_book"
      . " WHERE status = 1 OR status IS NULL");
    foreach($book AS $bk){
      if($bk->book_code){
        $hasil = $this->olah_utama($cookie_jar, $bk->book_code, $bk->id_tiket_book, $bk->book2nd);
        print date("Y-m-d H:i:s")." {$bk->book_code} {$bk->id_tiket_book} {$hasil['status']} {$hasil['note']}<br />";
      }
    }
    die;
  }
  
  public function status_tiket_single($book_code){
    $cookie_jar = tempnam('/tmp','cookie');
    
    $this->login_curl($cookie_jar);
    $book = $this->global_models->get_query("SELECT *"
      . " FROM tiket_book"
      . " WHERE book_code = '{$book_code}' AND status = 1");
    if($book){
      $hasil = $this->set_curl($cookie_jar, $book_code);

  //    cari book 1st
      $book_code1st_array = $this->find_1st_book_code($hasil, $book);
      $yh = count($book_code1st_array) - 1;
      $book_code1st = $book_code1st_array[$yh];
  //    end cari book 1st
  //    cari book 1st
      $book_code2nd = $this->find_2nd_book_code($hasil, $book_code1st_array[1]);
  //    end cari book 1st
  //    print "<textarea>";
  //    $this->debug($hasil);
  //    $this->debug($book_code2nd);
  //    print "</textarea>";
      if($book_code1st != $book_code2nd){
        $this->global_models->update("tiket_book", array("id_tiket_book" => $book[0]->id_tiket_book), 
          array("book_code" => $book_code1st, "book2nd" => $book_code2nd));
      }
      else{
        $book_code2nd = NULL;
      }

      $hasil = $this->olah_utama($cookie_jar, $book_code1st, $book[0]->id_tiket_book, $book_code2nd);
      print date("Y-m-d H:i:s")." {$bk->book_code} {$bk->id_tiket_book} {$hasil['status']} {$hasil['note']}<br />";
    }
    die;
  }
  
  private function find_1st_book_code($hasil, $book){
    $hasil_temp = explode(date("Y-m-d", strtotime($book[0]->tanggal))."</td>", $hasil);
    $hasil_temp = explode("</td>", $hasil_temp[1]);
    $hasil_temp = explode(">", $hasil_temp[1]);
    return $hasil_temp;
  }
  
  private function find_2nd_book_code($hasil, $param){
    $hasil_temp = explode($param.">", $hasil);
    $hasil_temp = explode("</td>", $hasil_temp[4]);
    return $hasil_temp[0];
  }
  
  function olah_utama(&$cookie_jar, $book_code, $id_tiket_book, $book2nd = NULL){
    $hasil = $this->set_curl($cookie_jar, $book_code);
    $hanya_hasil = explode(">{$book_code}<", $hasil);
    $after_payment = explode("<font color=#ff0000><b>", $hanya_hasil[1]);
    $after_payment = explode("</b></font></td>", $after_payment[1]);
    
    $timelimit = explode("'>", $after_payment[1]);
    $after_timelimit = explode("</td><td>", $timelimit[1]);
    $hpp = explode("</td>", $timelimit[4]);
    
    $passenger = $this->global_models->get_query("SELECT B.*, A.id_tiket_book_passenger"
      . " FROM tiket_book_passenger AS A"
      . " LEFT JOIN tiket_passenger AS B ON A.id_tiket_passenger = B.id_tiket_passenger"
      . " WHERE A.id_tiket_book = '{$id_tiket_book}'");
    $harga_total = 0;  
//    $gy = 1;
    $harga_pertama = 0;
    foreach($passenger AS $psg){
      $harga_penumpang = explode(strtolower("{$psg->first_name} {$psg->last_name}"), strtolower($hanya_hasil[1]));
      $harga_penumpang = explode("<td align='right'>", $harga_penumpang[1]);
      $harga_penumpang = explode("</td>", $harga_penumpang[1]);
      $harga[$psg->id_tiket_book_passenger] = str_replace(",","",trim($harga_penumpang[0]));
      $harga_total += str_replace(",","",trim($harga_penumpang[0]));
      $this->global_models->update("tiket_book_passenger", array("id_tiket_book_passenger" => $psg->id_tiket_book_passenger), 
        array("harga" => str_replace(",","",trim($harga_penumpang[0]))));
      
      $harga_pertama += str_replace(",","",trim($harga_penumpang[0]));
//      $gy++;
    }
//    $this->debug($passenger);
//    print "<textarea>";
//    print strtolower("</span>{$psg->first_name} {$psg->last_name}");
//    print_r($hanya_hasil);
//    print "</textarea>";die;
    $harga_bayar = explode("Harga Tiket Rp", $hanya_hasil[1]);
    $harga_bayar = explode("</td>", $harga_bayar[1]);
    $hasil_array = array(
      "cara_bayar"    => $after_payment[0],
      "timelimit"     => $after_timelimit[0],
      "tiket_no"      => $after_timelimit[9],
      "hpp"           => str_replace(",", "", trim($hpp[0])),
      "harga"         => $harga_total,
      "harga_bayar"   => str_replace(",", "", trim($harga_bayar[0])),
    );
//    $this->debug($harga);
//    $this->debug($hasil_array, true);
    if($hasil_array['timelimit']){
      $note = "Proses";
      $status = 1;
      if($hasil_array['tiket_no']){
        $status = 3;
        $note = "Issued";
      }
      else if(strtotime("now") > strtotime($hasil_array['timelimit'])){
        $status = 4;
        $note = "Time Limit";
      }
      $tiket_before = $this->global_models->get("tiket_book", array("id_tiket_book" => $id_tiket_book));
      $update_book = array(
        "timelimit"     => $hasil_array['timelimit'],
        "price"         => ($hasil_array['harga'] + $tiket_before[0]->infant),
        "child"         => 0,
        "tiket_no"      => $hasil_array['tiket_no'],
        "hpp"           => $hasil_array['hpp'],
        "harga_bayar"   => $hasil_array['harga_bayar'],
        "status"        => $status
      );
      if(trim($hasil_array['cara_bayar'])){
        $update_book['cara_bayar']  = $hasil_array['cara_bayar'];
      }
      $this->global_models->update("tiket_book", array("id_tiket_book" => $id_tiket_book), $update_book);
      $return = array(
        'status'  => $status,
        'note'    => $note);
    }
    else{
      $return = array(
        'status'  => 1,
        'note'    => 'Data kosong');
    }
    if($book2nd){
      $hanya_hasil = explode(">{$book2nd}<", $hasil);
//      $after_payment = explode("<font color=#ff0000><b>", $hanya_hasil[1]);
//      $after_payment = explode("</b></font></td>", $after_payment[1]);

      $timelimit = explode("</td>", $hanya_hasil[1]);
      $timelimit_fix = explode(">", $timelimit[0]);
      $after_timelimit = explode("<td>", $timelimit[10]);
      $hpp = explode("'>", $timelimit[14]);

      $passenger = $this->global_models->get_query("SELECT B.*, A.id_tiket_book_passenger"
        . " FROM tiket_book_passenger AS A"
        . " LEFT JOIN tiket_passenger AS B ON A.id_tiket_passenger = B.id_tiket_passenger"
        . " WHERE A.id_tiket_book = '{$id_tiket_book}'");
      $harga_total = 0;  
      foreach($passenger AS $psg){
        $harga_penumpang = explode(strtolower("{$psg->first_name} {$psg->last_name}"), strtolower($hanya_hasil[1]));
        $harga_penumpang = explode("<td align='right'>", $harga_penumpang[1]);
        $harga_penumpang = explode("</td>", $harga_penumpang[1]);
        $harga[$psg->id_tiket_book_passenger] = str_replace(",","",trim($harga_penumpang[0]));
        $harga_total += str_replace(",","",trim($harga_penumpang[0]));
        $this->global_models->update("tiket_book_passenger", array("id_tiket_book_passenger" => $psg->id_tiket_book_passenger), 
          array("harga2nd" => str_replace(",","",trim($harga_penumpang[0]))));
      }
      $harga_bayar = explode("Harga Tiket Rp", $hanya_hasil[1]);
      $harga_bayar = explode("</td>", $harga_bayar[1]);
      $hasil_array2 = array(
        "timelimit"     => trim($timelimit_fix[1]),
        "tiket_no"      => trim($after_timelimit[1]),
        "harga"         => $harga_total,
        "harga_bayar"   => str_replace(",", "", trim($harga_bayar[0])),
        "hpp"           => str_replace(",", "", trim($hpp[1])),
      );
      
      if($hasil_array2['timelimit']){
        $note = "Proses";
        if($hasil_array2['tiket_no']){
          $status = 3;
          $note = "Issued";
        }
        else if(strtotime("now") > strtotime($hasil_array2['timelimit'])){
          $status = 4;
          $note = "Time Limit";
        }
        $this->global_models->update("tiket_book", array("id_tiket_book" => $id_tiket_book), array(
          "child"         => $harga_total,
          "tiket_no2nd"   => trim($hasil_array2['tiket_no']),
          "hpp2nd"        => trim($hasil_array2['hpp']),
          "harga_bayar2nd" => trim($hasil_array2['harga_bayar']),
        ));
        $return = array(
          'status'  => $status,
          'note'    => $note);
      }
      
    }
    $harga_bayar = explode("Harga Tiket Rp", $hasil);
    $harga_bayar2 = explode("</td>", $harga_bayar[1]);
    $book_final = $this->global_models->get("tiket_book", array("id_tiket_book" => $id_tiket_book));
    if(str_replace(",", "", trim($harga_bayar2[0])) != ($book_final[0]->price + $book_final[0]->child)){
      $hemat_mega = $this->global_models->get_query("SELECT id_website_hemat_mega"
        . " FROM website_hemat_mega"
        . " WHERE '{$book_final[0]->tanggal}' BETWEEN mulai AND akhir");
      if($hemat_mega[0]->id_website_hemat_mega){
        $this->global_models->update("tiket_book", array("id_tiket_book" => $id_tiket_book), 
          array("id_website_hemat_mega" => $hemat_mega[0]->id_website_hemat_mega));
      }
    }
    return $return;
  }
  
  function login_curl(&$cookie_jar){
    $login = "http://tiket.antavaya.com/finish/logincek.php";
    $post = array(
      "username" 	=> "donny",
      "pass"		=> "donny789",
      "Submit"	=> "Login"
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $login);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function set_curl($cookie_jar, $book_code){
    
    $post_diskon = array(
      "rbrpt" 			=> 'pnr',
      "tgla"			=> '',
      "tglb"			=> '',
      "tktnopnr"			=> $book_code,
      "submit"			=> "Search",
      "hairln"			=> "",
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tiket.antavaya.com/finish/vayatkt.php");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_diskon);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    $hasil_1 = curl_exec($ch);
    curl_close($ch);

    return $hasil_1;
  }
  
  private function curl_mentah($pst, $url){
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */