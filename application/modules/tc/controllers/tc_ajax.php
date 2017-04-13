<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tc_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
    function product_tour_book_payment_get(){
    $pst = $this->input->post();
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $pst['start'],
      "max"         => 20,
      "mulai"       => $pst['mulai']." 00:00:00",
      "akhir"       => $pst['akhir']." 23:59:59",
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/product-tour-book-payment-get");  
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $status = array(
      3 => "<label class='label label-danger'>Rejected</label>",
      4 => "<label class='label label-success'>Confirm</label>",
      2 => "<label class='label label-primary'>Create</label>",
    );
    $type = array(
      1 => "Tiket",
      2 => "Hotel",
      3 => "Tour",
      4 => "Umroh",
      5 => "Transport"
    );
    foreach ($data_array->data AS $da){
      $button = "";
      $del = "";
      if($da->status != 4){
        if($da->id_users == $this->session->userdata("id")){
          $del = "<a href='#' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$da->id_product_tour_book_payment}' class='btn btn-danger' id='id-customer-cancel' style='width: 40px'>"
          . "<i class='fa fa-trash-o'></i>"
        . "</a>";
        }
      }else{
          $del = "";
      }
      
      $ttu = "";
      if($da->status != 3){
          $ttu = "<a href='".site_url("tour/tour-payment/ttu/{$da->id_product_tour_book_payment}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'>"
          . "<i class='fa fa-money'></i>"
        . "</a>";
      }
      
//      if($da->status == 2){
        $button = "<div class='btn-group'>"
        . "<a href='".site_url("store/print-store/ttu-indie/{$da->id_product_tour_book_payment}")."' type='button' class='btn btn-warning btn-flat' style='width: 40px'>"
          . "<i class='fa fa-search'></i>"
        . "</a>"        
        . $ttu
        . "<a href='".site_url("store/print-store/ttu-kwitansi/{$da->id_product_tour_book_payment}")."' target='_blank' class='btn btn-info' style='width: 40px'>"
          . "<i class='fa fa-print'></i>"
        . "</a>"
        . $del
      . "</div>";
//      }
      
      $hasil[] = array(
        $da->tanggal,
        $type[$da->type],
        ($da->code ? $da->code : $da->kode),
        $da->no_ttu,
        $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users)),
        "<div style='text-align: right; width: 100%'>".  number_format($da->nominal)."</div>"
        . "<div style='text-align: right; width: 100%'><i>".  number_format(($da->debit - $da->kredit))."</i></div",
        $status[$da->status]."<br />{$confirm}",
        $button,
      );
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */