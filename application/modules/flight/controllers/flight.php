<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  public function book(){
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
    $list = $this->global_models->get_query("SELECT A.*, B.dari, B.ke, C.dari AS dr, C.ke AS k, A.harga_bayar AS bayar, D.hemat"
      . " FROM tiket_book AS A"
      . " LEFT JOIN tiket_flight AS B ON A.id_tiket_flight = B.id_tiket_flight"
      . " LEFT JOIN tiket_flight AS C ON A.id_tiket_flight2nd = C.id_tiket_flight"
      . " LEFT JOIN website_hemat_mega AS D ON A.id_website_hemat_mega = D.id_website_hemat_mega"
      . " GROUP BY A.book_code"
      . " ORDER BY (A.price+A.child-A.infant) ASC");
    $this->template->build('book', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "flight/book",
            'data'        => $list,
            'title'       => lang("antavaya_flight_book"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc',
            'css'         => $css,
            'foot'        => $foot,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('book');
  }
  
  public function book_store(){
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
    ."<script type='text/javascript'>"
      . "$(function() { "
        . "$( '#start_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
        . "$( '#end_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
      . "}); "
    . "</script> ";
//    if($this->session->userdata("flight_book_store_search") == true){
    $pst = $this->input->post();
    if($pst){
      $set_sess = array(
        "flight_book_store_booking_from"      => $pst['booking_from'],
        "flight_book_store_book_code"         => $pst['book_code'],
        "flight_book_store_booking_to"        => $pst['booking_to'],
        "flight_book_store_pemesan"           => $pst['pemesan'],
      );
      $this->session->set_userdata($set_sess);
    }
    if($this->session->userdata("flight_book_store_booking_from") AND $this->session->userdata("flight_book_store_booking_to")){
      $search_range = "AND (A.tanggal BETWEEN '".$this->session->userdata("flight_book_store_booking_from")."'"
        . " AND '".$this->session->userdata("flight_book_store_booking_to")."')";
    }
    else{
      $search_range = "AND (A.tanggal BETWEEN '".date("Y-m-")."01 00:00:00' AND '".date("Y-m-t")." 23:59:59')";
    }
    
    if($this->session->userdata("flight_book_store_book_code")){
      $search_book_code = "AND LOWER(A.book_code) LIKE '%{$this->session->userdata("flight_book_store_book_code")}%'";
    }
    else{
      $search_book_code = "";
    }
    
    if($this->session->userdata("flight_book_store_pemesan")){
      $search_pemesan = "AND (LOWER(A.email) LIKE '%{$this->session->userdata("flight_book_store_pemesan")}%'"
      . " OR LOWER(A.first_name) LIKE '%{$this->session->userdata("flight_book_store_pemesan")}%'"
      . " OR LOWER(A.last_name) LIKE '%{$this->session->userdata("flight_book_store_pemesan")}%')"
      . "";
    }
    else{
      $search_pemesan = "";
    }
    
    $list = $this->global_models->get_query("SELECT A.*, B.dari, B.ke, C.dari AS dr, C.ke AS k, A.harga_bayar AS bayar, D.hemat"
      . " FROM tiket_book AS A"
      . " LEFT JOIN tiket_flight AS B ON A.id_tiket_flight = B.id_tiket_flight"
      . " LEFT JOIN tiket_flight AS C ON A.id_tiket_flight2nd = C.id_tiket_flight"
      . " LEFT JOIN website_hemat_mega AS D ON A.id_website_hemat_mega = D.id_website_hemat_mega"
      . " WHERE A.id_users = '{$this->session->userdata("id")}'"
      . " {$search_range}"
      . " {$search_book_code}"
      . " {$search_pemesan}"
      . " GROUP BY A.book_code"
      . " ORDER BY (A.price+A.child-A.infant) ASC");
//    }
    
    $date_form = $this->form_eksternal->form_input('booking_from', $this->session->userdata('flight_book_store_booking_from'), 'id="start_date" class="form-control input-sm" placeholder="Start Date"');
    $book_code = $this->form_eksternal->form_input('book_code', $this->session->userdata('flight_book_store_book_code'), 'class="form-control" placeholder="Book Code"');
    
    $date_to = $this->form_eksternal->form_input('booking_to', $this->session->userdata('flight_book_store_booking_to'), 'id="end_date" class="form-control input-sm" placeholder="End Date"');
    
    $pemesan = $this->form_eksternal->form_input('pemesan', $this->session->userdata('flight_book_store_pemesan'), 'class="form-control" placeholder="Pemesan"');
    
    $before_table = $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => "")).""
      . "<div class='box-body col-sm-6'>"
        . "<div class='control-group'>"
          . "<label>Start Date</label>"
          . "{$date_form}"
        . "</div>"
        . "<div class='control-group'>"
          . "<label>Book Code</label>"
          . "{$book_code}"
        . "</div>"
      . "</div>"
      . "<div class='box-body col-sm-6' >"
        . "<div class='control-group'>"
          . "<label>End Date</label>"
          . "{$date_to}"
        . "</div>"
        . "<div class='control-group'>"
          . "<label>Pemesan</label>"
          . "{$pemesan}"
        . "</div>"
      . "</div>"
      . "<div class='box-body col-sm-6'>"
        . "<div class='box-footer'>"
          . "<button class='btn btn-primary' type='submit'>Search</button>"
        . "</div>"
      . "</div>"
      . "</form>"
      . "<br />";

    $this->template->build('book-store', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "flight/book-store",
            'data'        => $list,
            'title'       => lang("antavaya_flight_book"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc',
            'css'         => $css,
            'foot'        => $foot,
            'before_table' => $before_table,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('book-store');
  }
  
  function report_transaksi($sort = 1,$field = ""){
      $pst = $this->input->post(NULL, TRUE);
      if($pst){
        $set_sess = array(
          "flight_report_transaksi_book_code" => $pst['book_code'],
          "flight_report_transaksi_payment" => $pst['payment'],
          "flight_report_transaksi_booking_from" => $pst['booking_from'],
          "flight_report_transaksi_booking_to" => $pst['booking_to'],
        );
        $this->session->set_userdata($set_sess);
      }
     
        $where = " AND 1=1 ";
      if($this->session->userdata('flight_report_transaksi_book_code')){
          $where .= " AND A.book_code LIKE '%{$this->session->userdata('flight_report_transaksi_book_code')}%' ";
      }
      if($this->session->userdata('flight_report_transaksi_payment')){
          $where .= " AND A.cara_bayar LIKE '%{$this->session->userdata('flight_report_transaksi_payment')}%' ";
      }
      if($this->session->userdata('flight_report_transaksi_booking_from')){
          $where .= " AND A.tanggal >= '{$this->session->userdata('flight_report_transaksi_booking_from')}' ";
      }
      else{
        $where .= " AND A.tanggal >= '".date("Y-m")."-01' ";
      }
      if($this->session->userdata('flight_report_transaksi_booking_to')){
          $where .= " AND A.tanggal <= '{$this->session->userdata('flight_report_transaksi_booking_to')}' ";
      }
      else{
        $where .= " AND A.tanggal <= '".date("Y-m-t")."' ";
      }
//     $search = array("book_code" => $pst['book_code'],
//         "payment" => $pst['payment'],
//         "booking_from" => $pst['booking_from'],
//         "booking_to" => $pst['booking_to']);
     
      $cra_byar =array("0" => "All",
                    "MEGA CC" => "MEGA CC",
                     "MEGAFIRST" => "MEGAFIRST",
                     "BCA" => "BCA"
          );
      
//    if($bln == 100){
//      $bln = date("m");
//    }
//    if($thn == 1111){
//      $thn = date("Y");
//    }
    
    if($sort == 1){
          $sort = "ASC";
      }elseif ($sort == 2) {
            $sort = "DESC";
        }
        if($field == 1){
            $field = "tanggal";
        }elseif($field == 2){
            $field = "price";
        }elseif($field == 3){
            $field = "infant";
        }elseif($field == 4){
            $field = "id_website_hemat_mega";
        }elseif($field == 5){
            $field = "harga_bayar";
        }elseif($field == 6){
            $field = "hpp";
        }else{
            $field = "";
        }
        
      if($field){
          $orderby = " ORDER BY A.".$field." ".$sort;
      }else{
          $orderby = " ORDER BY A.tanggal";
      }
    

    $css = ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
            ."<script type='text/javascript'>"
      . "$(function() { "
        . "$( '#start_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
        . "$( '#end_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
      . "}); "
      . "</script> ";
    
    $report = $this->global_models->get_query("SELECT A.price, A.child, A.infant"
      . " , A.tanggal, A.book_code, A.tiket_no, A.tiket_no2nd, A.cara_bayar, A.id_website_hemat_mega"
      . " , A.hpp, A.hpp2nd, A.harga_bayar, A.harga_bayar2nd"
      . " FROM tiket_book AS A"
      . " WHERE A.status = 3".$where
//      . " AND (tanggal BETWEEN '".date("Y-m", strtotime("{$thn}-{$bln}"))."-01' AND '".date("Y-m-t", strtotime("{$thn}-{$bln}-01"))."')"
      . " GROUP BY A.book_code"
      . $orderby );
    $this->template->build('report-transaksi', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "flight/report-transaksi",
            'data'        => $report,
            'title'       => lang("antavaya_report_transaksi"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc',
            'css'         => $css,
            'foot'        => $foot,
            'type_payment' => $cra_byar,
//            'sort'        => $sort,
//            'serach_data'   => $search,
            'before_table' => $before_table,
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('report-transaksi');
  }
  
  function report_transaksi_store($sort = 1,$field = ""){
      $pst = $this->input->post(NULL, TRUE);
      if($pst){
        $set_sess = array(
          "flight_report_transaksi_store_book_code" => $pst['book_code'],
          "flight_report_transaksi_store_booking_from" => $pst['booking_from'],
          "flight_report_transaksi_store_booking_to" => $pst['booking_to'],
        );
        $this->session->set_userdata($set_sess);
      }
     
        $where = " AND 1=1 ";
      if($this->session->userdata('flight_report_transaksi_store_book_code')){
          $where .= " AND A.book_code LIKE '%{$this->session->userdata('flight_report_transaksi_store_book_code')}%' ";
      }
      if($this->session->userdata('flight_report_transaksi_store_booking_from')){
          $where_tanggal .= " AND B.tanggal >= '{$this->session->userdata('flight_report_transaksi_store_booking_from')}' ";
      }
      else{
        $where_tanggal .= " AND B.tanggal >= '".date("Y-m")."-01' ";
      }
      if($this->session->userdata('flight_report_transaksi_store_booking_to')){
          $where_tanggal .= " AND B.tanggal <= '{$this->session->userdata('flight_report_transaksi_store_booking_to')}' ";
      }
      else{
        $where_tanggal .= " AND B.tanggal <= '".date("Y-m-t")."' ";
      }
     
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
            ."<script type='text/javascript'>"
      . "$(function() { "
        . "$( '#start_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
        . "$( '#end_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
      . "}); "
      . "</script> ";
    
    $report = $this->global_models->get_query("SELECT B.tanggal, B.saldo, A.book_code, A.tiket_no, B.pos, B.type, C.name"
      . " FROM tiket_setor_agent AS B"
      . " LEFT JOIN tiket_book AS A ON A.id_tiket_book = B.id_tiket_book"
      . " LEFT JOIN m_users AS C ON B.create_by_users = C.id_users"
      . " WHERE B.id_users = '{$this->session->userdata("id")}'" .$where_tanggal
      . " ORDER BY B.tanggal ASC");
//    $this->debug($report, true);
    $report_all = $this->global_models->get_query("SELECT SUM(CASE WHEN pos = 1 THEN saldo ELSE 0 END) AS debit,"
      . " SUM(CASE WHEN pos = 2 THEN saldo ELSE 0 END) AS kredit"
      . " FROM tiket_setor_agent AS B"
      . " WHERE B.id_users = '{$this->session->userdata("id")}'");
    $this->template->build('report-transaksi-agent', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "flight/report-transaksi-store",
            'data'        => $report,
            'report_all'  => $report_all,
            'title'       => lang("antavaya_report_transaksi"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc',
            'css'         => $css,
            'foot'        => $foot,
            'type_payment' => $cra_byar,
            'before_table' => $before_table,
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('report-transaksi-agent');
  }
  
  function issued_store($id_tiket_book){
    $tiket_book = $this->global_models->get("tiket_book", 
      array("id_tiket_book" => $id_tiket_book, "id_users" => $this->session->userdata("id"), "status" => 1));
    if($tiket_book){
      $kirim = array(
        'users'             => USERSSERVER, 
        'password'          => PASSSERVER,
//        "book_code"         => $tiket_book[0]->book_code,
      );

      $data = $this->curl_mentah($kirim, URLSERVER."json/issued");
      $data_array = json_decode($data);
      if($data_array->status == 1){
//      if($data_array->status == 2){
        $ft = $this->curl_mentah(array(), site_url("flight/flight-umum/status-tiket-single/{$tiket_book[0]->book_code}"));
        $new = $this->global_models->get("tiket_book", array("id_tiket_book" => $tiket_book[0]->id_tiket_book));
//        if($new[0]->status == 3){
          $this->global_models->update("tiket_book", array("id_tiket_book" => $tiket_book[0]->id_tiket_book), 
            array("status" => 5));
          $kirim = array(
            "id_users"          => $this->session->userdata("id"),
            "id_tiket_book"     => $tiket_book[0]->id_tiket_book,
            "pos"               => 1,
            "saldo"             => $tiket_book[0]->harga_bayar,
            "tanggal"           => date("Y-m-d H:i:s"),
            "create_by_users"   => $this->session->userdata("id"),
            "create_date"       => date("Y-m-d H:i:s"),
          );
          $this->global_models->insert("tiket_setor_agent", $kirim);
          $this->session->set_flashdata('success', 'Tiket Issued');
//        }
//        else{
//          $this->session->set_flashdata('notice', 'Issued Gagal');
//        }
      }
      else{
        $this->session->set_flashdata('notice', 'Issued Gagal');
      }
    }
    else{
      $this->session->set_flashdata('notice', 'Tiket Salah');
    }
    redirect("flight/book-store");
  }
  
  function agent(){
    $privilege = $this->nbscache->get_explode("store", "privilege");
    $jumlah = $this->global_models->get_query("SELECT count(A.id_users) AS jml"
      . " FROM m_users AS A"
      . " LEFT JOIN d_user_privilege AS B ON A.id_users = B.id_users"
      . " LEFT JOIN m_privilege AS C ON B.id_privilege = C.id_privilege"
      . " WHERE C.id_privilege = '{$privilege[1]}'"
      . "");
    
    $url_list = site_url("ajax/ajax-agent/".$jumlah[0]->jml);
    $url_list_halaman = site_url("ajax/ajax-halaman/".$jumlah_list);
    $foot = <<<EOD
      <script>
            
            function get_list(start){
                  if(typeof start === "undefined"){
                    start = 0;
                  }
                  $.post('{$url_list}/'+start, function(data){
                    $("#data_list").html(data);
                    $.post('{$url_list_halaman}/'+start, function(data){
                      $("#halaman_set").html(data);
                    });
                  });
            }
            get_list(0);
      </script>
EOD;

    $menutable = "<li><a href='".site_url("flight/add-new-agent")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build('agent', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'flight/agent',
            'title'   => "Agent",
            'foot'    => $foot,
            'css'     => $css,
            'menutable'   => $menutable,
            'menu_action' => 1
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('agent');

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
  
  function report_agent($id_users){
    $pst = $this->input->post(NULL, TRUE);
      if($pst){
        $set_sess = array(
          "flight_report_transaksi_store_book_code" => $pst['book_code'],
          "flight_report_transaksi_store_booking_from" => $pst['booking_from'],
          "flight_report_transaksi_store_booking_to" => $pst['booking_to'],
        );
        $this->session->set_userdata($set_sess);
      }
     
        $where = " AND 1=1 ";
      if($this->session->userdata('flight_report_transaksi_store_book_code')){
          $where .= " AND A.book_code LIKE '%{$this->session->userdata('flight_report_transaksi_store_book_code')}%' ";
      }
      if($this->session->userdata('flight_report_transaksi_store_booking_from')){
          $where_tanggal .= " AND B.tanggal >= '{$this->session->userdata('flight_report_transaksi_store_booking_from')}' ";
      }
      else{
        $where_tanggal .= " AND B.tanggal >= '".date("Y-m")."-01' ";
      }
      if($this->session->userdata('flight_report_transaksi_store_booking_to')){
          $where_tanggal .= " AND B.tanggal <= '{$this->session->userdata('flight_report_transaksi_store_booking_to')}' ";
      }
      else{
        $where_tanggal .= " AND B.tanggal <= '".date("Y-m-t")."' ";
      }
     
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    
    $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
            ."<script type='text/javascript'>"
      . "$(function() { "
        . "$( '#start_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
        . "$( '#end_date' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
      . "}); "
      . "</script> ";
    
    $report = $this->global_models->get_query("SELECT B.tanggal, B.saldo, A.book_code, A.tiket_no, B.pos, B.type, C.name"
      . " FROM tiket_setor_agent AS B"
      . " LEFT JOIN tiket_book AS A ON A.id_tiket_book = B.id_tiket_book"
      . " LEFT JOIN m_users AS C ON B.create_by_users = C.id_users"
      . " WHERE B.id_users = '$id_users'" .$where_tanggal
      . " ORDER BY B.tanggal ASC");
    
    $report_all = $this->global_models->get_query("SELECT SUM(CASE WHEN pos = 1 THEN saldo ELSE 0 END) AS debit,"
      . " SUM(CASE WHEN pos = 2 THEN saldo ELSE 0 END) AS kredit"
      . " FROM tiket_setor_agent AS B"
      . " WHERE B.id_users = '$id_users'");
    $menutable = "<li><a href='".site_url("flight/transfer-pendapatan/{$id_users}")."'><i class='icon-plus'></i> Transfer</a></li>";
    $this->template->build('report-transaksi-agent', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "flight/report-transaksi-store",
            'data'        => $report,
            'report_all'  => $report_all,
            'title'       => lang("antavaya_report_transaksi"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc',
            'css'         => $css,
            'foot'        => $foot,
            'type_payment' => $cra_byar,
            'breadcrumb'  => array(
                    "Agent"  => "flight/agent"
                ),
//            'sort'        => $sort,
//            'serach_data'   => $search,
            'before_table' => $before_table,
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('report-transaksi-agent');
  }
  
  function transfer_pendapatan($id_users){
    if(!$this->input->post(NULL)){
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";

      $foot .= "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
              ."<script type='text/javascript'>"
        . "$(function() { "
          . "$( '#tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
        . "</script> ";
      $this->template->build("transfer-pendapatan", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'flight/agent',
              'title'       => lang("antavaya_transfer_pendapatan"),
              'id_users'    => $id_users,
              'breadcrumb'  => array(
                    "Agent"                       => "flight/agent",
                    "antavaya_report_transaksi"   => "flight/report-agent/{$id_users}",
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("transfer-pendapatan");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $kirim = array(
          "id_users"          => $id_users,
          "pos"               => 2,
          "saldo"             => $pst['saldo'],
          "type"              => $pst['payment'],
          "tanggal"           => $pst['tanggal'],
          "create_by_users"   => $this->session->userdata("id"),
          "create_date"       => date("Y-m-d H:i:s"),
      );
      $id_tiket_setor_agent = $this->global_models->insert("tiket_setor_agent", $kirim);
      if($id_tiket_setor_agent){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("flight/report-agent/{$id_users}");
    }
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */