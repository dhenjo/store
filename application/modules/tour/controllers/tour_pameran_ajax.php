<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_pameran_ajax extends MX_Controller {
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
//    $this->debug($data_array, true);
    $temp = "";
    $urut = -1;
    $kode_type = array(
      1   => array("id" => "tunai", "col" => 7),
      3   => array("id" => "mega", "col" => 8),
      2   => array("id" => "bca", "col" => 9),
      4   => array("id" => "mandiri", "col" => 10),
      7   => array("id" => "dbca", "col" => 11),
      14  => array("id" => "dmandiri", "col" => 12),
      15  => array("id" => "dbni", "col" => 13),
      9   => array("id" => "ccbca", "col" => 14),
      5   => array("id" => "ccmega", "col" => 15),
      11  => array("id" => "ccbni", "col" => 16),
      12  => array("id" => "ccmandiri", "col" => 17),
      13  => array("id" => "cccity", "col" => 18),
      10  => array("id" => "cclain", "col" => 19),
      16  => array("id" => "certificate", "col" => 20),
      17  => array("id" => "voucher", "col" => 21),
      18  => array("id" => "ctcorp", "col" => 22),
      19  => array("id" => "point", "col" => 23),
      20  => array("id" => "kupon", "col" => 24),
    );
    foreach($data_array->data AS $key => $da){
      if($da->nominal > 0){
        if($temp == $da->no_ttu){
          $exe = $kode_type[$da->type];
          $hasil[$urut][$exe['col']] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
          $jumlah[$exe['id']] += $da->nominal;
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
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            "<div style='width: 100%; text-align: right'>0</div>",
            $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users_confirm)),
            nl2br($da->remark),
            "",
          );
          $exe = $kode_type[$da->type];
          $hasil[$urut][$exe['col']] = "<div style='width: 100%; text-align: right'>".  number_format($da->nominal)."</div>";
          $jumlah[$exe['id']] += $da->nominal;
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
  
  function cashier_report_get(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $pst['start'],
      "awal"                => $pst['awal'],
      "akhir"               => $pst['akhir'],
      "id_tour_pameran"     => $pst['id_tour_pameran'],
      "id_store"            => $pst['id_store'],
      "max"                 => 1000,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cashier-get");
    $data_array = json_decode($data);
//    $this->debug($data);
//    $this->debug($data_array, true);
    $temp = "";
    $urut = -1;
    $kode_type = $this->global_variable->payment_type();
    $jenis = array(
      1 => "Tiket",
      2 => "Hotel",
      3 => "Tour",
    );
    foreach($data_array->data AS $key => $da){
      if($da->nominal > 0){
        $no = $pst['nomor'] + $urut + 1;
        $urut++;
//        $book = explode("|", $da->book);
//        $temp = $da->no_ttu;
//        $key_temp = $urut;
        $jumlah[$da->type] += $da->nominal;
        $hasil[$urut] = array(
          $no,
          date("Y-m-d", strtotime($da->tanggal)),
          $da->no_ttu,
          $da->tour.$da->inventory,
          $da->store,
          $jenis[$da->jenis],
          $kode_type[$da->type],
          "<div style='width: 100%; text-align: right'>".number_format($da->nominal)."</div>",
          $this->global_models->get_field("m_users", "name", array("id_users" => $da->id_users_confirm)),
          $da->number,
        );
      }
    }
    
    $html = "<table class='table table-bordered table-hover'>"
        . "<thead>"
          . "<tr>"
            . "<th>Penerima</th>"
            . "<th>Total</th>"
          . "</tr>"
        . "</thead>"
        . "<tbody>";
    foreach($jumlah AS $key => $yh){
      $html .= "<tr>"
          . "<td>{$kode_type[$key]}</td>"
          . "<td style='text-align: right'>".number_format($yh)."</td>"
        . "</tr>"
        . "";
      $total += $yh;
    }
    $html .= "</tbody>"
        . "<tfoot>"
          . "<tr>"
            . "<th>TOTAL</th>"
            . "<th style='text-align: right'>".number_format($total)."</th>"
          . "</tr>"
        . "</tfoot>"
      . "</table>"
      . "";
    
    if(!$hasil){
      $return['status'] = 3;
    }
    else{
      $return['status'] = 2;
      $return['start']  = $pst['start'] + 1000;
    }
    $return['hasil'] = $hasil;
    $return['banding'] = $banding;
    $return['html'] = $html;
    $return['nomor'] = $no;
    print json_encode($return);
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */