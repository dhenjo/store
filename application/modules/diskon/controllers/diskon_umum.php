<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diskon_umum extends MX_Controller {
    
  function __construct() {      
    
  }
  
  public function set_mega(){
//    $besok = date("Y-m-d", mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
    $besok = date("Y-m-d H:i:s");
    $cek = $this->global_models->get_query("SELECT hemat, nilai"
      . " FROM website_hemat_mega"
      . " WHERE ('{$besok}' BETWEEN mulai AND akhir) AND status = 1");
    if($cek[0]->hemat > 0 OR $cek[0]->nilai > 0){
      $cookie_jar = tempnam('/tmp','cookie');
      $this->login_curl_diskon($cookie_jar);
      $this->set_curl_diskon($cookie_jar, $cek[0]->hemat, $cek[0]->nilai, 5, date("Y-m-d"));
      $this->set_curl_diskon($cookie_jar, $cek[0]->hemat, $cek[0]->nilai, 6, date("Y-m-d"));
      
      print "Set diskon {$cek[0]->hemat} {$cek[0]->nilai} ".date("Y-m-d H:i:s");
    }
    else{
      $cookie_jar = tempnam('/tmp','cookie');
      $this->login_curl_diskon($cookie_jar);
      $this->set_curl_diskon($cookie_jar, 0, 0, 5, date("Y-m-d"));
      $this->set_curl_diskon($cookie_jar, 0, 0, 6, date("Y-m-d"));
      
      print "Set diskon 0 ".date("Y-m-d H:i:s");
    }
    die;
  }
  
  function login_curl_diskon(&$cookie_jar){
    $login = "http://tiket.antavaya.com/diskon/logincek.php";
    $post = array(
      "username" 	=> "diskon",
      "pass"		=> "noksid",
      "Submit"	=> "Log masuk"
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
  
  function set_curl_diskon($cookie_jar, $diskon, $nilai, $id, $besok){
    $title = array(
      5 => "MEGA 20",
      6 => "MEGAFIRST 20",
    );
    $type = array(
      5 => "MEGA",
      6 => "MEGAFIRST",
    );
    $post_diskon = array(
      "title" 			=> $title[$id],
      "cardtype"			=> $type[$id],
      "persentase"		=> $diskon,
	  "diskonrupiah" => $nilai,
      "periodfrom"		=> $besok,
      "perioduntil"		=> $besok,
      "submit"			=> "Save Data Diskon Mega",
      "modifieddate"		=> "2015-02-11",
      "createddate"		=> "2015-02-04",
      "diskon"			=> 0,
      "id"				=> $id,
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://tiket.antavaya.com/diskon/diskonmega_form.php");
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
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */