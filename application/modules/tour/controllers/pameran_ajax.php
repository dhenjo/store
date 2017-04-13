<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pameran_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function finance_report_get(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "awal"                => $pst['awal'],
      "akhir"               => $pst['akhir'],
      "id_tour_pameran"     => $pst['id_tour_pameran'],
      "id_store"            => $pst['id_store'],
      "max"                 => 50,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-ttu-get");
    $data_array = json_decode($data);
    $temp = "";
    $urut = -1;
    foreach($data_array->data AS $key => $da){
      if($da){
        if($temp == $da->no_ttu){
          if($da->type == 1){
            $hasil[$urut][7] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['cash'] += $da->nominal;
          }
          if($da->type == 2){
            $hasil[$urut][8] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['bca'] += $da->nominal;
          }
          if($da->type == 4){
            $hasil[$urut][9] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['mandiri'] += $da->nominal;
          }
          if($da->type == 3){
            $hasil[$urut][10] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['mega'] += $da->nominal;
          }
          if($da->type == 5){
            $hasil[$urut][12] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['ccmega'] += $da->nominal;
          }
          if($da->type == 9 OR $da->type == 10){
            $hasil[$urut][13] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['cclainnya'] += $da->nominal;
          }
          if($da->type == 7 OR $da->type == 8){
            $hasil[$urut][14] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['debit'] += $da->nominal;
          }
        }
        else{
          $no = $pst['nomor'] + $urut + 1;
          $urut++;
          $book = explode("|", $da->book);
          $temp = $da->no_ttu;
          $key_temp = $urut;
          $hasil[$urut] = array(
            $no,
            date("Y-m-d", strtotime($da->tanggal)),
            $da->no_ttu,
            $book[0],
            $da->store,
            $book[2]." ".$book[3],
            $da->no_deposit,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            "",
            $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users_confirm)),
            nl2br($da->remark),
            "",
          );
          if($da->type == 1){
            $hasil[$urut][7] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['cash'] += $da->nominal;
          }
          if($da->type == 2){
            $hasil[$urut][8] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['bca'] += $da->nominal;
          }
          if($da->type == 4){
            $hasil[$urut][9] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['mandiri'] += $da->nominal;
          }
          if($da->type == 3){
            $hasil[$urut][10] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['mega'] += $da->nominal;
          }
          if($da->type == 5){
            $hasil[$urut][12] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['ccmega'] += $da->nominal;
          }
          if($da->type == 9 OR $da->type == 10){
            $hasil[$urut][13] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['cclainnya'] += $da->nominal;
          }
          if($da->type == 7 OR $da->type == 8){
            $hasil[$urut][14] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
            $jumlah['debit'] += $da->nominal;
          }
        }
      }
    }
    
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 50;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    $return['jumlah'] = $jumlah;
    $return['nomor'] = $no;
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */