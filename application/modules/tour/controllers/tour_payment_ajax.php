<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_payment_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function type_payment_add_row(){
    $html = "<hr />"
      . "<div class='row'>"
        . "<div class='col-xs-4'>"
          . "<label>Type</label>"
          . "<select class='form-control input-sm select2' name='type[]'>"
            . "<optgroup label='Tunai'>"
              . "<option value='1'>Tunai</option>"
            . "</optgroup>"
            . "<optgroup label='Transfer'>"
              . "<option value='3'>Transfer Mega</option>"
              . "<option value='2'>Transfer BCA</option>"
              . "<option value='4'>Transfer Mandiri</option>"
            . "</optgroup>"
            . "<optgroup label='Debit'>"
              . "<option value='7'>Debit BCA</option>"
              . "<option value='14'>Debit Mandiri</option>"
              . "<option value='15'>Debit BNI</option>"
            . "</optgroup>"
            . "<optgroup label='Kartu Kredit'>"
              . "<option value='9'>Kartu Kredit BCA</option>"
              . "<option value='5'>Kartu Kredit Mega</option>"
              . "<option value='11'>Kartu Kredit BNI</option>"
              . "<option value='12'>Kartu Kredit Mandiri</option>"
              . "<option value='13'>Kartu Kredit Citibank</option>"
              . "<option value='10'>Kartu Kredit Lainnya</option>"
            . "</optgroup>"
            . "<optgroup label='Others'>"
              . "<option value='16'>Travel Certificate</option>"
              . "<option value='17'>Travel Voucher</option>"
              . "<option value='18'>Voucher CT Corp</option>"
              . "<option value='19'>Point Rewards</option>"
              . "<option value='20'>Kupon</option>"
            . "</optgroup>"
          . "</select>"
        . "</div>"
        . "<div class='col-xs-4'>"
          . "<label>Nominal</label>"
          . "<input type='text' name='nominal[]' class='form-control input-sm harga' placeholder='Nominal'>"
        . "</div>"
        . "<div class='col-xs-2'>"
          . "<label>MDR</label>"
          . "<input type='text' name='mdr[]' class='form-control input-sm harga' placeholder='MDR'>"
        . "</div>"
        . "<div class='col-xs-2'>"
          . "<label>Status</label>&nbsp;"
        . "</div>"
      . "</div>"
      . "<div class='row'>"
        . "<div class='col-xs-4'>"
          . "<label>Card Number</label>"
          . "<input type='text' name='number[]' class='form-control input-sm' placeholder='Card Number'>"
        . "</div>"
        . "<div class='col-xs-4'>"
          . "<label>Tanggal</label>"
          . "<input type='text' name='tanggal[]' class='form-control input-sm tanggal' placeholder='Tanggal'>"
        . "</div>"
        . "<div class='col-xs-4'>"
          . "<label>Remarks</label>"
          . "<textarea name='remark[]' class='form-control input-sm' placeholder='Remarks'></textarea>"
        . "</div>"
      . "</div>"
      . "";
    print $html;
    die;
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
    $type = $this->global_variable->payment_type();
    foreach ($data_array->data AS $da){
      if($da->status > 0){
          $confirm = "";
          if(!empty($da->id_users_confirm)){
              $confirm = $this->global_models->get_field("m_users", "name", array("id_users" => "{$da->id_users_confirm}"));
          }
        
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
  
   function change_pameran(){
    $pst = $this->input->post();
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "id_users"    => $this->session->userdata("id"),
      "id_pameran"  => $pst['id_pameran'],
      "id"          => $pst['id'], 
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/change-pameran");  
    $data_array = json_decode($data);

//   
//    if($data_array->status == 3){
//      $return['status'] = 3;
//    }
//    elseif($data_array->status == 2){
//      $return['status'] = 2;
//     
//    }
    $return['status'] = $data_array->status;
    print json_encode($return);
    die;
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
//      if($da->status == 2){
        $button = "<div class='btn-group'>"
        . "<a href='".site_url("tour/tour-payment/ttu/{$da->id_product_tour_book_payment}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'>"
          . "<i class='fa fa-money'></i>"
        . "</a>"
        . "<a href='".site_url("store/print-store/ttu-kwitansi/{$da->id_product_tour_book_payment}")."' target='_blank' class='btn btn-info'>"
          . "<i class='fa fa-print'></i>"
        . "</a>"
        . "<a href='".site_url("store/print-store/ttu-kwitansi/{$da->id_product_tour_book_payment}/2")."' target='_blank' class='btn btn-warning'>"
          . "<i class='fa fa-print'></i>"
        . "</a>"
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