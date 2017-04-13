<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Antavaya extends MX_Controller {
  var $cookie_jar;
    
  function __construct() {      
    $this->load->library('mobile_detect');
    $this->load->library('encrypt');
  }
  
  function perbaikan(){
    $this->template->build("perbaikan", 
        array(
          'url'           => base_url()."themes/antavaya/",
          'theme2nd'      => 'antavaya',
          'tiket_book'    => $tiket_book,
        ));
      $this->template
        ->set_layout('default')
        ->build("perbaikan");
    
  }
  function ajax_flight_pp(){
    $fasilitas = array(
      "GA"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none;color: black;'></i>",
      "SJ"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none;color: black;'></i>",
      "ID"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none;color: black;'></i>",
      "IW"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>10</span></i>",
      "JT"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>20</span></i>",
      "QG"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>15</span></i>",
      "QZ"    => "<i class='soap-icon-plane' style='text-transform: none;color: black;'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none;color: black;'><span style='font-size: 12px'>15</span></i>",
    );
    $go = $this->encrypt->decode($this->input->post("go"));
    $back = $this->encrypt->decode($this->input->post("back"));
    
    $data_diskon = $this->curl_mentah(
      array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s")), 
      URLSERVER."json/cek-diskon-payment");
    $data_diskon_array = json_decode($data_diskon);
//    $this->debug($data_diskon_array, true);
    $flight_go[0] = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $go));
    
    $flight_go[1] = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $back));
    
    print "<div class='col-sm-8 col-md-12'>
                <div class='flight-list listing-style3 flight'>";
    $kesatu = "";
    for($t = 0 ; $t <= 1 ; $t++){
      
      $flight_items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $flight_go[$t][0]->id_website_flight_temp));
      
      $diskon_angka = $this->global_models->diskon($flight_go[$t][0]->maskapai, $flight_go[$t][0]->price);
      $jual[$t] = $flight_go[$t][0]->price - $diskon_angka;
      
      $kali_dewasa = $this->session->userdata("flight_adl") * $flight_go[$t][0]->price;
      $kali_anak = $this->session->userdata("flight_chd") * $flight_go[$t][0]->child;
      $kali_bayi = $this->session->userdata("flight_inf") * $flight_go[$t][0]->infant;
      $dewasa_anak = $kali_dewasa + $kali_anak;
      $dewasa_anak_bayi = $dewasa_anak + $kali_bayi;
      $diskon_dewasa_anak = $this->global_models->diskon($flight_go[$t][0]->maskapai, $dewasa_anak);
      $harga_bayar[$t] = $dewasa_anak_bayi - $diskon_dewasa_anak;
      
      if($data_diskon_array->status == 2){
        $cetak_isi_diskon_bank = "
          <span class='price' style='color: #bd2330; font-weight: bold'>";
        foreach($data_diskon_array->diskon AS $kdda => $dda){
          if($dda->type == 1){
            $diskon_temp = $dda->diskon/100 * $harga_bayar[$t];
            $jual_mega[$kdda][$t] = $harga_bayar[$t] - $diskon_temp;
          }
          else{
            $jual_mega[$kdda][$t] = $harga_bayar[$t] - $dda->diskon;
          }
          $cetak_isi_diskon_bank .= "<img src='".$dda->logo."' width='50' />"
            . "Rp {$this->global_models->format_angka_atas($jual_mega[$kdda][$t], 0, ",", ".")} <br />";
        }
        $cetak_isi_diskon_bank .= "</span>";
        
      }
      
      if($flight_go[$t][0]->hemat > 0){
        $hemat = "<span class='skin-color' style='text-transform: none; color: #bd2330;'>Hemat Rp ".$this->global_models->format_angka_atas($flight_go[$t][0]->hemat, 0, ",", ".")."</span>";
        $diskon = "<s>Rp ".$this->global_models->format_angka_atas($flight_go[$t][0]->price, 0, ",", ".")."</s>";
      }
      $take_off = $landing = $no_flight = $small_title = "";
      foreach($flight_items AS $fi){
        $take_off .= "<li>".date("H:i",strtotime($fi->take_off))." ({$fi->dari})</li>";
        $landing .= "<li>".date("H:i",  strtotime($fi->landing))." ({$fi->ke})</li>";
        $no_flight .= "<li>{$fi->flight_no}</li>";
        $small_title .= $this->global_models->array_kota($fi->dari)." ke ".$this->global_models->array_kota($fi->ke)."<br />";
      }
      $var_go  = "<input type='text' name='go' value='{$this->encrypt->encode($flight_go[$t][0]->id_website_flight_temp)}' style='display: none' />";
      if($t == 1){
        $total = $harga_bayar[0] + $harga_bayar[1];
        if($data_diskon_array->status == 2){
          $cetak_bank = "<span class='price' style='color: #bd2330; font-size: 30px; font-weight: bold'>";
          foreach($data_diskon_array->diskon AS $kdda => $dda){
            $total_mega[$kdda] = $jual_mega[$kdda][0] + $jual_mega[$kdda][1];
            $cetak_bank .= "<img src='".$dda->logo."' width='50' />"
              . "Rp ".$this->global_models->format_angka_atas($total_mega[$kdda], 0, ",", ".")."<br />";
          }
          $cetak_bank .= "</span>";
        }
        if(strtotime($flight_go[0][0]->take_off) < strtotime($flight_go[1][0]->landing)){
          $kesatu = "<div>
                          <span width='100%' style='font-weight: bold; font-size: 18px'>TOTAL </span>
                          <span class='price' style='color: #1a6ea5'>Rp ".$this->global_models->format_angka_atas($total, 0, ",", ".")."</span>
                          {$cetak_bank}
                          <input type='text' name='back' value='{$this->encrypt->encode($flight_go[$t][0]->id_website_flight_temp)}' style='display: none' />
                      </div>
                      <button class='button btn-small full-width'>Pesan</button>";
        }
        else{
          $kesatu = "<div>
                          <span class='price' style='color: #1a6ea5'>Rp ".$this->global_models->format_angka_atas($total, 0, ",", ".")."</span>
                          <input type='text' name='back' value='{$this->encrypt->encode($flight_go[$t][0]->id_website_flight_temp)}' style='display: none' />
                          {$cetak_bank}
                      </div>
                      Waktu pulang harus lebih besar dari waktu pergi";
        }
        $var_go = "";
      }
      $stop_cetak = "Langsung";
      if($flight_go[$t][0]->stop > 1){
        $stop_cetak = ($flight_go[$t][0]->stop - 1)." Transit";
      }
      
      print "
                  <article class='box'>
                      <figure class='col-xs-3 col-sm-2'>
                          <span><img style='max-width: 100%' alt='' src='".base_url()."themes/antavaya/maskapai/{$flight_go[$t][0]->img}'></span>
                          {$var_go}
                      </figure>
                      <div class='details col-xs-9 col-sm-10'>
                          <div class='details-wrapper'>
                              <div class='first-row'>
                                  <div>
                                      <h4 class='box-title'>{$this->global_models->array_kota($flight_go[$t][0]->dari)} ke {$this->global_models->array_kota($flight_go[$t][0]->ke)}
                                          <small>{$small_title}</small></h4>
                                      <a class='button btn-mini stop'>{$stop_cetak}</a>
                                  </div>
                                  <div>
                                      <span class='price'><small>
                                        <s>Rp ".$this->global_models->format_angka_atas($dewasa_anak_bayi, 0, ",", ".")."</s>"
                                      . "</small>"
                                        . "Rp ".$this->global_models->format_angka_atas($harga_bayar[$t], 0, ",", ".")."</span>
                                      <span class='price' style='font-size: 11px'><a id='harga{$t}' href='javascript:void(0)'>Rincian Harga</a></span>
                                      <span style='display: none' id='isiharga{$t}'>
                                        <table width='100%'>
                                          <tr>
                                            <td>Dewasa </td>
                                            <td style='text-align: right'>{$this->session->userdata("flight_adl")} X Rp ".$this->global_models->format_angka_atas($flight_go[$t][0]->price, 0, ",", ".")."</td>
                                            <td style='text-align: right'>Rp ".$this->global_models->format_angka_atas($kali_dewasa, 0, ",", ".")."</td>
                                          </tr>
                                          <tr>
                                            <td>Child </td>
                                            <td style='text-align: right'>{$this->session->userdata("flight_chd")} X Rp ".$this->global_models->format_angka_atas($flight_go[$t][0]->child, 0, ",", ".")."</td>
                                            <td style='text-align: right'>Rp ".$this->global_models->format_angka_atas($kali_anak, 0, ",", ".")."</td>
                                          </tr>
                                          <tr>
                                            <td>Infant </td>
                                            <td style='text-align: right'>{$this->session->userdata("flight_inf")} X Rp ".$this->global_models->format_angka_atas($flight_go[$t][0]->infant, 0, ",", ".")."</td>
                                            <td style='text-align: right'>Rp ".$this->global_models->format_angka_atas($kali_bayi, 0, ",", ".")."</td>
                                          </tr>
                                          <tr>
                                            <td>Hemat </td>
                                            <td style='text-align: right'></td>
                                            <td style='text-align: right'>Rp ".$this->global_models->format_angka_atas($diskon_dewasa_anak, 0, ",", ".")."</td>
                                          </tr>
                                          <tr>
                                            <td>Total </td>
                                            <td style='text-align: right'></td>
                                            <td style='text-align: right'>Rp ".$this->global_models->format_angka_atas($harga_bayar[$t], 0, ",", ".")."</td>
                                          </tr>
                                        </table>
                                      </span>
                                      <script>
                                      $(function() {
                                        $('#harga{$t}').tooltipster({
                                            content: $('#isiharga{$t}').html(),
                                            minWidth: 300,
                                            maxWidth: 300,
                                            contentAsHTML: true,
                                            interactive: true
                                        });
                                      });
                                      </script>
                                      
                                  </div>
                              </div>
                              <div class='second-row'>
                                  <div class='time'>
                                      <div class='take-off col-sm-3'>
                                          <div class='icon'><i class='soap-icon-plane-right yellow-color'></i></div>
                                          <div>
                                              <span class='skin-color'>Berangkat</span>
                                              <ul style='list-style: inherit'>
                                                  {$take_off}
                                              </ul>
                                          </div>
                                      </div>
                                      <div class='landing col-sm-3'>
                                          <div class='icon'><i class='soap-icon-plane-right yellow-color'></i></div>
                                          <div>
                                              <span class='skin-color'>Tiba</span>
                                              <ul style='list-style: inherit'>
                                                  {$landing}
                                              </ul>
                                          </div>
                                      </div>
                                      <div class='landing col-sm-3'>
                                          <div class='icon'></div>
                                          <div>
                                              <span>Fasilitas</span>
                                              <ul>
                                                  <li>{$fasilitas[$flight_go[$t][0]->maskapai]}</li>
                                              </ul>
                                          </div>
                                      </div>
                                      <div class='total-time col-sm-3'>
                                          <div class='icon'><i class=' yellow-color'></i></div>
                                          <div>
                                              {$hemat}
                                              <ul style='list-style: inherit'>
                                                  {$no_flight}
                                              </ul>
                                          </div>
                                      </div>
                                  </div>
                                  <div class='action'>
                                    {$cetak_isi_diskon_bank}
                                    {$kesatu}
                                  </div>
                              </div>
                          </div>
                      </div>
                  </article>";
    }
    print "</div>
            </div>";
    die;
  }
  
  function konfirmasi_pembayaran(){
    $this->template->build("konfirmasi-pembayaran", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => "<script>function konfirm(){ window.location = '".site_url("antavaya/thank-you")."/'+$('#book_code').val(); }</script>",
      ));
    $this->template
      ->set_layout('default')
      ->build("konfirmasi-pembayaran");
  }
  
  function email_book($book_code){
   // $id_inquiry_costume = $this->global_models->insert("inquiry_costume", $kirim);
      
    $this->load->library('email');
    $this->email->initialize($this->global_models->email_conf());

    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      'book_code'         => $book_code
    );
    $tiket_book_json = $this->curl_mentah($kirim, URLSERVER."json/get-detail-tiket-book");
    $tiket_book = json_decode($tiket_book_json);
   // print_r($tiket_book->diskon_payment[0]->book_code);
    
   // echo $tiket_book->pemesan->email;
   /* print "<pre>";
    print_r($tiket_book); 
    print "</pre>";
    die; */
 
    $this->email->from("no-reply@antavaya.com","AntaVaya Online");
    $this->email->to($tiket_book->pemesan->email);
    $this->email->bcc('nugroho.budi@antavaya.com');
    // die;
    
    $this->email->subject('Tiket Book '.$book_code);
    $isihtml = "
<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html lang='en'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1'> <!-- So that mobile will display zoomed in -->
  <meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- enable media queries for windows phone 8 -->
  <meta name='format-detection' content='telephone=no'> <!-- disable auto telephone linking in iOS -->
  <title>Single Column</title>

  <style type='text/css'>
body {
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}

table {
  border-spacing: 0;
}

table td {
  border-collapse: collapse;
}

.ExternalClass {
  width: 100%;
}

.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
  line-height: 100%;
}

.ReadMsgBody {
  width: 100%;
  background-color: #ebebeb;
}

hr {
  color: #d9d9d9;
  background-color: #d9d9d9;
  height: 1px;
  border: none;
  display: block;
  -webkit-margin-before: 0.5em;
  -webkit-margin-after: 0.5em;
  -webkit-margin-start: auto;
  -webkit-margin-end: auto;
}

table {
  mso-table-lspace: 0pt;
  mso-table-rspace: 0pt;
}

img {
  -ms-interpolation-mode: bicubic;
  outline: none;
  text-decoration: none;
  -ms-interpolation-mode: bicubic;
  width: auto;
  max-width: 100%;
  float: left;
  clear: both;
  display: block;
}

.yshortcuts a {
  border-bottom: none !important;
}

@media screen and (max-width: 599px) {
  table[class='force-row'],
  table[class='container'] {
    width: 100% !important;
    max-width: 100% !important;
  }
}
@media screen and (max-width: 400px) {
  td[class*='container-padding'] {
    padding-left: 12px !important;
    padding-right: 12px !important;
  }
}
.ios-footer a {
  color: #aaaaaa !important;
  text-decoration: underline;
}
</style>

</head>
<body style='margin:0; padding:0;' bgcolor='#ffffff' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#F0F0F0'>
  <tr>
    <td align='center' valign='top' bgcolor='#6B8CF5' style='background-color: #6B8CF5;'>
      <!-- 600px container (white background) -->
      <table class='row header' style='background: #6B8CF5;  padding: 0px;
  width: 100%;
  position: relative;'>
                  <tr>
                    <td class='center' align='center'>
                      <center>
                        <table class='container' >
                          <tr>
                            <td class='wrapper last' style=' width: 580px; vertical-align: top;
                                  text-align: left; margin: 0 auto; padding-right: 0px;  padding: 10px 0px 0px 0px;
  position: relative;'>
                              <table class='twelve columns' style='margin: 0 auto;'>
                                <tr>
                                  <td class='six sub-columns' style='   font-weight: normal; margin: 0;
							text-align: left; padding-right: 10px; width: 80%;  padding: 0px 0px 10px;'>
                                    <img src='".base_url()."/themes/antavaya/images/logo.png'>
                                  </td>
                                  <td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>
                                    <span class='template-label'></span>
                                  </td>
                                  <td class='expander'></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
<!--/600px container -->


    </td>
  </tr>
</table>

<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
  <tr>
    <td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'><br>
     
      <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px;height: 50px;'>
        <tr>
          <td class='container-padding header' align='left'>
            <span style='font-family:Helvetica, Arial, sans-serif;font-size:30px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px'>Dear, {$tiket_book->pemesan->first_name} {$tiket_book->pemesan->last_name}</span>
          <br><br><b> Terima kasih telah melakukan booking di <a href='".site_url()."' target='_blank'>antavaya.com</a></b>
		  <br><br><hr><b>Silahkan pilih cara pembayaran</b> <br><hr>
		  </td>
		  
        </tr>
		<tr>
          <td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff'>
            <br>

		<div style='width: 20%; float: left;font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;color:#374550'>
				<a href='".site_url('payment/gunakan-bca/'.$tiket_book->flight[0]->book_code)."'>
					<img src='".base_url()."/themes/antavaya/images/bca.png' style='max-width: 80px' /><br />
					<br /><br />Transfer BCA
				</a>
		</div>
		<div style='width: 20%; float: left;font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;color:#374550'>
				<a href='http://tiket.antavaya.com/index.php/component/mandiripayment/?view=mandiripayment&layout=default&thepnr={$tiket_book->flight[0]->book_code}'>
					<img src='".base_url()."/themes/antavaya/images/mandiri.png' style='max-width: 80px' /><br />
					<br /><br />Mandiri ClickPay
				</a>
		</div>
		<div style='width: 20%; float: left;font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;color:#374550'>
				<a href='".site_url('payment/gunakan-cc-bank/3/'.$tiket_book->flight[0]->book_code)."'>
					<img src='".base_url()."/themes/antavaya/images/visa.png' style='max-width: 80px' /><br />
					<br /><br />Visa/Master</span>
				</a>
		</div>
        <div style='width: 20%; float: left;font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;color:#374550'>
               <a href='".site_url('payment/gunakan-cc-bank/2/'.$tiket_book->flight[0]->book_code)."'>
                  <img src='".base_url()."/themes/antavaya/images/mega.png' style='max-width: 60px' /><br /><br />
                   <br />Mega Credit Card
               </a>
        </div>
                  <div style='width: 20%; float: left;font-family:Helvetica, Arial, sans-serif;font-size:12px;font-weight:600;color:#374550'>
                   <a href='".site_url('payment/gunakan-cc-bank/4/'.$tiket_book->flight[0]->book_code)."'>
                     <img src='".base_url()."/themes/antavaya/images/mega.png' style='max-width: 60px' /><br /><br />
                      <br />Mega Priority
                             </a>
                                </div>
<br>

          </td>
        </tr>
      </table>";
      if($tiket_book->diskon_payment){ 
	  $isihtml .= "<table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
        
        <tr>
          <td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#b9e5ff;'>
            <table style='font-size:12px;FONT-FAMILY:sans-serif'>
                                  <tbody>";
               foreach ($tiket_book->diskon_payment as $value) {   
                      $isihtml .= "<tr>
                                      <td width='50%'>Diskon khusus bila melakukan pembayaran menggunakan <b>{$value->name}</b></td>
                                        <td width='15%'> <img src='{$value->logo}' style='max-width: 50px' /><br /></td>
                                      <td ><b>Discount Rp ".  number_format($value->diskon, 0, ".", ",")."</b></td>
                                   </tr>";  
               }
                      $isihtml .= "</tbody>
                                </table>
          </td>
		  <td>
		  </td>
        </tr>
      </table>";
      }
    $isihtml .= "
   </td>
  </tr>
  <tr>
    <td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'><br>
	  <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
  <tr>
		<td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#b9e5ff;'>
          <table style='font-size:12px;FONT-FAMILY:sans-serif'>
            <tbody>
                  <tr>
                    <td>Kode Booking </td>
                    <td>: <b>{$tiket_book->flight[0]->book_code}</b></td>
                  </tr>
                  <tr>
                    <td>Time Limit </td>
                    <td>: <b>".date("d F Y H:i:s", strtotime($tiket_book->book->timelimit))." WIB</b></td>
                  </tr>
      <tr><br>
        <td style='padding-top: 5%;'>
         <table class='button' style='width: 120%; overflow: hidden;'>
           <tr>
                <td style='  display: block;
                    width: auto!important;
                    text-align: center;
                    background: #2ba6cb;
                    border: 1px solid #2284a1;
                    color: #ffffff;
                    padding: 8px 0;'>
                  <a href='".site_url("antavaya/thank-you/{$tiket_book->flight[0]->book_code}")."' style='  font-weight: bold;
                    text-decoration: none;
                    font-family: Helvetica,Arial,sans-serif;
                    color: #ffffff;
                    font-size: 16px;'>Proses Payment</a></td>
           </tr>
         </table>
        </td>
     </tr>
    </tbody>
		  <td>
		  </td>
		  </table>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>

      <br>

      <!-- 600px container (white background) -->
      <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px;'>
        <tr>
          <td class='container-padding header' align='left'>
		  <hr><b>Berikut perincian reservasi anda </b> <br><hr>
		  </td>
		  
        </tr>
		
      </table>
	  <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
        
<tr>
	<td class='container-padding content' align='left' style='padding-left:24px;padding-top:10px;padding-right:24px;padding-bottom:12px;background-color:#F0F0F0;'>
	<table style='font-size:12px;FONT-FAMILY:sans-serif; width: 100%;'>
		  <tbody>
			<tr bgcolor='darkgray' style='padding-left:3%'>
			  <td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
				<span style='margin-up:5%'>Informasi Pemesan</span>
			  </td>
			</tr>
			<tr style='padding-left:20%'>
			  <td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>
			  <td width='50%'>: {$tiket_book->pemesan->first_name} {$tiket_book->pemesan->last_name}</td>
			</tr>
			<tr>
			  <td ><span style='padding-bottom: 0%;padding-left:6%'>Handphone </span> </td>
			  <td>: <a href='tel:08767673574' value='+628767673574' target='_blank'>{$tiket_book->pemesan->phone}</a></td>
			</tr>
			<tr>
			  <td ><span style='padding-bottom: 0%;padding-left:6%'>Email </span> </td>
			  <td>: {$tiket_book->pemesan->email}</td>
			</tr>
			<tr>
			  <td><span style='padding-bottom: 0%;padding-left:6%'>Book date </span> </td>
			  <td>: ".date("d F Y", strtotime($tiket_book->book->waktu))."</td>
			</tr>";
$no_adult = 0; 
  $no_child = 0;
  $no_inf   = 0;
foreach ($tiket_book->passenger as $value) {
if($value->type == 1){
$no_adult += 1;
$isihtml .= "
        <tr><td colspan='2' height='5px'><br></td></tr>
				<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
					<span style='margin-up:5%'>Informasi Penumpang {$no_adult}</span>
					</td>
				</tr>
				<tr style='padding-left:20%'>
					<td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>
					<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>
				</tr>
				<tr>
					<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>
					<td>: ".date("d F Y", strtotime($value->tanggal_lahir))."</td>
				</tr>
        <tr><td colspan='2' height='5px'><br></td></tr>";
  } elseif($value->type == 2){  
   $no_child += 1;   
		$isihtml .= "	
			<tr><td colspan='2' height='5px'><br></td></tr>
				<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
					<span style='margin-up:5%'>Informasi Penumpang Child {$no_child}</span>
					</td>
				</tr>
				<tr style='padding-left:20%'>
					<td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>
					<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>
				</tr>
				<tr>
					<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>
					<td>: ".date("d F Y", strtotime($value->tanggal_lahir))."</td>
				</tr><br>
        <tr><td colspan='2' height='5px'><br></td></tr>";
          
  }  elseif($value->type == 3){  
      $no_inf += 1;
		$isihtml .= "		
			<tr><td colspan='2' height='5px'><br></td></tr>
				<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
					<span style='margin-up:5%'>Informasi Penumpang Infant {$no_inf}</span>
					</td>
				</tr>
				<tr style='padding-left:20%'>
					<td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>
					<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>
				</tr>
				<tr>
					<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>
					<td>: ".date("d F Y", strtotime($value->tanggal_lahir))."</td>
				</tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Pax </span> </td><td>: {$value->pax}</td></tr>
				<tr><td colspan='2' height='5px'><br></td></tr>";	
  }  }      
  if($tiket_book->flight[0]->flight == 1){
		 $isihtml .= "
				<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
					<span style='margin-up:5%'>Outgoing Trip</span>
					</td>
				</tr>
				<tr style='padding-left:20%'>
					<td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Flight Date </span></td>
					<td width='50%'>: ".date("d F Y", strtotime($tiket_book->flight[0]->departure))."</td>
				</tr>
				<tr>
					<td ><span style='padding-bottom: 0%;padding-left:6%'>Flight No </span> </td>
					<td>: {$tiket_book->flight[0]->penerbangan[0]->flight_no}</td>
				</tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Depart</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[0]->dari)}</td></tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Arrive</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[0]->ke)}</td></tr>   
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>STD</span> </td><td>: ".date("d F Y H:i:s", strtotime($tiket_book->flight[0]->departure))."</td></tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>STA</span> </td><td>: ".date("d F Y H:i:s", strtotime($tiket_book->flight[0]->arrive))."</td></tr>   
				
        <tr><td colspan='2' height='5px'><br></td></tr>";
  }if($tiket_book->flight[1]->flight == 2){    
		 $isihtml .= "
				<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'><span style='margin-up:5%'>Return Trip</span></td>
				</tr>
				<tr style='padding-left:20%'>
					<td width='14%'><span style='padding-bottom: 0%;padding-left:6%'>Flight Date </span></td>
					<td width='50%'>: ".date("d F Y", strtotime($tiket_book->flight[1]->departure))."</td>
				</tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Flight No </span> </td><td>: {$tiket_book->flight[1]->penerbangan[0]->flight_no}</td></tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Depart</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[1]->dari)}</td></tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Arrive</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[1]->ke)}</td></tr>                                  
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>STD</span> </td><td>: ".date("d F Y H:i:s", strtotime($tiket_book->flight[1]->departure))."</td></tr>
				<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>STA</span> </td><td>: ".date("d F Y H:i:s", strtotime($tiket_book->flight[1]->arrive))."</td></tr>   
				
        <tr><td colspan='2' height='5px'><br></td></tr>";
	}		
				$isihtml .= "<tr bgcolor='darkgray' style='padding-left:3%'>
					<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>
					<span style='margin-up:5%'>Biaya Keseluruhan</span>
					</td>
				</tr>
				<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Price</span> </td><td>: Rp ".number_format(($tiket_book->book->harga_bayar+$tiket_book->book->diskon), 0, ".", ",")."</td></tr>
				<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Admin Fee</span> </td><td>: Gratis</td></tr>
				<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Discount</span> </td><td>: Rp ".number_format($tiket_book->book->diskon, 0, ".", ",")." </td></tr>
				<tr><td colspan='2' height='10px'><br></td></tr>
				<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Total</span> </td><td>: <b>Rp ".number_format($tiket_book->book->harga_bayar, 0, ".", ",")." </b></td></tr>
		 
		</tbody>
	</table>
			<br>
			<hr style='padding-left:100%'>
          </td>
		  <td>
		  
		  </td>
        </tr>
        <tr>
             <td style='font-size:11px;color: #222222;
					font-family:Helvetica,Arial,sans-serif;
					font-weight: normal; padding: 0;margin: 0;
					text-align: left;'>
				<br><b>PERHATIAN UNTUK PEMBAYARAN DENGAN SISTEM PEMBAYARAN TRANSFER</b> <br>
				Bila nilai nominal pembayaran anda tidak sesuai dengan nilai yang tertera di tiket, tiket anda tidak akan tercetak secara otomatis. Sistem e-ticketing kami tidak dapat melakukan pengecekan transaksi pembayaran tiket anda dari pukul 21.00-05.00. Kami harapkan anda untuk melakukan pembayaran dan Konfirmasi Transfer sebelum jam 21.00 ataupun setelah jam 05.00. Bila ingin melakukan pembayaran tiket antara jam 21.00-05.00 lakukan dengan menggunakan Mandiri ClickPay.<br> Jika ada pertanyaan hubungi <b>Layanan Konsumen</b> kami di <b><a href='tel:02129227888' value='+622129227888' target='_blank'>(021) 2922 7888</a></b> atau kirimkan email ke <b><a href='mailto:cs@antavaya.com' target='_blank'>cs@antavaya.com</a></b> dengan mencantumkan Kode Booking, apabila anda mengalami kesulitan atau masalah dalam melakukan pembayaran di website kami.
				<br><br>
            </td>
         </tr>
		 <tr>
            <td class='wrapper last' style='background: url(".base_url()."/themes/antavaya/images/back-foot.png) no-repeat center center; color: white'>
                <table  border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='  font-size: 10px;
  FONT-FAMILY: sans-serif; width:600px;max-width:600px; line-height: 19px;padding-top:2%;padding-bottom:2%'>
         <tr>
                <th style='padding-left:5%'>Contact Center 24 jam <br>+6221 2922 7888 <br>cs@antavaya.com <br></th>
                <th style='padding-left:7%'>Tour inquiries <br>+6221 625 3919 <br>+6221 386 2747 <br>tour@antavaya.com </th>
                <th style='padding-left:8%'>Complaint & compliment <br>customercare@antavaya.com</th>
         </tr>
		 </tr>
      </table>
	  
<!--/600px container -->


    </td>
  </tr>
</table>

<!--/100% background wrapper-->

</body>
</html>";
   // print $isihtml; die;
    $this->email->message($isihtml);  
//die;
    $this->email->send();

//    echo $this->email->print_debugger();
    return true;
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
  
  function popup_faq(){
    $faq = $this->global_models->get_query("SELECT * FROM website_faq ORDER BY sort ASC");
    $this->template->build("faq", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => $foot,
        'faq'         => $faq
      ));
    $this->template
      ->set_layout('popup')
      ->build("faq");
  }

  function popup_terms(){
    $terms = $this->global_models->get_query("SELECT * FROM website_terms ORDER BY sort ASC");
    $this->template->build("terms", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => $foot,
        'terms'         => $terms
      ));
    $this->template
      ->set_layout('popup')
      ->build("terms");
  }

  public function index($v = ""){
    
    $slide = $this->global_models->get_query("SELECT * FROM website_slideshow WHERE status = 1 ORDER BY sort ASC");
    $promosi = $this->global_models->get_query("SELECT * FROM website_promosi WHERE status = 2 ORDER BY price ASC LIMIT 0, 4");
    $group = $this->global_models->get_query("SELECT * FROM website_group_tour WHERE status = 2 ORDER BY price ASC LIMIT 0, 4");
   // $news = $this->global_models->get_query("SELECT * FROM website_news WHERE status = 1 ORDER BY id_website_news DESC LIMIT 0, 2");
    $fit = $this->global_models->get_query("SELECT * FROM website_promosi WHERE status = 2 ORDER BY RAND() LIMIT 0, 2");
    
//    $data = $this->curl_mentah(array(), "http://tiket.antavaya.com/widgets.php");
//    $dt_temp = explode('tnow"', $data);
//    $dt_temp = explode('"', $dt_temp[2]);
//    $this->debug($dt_temp, true);
    $foot = "<script>"
      
      . "$( document ).ajaxStart(function(){ "
        . "$( '#loading-inquiry' ).show();"
//            . "$( '#tampilkan' ).hide();"
      . "});"
      . "$( document ).ajaxStop(function(){ "
        . "$( '#loading-inquiry' ).hide();"
        . "$('#autocomplete_nation').removeClass('working');"
        . "$('#autocomplete_city').removeClass('working');"
      . "});"
      
      . "$(function() {"
//        . "address = $( '#address' );"
      
        . "$( '#autocomplete_nation' ).autocomplete({"
          . "source: '".site_url("ajax/hotel-nation")."',"
          . "minLength: 1,"
          . "search  : function(){ $(this).addClass('working');},"
          . "open    : function(){ $(this).removeClass('working');},"
          . "select: function( event, ui ) {"
            . "$('#id_master_hotel_nation').val(ui.item.value);"
            . "$( '#autocomplete_city' ).autocomplete('option','source','".site_url("ajax/hotel-city")."/'+$('#id_master_hotel_nation').val());"
          . "}"
        . "});"
      
        . "$( '#autocomplete_city' ).autocomplete({"
          . "source: '".site_url("ajax/hotel-city")."/'+$('#id_master_hotel_nation').val(),"
          . "minLength: 1,"
          . "search  : function(){ $(this).addClass('working');},"
          . "open    : function(){ $(this).removeClass('working');},"
          . "select: function( event, ui ) {"
//            . "$('#id_master_hotel_nation').val(ui.item.id);"
          . "}"
        . "});"
      
        . "function submit_form(){"
          . "var nama = $('#name').val();"
          . "var email = $('#email').val();"
          . "var telp = $('#telp').val();"
          . "var note = $('#note').val();"
          . "if(email){"
            . "$.post('".site_url("antavaya/ajax-book-promosi")."', {name: nama, email: email, telp: telp, note: note}, function(data){"
              . "alert('Permintaan akan di proses.');"
              . "dialog.dialog( 'close' );"
            . "});"
          . "}"
          . "else{"
            . "alert('Email harus diisi.')"
          . "}"
        . "}"
        . "dialog = $( '#dialog-form' ).dialog({"
          . "autoOpen: false,"
          . "height: 500,"
          . "width: 500,"
          . "modal: true,"
          . "buttons: {"
            . "'Submit': function() {"
              . "var tg = submit_form();"
            . "},"
            . "Cancel: function() {"
              . "dialog.dialog( 'close' );"
            . "}"
          . "},"
          . "close: function() {"
            . "form[ 0 ].reset();"
          . "}"
        . "});"
        . "form = dialog.find( 'form' ).on( 'submit', function( event ) {"
          . "event.preventDefault();"
        . "});"
        . "$( '#book-now' ).button().on( 'click', function() {"
          . "dialog.dialog( 'open' );"
        . "});"
        . "$( '#book-now-2nd' ).button().on( 'click', function() {"
          . "dialog.dialog( 'open' );"
        . "});"
      . "});"
      
      . "function faq_popup(){"
      . "window.open('".site_url("antavaya/popup-faq")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, width=1100, height=650');"
      . "}"
      . "function term_popup(){"
      . "window.open('".site_url("antavaya/popup-terms")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, width=1100, height=650');"
      . "}"
      . "$(document).ready(function() {"
        . "var tinggi1 = $('.search-box').height() * 1;"
        . "var tinggi2 = $('.search-tabs').height() * 1;"
        . "var nc = $('.nc').width() * 1;"
        . "var hasil_tinggi = tinggi1 - tinggi2 + 5;"
        . "$('.modify-back').height(hasil_tinggi);"
        . "$('.newcon').width(nc);"
      
        . "var fit = 1063;"
        . "var group = 1063;"
//        . "alert(fit);"
/*        . "alert(group);"
        . "if(fit > group){"
          . "$('#fit-pack').height(fit);"
          . "$('#group-pack').height(fit);"
        . "}"
        . "else{"
          . "$('#fit-pack').height(group);"
          . "$('#group-pack').height(group);"
        . "}"*/
//        . "$('.search-box-wrapper').height(tinggi1);"
      . "});"
//      . "setInterval(function() {"
//        . "window.location.reload();"
//      . "}, 300000);"
      
      . "function validasi(){"
        . "var out = 0;"
      
        . "dari = cek_dari();"
        . "out = out + dari['out'];"
        . "if(dari['out'] > 0){"
          . "pesan = dari['pesan'];"
        . "}"
      
        . "ke = cek_ke();"
        . "out = out + ke['out'];"
        . "if(ke['out'] > 0){"
          . "pesan = ke['pesan'];"
        . "}"
      
        . "darisamake = cek_darisamake();"
        . "out = out + darisamake['out'];"
        . "if(darisamake['out'] > 0){"
          . "pesan = darisamake['pesan'];"
        . "}"
      
        . "keberangkatan = cek_keberangkatan();"
        . "out = out + keberangkatan['out'];"
        . "if(keberangkatan['out'] > 0){"
          . "pesan = keberangkatan['pesan'];"
        . "}"
      
        . "pulang = cek_pulang();"
        . "out = out + pulang['out'];"
        . "if(pulang['out'] > 0){"
          . "pesan = pulang['pesan'];"
        . "}"
      
        . "berangkat1tahun = cek_berangkat1tahun();"
        . "out = out + berangkat1tahun['out'];"
        . "if(berangkat1tahun['out'] > 0){"
          . "pesan = berangkat1tahun['pesan'];"
        . "}"
      
        . "bayidewasa = cek_bayidewasa();"
        . "out = out + bayidewasa['out'];"
        . "if(bayidewasa['out'] > 0){"
          . "pesan = bayidewasa['pesan'];"
        . "}"
      
        . "if(out > 0){"
          . "alert(pesan);"
          . "return false;"
        . "}"
        . "else{"
          . "return true;"
        . "}"
      
      . "}"
      
      . "function cek_dari(){"
        . "var hasil_dari = [];"
        . "if(!$('.drdr').val()){"
          . "hasil_dari['pesan'] = 'Silahkan pilih bandara keberangkatan dan tujuan';"
          . "hasil_dari['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_dari['pesan'] = '';"
          . "hasil_dari['out'] = 0;"
        . "}"
        . "return hasil_dari;"
      . "}"
      
      . "function cek_ke(){"
        . "var hasil_ke = [];"
        . "if(!$('.keke').val()){"
          . "hasil_ke['pesan'] = 'Silahkan pilih bandara keberangkatan dan tujuan';"
          . "hasil_ke['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_ke['pesan'] = '';"
          . "hasil_ke['out'] = 0;"
        . "}"
        . "return hasil_ke;"
      . "}"
      
      . "function cek_darisamake(){"
        . "var hasil_darisamake = [];"
        . "if($('.keke').val() == $('.drdr').val()){"
          . "hasil_darisamake['pesan'] = 'Kota keberangkatan dan kota tujuan harus berbeda';"
          . "hasil_darisamake['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_darisamake['pesan'] = '';"
          . "hasil_darisamake['out'] = 0;"
        . "}"
        . "return hasil_darisamake;"
      . "}"
      
      . "function cek_keberangkatan(){"
        . "var hasil_keberangkatan = [];"
        . "var tgl = $('#tgl').val();"
        . "var tgl_input = new Date(tgl+' 23:58:00');"
        . "var tgl_now = new Date();"
        . "if(tgl_input.getTime() < tgl_now.getTime()){"
          . "hasil_keberangkatan['pesan'] = 'Maaf, tanggal yang dipilih sudah lewat. Silahkan pilih tanggal lain.';"
          . "hasil_keberangkatan['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_keberangkatan['pesan'] = '';"
          . "hasil_keberangkatan['out'] = 0;"
        . "}"
        . "return hasil_keberangkatan;"
      . "}"
      
      . "function cek_pulang(){"
        . "var hasil_pulang = [];"
        . "var tgl = $('#tgl').val();"
        . "var tglr = $('#tglr').val();"
        . "var tgl_input = new Date(tgl);"
        . "var tgl_pulang = new Date(tglr);"
        . "if(tgl_input.getTime() > tgl_pulang.getTime()){"
          . "hasil_pulang['pesan'] = 'Tanggal pulang minimal harus sama atau lebih besar dari tanggal pergi. Silahkan pilih tanggal lain.';"
          . "hasil_pulang['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_pulang['pesan'] = '';"
          . "hasil_pulang['out'] = 0;"
        . "}"
        . "return hasil_pulang;"
      . "}"
      
      . "function cek_berangkat1tahun(){"
        . "var hasil_berangkat1tahun = [];"
        . "var tgl = $('#tgl').val();"
        . "var tgl_input = new Date(tgl);"
        . "var tgl_sekarang = new Date();"
        . "tgl_sekarang.setFullYear(".(date("Y")+1).");"
        . "if(tgl_input.getTime() >= tgl_sekarang.getTime()){"
          . "hasil_berangkat1tahun['pesan'] = 'Tanggal keberangkatan tidak lebih dari 360 hari.';"
          . "hasil_berangkat1tahun['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_berangkat1tahun['pesan'] = '';"
          . "hasil_berangkat1tahun['out'] = 0;"
        . "}"
        . "return hasil_berangkat1tahun;"
      . "}"
      
      . "function cek_bayidewasa(){"
        . "var hasil_bayidewasa = [];"
        . "var adl = $('#adl').val() * 1;"
        . "var inf = $('#inf').val() * 1;"
        . "if(adl < inf){"
          . "hasil_bayidewasa['pesan'] = 'Jumlah bayi tidak lebih dari jumlah dewasa.';"
          . "hasil_bayidewasa['out'] = 1;"
        . "}"
        . "else{"
          . "hasil_bayidewasa['pesan'] = '';"
          . "hasil_bayidewasa['out'] = 0;"
        . "}"
        . "return hasil_bayidewasa;"
      . "}"
      
      . "</script>";
    $key = $dt_temp[1];
    if($this->mobile_detect->isMobile()){
      $this->template->build("mobile/main", 
        array(
          'url'         => base_url()."themes/mobile-antavaya/",
          'theme2nd'    => 'mobile-antavaya',
        ));
      $this->template
        ->set_layout('default')
        ->build("mobile/main");
    }
    else{
      $this->template->build("main", 
        array(
          'url'         => base_url()."themes/antavaya/",
          'theme2nd'    => 'antavaya',
          'slide'       => $slide,
          'promosi'     => $promosi,
           'fit'         => $fit,
          'key'         => $key,
          'foot2'       => $foot,
          'group'       => $group,
        //    'news'       => $news
        ));
      $this->template
        ->set_layout('default')
        ->build("main");
    }
  }
  
  function olah_waktu_view($tanggal, $jam, $sebelum = 0){
    $jam_array = explode("@", $jam);
    foreach ($jam_array AS $ja){
      $time[] = $sebelum = $this->olah_waktu($tanggal, $ja, $sebelum);
    }
    return $time;
  }
  
  function olah_waktu($tgl, $waktu, $compare = 0){
    $bulan = array(
      date("F", strtotime("2015-01-01")) => '01',
      date("F", strtotime("2015-02-01")) => '02',
      date("F", strtotime("2015-03-01")) => '03',
      date("F", strtotime("2015-04-01")) => '04',
      date("F", strtotime("2015-05-01")) => '05',
      date("F", strtotime("2015-06-01")) => '06',
      date("F", strtotime("2015-07-01")) => '07',
      date("F", strtotime("2015-08-01")) => '08',
      date("F", strtotime("2015-09-01")) => '09',
      date("F", strtotime("2015-10-01")) => '10',
      date("F", strtotime("2015-11-01")) => '11',
      date("F", strtotime("2015-12-01")) => '12',
    );
    $pecah = explode(" ", urldecode($tgl));
//    $this->debug($pecah, true);
    $time_tgl = date("Y-m-d", strtotime($pecah[2]."-".$bulan[$pecah[1]]."-".$pecah[0]));
    $time = substr($waktu, 0, 2).":".substr($waktu, -2);
//    $this->debug($time_tgl." ".$time, true);
    if($compare <> 0 AND $compare > strtotime($time_tgl." ".$time)){
      $time_tgl = date("Y-m-d", strtotime("+1 day", strtotime($pecah[2]."-".$bulan[$pecah[1]]."-".($pecah[0]))));
    }
    return strtotime($time_tgl." ".$time);
  }
  
  function ajax_get_xml($pp = 0){
    $ke = $this->input->post("ke");
    
    
    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      "asal"              => $this->input->post("asal"),
      "tujuan"            => $this->input->post("tujuan"),
      "tgl"               => "{$this->input->post("tanggalpergi")}",
      "tglkembali"        => "{$this->input->post("tanggalkembali")}",
      "adl"               => $this->input->post("adl"),
      "chd"               => $this->input->post("chd"),
      "inf"               => $this->input->post("inf"),
      "sig"               => $this->input->post("sig"),
      "ke"                => $ke
    );
    $code_dest = $this->input->post("asal")."-".$this->input->post("tujuan");
    $code_dest2 = $this->input->post("tujuan")."-".$this->input->post("asal");
      
//    $kirim = array(
//      'users'             => 'test', 
//      'password'          => "123", 
//      "asal"              => "CGK",
//      "tujuan"            => "DPS",
//      "tgl"               => "20 March 2015",
//      "tglkembali"        => "",
//      "adl"               => 1,
//      "chd"               => 0,
//      "inf"               => 0,
//      "sig"               => "",
//      "ke"                => "1",
//    );
    
//    $ke = 4;
    
    $data = $this->curl_mentah($kirim, URLSERVER."json/get-flight");
    $data_array = json_decode($data);
    
    $data_diskon = $this->curl_mentah(
      array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s")), 
      URLSERVER."json/cek-diskon-payment");
    $data_diskon_array = json_decode($data_diskon);
//    $code_dest = "CGK-BKS-CGK";
    $data_diskon_dest = $this->curl_mentah(
      array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
      URLSERVER."json/cek-diskon-destination");
    $data_diskon_dest_array = json_decode($data_diskon_dest);
    
//    $this->debug($kirim);
//    $this->debug($data_diskon_dest_array, true);
//    print json_encode($data_array);die;
    $html = "";
    $fasilitas = array(
      "GA"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none'></i>",
      "SJ"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none'></i>",
      "ID"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>
                  <i class='soap-icon-breakfast' style='text-transform: none'></i>",
      "IW"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>10</span></i>",
      "JT"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>20</span></i>",
      "QG"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>15</span></i>",
      "QZ"    => "<i class='soap-icon-plane' style='text-transform: none'><span style='font-size: 8px'>Tax</span></i>
                  <i class='soap-icon-baggage' style='text-transform: none'><span style='font-size: 12px'>15</span></i>",
    );
    foreach ($data_array AS $key => $da){
      if($da->harga > 0){
        
        $kirim_flight_items = array();
        $diskon = $this->global_models->diskon($da->maskapai, $da->harga);
        $kirim_flight = array(
          "session_id"      => $this->session->userdata('session_id'),
          "dari"            => $da->dari,
          "ke"              => $da->ke,
          "stop"            => $da->stop,
          "take_off"        => $da->departure,
          "landing"         => $da->arrive,
          "flight_no"       => $da->role[0]->flight,
          "price"           => $da->harga,
          "child"           => $da->child,
          "infant"          => $da->infant,
          "hemat"           => $da->diskon_maskapai,
          "jual"            => $da->total_harga,
          "maskapai"        => $da->maskapai,
          "img"             => $da->img,
          "id_website_class_code" => $da->maskapai.$da->role[0]->class,
          "id_flight"       => $da->id_flight,
          "status"          => 2,
          "note"            => "",
          "penumpang"       => $this->session->userdata("flight_adl").$this->session->userdata("flight_chd").$this->session->userdata("flight_inf"),
          "create_date"     => date("Y-m-d H:i:s")
        );
        $id_website_flight_temp = $this->global_models->insert("website_flight_temp", $kirim_flight);
        if($id_website_flight_temp){
          $flight = $berangkat_pp = $tiba_pp = "";
          $kirim_items = array();
          foreach($da->role AS $role){
            $kirim_items[] = array(
              "id_website_flight_temp"        => $id_website_flight_temp,
              "flight_no"                     => $role->flight,
              "dari"                          => $role->dari,
              "ke"                            => $role->ke,
              "id_website_class_code"         => $da->maskapai.$role->class,
              "take_off"                      => $role->departure,
              "landing"                       => $role->arrive,
              "note"                          => "",
              "create_date"                   => date("Y-m-d H:i:s")
            );
            $flight .= "{$role->flight}<br />";
            $berangkat_pp .= date("H:i", strtotime($role->departure))."<br />";
            $tiba_pp .= date("H:i", strtotime($role->arrive))."<br />";
          }
          $this->global_models->insert_batch("website_flight_temp_items", $kirim_items);
        }
      
        if($pp == 2){
          $empat_hari = strtotime("+4 days");
          $stat = $mega = "2";
          $harga_mega = 0;
          if($kirim_flight['maskapai'] == "QZ"){
            if(strtotime($kirim_flight['take_off']) < $empat_hari){
              $stat = "1";
            }
          }
          $hemat = $this->global_models->diskon($da->maskapai, $da->harga);
          $jual = $da->harga - $hemat;
          
          if($data_diskon_array->status == 2){
            $harga_mega = "";
            foreach($data_diskon_array->diskon AS $kdda => $dda){
              if($dda->type == 1){
                $diskon_jual_khusus = $dda->diskon/100 * ($da->total_harga - $da->diskon_maskapai);
                $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $diskon_jual_khusus;
              }
              else{
                $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $dda->diskon;
              }
              $harga_mega .= "<img src='{$dda->logo}' width='50' />Rp {$this->global_models->format_angka_atas($jual_khusus, 0, ",", ".")}<br />";
            }
            $mega = "1";
          }
          
          $data_diskon_dest2 = $this->curl_mentah(
            array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest2), 
            URLSERVER."json/cek-diskon-destination");
          $data_diskon_dest_array2 = json_decode($data_diskon_dest2);
          
          if($da->dari == $kirim['asal']){
            if($data_diskon_dest_array->status == 2){
              $harga_mega = "";
              foreach($data_diskon_dest_array->diskon AS $kdda => $dda){
                if($da->maskapai == $kdda){
                  if($dda->type == 1){
                    $diskon_jual_khusus = $dda->diskon/100 * ($da->total_harga - $da->diskon_maskapai);
                    $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $diskon_jual_khusus;
                  }
                  else{
                    $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $dda->diskon;
                  }
                  $harga_mega .= "<img src='{$dda->logo}' width='20' /> Rp {$this->global_models->format_angka_atas($jual_khusus, 0, ",", ".")}<br />";
                }
                $mega = "1";
              }
            }
            $pulang_pergi[] = array(
                "id_website_flight_temp_encrypt"  => $this->encrypt->encode($id_website_flight_temp),
                "take_off"                        => $berangkat_pp,
                "landing"                         => $tiba_pp,
                "jual"                            => $this->global_models->format_angka_atas(($da->total_harga - $da->diskon_maskapai),0,",","."),
                "img"                             => $da->img,
                "hemat"                           => $this->global_models->format_angka_atas($da->diskon_maskapai,0,",","."),
                "harga"                           => $this->global_models->format_angka_atas($da->total_harga,0,",","."),
                "stat"                            => $stat,
                "mega"                            => $harga_mega,
                "stat2"                           => $mega,
                "flight"                          => $flight,
                "ke"                              => ($ke*100)
              );
          }
          else{
            if($data_diskon_dest_array2->status == 2){
              $harga_mega = "";
              foreach($data_diskon_dest_array2->diskon AS $kdda => $dda){
                if($da->maskapai == $kdda){
                  if($dda->type == 1){
                    $diskon_jual_khusus = $dda->diskon/100 * ($da->total_harga - $da->diskon_maskapai);
                    $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $diskon_jual_khusus;
                  }
                  else{
                    $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $dda->diskon;
                  }
                  $harga_mega .= "<img src='{$dda->logo}' width='20' /> Rp {$this->global_models->format_angka_atas($jual_khusus, 0, ",", ".")}<br />";
                }
                $mega = "1";
              }
            }
            $pergi_pergi[] = array(
                "id_website_flight_temp_encrypt"  => $this->encrypt->encode($id_website_flight_temp),
                "take_off"                        => $berangkat_pp,
                "landing"                         => $tiba_pp,
                "jual"                            => $this->global_models->format_angka_atas(($da->total_harga - $da->diskon_maskapai),0,",","."),
                "img"                             => $da->img,
                "hemat"                           => $this->global_models->format_angka_atas($da->diskon_maskapai,0,",","."),
                "harga"                           => $this->global_models->format_angka_atas($da->total_harga,0,",","."),
                "stat"                            => $stat,
                "mega"                            => $harga_mega,
                "stat2"                           => $mega,
                "flight"                          => $flight,
                "ke"                              => ($ke*100)
              );
          }
        }
        
//        end round trip
        
        else{
          
          $empat_hari = strtotime("+4 days");
          $stat = $mega = "2";
          $harga_mega = 0;
          if($da->maskapai == "QZ"){
            if(strtotime($kirim_flight['take_off']) < $empat_hari){
              $stat = "1";
            }
          }
          
          $hemat = $this->global_models->diskon($da->maskapai, $da->harga);
          $jual = $da->harga - $hemat;
          
          
          if($data_diskon_dest_array->status == 2){
            $harga_mega = "";
            foreach($data_diskon_dest_array->diskon AS $kdda => $dda){
              if($da->maskapai == $kdda){
                if($dda->type == 1){
                  $diskon_jual_khusus = $dda->diskon/100 * ($da->total_harga - $da->diskon_maskapai);
                  $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $diskon_jual_khusus;
                }
                else{
                  $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $dda->diskon;
                }
                $harga_mega .= "<img src='{$dda->logo}' width='20' /> Rp {$this->global_models->format_angka_atas($jual_khusus, 0, ",", ".")}<br />";
              }
              $mega = "1";
            }
          }
          if($data_diskon_array->status == 2){
            $harga_mega = "";
            foreach($data_diskon_array->diskon AS $kdda => $dda){
              if($dda->type == 1){
                $diskon_jual_khusus = $dda->diskon/100 * ($da->total_harga - $da->diskon_maskapai);
                $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $diskon_jual_khusus;
              }
              else{
                $jual_khusus = ($da->total_harga - $da->diskon_maskapai) - $dda->diskon;
              }
              $harga_mega .= "<img src='{$dda->logo}' width='50' />Rp {$this->global_models->format_angka_atas($jual_khusus, 0, ",", ".")}<br />";
            }
            $mega = "1";
          }
          
          $pulang_pergi[] = array(
            "id_website_flight_temp_encrypt"  => $this->encrypt->encode($id_website_flight_temp),
            "take_off"                        => $berangkat_pp,
            "landing"                         => $tiba_pp,
            "jual"                            => $this->global_models->format_angka_atas(($da->total_harga - $da->diskon_maskapai),0,",","."),
            "img"                             => $da->img,
            "hemat"                           => $this->global_models->format_angka_atas($da->diskon_maskapai,0,",","."),
            "harga"                           => $this->global_models->format_angka_atas($da->total_harga,0,",","."),
            "stat"                            => $stat,
            "mega"                            => $harga_mega,
            "stat2"                           => $mega,
            "flight"                          => $flight,
            "fasilitas"                       => $fasilitas[$da->maskapai],
            "ke"                              => ($ke*100)
          );
          
        };
                                    
      }
    }
//    $this->debug($pulang_pergi, true);
    if($pp == 2){
      $cetak = array(
        "p"   => $pulang_pergi,
        "k"   => $pergi_pergi
      );
      print json_encode($cetak);
    }
    else{
      $cetak = array(
        "p"   => $pulang_pergi,
      );
      print json_encode($cetak);
    }
    die;
  }
  
  function just_code($kota){
    $rest = substr($kota, -5);
    $kota_temp = explode("(", $rest);
    $kota_t = explode(")", $kota_temp[1]);
    return $kota_t[0];
  }
  
  function flight_list($sort = "", $type = "ASC"){
    $this->load->library('global_variable');
    $data_diskon = $this->global_variable->curl_mentah(
      array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s")), 
      URLSERVER."json/cek-diskon-payment");
    $data_diskon_array = json_decode($data_diskon);
    
    
    $pst = $this->input->post();
//    $this->debug($this->session->userdata("session_id"), true);
    if($pst){
      $css = "<link href='".base_url()."themes/lte/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/lte/js/jquery1.10.2.min.js' type='text/javascript'></script>";
      $foot .= "<script src='".base_url()."themes/lte/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
    
      $this->global_models->query("DELETE FROM website_flight_temp WHERE create_date < '".date("Y-m-d H:i:s", (strtotime("now") - (30*60)))."'");
      $max = $this->global_models->get_field("website_flight_temp", "MAX(id_website_flight_temp)");
      $max += 1;
      $this->global_models->query("ALTER TABLE website_flight_temp AUTO_INCREMENT = ".$max);
      $this->global_models->query("DELETE FROM website_flight_temp_items WHERE create_date < '".date("Y-m-d H:i:s", (strtotime("now") - (30*60)))."'");
      $sess = array(
        "flight_dari"       => $this->just_code($pst['tdr']),
        "flight_ke"         => $this->just_code($pst['tke']),
        "flight_berangkat"  => $pst['tgl'],
        "flight_pulang"     => $pst['tglr'],
        "flight_adl"        => $pst['adl'],
        "flight_chd"        => $pst['chd'],
        "flight_inf"        => $pst['inf'],
        "flight_rdotrip"    => $pst['rdotrip'],
      );
//      $this->debug($sess, true);
      $this->session->set_userdata($sess);
      
      $code_dest = $sess['flight_dari']."-".$sess['flight_ke'];
      $data_diskon_dest = $this->curl_mentah(
        array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
        URLSERVER."json/cek-diskon-destination");
      $data_diskon_dest_array = json_decode($data_diskon_dest);
      
      $minta = array(
        "dari"      => $this->session->userdata("flight_dari"),
        "ke"        => $this->session->userdata("flight_ke"),
        "berangkat" => $this->session->userdata("flight_berangkat"),
        "pulang"    => $this->session->userdata("flight_pulang"),
        "rdotrip"   => $this->session->userdata("flight_rdotrip"),
      );
      $olah_flight = FALSE;
//      $data = $this->get_data_temp($minta, "jual", $type);
      $view = "flight-list";
      if($minta["rdotrip"] == "Round trip"){
        $pp = 2;
        $view = "flight-list-pp";
        if($data[0] AND $data[1]){
          $olah_flight = TRUE;
          $foot .= "<script type='text/javascript' src='".base_url()."themes/antavaya/js/jquery.tablesorter.js'></script>"
            . "<script type='text/javascript'>"
            . "function cekback(){"
              . "var go = $('input[name=go]:checked').val();"
              . "var back = $('input[name=back]:checked').val();"
              . "if(go && back){"
                . "$.post('".site_url("antavaya/ajax-flight-pp")."', {go: go, back: back}, function(data){"
                  . "$('#rangkuman').html(data);"
                  . "$('html,body').animate({scrollTop: 0}, 1000);"
                . "});"
              . "}"
            . "}"
            . "$('#table1').tablesorter();"
            . "$('#table2').tablesorter();"
            . "</script>";
        }
      }
      else{
        if($data[0]){
          $olah_flight = TRUE;
        }
      }
      
      if($olah_flight === FALSE){
        $url = base_url()."themes/antavaya/maskapai";
        $url2 = base_url()."themes/antavaya/";
        if($pp == 2){
          $fgh = <<<EOD
            var ft = $.parseJSON(data);
            var a = ft.p;
            var b = ft.k;
            var cetakan_pergi = "";
            var cetakan_pulang = "";
            if(a){
              a.forEach(function(entry) {
                  var button_khusus1 = "";
                  var khusus1 = "";
                  if(entry.stat == '2'){
                    button_khusus1 = "<input type='radio' onclick='cekback()' name='go' value='"+entry.id_website_flight_temp_encrypt+"' />";
                  }
                  if(entry.stat2 == '1'){
                    khusus1 = "<td></td><td style='color: #bd2330; font-size: 15px; font-weight: bold'>"+entry.mega+"</td>";
                  }
                  cetakan_pergi = cetakan_pergi + "<tr><td>"+button_khusus1+"<img src='{$url}/"+entry.img+"' width='50px' /></td><td>"+entry.take_off+"({$this->session->userdata("flight_dari")})</td><td>"+entry.landing+"({$this->session->userdata("flight_ke")})</td><td></td><td>Rp "+entry.hemat+"</td>"+khusus1+"<td></td><td><s>Rp "+entry.harga+"</s><br /><span style='font-size: 17px; color: #1a6ea5'>Rp "+entry.jual+"</span></td></tr>";
              });
              $('#list').after(cetakan_pergi);
            }
            if(b){
              b.forEach(function(entryb) {
                  var button_khusus = "";
                  var khusus = "";
                  if(entryb.stat == '2'){
                    button_khusus = "<input type='radio' onclick='cekback()' name='back' value='"+entryb.id_website_flight_temp_encrypt+"' />";
                  }
                  if(entryb.stat2 == '1'){
                    khusus = "<td></td><td style='color: #bd2330; font-size: 15px; font-weight: bold'>"+entryb.mega+"</td>";
                  }
                  cetakan_pulang = cetakan_pulang + "<tr><td>"+button_khusus+"<img src='{$url}/"+entryb.img+"' width='50px' /></td><td>"+entryb.take_off+"({$this->session->userdata("flight_ke")})</td><td>"+entryb.landing+"({$this->session->userdata("flight_dari")})</td><td></td><td>Rp "+entryb.hemat+"</td>"+khusus+"<td></td><td><s>Rp "+entryb.harga+"</s><br /><span style='font-size: 17px; color: #1a6ea5'>Rp "+entryb.jual+"</span></td></tr>";
              });
              $('#list1').after(cetakan_pulang);
            }
EOD;
          $code_dest = $sess['flight_ke']."-".$sess['flight_dari'];
          $data_diskon_dest2 = $this->curl_mentah(
            array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
            URLSERVER."json/cek-diskon-destination");
          $data_diskon_dest_array2 = json_decode($data_diskon_dest2);
        }
        else{
          $fgh = <<<EOD
            var ft = $.parseJSON(data);
            var a = ft.p;
            var cetakan_pergi = "";
            var r = 0;
            if(a){
              a.forEach(function(entry) {
                  var s = (entry.ke * 1) + r;
                  var button_khusus1 = "Dapat Book <br />4 Hari dari Hari ini";
                  var khusus1 = "";
                  if(entry.stat == '2'){
                    button_khusus1 = "<input name='doce["+s+"]' value='"+entry.id_website_flight_temp_encrypt+"' style='display: none'><button name='submit' value='"+s+"' class='button btn-small full-width'>Pesan</button>";
                  }
                  if(entry.stat2 == '1'){
                    khusus1 = "<td></td><td style='color: #bd2330; font-size: 15px; font-weight: bold'>"+entry.mega+"</td>";
                  }
                  cetakan_pergi = cetakan_pergi + "<tr><td><img src='{$url}/"+entry.img+"' width='70px' /></td><td>"+entry.flight+"</td><td>"+entry.take_off+"({$this->session->userdata("flight_dari")})</td><td>"+entry.landing+"({$this->session->userdata("flight_ke")})</td><td style='font-size: 18px'>"+entry.fasilitas+"</td><td>Rp "+entry.hemat+"</td>"+khusus1+"<td></td><td><s>Rp "+entry.harga+"</s><br /><span style='font-size: 17px; color: #1a6ea5'>Rp "+entry.jual+"</span></td><td style='text-align: center'>"+button_khusus1+"</td></tr>";
                  r++;
              });
              $('#list').after(cetakan_pergi);
            }
EOD;
        }
        $foot .= "<script>"
          . "function cekback(){"
              . "var go = $('input[name=go]:checked').val();"
              . "var back = $('input[name=back]:checked').val();"
              . "if(go && back){"
                . "$.post('".site_url("antavaya/ajax-flight-pp")."', {go: go, back: back}, function(data){"
                  . "$('#rangkuman').html(data);"
                  . "$('html,body').animate({scrollTop: 0}, 1000);"
                . "});"
              . "}"
            . "}"
          . "function get_data(ke){"
            . "$.post('".site_url("antavaya/ajax-get-xml/{$pp}")."', {ke: ke, asal: '".$this->just_code($pst['tdr'])."', tujuan: '".$this->just_code($pst['tke'])."', tanggalpergi: '{$pst['tgl']}', tanggalkembali: '{$pst['tglr']}', adl: '{$pst['adl']}', chd: '{$pst['chd']}', inf: '{$pst['inf']}', sig: '', rdoway: '{$pst['rdotrip']}'}, function(data){"
              . $fgh
            . "});"
          . "}"
          . "$( document ).ajaxStart(function(){ "
            . "$( '#loading-flight' ).show();"
//            . "$( '#tampilkan' ).hide();"
          . "});"
          . "$( document ).ajaxStop(function(){ "
            . "$( '#loading-flight' ).hide();"
            . "window.location = '".site_url("antavaya/flight-list/jual")."'"
          . "});"
          . "get_data(1);"
          . "get_data(2);"
          . "get_data(3);"
          . "get_data(4);"
          . "get_data(5);"
        . "$(document).ready(function(){"
          . "$('#pencarian').click(function(){"
            . "if($(this).attr('class') == 'active'){"
              . "$('#pencarian').removeClass('active');"
              . "$('#hasil_pencarian').removeClass('active');"
              . "$('#hasil_pencarian').addClass('fade');"
            . "}"
            . "else{"
              . "$('#hasil_pencarian').addClass('active');"
              . "$('#pencarian').addClass('active');"
              . "$('#hasil_pencarian').removeClass('fade');"
            . "}"
          . "});"
        . "});"
          . "</script>"
        ;
      }
//      $this->debug($data, true);
      if($this->mobile_detect->isMobile()){
          if($minta["rdotrip"] == "Round trip"){
          $pp = 2;
        }
        $this->template->build("mobile/flight-list", 
          array(
            'url'         => base_url()."themes/mobile-antavaya/",
            'theme2nd'    => 'mobile-antavaya',
            'pp'          => $pp,
            'foot2'       => $foot
          ));
        $this->template
          ->set_layout('default')
          ->build("mobile/flight-list");
      }
      else{
        $this->template->build($view, 
          array(
            'url'         => base_url()."themes/antavaya/",
            'theme2nd'    => 'antavaya',
            'foot2'       => $foot,
            'css'         => $css,
            'data'        => $data,
            'data_diskon_array' => $data_diskon_array,
            'data_diskon_dest_array' => $data_diskon_dest_array,
            'data_diskon_dest_array2' => $data_diskon_dest_array2,
          ));
        $this->template
          ->set_layout('default')
          ->build($view);
      }
    }
    else if($sort){
      
      $this->global_models->update("website_flight_temp", array("session_id" => $this->session->userdata("session_id"), "status" => 1), array("status" => 2));
      
      $minta = array(
        "dari"      => $this->session->userdata("flight_dari"),
        "ke"        => $this->session->userdata("flight_ke"),
        "berangkat" => $this->session->userdata("flight_berangkat"),
        "pulang"    => $this->session->userdata("flight_pulang"),
        "rdotrip"   => $this->session->userdata("flight_rdotrip"),
      );
      $data = $this->get_data_temp($minta, $sort, $type);
      
      $code_dest = $minta['dari']."-".$minta['ke'];
      $data_diskon_dest = $this->curl_mentah(
        array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
        URLSERVER."json/cek-diskon-destination");
      $data_diskon_dest_array = json_decode($data_diskon_dest);
//      $this->debug($minta);
//      $this->debug($data, true);
      if(!$data[0]){
        redirect();
      }
      $css = "<link href='".base_url()."themes/lte/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/lte/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot .= "<script src='".base_url()."themes/lte/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
      $foot .= "<script type='text/javascript' src='".base_url()."themes/antavaya/js/jquery.tablesorter.js'></script>"
        . "<script type='text/javascript'>"
        . "function cekback(){"
          . "var go = $('input[name=go]:checked').val();"
          . "var back = $('input[name=back]:checked').val();"
          . "if(go && back){"
            . "$.post('".site_url("antavaya/ajax-flight-pp")."', {go: go, back: back}, function(data){"
              . "$('#rangkuman').html(data);"
              . "$('html,body').animate({scrollTop: 0}, 1000);"
            . "});"
          . "}"
        . "}"
        . "$('#table1').tablesorter();"
        . "$('#table2').tablesorter();"
        . "$(document).ready(function(){"
          . "$('#pencarian').click(function(){"
            . "if($(this).attr('class') == 'active'){"
              . "$('#pencarian').removeClass('active');"
              . "$('#hasil_pencarian').removeClass('active');"
              . "$('#hasil_pencarian').addClass('fade');"
            . "}"
            . "else{"
              . "$('#hasil_pencarian').addClass('active');"
              . "$('#pencarian').addClass('active');"
              . "$('#hasil_pencarian').removeClass('fade');"
            . "}"
          . "});"
        . "});"
        . "</script>";
//      $data = $this->global_models->get("website_flight_temp");
      if($this->mobile_detect->isMobile()){
        if($minta["rdotrip"] == "Round trip"){
          $pp = 2;
        }
        $this->template->build("mobile/flight-list", 
          array(
            'url'         => base_url()."themes/mobile-antavaya/",
            'theme2nd'    => 'mobile-antavaya',
            'pp'          => $pp,
            'data'        => $data
          ));
        $this->template
          ->set_layout('default')
          ->build("mobile/flight-list");
      }
      else{
        $view = "flight-list";
        if($minta["rdotrip"] == "Round trip"){
          $code_dest = $minta['ke']."-".$minta['dari'];
          $data_diskon_dest2 = $this->curl_mentah(
            array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
            URLSERVER."json/cek-diskon-destination");
          $data_diskon_dest_array2 = json_decode($data_diskon_dest2);
//          $this->debug($data_diskon_dest2, true);
          $view = "flight-list-pp";
        }
          
        $this->template->build("flight-list", 
          array(
            'url'         => base_url()."themes/antavaya/",
            'theme2nd'    => 'antavaya',
            'data'        => $data,
            'sort'        => $sort,
            'type'        => $type,
            'foot2'       => $foot,
            'css'         => $css,
            'data_diskon_array' => $data_diskon_array,
            'data_diskon_dest_array' => $data_diskon_dest_array,
            'data_diskon_dest_array2' => $data_diskon_dest_array2,
          ));
        
        $this->template
          ->set_layout('default')
          ->build($view);
      }
    }
    else{
      redirect();
    }
  }
  
  function get_data_temp($minta, $sort, $type){
    $data = $this->global_models->get_query("SELECT *"
      . " FROM website_flight_temp"
      . " WHERE dari = '{$minta['dari']}'"
      . " AND ke = '{$minta['ke']}'"
      . " AND (take_off BETWEEN '".date("Y-m-d H:i:s", $this->olah_waktu($minta['berangkat'], "0001"))."' AND '".date("Y-m-d H:i:s", $this->olah_waktu($minta['berangkat'], "2359"))."')"
      . " AND create_date >= '".date("Y-m-d H:i:s", (strtotime("now") - (7*60)))."'"
      . " AND status = 2"
      . " AND penumpang = '{$this->session->userdata("flight_adl")}{$this->session->userdata("flight_chd")}{$this->session->userdata("flight_inf")}'"
      . " GROUP BY flight_no"
      . " ORDER BY {$sort} {$type}, create_date DESC"
      . "");
    
    if($minta["rdotrip"] == "Round trip"){
      $data2 = $this->global_models->get_query("SELECT *"
        . " FROM website_flight_temp"
        . " WHERE dari = '{$minta['ke']}'"
        . " AND ke = '{$minta['dari']}'"
        . " AND (take_off BETWEEN '".date("Y-m-d H:i:s", $this->olah_waktu($minta['pulang'], "0001"))."' AND '".date("Y-m-d H:i:s", $this->olah_waktu($minta['pulang'], "2359"))."')"
        . " AND create_date >= '".date("Y-m-d H:i:s", (strtotime("now") - (7*60)))."'"
        . " AND status = 2"
        . " AND penumpang = '{$this->session->userdata("flight_adl")}{$this->session->userdata("flight_chd")}{$this->session->userdata("flight_inf")}'"
        . " GROUP BY flight_no"
        . " ORDER BY {$sort} {$type}, create_date DESC"
        . "");
      return array($data, $data2);
    }
    else{
      return array($data);
    }
  }
  
  function book(){
      
//      $this->debug($sess, true);
    
      
    $pst = $this->input->post();
      
//    $this->debug($pst, true);
    if($pst){
      $data_diskon = $this->curl_mentah(
        array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s")), 
        URLSERVER."json/cek-diskon-payment");
      $data_diskon_array = json_decode($data_diskon);
      
//      $this->debug($data_diskon_array, true);
    
      $id_website_flight_temp_encode = $pst['doce'][$pst['submit']];
      if($pst['pp'] == 2){
        $id_website_flight_temp_encode2 = $pst['back'];
        $id_website_flight_temp2 = $this->encrypt->decode($id_website_flight_temp_encode2);
        $id_website_flight_temp_encode = $pst['go'];
        $flight2 = $this->global_models->get_query("SELECT A.*, B.code, B.note AS class"
          . " FROM website_flight_temp AS A"
          . " LEFT JOIN website_class_code AS B ON B.id_website_class_code = A.id_website_class_code"
          . " WHERE A.id_website_flight_temp = '{$id_website_flight_temp2}'");
        $items2 = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $id_website_flight_temp2));
      }
      $id_website_flight_temp = $this->encrypt->decode($id_website_flight_temp_encode);
      $flight = $this->global_models->get_query("SELECT A.*, B.code, B.note AS class"
        . " FROM website_flight_temp AS A"
        . " LEFT JOIN website_class_code AS B ON B.id_website_class_code = A.id_website_class_code"
        . " WHERE A.id_website_flight_temp = '{$id_website_flight_temp}'");
        
      $code_dest = $flight[0]->dari."-".$flight[0]->ke;
      $data_diskon_dest = $this->curl_mentah(
        array('users' => USERSSERVER, 'password' => PASSSERVER,'tanggal' => date("Y-m-d H:i:s"), 'code' => $code_dest), 
        URLSERVER."json/cek-diskon-destination");
      $data_diskon_dest_array = json_decode($data_diskon_dest);
      
      $foot = "<script>"
          . "function filter(){"
            . "var out = 0;"
            . "if($('#setuju_terms').prop('checked') == false){"
              . "pesan = 'Harus Menyetujui Syarat & Ketentuan';"
              . "out = 1;"
            . "}"
            . "telp = cek_telp();"
            . "out = out + telp['out'];"
            . "if(telp['out'] > 0){"
              . "pesan = telp['pesan'];"
            . "}"
            
            . "mail = cek_mail();"
            . "out = out + mail['out'];"
            . "if(mail['out'] > 0){"
              . "pesan = mail['pesan'];"
            . "}"
        
            . "if($('#batas_bayi').val()){"
              . "last_name_bayi = cek_last_name_bayi();"
              . "out = out + last_name_bayi['out'];"
              . "if(last_name_bayi['out'] > 0){"
                . "pesan = last_name_bayi['pesan'];"
              . "}"
              . "first_name_bayi = cek_first_name_bayi();"
              . "out = out + first_name_bayi['out'];"
              . "if(first_name_bayi['out'] > 0){"
                . "pesan = first_name_bayi['pesan'];"
              . "}"
              . "umur_bayi = cek_umur_bayi();"
              . "out = out + umur_bayi['out'];"
              . "if(umur_bayi['out'] > 0){"
                . "pesan = umur_bayi['pesan'];"
              . "}"
            . "}"
            
            . "if($('#batas_anak').val()){"
              . "last_name_anak = cek_last_name_anak();"
              . "out = out + last_name_anak['out'];"
              . "if(last_name_anak['out'] > 0){"
                . "pesan = last_name_anak['pesan'];"
              . "}"
              . "first_name_anak = cek_first_name_anak();"
              . "out = out + first_name_anak['out'];"
              . "if(first_name_anak['out'] > 0){"
                . "pesan = first_name_anak['pesan'];"
              . "}"
              . "umur_anak = cek_umur_anak();"
              . "out = out + umur_anak['out'];"
              . "if(umur_anak['out'] > 0){"
                . "pesan = umur_anak['pesan'];"
              . "}"
            . "}"
        
            . "last_name = cek_last_name();"
            . "out = out + last_name['out'];"
            . "if(last_name['out'] > 0){"
              . "pesan = last_name['pesan'];"
            . "}"
        
            . "first_name = cek_first_name();"
            . "out = out + first_name['out'];"
            . "if(first_name['out'] > 0){"
              . "pesan = first_name['pesan'];"
            . "}"
        
            . "umur_adult = cek_umur_adult();"
            . "out = out + umur_adult['out'];"
            . "if(umur_adult['out'] > 0){"
              . "pesan = umur_adult['pesan'];"
            . "}"
        
            . "if(out > 0){"
              . "alert(pesan);"
              . "return false;"
            . "}"
            . "else{"
//              . "alert('berhasil');"
              . "return true;"
            . "}"
          . "}"
        
          . "function cek_telp(){"
            . "var hasil_telp = [];"
            . "if(!$('#telp').val()){"
              . "hasil_telp['pesan'] = 'Telphone Harus Diisi';"
              . "hasil_telp['out'] = 1;"
            . "}"
            . "else{"
              . "hasil_telp['pesan'] = '';"
              . "hasil_telp['out'] = 0;"
            . "}"
            . "return hasil_telp;"
          . "}"
        
          . "function isValidEmailAddress(emailAddress) {"
            . "var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;"
            . "return pattern.test(emailAddress);"
          . "}"
        
          . "function cek_mail(){"
            . "var hasil_mail = [];"
            . "if(!$('#mail').val()){"
              . "hasil_mail['pesan'] = 'Email Harus Diisi';"
              . "hasil_mail['out'] = 1;"
            . "}"
            . "else{"
              . "if(!isValidEmailAddress($('#mail').val())){"
                . "hasil_mail['pesan'] = 'Format Email Salah';"
                . "hasil_mail['out'] = 1;"
              . "}"
              . "else{"
                . "hasil_mail['pesan'] = '';"
                . "hasil_mail['out'] = 0;"
              . "}"
            . "}"
            . "return hasil_mail;"
          . "}"
        
          . "function cek_first_name(){"
            . "var akhir = $('#batas_dewasa').val() * 1;"
            . "var hasil_fn = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tfirst'+t).val()){"
                . "hasil_fn['pesan'] = 'Nama Pertama Penumpan '+t+' Harus Diisi';"
                . "hasil_fn['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_fn['out'] != 1){"
              . "hasil_fn['pesan'] = '';"
              . "hasil_fn['out'] = 0;"
            . "}"
            . "return hasil_fn;"
          . "}"
        
          . "function cek_last_name(){"
            . "var akhir = $('#batas_dewasa').val() * 1;"
            . "var hasil_ln = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tlast'+t).val()){"
                . "hasil_ln['pesan'] = 'Nama Belakang Penumpan '+t+' Harus Diisi';"
                . "hasil_ln['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_ln['out'] != 1){"
              . "hasil_ln['pesan'] = '';"
              . "hasil_ln['out'] = 0;"
            . "}"
            . "return hasil_ln;"
          . "}"
        
          . "function cek_umur_adult(){"
            . "var akhir = $('#batas_dewasa').val() * 1;"
            . "var hasil_umur_adult = [];"
            . "var bulan = [];"
            . "bulan[1] = 'January';"
            . "bulan[2] = 'February';"
            . "bulan[3] = 'March';"
            . "bulan[4] = 'April';"
            . "bulan[5] = 'May';"
            . "bulan[6] = 'June';"
            . "bulan[7] = 'July';"
            . "bulan[8] = 'August';"
            . "bulan[9] = 'September';"
            . "bulan[10] = 'October';"
            . "bulan[11] = 'November';"
            . "bulan[12] = 'December';"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "var lahir = new Date($('#lahirtgl'+t).val()+' '+bulan[$('#lahirbln'+t).val()]+' '+$('#lahirthn'+t).val());"
              . "var penerbangan = new Date($('#tglberangkat').val());"
              . "var age = Math.floor((penerbangan-lahir) / (365.25 * 24 * 60 * 60 * 1000));"
              . "if(age < 12){"
                . "hasil_umur_adult['pesan'] = 'Umur Penumpan '+t+' Harus >= 12 Tahun Pada Hari Penerbangan';"
                . "hasil_umur_adult['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_umur_adult['out'] != 1){"
              . "hasil_umur_adult['pesan'] = '';"
              . "hasil_umur_adult['out'] = 0;"
            . "}"
            . "return hasil_umur_adult;"
          . "}"
        
          . "function cek_umur_anak(){"
            . "var akhir = $('#batas_anak').val() * 1;"
            . "var hasil_umur_anak = [];"
            . "var bulan = [];"
            . "bulan[1] = 'January';"
            . "bulan[2] = 'February';"
            . "bulan[3] = 'March';"
            . "bulan[4] = 'April';"
            . "bulan[5] = 'May';"
            . "bulan[6] = 'June';"
            . "bulan[7] = 'July';"
            . "bulan[8] = 'August';"
            . "bulan[9] = 'September';"
            . "bulan[10] = 'October';"
            . "bulan[11] = 'November';"
            . "bulan[12] = 'December';"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "var lahir = new Date($('#lahirtglc'+t).val()+' '+bulan[$('#lahirblnc'+t).val()]+' '+$('#lahirthnc'+t).val());"
              . "var penerbangan = new Date($('#tglberangkat').val());"
              . "var age = Math.floor((penerbangan-lahir) / (365.25 * 24 * 60 * 60 * 1000));"
              . "if(age < 2 || age >= 12){"
                . "hasil_umur_anak['pesan'] = 'Umur Penumpan Anak '+t+' Tidak Boleh < 2 Tahun atau  => 12 Tahun Pada Hari Penerbangan';"
                . "hasil_umur_anak['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_umur_anak['out'] != 1){"
              . "hasil_umur_anak['pesan'] = '';"
              . "hasil_umur_anak['out'] = 0;"
            . "}"
            . "return hasil_umur_anak;"
          . "}"
        
          . "function cek_umur_bayi(){"
            . "var akhir = $('#batas_bayi').val() * 1;"
            . "var hasil_umur_bayi = [];"
            . "var bulan = [];"
            . "bulan[1] = 'January';"
            . "bulan[2] = 'February';"
            . "bulan[3] = 'March';"
            . "bulan[4] = 'April';"
            . "bulan[5] = 'May';"
            . "bulan[6] = 'June';"
            . "bulan[7] = 'July';"
            . "bulan[8] = 'August';"
            . "bulan[9] = 'September';"
            . "bulan[10] = 'October';"
            . "bulan[11] = 'November';"
            . "bulan[12] = 'December';"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "var lahir = new Date($('#lahirtgli'+t).val()+' '+bulan[$('#lahirblni'+t).val()]+' '+$('#lahirthni'+t).val());"
              . "var penerbangan = new Date($('#tglberangkat').val());"
              . "var age = Math.floor((penerbangan-lahir) / (30 * 24 * 60 * 60 * 1000));"
              . "if(age <= 0 || age >= 24){"
                . "hasil_umur_bayi['pesan'] = 'Umur Penumpan Bayi '+t+' Tidak Boleh >= 2 Tahun Pada Hari Penerbangan';"
                . "hasil_umur_bayi['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_umur_bayi['out'] != 1){"
              . "hasil_umur_bayi['pesan'] = '';"
              . "hasil_umur_bayi['out'] = 0;"
            . "}"
            . "return hasil_umur_bayi;"
          . "}"
        
          . "function cek_first_name_anak(){"
            . "var akhir = $('#batas_anak').val() * 1;"
            . "var hasil_fna = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tfirstc'+t).val()){"
                . "hasil_fna['pesan'] = 'Nama Pertama Penumpan Anak '+t+' Harus Diisi';"
                . "hasil_fna['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_fna['out'] != 1){"
              . "hasil_fna['pesan'] = '';"
              . "hasil_fna['out'] = 0;"
            . "}"
            . "return hasil_fna;"
          . "}"
        
          . "function cek_last_name_anak(){"
            . "var akhir = $('#batas_anak').val() * 1;"
            . "var hasil_lna = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tlastc'+t).val()){"
                . "hasil_lna['pesan'] = 'Nama Belakang Penumpan Anak '+t+' Harus Diisi';"
                . "hasil_lna['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_lna['out'] != 1){"
              . "hasil_lna['pesan'] = '';"
              . "hasil_lna['out'] = 0;"
            . "}"
            . "return hasil_lna;"
          . "}"
        
          . "function cek_first_name_bayi(){"
            . "var akhir = $('#batas_bayi').val() * 1;"
            . "var hasil_fnb = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tfirsti'+t).val()){"
                . "hasil_fnb['pesan'] = 'Nama Pertama Penumpan Bayi '+t+' Harus Diisi';"
                . "hasil_fnb['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_fnb['out'] != 1){"
              . "hasil_fnb['pesan'] = '';"
              . "hasil_fnb['out'] = 0;"
            . "}"
            . "return hasil_fnb;"
          . "}"
        
          . "function cek_last_name_bayi(){"
            . "var akhir = $('#batas_bayi').val() * 1;"
            . "var hasil_lnb = [];"
            . "for(var t = akhir ; t >= 1 ; t--){"
              . "if(!$('#tlasti'+t).val()){"
                . "hasil_lnb['pesan'] = 'Nama Belakang Penumpan Bayi '+t+' Harus Diisi';"
                . "hasil_lnb['out'] = 1;"
              . "}"
            . "}"
            . "if(hasil_lnb['out'] != 1){"
              . "hasil_lnb['pesan'] = '';"
              . "hasil_lnb['out'] = 0;"
            . "}"
            . "return hasil_lnb;"
          . "}"
        
          . "function login_ajax(){"
            . "$.post('".site_url("antavaya/login-ajax")."', {name: $('#email_ajax').val(), sandi: $('#pass_ajax').val()}, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "if(hasil.status == 'gagal'){"
                . "alert('Login gagal');"
              . "}"
              . "else{"
                . "$('#mail').val(hasil.mail);"
                . "$('#telp').val(hasil.telp);"
                . "$('#pemesan_depan').val(hasil.depan);"
                . "$('#pemesan_belakang').val(hasil.belakang);"
                . "$('#tfirst1').val(hasil.depan);"
                . "$('#tlast1').val(hasil.belakang);"
                . "$('.luar').hide();"
                . "$('.dalam').show();"
                . "$('#penumpang_login').hide();"
              . "}"
            . "});"
          . "}"
        
          . "function daftar_ajax(){"
            . "var berita = 1;"
            . "if($('#berita_daftar').prop('checked') == false){"
              . "berita = 1;"
            . "}"
            . "else{"
              . "berita = 2;"
            . "}"
            . "var nama = $('#nama_daftar').val();"
            . "var email = $('#email_daftar').val();"
            . "var pass = $('#sandi_daftar').val();"
            . "var repass = $('#ulang_sandi_daftar').val();"
            . "if(pass == repass){"
              . "$.post('".site_url("antavaya/daftar-ajax")."', {name: nama, sandi: pass, resandi: repass, email: email, berita: berita}, function(data){"
                . "var hasil = $.parseJSON(data);"
                . "if(hasil.status == 'gagal'){"
                  . "alert('Pendaftaran gagal');"
                . "}"
                . "else{"
                  . "$('#mail').val(hasil.mail);"
                  . "$('#telp').val(hasil.telp);"
                  . "$('#pemesan_depan').val(hasil.depan);"
                  . "$('#pemesan_belakang').val(hasil.belakang);"
                  . "$('#tfirst1').val(hasil.depan);"
                  . "$('#tlast1').val(hasil.belakang);"
                  . "$('.luar').hide();"
                  . "$('.dalam').show();"
                  . "$('#penumpang_login').hide();"
                . "}"
              . "});"
            . "}"
            . "else{"
              . "alert('Password & Ulangi Password Tidak Sama');"
            . "}"
          . "}"
        
          . "$('#pass_ajax').bind('enterKey',function(e){"
            . "login_ajax();"
          . "});"
          . "$('#pass_ajax').keyup(function(e){"
            . "if(e.keyCode == 13){"
              . "$(this).trigger('enterKey');"
            . "}"
          . "});"

          . "function set_nama(){"
            . "var depan = $('#pemesan_depan').val();"
            . "var belakang = $('#pemesan_belakang').val();"
            . "$('#tfirst1').val(depan);"
            . "$('#tlast1').val(belakang);"
          . "}"
        
          . "function set_bawah(){"
            . "var depan = $('#tfirst1').val();"
            . "var belakang = $('#tlast1').val();"
            . "$('#pemesan_depan').val(depan);"
            . "$('#pemesan_belakang').val(belakang);"
          . "}"
        
          . "$(function(){"
          . "});"
        . "</script>";
      $items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $id_website_flight_temp));
      $items2 = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $id_website_flight_temp2));
  //    $this->debug($flight, true);
      if($this->mobile_detect->isMobile()){
        $id_website_flight_temp = $this->encrypt->decode($pst['flight']);
        
        $flight = $this->global_models->get_query("SELECT A.*, B.code, B.note AS class"
          . " FROM website_flight_temp AS A"
          . " LEFT JOIN website_class_code AS B ON B.id_website_class_code = A.id_website_class_code"
          . " WHERE A.id_website_flight_temp = '{$id_website_flight_temp}'");
          
          $id_website_flight_temp = $this->encrypt->decode($pst['flight2']);
          $flight2 = $this->global_models->get_query("SELECT A.*, B.code, B.note AS class"
          . " FROM website_flight_temp AS A"
          . " LEFT JOIN website_class_code AS B ON B.id_website_class_code = A.id_website_class_code"
          . " WHERE A.id_website_flight_temp = '{$id_website_flight_temp}'");
//        $this->debug($flight, true);
        $this->template->build("mobile/book", 
          array(
            'url'         => base_url()."themes/mobile-antavaya/",
            'theme2nd'    => 'mobile-antavaya',
              'foot2'       => $foot,
            'id_website_flight_temp' => $pst['flight'],
            'id_website_flight_temp2' => $pst['flight2'],
            'flight'      => $flight,
            'items'       => $items,
            'flight2'     => $flight2,
            'items2'      => $items2,
            'pp'          => $pst['pp'],
            'data_diskon_array' => $data_diskon_array,
          ));
        $this->template
          ->set_layout('default')
          ->build("mobile/book");
      }
      else{
        $this->template->build("book", 
          array(
            'url'         => base_url()."themes/antavaya/",
            'theme2nd'    => 'antavaya',
            'foot2'       => $foot,
            'id_website_flight_temp' => $id_website_flight_temp_encode,
            'id_website_flight_temp2' => $id_website_flight_temp_encode2,
            'flight'      => $flight,
            'items'       => $items,
            'flight2'     => $flight2,
            'items2'      => $items2,
            'pp'          => $pst['pp'],
            'data_diskon_array' => $data_diskon_array,
            'data_diskon_dest_array' => $data_diskon_dest_array,
          ));
        $this->template
          ->set_layout('default')
          ->build("book");
      }
    }
    else{
      redirect();
    }
  }
  
  function proses(){
    $foot = "<script>"
        . "function batch_data(ke){"
//          . "$.post('".site_url("antavaya/batch-proses-booking-self")."', {ke: ke,"
          . "$.post('".site_url("antavaya/batch-proses-booking")."', {ke: ke,"
                      . " id_website_flight_temp: '{$pst['id_website_flight_temp']}',"
                      . " dtitle: '{$pst['dtitle']}',"
                      . " tfirst: '{$pst['tfirst']}',"
                      . " tlast: '{$pst['tlast']}',"
                      . " tanggal: '{$pst['tanggal']}',"
                      . " thp2: '{$pst['thp2']}',"
                      . " tmail: '{$pst['tmail']}'}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "console.log(hasil.note);"
            . "if(hasil.note == 'gagal'){"
              . "window.location = '".site_url("antavaya/book-fail")."'"
            . "}"
            . "if(hasil.persen <= 100){"
              . "$('#info_proses').text(hasil.proses);"
              . "$('#info_persen').text(hasil.persen);"
              . "$('#catatan').text(hasil.catatan);"
              . "$('#bar_proses').width(hasil.persen+'%');"
              . "batch_data(hasil.proses);"
            . "}"
            . "else{"
              . "window.location = '".site_url("antavaya/thank-you")."'"
            . "}"
          . "});"
        . "}"
        . "batch_data(1);"
      . "</script>";
//    $this->template->build("proses-self", 
    $this->template->build("proses", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => $foot,
      ));
    $this->template
      ->set_layout('default')
      ->build("proses");
//      ->build("proses-self");
  }
  
  function batch_proses_booking($ke = 1){
    $pst = $this->input->post();
	/*$pst = array( 
		"ke"	=> 1,
		"id_website_flight_temp" => "TLa+3+YZkyPSh4qm2Uh5O8/xySPhZDDfX3yRYbOhTf/GNxq2EwEW1/QaY9602Q33VPUjF6KpnLUd0QPDjBXmkw==",
		"dtitle" => "Mr",
		"tfirst" => "Nugroho",
		"tlast" => "Santoso",
		"tanggal" => "16 December 1987",
		"thp2" => "08991811123",
		"tmail" => "nugroho.budi@antavaya.com"
	);*/
    $ke = $pst["ke"];
    
    $link1st = $this->session->userdata("link1st");
    $link2nd = "http://tiket.antavaya.com/index.php?option=com_jadwal&view=jadwal&layout=hsl&Itemid=8&act=step2";
    $link3rd = "http://tiket.antavaya.com/components/com_jadwal/views/jadwal/tmpl/waiting.php?act=Please";
    $link4th = "http://tiket.antavaya.com/index.php?option=com_jadwal&view=jadwal&layout=hsl&Itemid=8&act=step3&cek=0";
    
    if($ke == 1){
      $data = $this->curl_mentah(array(), "http://tiket.antavaya.com/widgets.php");
      $dt_temp = explode('tnow"', $data);
      $dt_temp = explode('"', $dt_temp[2]);
      $link1st = "http://tiket.antavaya.com/index.php?option=com_jadwal&view=jadwal&layout=hsl&itemid=8&c={$dt_temp[1]}&err=&agen=";
      $this->cookie_jar = tempnam('/tmp','cookie');
      $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar, "link1st" => $link1st));
      $this->bookstep1_set_cookie($link1st);
      $note = $this->cookie_jar;
      $catatan = "Kirim Data Booking";
    }
    
    if($ke == 2){
      $dtitle = unserialize($pst['dtitle']);
      $id_website_flight_temp = $this->encrypt->decode($pst['id_website_flight_temp']);
      $id_tiket_flight = $this->temp_to_book($id_website_flight_temp);
//      $child_sign = $harga_child = $diskon_child = 0;
//      $infant_sign = 0;
//      $diskon_adult = $this->global_models->diskon($website_flight_temp[0]->maskapai, (count($dtitle) * $kirim_flight['price']));
//      if($this->session->userdata("flight_chd")){
//        $child_sign = $this->session->userdata("flight_chd");
//        $harga_child = $child_sign * $kirim_flight['child'];
//        $diskon_child = $this->global_models->diskon($website_flight_temp[0]->maskapai, $harga_child);
//      }
//      if($this->session->userdata("flight_inf"))
//        $infant_sign = $this->session->userdata("flight_inf");
      
      $kirim_book = array(
        'rhrg'		=> $this->format_rhrg($dtitle, $id_website_flight_temp),
//        'rhrg'		=> "{$send_flight_code}/{$send_dari}/{$send_ke}/{$send_dept}/{$send_arrive}/".(count($dtitle)*$kirim_flight["price"])."/"
//          . date("d F Y", strtotime($kirim_flight["departure"]))."/".count($dtitle)."/{$send_class}/{$website_flight_temp[0]->maskapai}/"
//          . ($infant_sign*$kirim_flight['infant'])."/{$infant_sign}/{$child_sign}/{$harga_child}/"
//          . ($diskon_adult+$diskon_child)."/{$diskon_adult}/{$diskon_child}",
        'next'		=> 'Book'
      );
      if($pst['pp'] == 2){
        $id_website_flight_temp2 = $this->encrypt->decode($pst['id_website_flight_temp2']);
        $id_tiket_flight2 = $this->temp_to_book($id_website_flight_temp2);
        $this->session->set_userdata(array("id_tiket_flight2" => $id_tiket_flight2));
        $kirim_book['rhrg2'] = $this->format_rhrg($dtitle, $id_website_flight_temp2);
      }
      $this->cookie_jar = $this->session->userdata("cookie_jar");
      $this->session->set_userdata(array("id_tiket_flight" => $id_tiket_flight));
      $this->bookstep2_send_book($link1st, $kirim_book);
      $note = json_encode($kirim_book);
      $catatan = "Kirim Data Booking";
    }
    
    if($ke == 3){
      $this->cookie_jar = $this->session->userdata("cookie_jar");
      $this->bookstep3_set_session($link2nd);
      $note = $this->cookie_jar;
      $catatan = "Kirim Data Booking";
    }
    
    if($ke == 4){
      $dtitle = unserialize($pst['dtitle']);
      $tfirst = unserialize($pst['tfirst']);
      $tlast = unserialize($pst['tlast']);
      $tgl = unserialize($pst['dtgl']);
      $bln = unserialize($pst['dbln']);
      $thn = unserialize($pst['dthn']);
      foreach($dtitle AS $k => $title){
        $f = "";
        if($k > 1){
          $f = $k;
        }
        $kirim_passenger["dtitle{$f}"] = $title;
        $kirim_passenger["tfirst{$f}"] = trim($tfirst[$k]);
        $kirim_passenger["tlast{$f}"] = trim($tlast[$k]);
        $kirim_passenger["dtgl{$f}"] = $tgl[$k];
        $kirim_passenger["dbln{$f}"] = $bln[$k];
        $kirim_passenger["dthn{$f}"] = $thn[$k];
        $kirim_passenger["ffp{$f}"] = "";
      }
      
      if($pst['dtitlec']){
        $dtitlec = unserialize($pst['dtitlec']);
        $tfirstc = unserialize($pst['tfirstc']);
        $tlastc = unserialize($pst['tlastc']);
        $tglc = unserialize($pst['dtglc']);
        $blnc = unserialize($pst['dblnc']);
        $thnc = unserialize($pst['dthnc']);
        $c_ext = 1;
        foreach($dtitlec AS $c => $titlec){
          $kirim_passenger["dtitlec{$c_ext}"] = $titlec;
          $kirim_passenger["tfirstc{$c_ext}"] = trim($tfirstc[$c]);
          $kirim_passenger["tlastc{$c_ext}"] = trim($tlastc[$c]);
          $kirim_passenger["dtglc{$c_ext}"] = $tglc[$c];
          $kirim_passenger["dblnc{$c_ext}"] = $blnc[$c];
          $kirim_passenger["dthnc{$c_ext}"] = $thnc[$c];
          $kirim_passenger["ffpc{$c_ext}"] = "";
          $c_ext++;
        }
      }
      
      if($pst['dtitlei']){
        $dtitlei = unserialize($pst['dtitlei']);
        $tfirsti = unserialize($pst['tfirsti']);
        $tlasti = unserialize($pst['tlasti']);
        $tgli = unserialize($pst['dtgli']);
        $blni = unserialize($pst['dblni']);
        $thni = unserialize($pst['dthni']);
        $dpax = unserialize($pst['dpax']);
        $i_ext = 1;
        foreach($dtitlei AS $i => $titlei){
          $kirim_passenger["dtitlei{$i_ext}"] = $titlei;
          $kirim_passenger["tfirsti{$i_ext}"] = trim($tfirsti[$i]);
          $kirim_passenger["tlasti{$i_ext}"] = trim($tlasti[$i]);
          $kirim_passenger["dtgli{$i_ext}"] = $tgli[$i];
          $kirim_passenger["dblni{$i_ext}"] = $blni[$i];
          $kirim_passenger["dthni{$i_ext}"] = $thni[$i];
          $kirim_passenger["dpax{$i_ext}"] = $dpax[$i];
          $i_ext++;
        }
      }
      
      $kirim_passenger["thp2"] = $pst['thp2'];
      $kirim_passenger["tmail"] = $pst['tmail'];
      $kirim_passenger["submit"] = "Book";
      $kirim_passenger["checkbox1"] = "on";
      $kirim_passenger["tadl"] = count($dtitle);
      
      $this->cookie_jar = $this->session->userdata("cookie_jar");
      $this->bookstep4_confirm_book($link2nd, $kirim_passenger);
      $note = json_encode($kirim_passenger);
      $catatan = "Kirim Data Penumpang";
    }
    
    if($ke == 5){
      $this->cookie_jar = $this->session->userdata("cookie_jar");
      $this->bookstep5_wait($link2nd, $link3rd);
      $note = $this->cookie_jar;
      $catatan = "Menghubungi dan Kalkulasi Ulang pada Maskapai";
    }
    
    if($ke == 6){
      $this->cookie_jar = $this->session->userdata("cookie_jar");
      $hasil = $this->bookstep6_final($link3rd, $link4th);
      
      $book_code = $this->olah_book_and_time($hasil);
      $note = json_encode($book_code);
      if($book_code['book']){
        
        $dtitle = unserialize($pst['dtitle']);
        $tfirst = unserialize($pst['tfirst']);
        $tlast = unserialize($pst['tlast']);
        $tgl = unserialize($pst['dtgl']);
        $bln = unserialize($pst['dbln']);
        $thn = unserialize($pst['dthn']);
        
        $kirim_tiket_book = array(
          "id_tiket_flight"     => $this->session->userdata("id_tiket_flight"),
          "id_tiket_flight2nd"  => $this->session->userdata("id_tiket_flight2"),
          "id_users"            => $this->session->userdata("id"),
          "book_code"           => $book_code['book'],
          "book2nd"             => $book_code['book2nd'],
          "tanggal"             => date("Y-m-d H:i:s"),
          "status"              => 1,
          "telphone"            => $pst['thp2'],
          "email"               => $pst['tmail'],
          "first_name"          => $pst['depan'],
          "last_name"           => $pst['belakang'],
          "timelimit"           => $book_code['limit'],
          "price"               => $book_code['price'],
          "child"               => $book_code['price2nd'],
          "infant"              => $book_code['diskon'],
          "create_by_users"     => $this->session->userdata("id"),
          "create_date"         => date("Y-m-d H:i:s"),
        );
        $this->session->set_userdata(array("id_tiket_flight" => ""));
        $id_tiket_book = $this->global_models->insert("tiket_book", $kirim_tiket_book);
        
        if($this->session->userdata("id_tiket_flight2")){
//          $kirim_tiket_book['id_tiket_flight'] = $this->session->userdata("id_tiket_flight2");
          $this->session->set_userdata(array("id_tiket_flight2" => ""));
//          $id_tiket_book2 = $this->global_models->insert("tiket_book", $kirim_tiket_book);
        }
        
        foreach($dtitle AS $t => $save_title){
          $kirim_passenger = array(
            "first_name"          => $tfirst[$t],
            "id_users"            => $this->session->userdata("id"),
            "last_name"           => $tlast[$t],
            "telphone"            => $pst['thp2'],
            "email"               => $pst['tmail'],
            "title"               => $save_title,
            "type"                => 1,
            "tanggal_lahir"       => "{$thn[$t]}-{$bln[$t]}-{$tgl[$t]}",
            "create_by_users"     => $this->session->userdata("id"),
            "create_date"         => date("Y-m-d H:i:s"),
          );
          $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_passenger);

          $kirim_bridge = array(
            "id_tiket_passenger"      => $id_tiket_passenger,
            "id_tiket_book"           => $id_tiket_book
          );
          $id_tiket_book_passenger = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
          if($id_tiket_book2){
            $kirim_bridge['id_tiket_book'] = $id_tiket_book2;
            $id_tiket_book_passenger2 = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
          }
        }
        
        if($pst['dtitlec']){
          $dtitlec = unserialize($pst['dtitlec']);
          $tfirstc = unserialize($pst['tfirstc']);
          $tlastc = unserialize($pst['tlastc']);
          $tglc = unserialize($pst['dtglc']);
          $blnc = unserialize($pst['dblnc']);
          $thnc = unserialize($pst['dthnc']);
          foreach($dtitlec AS $c => $titlec){
            $kirim_passenger = array(
              "first_name"          => $tfirstc[$c],
              "id_users"            => $this->session->userdata("id"),
              "last_name"           => $tlastc[$c],
              "telphone"            => $pst['thp2'],
              "email"               => $pst['tmail'],
              "title"               => $titlec,
              "type"                => 2,
              "tanggal_lahir"       => "{$thnc[$c]}-{$blnc[$c]}-{$tglc[$c]}",
              "create_by_users"     => $this->session->userdata("id"),
              "create_date"         => date("Y-m-d H:i:s"),
            );
            $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_passenger);

            $kirim_bridge = array(
              "id_tiket_passenger"      => $id_tiket_passenger,
              "id_tiket_book"           => $id_tiket_book
            );
            $id_tiket_book_passenger = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
            if($id_tiket_book2){
              $kirim_bridge['id_tiket_book'] = $id_tiket_book2;
              $id_tiket_book_passenger2 = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
            }
          }
        }
        
        if($pst['dtitlei']){
          $dtitlei = unserialize($pst['dtitlei']);
          $tfirsti = unserialize($pst['tfirsti']);
          $tlasti = unserialize($pst['tlasti']);
          $tgli = unserialize($pst['dtgli']);
          $blni = unserialize($pst['dblni']);
          $thni = unserialize($pst['dthni']);
          $dpax = unserialize($pst['dpax']);
          foreach($dtitlei AS $i => $titlei){
            $kirim_passenger = array(
              "first_name"          => $tfirsti[$i],
              "id_users"            => $this->session->userdata("id"),
              "last_name"           => $tlasti[$i],
              "telphone"            => $pst['thp2'],
              "email"               => $pst['tmail'],
              "title"               => $titlei,
              "type"                => 3,
              "pax"                 => $dpax[$i],
              "tanggal_lahir"       => "{$thni[$i]}-{$blni[$i]}-{$tgli[$i]}",
              "create_by_users"     => $this->session->userdata("id"),
              "create_date"         => date("Y-m-d H:i:s"),
            );
            $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_passenger);

            $kirim_bridge = array(
              "id_tiket_passenger"      => $id_tiket_passenger,
              "id_tiket_book"           => $id_tiket_book
            );
            $id_tiket_book_passenger = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
            if($id_tiket_book2){
              $kirim_bridge['id_tiket_book'] = $id_tiket_book2;
              $id_tiket_book_passenger2 = $this->global_models->insert("tiket_book_passenger", $kirim_bridge);
            }
          }
        }
        
        $this->session->set_userdata(array("id_tiket_book_passenger" => $id_tiket_book, "id_tiket_book_passenger2" => $id_tiket_book2));
      }
      else{
        $note = "gagal";
      }
      $catatan = "Mengambil Book Code";
    }
    
//    $note = $ke;
    $ke++;
    $persen = ceil($ke/7 * 100);
    $hasil = array(
      "proses"      => $ke,
      "note"        => $note,
      "persen"      => $persen,
      "catatan"     => $catatan,
    );
    print json_encode($hasil);
	die;
  }
  
  function book_code(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    if($pst){
      foreach ($pst['dtitle'] AS $k => $title_adult){
        $adult[] = array(
            'title'       => $title_adult,
            'first_name'	=> $pst['tfirst'][$k],
            'last_name'		=> $pst['tlast'][$k],
            'tanggal'     => $pst['dtgl'][$k],
            'bulan'       => $pst['dbln'][$k],
            'tahun'       => $pst['dthn'][$k],
          );
      }
//      $this->debug(json_encode($adult));
//      $this->debug(json_decode('[{"title":"Mr","first_name":"Nugroho","last_name":"Budhi","tanggal":"1","bulan":"1","tahun":"1935"}]'));
      
      $child = array();
      if($pst['dtitlec']){
        foreach ($pst['dtitlec'] AS $k => $title_child){
          $child[] = array(
              'title'       => $title_child,
              'first_name'	=> $pst['tfirstc'][$k],
              'last_name'		=> $pst['tlastc'][$k],
              'tanggal'     => $pst['dtglc'][$k],
              'bulan'       => $pst['dblnc'][$k],
              'tahun'       => $pst['dthnc'][$k],
            );
        }
      }
      
      $infant = array();
      if($pst['dtitlei']){
        foreach ($pst['dtitlei'] AS $k => $title_infant){
          $infant[] = array(
              'title'       => $title_infant,
              'first_name'	=> $pst['tfirsti'][$k],
              'last_name'		=> $pst['tlasti'][$k],
              'tanggal'     => $pst['dtgli'][$k],
              'bulan'       => $pst['dblni'][$k],
              'tahun'       => $pst['dthni'][$k],
              'pax'         => $pst['dpax'][$k]
            );
        }
      }
      
      $foot = "<script>"
          . "function batch_data(ke){"
            . "$.post('".site_url("antavaya/batch-proses-booking-self")."', {ke: ke,"
                        . " id_website_flight_temp: '{$pst['id_website_flight_temp']}',"
                        . " id_website_flight_temp2: '{$pst['id_website_flight_temp2']}',"
                        . " adult: '".json_encode($adult)."',"
                        . " child: '".json_encode($child)."',"
                        . " infant: '".json_encode($infant)."',"
                        . " pp: '{$pst['pp']}',"
                        . " thp2: '{$pst['thp2']}',"
                        . " depan: '{$pst['depan']}',"
                        . " belakang: '{$pst['belakang']}',"
                        . " tmail: '{$pst['tmail']}'}, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "console.log(hasil.note);"
              . "if(hasil.note == 'gagal'){"
                . "window.location = '".site_url("antavaya/book-fail")."'"
              . "}"
              . "else if(hasil.persen <= 100){"
                . "$('#info_proses').text(hasil.proses);"
                . "$('#info_persen').text(hasil.persen);"
                . "$('#catatan').text(hasil.catatan);"
                . "$('#bar_proses').width(hasil.persen+'%');"
                . "batch_data(hasil.proses);"
              . "}"
              . "else{"
                . "window.location = '".site_url("antavaya/thank-you")."'"
              . "}"
            . "});"
          . "}"
          . "batch_data(1);"
        . "</script>";

//      $child = "";
//      if($pst['dtitlec']){
//        $child = "dtitlec: '".serialize($pst['dtitlec'])."',"
//          . "tfirstc: '".serialize($pst['tfirstc'])."',"
//          . "tlastc: '".serialize($pst['tlastc'])."',"
//          . "dtglc: '".serialize($pst['dtglc'])."',"
//          . "dblnc: '".serialize($pst['dblnc'])."',"
//          . "dthnc: '".serialize($pst['dthnc'])."',";
//      }
//      
//      $infant = "";
//      if($pst['dtitlei']){
//        $infant = "dtitlei: '".serialize($pst['dtitlei'])."',"
//          . "tfirsti: '".serialize($pst['tfirsti'])."',"
//          . "tlasti: '".serialize($pst['tlasti'])."',"
//          . "dtgli: '".serialize($pst['dtgli'])."',"
//          . "dblni: '".serialize($pst['dblni'])."',"
//          . "dthni: '".serialize($pst['dthni'])."',"
//          . "dpax: '".serialize($pst['dpax'])."',";
//      }
//      
//      $foot = "<script>"
//          . "function batch_data(ke){"
//            . "$.post('".site_url("antavaya/batch-proses-booking-self")."', {ke: ke,"
////            . "$.post('".site_url("antavaya/batch-proses-booking")."', {ke: ke,"
//                        . " id_website_flight_temp: '{$pst['id_website_flight_temp']}',"
//                        . " id_website_flight_temp2: '{$pst['id_website_flight_temp2']}',"
//                        . " dtitle: '".serialize($pst['dtitle'])."',"
//                        . " tfirst: '".serialize($pst['tfirst'])."',"
//                        . " tlast: '".serialize($pst['tlast'])."',"
//                        . " dtgl: '".serialize($pst['dtgl'])."',"
//                        . " dbln: '".serialize($pst['dbln'])."',"
//                        . " dthn: '".serialize($pst['dthn'])."',"
//                        . " pp: '{$pst['pp']}',"
//                        . $child
//                        . $infant
//                        . " thp2: '{$pst['thp2']}',"
//                        . " depan: '{$pst['depan']}',"
//                        . " belakang: '{$pst['belakang']}',"
//                        . " tmail: '{$pst['tmail']}'}, function(data){"
//              . "var hasil = $.parseJSON(data);"
//              . "console.log(hasil.note);"
//              . "if(hasil.note == 'gagal'){"
////                . "window.location = '".site_url("antavaya/book-fail")."'"
//              . "}"
//              . "else if(hasil.persen <= 100){"
//                . "$('#info_proses').text(hasil.proses);"
//                . "$('#info_persen').text(hasil.persen);"
//                . "$('#catatan').text(hasil.catatan);"
//                . "$('#bar_proses').width(hasil.persen+'%');"
//                . "batch_data(hasil.proses);"
//              . "}"
//              . "else{"
////                . "window.location = '".site_url("antavaya/thank-you")."'"
//              . "}"
//            . "});"
//          . "}"
//          . "batch_data(1);"
//        . "</script>";
      $this->template->build("proses-self", 
        array(
          'url'         => base_url()."themes/antavaya/",
          'theme2nd'    => 'antavaya',
          'foot2'       => $foot,
        ));
      $this->template
        ->set_layout('default')
        ->build("proses-self");
      
    }
    else{
      redirect();
    }
  }
  
  function mobilebookcode(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    if($pst){
      $child = "";
      if($pst['dtitlec']){
        $child = "dtitlec: '".serialize($pst['dtitlec'])."',"
          . "tfirstc: '".serialize($pst['tfirstc'])."',"
          . "tlastc: '".serialize($pst['tlastc'])."',"
          . "dtglc: '".serialize($pst['dtglc'])."',"
          . "dblnc: '".serialize($pst['dblnc'])."',"
          . "dthnc: '".serialize($pst['dthnc'])."',";
      }
      
      $infant = "";
      if($pst['dtitlei']){
        $infant = "dtitlei: '".serialize($pst['dtitlei'])."',"
          . "tfirsti: '".serialize($pst['tfirsti'])."',"
          . "tlasti: '".serialize($pst['tlasti'])."',"
          . "dtgli: '".serialize($pst['dtgli'])."',"
          . "dblni: '".serialize($pst['dblni'])."',"
          . "dthni: '".serialize($pst['dthni'])."',"
          . "dpax: '".serialize($pst['dpax'])."',";
      }
      
      $foot = "<script>"
          . "function batch_data(ke){"
            . "$.post('".site_url("antavaya/batch-proses-booking")."', {ke: ke,"
                        . " id_website_flight_temp: '{$pst['id_website_flight_temp']}',"
                        . " id_website_flight_temp2: '{$pst['id_website_flight_temp2']}',"
                        . " dtitle: '".serialize($pst['dtitle'])."',"
                        . " tfirst: '".serialize($pst['tfirst'])."',"
                        . " tlast: '".serialize($pst['tlast'])."',"
                        . " dtgl: '".serialize($pst['dtgl'])."',"
                        . " dbln: '".serialize($pst['dbln'])."',"
                        . " dthn: '".serialize($pst['dthn'])."',"
                        . " pp: '{$pst['pp']}',"
                        . $child
                        . $infant
                        . " thp2: '{$pst['thp2']}',"
                        . " depan: '{$pst['depan']}',"
                        . " belakang: '{$pst['belakang']}',"
                        . " tmail: '{$pst['tmail']}'}, function(data){"
              . "var hasil = $.parseJSON(data);"
              . "console.log(hasil.note);"
              . "if(hasil.note == 'gagal'){"
                . "window.location = '".site_url("antavaya/book-fail")."'"
              . "}"
              . "else if(hasil.persen <= 100){"
                . "$('#info_proses').text(hasil.proses);"
                . "$('#info_persen').text(hasil.persen);"
                . "$('#catatan').text(hasil.catatan);"
                . "$('#bar_proses').width(hasil.persen+'%');"
                . "batch_data(hasil.proses);"
              . "}"
              . "else{"
                . "window.location = '".site_url("antavaya/thank-you")."'"
              . "}"
            . "});"
          . "}"
          . "batch_data(1);"
        . "</script>";
      $this->template->build("proses-self", 
        array(
          'url'         => base_url()."themes/antavaya/",
          'theme2nd'    => 'antavaya',
          'foot2'       => $foot,
        ));
      $this->template
        ->set_layout('default')
        ->build("proses-self");
      
    }
    else{
      redirect();
    }
  }
  
  function bookstep1_set_cookie($link1st){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link1st);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_jar);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar));
    return $hasil_1;
  }
 
  function bookstep2_send_book($link1st, $kirim){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link1st);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_REFERER, $link1st);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_jar);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $kirim);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar));
    return $hasil_1;
  }
  
  function bookstep3_set_session($link2nd){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link2nd);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_REFERER, $link2nd);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_jar);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar));
    return $hasil_1;
  }
  
  function bookstep4_confirm_book($link2nd, $kirim){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link2nd);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_REFERER, $link2nd);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_jar);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $kirim);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar));
    return $hasil_1;
  }
  
  function bookstep5_wait($link2nd, $link3rd){
    curl_setopt($ch, CURLOPT_URL, $link3rd);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_REFERER, $link2nd);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_jar);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    $this->session->set_userdata(array("cookie_jar" => $this->cookie_jar));
    return $hasil_1;
  }
 
  function bookstep6_final($link3rd, $link4th){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link4th);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true); 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); 
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_REFERER, $link3rd);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_jar);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function olah_book_and_time($hasil){
    $hasil1 = explode("Booking Code", $hasil);
    $cari_book = explode("B>", $hasil1[1]);
    $fix_book = explode("<", $cari_book[1]);
    if($hasil1[2]){
      $cari_book2nd = explode("B>", $hasil1[2]);
      $fix_book2nd  = explode("<", $cari_book2nd[1]);
    }
    
    $time = explode("Time Limit", $hasil1[1]);
    $time1 = explode(":", $time[1]);
    $fix_time = trim($time1[1]).":".$time1[2].":00";
    
    $price1 = explode("Price", $hasil1[1]);
    $price2 = explode("IDR", $price1[1]);
    $price = explode(":", $price2[0]);
    if($price1[2]){
//      $price2nd1 = explode("Price", $hasil1[2]);
      $pricert = explode("IDR", $price1[2]);
      $price2nd = explode(":", $pricert[0]);
    }
    
    $diskon1 = explode("Discount", $hasil1[1]);
    $diskon2 = explode("IDR", $diskon1[1]);
    $diskon = explode(":", $diskon2[0]);
    
    return array(
      "book"    => $fix_book[0],
      "book2nd" => $fix_book2nd[0],
      "limit"   => $fix_time,
      "price"   => trim(str_replace(",", "", $price[1])),
      "price2nd"=> trim(str_replace(",", "", $price2nd[1])),
      "diskon"  => trim(str_replace(",", "", $diskon[1])),
    );
  }
  
  function thank_you($book_code = ""){
    if($book_code)
      $book_code = $book_code;
    else
      $book_code = $this->session->userdata("id_tiket_book_passenger");
    
    //$ft = $this->curl_mentah(array(), URLSERVER."json/flight-umum/status-tiket-single/{$book_code}");
    
    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      'book_code'         => $book_code
    );
    $tiket_book_json = $this->curl_mentah($kirim, URLSERVER."json/get-detail-tiket-book");
    $tiket_book = json_decode($tiket_book_json);
    
    $this->session->set_userdata(array(
      "proses_pembayaran_book_code"       => $tiket_book->flight[0]->book_code,
      "proses_pembayaran_harga_bayar"     => $tiket_book->book->harga_bayar,
      "proses_pembayaran_diskon"          => $tiket_book->book->diskon,
      "proses_pembayaran_timelimit"       => $tiket_book->book->timelimit,
    ));
//    $this->debug($tiket_book, true);
    if($this->mobile_detect->isMobile()){
      $this->template->build("mobile/thank-you", 
        array(
          'url'         => base_url()."themes/mobile-antavaya/",
          'theme2nd'    => 'mobile-antavaya',
          'tiket_book'  => $tiket_book,
        ));
      $this->template
        ->set_layout('default')
        ->build("mobile/thank-you");
    }
    else{
      $this->template->build("thank-you", 
        array(
          'url'           => base_url()."themes/antavaya/",
          'theme2nd'      => 'antavaya',
          'tiket_book'    => $tiket_book,
        ));
      $this->template
        ->set_layout('default')
        ->build("thank-you");
    }
  }
  
  function book_fail(){
    $this->template->build("book-fail", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
      ));
    $this->template
      ->set_layout('default')
      ->build("book-fail");
  }
  
  function format_rhrg($dtitle, $id_website_flight_temp){
    
    $website_flight_temp = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $id_website_flight_temp));
    $website_flight_temp_items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $id_website_flight_temp));
    
    $send_flight_code = $send_dari = $send_ke = $send_dept = $send_arrive = $send_class = $send_maskapai = "";
    foreach($website_flight_temp_items AS $kj => $wfti){
      
      if($kj > 0){
        $send_flight_code   .= "<BR><BR>";
        $send_dari          .= "<BR><BR>";
        $send_ke            .= "<BR><BR>";
        $send_dept          .= "<BR><BR>";
        $send_arrive        .= "<BR><BR>";
        $send_class         .= "<BR><BR>";
      }
      $send_flight_code   .= $wfti->flight_no;
      $send_dari          .= $this->global_models->array_kota($wfti->dari);
      $send_ke            .= $this->global_models->array_kota($wfti->ke);
      $send_dept          .= date("Hi", strtotime($wfti->take_off));
      $send_arrive        .= date("Hi", strtotime($wfti->landing));
      $send_class         .= substr($wfti->id_website_class_code, -1);
    }
    
    $child_sign = $harga_child = $diskon_child = $infant_sign = 0;
    $diskon_adult = $this->global_models->diskon($website_flight_temp[0]->maskapai, (count($dtitle) * $website_flight_temp[0]->price));
    if($this->session->userdata("flight_chd")){
      $child_sign = $this->session->userdata("flight_chd");
      $harga_child = $child_sign * $website_flight_temp[0]->child;
      $diskon_child = $this->global_models->diskon($website_flight_temp[0]->maskapai, $harga_child);
    }
    if($this->session->userdata("flight_inf"))
      $infant_sign = $this->session->userdata("flight_inf");
    
    $hasil = "{$send_flight_code}/{$send_dari}/{$send_ke}/{$send_dept}/{$send_arrive}/".(count($dtitle)*$website_flight_temp[0]->price)."/"
      . date("d F Y", strtotime($website_flight_temp[0]->take_off))."/".count($dtitle)."/{$send_class}/{$website_flight_temp[0]->maskapai}/"
      . ($infant_sign*$website_flight_temp[0]->infant)."/{$infant_sign}/{$child_sign}/{$harga_child}/"
      . ($diskon_adult+$diskon_child)."/{$diskon_adult}/{$diskon_child}";
    return $hasil;
  }
  
  function temp_to_book($id_website_flight_temp){
    $website_flight_temp = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $id_website_flight_temp));
    $website_flight_temp_items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $id_website_flight_temp));
    $kirim_flight = array(
      "dari"            => $website_flight_temp[0]->dari,
      "ke"              => $website_flight_temp[0]->ke,
      "stop"            => $website_flight_temp[0]->stop,
      "departure"       => $website_flight_temp[0]->take_off,
      "arrive"          => $website_flight_temp[0]->landing,
      "price"           => $website_flight_temp[0]->price,
      "child"           => $website_flight_temp[0]->child,
      "infant"          => $website_flight_temp[0]->infant,
      "diskon"          => $website_flight_temp[0]->hemat,
      "jual"            => $website_flight_temp[0]->jual,
      "maskapai"        => $website_flight_temp[0]->maskapai,
      "img"             => $website_flight_temp[0]->img,
      "tanggal"         => date("Y-m-d H:i:s"),
      "create_by_users" => $this->session->userdata("id"),
      "create_date"     => date("Y-m-d H:i:s"),
    );
    $id_tiket_flight = $this->global_models->insert("tiket_flight", $kirim_flight);
    
    $send_flight_code = $send_dari = $send_ke = $send_dept = $send_arrive = $send_class = $send_maskapai = "";
    foreach($website_flight_temp_items AS $kj => $wfti){
      $kirim_flight_items[] = array(
        "id_tiket_flight"       => $id_tiket_flight,
        "id_website_class_code" => $wfti->id_website_class_code,
        "flight_no"             => $wfti->flight_no,
        "dari"                  => $wfti->dari,
        "ke"                    => $wfti->ke,
        "departure"             => $wfti->take_off,
        "arrive"                => $wfti->landing,
        "create_by_users"       => $this->session->userdata("id"),
        "create_date"           => date("Y-m-d H:i:s"),
      );
    }
    $this->global_models->insert_batch("tiket_flight_items", $kirim_flight_items);
    return $id_tiket_flight;
  }
  
  function login(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    
    $users = $this->global_models->get("m_users", array("email" => $pst['email']));
    if($users){
      $if = $this->encrypt->decode($users[0]->pass);
      $priv = $this->global_models->get("d_user_privilege", array("id_users" => $users[0]->id_users));
      if(!$priv){
        $priv[0] = (object) array('id_user_privilege' => "", 'id_privilege' => 0);
      }
      if($pst['pass'] == $if){
        $newdata = array(
          'name'  => $users[0]->name,
          'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($users[0]->name),
          'epass'  => substr(md5(date("d")), -5).$users[0]->pass,
          'email'     => $users[0]->email,
          'id'     => $users[0]->id_users,
          'outlet'     => 0,
          'privilege'     => $priv[0]->id_user_privilege,
          'id_privilege'     => $priv[0]->id_privilege,
          'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => $priv[0]->id_privilege)),
          'logged_in' => TRUE
        );
        $this->session->set_userdata($newdata);
      }
      else{
        $this->session->set_flashdata('pesan', 'Password tidak sesuai');
      }
    }
    else{
      $this->session->set_flashdata('pesan', 'Email tidak terdaftar');
    }
    if($this->session->userdata("id") == 1)
      redirect('home');
    else
      redirect($this->session->userdata("dashbord"));
  }
  
  function logout(){
    $this->session->sess_destroy();
    redirect();
  }
  
  function daftar(){
    $pst = $this->input->post();
    $users = $this->global_models->get_field("m_users", "id_users", array("email" => $pst['email']));
    if($users > 0){
      $this->session->set_flashdata('pesan', 'Email sudah terdaftar');
    }
    else if($pst['pass'] != $pst['re_pass']){
      $this->session->set_flashdata('pesan', 'Password dan Ulangi Password Harus Sama');
    }
    else if(!$pst['name'] AND !$pst['pass'] AND !$pst['email']){
      $this->session->set_flashdata('pesan', 'Data Tidak Valid');
    }
    else{
      $kirim = array(
        'users'           =>  USERSSERVER,
        'password'        =>  PASSSERVER,
        "name"            => $pst['name'],
        "pass"            => $this->encrypt->encode($pst['pass']),
        "email"           => $pst['email'],
        "type"            => $pst['berita'],
        "id_status_user"  => 1,
        'id_privilege'    => 3,
        "create_date"     => date("Y-m-d H:i:s")
      );
      $users_channel = $this->antavaya_lib->curl_mentah($kirim, URLSERVER."json/json-midlle-system/set-users");
      $data_array = json_decode($users_channel);
      if($data_array->status == 2){
        $kirim['id_users'] = $data_array->id_users;
        unset($kirim['id_privilege']);
        unset($kirim['users']);
        unset($kirim['password']);
        $id_users = $this->global_models->insert("m_users", $kirim);
        if($id_users){
          $id_user_privilege = $this->global_models->insert("d_user_privilege", array("id_privilege" => 3, "id_users" => $id_users));
        }

        $newdata = array(
          'name'  => $pst['name'],
          'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($kirim['name']),
          'epass'  => substr(md5(date("d")), -5).$kirim['pass'],
          'email'     => $kirim['email'],
          'id'     => $id_users,
          'outlet'     => 0,
          'privilege'     => $id_user_privilege,
          'id_privilege'     => 3,
          'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => 3)),
          'logged_in' => TRUE
        );
        $this->session->set_userdata($newdata);
      }
    }
    redirect($this->session->userdata("dashbord"));
  }
  
  function login_ajax(){
    $pst = $this->input->post();
    $users = $this->global_models->get("m_users", array("email" => $pst['name']));
    if($users){
      $if = $this->encrypt->decode($users[0]->pass);
      $priv = $this->global_models->get("d_user_privilege", array("id_users" => $users[0]->id_users));
      if(!$priv){
        $priv[0] = (object) array('id_user_privilege' => "", 'id_privilege' => 0);
      }
      if($pst['sandi'] == $if){
        $newdata = array(
          'name'  => $users[0]->name,
          'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($users[0]->name),
          'epass'  => substr(md5(date("d")), -5).$users[0]->pass,
          'email'     => $users[0]->email,
          'id'     => $users[0]->id_users,
          'outlet'     => 0,
          'privilege'     => $priv[0]->id_user_privilege,
          'id_privilege'     => $priv[0]->id_privilege,
          'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => $priv[0]->id_privilege)),
          'logged_in' => TRUE
        );
        $this->session->set_userdata($newdata);
        $bookers = $this->global_models->get("tiket_book", array("id_users" => $users[0]->id_users));
        if(!$bookers){
          $telp = "";
          $depan = "";
          $belakang = "";
        }
        else{
          $telp = $bookers[0]->telphone;
          $depan = $bookers[0]->first_name;
          $belakang = $bookers[0]->last_name;
        }
        print json_encode(array("mail" => $users[0]->email, "telp" => $telp, "depan" => $depan, "belakang" => $belakang));
      }
      else{
        print json_encode(array("status" => 'gagal'));
      }
    }
    else{
      print json_encode(array("status" => 'gagal'));
    }
    die;
  }
 
  function daftar_ajax(){
    $pst = $this->input->post();
    
//    name: nama, sandi: pass, resandi: repass, email: email, berita: berita
    $users = $this->global_models->get_field("m_users", "id_users", array("email" => $pst['email']));
    if($users > 0){
      print json_encode(array("status" => 'gagal'));
    }
    else if($pst['sandi'] != $pst['resandi']){
      print json_encode(array("status" => 'gagal'));
    }
    else if(!$pst['name'] AND !$pst['pass'] AND !$pst['email']){
      print json_encode(array("status" => 'gagal'));
    }
    else{
      $kirim = array(
        'users'           =>  USERSSERVER,
        'password'        =>  PASSSERVER,
        "name"            => $pst['name'],
        "pass"            => $this->encrypt->encode($pst['sandi']),
        "email"           => $pst['email'],
        "type"            => $pst['berita'],
        "id_status_user"  => 1,
        'id_privilege'    => 3,
        "create_date"     => date("Y-m-d H:i:s")
      );
      $users_channel = $this->antavaya_lib->curl_mentah($kirim, URLSERVER."json/json-midlle-system/set-users");
      $data_array = json_decode($users_channel);
      if($data_array->status == 2){
        $kirim['id_users'] = $data_array->id_users;
        unset($kirim['id_privilege']);
        unset($kirim['users']);
        unset($kirim['password']);
        $id_users = $this->global_models->insert("m_users", $kirim);
        if($id_users){
          $id_user_privilege = $this->global_models->insert("d_user_privilege", array("id_privilege" => 3, "id_users" => $id_users));
        }

        $newdata = array(
          'name'  => $pst['name'],
          'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($kirim['name']),
          'epass'  => substr(md5(date("d")), -5).$kirim['pass'],
          'email'     => $kirim['email'],
          'id'     => $id_users,
          'outlet'     => 0,
          'privilege'     => $id_user_privilege,
          'id_privilege'     => 3,
          'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => 3)),
          'logged_in' => TRUE
        );
        $this->session->set_userdata($newdata);
        $telp = "";
        $depan = "";
        $belakang = "";
      }
      print json_encode(array("mail" => $kirim['email'], "telp" => $telp, "depan" => $depan, "belakang" => $belakang));
    }
    
    die;
  }
  
  function form_book(){
    $this->template->build("mobile/form-book", 
      array(
        'url'         => base_url()."themes/mobile-antavaya/",
        'theme2nd'    => 'mobile-antavaya',
      ));
    $this->template
      ->set_layout('default')
      ->build("mobile/form-book");
  }
  
  function ajax_book_promosi(){
    $pst = $this->input->post();
    if($pst['email']){
      
      $kirim = array(
        "nama"      => $pst['name'],
        "email"     => $pst['email'],
        "telp"      => $pst['telp'],
        "note"      => $pst['note'],
        "create_by_users" => $this->session->userdata("id"),
        "create_date" => date("Y-m-d H:i:s"),
      );
      
      $id_inquiry_costume = $this->global_models->insert("inquiry_costume", $kirim);
      
      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('hotelpromo@antavaya.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Hotel The Trans ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Dear Tour Hotel <br />"
        . "Mohon informasi lebih detail untuk promosi Hotel The Trans Resort Bali.<br />"
        . "Kepada <br />"
        . "Nama : {$pst['name']}<br />"
        . "Email : {$pst['email']}<br />"
        . "Telp : {$pst['telp']}<br />"
        . "Desc <br />"
        . "{$pst['note']} <br />"
        . "Terima Kasih"
        . "");  
  //die;
      $this->email->send();
      print 'ok';
    }
    else{
      print 'ko';
    }
    
    die;
  }
  
  function batch_proses_booking_self($ke = 1){
    $pst = $this->input->post();
	/*$pst = array( 
		"ke"	=> 1,
		"id_website_flight_temp" => "TLa+3+YZkyPSh4qm2Uh5O8/xySPhZDDfX3yRYbOhTf/GNxq2EwEW1/QaY9602Q33VPUjF6KpnLUd0QPDjBXmkw==",
		"dtitle" => "Mr",
		"tfirst" => "Nugroho",
		"tlast" => "Santoso",
		"tanggal" => "16 December 1987",
		"thp2" => "08991811123",
		"tmail" => "nugroho.budi@antavaya.com"
	);*/
    $ke = $pst["ke"];
    
    $adult = json_decode($pst['adult']);
//    $this->debug(json_encode(array(0 => array('title' => 'Mr'))));
//    $this->debug(json_decode('[{title: "Mr", first_name: "Nugroho", last_name: "Budhi", tanggal: "1", bulan: "1", tahun: "1935"}]'), true);
//    $this->debug($adult[0]->first_name, true);
//    $this->debug($pst['adult'], true);
    $child = json_decode($pst['child']);
    $infant = json_decode($pst['infant']);
    $flight = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $this->encrypt->decode($pst['id_website_flight_temp'])));
    $flight2 = $this->global_models->get("website_flight_temp", array("id_website_flight_temp" => $this->encrypt->decode($pst['id_website_flight_temp2'])));
    
    if($ke == 1){
      
      $param = array(
        'users'             => USERSSERVER, 
        'password'          => PASSSERVER,
        "adl"               => count($adult), 
        "chd"               => count($child),
        "inf"               => count($infant),
        "id_flight"         => $flight[0]->id_flight, 
        "id_flight2"        => $flight2[0]->id_flight,
        "pp"                => $pst['pp'],
        "id_users"          => $this->session->userdata("id"),
        "harga_bayar"       => $flight[0]->jual,
        "diskon"            => ($flight[0]->hemat + $flight2[0]->hemat),
        "first_name"        => $pst['depan'],
        "last_name"         => $pst['belakang'],
        "telphone"          => $pst['thp2'],
        "email"             => $pst['tmail'],
      );
      $data_json = $this->curl_mentah($param, URLSERVER."json/bookstep1-set-cookie");
      $data = json_decode($data_json);
//      print $data_json;die;
      if($data->status == 2){
//      tiket book
//      $this->debug($pst['id_website_flight_temp'], true);
        $kirim_tiket_flight = array(
          "dari"            => $flight[0]->dari,
          "ke"              => $flight[0]->ke,
          "stop"            => $flight[0]->stop,
          "departure"       => $flight[0]->take_off,
          "arrive"          => $flight[0]->landing,
          "price"           => $flight[0]->price,
          "child"           => $flight[0]->child,
          "infant"          => $flight[0]->infant,
          "diskon"          => $flight[0]->hemat,
          "jual"            => $flight[0]->jual,
          "maskapai"        => $flight[0]->maskapai,
          "img"             => $flight[0]->img,
          "tanggal"         => date("Y-m-d H:i:s"),
          "create_by_users" => $this->session->userdata("id"),
          "create_date"     => date("Y-m-d H:i:s"),
        );
        $id_tiket_flight = $this->global_models->insert("tiket_flight", $kirim_tiket_flight);
        if($id_tiket_flight){
          $items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $flight[0]->id_website_flight_temp));
          foreach($items AS $itm){
            $kirim_items[] = array(
              "id_tiket_flight"             => $id_tiket_flight,
              "id_website_class_code"       => $itm->id_website_class_code,
              "flight_no"                   => $itm->flight_no,
              "dari"                        => $itm->dari,
              "ke"                          => $itm->ke,
              "departure"                   => $itm->take_off,
              "arrive"                      => $itm->landing,
              "create_by_users"             => $this->session->userdata("id"),
              "create_date"                 => date("Y-m-d H:i:s"),
            );
          }
          if($kirim_items)
            $this->global_models->insert_batch("tiket_flight_items", $kirim_items);
        }

        if($flight2){
          $kirim_tiket_flight2nd = array(
            "dari"            => $flight2[0]->dari,
            "ke"              => $flight2[0]->ke,
            "stop"            => $flight2[0]->stop,
            "departure"       => $flight2[0]->take_off,
            "arrive"          => $flight2[0]->landing,
            "price"           => $flight2[0]->price,
            "child"           => $flight2[0]->child,
            "infant"          => $flight2[0]->infant,
            "diskon"          => $flight2[0]->hemat,
            "jual"            => $flight2[0]->jual,
            "maskapai"        => $flight2[0]->maskapai,
            "img"             => $flight2[0]->img,
            "tanggal"         => date("Y-m-d H:i:s"),
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d H:i:s"),
          );
          $id_tiket_flight2 = $this->global_models->insert("tiket_flight", $kirim_tiket_flight2nd);

          if($id_tiket_flight2){
            $items = $this->global_models->get("website_flight_temp_items", array("id_website_flight_temp" => $flight2[0]->id_website_flight_temp));
            foreach($items AS $itm){
              $kirim_items2[] = array(
                "id_tiket_flight"             => $id_tiket_flight2,
                "id_website_class_code"       => $itm->id_website_class_code,
                "flight_no"                   => $itm->flight_no,
                "dari"                        => $itm->dari,
                "ke"                          => $itm->ke,
                "departure"                   => $itm->take_off,
                "arrive"                      => $itm->landing,
                "create_by_users"             => $this->session->userdata("id"),
                "create_date"                 => date("Y-m-d H:i:s"),
              );
            }
            if($kirim_items2)
              $this->global_models->insert_batch("tiket_flight_items", $kirim_items2);
          }
        }
  //      $this->debug('asas', true);
        $t_harga_adult = $flight[0]->price * count($adult);
        $t_harga_child = $flight[0]->child * count($child);
        $t_harga_infant = $flight[0]->infant * count($infant);

        $t_harga_adult2 = $flight2[0]->price * count($adult);
        $t_harga_child2 = $flight2[0]->child * count($child);
        $t_harga_infant2 = $flight2[0]->infant * count($infant);

        $kirim_tiket_book = array(
          "id_tiket_flight"                 => $id_tiket_flight,
          "id_tiket_flight2nd"              => $id_tiket_flight2,
          "id_users"                        => $this->session->userdata("id"),
          "first_name"                      => $pst['depan'],
          "last_name"                       => $pst['belakang'],
          "tanggal"                         => date("Y-m-d H:i:s"),
          "status"                          => 1,
          "telphone"                        => $pst['thp2'],
          "email"                           => $pst['tmail'],
          "price"                           => ($t_harga_adult + $t_harga_child + $t_harga_infant),
          "child"                           => ($t_harga_adult2 + $t_harga_child2 + $t_harga_infant2),
          "infant"                          => ($flight2[0]->hemat + $flight[0]->hemat),
          "create_by_users"                 => $this->session->userdata("id"),
          "create_date"                     => date("Y-m-d H:i:s"),
        );
        $id_tiket_book = $this->global_models->insert("tiket_book", $kirim_tiket_book);

        if($id_tiket_book){
          foreach ($adult AS $ad){
            $kirim_tiket_passenger = array(
              "id_users"        => $this->session->userdata("id"),
              "first_name"      => $ad->first_name,
              "last_name"       => $ad->last_name,
              "title"           => $ad->title,
              "tanggal_lahir"   => $ad->tahun."-".$ad->bulan."-".$ad->tanggal,
              "type"            => 1,
              "create_by_users" => $this->session->userdata("id"),
              "create_date"     => date("Y-m-d H:i:s"),
            );
            $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_tiket_passenger);
            $kirim_tiket_book_passenger[] = array(
              "id_tiket_book"       => $id_tiket_book,
              "id_tiket_passenger"  => $id_tiket_passenger
            );
          }
          foreach ($child AS $ch){
            $kirim_tiket_passenger = array(
              "id_users"        => $this->session->userdata("id"),
              "first_name"      => $ch->first_name,
              "last_name"       => $ch->last_name,
              "title"           => $ch->title,
              "tanggal_lahir"   => $ch->tahun."-".$ch->bulan."-".$ch->tanggal,
              "type"            => 2,
              "create_by_users" => $this->session->userdata("id"),
              "create_date"     => date("Y-m-d H:i:s"),
            );
            $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_tiket_passenger);
            $kirim_tiket_book_passenger[] = array(
              "id_tiket_book"       => $id_tiket_book,
              "id_tiket_passenger"  => $id_tiket_passenger
            );
          }
          foreach ($infant AS $if){
            $kirim_tiket_passenger = array(
              "id_users"        => $this->session->userdata("id"),
              "first_name"      => $if->first_name,
              "last_name"       => $if->last_name,
              "title"           => $if->title,
              "tanggal_lahir"   => $if->tahun."-".$if->bulan."-".$if->tanggal,
              "pax"             => $if->pax,
              "type"            => 3,
              "create_by_users" => $this->session->userdata("id"),
              "create_date"     => date("Y-m-d H:i:s"),
            );
            $id_tiket_passenger = $this->global_models->insert("tiket_passenger", $kirim_tiket_passenger);
            $kirim_tiket_book_passenger[] = array(
              "id_tiket_book"       => $id_tiket_book,
              "id_tiket_passenger"  => $id_tiket_passenger
            );
          }
          if($kirim_tiket_book_passenger)
            $id_tiket_book_passenger = $this->global_models->insert_batch("tiket_book_passenger", $kirim_tiket_book_passenger);
        }

  //      end tiket book
  //      $this->debug('asas', true);
        $this->session->set_userdata(array(
          "cookie_book"       => $data->key,
          "cookie_tiket_book" => $data->id_tiket_book,
          "id_tiket_book"     => $id_tiket_book,
          ));

        $catatan = "Kirim Data Penumpang";
      }
      else{
        $note = 'gagal';
      }
    }
    
    if($ke == 2){
      $cookie_book = $this->session->userdata("cookie_book");
      $cookie_tiket_book = $this->session->userdata("cookie_tiket_book");
      
      $param = array(
        'users'             => USERSSERVER, 
        'password'          => PASSSERVER,
        'key'               => $cookie_book,
        'id_tiket_book'     => $cookie_tiket_book,
        "adl"               => $pst['adult'],
        "chd"               => $pst['child'],
        "inf"               => $pst['infant'],
        "telphone"          => $pst['thp2'],
        "email"             => $pst['tmail'],
      );
      
      $data_json = $this->curl_mentah($param, URLSERVER."json/bookstep2-confirm-book");
//      $this->debug('asas', true);
//      $this->debug($data_json, true);
      $data = json_decode($data_json);
      if($data->status == 2){
        $this->session->set_userdata(array("cookie_book" => $data->key));
        $catatan = "Pengecekan Data Ulang dan Pencarian Code Booking";
      }
      else{
        $note = 'gagal';
      }
    }
    
    if($ke == 3){
      $cookie_book = $this->session->userdata("cookie_book");
      $cookie_tiket_book = $this->session->userdata("cookie_tiket_book");
      
      $param = array(
        'users'             => USERSSERVER, 
        'password'          => PASSSERVER,
        'key'         => $cookie_book,
        'id_tiket_book'     => $cookie_tiket_book,
      );
      
      $data_json = $this->curl_mentah($param, URLSERVER."json/bookstep3-final");
//      print $data_json;die;
      $data = json_decode($data_json);
      if($data->status == 2){
        $kirim_update_tiket_book = array(
          "book_code"       => $data->book,
          "book2nd"         => $data->book2nd,
          "timelimit"       => $data->limit
        );
        $this->global_models->update("tiket_book", array("id_tiket_book" => $this->session->userdata("id_tiket_book")), $kirim_update_tiket_book);
        $this->email_book($data->book);
        $catatan = "Finish";
      }
      else{
        $note = "gagal";
        $catatan = $data->note;
      }
      $this->session->set_userdata(array(
        "cookie_book"       => "",
        "id_tiket_book"     => "",
        "id_tiket_book_passenger" => $data->book
      ));
    }
    
//    $note = $ke;
    $ke++;
    $persen = ceil($ke/4 * 100);
    $hasil = array(
      "proses"      => $ke,
      "note"        => $note,
      "persen"      => $persen,
      "catatan"     => $catatan,
    );
    print json_encode($hasil);
	die;
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */