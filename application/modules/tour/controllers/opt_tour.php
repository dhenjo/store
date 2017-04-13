<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Opt_tour extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function fit_request(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_start"             => $pst['fit_search_start'],
        "fit_search_end"               => $pst['fit_search_end'],
        "fit_search_title"             => $pst['fit_search_title'],
        "fit_search_client"            => $pst['fit_search_client'],
        "fit_search_status"            => $pst['fit_search_status'],
        "fit_search_destination"       => $pst['fit_search_destination'],
        "fit_search_p_start"           => $pst['fit_search_p_start'],
        "fit_search_p_end"             => $pst['fit_search_p_end'],
        "fit_search_code"              => $pst['fit_search_code'],
      );
      $this->session->set_userdata($set);
    }
    if(!$this->session->userdata('fit_search_start')){
      $this->session->set_userdata(array("fit_search_start" => date("Y-m-01", strtotime(date("Y")."-".(date("m") - 1)."-01")),"fit_search_end" => date("Y-m-t")));
    }
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
	  
    $foot .= "<script>"
      
      . "function load_tooltip(){"
        . "$('.tooltip-title').tooltipster({"
          . "content: 'Loading...',"
          . "minWidth: 300,"
          . "maxWidth: 300,"
          . "contentAsHTML: true,"
          . "interactive: true,"
          . "functionBefore: function(origin, continueTooltip) {"
            . "continueTooltip();"
            . "if (origin.data('ajax') !== 'cached') { "
              . "$.ajax({ "
                . "type: 'POST',"
                . "url: '".site_url("tour/ajax/load-tooltip-detail-tour")."/'+$(this).attr('isi'),"
                . "success: function(data) {"
                  . "origin.tooltipster('content', data).data('ajax', 'cached');"
                . "}"
              . "});"
            . "}"
          . "}"
        . "});"
      . "}"
      
      . "function load_tooltip_harga(){"
        . "$('.tooltip-harga').tooltipster({"
          . "content: 'Loading...',"
          . "minWidth: 300,"
          . "maxWidth: 300,"
          . "contentAsHTML: true,"
          . "interactive: true,"
          . "functionBefore: function(origin, continueTooltip) {"
            . "continueTooltip();"
            . "if (origin.data('ajax') !== 'cached') { "
              . "$.ajax({ "
                . "type: 'POST',"
                . "url: '".site_url("tour/ajax/load-tooltip-harga-tour")."/'+$(this).attr('isi'),"
                . "success: function(data) {"
                  . "origin.tooltipster('content', data).data('ajax', 'cached');"
                . "}"
              . "});"
            . "}"
          . "}"
        . "});"
      . "}"
      
      . '$(function() {'
        . 'var table = '
        . '$("#tableboxy").dataTable({'
          . '"order": [[ 0, "desc" ]],'
//          . "'iDisplayLength': 20"
        . '});'
      
        . 'ambil_data(table, 0);'
      
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      
      . '});'
      
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/tour-fit-ajax/get-opt-tour-fit-request").'/"+mulai, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.fnAddData(hasil.hasil);'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
            . 'load_tooltip();'
            . 'load_tooltip_harga();'
//            . "$('#script-tambahan').html('".$script_tambahan."');"
          . '}'
        . '});'
      . '}'
      
	  . "</script>";
    
    $store_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
    );
    $store = $this->antavaya_lib->curl_mentah($store_post, URLSERVER."json/json-tour/get-all-store-region");  
    $store_array = json_decode($store);
    if($store_array->status == 2){
      $store_dd[NULL] = "- Pilih -";
      foreach($store_array->data AS $sd){
        $store_dd[$sd->id_store_region] = $sd->title;
      }
    }
     
    $this->template->build('opt/fit-request', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/opt-tour/fit-request",
        'data'          => $data_array->data,
        'title'         => lang("Quotation Request"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('opt/fit-request');
  }
  
  function fit_price_request(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_start"             => $pst['fit_search_start'],
        "fit_search_end"               => $pst['fit_search_end'],
        "fit_search_code"              => $pst['fit_search_code'],
        "fit_search_fit_code"          => $pst['fit_search_fit_code'],
        "fit_search_name"              => $pst['fit_search_name'],
        "fit_search_email"             => $pst['fit_search_email'],
        "fit_search_status"             => $pst['fit_search_status'],
      );
      $this->session->set_userdata($set);
    }
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>";
	  
    $foot .= "<script>"
      
      . "function load_tooltip(){"
        . "$('.tooltip-title').tooltipster({"
          . "content: 'Loading...',"
          . "minWidth: 300,"
          . "maxWidth: 300,"
          . "contentAsHTML: true,"
          . "interactive: true,"
          . "functionBefore: function(origin, continueTooltip) {"
            . "continueTooltip();"
            . "if (origin.data('ajax') !== 'cached') { "
              . "$.ajax({ "
                . "type: 'POST',"
                . "url: '".site_url("tour/ajax/load-tooltip-detail-tour")."/'+$(this).attr('isi'),"
                . "success: function(data) {"
                  . "origin.tooltipster('content', data).data('ajax', 'cached');"
                . "}"
              . "});"
            . "}"
          . "}"
        . "});"
      . "}"
      
      . "function load_tooltip_harga(){"
        . "$('.tooltip-harga').tooltipster({"
          . "content: 'Loading...',"
          . "minWidth: 300,"
          . "maxWidth: 300,"
          . "contentAsHTML: true,"
          . "interactive: true,"
          . "functionBefore: function(origin, continueTooltip) {"
            . "continueTooltip();"
            . "if (origin.data('ajax') !== 'cached') { "
              . "$.ajax({ "
                . "type: 'POST',"
                . "url: '".site_url("tour/ajax/load-tooltip-harga-tour")."/'+$(this).attr('isi'),"
                . "success: function(data) {"
                  . "origin.tooltipster('content', data).data('ajax', 'cached');"
                . "}"
              . "});"
            . "}"
          . "}"
        . "});"
      . "}"
      
      . '$(function() {'
        . 'var table = '
        . '$("#tableboxy").dataTable({'
          . '"order": [[ 0, "desc" ]],'
//          . "'iDisplayLength': 20"
        . '});'
      
        . 'ambil_data(table, 0);'
      
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      
      . '});'
      
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/ajax/get-opt-book-list-fit").'/"+mulai, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.fnAddData(hasil.hasil);'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
            . 'load_tooltip();'
            . 'load_tooltip_harga();'
//            . "$('#script-tambahan').html('".$script_tambahan."');"
          . '}'
        . '});'
      . '}'
      
	  . "</script>";
    
    $store_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
    );
    $store = $this->antavaya_lib->curl_mentah($store_post, URLSERVER."json/json-tour/get-all-store-region");  
    $store_array = json_decode($store);
    if($store_array->status == 2){
      $store_dd[NULL] = "- Pilih -";
      foreach($store_array->data AS $sd){
        $store_dd[$sd->id_store_region] = $sd->title;
      }
    }
     
    $this->template->build('opt/fit-price-request', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/opt-tour/fit-price-request",
        'data'          => $data_array->data,
        'title'         => lang("Book List FIT"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('opt/fit-price-request');
  }
  
  function book_fit_detail($kode){
    
    $pst = $this->input->post();
    if($pst AND $pst['submit'] == 'submit'){
//      price
      foreach($pst['note'] AS $knote => $note){
        if($note){
          $pst_note[] = $note;
          $pst_qty[] = $pst['qty'][$knote];
          $pst_price[] = $pst['price'][$knote];
          $pst_type[] = 1;
          $pst_pos[] = 1;
        }
      }
      foreach($pst['note_discount'] AS $knote2 => $note2){
        if($note2){
          $pst_note[] = $note2;
          $pst_qty[] = $pst['qty_discount'][$knote2];
          $pst_price[] = $pst['price_discount'][$knote];
          $pst_type[] = 5;
          $pst_pos[] = 2;
        }
      }
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "code"                => $kode,
        "note"                => json_encode($pst_note),
        "qty"                 => json_encode($pst_qty),
        "price"               => json_encode($pst_price),
        "type"                => json_encode($pst_type),
        "pos"                 => json_encode($pst_pos),
      );
      $price = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-price-fit");
      $price_array = json_decode($price);
//      $this->debug($price, true);
      $status = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
        "status"            => 3,
        "id_users"          => $this->session->userdata("id")
      );
      $stat = $this->antavaya_lib->curl_mentah($status, URLSERVER."json/json-tour/set-status-book-fit");
      
      $tl = $pst['time_limit'];
      $tl_ex = explode(" ", $tl);
      $tl_time = explode(":", $tl);
      if($tl_ex[1] == "PM"){
        $tl_time[0] += 12;
      }
      $time_limit = $tl_time[0].":".$tl_time[1].":00";
      $limit = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "id_users"          => $this->session->userdata("id"),
        "code"              => $kode,
        "date_limit"        => $pst['date_limit'],
        "time_limit"        => $time_limit,
      );
      $limit_hasil = $this->antavaya_lib->curl_mentah($limit, URLSERVER."json/json-tour/update-fit-book");
//      $this->debug($limit_hasil, true);
      if($price_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/opt-tour/book-fit-detail/{$kode}");
    }
    else{
    
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/timepicker/bootstrap-timepicker.min.css' rel='stylesheet'/>"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/timepicker/bootstrap-timepicker.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>";

      $foot .= "<script>"

        . "function load_tooltip(){"
          . "$('.tooltip-title').tooltipster({"
            . "content: 'Loading...',"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true,"
            . "functionBefore: function(origin, continueTooltip) {"
              . "continueTooltip();"
              . "if (origin.data('ajax') !== 'cached') { "
                . "$.ajax({ "
                  . "type: 'POST',"
                  . "url: '".site_url("tour/ajax/load-tooltip-detail-tour")."/'+$(this).attr('isi'),"
                  . "success: function(data) {"
                    . "origin.tooltipster('content', data).data('ajax', 'cached');"
                  . "}"
                . "});"
              . "}"
            . "}"
          . "});"
        . "}"

        . "function load_tooltip_harga(){"
          . "$('.tooltip-harga').tooltipster({"
            . "content: 'Loading...',"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true,"
            . "functionBefore: function(origin, continueTooltip) {"
              . "continueTooltip();"
              . "if (origin.data('ajax') !== 'cached') { "
                . "$.ajax({ "
                  . "type: 'POST',"
                  . "url: '".site_url("tour/ajax/load-tooltip-harga-tour")."/'+$(this).attr('isi'),"
                  . "success: function(data) {"
                    . "origin.tooltipster('content', data).data('ajax', 'cached');"
                  . "}"
                . "});"
              . "}"
            . "}"
          . "});"
        . "}"

        . '$(function() {'
        
          . "$('.timepicker').timepicker({"
            . "showInputs: false"
          . "});"
        
          . 'var table = '
          . '$("#tableboxy").dataTable({'
            . '"order": [[ 1, "asc" ]],'
  //          . "'iDisplayLength': 20"
          . '});'
        
          . "$('.harga').priceFormat({"
            . "prefix: 'Rp ',"
            . "centsLimit: 0"
          . "});"

          . 'ambil_data(table, 0);'

          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true,"
          . "});"

        . '});'

        . 'function ambil_data(table, mulai){'
          . '$.post("'.site_url("tour/ajax/get-master-tour-fit").'/"+mulai, function(data){'
            . '$("#loader-page").show();'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.status == 2){'
              . 'table.fnAddData(hasil.hasil);'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
              . '$("#loader-page").hide();'
              . 'load_tooltip();'
              . 'load_tooltip_harga();'
  //            . "$('#script-tambahan').html('".$script_tambahan."');"
            . '}'
          . '});'
        . '}'
        
        . "$(document).on('click', '.tour-edit-pax', function(evt){"
//        . "alert($(this).attr('isi'));"
          . "$.post('".site_url("tour/ajax/edit-pax-book")."', {code: $(this).attr('isi')},function(data){"
            . "var hasil = $.parseJSON(data);"
//        . "alert(hasil.data.kode);"
            . "$('#edit-pax-kode').val(hasil.data.kode);"
            . "$('#edit-title').val(hasil.data.title);"
            . "$('#edit-pax-type').val(hasil.data.pax_type);"
            . "$('#edit-first-name').val(hasil.data.first_name);"
            . "$('#edit-last-name').val(hasil.data.last_name);"
            . "$('#edit-telp').val(hasil.data.telp);"
            . "$('#edit-type').val(hasil.data.type);"
            . "$('#edit-tempat-lahir').val(hasil.data.tempat_lahir);"
            . "$('#edit-tanggal-lahir').val(hasil.data.tanggal_lahir);"
            . "$('#edit-passport').val(hasil.data.passport);"
            . "$('#edit-tanggal-passport').val(hasil.data.tanggal_passport);"
            . "$('#edit-expired-passport').val(hasil.data.expired_passport);"
            . "$('#edit-note').val(hasil.data.note);"
          . "});"
        . "});"
        . "$(document).on('click', '#add-pax', function(evt){"
          . "$('#edit-pax-kode').val('');"
          . "$('#edit-first-name').val('');"
          . "$('#edit-last-name').val('');"
          . "$('#edit-telp').val('');"
          . "$('#edit-tempat-lahir').val('');"
          . "$('#edit-tanggal-lahir').val('');"
          . "$('#edit-passport').val('');"
          . "$('#edit-tanggal-passport').val('');"
          . "$('#edit-expired-passport').val('');"
          . "$('#edit-note').val('');"
        . "});"
        
        . "$(document).on('click', '#add-price', function(evt){"
          . "$.post('".site_url("tour/ajax/add-row-opt-book-price")."', function(data){"
            . "$('#table-price tbody:last').before(data);"
          . "});"
        . "});"
        
        . "$(document).on('click', '#add-discount', function(evt){"
          . "$.post('".site_url("tour/ajax/add-row-opt-book-discount")."', function(data){"
            . "$('#table-discount tbody:last').before(data);"
          . "});"
        . "});"

      . "</script>";

      $book_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $book = $this->antavaya_lib->curl_mentah($book_post, URLSERVER."json/json-tour/get-book-tour-fit-detail");  
      $book_array = json_decode($book);
      
      $price_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $price = $this->antavaya_lib->curl_mentah($book_post, URLSERVER."json/json-tour/get-book-tour-fit-price");  
      $price_array = json_decode($price);
     
//      $this->debug($price_array, true);
      $this->template->build('opt/book-fit-detail', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/opt-tour/fit-price-request",
          'data'          => $data_array->data,
          'title'         => lang("Book FIT")." {$kode}",
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'book'          => $book_array->data,
          'pax'           => $book_array->pax,
          'price'         => $price_array->price,
          'discount'      => $price_array->discount,
        ));
      $this->template
        ->set_layout('default')
        ->build('opt/book-fit-detail');
    }
  }
  
  function change_status_tour_fit($kode, $status = 2){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "status"            => $status,
      "id_users"          => $this->session->userdata("id")
    );
    $store = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-status-book-fit");  
    $store_array = json_decode($store);
    if($store_array->status == 2)
      $this->session->set_flashdata('success', 'Data tersimpan');
    else
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    redirect("tour/opt-tour/book-fit-detail/{$kode}");
  }
  
  function book_fit_request($kode){
    
    $pst = $this->input->post();
    if($pst){
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "code"                => $kode,
      );
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/get-book-tour-fit-schedule");
      $data_array = json_decode($data);
//      $this->debug($data, true);
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("tour/book-fit-detail/{$data_array->code}");
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
        redirect("tour/book-fit/{$kode}");
      }
    }
    else{
      $log_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $log = $this->antavaya_lib->curl_mentah($log_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-log");  
      $log_array = json_decode($log);
      
      $book_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
        "start"             => 0,
        "max"               => 1,
      );
      $book = $this->antavaya_lib->curl_mentah($book_post, URLSERVER."json/json-tour-fit/get-tour-fit-request");  
      $book_array = json_decode($book);

      $quo_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
        "start"             => 0,
        "max"               => 1,
      );
      $quo = $this->antavaya_lib->curl_mentah($quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-quotation");  
      $quo_array = json_decode($quo);
//      $this->debug($quo_array, true);
      $itin_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
      $itin_array = json_decode($itin);
      
      $cp_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $cp = $this->antavaya_lib->curl_mentah($cp_post, URLSERVER."json/json-tour-fit/get-contact-person-fit-request");  
      $cp_array = json_decode($cp);
      
      $pax_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $pax = $this->antavaya_lib->curl_mentah($pax_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-pax");  
      $pax_array = json_decode($pax);
      
      $price_tag_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $price_tag = $this->antavaya_lib->curl_mentah($price_tag_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-price-tag");  
      $price_tag_array = json_decode($price_tag);
      
      $hpp_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $hpp = $this->antavaya_lib->curl_mentah($hpp_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-hpp");  
      $hpp_array = json_decode($hpp);

      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/timepicker/bootstrap-timepicker.min.css' rel='stylesheet'/>"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/timepicker/bootstrap-timepicker.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>";

      $foot .= "<script>"
        . "CKEDITOR.replace('editor2');"
        . 'var table = '
        . '$("#tableboxy").dataTable({'
          . '"order": [[ 0, "asc" ]],'
//          . "'iDisplayLength': 20"
        . '});'
        . 'var table_price = '
        . '$("#table-price").dataTable({'
          . '"order": [[ 0, "asc" ]],'
          . "'pageLength': -1"
        . '});'
        . "function load_tooltip(){"
          . "$('.tooltip-title').tooltipster({"
            . "content: 'Loading...',"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true,"
            . "functionBefore: function(origin, continueTooltip) {"
              . "continueTooltip();"
              . "if (origin.data('ajax') !== 'cached') { "
                . "$.ajax({ "
                  . "type: 'POST',"
                  . "url: '".site_url("tour/ajax/load-tooltip-detail-tour")."/'+$(this).attr('isi'),"
                  . "success: function(data) {"
                    . "origin.tooltipster('content', data).data('ajax', 'cached');"
                  . "}"
                . "});"
              . "}"
            . "}"
          . "});"
        . "}"
        
        . "function load_tooltip_harga(){"
          . "$('.tooltip-harga').tooltipster({"
            . "content: 'Loading...',"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true,"
            . "functionBefore: function(origin, continueTooltip) {"
              . "continueTooltip();"
              . "if (origin.data('ajax') !== 'cached') { "
                . "$.ajax({ "
                  . "type: 'POST',"
                  . "url: '".site_url("tour/ajax/load-tooltip-harga-tour")."/'+$(this).attr('isi'),"
                  . "success: function(data) {"
                    . "origin.tooltipster('content', data).data('ajax', 'cached');"
                  . "}"
                . "});"
              . "}"
            . "}"
          . "});"
        . "}"
        
        . "$('#chat-box').slimScroll({"
          . "height: '250px'"
        . "});"
        
        . "$('#history-log').slimScroll({"
          . "height: '500px'"
        . "});"

        . '$(function() {'
        
          . "$('.timepicker').timepicker({"
            . "showInputs: false"
          . "});"
        
          . "$(document).on('click', '#post-chat', function(evt){"
            . "$('#loading-chat').show();"
            . "$('#post-chat').hide();"
            . "$.post('".site_url("tour/tour-fit-ajax/post-chat")."', {chat: $('#isi-chat').val(), id: '{$this->session->userdata('id')}', code: '{$kode}'}, function(html){"
              . "$('#loading-chat').hide();"
              . "$('#post-chat').show();"
              . "$('#isi-chat').val('');"
            . "});"
          . "});"
        
          . "$('.harga').priceFormat({"
            . "prefix: 'Rp ',"
            . "centsLimit: 0"
          . "});"

          . 'ambil_data(table, 0);'
          . 'ambil_data_price(table_price, 0);'

          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true,"
          . "});"

        . '});'

        . 'function ambil_data(table, mulai){'
          . '$.post("'.site_url("tour/ajax/get-itin-quo-detail").'/"+mulai, {code: "'.$kode.'"}, function(data){'
            . '$("#loading-itin-quo").show();'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.hasil){'
              . 'table.fnAddData(hasil.hasil);'
            . '}'
            . '$("#loading-itin-quo").hide();'
          . '});'
        . '}'
              
        . 'function ambil_data_price(table_price, mulai){'
          . '$("#loading-price").show();'
          . '$("#status-update3").hide();'
          . '$("#status-update4").hide();'
          . '$("#status-update6").hide();'
          . '$.post("'.site_url("tour/tour-fit-ajax/get-price-request").'/"+mulai, {code: "'.$kode.'", quo: "'.$quo_array->data[0]->status.'"}, function(data){'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.hasil){'
              . 'table_price.fnAddData(hasil.hasil);'
              . '$("#sum-debit").html(hasil.debit);'
              . '$("#sum-kredit").html(hasil.kredit);'
              . '$("#total").html(hasil.total);'
              . '$("#total-cost").html(hasil.total);'
              . 'var total_cost = hasil.total.replace(",", "");'
              . 'total_cost = total_cost.replace(",", "");'
              
              . 'total_cost = total_cost * 1;'
              . 'var total_cost2 = $("#total-cost2").text();'
              . 'var total_cost2 = total_cost2.replace(",", "");'
              . 'total_cost2 = total_cost2.replace(",", "");'
              . 'total_cost2 = total_cost2 * 1;'
              
              . 'var total_hasil = total_cost - total_cost2;'
              . '$("#hasil-kredit").html(formatDollar(total_hasil));'
            . '}'
//            . 'alert(hasil.quo);'
            . 'if(hasil.quo != 2){'
              . '$("#status-update"+hasil.quo).show();'
              . '$("#status-asli").hide();'
            . '}'
            . '$("#loading-price").hide();'
          . '});'
        . '}'
              
        . "function formatDollar(num) {"
          . "var p = num.toFixed(2).split('.');"
          . "return p[0].split('').reverse().reduce(function(acc, num, i, orig) {"
            . "return  num + (i && !(i % 3) ? ',' : '') + acc;"
          . "}, '');"
        . "}"
        
        . "$(document).on('click', '.tour-edit-pax', function(evt){"
//        . "alert($(this).attr('isi'));"
          . "$.post('".site_url("tour/ajax/edit-pax-book")."', {code: $(this).attr('isi')},function(data){"
            . "var hasil = $.parseJSON(data);"
//        . "alert(hasil.data.kode);"
            . "$('#edit-pax-kode').val(hasil.data.kode);"
            . "$('#edit-title').val(hasil.data.title);"
            . "$('#edit-pax-type').val(hasil.data.pax_type);"
            . "$('#edit-first-name').val(hasil.data.first_name);"
            . "$('#edit-last-name').val(hasil.data.last_name);"
            . "$('#edit-telp').val(hasil.data.telp);"
            . "$('#edit-type').val(hasil.data.type);"
            . "$('#edit-tempat-lahir').val(hasil.data.tempat_lahir);"
            . "$('#edit-tanggal-lahir').val(hasil.data.tanggal_lahir);"
            . "$('#edit-passport').val(hasil.data.passport);"
            . "$('#edit-tanggal-passport').val(hasil.data.tanggal_passport);"
            . "$('#edit-expired-passport').val(hasil.data.expired_passport);"
            . "$('#edit-note').val(hasil.data.note);"
          . "});"
        . "});"
        . "$(document).on('click', '#add-pax', function(evt){"
          . "$('#edit-pax-kode').val('');"
          . "$('#edit-first-name').val('');"
          . "$('#edit-last-name').val('');"
          . "$('#edit-telp').val('');"
          . "$('#edit-tempat-lahir').val('');"
          . "$('#edit-tanggal-lahir').val('');"
          . "$('#edit-passport').val('');"
          . "$('#edit-tanggal-passport').val('');"
          . "$('#edit-expired-passport').val('');"
          . "$('#edit-note').val('');"
        . "});"

        . "$(document).on('click', '#simpan-itin-quo', function(evt){"
          . "$('#loading-itin-quo').show();"
          . "var id_tour_fit_request_detail = $('#itin-quo-id-tour-fit-request-detail').val();"
//        . "alert(id_tour_fit_request_detail);"
          . "var sort = $('#itin-quo-days').val();"
          . "var itinerary = $('#itin-quo-itinerary').val();"
          . "var meal = $('#itin-quo-meal').val();"
          . "var entrance = $('#itin-quo-entrance').val();"
          . "var specific = $('#itin-quo-specific').val();"
          . "$.post('".site_url("tour/ajax/update-itin-quo")."', {id: id_tour_fit_request_detail, id_tour_fit_request: '{$book_array->data[0]->id_tour_fit_request}', sort: sort, itinerary: itinerary, meal: meal, entrance: entrance, specific: specific}, function(data){"
//            . 'var table2 = '
//            . '$("#tableboxy").dataTable({'
//              . '"order": [[ 0, "asc" ]],'
//            . '});'
            . "table.fnClearTable();"
            . "ambil_data(table, 0);"
            . "$('#loading-itin-quo').hide();"
          . "});"
        . "});"
        
        . "$(document).on('click', '.itin-quo-edit', function(evt){"
          . "$.post('".site_url("tour/ajax/itin-quo-edit")."', {id: $(this).attr('isi')}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(hasil.status == 2){"
              . "$('#itin-quo-id-tour-fit-request-detail').val(hasil.data.id_tour_fit_request_detail);"
              . "$('#itin-quo-days').val(hasil.data.sort);"
              . "$('#itin-quo-itinerary').val(hasil.data.itinerary);"
              . "$('#itin-quo-meal').val(hasil.data.meal);"
              . "$('#itin-quo-entrance').val(hasil.data.entrance);"
              . "$('#itin-quo-specific').val(hasil.data.specific);"
            . "}"
            . "else{"
              . "$('#itin-quo-id-tour-fit-request-detail').val(0);"
            . "}"
          . "});"
        . "});"
            
        . "$(document).on('click', '#set-button-time-limit', function(evt){"
          . "$.post('".site_url("tour/tour-fit-ajax/set-time-limit")."', {code: '{$kode}', date_limit: $('#set-date-limit').val(), time_limit: $('#set-time-limit').val()}, function(data){"
            . "$('#timelimit-rep').html('<th>Timelimit</th>"
            . "<td>'+data+'</td>');"
            . "$('#timelimit-rep2').remove();"
          . "});"
        . "});"
            
        . "function load_chat(){"
          . "$.post('".site_url("tour/tour-fit-ajax/load-chat")."', {sort: $('#sort-ajax').val(), code: '{$kode}'}, function(hasil){"
            . "var data = $.parseJSON(hasil);"
            . "if(data.status == 2){"
              . "$('#chat-box').prepend(data.html);"
              . "$('#sort-ajax').val(data.sort);"
            . "}"
//            . "load_chat();"
          . "});"
        . "}"
        . "load_chat();"

      . "</script>";
      
//      $this->debug($quo_array, true);
      $this->template->build('opt/book-fit-request', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/opt-tour/fit-request",
          'data'          => $data_array->data,
          'title'         => lang("Book Request")." {$kode}",
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'book'          => $book_array->data,
          'itin_req'      => $itin_array->data,
          'quo'           => $quo_array->data,
          'cp'            => $cp_array->data,
          'pax'           => $pax_array->data,
          'log'           => $log_array->data,
          'price_tag'     => $price_tag_array->data,
          'hpp'           => $hpp_array->data,
        ));
      $this->template
        ->set_layout('default')
        ->build('opt/book-fit-request');
    }
  }
  
  function quotation_request($kode){
    $pst = $this->input->post();
    
    $quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "id_users"            => $this->session->userdata("id"),
      "id_store_region"     => $pst['id_store_region'],
      "destination"         => $pst['destination'],
      "cost"                => str_replace(",", "", str_replace("Rp ", "", $pst['cost'])),
      "airline"             => $pst['airline'],
      "hotel"               => $pst['hotel'],
      "stars"               => $pst['stars'],
      "note"                => $pst['note'],
//      "time_limit"          => $time_limit,
      "fare_est"            => str_replace(",", "", str_replace("Rp ", "", $pst['fare_est'])),
    );
    $quo = $this->antavaya_lib->curl_mentah($quo_post, URLSERVER."json/json-tour-fit/set-tour-fit-quotation");
    $quo_array = json_decode($quo);
//    $this->debug($quo, true);
    if($quo_array->status == 2){
      
      $users_opt = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
      $users_to_users = $this->global_models->get("m_users", array("id_users" => $quo_array->users));
      
      $users_to = $this->global_models->get_query("SELECT A.email"
        . " FROM m_users AS A"
        . " LEFT JOIN d_user_privilege AS B ON A.id_users = B.id_users"
        . " LEFT JOIN m_privilege AS C ON B.id_privilege = C.id_privilege"
        . " WHERE C.name LIKE 'Portal - FIT Opt'");
      $email_to[] = $users_to_users[0]->email;
      foreach($users_to AS $ut){
        $email_to[] = $ut->email;
      }

      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());
      $this->email->from($users_opt[0]->email, $users_opt[0]->name);
      $this->email->to($email_to);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[FIT] Quotation FIT {$kode}");
      $this->email->message("
        Dear {$users_to_users[0]->name} <br />
        Untuk book code <a href='".site_url("tour-fit/book-fit-request/{$kode}")."'>{$kode}</a><br />
        Sudah dibuatkan quotation dan skema harga <br />
        Terima Kasih <br />
        {$users_opt[0]->name}
        ");

      $this->email->send();
      
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/opt-tour/book-fit-request/{$kode}");
  }
  
  function set_fit_request_price_tag($kode){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    foreach($pst['title'] AS $key => $title){
      $post = array(
        "users"                   => USERSSERVER,
        "password"                => PASSSERVER,
        "id_users"                => $this->session->userdata('id'),
        "id_store_region"         => $this->session->userdata('id_store_region'),
        "code"                    => $kode,
        "title"                   => $title,
        "id_tour_fit_request_price_tag" => $pst['id_tour_fit_request_price_tag'][$key],
        "adult_triple_twin"       => str_replace(",","",str_replace("Rp ","",$pst['adult_triple_twin'][$key])),
        "adult_triple_twin_sell"  => str_replace(",","",str_replace("Rp ","",$pst['adult_triple_twin_sell'][$key])),
        "adult_sgl_supp"          => str_replace(",","",str_replace("Rp ","",$pst['adult_sgl_supp'][$key])),
        "adult_sgl_supp_sell"     => str_replace(",","",str_replace("Rp ","",$pst['adult_sgl_supp_sell'][$key])),
        "child_twin_bed"          => str_replace(",","",str_replace("Rp ","",$pst['child_twin_bed'][$key])),
        "child_twin_bed_sell"     => str_replace(",","",str_replace("Rp ","",$pst['child_twin_bed_sell'][$key])),
        "child_extra_bed"         => str_replace(",","",str_replace("Rp ","",$pst['child_extra_bed'][$key])),
        "child_extra_bed_sell"    => str_replace(",","",str_replace("Rp ","",$pst['child_extra_bed_sell'][$key])),
        "child_no_bed"            => str_replace(",","",str_replace("Rp ","",$pst['child_no_bed'][$key])),
        "child_no_bed_sell"       => str_replace(",","",str_replace("Rp ","",$pst['child_no_bed_sell'][$key])),
        "adult_fare"              => str_replace(",","",str_replace("Rp ","",$pst['adult_fare'][$key])),
        "adult_fare_sell"         => str_replace(",","",str_replace("Rp ","",$pst['adult_fare_sell'][$key])),
        "child_fare"              => str_replace(",","",str_replace("Rp ","",$pst['child_fare'][$key])),
        "child_fare_sell"         => str_replace(",","",str_replace("Rp ","",$pst['child_fare_sell'][$key])),
        "infant_fare"             => str_replace(",","",str_replace("Rp ","",$pst['infant_fare'][$key])),
        "infant_fare_sell"        => str_replace(",","",str_replace("Rp ","",$pst['infant_fare_sell'][$key])),
        "sort"                    => $key,
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-price-tag");
      $data_array = json_decode($data);
      if($data_array->update == 2){
        $update = 2;
      }
    }
    if($update == 2){
      $users_opt = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
      $users_to_users = $this->global_models->get("m_users", array("id_users" => $data_array->users));
      
      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());
      $this->email->from($users_opt[0]->email, $users_opt[0]->name);
      $this->email->to($users_to_users[0]->email);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[FIT] Quotation Update Skema Harga {$kode}");
      $this->email->message("
        Dear {$users_to_users[0]->name} <br />
        Untuk book code <a href='".site_url("tour-fit/book-fit-request/{$kode}")."'>{$kode}</a><br />
        Terdapat perubahan skema harga <br />
        Terima Kasih <br />
        {$users_opt[0]->name}
        ");

      $this->email->send();
    }
    $post2 = array(
      "users"                   => USERSSERVER,
      "password"                => PASSSERVER,
      "id_users"                => $this->session->userdata('id'),
      "code"                    => $kode,
      "status"                  => 7,
    );
    $data2 = $this->global_variable->curl_mentah($post2, URLSERVER."json/json-tour-fit/set-status-fit-request");
//    $this->debug($data2, true);
    redirect("tour/opt-tour/book-fit-request/{$kode}");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */