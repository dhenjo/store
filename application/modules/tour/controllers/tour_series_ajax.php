<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_series_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function tour_series_get(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "max"                 => 20,
      "status"              => $pst['status'],
      "code"                => $pst['code'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-series/tour-series-schedule-get");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $status = $this->global_variable->tour_schedule_status(1);
    $sales = $this->global_variable->tour_schedule_public_sales(1);
    if($data_array->status == 2){
      foreach ($data_array->data AS $key => $da){
        $hasil[] = array(
          $da->start_date,
          $da->end_date,
          $da->flt,
          $da->available_seat,
          $da->seat_update,
          "<div style='width: 100%; text-align: right'>".number_format($da->adult_triple_twin)."</div>",
          $status[$da->status],
          $sales[$da->umum],
          ""
          . "<a class='btn btn-primary' href='".site_url("tour/tour-series/schedule-detail/{$da->kode}")."'><i class='fa fa-pencil-square'></i></a>"
          . "",
        );
        $banding[] = $da->id_product_tour_information;
      }
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    $return['nomor'] = $no;
    print json_encode($return);
    die;
  }
  
  function tour_series_get_close_cancel(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "max"                 => 20,
      "status"              => $pst['status'],
      "code"                => $pst['code'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-series/tour-series-schedule-get");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $status = $this->global_variable->tour_schedule_status(1);
    if($data_array->status == 2){
      foreach ($data_array->data AS $key => $da){
        $hasil[] = array(
          $da->start_date,
          $da->flt,
          $da->seat_update,
          $status[$da->status],
          ""
          . "<a class='btn btn-primary' href='".site_url("tour/tour-series/schedule-detail/{$da->kode}")."'><i class='fa fa-pencil-square'></i></a>"
          . "",
        );
        $banding[] = $da->id_product_tour_information;
      }
    }
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 20;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    $return['nomor'] = $no;
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */