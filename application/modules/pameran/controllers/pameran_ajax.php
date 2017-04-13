<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pameran_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function master_pameran_get(){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "start"             => $pst['start'],
      "limit"             => 20,
      "order"             => "date_start DESC",
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-pameran");  
    $data_array = json_decode($data);
      
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->date_start,
        $da->date_end,
        "<a href='".site_url("pameran/transaksi/{$da->id_tour_pameran}")."'>{$da->title}</a>",
        $da->location,
        "<div style='text-align: right; width: 100%'>".number_format($da->nominal)."</div>",
      );
      $banding[] = $da->id_tour_pameran;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $start + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    print json_encode($return);
    die;
  }
  
  function transaksi_pameran_get(){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "start"             => $pst['start'],
      "limit"             => 20,
      "order"             => "tanggal DESC",
      "id_tour_pameran"   => $pst['id_tour_pameran'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-transaksi-pameran");  
    $data_array = json_decode($data);
//    $this->debug($data, true);
    $type = array(
      2 => "Tiket Maskapai",
      1 => "Group Tour",
      3 => "Voucher Hotel",
      4 => "Tiket Kereta Api",
      9 => "Lainnya",
    );
    $payment = array(
      1 => "Cash",
      2 => "BCA",
      3 => "Mega",
      4 => "Mandiri",
      5 => "CC"
    );
    $status = array(
      1 => "<span class='label label-warning'>Create</span>",
      2 => "<span class='label label-success'>Received</span>",
      3 => "<span class='label label-danger'>Rejected</span>",
    );
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->tanggal,
        $da->users,
        $type[$da->type],
        "{$da->no}<br />{$da->name}",
        "{$payment[$da->payment]}<br />{$status[$da->status]}",
        "<div style='width: 100%; text-align: right'>".number_format($da->nominal)."</div>",
      );
      $banding[] = $da->id_tour_pameran;
      $nominal[] = $da->nominal;
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $start + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    $return['nominal'] = $nominal;
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */