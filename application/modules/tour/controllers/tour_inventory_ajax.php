<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_inventory_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
    function get_tour_product($start = 0, $id_inventory = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "start_date"          => $this->session->userdata("tour_search_start"),
      "end_date"            => $this->session->userdata("tour_search_end"),
      "status"              => $this->session->userdata("tour_search_status"),
      "code"                => $this->session->userdata("tour_search_kode"),
      "no_pn"               => $this->session->userdata("tour_search_no_pn"),
      "title"               => $this->session->userdata("tour_search_title"),
      "category_product"    => $this->session->userdata("tour_search_category_product"),
      "id_store_region"     => $this->session->userdata("tour_search_id_store_region"),
      "destination"         => $this->session->userdata("tour_search_destination"),
      "landmark"            => $this->session->userdata("tour_search_landmark"),
      "sub_category"        => $this->session->userdata("tour_search_sub_category"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-product-search");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-success'>Available</span>",
      5 => "<span class='label label-warning'>Push Selling</span>",
    );
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    $kategori = array(
      1 => "<span class='label label-success'>Viesta</span>",
      2 => "<span class='label label-warning'>Premium</span>",
    );
    
    foreach ($data_array->data AS $da){
	    
	    if($da->at_airport_date != "0000-00-00" AND $da->at_airport_date != ""){
            $date_start = $da->at_airport_date;
        }else{
            $date_start = $da->start_date;
        }
        
      $hasil[] = array(
        $status[$da->status_info],
        "<span style='display: none'>{$date_start}</span>"
        . "<a class='tooltip-harga' isi='{$da->kode_info}' href='".site_url("tour/tour-inventory/book-tour/{$id_inventory}/".$da->kode_info)."'>"
          . date("d M y", strtotime($date_start))
        . "</a>",
        "<span style='display: none'>{$da->end_date}</span>".date("d M y", strtotime($da->end_date)),
        "<a class='tooltip-title' isi='{$da->kode_info}' target='_blank' href='".site_url("tour/tour-inventory/tour-detail/{$id_inventory}/".$da->kode)."'>".$da->title."</a>"
          . "<br />".$region[$da->sub_category]
          . "<br />".$kategori[$da->category_product],
        $da->no_pn,
        $da->flt,
        $da->days,
        $da->available_seat,
        $da->book,
        $da->conf,
        "<a href='".site_url("tour/tour-inventory/list-tour-book-umum/{$id_inventory}/{$da->kode_info}")."'>".($da->available_seat - $da->conf)."</a>",
        number_format($da->adult_triple_twin),
        number_format($da->airport_tax),
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  
    function load_tooltip_harga_tour($id_inventory,$code){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-tour-information-harga");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $html = ""
      . "<table width='100%'>"
        . "<tbody>"
          . "<tr>"
            . "<td>Tour Code</td>"
            . "<td style='text-align: left'>{$data_array->data[0]->kode}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Adult Triple/Twin</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->adult_triple_twin)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child Twin Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_twin_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child Extra Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_extra_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child No Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_no_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>SGL SUPP</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->sgl_supp)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Airport Tax &amp; Flight Insurance</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->airport_tax)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td colspan='2'>"
              . "<center>"
                . "<a href='".site_url("tour/tour-inventory/book-tour/{$id_inventory}/".$data_array->data[0]->kode)."' class='btn btn-primary'>BOOK</a>"
              . "</center>"
            . "</td>"
            . "<td></td>"
          . "</tr>"
        . "</tbody>"
      . "</table>";
    print $html;
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */