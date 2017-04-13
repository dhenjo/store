<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_series extends MX_Controller {
    
  function __construct() {
    $this->load->library('email');
    $this->menu = $this->cek();
  }
  
  function schedule_detail($code){
    $pst = $this->input->post();
    
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $code,
    );
    
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-series/tour-information-get");
    $data_array = json_decode($data);
    
    if($pst){
//      $this->debug($pst, true);
      $post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $code,
        "kode_ps"           => $pst['kode_ps'],
        "at_airport"        => $pst['at_airport'],
        "start_date"        => $pst['start_date'],
        "start_time"        => $pst['start_time'],
        "end_date"          => $pst['end_date'],
        "end_time"          => $pst['end_time'],
        "available_seat"    => $pst['available_seat'],
        "keberangkatan"     => $pst['keberangkatan'],
        "sts"               => $pst['sts'],
        "flt"               => $pst['flt'],
        "in"                => $pst['in'],
        "out"               => $pst['out'],
        "tampil"            => $pst['tampil'],
        "status"            => $pst['status'],
        "umum"              => $pst['umum'],
        "remarks"           => $pst['remarks'],
        "adult_triple_twin" => str_replace(",","", $pst['adult_triple_twin']),
        "child_twin_bed"    => str_replace(",","", $pst['child_twin_bed']),
        "child_extra_bed"   => str_replace(",","", $pst['child_extra_bed']),
        "child_no_bed"      => str_replace(",","", $pst['child_no_bed']),
        "airport_tax"       => str_replace(",","", $pst['airport_tax']),
        "less_ticket_adl"   => str_replace(",","", $pst['less_ticket_adl']),
        "less_ticket_chl"   => str_replace(",","", $pst['less_ticket_chl']),
      );

      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-series/tour-information-update");
      $data_array = json_decode($data);
    }
//    $this->debug($data_array, true);
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />"
      . "";
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
      . "";

    $foot .= "<script>"


        . "$('.harga').priceFormat({"
          . "prefix: '',"
          . "centsLimit: 0"
        . "});"

        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"

        . "$( '.time' ).timepicker({"
        . "});"

    . "</script>";
    $this->template->build('series/schedule-detail', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master",
        'data'          => $data_array->data,
        'title'         => lang("Edit"),
        'foot'          => $foot,
        'css'           => $css,
        'kode'          => $code,
        'detail'        => $data_array->book,
      ));
    $this->template
      ->set_layout('default')
      ->build('series/schedule-detail');
  }
  
  function duplicate_tour_information($code){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $code,
      "relasi"            => $pst['relasi'],
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-series/tour-information-clone");
    $data_array = json_decode($data);
    if($data_array->status == 2){
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("tour/tour-series/schedule-detail/{$data_array->code}");
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      redirect("tour/tour-series/schedule-detail/{$code}");
    }
  }
  
  function cancel_tour_information($code){
    
//    get data book
    $post_book = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data_book = $this->global_variable->curl_mentah($post_book, URLSERVER."json/json-series/tour-series-get-book-list");
    $book_array = json_decode($data_book);
//    $this->debug($book_array, true);
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cancel");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if($data_array->status == 2){
      $email_to = $this->session->userdata("email");
      foreach($book_array->data AS $bookers){
        if($bookers->status == 2 OR $bookers->status == 3){
          $email_to .= ','.$bookers->users;
        }
      }
      
      $this->email->initialize($this->global_models->email_conf());
      $this->email->from("no-reply@antavaya.com", "System TMS");
      $this->email->to($email_to);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[GS] Tour Series Cancel");
      $this->email->message("
        Dear Bookers <br />
        Anda memiliki book yang sudah melakukan pembayaran<br />
        Untuk Itin {$data_array->detail->title} tgl ".date("d M Y", strtotime($data_array->detail->start_date))." s/d ".date("d M Y", strtotime($data_array->detail->end_date))."<br />
        Sudah di CANCEL <br />
        Mohon hubungi operation untuk informasi lebih lanjut<br />
        Terima Kasih <br />
        ");

      $this->email->send();
//      print $email_to;die;
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("tour/tour-series/schedule/{$data_array->code}");
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      redirect("tour/tour-series/schedule-detail/{$code}");
    }
  }
  
  function close_tour_information($code){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cancel");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if($data_array->status == 2){
      $this->session->set_flashdata('success', 'Data tersimpan');
      redirect("tour/tour-series/schedule/{$data_array->code}");
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      redirect("tour/tour-series/schedule-detail/{$code}");
    }
  }
  
  function schedule($code){
    
    $post_itin = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data_itin = $this->global_variable->curl_mentah($post_itin, URLSERVER."json/json-series/tour-series-itin-detail");
    $itin_array = json_decode($data_itin);
//    $this->debug($itin_array, true);
    
     $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<style>"
       . ".delete-tour{"
        . "background-color: red !important;"
        . "color: green !important;"
       . "}"
       . ".go-tour{"
        . "background-color: #00a65a !important;"
       . "}"
      . "</style>";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
      . "<script>"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "</script>";
	  
    $foot .= "<script>"

      . "var table = "
      . "$('#tableboxy').DataTable({"
        . "'order': [[ 0, 'desc' ]],"
        . "'responsive': true"
      . "});"
      
      . "var table_close = "
      . "$('#tableboxy-close').DataTable({"
        . "'order': [[ 0, 'desc' ]],"
        . "'responsive': true"
      . "});"
      
      ."ambil_data(table, 0);"
      ."ambil_data_close(table_close, 0);"
      
      . "function ambil_data(table, start){"
        . "$.post('".site_url("tour/tour-series-ajax/tour-series-get")."', {start: start, code: '{$code}', status: '(1,2,5)'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
              . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding[ind]);"
              . "$('#nomor').val(hasil.nomor);"
            . '}'
            ."ambil_data(table, hasil.start);"
          . "}"
        . "});"
      . "}"
      
      . "function ambil_data_close(table_close, start){"
        . "$.post('".site_url("tour/tour-series-ajax/tour-series-get-close-cancel")."', {start: start, code: '{$code}', status: '(3,4)'}, function(data){"
          . "var hasil = $.parseJSON(data);"
          . "if(hasil.status == 2){"
            . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
              . "var rowNode = table_close.row.add(hasil.hasil[ind]).draw().node();"
              . "$( rowNode ).attr('isi',hasil.banding[ind]);"
              . "$('#nomor').val(hasil.nomor);"
            . '}'
            ."ambil_data_close(table_close, hasil.start);"
          . "}"
        . "});"
      . "}"

      . "$(document).on( 'click', '.cancel-tour', function () {"
        . "var kode = $(this).attr('isi');"
        . "$.post('".site_url("tour/tour-ajax/tour-series-open-cancel")."', {kode: kode}, function(data){"
          . "if(data == 2){"
            . "$('tr[isi='+kode+']').addClass('delete-tour');"
            . "$('.btn-hide'+kode).remove();"
          . "}"
        . "});"
      . "});"

      . "$(document).on( 'click', '.close-tour', function () {"
        . "var kode = $(this).attr('isi');"
        . "$.post('".site_url("tour/tour-ajax/tour-series-open-close")."', {kode: kode}, function(data){"
          . "if(data == 2){"
            . "$('tr[isi='+kode+']').addClass('go-tour');"
            . "$('.btn-hide'+kode).remove();"
          . "}"
        . "});"
      . "});"

    . "</script>";
    $this->template->build('series/schedule', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master",
        'title'         => lang("Schedule"),
        'foot'          => $foot,
        'css'           => $css,
        'itin'          => $itin_array->data[0],
      ));
    $this->template
      ->set_layout('default')
      ->build('series/schedule');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */