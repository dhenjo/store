<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function sales_view_get(){
    $pst = $this->input->post();
    $hasil = array();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "max"                 => 20,
      "year"                => $pst['year'],
      "id_store_region"     => $this->session->userdata("tour_search_id_store_region"),  
      "sub_category"        => $pst['cate'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/master-tour-get");
    $data_array = json_decode($data);
    
    if($data_array->status == 2 AND $data_array->data){
      foreach($data_array->data AS $data){
        $start_time = explode(":", $data->start_time);
        $end_time = explode(":", $data->end_time);
        if($data->at_airport){
            $airport_date = date("dM", strtotime($data->at_airport_date));
            $at_airport = explode(":", $data->at_airport);
            $airport = $airport_date."<br>".$at_airport[0].":".$at_airport[1];
        }else{
            $airport    = "at airport";
        }
        
        
        $adult_triple_twin = (($data->adult_triple_twin/1000000) > 0 ? number_format(($data->adult_triple_twin/1000000),2)." Jt": 'N/A');
        $child_twin_bed = (($data->child_twin_bed/1000000) > 0 ? number_format(($data->child_twin_bed/1000000),2)." Jt": 'N/A');
        $child_extra_bed = (($data->child_extra_bed/1000000) > 0 ? number_format(($data->child_extra_bed/1000000),2)." Jt": 'N/A');
        $child_no_bed = (($data->child_no_bed/1000000) > 0 ? number_format(($data->child_no_bed/1000000),2)." Jt": 'N/A');
        $sgl_supp = (($data->sgl_supp/1000000) > 0 ? number_format(($data->sgl_supp/1000000),2)." Jt": 'N/A');
        $airport_tax = (($data->airport_tax/1000000) > 0 ? number_format(($data->airport_tax/1000000),2)." Jt": 'N/A');
//        ar airport
        
        $hasil['data'][] = array(
          "title"               => $data->title,
          "days"                => $data->days,
          "no_pn"               => $data->no_pn,
          "start_date"          => date("d M", strtotime($data->start_date)),
          "start_time"          => $start_time[0].":".$start_time[1],
          "end_date"            => date("d M", strtotime($data->end_date)),
          "end_time"            => $end_time[0].":".$end_time[1],
          "flt"                 => $data->flt,
          "available_seat"      => $data->available_seat,
          "sts"                 => $data->sts,
          "in"                  => $data->in,
          "out"                 => $data->out,
          "adult_triple_twin"   => $adult_triple_twin,
          "child_extra_bed"     => $child_extra_bed,
          "child_twin_bed"      => $child_twin_bed,
          "child_no_bed"        => $child_no_bed,
          "sgl_supp"            => $sgl_supp,
          "airport_tax"         => $airport_tax,
          "at_airport"          => $airport,  
          "status"              => $data->status,
          "code2"               => $data->kode,
          "code1"               => $data->kode2,
          "dp"                  => ($data->seat_update > 0 ? $data->seat_update : 0),
          "pax"                 => ($data->pax_book > 0 ? $data->pax_book : 0),
        );
      }
      $hasil['status'] = 2;
      $hasil['start'] = $pst['start'] + 20;
    }
    else{
      $hasil['status'] = 3;
    }
//    $this->debug($data, true);
    print json_encode($hasil);
    die;
  }
  
  function tour_series_open_get(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "awal"                => $pst['awal'],
      "akhir"               => $pst['akhir'],
      "max"                 => 20,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-open");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    if($data_array->status == 2){
      foreach ($data_array->data AS $key => $da){
        $no = $pst['nomor'] + $key;
        $hasil[] = array(
          $no,
          $da->title,
          $da->start_date,
          $da->tpax,
          $da->flt,
          ""
          . "<button type='button' isi='{$da->kode}' class='btn btn-success close-tour btn-hide{$da->kode}'><i class='fa fa-plane'></i></button>"
          . "<a href='".site_url("tour/tour-series/cancel-tour-information/{$da->kode}")."' class='btn btn-danger'><i class='fa fa-times'></i></a>"
          . "",
        );
        $banding[] = $da->kode;
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
  
  function tour_series_close_get(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "awal"                => $pst['awal'],
      "akhir"               => $pst['akhir'],
      "max"                 => 20,
      "status"              => 4,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-open");
    $data_array = json_decode($data);
    
    $storepost = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $store = $this->global_variable->curl_mentah($storepost, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($store);
//    $this->debug($store_array, true);
    if($data_array->status == 2){
      foreach ($data_array->data AS $key => $da){
        $leader = ($da->leader ? $da->leader : "No TL");
        $infopost = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "id_product_tour_information" => $da->id_product_tour_information,
        );
        $info = $this->global_variable->curl_mentah($infopost, URLSERVER."json/json-tour/tour-series-info-book-get");
        $info_array = json_decode($info);
//        $this->debug($info, true);
        
        $no = $pst['nomor'] + $key;
        $hasil[$key] = array(
          $no,
          $da->title."<br />".$leader,
          $da->start_date,
          $da->tpax,
          $da->flt,
        );
        $jml = array();
        foreach($info_array->data AS $ia){
          $harga = explode("|", $ia->tpax);
          $tharga = ($harga[1]+$harga[2]+$harga[3]+$harga[4]+$harga[5]);
          $hasil[$key][] = $harga[0]."<br />".number_format($tharga);
          $jml[] = array(
            "pax" => $harga[0],
            "harga" => $tharga,
            "id"  => $ia->id_store
          );
        }
        $banding[$key] = $da->kode;
        $jumlah[$key] = $jml;
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
    $return['jumlah'] = $jumlah;
    $return['nomor'] = $no;
    print json_encode($return);
    die;
  }
  
  function tour_series_open_cancel(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $pst['kode'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cancel");
    $data_array = json_decode($data);
    print $data_array->status;die;
  }
  
  function tour_series_open_close(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $pst['kode'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-close");
    $data_array = json_decode($data);
    print $data_array->status;die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */