<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel extends MX_Controller {
  var $cookie_jar;
    
  function __construct() {      
    $this->load->library('mobile_detect');
    $this->load->library('encrypt');
  }
  function hotel_list(){
    $pst = $this->input->post();
    if($pst){
      $kirim = array(
        'users'             => USERSSERVER, 
        'password'          => PASSSERVER,
        "nation"            => $pst['nation'],
        "city"              => $pst['city'],
        "CheckIn"           => $pst['CheckIn'],
        "CheckOut"          => $pst['CheckOut'],
        "Sgl"               => $pst['Sgl'],
        "Dbl"               => $pst['Dbl'],
        "Trp"               => $pst['Trp'],
        "Twn"               => $pst['Twn'],
        "Quad"              => $pst['Quad'],
      );
      $data = $this->curl_mentah($kirim, URLSERVER."json/json-hotel/get-hotel-in-city");
      $data_array = json_decode($data);
      
      $set_session = array(
        "search_hotel_nation"            => $kirim['nation'],
        "search_hotel_city"              => $kirim['city'],
        "search_hotel_CheckIn"           => $kirim['CheckIn'],
        "search_hotel_CheckOut"          => $kirim['CheckOut'],
        "search_hotel_Sgl"               => $kirim['Sgl'],
        "search_hotel_Dbl"               => $kirim['Dbl'],
        "search_hotel_Trp"               => $kirim['Trp'],
        "search_hotel_Twn"               => $kirim['Twn'],
        "search_hotel_Quad"              => $kirim['Quad'],
      );
      $this->session->set_userdata($set_session);
      
//      $this->debug($data_array->hotel[0]->Name->$r, true);
      
      $foot = "<script>"
        . "function detail_hotel(hotelcode){"
          . "$('#list_harga'+hotelcode).show();"
          . "$('#id_loading_daftar'+hotelcode).show();"
          . "$.post('".site_url("hotel/ajax-hotel-detail")."', {HCode: hotelcode}, function(data){"
            . "$('#hasil_harga'+hotelcode).html(data);"
          . "});"
        . "}"
        . "$( document ).ajaxStop(function(){ "
          . "$( '.loading_daftar_harga' ).hide();"
        . "});"
        . "</script>";
      
      $this->template->build("hotel-list", 
        array(
          'url'         => base_url()."themes/antavaya/",
          'theme2nd'    => 'antavaya',
          'data'        => $data_array,
          'foot2'       => $foot
        ));
      $this->template
        ->set_layout('default')
        ->build("hotel-list");
    }
    else{
      redirect();
    }
  }
  
  function ajax_hotel_detail(){
    $kirim = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      "nation"            => $this->session->userdata('search_hotel_nation'),
      "city"              => $this->session->userdata('search_hotel_city'),
      "CheckIn"           => $this->session->userdata('search_hotel_CheckIn'),
      "CheckOut"          => $this->session->userdata('search_hotel_CheckOut'),
      "Sgl"               => $this->session->userdata('search_hotel_Sgl'),
      "Dbl"               => $this->session->userdata('search_hotel_Dbl'),
      "Trp"               => $this->session->userdata('search_hotel_Trp'),
      "Twn"               => $this->session->userdata('search_hotel_Twn'),
      "Quad"              => $this->session->userdata('search_hotel_Quad'),
      "HCode"             => $this->input->post('HCode'),
//      "HCode"             => "PHCEB_00082",
    );
    $data = $this->curl_mentah($kirim, URLSERVER."json/json-hotel/get-hotel-detail");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
//    $this->debug($tg, true);
    print "<tr>"
      . "<td>{$data_array->hotel->status}</td>"
      . "<td>{$data_array->hotel->room_grade}</td>"
      . "<td>{$data_array->hotel->meal}</td>"
      . "<td>$ ".  number_format($data_array->hotel->total,0,".",",")."</td>"
      . "<td><a href='javascript:void(0)'>Cancellation Policy</a></td>"
      . "<td>Book Now!</td>"
    . "</tr>"
        . "<script> $(function() { $('#harga_list<?php print $key?>').tooltipster({ content: $('#isiharga_list<?php print $key?>').html(), minWidth: 300, maxWidth: 300, contentAsHTML: true, interactive: true }); }); </script>";
    die;
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */