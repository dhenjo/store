<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function tour_payment_get(){
    $pst = $this->input->post();
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $pst['start'],
      "max"         => 20,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-get");  
    $data_array = json_decode($data);
//    $this->debug($data, true);
    $status = array(
      0 => "<label class='label label-primary'>Create</label>",
      1 => "<label class='label label-danger'>Rejected</label>",
      NULL => "<label class='label label-primary'>Create</label>",
      2 => "<label class='label label-success'>Accepted</label>",
    );
    $type = array(
      1 => "Tunai", 
      2 => "Transfer BCA", 
      3 => "Transfer Mega", 
      4 => "Transfer Mandiri", 
      5 => "CC Mega", 
      7 => "Debit BCA", 
      8 => "Debit Lainnya", 
      9 => "CC BCA", 
      10 => "CC Lainnya"
    );
    foreach ($data_array->data AS $da){
      if($da->status > 0){
        $confirm = $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users_confirm));
        $button = nl2br($da->note);
      }
      else{
        $button = "<div class='btn-group'>"
        . "<a href='".site_url("tour/tour-payment/payment-confirm/{$da->id_tour_payment}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'>"
          . "<i class='fa fa-check'></i>"
        . "</a>"
        . "<button type='button' class='btn btn-danger tour-payment-delete' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$da->id_tour_payment}' class='btn btn-danger' id='id-customer-cancel'>"
          . "<i class='fa fa-times'></i>"
        . "</button>"
//        . "<a href='".site_url("mrp/mrp-inventory/add-mutasi-pabrik/{$da->id_mrp_mutasi}")."' type='button' class='btn btn-danger btn-flat' style='width: 40px'>"
//          . "<i class='fa fa-times'></i>"
//        . "</a>"
      . "</div>";
      }
      $hasil[] = array(
        $da->tanggal,
        $da->no_ttu,
        $type[$da->type],
        $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users)),
        "<div style='text-align: right; width: 100%'>".  number_format($da->nominal)."</div>",
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
  
  function inventory_get(){
    $pst = $this->input->post();
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $pst['start'],
      "max"         => 20,
      "mulai"       => ($pst['awal'] ? $pst['awal'] : date("Y-m-01"))." 00:00:00",
      "akhir"       => ($pst['akhir'] ? $pst['akhir'] : date("Y-m-t"))." 23:59:59",
      "id_store"    => $this->session->userdata("id_store"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-get");  
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $status = $this->global_variable->inventory_status(1);
    $type = array(
      1 => "Tiket",
      2 => "Hotel",
      3 => "Tour",
      4 => "Umroh",
      5 => "Transport"
    );
    foreach ($data_array->data AS $da){
      $payment = explode("|", $da->id_product_tour_book_payment);
      $button = "";
//      if($da->status == 2){
//        $button = "<div class='btn-group'>"
//        . "<a target='_blank' href='".site_url("store/print-store/ttu-indie/{$da->id_ttu}")."' type='button' class='btn btn-warning btn-flat'>"
//          . "<i class='fa fa-search'></i>"
//        . "</a>"
//        . "<a href='".site_url("tour/tour-payment/ttu/{$payment[0]}")."' type='button' class='btn btn-success btn-flat'>"
//          . "<i class='fa fa-money'></i>"
//        . "</a>"
//      . "</div>";
      $btn_search = "";
      if($da->type == 3 AND $da->id_users == $this->session->userdata("id")){
          if($da->status > 1){
          $btn_search =  "<a href='".site_url("tour/tour-inventory/search/{$da->id_inventory}")."' target='_blank' title='Search Tour' class='btn btn-success' style='width: 40px'>"
        . "<i class='fa fa-search'></i>"
        . "</a>" ;
          }
      }
      
      if($da->flag_book == 1){
          $btn_search =  "<a href='".site_url("grouptour/product-tour/book-information/{$da->kode}")."' target='_blank' title='Search Tour' class='btn btn-success' style='width: 40px'>"
        . "<i class='fa fa-search'></i>"
        . "</a>" ;
      }
      
      $del = "";
      if($da->id_users == $this->session->userdata("id")){
        if($da->status == 1){
            $del = "<a href='#' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$da->id_inventory}' class='btn btn-danger' id='id-customer-cancel' style='width: 40px'>"
            . "<i class='fa fa-trash-o'></i>"
          . "</a>";
        }
      }
        $button = "<div class='btn-group'>"
        . "<a href='".site_url("payment/ttu/{$da->id_inventory}")."' type='button' class='btn btn-warning btn-flat'>"
          . "TTU"
        . "</a>"
        . $del
        . $btn_search        
      . "</div>";
//      }
      $hasil[] = array(
        $da->tanggal,
        $type[$da->type],
        $da->title,
        $da->kode,
        $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users)),
        "<div style='text-align: right; width: 100%'>".  number_format($payment[1])."</div>",
        $status[$da->status],
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