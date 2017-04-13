<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class generate_price extends MX_Controller {
    
  function __construct() {      
    
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
  
  public function index($kode_book){
    
    $kirim_data = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $kode_book,
              
        );
   
       $discount_detail = $this->curl_mentah($kirim_data, URLSERVER."json/json-generate/total-price");
       $discount_array = json_decode($discount_detail);
      
       if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Generate Harga');
      }else{
         $this->session->set_flashdata('notice', 'Gagal Generate Harga');
      }
      redirect("grouptour/product-tour/book-information/{$kode_book}");
  }
  
  public function ppn($kode_book){
   
    $kirim_data = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $kode_book,
              
        );
  
       $discount_detail = $this->curl_mentah($kirim_data, URLSERVER."json/json-generate/total-price-ppn");
       $discount_array = json_decode($discount_detail);
      
       if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Generate Harga ppn');
      }else{
         $this->session->set_flashdata('notice', 'Gagal Generate Harga ppn');
      }
      redirect("grouptour/product-tour/book-information/{$kode_book}");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */