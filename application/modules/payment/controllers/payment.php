<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends MX_Controller {
    
  function __construct() {      
    $this->load->library('mobile_detect');
    $this->load->library('encrypt');
  }
  
  private function gen_conf_fee($price, &$conf_fee){
    $total = $price + $conf_fee;
    $cek = $this->global_models->get_query("SELECT id_tiket_payment"
      . " FROM tiket_payment AS A"
      . " WHERE total = '{$total}' AND timelimit >= '".date("Y-m-d H:i:s")."' AND type = '1'");
    if($cek[0]->id_tiket_payment > 0){
      $conf_fee = rand(0, 100);
      $this->gen_conf_fee($price, $conf_fee);
    }
    else{
      $cek = $this->global_models->get_query("SELECT id_tiket_payment"
      . " FROM tiket_payment AS A"
      . " WHERE total = '{$total}' AND (tanggal BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:00') AND type <> '2'");
      if($cek[0]->id_tiket_payment > 0){
        $conf_fee = rand(0, 100);
        $this->gen_conf_fee($price, $conf_fee);
      }
      else{
        return true;
      }
    }
  }
  
  function email_timelimit($book_code){
  $data_time = $this->global_models->get_query("
        SELECT id_tiket_book,book_code,create_date,timelimit
        FROM tiket_book 
        WHERE TIMESTAMPDIFF(MINUTE , create_date, NOW() ) <= 30
        AND (status_timelimit < 2 OR status_timelimit > 2)
        ");
  
   if(is_array($data_time)){
      foreach ($data_time as $data_value) {
        
    $book_code = $data_value->book_code; 
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
   /*print "<pre>";
    print_r($tiket_book); 
    print "</pre>";
    die; */
 
    $this->email->from("no-reply@antavaya.com","No Reply");
    
    $this->email->to($tiket_book->pemesan->email);
    $this->email->bcc('nugroho.budi@antavaya.com');
    // die;
    
    $this->email->subject('Tiket Book '.$book_code);
    $isihtml = "<html xmlns='http://www.w3.org/1999/xhtml'>"
      . "<head>"
        . "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>"
        . "<meta name='viewport' content='width=device-width'/>"
        . "<style>#outlook a{padding:0;}body{width:100%!important;min-width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;}.ExternalClass{width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%;}#backgroundTable{margin:0;padding:0;width:100%!important;line-height:100%!important;}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;float:left;clear:both;display:block;}center{width:100%;min-width:580px;}a img{border:none;}p{margin:0 0 0 10px;}table{border-spacing:0;border-collapse:collapse;}td{word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;}table,tr,td{padding:0;vertical-align:top;text-align:left;}hr{color:#d9d9d9;background-color:#d9d9d9;height:1px;border:none;}table.body{height:100%;width:100%;}table.container{width:580px;margin:0 auto;text-align:inherit;}table.row{padding:0px;width:100%;position:relative;}table.container table.row{display:block;}td.wrapper{padding:10px 300px 0px 0px;position:relative;}table.columns,table.column{margin:0 auto;}table.columns td,table.column td{padding:0px 0px 10px;}table.columns td.sub-columns,table.column td.sub-columns,table.columns td.sub-column,table.column td.sub-column{padding-right:10px;}td.sub-column,td.sub-columns{min-width:0px;}table.row td.last,table.container td.last{padding-right:0px;}table.one{width:30px;}table.two{width:80px;}table.three{width:130px;}table.four{width:180px;}table.five{width:230px;}table.six{width:280px;}table.seven{width:330px;}table.eight{width:380px;}table.nine{width:430px;}table.ten{width:480px;}table.eleven{width:530px;}table.twelve{width:580px;}table.one center{min-width:30px;}table.two center{min-width:80px;}table.three center{min-width:130px;}table.four center{min-width:180px;}table.five center{min-width:230px;}table.six center{min-width:280px;}table.seven center{min-width:330px;}table.eight center{min-width:380px;}table.nine center{min-width:430px;}table.ten center{min-width:480px;}table.eleven center{min-width:530px;}table.twelve center{min-width:580px;}table.one .panel center{min-width:10px;}table.two .panel center{min-width:60px;}table.three .panel center{min-width:110px;}table.four .panel center{min-width:160px;}table.five .panel center{min-width:210px;}table.six .panel center{min-width:260px;}table.seven .panel center{min-width:310px;}table.eight .panel center{min-width:360px;}table.nine .panel center{min-width:410px;}table.ten .panel center{min-width:460px;}table.eleven .panel center{min-width:510px;}table.twelve .panel center{min-width:560px;}.body .columns td.one,.body .column td.one{width:8.333333%;}.body .columns td.two,.body .column td.two{width:16.666666%;}.body .columns td.three,.body .column td.three{width:25%;}.body .columns td.four,.body .column td.four{width:33.333333%;}.body .columns td.five,.body .column td.five{width:41.666666%;}.body .columns td.six,.body .column td.six{width:50%;}.body .columns td.seven,.body .column td.seven{width:58.333333%;}.body .columns td.eight,.body .column td.eight{width:66.666666%;}.body .columns td.nine,.body .column td.nine{width:75%;}.body .columns td.ten,.body .column td.ten{width:83.333333%;}.body .columns td.eleven,.body .column td.eleven{width:91.666666%;}.body .columns td.twelve,.body .column td.twelve{width:100%;}td.offset-by-one{padding-left:50px;}td.offset-by-two{padding-left:100px;}td.offset-by-three{padding-left:150px;}td.offset-by-four{padding-left:200px;}td.offset-by-five{padding-left:250px;}td.offset-by-six{padding-left:300px;}td.offset-by-seven{padding-left:350px;}td.offset-by-eight{padding-left:400px;}td.offset-by-nine{padding-left:450px;}td.offset-by-ten{padding-left:500px;}td.offset-by-eleven{padding-left:550px;}td.expander{visibility:hidden;width:0px;padding:0!important;}table.columns .text-pad,table.column .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad,table.columns .text-pad-left,table.column .left-text-pad,table.column .text-pad-left{padding-left:10px;}table.columns .right-text-pad,table.columns .text-pad-right,table.column .right-text-pad,table.column .text-pad-right{padding-right:10px;}.block-grid{width:100%;max-width:580px;}.block-grid td{display:inline-block;padding:10px;}.two-up td{width:270px;}.three-up td{width:173px;}.four-up td{width:125px;}.five-up td{width:96px;}.six-up td{width:76px;}.seven-up td{width:62px;}.eight-up td{width:52px;}table.center,td.center{text-align:center;}h1.center,h2.center,h3.center,h4.center,h5.center,h6.center{text-align:center;}span.center{display:block;width:100%;text-align:center;}img.center{margin:0 auto;float:none;}.show-for-small,.hide-for-desktop{display:none;}body,table.body,h1,h2,h3,h4,h5,h6,p,td{color:#222222;font-family:'Helvetica','Arial',sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;}h1,h2,h3,h4,h5,h6{word-break:normal;}h1{font-size:40px;}h2{font-size:36px;}h3{font-size:32px;}h4{font-size:28px;}h5{font-size:24px;}h6{font-size:20px;}body,table.body,p,td{font-size:14px;line-height:19px;}p.lead,p.lede,p.leed{font-size:18px;line-height:21px;}p{margin-bottom:10px;}small{font-size:10px;}a{color:#2ba6cb;text-decoration:none;}a:hover{color:#2795b6!important;}a:active{color:#2795b6!important;}a:visited{color:#2ba6cb!important;}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#2ba6cb;}h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active{color:#2ba6cb!important;}h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited{color:#2ba6cb!important;}.panel{background:#f2f2f2;border:1px solid #d9d9d9;padding:10px!important;}.sub-grid table{width:100%;}.sub-grid td.sub-columns{padding-bottom:0;}table.button,table.tiny-button,table.small-button,table.medium-button,table.large-button{width:120%;overflow:hidden;}table.button td,table.tiny-button td,table.small-button td,table.medium-button td,table.large-button td{display:block;width:auto!important;text-align:center;background:#2ba6cb;border:1px solid #2284a1;color:#ffffff;padding:8px 0;}table.tiny-button td{padding:5px 0 4px;}table.small-button td{padding:8px 0 7px;}table.medium-button td{padding:12px 0 10px;}table.large-button td{padding:21px 0 18px;}table.button td a,table.tiny-button td a,table.small-button td a,table.medium-button td a,table.large-button td a{font-weight:bold;text-decoration:none;font-family:Helvetica,Arial,sans-serif;color:#ffffff;font-size:16px;}table.tiny-button td a{font-size:12px;font-weight:normal;}table.small-button td a{font-size:16px;}table.medium-button td a{font-size:20px;}table.large-button td a{font-size:24px;}table.button:hover td,table.button:visited td,table.button:active td{background:#2795b6!important;}table.button:hover td a,table.button:visited td a,table.button:active td a{color:#fff!important;}table.button:hover td,table.tiny-button:hover td,table.small-button:hover td,table.medium-button:hover td,table.large-button:hover td{background:#2795b6!important;}table.button:hover td a,table.button:active td a,table.button td a:visited,table.tiny-button:hover td a,table.tiny-button:active td a,table.tiny-button td a:visited,table.small-button:hover td a,table.small-button:active td a,table.small-button td a:visited,table.medium-button:hover td a,table.medium-button:active td a,table.medium-button td a:visited,table.large-button:hover td a,table.large-button:active td a,table.large-button td a:visited{color:#ffffff!important;}table.secondary td{background:#e9e9e9;border-color:#d0d0d0;color:#555;}table.secondary td a{color:#555;}table.secondary:hover td{background:#d0d0d0!important;color:#555;}table.secondary:hover td a,table.secondary td a:visited,table.secondary:active td a{color:#555!important;}table.success td{background:#5da423;border-color:#457a1a;}table.success:hover td{background:#457a1a!important;}table.alert td{background:#c60f13;border-color:#970b0e;}table.alert:hover td{background:#970b0e!important;}table.radius td{-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}table.round td{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px;}body.outlook p{display:inline!important;}@media only screen and (max-width: 600px) {table[class='body'] img{width:auto!important;height:auto!important;}table[class='body'] center{min-width:0!important;}table[class='body'] .container{width:95%!important;}table[class='body'] .row{width:100%!important;display:block!important;}table[class='body'] .wrapper{display:block!important;padding-right:0!important;}table[class='body'] .columns,table[class='body'] .column{table-layout:fixed!important;float:none!important;width:100%!important;padding-right:0px!important;padding-left:0px!important;display:block!important;}table[class='body'] .wrapper.first .columns,table[class='body'] .wrapper.first .column{display:table!important;}table[class='body'] table.columns td,table[class='body'] table.column td{width:100%!important;}table[class='body'] .columns td.one,table[class='body'] .column td.one{width:8.333333%!important;}table[class='body'] .columns td.two,table[class='body'] .column td.two{width:16.666666%!important;}table[class='body'] .columns td.three,table[class='body'] .column td.three{width:25%!important;}table[class='body'] .columns td.four,table[class='body'] .column td.four{width:33.333333%!important;}table[class='body'] .columns td.five,table[class='body'] .column td.five{width:41.666666%!important;}table[class='body'] .columns td.six,table[class='body'] .column td.six{width:50%!important;}table[class='body'] .columns td.seven,table[class='body'] .column td.seven{width:58.333333%!important;}table[class='body'] .columns td.eight,table[class='body'] .column td.eight{width:66.666666%!important;}table[class='body'] .columns td.nine,table[class='body'] .column td.nine{width:75%!important;}table[class='body'] .columns td.ten,table[class='body'] .column td.ten{width:83.333333%!important;}table[class='body'] .columns td.eleven,table[class='body'] .column td.eleven{width:91.666666%!important;}table[class='body'] .columns td.twelve,table[class='body'] .column td.twelve{width:100%!important;}table[class='body'] td.offset-by-one,table[class='body'] td.offset-by-two,table[class='body'] td.offset-by-three,table[class='body'] td.offset-by-four,table[class='body'] td.offset-by-five,table[class='body'] td.offset-by-six,table[class='body'] td.offset-by-seven,table[class='body'] td.offset-by-eight,table[class='body'] td.offset-by-nine,table[class='body'] td.offset-by-ten,table[class='body'] td.offset-by-eleven{padding-left:0!important;}table[class='body'] table.columns td.expander{width:1px!important;}table[class='body'] .right-text-pad,table[class='body'] .text-pad-right{padding-left:10px!important;}table[class='body'] .left-text-pad,table[class='body'] .text-pad-left{padding-right:10px!important;}table[class='body'] .hide-for-small,table[class='body'] .show-for-desktop{display:none!important;}table[class='body'] .show-for-small,table[class='body'] .hide-for-desktop{display:inherit!important;}}</style>"
        . "<style>table.facebook td{background:#3b5998;border-color:#2d4473;}table.facebook:hover td{background:#2d4473!important;}table.twitter td{background:#00acee;border-color:#0087bb;}table.twitter:hover td{background:#0087bb!important;}table.google-plus td{background-color:#DB4A39;border-color:#CC0000;}table.google-plus:hover td{background:#CC0000!important;}.template-label{color:#ffffff;font-weight:bold;font-size:11px;}.callout .panel{background:#ECF8FF;border-color:#b9e5ff;}.header{background:#6B8CF5;}.footer .wrapper{background:#ebebeb;}.footer h5{padding-bottom:10px;}table.columns .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad{padding-left:10px;}table.columns .right-text-pad{padding-right:10px;}@media only screen and (max-width: 600px) {table[class='body'] .right-text-pad{padding-left:10px!important;}table[class='body'] .left-text-pad{padding-right:10px!important;}}</style>"
      . "</head>"
      . "<body>"
        . "<table class='body'>"
          . "<tr>"
            . "<td class='center' align='center' valign='top'>"
              . "<center>"
                . "<table class='row header'>"
                  . "<tr>"
                    . "<td class='center' align='center'>"
                      . "<center>"
                        . "<table class='container'>"
                          . "<tr>"
                            . "<td class='wrapper last'>"
                              . "<table class='twelve columns'>"
                                . "<tr>"
                                  . "<td class='six sub-columns'>"
                                    . "<img src='".base_url()."themes/antavaya/images/logo.png'>"
                                  . "</td>"
                                  . "<td class='six sub-columns last' align='right' style='text-align:right; vertical-align:middle;'>"
                                    . "<span class='template-label'></span>"
                                  . "</td>"
                                  . "<td class='expander'></td>"
                                . "</tr>"
                              . "</table>"
                            . "</td>"
                          . "</tr>"
                        . "</table>"
                      . "</center>"
                    . "</td>"
                  . "</tr>"
                . "</table>"
                . "<br>"
                . "<table class='container'>"
                  . "<tr>"
                    . "<td>"
                      . "<table class='row'>"
                        . "<tr>"
                          . "<td class='wrapper last'>"
                            . "<table class='twelve columns'>"
                              . "<tr>"
                                . "<td>"
                                  . "<h1>Dear, {$tiket_book->pemesan->first_name} {$tiket_book->pemesan->last_name}</h1>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td><b>Anda belum melakukan pembayaran, harap melakukan pembayaran sebelum reservasi tiket anda mencapai time limit.</b></td>"
                                . "</tr>"
                                . "<tr>"
                                  . "<td>"
                                    . "<table class='twelve columns'>"
                                      . "<tr>"
                                        . "<td>"
                                          . "<hr><b>Silahkan pilih cara pembayaran</b> <br><hr>"
                                        . "</td>"
                                      . "</tr>"
                                      . "<tr>"
                                        . "<td>"
                                          . "<div style='width: 20%; float: left; font-size: 13px;'>"
                                            . "<a href='".site_url('payment/gunakan-bca/'.$tiket_book->flight[0]->book_code)."'>"
                                              . "<img src='".base_url()."themes/antavaya/images/bca.png' style='max-width: 80px' /><br /><br />"
                                              . "<br />Transfer BCA"
                                            . "</a>"
                                          . "</div>"
                                          . "<div style='width: 20%; float: left; font-size: 13px;'>"
                                            . "<a href='http://tiket.antavaya.com/index.php/component/mandiripayment/?view=mandiripayment&layout=default&thepnr={$tiket_book->flight[0]->book_code}'>"
                                              . "<img src='".base_url()."themes/antavaya/images/mandiri.png' style='max-width: 80px' /><br />"
                                              . "<br /><br />Mandiri ClickPay"
                                            . "</a>"
                                          . "</div>"
                                          . "<div style='width: 20%; float: left; font-size: 13px;'>"
                                            . "<a href='".site_url('payment/gunakan-cc-bank/3/'.$tiket_book->flight[0]->book_code)."'>"
                                              . "<img src='".base_url()."themes/antavaya/images/visa.png' style='max-width: 80px' /><br /><br />"
                                              . "<br />Visa/Master"
                                            . "</a>"
                                          . "</div>"
                                          . "<div style='width: 20%; float: left; font-size: 13px;'>"
                                            . "<a href='".site_url('payment/gunakan-cc-bank/2/'.$tiket_book->flight[0]->book_code)."'>"
                                              . "<img src='".base_url()."themes/antavaya/images/mega.png' style='max-width: 80px' /><br /><br />"
                                              . "<br />Mega Credit Card"
                                            . "</a>"
                                          . "</div>"
                                          . "<div style='width: 20%; float: left; font-size: 13px;'>"
                                            . "<a href='".site_url('payment/gunakan-cc-bank/4/'.$tiket_book->flight[0]->book_code)."'>"
                                              . "<img src='".base_url()."themes/antavaya/images/mega.png' style='max-width: 80px' /><br /><br />"
                                              . "<br />Mega Priority"
                                            . "</a>"
                                          . "</div>"
                                        . "</td>"
                                      . "</tr>"
                                    . "</table>"
                                  . "</td>"
                                . "</tr>"
                              . "</td>"
                              . "<td class='expander'></td>"
                            . "</tr>"
                          . "</table>"
                        . "</td>"
                      . "</tr>"
                    . "</table>";
           if($tiket_book->diskon_payment){                     
                    $isihtml .= "<table class='row callout'>"
                      . "<tr>"
                        . "<td class='wrapper last'>"
                          . "<table class='twelve columns'>"
                            . "<tr>"
                              . "<td class='panel'>"
                                . "<table style='font-size:12px;FONT-FAMILY:sans-serif'>"
                                  . "<tbody>";
                          foreach ($tiket_book->diskon_payment as $value) {
                                    $isihtml .= "<tr>"
                                      . "<td width='50%'>Diskon khusus bila melakukan pembayaran menggunakan <b>{$value->name}</b></td>" 
                                        . "<td width='15%'> <img src='{$value->logo}' style='max-width: 50px' /><br /></td>"
                                      . "<td ><b>Discount Rp ".  number_format($value->diskon, 0, ".", ",")."</b></td>"
                                    . "</tr>";
                         }              
                                  $isihtml .= "</tbody>"
                                . "</table>"
                              . "</td>"
                              . "<td class='expander'></td>"
                            . "</tr>"
                          . "</table>"
                        . "</td>"
                      . "</tr>"
                    . "</table>";
            }
                    $isihtml .= "<table class='row callout'>"
                      . "<tr>"
                        . "<td class='wrapper last'>"
                          . "<table class='twelve columns'>"
                            . "<tr>"
                              . "<td class='panel'>"
                                . "<table style='font-size:12px;FONT-FAMILY:sans-serif'>"
                                  . "<tbody>"
                                    . "<tr>"
                                      . "<td>Kode Booking </td>"
                                      . "<td>: <b>{$tiket_book->flight[0]->book_code}</b></td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td>Time Limit </td>"
                                      . "<td>: <b>".date("d F Y H:i:s", strtotime($tiket_book->book->timelimit))." WIB</b></td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<br><td style='padding-top: 5%;'>"
                                        . "<table class='button'>"
                                          . "<tr>"
                                            . "<td><a href='".site_url("antavaya/thank-you/{$tiket_book->flight[0]->book_code}")."'>Proses Payment</a></td>"
                                          . "</tr>"
                                        . "</table>"
                                      . "</td>"
                                    . "</tr>"
                                  . "</tbody>"
                                . "</table>"
                              . "</td>"
                              . "<td class='expander'></td>"
                            . "</tr>"
                          . "</table>"
                        . "</td>"
                      . "</tr>"
                    . "</table>";        
                    $isihtml .= "<table class='row'>"
                      . "<tr>"
                        . "<td class='wrapper last'>"
                          . "<table class='twelve columns'>"
                            . "<tr>"
                              . "<td><hr><b>Berikut perincian reservasi anda</b> <hr></td>"
                              . "<td class='expander'></td>"
                            . "</tr>"
                          . "</table>"
                        . "</td>"
                      . "</tr>"
                    . "</table>"
                    . "<table class='row footer'>"
                      . "<tr>"
                        . "<td class='wrapper'>"
                          . "<table class='six columns'>"
                            . "<tr>"
                              . "<td class='left-text-pad'></td>"
                              . "<td>"
                                . "<table style='font-size:12px;FONT-FAMILY:sans-serif; width: 207%;'>"
                                  . "<tbody>"
                                    . "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Informasi Pemesan</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>"
                                      . "<td width='50%'>: {$tiket_book->pemesan->first_name} {$tiket_book->pemesan->last_name}</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Handphone </span> </td>"
                                      . "<td>: <a href='tel:08767673574' value='+628767673574' target='_blank'>{$tiket_book->pemesan->phone}</a></td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Email </span> </td>"
                                      . "<td>: {$tiket_book->pemesan->email}</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td><span style='padding-bottom: 0%;padding-left:6%'>Book date </span> </td>"
                                      . "<td>: ".date("d F Y", strtotime($tiket_book->book->waktu))."</td>"
                                    . "</tr>";
          $no_adult = 0; 
          $no_child = 0;
          $no_inf   = 0;
        foreach ($tiket_book->passenger as $value) {
        if($value->type == 1){
        $no_adult += 1;
                                   // . if($aaa =123){
                                    $isihtml .= "<tr><td colspan='2' height='5px'><br></td></tr>"
                                    . "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Informasi Penumpang {$no_adult}</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>"
                                      . "<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>"
                                      . "<td>:".date("d F Y", strtotime($value->tanggal_lahir))."</td>"
                                    . "</tr>";
              } elseif($value->type == 2){  
                  $no_child += 1;
                                    $isihtml .= "<tr><td colspan='2' height='5px'><br></td></tr>"
                                    . "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Informasi Penumpang Child {$no_child}</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>"
                                      . "<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>"
                                      . "<td>: ".date("d F Y", strtotime($value->tanggal_lahir))."</td>"
                                    . "</tr><br>";
              }  elseif($value->type == 3){  
                  $no_inf += 1;
                                  $isihtml  .= "<tr><td colspan='2' height='5px'><br></td></tr>"
                                    . "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Informasi Penumpang Infant {$no_inf}</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Name </span></td>"
                                      . "<td width='50%'>: {$value->title} {$value->first_name} {$value->last_name}</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Date of Birth </span> </td>"
                                      . "<td>: ".date("d F Y", strtotime($value->tanggal_lahir))."</td>"
                                    . "</tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Pax </span> </td><td>: {$value->pax}</td></tr>"
                                    . "<tr><td colspan='2' height='5px'><br></td></tr>";
           //                         . "<tr>"
  }           }   
           if($tiket_book->flight[0]->flight == 1){
                                    $isihtml .= "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Outgoing Trip</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Flight Date </span></td>"
                                      . "<td width='50%'>: ".date("d F Y", strtotime($tiket_book->flight[0]->departure))."</td>"
                                    . "</tr>"
                                    . "<tr>"
                                      . "<td ><span style='padding-bottom: 0%;padding-left:6%'>Flight No </span> </td>"
                                      . "<td>: {$tiket_book->flight[0]->penerbangan[0]->flight_no}</td>"
                                    . "</tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Depart</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[0]->dari)}</td></tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Arrive</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[0]->ke)}</td></tr>"      
                                    . "<tr><td colspan='2' height='5px'><br></td></tr>";
         }if($tiket_book->flight[1]->flight == 2){
                                    $isihtml .= "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                    ."<td colspan='2' style='padding-bottom: 0%;padding-left:1%'><span style='margin-up:5%'>Return Trip</span></td>"
                                    . "</tr>"
                                    . "<tr style='padding-left:20%'>"
                                      . "<td width='45%'><span style='padding-bottom: 0%;padding-left:6%'>Flight Date </span></td>"
                                      . "<td width='50%'>: ".date("d F Y", strtotime($tiket_book->flight[1]->departure))."</td>"
                                    . "</tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Flight No </span> </td><td>: {$tiket_book->flight[1]->penerbangan[0]->flight_no}</td></tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Depart</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[1]->dari)}</td></tr>"
                                    . "<tr><td ><span style='padding-bottom: 0%;padding-left:6%'>Arrive</span> </td><td>: {$this->global_models->array_kota($tiket_book->flight[1]->ke)}</td></tr>"                                    
                                    . "<tr><td colspan='2' height='5px'><br></td></tr>";
         }                  
                                    $isihtml .= "<tr bgcolor='darkgray' style='padding-left:3%'>"
                                      . "<td colspan='2' style='padding-bottom: 0%;padding-left:1%'>"
                                        . "<span style='margin-up:5%'>Biaya Keseluruhan</span>"
                                      . "</td>"
                                    . "</tr>"
                                    . "<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Price</span> </td><td>: Rp ".number_format(($tiket_book->book->harga_bayar + $tiket_book->book->diskon), 0, ".", ",")."</td></tr>"
                                    . "<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Admin Fee</span> </td><td>: Gratis</td></tr>"
                                    . "<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Discount</span> </td><td>: Rp ".number_format($tiket_book->book->diskon, 0, ".", ",")." </td></tr>"
                                    . "<tr><td colspan='2' height='10px'><br></td></tr>"
                                    . "<tr><td><span style='padding-bottom: 0%;padding-left:6%'>Total</span> </td><td>: <b>Rp ".number_format($tiket_book->book->harga_bayar, 0, ".", ",")." </b></td></tr>"
                                  . "</tbody>"
                                . "</table>"
                                . "<hr style='padding-left:200%'>"
                              . "</td>"
                            . "</td>"
                            . "<td class='expander'></td>"
                          . "</tr>"
                        . "</table>"
                      . "</td>"
                    . "</tr>"
                  . "</table>"
                  . "<table class='row'>"
                    . "<tr>"
                      . "<td style='font-size:11px'>"
                        . "<b>PERHATIAN UNTUK PEMBAYARAN DENGAN SISTEM PEMBAYARAN TRANSFER</b> <br> "
                        . "Bila nilai nominal pembayaran anda tidak sesuai dengan nilai yang tertera di tiket, tiket anda tidak akan tercetak secara otomatis. Sistem e-ticketing kami tidak dapat melakukan pengecekan transaksi pembayaran tiket anda dari pukul 21.00-05.00. Kami harapkan anda untuk melakukan pembayaran dan Konfirmasi Transfer sebelum jam 21.00 ataupun setelah jam 05.00. Bila ingin melakukan pembayaran tiket antara jam 21.00-05.00 lakukan dengan menggunakan Mandiri ClickPay.<br> Jika ada pertanyaan hubungi <b>Layanan Konsumen</b> kami di <b><a href='tel:02129227888' value='+622129227888' target='_blank'>(021) 2922 7888</a></b> atau kirimkan email ke <b><a href='mailto:cs@antavaya.com' target='_blank'>cs@antavaya.com</a></b> dengan mencantumkan Kode Booking, apabila anda mengalami kesulitan atau masalah dalam melakukan pembayaran di website kami."
                        . "<br><br>"
                      . "</td>"
                    . "</tr>"
                    . "<tr>"
                      . "<td class='wrapper last' style='background: url(".base_url()."themes/antavaya/images/back-foot.png) no-repeat center center; color: white'>"
                        . "<table class='twelve columns' style='font-size:10px;FONT-FAMILY:sans-serif'>"
                          . "<tr>"
                            . "<th style='padding-left:5%'>Contact Center 24 jam <br>+6221 2922 7888 <br>cs@antavaya.com <br></th>"
                            . "<th style='padding-left:7%'>Tour inquiries <br>+6221 625 3919 <br>+6221 386 2747 <br>tour@antavaya.com </th>"
                            . "<th style='padding-left:8%'>Complaint & compliment <br>customercare@antavaya.com</th>"
                          . "</tr>"
                        . "</table>"
                      . "</td>"
                    . "</tr>"
                  . "</table>"
                . "</td>"
              . "</tr>"
            . "</table>"
          . "</center>"
        . "</td>"
      . "</tr>"
      . "</table>"
      . "</body>"
      . "</html>"
      . "";
   // print $isihtml; die;
    $this->email->message($isihtml);  
//die;
    
     if($this->email->send()){
      $kirim = array(
            "status_timelimit"      => 2
        );
        $this->global_models->update("tiket_book", array("book_code" => $data_value->book_code,"id_tiket_book" => $data_value->id_tiket_book),$kirim);
     
    }else{
      $kirim = array(
            "status_timelimit"      => 3
        );
        $this->global_models->update("tiket_book", array("book_code" => $value->book_code,"id_tiket_book" => $value->id_tiket_book),$kirim);
      
    }

//    echo $this->email->print_debugger();
     }
      }
      return true;
  }
  
  
  function email_convenience_fee($book_code){
     
    $this->load->library('email');
    $this->email->initialize($this->global_models->email_conf());

    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      'book_code'         => $book_code
    );
    $tiket_book_json = $this->curl_mentah($kirim, URLSERVER."json/get-detail-tiket-book");
    $tiket_book = json_decode($tiket_book_json);
    
    $detail = $this->global_models->get("tiket_payment", array("book_code" => $book_code, "status" => 1));
//    $detail_data = $this->global_models->get("tiket_book", array("book_code" => $book_code));
    
    $type = array(1 => "BCA", 2 => "Kartu Kredit Mega", 3 => "Visa/ Master Card", 4 => "Mega Priority");
 
    $this->email->from("no-reply@antavaya.com","AntaVaya Online");
    $this->email->to($tiket_book->pemesan->email);
    $this->email->bcc('nugroho.budi@antavaya.com');
    
    // die;
    $this->email->subject('Payment Tiket '.$book_code.' '.$type[$detail[0]->type]);
    
    $bca_type = "<tr>"
        . "<td colspan='2'>Silahkan transfer ke No rekening BCA dibawah ini: </td>"
      . "</tr>"
      . "<tr>"
        . "<td>Nama </td>"
        . "<td>: <b>Antonia</b></td>"
      . "</tr>"   
      . "<tr>"
        . "<td>No Rek	 </td>"
        . "<td>: <b>535-018-7938 (KCP Juanda 111)</b></td>"
      . "</tr>"
      . "<tr>"
        . "<br><td style='padding-top: 5%;'>"
        . "<table class='button'>"
          . "<tr>"
            . "<td><a href='".site_url("payment/gunakan-bca/{$detail[0]->book_code}")."'>Konfirmasi Payment</a></td>"
          . "</tr>"
        . "</table>"
      . "</tr>";
    $cc_type = "<tr>"
        . "<td colspan='2'>Silahkan melakukan pembayaran menggunakan kartu anda: </td>"
      . "</tr>"
      . "<tr>"
        . "<br><td style='padding-top: 5%;'>"
        . "<table class='button'>"
          . "<tr>"
            . "<td><a href='".site_url("payment/gunakan-cc-bank/{$detail[0]->type}/{$detail[0]->book_code}")."'>Payment</a></td>"
          . "</tr>"
        . "</table>"
      . "</tr>";
    $payment_type = array(
      1         => $bca_type,
      2         => $cc_type,
      3         => $cc_type,
      4         => $cc_type,
    );
    
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
    </td>
  </tr>
</table>

<table border='0' width='100%' height='100%' cellpadding='0' cellspacing='0' bgcolor='#ffffff'>
  <tr>
    <td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'>
      <br>
      <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px;height: 50px;'>
        <tr>
          <td class='container-padding header' align='left'>
            <span style='font-family:Helvetica, Arial, sans-serif;font-size:30px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px'>Dear, {$tiket_book->pemesan->first_name} {$tiket_book->pemesan->last_name}</span>
          <br><br><b> Cara pembayaran dengan transfer {$type[$detail[0]->type]}.</b>
		  <br><br><hr><b>Berikut perincian biaya reservasi anda</b> <br><hr>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td align='center' valign='top' bgcolor='#ffffff' style='background-color: #ffffff;'><br> 
	  <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
      <tr>
		<td class='container-padding content' align='left' style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#b9e5ff;'>
          <table style='font-size:12px;FONT-FAMILY:sans-serif;margin-left:5%'>
                                  <tbody>
                                    <tr>
                                      <td>Price </td>
                                      <td>: Rp ".number_format($detail[0]->price, 0, ".", ",")."</td>
                                    </tr>
									<tr>
                                      <td>Convenience Fee </td>
                                      <td>: Rp ". number_format($detail[0]->conf_fee, 0, ".", ",") ."</td>
                                    </tr>
									<tr>
                                      <td>Discount </td>
                                      <td>: Rp ". number_format($detail[0]->diskon, 0, ".", ",") ."</td>
                                    </tr>
									<tr>
                                      <td>Total </td>
                                      <td>: <b>Rp ". number_format($detail[0]->total, 0, ".", ",") ."</b></td>
                                    </tr>
									<tr>
                                      <td>Kode Booking </td>
                                      <td>: <b>{$detail[0]->book_code}</b></td>
                                    </tr>
                                    <tr>
                                      <td>Time Limit </td>
                                      <td>: <b>".date("d F Y H:i:s", strtotime($detail[0]->timelimit))." WIB</b></td>
                                    </tr>
									<tr><td colspan='2' height='10px'><br></td></tr>
									 {$payment_type[$detail[0]->type]}
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

   
	  <table border='0' width='600' cellpadding='0' cellspacing='0' class='container' style='width:600px;max-width:600px'>
        

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
    </td>
  </tr>
</table>
</body>
</html>";
   // print $isihtml; die;
    $this->email->message($isihtml);  
//die;
    $this->email->send();

//    echo $this->email->print_debugger();
//    die;
    return true;
  }
  
  function gunakan_bca($book_code = ""){
   
    if($book_code)
      $book_code = $book_code;
    else
      $book_code = $this->session->userdata("proses_pembayaran_book_code");
    
    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      'book_code'         => $book_code
    );
    $tiket_book_json = $this->curl_mentah($kirim, URLSERVER."json/get-detail-tiket-book");
    $tiket_book = json_decode($tiket_book_json);
    
    $this->global_models->update("tiket_payment", array("book_code" => $book_code, "type <>" => 1, "status" => 1), array("status" => 2));
      
    $tiket_payment = $this->global_models->get("tiket_payment", array("book_code" => $book_code, "type" => 1));
    
    if(!$tiket_payment[0]->id_tiket_payment > 0){
      $conf_fee = 0;
      $this->gen_conf_fee($this->session->userdata("proses_pembayaran_harga_bayar"), $this->session->userdata("proses_pembayaran_timelimit"), $conf_fee);
      $kirim = array(
        "book_code"               => $book_code,
        "status"                  => 1,
        "tanggal"                 => date("Y-m-d H:i:s"),
        "timelimit"               => $tiket_book->book->timelimit,
        "price"                   => ($tiket_book->book->harga_bayar + $tiket_book->book->diskon),
        "diskon"                  => ($tiket_book->book->diskon + $tiket_book->diskon_payment->$type->diskon),
        "total"                   => ($tiket_book->book->harga_bayar - $tiket_book->diskon_payment->$type->diskon),
        "conf_fee"                => $conf_fee,
        "total"                   => ($this->session->userdata("proses_pembayaran_harga_bayar") + $conf_fee),
        "type"                    => 1,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s"),
      );
      $id_tiket_payment = $this->global_models->insert("tiket_payment", $kirim);
      $tiket_payment = $this->global_models->get("tiket_payment", array("id_tiket_payment" => $id_tiket_payment));
      $this->email_convenience_fee($book_code);
    }
    if($tiket_payment[0]->status == 2){
      $this->global_models->update("tiket_payment", array("id_tiket_payment" => $tiket_payment[0]->id_tiket_payment), array("status" => 1));
    }
    
    $this->session->set_userdata(array(
      "proses_pembayaran_book_code"       => "",
      "proses_pembayaran_harga_bayar"     => "",
      "proses_pembayaran_timelimit"       => "",
      "proses_pembayaran_diskon"          => "",
    ));
    $this->template->build("bca", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'book_code'   => $book_code,
        'tiket'       => $tiket_payment
      ));
    $this->template
      ->set_layout('default')
      ->build("bca");
  }
  
  function gunakan_cc_bank($type, $book_code = ""){
//    $tiket_book = $this->global_models->get("tiket_book", array("book_code" => $book_code));
    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      'book_code'         => $book_code
    );
    $tiket_book_json = $this->curl_mentah($kirim, URLSERVER."json/get-detail-tiket-book");
    $tiket_book = json_decode($tiket_book_json);
//    $this->debug($tiket_book);
//    $this->debug($tiket_book->diskon_payment->$type, true);
    if($tiket_book->status != 2){
      redirect("payment/fail");
    }
    
    $this->global_models->update("tiket_payment", array("book_code" => $book_code, "type <>" => $type, "status" => 1), array("status" => 2));
    
    $tiket_payment = $this->global_models->get("tiket_payment", array("book_code" => $book_code, "pos" => 1, "type" => $type));
    if(!$tiket_payment[0]->id_tiket_payment > 0){
      $kirim = array(
        "book_code"               => $book_code,
        "id_website_hemat_mega"   => $tiket_book->diskon_payment->$type->id,
        "tanggal"                 => date("Y-m-d H:i:s"),
        "timelimit"               => $tiket_book->book->timelimit,
        "status"                  => 1,
        "price"                   => ($tiket_book->book->harga_bayar + $tiket_book->book->diskon),
        "diskon"                  => ($tiket_book->book->diskon + $tiket_book->diskon_payment->$type->diskon),
        "total"                   => ($tiket_book->book->harga_bayar - $tiket_book->diskon_payment->$type->diskon),
        "pos"                     => 1,
        "type"                    => $type,
        "create_by_users"         => $this->session->userdata("id"),
        "create_date"             => date("Y-m-d H:i:s"),
      );
      $id_tiket_payment = $this->global_models->insert("tiket_payment", $kirim);
      $tiket_payment = $this->global_models->get("tiket_payment", array("id_tiket_payment" => $id_tiket_payment));
      $this->email_convenience_fee($book_code);
    }
    if($tiket_payment[0]->status == 2){
      $this->global_models->update("tiket_payment", array("id_tiket_payment" => $tiket_payment[0]->id_tiket_payment), array("status" => 1));
    }
    $this->template->build("cc-bank", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'book_code'   => $book_code,
        'tiket'       => $tiket_payment,
        'type'        => $type,
      ));
    $this->template
      ->set_layout('default')
      ->build("cc-bank");
  }
  
  function konfirm_bca(){
    if($this->input->post("id_tiket_payment")){
      $id_tiket_payment = $this->input->post("id_tiket_payment");
    }
    else{
      $id_tiket_payment = $this->session->userdata("temp_id_tiket_payment");
    }
    if($id_tiket_payment){
      $tiket_payment = $this->global_models->get("tiket_payment", array("id_tiket_payment" => $id_tiket_payment));
      $this->session->set_userdata(array("temp_id_tiket_payment" => ""));
      $this->template->build("konfirmasi-bca", 
        array(
          'url'         => base_url()."themes/antavaya/",
          'theme2nd'    => 'antavaya',
          'tiket'       => $tiket_payment
        ));
      $this->template
        ->set_layout('default')
        ->build("konfirmasi-bca");
    }
    else{
      redirect("antavaya/konfirmasi-pembayaran");
    }
  }
  
  function konfirm_cc_bank(){
    $tiket = $this->global_models->get_query("SELECT A.*"
      . " FROM tiket_payment AS A"
      . " WHERE A.id_tiket_payment = '{$this->input->post("id_tiket_payment")}'");
	$tt = $this->global_models->get("tiket_payment", array("book_code" => $tiket[0]->book_code));
	foreach($tt AS $tk){
		if($tk->pos == 1)
			$bayar += $tk->total;
		else
			$bayar = $bayar - $tk->total;
	}
	//print $bayar;die;
    $mid = array(
      2 => '201504003201',
      3 => '201504003102',
      4 => '201504003301',
    );
    $angka1 = md5(rand(11111, 99999));
    $angka2 = md5(rand(11111, 99999));
    $jml_angka = strlen((string) $tiket[0]->id_tiket_payment);
    $hasil = ""
      . "<form id='bankcc' method='POST' action='https://ibank.bankmega.com/mv/directlink/payment_cc.php'>"
      . "<input type='hidden' id='mid' name='mid' value='{$mid[$tiket[0]->type]}'>"
      . "<input type='hidden' id='ref' name='ref' value='{$tiket[0]->book_code}'>"
      . "<input type='hidden' id='amt' name='amt' value='".number_format($bayar, 2,".","")."'>"
      . "<input type='hidden' id='cur' name='cur' value='IDR'>"
      . "<input type='hidden' id='paytype' name='paytype' value='3'>"
      . "<input type='hidden' id='transtype' name='transtype' value='sale'>"
      . "<input type='hidden' id='userfield1' name='userfield1' value='".$tiket[0]->book_code."'>"
      . "<input type='hidden' id='userfield2' name='userfield2' value='".$tiket[0]->type."'>"
      . "<input type='hidden' id='userfield3' name='userfield3' value=''>"
      . "<input type='hidden' id='userfield4' name='userfield4' value=''>"
      . "<input type='hidden' id='userfield5' name='userfield5' value='".$jml_angka.$angka1.$tiket[0]->id_tiket_payment.$angka2."'>"
      . "<input type='hidden' id='returnurl' name='returnurl' value='".site_url("payment/thank-you/{$tiket[0]->book_code}")."'>"
      . "<input type='hidden' id='statusurl' name='statusurl' value='".site_url("payment/cek-cc-bank")."'>"
//      . "<input id='submit' type='button' name='submitconfirm' value='Confirm Data Itinerary'>"
      . "</form>"
      . "";
    print $hasil;
    print '<script>
function myFunction() {
    document.getElementById("bankcc").submit();
}
myFunction();
</script>';
    die;
  }
  
  function thank_you($book_code){
    $tiket = $this->global_models->get_query("SELECT A.*"
      . " FROM tiket_payment AS A"
      . " WHERE A.book_code = '{$book_code}' AND pos = 1");
    $tiket2 = $this->global_models->get_query("SELECT A.*"
      . " FROM tiket_payment AS A"
      . " WHERE A.book_code = '{$book_code}' AND pos = 2");
//    $this->debug($tiket2);
//    $this->debug($tiket, true);
    $this->template->build("thank-you", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'tiket'       => $tiket,
        'tiket2'      => $tiket2
      ));
    $this->template
      ->set_layout('default')
      ->build("thank-you");
  }
  
  function cek_cc_bank(){
    $pst = $this->input->post();
    $digit = substr($pst['TM_UserField5'], 0, 1);
    $id_tiket_payment = substr($pst['TM_UserField5'], 33, $digit);
    $book_code        = $pst['TM_UserField1'];
    $type             = $pst['TM_UserField2']; 
    $this->global_models->insert("log_bank", array("note" => $pst['TM_Error'], "tanggal" => date("Y-m-d H:i:s"), "book_code" => $pst['TM_UserField1']));
//    $id_tiket_payment = 1;
//    $book_code        = '24P6XG';
//    $type             = 3;
    
    if($id_tiket_payment){
      $tiket_payment  = $this->global_models->get("tiket_payment", array("id_tiket_payment" => $id_tiket_payment));
//      $tiket_book     = $this->global_models->get("tiket_book", array("id_tiket_book" => $tiket_payment[0]->id_tiket_book));
      if($tiket_payment[0]->book_code == trim($book_code) AND $tiket_payment[0]->type == trim($type) AND !$pst['TM_Error']){
        $kirim = array(
          "book_code"             => $tiket_payment[0]->book_code,
          "status"                => 1,
          "total"                 => $pst['TM_DebitAmt'],
          "pos"                   => 2,
          "type"                  => $tiket_payment[0]->type,
          "tanggal"               => date("Y-m-d H:i:s"),
          "create_by_users"       => $this->session->userdata("id"),
          "create_date"           => date("Y-m-d H:i:s")
        );
        $id_tiket_payment_credit = $this->global_models->insert("tiket_payment", $kirim);
        
        $debit = $this->global_models->get_field("tiket_payment", "sum(total)", array(
          "book_code"             => $tiket_payment[0]->book_code,
          "type"              => $tiket_payment[0]->type,
          "pos"               => 1,
          )
        );
        $kredit = $this->global_models->get_field("tiket_payment", "sum(total)", array(
          "book_code"             => $tiket_payment[0]->book_code,
          "type"              => $tiket_payment[0]->type,
          "pos"               => 2,
          )
        );
        if($kredit >= $debit){
          $post = array(
            'users'             => USERSSERVER, 
            'password'          => PASSSERVER,
            "book_code"         => $tiket_payment[0]->book_code,
            'harga_bayar'       => $kredit,
            'channel'           => $tiket_payment[0]->type,
          );
          $data = $this->curl_mentah($post, URLSERVER."json/issued");
          $data_array = json_decode($data);
//          $this->debug($post);
//          $this->debug($data_array, true);
          if($data_array->status == 2){
//        pengolahan book
            
            $cara_bayar = array(
              2 => "Master/VISA",
              3 => "Credit Card MEGA",
              4 => "MEGA Priority"
            );
            $kirim_update_book = array(
              "cara_bayar"  => $cara_bayar[$tiket_payment[0]->type],
              "status"      => 3
            );
            $this->global_models->update("tiket_book", array("book_code" => $tiket_payment[0]->book_code), $kirim_update_book);
            $this->global_models->update("tiket_payment", array("id_tiket_payment" => $id_tiket_payment), array("status" => 3));
//        pengolahan book
          }
        }
//        $this->debug('sasa');
      }
    }
    die;
  }
  
  function cek_bca(){
    $tiket_payment = $this->global_models->get_query("SELECT *"
      . " FROM tiket_payment"
      . " WHERE status = '1' AND type = '1' AND timelimit >= '".date("Y-m-d H:i:s")."'");
    
    $bca = $this->global_models->get_field("variable", "isi", array("code" => "bca"));
//    $this->debug($tiket_payment, true);
    if($bca == "idle"){
      $scrap_bca = $this->transaksi_hari_ini();
      foreach($tiket_payment AS $tp){
        $hasil = $this->olah_bca($tp->total, $scrap_bca);
        
        if($hasil == "nbs"){
          $this->global_models->update("tiket_payment", array("id_tiket_payment" => $tp->id_tiket_payment), array("status" => 3, "type" => 1, "tanggal" => date("Y-m-d H:i:s")));
          $post = array(
            'users'             => USERSSERVER, 
            'password'          => PASSSERVER,
            "book_code"         => $tp->book_code,
            'harga_bayar'       => $tp->total,
            'channel'           => 1,
          );
          $data = $this->curl_mentah($post, URLSERVER."json/issued");
          $data_array = json_decode($data);
    //      $this->debug($data_array, true);
          if($data_array->status == 2){
    //        pengolahan book
            $kirim_update_book = array(
              "cara_bayar"  => "BCA",
              "status"      => 3,
            );
            $this->global_models->update("tiket_book", array("id_tiket_book" => $tp->id_tiket_book), $kirim_update_book);
    //        pengolahan book
//            $gagal = "E-tiket akan dikirimkan melalui email pemesan yang terdaftar. Terima Kasih";
          }
          else{
//            $gagal = "Issued Tiket Gagal. Mohon Hubungi nugroho.budi@antavaya.com dan sertakan Code Book {$book[0]->book_code} Error Code {$data_array->status}";
          }
//          $this->session->set_flashdata('success', 'Pembayaran Diterima.'.$gagal);
        }
        else{
//          $this->session->set_flashdata('notice', 'Pembayaran Belum Diterima');
        }
      }
    }
    $this->session->set_userdata(array("temp_id_tiket_payment" => $this->input->post("id_tiket_payment")));
    redirect("payment/konfirm-bca");
  }
  
  private function olah_bca($total, $hasil){
    
    $array = explode('<font face="verdana" size="1" color="#0000bb">', $hasil);
    $r = "bhsakhd";
    foreach($array AS $gt => $ar){
      if(strpos($ar, number_format($total,2,".",",")."</font></div></td>")){
        if(strpos($array[($gt+1)], 'CR</font></div></td>')){
          $r = "nbs";
        }
      }
    }
        
    return $r;
  }
  
  private function transaksi_hari_ini(){
    $this->load->library('bca');
    $this->global_models->update("variable", array("code" => "bca"), array("isi" => "online"));
    $data = $this->bca->start();
    if($data['ketemu']) {
      
      $cookie_1 = $data['cookie_1'];
      $cookie_2 = $data['cookie_2'];

      $is_login = $this->bca->login($cookie_1, $cookie_2);

      if($is_login) {
//        $hasil = $this->bca->show_last_mutasi($cookie_1, $cookie_2, 16, 2, 2015);
//        $total = 2000000;
        $hasil = $this->bca->show_last_mutasi($cookie_1, $cookie_2, date("j"), date("n"), date("Y"));
        $r = $hasil;
        file_put_contents("files/antavaya/logtransaksibca/".date("YmdHis").".html", $r);
        $this->load->library('email');
        $this->email->initialize($this->global_models->email_conf());
        $this->email->from("no-reply@antavaya.com","AntaVaya Online");
        $this->email->to('nugroho.budi@antavaya.com');
        $this->email->subject('System');
        $isihtml = "Log data Website<br> Module Payment function transaksi_hari_ini()<br> lokasi log file:files/antavaya/logtransaksibca";
        $this->email->message($isihtml);  
        $this->email->send();
      }
      $this->bca->logout($cookie_1, $cookie_2);
    }
    $this->global_models->update("variable", array("code" => "bca"), array("isi" => "idle"));
    return $r;
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
  
  function batch_tiketing(){
    $tiket_payment = $this->global_models->get_query("SELECT *"
      . " FROM tiket_payment"
      . " WHERE status = '1' AND type = '1' AND timelimit >= '".date("Y-m-d H:i:s")."'");
    
    $bca = $this->global_models->get_field("variable", "isi", array("code" => "bca"));
    if($bca == "idle"){
      $scrap_bca = $this->transaksi_hari_ini();
      $note = $tiket_payment[0]->id_tiket_payment;
      foreach($tiket_payment AS $tp){
        $hasil = $this->olah_bca($tp->total, $scrap_bca);
        
        if($hasil == "nbs"){
          $this->global_models->update("tiket_payment", array("id_tiket_payment" => $tp->id_tiket_payment), array("status" => 3, "type" => 1, "tanggal" => date("Y-m-d H:i:s")));
          $post = array(
            'users'             => USERSSERVER, 
            'password'          => PASSSERVER,
            "book_code"         => $tp->book_code,
            'harga_bayar'       => $tp->total,
            'channel'           => 1,
          );
          $data = $this->curl_mentah($post, URLSERVER."json/issued");
          $data_array = json_decode($data);
          if($data_array->status == 2){
            $kirim_update_book = array(
              "cara_bayar"  => "BCA",
              "status"      => 3,
            );
            $this->global_models->update("tiket_book", array("id_tiket_book" => $tp->id_tiket_book), $kirim_update_book);
            $note .= "{$tp->id_tiket_payment} -> Bayar Ok, Issued Ok <br />";
          }
          else{
            $note .= "{$tp->id_tiket_payment} -> Bayar Ok, Issued Gagal <br />";
          }
        }
        else{
          $note .= "{$tp->id_tiket_payment} -> Belum Bayar <br />";
        }
      }
      print $note;
    }
    else{
      print "wait ...";
    }
    die;
  }
  
  function iss(){
    $post = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      "book_code"         => "4QVYBV",
      'harga_bayar'       => "1316232",
      'channel'           => 2,
    );
    $data = $this->curl_mentah($post, URLSERVER."json/issued");
    $data_array = json_decode($data);
    $this->debug($data);
    $this->debug($data_array, true);
  }
  
  function cront_bca(){
    $tiket_payment = $this->global_models->get_query("SELECT *"
      . " FROM tiket_payment"
      . " WHERE status = '1' AND type = '1' AND timelimit >= '".date("Y-m-d H:i:s")."'");
    
    $bca = $this->global_models->get_field("variable", "isi", array("code" => "bca"));
//    $this->debug($tiket_payment, true);
    if($bca == "idle"){
      $scrap_bca = $this->transaksi_hari_ini();
      foreach($tiket_payment AS $tp){
        $hasil = $this->olah_bca($tp->total, $scrap_bca);
        
        if($hasil == "nbs"){
          $this->global_models->update("tiket_payment", array("id_tiket_payment" => $tp->id_tiket_payment), array("status" => 3, "type" => 1, "tanggal" => date("Y-m-d H:i:s")));
          $post = array(
            'users'             => USERSSERVER, 
            'password'          => PASSSERVER,
            "book_code"         => $tp->book_code,
            'harga_bayar'       => $tp->total,
            'channel'           => 1,
          );
          $data = $this->curl_mentah($post, URLSERVER."json/issued");
          $data_array = json_decode($data);
    //      $this->debug($data_array, true);
          if($data_array->status == 2){
    //        pengolahan book
            $kirim_update_book = array(
              "cara_bayar"  => "BCA",
              "status"      => 3,
            );
            $this->global_models->update("tiket_book", array("id_tiket_book" => $tp->id_tiket_book), $kirim_update_book);
    //        pengolahan book
//            $gagal = "E-tiket akan dikirimkan melalui email pemesan yang terdaftar. Terima Kasih";
            print $tp->total." Issued Berhasil <br />";
          }
          else if($data_array->status == 4){
            print $tp->total." Issued Nomor Tidak Ada <br />";
          }
          else if($data_array->status == 6){
            print $tp->total." Issued File Tidak Ada <br />";
          }
          else{
            print $tp->total." gagal no {$data_array->status} <br />";
          }
//          $this->session->set_flashdata('success', 'Pembayaran Diterima.'.$gagal);
        }
        else{
          print $tp->total." Belum ada <br />";
        }
      }
    }
    else{
      print "Online";
    }
    die;
  }
  
  function inventory_void(){
     $pst = $this->input->post(NULL);
//     print_r($pst);
//     die;
     $note = trim($pst['note_cancel']);
     if($note){
         $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_inventory"    => $pst["id"],
      "note"            => $note,
      "id_users"        => $this->session->userdata("id")       
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-void");  
    $data_array = json_decode($data);
//    $this->debug($data, true);
//    die;
    if($data_array->status == 2){
        $this->session->set_flashdata('success', "Data Berhasil di Hapus");
    }elseif($data_array->status == 3){
        $this->session->set_flashdata('notice', "Gagal, Tidak ada akses untuk delete inventory ini");
    }else{
        $this->session->set_flashdata('notice', "Tidak Ada Akses");
    } 
      }else{
         $this->session->set_flashdata('notice', "Note Cancel Harus di isi");
     }
     redirect("payment/inventory");
     
  }
  
  public function inventory_create(){
    if(!$this->input->post(NULL)){
       
      $post_agent = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "status"            => 1
      );

      $pameran = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
      $pameran_array = json_decode($pameran);
      $pameran_drop[NULL] = '- Pilih -';
  //    $this->debug($pameran, true);
      foreach($pameran_array->data AS $pp){
        $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d", strtotime($pp->date_start))."-".date("d M y", strtotime($pp->date_end));
      }

      $css = ""
  //      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>";

      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
        . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"

        ."<script type='text/javascript'>"
        . "$(function() { "
          . "$('.select2').select2();"
          . "$( '#tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
        . "</script> 
          <script>
  function FormatCurrency(objNum)
  {
     var num = objNum.value
     var ent, dec;
     if (num != '' && num != objNum.oldvalue)
     {
       num = MoneyToNumber(num);
       if (isNaN(num))
       {
         objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
       } else {
         var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
         if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
         {
          // alert(num.split('.')[1]);
           objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
         }
         else
         {
           objNum.value = AddCommas(num.split('.')[0]);
         }
         objNum.oldvalue = objNum.value;
       }
     }
  }
  function MoneyToNumber(num)
  {
     return (num.replace(/,/g, ''));
  }

  function AddCommas(num)
  {
     numArr=new String(num).split('').reverse();
     for (i=3;i<numArr.length;i+=3)
     {
       numArr[i]+=',';
     }
     return numArr.reverse().join('');
  } 

  function formatCurrency(num) {
     num = num.toString().replace(/\$|\,/g,'');
     if(isNaN(num))
     num = '0';
     sign = (num == (num = Math.abs(num)));
     num = Math.floor(num*100+0.50000000001);
     cents = num0;
     num = Math.floor(num/100).toString();
     for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
     num = num.substring(0,num.length-(4*i+3))+'.'+
     num.substring(num.length-(4*i+3));
     return (((sign)?'':'-') + num);
  }
  </script>";
//      $this->debug($detail_array, true);
      $this->template->build("inventory-create", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'payment/inventory',
              'title'       => lang("Payment TTU"),
              'book_code'   =>  $book_code,
              'data'        =>  $detail_array,
              'breadcrumb'  => array(
                  "book_list"  => "grouptour/product-tour/book-list"
                ),
              'css'         => $css,
              'foot'        => $foot,
              'pameran'     => $pameran_drop,
            ));
      $this->template
        ->set_layout('form')
        ->build("inventory-create");
    }
    else{
      $pst = $this->input->post(NULL);
//      $this->debug($pst, true);
      
      if($pst['nominal'] > 0){
          $paket1 = array(
            "users"           => USERSSERVER,
            "password"        => PASSSERVER,
            "nominal"         => str_replace(",","",$pst['harga']),
            "tanggal"         => $pst['tanggal'],
            "id_users"        => $this->session->userdata("id"),
            "type"            => $pst['type'],
            "first_name"      => $pst['first_name'],
            "last_name"       => $pst['last_name'],
            "telp"            => $pst['telp'],
            "alamat"          => $pst['alamat'],
            "email"           => $pst['email'],
            "title"           => $pst['title'],
            "code"            => $pst['kode'],
            "note"            => $pst['remark'],
            "status"          => 1,
          );
          $detail1 = $this->global_variable->curl_mentah($paket1, URLSERVER."json/json-tour/inventory-set");
          $detail1_array = json_decode($detail1);
          
          if($detail1_array->status == 5){
              $this->session->set_flashdata('notice', "Gagal Insert, Users Session Anda sudah Habis, harap login Ulang");
              redirect("payment/inventory");
          }
//          $this->debug($detail1, true);
          if($detail1_array->id_inventory){
            $paket = array(
              "users"           => USERSSERVER,
              "password"        => PASSSERVER,
              "nominal"         => str_replace(",","",$pst['nominal']),
              "harga"           => str_replace(",","",$pst['harga']),
              "tanggal"         => $pst['tanggal'],
              "id_tour_pameran" => $pst['id_tour_pameran'],
              "id_users"        => $this->session->userdata("id"),
              "id_inventory"    => $detail1_array->id_inventory,
              "type"            => $pst['type'],
              "remark"          => $pst['remark'],
              "id_store"        => $this->session->userdata("id_store"),
            );
            $detail = $this->global_variable->curl_mentah($paket, URLSERVER."json/json-tour/ttu-set");
            $detail_array = json_decode($detail);
          }
          
          if($detail_array->status == 5){
              $this->session->set_flashdata('notice', "Gagal Insert, Users Session Anda sudah Habis, harap login Ulang");
              redirect("payment/inventory");
          }
//          $this->debug($detail, true);

//		$kirim_info_customer = array(
//          "users"                     => USERSSERVER,
//          "password"                  => PASSSERVER,
//          "id_users"                  => $this->session->userdata("id"),
//          "code"                      => $pst['book_code'],
//		  "nominal"					  => $pst['nominal']
//        );
//        $this->global_variable->curl_mentah($kirim_info_customer, URLSERVER."json/json-mail/info-book-status-to-customer");	
 
      }
      else{
//        if(!$pst["no_ttu"]){
//          if(!$pst['no_deposit']){
//            $this->session->set_flashdata('notice', "No TTU atau No Deposit Harus diisi");
//          }
//        }
//        else{
          $this->session->set_flashdata('notice', "Nominal Angka Tidak Boleh Kosong");
//        }
        redirect("payment/inventory");
      }
      

      
     // print "<pre>";
    //  print_r($detail);
    //  print "</pre>"; die;
      if($detail_array->status % 2 == 0 AND $detail_array->status){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("payment/inventory");
      }
      else{
        $this->session->set_flashdata('notice', $detail_array->status.' Data tidak tersimpan');
        redirect("payment/inventory");
      }
    }
  }
  
  public function ttu_create($id_inventory){
    if(!$this->input->post(NULL)){
       
      $post_agent = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "status"            => 1
      );

      $pameran = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
      $pameran_array = json_decode($pameran);
      $pameran_drop[NULL] = '- Pilih -';
//      $this->debug($pameran, true);
      foreach($pameran_array->data AS $pp){
        $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d", strtotime($pp->date_start))."-".date("d M y", strtotime($pp->date_end));
      }

      $css = ""
  //      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>";

      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
        . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"

        ."<script type='text/javascript'>"
        . "$(function() { "
          . "$('.select2').select2();"
          . "$( '#tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
        . "</script> 
          <script>
  function FormatCurrency(objNum)
  {
     var num = objNum.value
     var ent, dec;
     if (num != '' && num != objNum.oldvalue)
     {
       num = MoneyToNumber(num);
       if (isNaN(num))
       {
         objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
       } else {
         var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
         if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
         {
          // alert(num.split('.')[1]);
           objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
         }
         else
         {
           objNum.value = AddCommas(num.split('.')[0]);
         }
         objNum.oldvalue = objNum.value;
       }
     }
  }
  function MoneyToNumber(num)
  {
     return (num.replace(/,/g, ''));
  }

  function AddCommas(num)
  {
     numArr=new String(num).split('').reverse();
     for (i=3;i<numArr.length;i+=3)
     {
       numArr[i]+=',';
     }
     return numArr.reverse().join('');
  } 

  function formatCurrency(num) {
     num = num.toString().replace(/\$|\,/g,'');
     if(isNaN(num))
     num = '0';
     sign = (num == (num = Math.abs(num)));
     num = Math.floor(num*100+0.50000000001);
     cents = num0;
     num = Math.floor(num/100).toString();
     for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
     num = num.substring(0,num.length-(4*i+3))+'.'+
     num.substring(num.length-(4*i+3));
     return (((sign)?'':'-') + num);
  }
  </script>";
//      $this->debug($detail_array, true);
      $this->template->build("ttu-create", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'payment/inventory',
              'title'       => lang("Payment TTU"),
              'book_code'   =>  $book_code,
              'data'        =>  $detail_array,
              'breadcrumb'  => array(
                  "book_list"  => "grouptour/product-tour/book-list"
                ),
              'css'         => $css,
              'foot'        => $foot,
              'pameran'     => $pameran_drop,
              'id_inventory'=> $id_inventory,
            ));
      $this->template
        ->set_layout('form')
        ->build("ttu-create");
    }
    else{
      $pst = $this->input->post(NULL);
//      $this->debug($pst, true);
      
      if($pst['nominal'] > 0){
          
          $paket = array(
            "users"           => USERSSERVER,
            "password"        => PASSSERVER,
            "nominal"         => str_replace(",","",$pst['nominal']),
            "tanggal"         => $pst['tanggal'],
            "id_tour_pameran" => $pst['id_tour_pameran'],
            "id_users"        => $this->session->userdata("id"),
            "id_inventory"    => $id_inventory,
            "type"            => $pst['type'],
            "remark"          => $pst['remark'],
            "khusus"          => 2,
            "id_store"        => $this->session->userdata("id_store"),
          );
          $detail = $this->global_variable->curl_mentah($paket, URLSERVER."json/json-tour/ttu-set");
          $detail_array = json_decode($detail);
          
           if($detail_array->status == 5){
              $this->session->set_flashdata('notice', "Gagal Insert, Users Session Anda sudah Habis, harap login Ulang");
              redirect("payment/ttu/{$id_inventory}");
          }
//          $this->debug($detail, true);

//		$kirim_info_customer = array(
//          "users"                     => USERSSERVER,
//          "password"                  => PASSSERVER,
//          "id_users"                  => $this->session->userdata("id"),
//          "code"                      => $pst['book_code'],
//		  "nominal"					  => $pst['nominal']
//        );
//        $this->global_variable->curl_mentah($kirim_info_customer, URLSERVER."json/json-mail/info-book-status-to-customer");	
 
      }
      else{
//        if(!$pst["no_ttu"]){
//          if(!$pst['no_deposit']){
//            $this->session->set_flashdata('notice', "No TTU atau No Deposit Harus diisi");
//          }
//        }
//        else{
          $this->session->set_flashdata('notice', "Nominal Angka Tidak Boleh Kosong");
//        }
        redirect("payment/ttu/{$id_inventory}");
      }
      

      
     // print "<pre>";
    //  print_r($detail);
    //  print "</pre>"; die;
      if($detail_array->status % 2 == 0 AND $detail_array->status){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("payment/ttu/{$id_inventory}");
      }
      else{
        $this->session->set_flashdata('notice', $detail_array->status.' Data tidak tersimpan');
        redirect("payment/ttu/{$id_inventory}");
      }
    }
  }
  
  function inventory(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . '<script type="text/javascript">'
      
      . 'var table = '
      . '$("#tableboxy").DataTable({'
        . '"order": [[ 0, "desc" ]]'
      . '});'
      . 'ambil_data(table, 0);'
      
      . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
            
       . "$(document).on('click', '#id-customer-cancel', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id').val(id);"
      . "});"
            
      . 'function ambil_data(table, mulai){'
        . "$.post('".site_url("payment/payment-ajax/inventory-get")."', {start: mulai, awal: '{$this->input->post("awal")}', akhir: '{$this->input->post("akhir")}'}, function(data){"
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.rows.add(hasil.hasil).draw();'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
          . '}'
        . '});'
      . '}'
      
    . '</script>';
    
    $this->template->build('inventory', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "payment/inventory",
          'data'          => $data_array->book,
          'title'         => lang("Inventory"),
          'foot'          => $foot,
          'css'           => $css,
          'post'          => $this->input->post(),
        ));
    $this->template
      ->set_layout("default")
      ->build('inventory');
  }
  
  function ttu($id_inventory){
    $post = array(
      "users"         => USERSSERVER,
      "password"      => PASSSERVER,
      "id_inventory"  => $id_inventory,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-ttu-get");  
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js'></script>"
      . '<script type="text/javascript">'
      
      . 'var table = '
      . '$("#tableboxy").DataTable({'
        . '"order": [[ 0, "desc" ]]'
      . '});'
      
    . '</script>';
    
    $this->template->build('ttu', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "payment/inventory",
          'data'          => $data_array->data,
          'title'         => lang("TTU"),
          'foot'          => $foot,
          'css'           => $css,
          'id_inventory'  => $id_inventory,
        ));
    $this->template
      ->set_layout("default")
      ->build('ttu');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */