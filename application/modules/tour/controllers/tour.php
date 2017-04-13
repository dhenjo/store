<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function search(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "tour_search_start"             => $pst['tour_search_start'],
        "tour_search_end"               => $pst['tour_search_end'],
        "tour_search_kode"              => $pst['tour_search_kode'],
        "tour_search_no_pn"             => $pst['tour_search_no_pn'],
        "tour_search_title"             => $pst['tour_search_title'],
        "tour_search_id_store_region"   => $pst['tour_search_id_store_region'],
        "tour_search_destination"       => $pst['tour_search_destination'],
        "tour_search_landmark"          => $pst['tour_search_landmark'],
        "tour_search_status"            => $pst['tour_search_status'],
        "tour_search_sub_category"      => $pst['tour_search_sub_category'],
        "tour_search_category_product"  => $pst['tour_search_category_product'],
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
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.js' type='text/javascript'></script>";
    
//    $script_tambahan = "<script>"
//      . '$(".tooltip-title").tooltipster({'
//        . 'content: "Loading...",'
//        . "functionBefore: function(origin, continueTooltip) {"
//          . "continueTooltip();"
//          . 'if (origin.data("ajax") !== "cached") {'
//            . "$.ajax({ "
//              . 'type: "POST",'
//              . 'url: "example.php",'
//              . 'success: function(data) {'
//                . 'origin.tooltipster("content", data).data("ajax", "cached");'
//              . "}"
//            . "});"
//          . "}"
//        . "}"
//      . "});"
//      . "</script>";
	  
    $foot .= "<script>"
      
      . "$(document).on( 'click', '#clear', function (evt) {"
        . "localStorage.removeItem('nbsview1');"
        . "localStorage.removeItem('nbsview2');"
        . "localStorage.removeItem('nbsview3');"
        . "localStorage.removeItem('nbsview4');"
        . "localStorage.removeItem('nbsview5');"
        . "localStorage.removeItem('nbsview6');"
        . "localStorage.removeItem('nbsview7');"
        . "alert('Done');"
      . "});"
      
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
//          . '"order": [[ 0, "desc" ]],'
          . ' "aaSorting": []'
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
        . '$.post("'.site_url("tour/ajax/get-tour-product").'/"+mulai, function(data){'
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
     
    $this->template->build('search', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/search",
        'data'          => $data_array->data,
        'title'         => lang("Search Tour"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('search');
  }
  
  function fit_hotel(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_start"             => $pst['fit_search_start'],
        "fit_search_end"               => $pst['fit_search_end'],
        "fit_search_title"             => $pst['fit_search_title'],
        "fit_search_hotel"             => $pst['fit_search_hotel'],
        "fit_search_id_store_region"   => $pst['fit_search_id_store_region'],
        "fit_search_kode"              => $pst['fit_search_kode'],
        "fit_search_region"            => $pst['fit_search_region'],
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
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.js' type='text/javascript'></script>";
    
//    $script_tambahan = "<script>"
//      . '$(".tooltip-title").tooltipster({'
//        . 'content: "Loading...",'
//        . "functionBefore: function(origin, continueTooltip) {"
//          . "continueTooltip();"
//          . 'if (origin.data("ajax") !== "cached") {'
//            . "$.ajax({ "
//              . 'type: "POST",'
//              . 'url: "example.php",'
//              . 'success: function(data) {'
//                . 'origin.tooltipster("content", data).data("ajax", "cached");'
//              . "}"
//            . "});"
//          . "}"
//        . "}"
//      . "});"
//      . "</script>";
	  
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
        . '$.post("'.site_url("tour/ajax/get-tour-product-fit").'/"+mulai, function(data){'
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
     
    $this->template->build('fit-hotel', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/fit-hotel",
        'data'          => $data_array->data,
        'title'         => lang("Search FIT Hotel"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('fit-hotel');
  }
  
  function book_list_fit_hotel(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_start"             => $pst['fit_search_start'],
        "fit_search_end"               => $pst['fit_search_end'],
        "fit_search_title"             => $pst['fit_search_title'],
        "fit_search_hotel"             => $pst['fit_search_hotel'],
        "fit_search_id_store_region"   => $pst['fit_search_id_store_region'],
        "fit_search_kode"              => $pst['fit_search_kode'],
        "fit_search_region"            => $pst['fit_search_region'],
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
        . '$.post("'.site_url("tour/ajax/get-book-tour-fit").'/"+mulai, function(data){'
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
     
    $this->template->build('book-list-fit-hotel', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/book-list-fit-hotel",
        'data'          => $data_array->data,
        'title'         => lang("All Book FIT"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('book-list-fit-hotel');
  }
  
  function monitoring_book($code_tour_information){
    $pst = $this->input->post(NULL);
    if($pst){
      $newdata = array(
        'book_list_start_date'                   => $pst['start_date'],
        'book_list_end_date'                      => $pst['end_date'],
        'book_list_Tour_title'                      => $pst['title'],
        'book_list_name'                 => $pst['name'],
        'book_list_code'                   => $pst['code'],
        'book_list_status'                   => $pst['status'],
      );
      $this->session->set_userdata($newdata);
    }
    
    $data = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "start_date"      => $this->session->userdata('book_list_start_date'),
      "end_date"        => $this->session->userdata('book_list_end_date'),
      "title"           => $this->session->userdata('book_list_tour_title'),
      "name"            => $this->session->userdata('book_list_name'),
      "code"            => $this->session->userdata('book_list_code'),
      "status"          => $this->session->userdata('book_list_status'),
      "limit"           => 10,
      "id_users"        => $this->session->userdata("id"),
     );
    $data = $this->global_variable->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list");  
    $data_array = json_decode($data);
//    print $data_array->total; die;
    $url_list = site_url("tour/ajax/book-list/".$data_array->total);
    $url_list_halaman = site_url("tour/ajax/halaman-default/".$data_array->total);
    
    $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
       
        <script type='text/javascript'>
             $(document).ready(function () { 
           
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });  
            })
        </script>";
    $foot .= "<script type='text/javascript'>"
		. "$(document).on('click', '#id-customer-cancel', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id_customer_book').val(id);"
      . "});"
	  
      ."function get_list(start){"
        ."if(typeof start === 'undefined'){"
         ."start = 0;"
          ."}"
           ."$.post('{$url_list}/'+start, function(data){"
            ."$('#data_list').html(data);"
             ."$.post('{$url_list_halaman}/'+start, function(data){"
              ."$('#halaman_set').html(data);"
               ." });"
                ."});"
            ."}"
            ."get_list(0);"
      . "</script> ";
             
   // print_r($serach_data); die;
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('title', $this->session->userdata('book_list_Tour_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('code', $this->session->userdata('book_list_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $this->session->userdata('book_list_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $this->session->userdata('book_list_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('name', $this->session->userdata('book_list_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Status</label><br>"
            . "{$this->form_eksternal->form_dropdown('status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_status')), ' class="form-control input-sm"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
	 $link = site_url('store/cancel-book/2');
    $before_table .= "<div class='modal fade' id='edit-keterangan-cancel' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                <h4 class='modal-title'>Note Cancel</h4>
            </div>
            <form action='{$link}' method='post'>
                <div class='modal-body'>
                    <div class='form-group'>
                        <div class='input-group'>
<!--                            <span class='input-group-addon'>Note Cancel:</span>-->
                            <input name='book_code' class='form-control' id='dt_id_customer_book' style='display: none'>
                            <textarea name='note_cancel' placeholder='Note Cancel' style='margin: 0px; width: 553px; height: 227px;'></textarea>
                        </div>
                    </div>
                </div>
                <div class='modal-footer clearfix'>

                    <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>

                    <button type='submit' class='btn btn-primary pull-left'> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>"  ;
    
    $this->template->build('monitoring-book', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "tour/monitoring-book",
          'data'          => $data_array,
          'title'         => lang("Monitoring Book"),
          'category'      => $category,
          'sub_category'  => $sub_category,
          'foot'          => $foot,
          'css'           => $css,
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout('tableajax')
      ->build('monitoring-book');
  }
  
  function book_view($book_code){
    
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
      "dt_users"        => $this->session->userdata("id")
    );
    
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
    
    $foot .= ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script type='text/javascript'>"
      . "$(document).on('click', '#print-price-detail', function(evt){"
        . "window.open('".site_url("store/print-store/price-detail/{$book_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
        . '$("#table-ttue").DataTable({'
          . 'order: [[ 0, "desc" ]]'
        . '});'
      . "</script>";
    
    $post_discount = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "code"                      => $book_code,
    );

    $get_discount = $this->global_variable->curl_mentah($post_discount, URLSERVER."json/json-tour/get-discount");
    $get_discount_array = json_decode($get_discount);
    
//    $this->debug($detail_array, true);

    $this->template->build('book-view', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/product-tour",
            'data'        => $detail_array,
            'add_req2'    => $arr_additional,
            'discount'    => $get_discount_array->data,
            'title'       => lang("Book {$book_code}"),
            'book_code'   => $book_code,
            'foot'        => $foot,
            'breadcrumb'  => array(
            "product_tour"  => "grouptour/product-tour/book-list"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('book-view');
  }
  
  function sales_lead(){
    $list = $this->global_models->get_query("SELECT B.*, A.name AS ayah
      FROM m_menu AS A
      RIGHT JOIN m_menu AS B ON A.id_menu = B.parent
      GROUP BY B.id_menu");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= '<script type="text/javascript">'
      . '$(function() {'
        . 'var table = '
        . '$("#hasil").dataTable({'
          . '"order": [[ 0, "desc" ]]'
        . '});'
        . 'ambil_data(table, 0);'
      . '});'
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/ajax/get-sales-lead").'/"+mulai, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'table.fnAddData(hasil.hasil);'
          . 'if(hasil.status == 2){'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
          . '}'
        . '});'
      . '}'
    . '</script>';
    $menutable = '
      <li><a href="'.site_url("tour/add-sales-lead").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('main', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "tour/sales-lead",
//            'data'        => $list,
            'title'       => lang("Sales Lead"),
            'foot'        => $foot,
            'css'         => $css,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('default')
      ->build('main');
  }
  
  public function add_sales_lead(){
    if(!$this->input->post(NULL)){
      
      $this->template->build("add-sales-lead", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'tour/sales-lead',
              'title'       => lang("Form Sales Lead"),
              'breadcrumb'  => array(
                    "Sales Lead"  => "tour/sales-lead"
                ),
            ));
      $this->template
        ->set_layout('form')
        ->build("add-sales-lead");
    }
    else{
      $pst = $this->input->post(NULL);
      $post = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
        "fisrt_name"  => $pst['first_name'],
        "last_name"   => $pst['last_name'],
        "email"       => $pst['email'],
        "telphone"    => $pst['telp'],
        "note"        => $pst['note'],
        "id_users"    => $this->session->userdata("id"),
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/set-sales-lead");  
      $data_array = json_decode($data);
      
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/sales-lead");
    }
  }
  
  public function harga_all_in($book_code){
    if(!$this->input->post(NULL)){
      
      $this->template->build("harga-all-in", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "grouptour/product-tour",
              'book_code'   => $book_code,
              'title'       => "Yakin Menjadikan Book {$book_code} ini Menjadi Harga All in?",
            ));
      $this->template
        ->set_layout('form')
        ->build("harga-all-in");
    }
    else{
      $pst = $this->input->post(NULL);
      $post = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
        "code"        => $pst['code'],
        "id_users"    => $this->session->userdata("id"),
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/adjust-harga-all-in");  
      $data_array = json_decode($data);
      
      if($data_array->status == 2){
        $kirim = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "kode"                      => $pst['code'],
            "name"                      => $this->session->userdata("name"),
            "note"                      => "Penggunaan Harga All in. Mohon masukan harga keseluruhan",
            "create_by_users"           => $this->session->userdata("id"),
            "create_date"               => date("Y-m-d H:i:s"),
        );
          
        $discount_detail = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/insert-log-request-additional-tour");
        $discount_array = json_decode($discount_detail);
		  
        $kirim_additional = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "note"                      => "Penggunaan Harga All in. Mohon masukan harga keseluruhan",
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $pst['code'],
              
        );
        $this->global_variable->curl_mentah($kirim_additional, URLSERVER."json/json-mail/chat-additional");
        
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("grouptour/product-tour/book-information/{$book_code}");
    }
  }
  
  function list_tour_book($code){
    $pst = $this->input->post();
    if($pst){
      $set = array(
        "tour_book_start"   => $pst['tour_book_start'],
        "tour_book_end"     => $pst['tour_book_end'],
        "tour_book_status"  => $pst['tour_book_status'],
        "tour_store_real"   => $pst['tour_store_real'],
      );
      $this->session->set_userdata($set);
    }
    if($this->session->userdata("tour_book_status") == 1){
      $stat1 = "";
    }
    else if ($this->session->userdata("tour_book_status") == 2){
      $stat1 = "AND A.status = 2";
    }
    else if ($this->session->userdata("tour_book_status") == 3){
      $stat1 = "AND A.status = 3";
    }
    else if ($this->session->userdata("tour_book_status") == 4){
      $stat1 = "AND (A.status = 2 OR A.status = 3)";
    }
    else if ($this->session->userdata("tour_book_status") == 5){
      $stat1 = "AND A.status = 1";
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
      "status"      => $stat1,
      "start"       => $this->session->userdata("tour_book_start"),
      "end"         => $this->session->userdata("tour_book_end"),
      "id_store"    => $this->session->userdata("tour_store_real"),
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-list-tour-book");
    $data_array = json_decode($data);
//    $this->debug($data, true);    
    $post_tour = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
    );
//    $this->debug($post, true);
    $data_tour = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-information-detail");
    $data_tour_array = json_decode($data_tour);
//    $this->debug($data_array, true);
    
    $status = array(
      NULL => "<span class='label label-warning' style='color: black !important'>Book</span>",
      1 => "<span class='label label-warning' style='color: black !important'>Book</span>",
      2 => "<span class='label label-info' style='color: black !important'>Deposit</span>",
      3 => "<span class='label label-success' style='color: black !important'>Lunas</span>",
      4 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      5 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      6 => "<span class='label label-danger' style='color: black !important'>Cancel <br />Wait Approval</span>",
      7 => "<span class='label label-danger' style='color: black !important'>Change Tour <br />Wait Approval</span>",
      8 => "<span class='label label-danger' style='color: black !important'>Cancel<br />Change Tour</span>",  
      9 => "<span class='label label-danger' style='color: black !important'>Reject <br />Change Tour</span>",
    );
    $total = $data_store = array();
    foreach ($data_array->data AS $key => $dt){
      
      $cetak .= "<tr>"
        . "<td>{$dt->tanggal}</td>"
        . "<td><a href='".site_url("grouptour/product-tour/book-information/{$dt->kode}")."'>{$dt->kode}</a></td>"
        . "<td>{$dt->store}{$dt->store2}</td>"
        . "<td>"
          . "{$dt->first_name} {$dt->last_name} <br />"
          . "{$dt->telphone}"
        . "</td>"
        . "<td>{$status[$dt->status]}</td>"
        . "<td style='text-align: right'>".number_format(($dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp))."</td>"
        . "<td style='text-align: right'>".number_format($dt->kredit)."</td>"
        . "<td style='text-align: right'>".number_format($dt->debit)."</td>"
        . "<td style='text-align: right'>".number_format(($dt->kredit-$dt->debit))."</td>"
      . "</tr>";
      $total['pax'] += ($dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp);
      $total['penjualan'] += $dt->kredit;
      $total['deposit']   += $dt->debit;
      
    }
//    $this->debug($total, true);
    $post_store_real = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store_real = $this->antavaya_lib->curl_mentah($post_store_real, URLSERVER."json/json-midlle-system/get-all-store");
    $store_real = json_decode($data_store_real);
    
    $labels = $data_pax = "";
    $store_dd[NULL] = '- Pilih -';
    foreach ($store_real->data AS $sd){
      $store_dd[$sd->id_store] = $sd->title;
    }
    
//    $this->debug($store->data);
//    $this->debug($total);
//    $this->debug($data_penjualan, true);
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.core.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.doughnut.js' type='text/javascript'></script>"
      . "";
    $foot .= "<script>"
      
      . "$(function() {"
        . "$('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "});"
      
      . "$('#cari-status').change(function(){"
        . 'window.location = "'.site_url("tour/list-tour-book/{$code}/").'/"+$("#cari-status").val();'
      . "});"
      
      . "</script>";
     
    $this->template->build('list-tour-book', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/tour-close",
        'data'          => $data_array->data,
        'title'         => lang("List Tour Book"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd,
        'info'          => $data_tour_array,
        'stat'          => $stat
      ));
    $this->template
      ->set_layout('default')
      ->build('list-tour-book');
  }
  
  function list_tour_book_umum($code, $stat){
    
    if($stat == 1){
      $stat1 = "";
    }
    else if ($stat == 2){
      $stat1 = "AND A.status = 2";
    }
    else if ($stat == 3){
      $stat1 = "AND A.status = 3";
    }
    else if ($stat == 4){
      $stat1 = "AND (A.status = 2 OR A.status = 3)";
    }
    else if ($stat == 5){
      $stat1 = "AND A.status = 1";
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
      "status"      => $stat1,
    );
//    $this->debug($post, true);
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-list-tour-book");
    $data_array = json_decode($data);
    
    $post_tour = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
    );
//    $this->debug($post, true);
    $data_tour = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-information-detail");
    $data_tour_array = json_decode($data_tour);
//    $this->debug($data_array, true);
    
    $status = array(
      NULL => "<span class='label label-warning' style='color: black !important'>Book</span>",
      1 => "<span class='label label-warning' style='color: black !important'>Book</span>",
      2 => "<span class='label label-info' style='color: black !important'>Deposit</span>",
      3 => "<span class='label label-success' style='color: black !important'>Lunas</span>",
      4 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      5 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      6 => "<span class='label label-danger' style='color: black !important'>Cancel <br />Wait Approval</span>",
      7 => "<span class='label label-danger' style='color: black !important'>Change Tour <br />Wait Approval</span>",
      8 => "<span class='label label-danger' style='color: black !important'>Cancel<br />Change Tour</span>",  
      9 => "<span class='label label-danger' style='color: black !important'>Reject <br />Change Tour</span>",
    );
    $total = $data_store = array();
    foreach ($data_array->data AS $key => $dt){
      
      $cetak .= "<tr>"
        . "<td><a href='".site_url("grouptour/product-tour/book-information/{$dt->kode}")."'>{$dt->kode}</a></td>"
        . "<td>{$dt->store}{$dt->store2}</td>"
        . "<td>"
          . "{$dt->first_name} {$dt->last_name} <br />"
          . "{$dt->telphone}"
        . "</td>"
        . "<td>{$status[$dt->status]}</td>"
        . "<td style='text-align: right'>".number_format(($dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp))."</td>"
        . "<td style='text-align: right'>".number_format($dt->kredit)."</td>"
        . "<td style='text-align: right'>".number_format($dt->debit)."</td>"
        . "<td style='text-align: right'>".number_format(($dt->kredit-$dt->debit))."</td>"
      . "</tr>";
      $total['pax'] += ($dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp);
      $total['penjualan'] += $dt->kredit;
      $total['deposit']   += $dt->debit;
      
    }
//    $this->debug($total, true);
    $labels = $data_pax = "";
    $store_dd[NULL] = '- Pilih -';
    foreach ($store->data AS $sd){
      $store_dd[$sd->id_store] = $sd->title;
      $labels .= "'{$sd->title}',";
      if($total[$sd->id_store]['penjualan'])
        $data_penjualan .= round(($total[$sd->id_store]['penjualan']/1000000), 2).",";
      else
        $data_penjualan .= "0,";
      if($total[$sd->id_store]['deposit'])
        $data_deposit .= round(($total[$sd->id_store]['deposit']/1000000), 2).",";
      else
        $data_deposit .= "0,";
      
      if($total[$sd->id_store]['ds'])
        $data_ds .= "{$total[$sd->id_store]['ds']},";
      else
        $data_ds .= "0,";
      if($total[$sd->id_store]['ls'])
        $data_ls .= "{$total[$sd->id_store]['ls']},";
      else
        $data_ls .= "0,";
    }
    
//    $this->debug($store->data);
//    $this->debug($total);
//    $this->debug($data_penjualan, true);
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.core.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.doughnut.js' type='text/javascript'></script>"
      . "";
    $foot .= "<script>"
      
      . "$(function() {"
        . "$('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "});"
      
      . "$('#cari-status').change(function(){"
        . 'window.location = "'.site_url("tour/list-tour-book/{$code}/").'/"+$("#cari-status").val();'
      . "});"
      
      . "</script>";
     
    $this->template->build('list-tour-book-umum', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/search",
        'data'          => $data_array->data,
        'title'         => lang("List Tour Book"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd,
        'info'          => $data_tour_array,
        'stat'          => $stat
      ));
    $this->template
      ->set_layout('default')
      ->build('list-tour-book-umum');
  }
  
  function room_list($code){
    
    $pst = $this->input->post();
    if($pst){
      $set = array(
        "tour_book_start"   => $pst['tour_book_start'],
        "tour_book_end"     => $pst['tour_book_end'],
        "tour_book_status"  => $pst['tour_book_status'],
      );
      $this->session->set_userdata($set);
    }
    if($this->session->userdata("tour_book_status") == 1){
      $stat = "";
    }
    else if ($this->session->userdata("tour_book_status") == 2){
      $stat = "AND A.status = 2";
    }
    else if ($this->session->userdata("tour_book_status") == 3){
      $stat = "AND A.status = 3";
    }
    else if ($this->session->userdata("tour_book_status") == 4){
      $stat = "AND (A.status = 2 OR A.status = 3)";
    }
    else if ($this->session->userdata("tour_book_status") == 5){
      $stat = "AND A.status = 1";
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
      "status"      => $stat,
      "start"       => $this->session->userdata("tour_book_start"),
      "end"         => $this->session->userdata("tour_book_end"),
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-room-list");
    $data_array = json_decode($data);
    
//    $this->debug($data);
//    $this->debug($data_array, true);
    
    $type = array(
      1 => "Adult Triple/Twin",
      2 => "Child Twin Bed",
      3 => "Child Extra Bed",
      4 => "Child No Bed",
      5 => "Adult Single",
    );
    
    $s = array(
      NULL => "<span class='label label-warning' style='color: black !important'>Book</span>",
      1 => "<span class='label label-warning' style='color: black !important'>Book</span>",
      2 => "<span class='label label-info' style='color: black !important'>Deposit</span>",
      3 => "<span class='label label-success' style='color: black !important'>Lunas</span>",
      4 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      5 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      6 => "<span class='label label-danger' style='color: black !important'>Cancel <br />Wait Approval</span>",
      7 => "<span class='label label-danger' style='color: black !important'>Change Tour <br />Wait Approval</span>",
      8 => "<span class='label label-danger' style='color: black !important'>Cancel<br />Change Tour</span>",  
      9 => "<span class='label label-danger' style='color: black !important'>Reject <br />Change Tour</span>",
    );
    $hasil = $tooltips = "";
    $no = 1;
    foreach($data_array->pax AS $pax){
      if($pax->visa){
        $visa = "Include";
      }
      else{
        $visa = "Not Include";
      }
      if($pax->less_ticket){
        $less_ticket = "Less Ticket";
      }
      else{
        $less_ticket = "Ticket";
      }
      
      if($pax->sort < 100){
        if($no <= $data_array->tour->seats){
          $background = "";
        }
        else{
          $background = "style='background-color: #b0e0e6'";
        }
      }
      else{
        $background = "style='background-color: #b0e0e6'";
      }
      
      $hasil .= "<tr {$background}>"
        . "<td>{$no}</td>"
        . "<td><a href='".site_url("grouptour/product-tour/book-information/{$pax->book_code}")."'>{$pax->book_code}</a></td>"
        . "<td><a href='#compose-modal' class='edit-pax' isi='{$pax->kode}' id='info{$pax->kode}' data-toggle='modal' data-target='#compose-modal'>{$pax->first_name} {$pax->last_name}</a></td>"
        . "<td>{$s[$pax->status]}</td>"
        . "<td>{$type[$pax->type]}</td>"
        . "<td>{$pax->room_no}</td>"
        . "<td>{$pax->passport}</td>"
        . "<td>{$pax->date_of_expired}</td>"
        . "<td>{$pax->tanggal_lahir}</td>"
      . "</tr>"
      . "<div style='display: none' id='isiinfo{$pax->kode}'>"
        . "<p>"
          . "Visa : {$visa}<br />"
          . "Less Ticket : {$less_ticket}<br />"
        . "</p>"
        . "<hr />"
        . "<p>"
          . nl2br($pax->note)
        . "</p>"
      . "</div>"
      . "";
      $tooltips .= "$('#info{$pax->kode}').tooltipster({"
        . "content: $('#isiinfo{$pax->kode}').html(),"
        . "minWidth: 300,"
        . "maxWidth: 300,"
        . "contentAsHTML: true,"
        . "interactive: true"
      . "});";
      $no++;
    }
    
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.doughnut.js' type='text/javascript'></script>"
      . "";
    
    $foot .= "<script>"
      . "$(function() {"
        . "var table = $('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      
        . "$('#cari-status').change(function(){"
          . 'window.location = "'.site_url("tour/room-list/{$code}/").'/"+$("#cari-status").val();'
        . "});"
      
      . "});"
      . $tooltips
      . "$(document).on('click', '.edit-pax', function(evt){"
        . "var code = $(this).attr('isi');"
        . "$.post('".site_url("store/ajax/edit-pax-book")."', {code: code},function(data){"
          . "var hasil = $.parseJSON(data);"
          . "$('#edit-room').val(hasil.data.room);"
          . "$('#edit-type').val(hasil.data.type);"
          . "$('#edit-first-name').val(hasil.data.first_name);"
          . "$('#edit-last-name').val(hasil.data.last_name);"
          . "$('#edit-telp').val(hasil.data.telphone);"
          . "$('#edit-tempat-lahir').val(hasil.data.tempat_tanggal_lahir);"
          . "$('#edit-tanggal-lahir').val(hasil.data.tanggal_lahir);"
          . "$('#edit-passport').val(hasil.data.passport);"
          . "$('#edit-place-of-issued').val(hasil.data.place_of_issued);"
          . "$('#edit-date-of-issued').val(hasil.data.date_of_issued);"
          . "$('#edit-date-of-expired').val(hasil.data.date_of_expired);"
          . "$('#edit-note').val(hasil.data.note);"
          . "$('#edit-code').val(hasil.data.kode);"
          . "$('#edit-visa').val(hasil.data.visa);"
          . "$('#edit-less-ticket').val(hasil.data.less_ticket);"
          . "$('#edit-book-code').val(hasil.data.book_code);"
        . "});"
      . "});"
      . "</script>";
     
    $this->template->build('room-list', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/tour-close",
        'data_table'    => $hasil,
        'data'          => $data_array,
        'title'         => lang("Room List"),
        'foot'          => $foot,
        'css'           => $css,
        'status'        => $status
      ));
    $this->template
      ->set_layout('default')
      ->build('room-list');
  }
  
  function room_list_umum($code, $status = 1){
    
    if($status == 1){
      $stat = "";
    }
    else if ($status == 2){
      $stat = "AND A.status = 2";
    }
    else if ($status == 3){
      $stat = "AND A.status = 3";
    }
    else if ($status == 4){
      $stat = "AND (A.status = 2 OR A.status = 3)";
    }
    else if ($status == 5){
      $stat = "AND A.status = 1";
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
      "status"      => $stat,
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-room-list");
    $data_array = json_decode($data);
    
//    $this->debug($data);
//    $this->debug($data_array, true);
    
    $type = array(
      1 => "Adult Triple/Twin",
      2 => "Child Twin Bed",
      3 => "Child Extra Bed",
      4 => "Child No Bed",
      5 => "Adult Single",
    );
    $s = array(
      NULL => "<span class='label label-warning' style='color: black !important'>Book</span>",
      1 => "<span class='label label-warning' style='color: black !important'>Book</span>",
      2 => "<span class='label label-info' style='color: black !important'>Deposit</span>",
      3 => "<span class='label label-success' style='color: black !important'>Lunas</span>",
      4 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      5 => "<span class='label label-warning' style='color: black !important'>Cancel</span>",
      6 => "<span class='label label-danger' style='color: black !important'>Cancel <br />Wait Approval</span>",
      7 => "<span class='label label-danger' style='color: black !important'>Change Tour <br />Wait Approval</span>",
      8 => "<span class='label label-danger' style='color: black !important'>Cancel<br />Change Tour</span>",  
      9 => "<span class='label label-danger' style='color: black !important'>Reject <br />Change Tour</span>",
    );
    $hasil = $tooltips = "";
    $no = 1;
    foreach($data_array->pax AS $pax){
      if($pax->visa){
        $visa = "Include";
      }
      else{
        $visa = "Not Include";
      }
      if($pax->less_ticket){
        $less_ticket = "Less Ticket";
      }
      else{
        $less_ticket = "Ticket";
      }
      
      if($pax->sort < 100){
        if($no <= $data_array->tour->seats){
          $background = "";
        }
        else{
          $background = "style='background-color: #b0e0e6'";
        }
      }
      else{
        $background = "style='background-color: #b0e0e6'";
      }
      
      $hasil .= "<tr {$background}>"
        . "<td>{$no}</td>"
        . "<td><a href='".site_url("grouptour/product-tour/book-information/{$pax->book_code}")."'>{$pax->book_code}</a></td>"
        . "<td><a href='#' class='edit-pax' isi='{$pax->kode}' id='info{$pax->kode}'>{$pax->first_name} {$pax->last_name}</a></td>"
        . "<td>{$s[$pax->status]}</td>"
        . "<td>{$type[$pax->type]}</td>"
        . "<td>{$pax->room_no}</td>"
        . "<td>{$pax->passport}</td>"
        . "<td>{$pax->date_of_expired}</td>"
        . "<td>{$pax->tanggal_lahir}</td>"
      . "</tr>"
      . "<div style='display: none' id='isiinfo{$pax->kode}'>"
        . "<p>"
          . "Visa : {$visa}<br />"
          . "Less Ticket : {$less_ticket}<br />"
        . "</p>"
        . "<hr />"
        . "<p>"
          . nl2br($pax->note)
        . "</p>"
      . "</div>"
      . "";
      $tooltips .= "$('#info{$pax->kode}').tooltipster({"
        . "content: $('#isiinfo{$pax->kode}').html(),"
        . "minWidth: 300,"
        . "maxWidth: 300,"
        . "contentAsHTML: true,"
        . "interactive: true"
      . "});";
      $no++;
    }
    
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.doughnut.js' type='text/javascript'></script>"
      . "";
    
    $foot .= "<script>"
      . "$(function() {"
        . "var table = $('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      
        . "$('#cari-status').change(function(){"
          . 'window.location = "'.site_url("tour/room-list/{$code}/").'/"+$("#cari-status").val();'
        . "});"
      
      . "});"
      . $tooltips
      . "$(document).on('click', '.edit-pax', function(evt){"
        . "var code = $(this).attr('isi');"
        . "$.post('".site_url("store/ajax/edit-pax-book")."', {code: code},function(data){"
          . "var hasil = $.parseJSON(data);"
          . "$('#edit-room').val(hasil.data.room);"
          . "$('#edit-type').val(hasil.data.type);"
          . "$('#edit-first-name').val(hasil.data.first_name);"
          . "$('#edit-last-name').val(hasil.data.last_name);"
          . "$('#edit-telp').val(hasil.data.telphone);"
          . "$('#edit-tempat-lahir').val(hasil.data.tempat_tanggal_lahir);"
          . "$('#edit-tanggal-lahir').val(hasil.data.tanggal_lahir);"
          . "$('#edit-passport').val(hasil.data.passport);"
          . "$('#edit-place-of-issued').val(hasil.data.place_of_issued);"
          . "$('#edit-date-of-issued').val(hasil.data.date_of_issued);"
          . "$('#edit-date-of-expired').val(hasil.data.date_of_expired);"
          . "$('#edit-note').val(hasil.data.note);"
          . "$('#edit-code').val(hasil.data.kode);"
          . "$('#edit-visa').val(hasil.data.visa);"
          . "$('#edit-less-ticket').val(hasil.data.less_ticket);"
          . "$('#edit-book-code').val(hasil.data.book_code);"
        . "});"
      . "});"
      . "</script>";
     
    $this->template->build('room-list-umum', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/search",
        'data_table'    => $hasil,
        'data'          => $data_array,
        'title'         => lang("Room List"),
        'foot'          => $foot,
        'css'           => $css,
        'status'        => $status
      ));
    $this->template
      ->set_layout('default')
      ->build('room-list-umum');
  }
  
  function edit_book_pax(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $post = array(
      "users"                 => USERSSERVER,
      "password"              => PASSSERVER,
      "id_users"              => $this->session->userdata("id"),
      "code"                  => $pst['code'],
      "book_code"             => $pst['book_code'],
      "first_name"            => $pst['first_name'],
      "last_name"             => $pst['last_name'],
      "tanggal_lahir"         => $pst['tanggal_lahir'],
      "tempat_lahir"          => $pst['tempat_lahir'],
      "type"                  => $pst['type'],
      "room"                  => $pst['room'],
      "visa"                  => $pst['visa'],
      "less_ticket"           => $pst['less_ticket'],
      "passport"              => $pst['passport'],
      "place_of_issued"       => $pst['place_of_issued'],
      "date_of_issued"        => $pst['date_of_issued'],
      "date_of_expired"       => $pst['date_of_expired'],
      "telp"                  => $pst['telp'],
      "note"                  => $pst['note'],
    );
    
    $pax = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/update-pax-book");
    $pax_array = json_decode($pax);
//    $this->debug($pax, true);
    if($pax_array->status == 2){
      $this->session->set_flashdata('success', 'Update Customer Berhasil');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal');
    }
    redirect("tour/room-list/{$pst['code_pax']}/{$pst['sort']}");
  }
  
  function book_fit($kode){
    
    $pst = $this->input->post();
    if($pst){
      $post_store = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
      );
      $store = $this->antavaya_lib->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "fit_schedule"        => $kode,
        "departure"           => $pst['departure'],
        "name"                => $pst['name'],
        "email"               => $pst['email'],
        "telp"                => $pst['telp'],
        "address"             => $pst['address'],
        "id_store"            => $this->session->userdata("id_store"),
      );
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-book-tour-fit-schedule");
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
    
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
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
            . "selectOtherYears: true"
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

      $this->template->build('book-fit', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/fit-hotel",
          'data'          => $data_array->data,
          'title'         => lang("Book FIT"),
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'cetak'         => $cetak,
          'total'         => $total,
          'store'         => $store_dd,
        ));
      $this->template
        ->set_layout('default')
        ->build('book-fit');
    }
  }
  
  function book_fit_detail($kode){
    
    $pst = $this->input->post();
    if($pst){
      $post_store = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
      );
      $store = $this->antavaya_lib->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "fit_schedule"        => $kode,
        "departure"           => $pst['departure'],
        "name"                => $pst['name'],
        "email"               => $pst['email'],
        "telp"                => $pst['telp'],
        "address"             => $pst['address'],
        "id_store"            => $store->data[0]->id_store,
      );
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-book-tour-fit-schedule");
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
    
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>"
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
        "all"               => 2
      );
//      $this->debug($price_post, true);
      $price = $this->antavaya_lib->curl_mentah($price_post, URLSERVER."json/json-tour/get-book-tour-fit-price");  
      $price_array = json_decode($price);
//      $this->debug($price_array, true);
      $this->template->build('book-fit-detail', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/book-list-fit-hotel",
          'data'          => $data_array->data,
          'title'         => lang("Book FIT")." {$kode}",
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'book'          => $book_array->data,
          'pax'           => $book_array->pax,
          'price'         => $price_array,
        ));
      $this->template
        ->set_layout('default')
        ->build('book-fit-detail');
    }
  }
  
  function edit_book_fit_pax(){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "book"              => $pst['book_code'],
      "code"              => $pst['pax_code'],
      "id_users"          => $this->session->userdata("id"),
      "title"             => $pst['title'],
      "type"              => $pst['type'],
      "pax_type"          => $pst['pax_type'],
      "first_name"        => $pst['first_name'],
      "last_name"         => $pst['last_name'],
      "telp"              => $pst['telp'],
      "email"             => $pst['email'],
      "tempat_lahir"      => $pst['tempat_lahir'],
      "tanggal_lahir"     => $pst['tanggal_lahir'],
      "passport"          => $pst['passport'],
      "tempat_passport"   => $pst['tempat_passport'],
      "tanggal_passport"  => $pst['tanggal_passport'],
      "expired_passport"  => $pst['expired_passport'],
      "note"              => $pst['note'],
    );
    $pax = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-book-tour-fit-pax");  
    $pax_array = json_decode($pax);
//    $this->debug($post);
//    $this->debug($pax, true);
    if($pax_array->status == 2)
      $this->session->set_flashdata('success', 'Data tersimpan');
    else
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    redirect("tour/book-fit-detail/{$pst['book_code']}");
  }
  
  function book_list_fit(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "tour_search_start"             => $pst['tour_search_start'],
        "tour_search_end"               => $pst['tour_search_end'],
        "tour_search_kode"              => $pst['tour_search_kode'],
        "tour_search_no_pn"             => $pst['tour_search_no_pn'],
        "tour_search_title"             => $pst['tour_search_title'],
        "tour_search_id_store_region"   => $pst['tour_search_id_store_region'],
        "tour_search_destination"       => $pst['tour_search_destination'],
        "tour_search_landmark"          => $pst['tour_search_landmark'],
        "tour_master_status"            => $pst['tour_master_status'],
        "tour_search_sub_category"      => $pst['tour_search_sub_category'],
        "tour_search_category_product"  => $pst['tour_search_category_product'],
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
        . '$.post("'.site_url("tour/ajax/get-book-list-fit").'/"+mulai, function(data){'
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
     
    $this->template->build('book-list-fit', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/book-list-fit",
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
      ->build('book-list-fit');
  }
  
  function request_tour_fit($kode, $status = 2){
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
    redirect("tour/book-fit-detail/{$kode}");
  }
  
  function payment_tour_fit($kode){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['nomor'] AND !$pst['nomor_ttu']){
        $this->session->set_flashdata('notice', 'Nomor TTU atau Deposite Harus diisi');
      }
      else{
        $post_payment = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "id_users"          => $this->session->userdata("id"),
          "code"              => $kode,
          "nomor"             => $pst['nomor'],
          "nomor_ttu"         => $pst['nomor_ttu'],
          "price"             => str_replace("Rp ", "", str_replace(",", "", $pst['price'])),
        );
        $payment = $this->antavaya_lib->curl_mentah($post_payment, URLSERVER."json/json-tour/set-payment-book-fit");
        $payment_array = json_decode($payment);

        if($payment_array->status == 2)
          $this->session->set_flashdata('success', 'Data tersimpan');
        else
          $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/book-fit-detail/{$kode}");
    }
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>";
	  
    $foot .= "<script>"
      . '$(function() {'  
        . "$('.harga').priceFormat({"
          . "prefix: 'Rp ',"
          . "centsLimit: 0"
        . "});"
      . "});"
	  . "</script>";
    
    $this->template->build('payment-tour-fit', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master/fit",
        'data'          => $data_array->data,
        'title'         => lang("Payment"),
        'foot'          => $foot,
        'css'           => $css,
        'kode'         => $kode,
      ));
    $this->template
      ->set_layout('default')
      ->build('payment-tour-fit');
  }
  
  function sales_view($year){
    
    $html = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.min.js'></script>"
      . "<style>"
        . "table{"
          . "font-size: 5px;"
        . "}"
        . "td{"
          . "padding-left: 5px;"
          . "padding-right: 5px;"
        . "}"
        . ".selected{"
          . "background-color: #b2b1b1 !important;"
        . "}"
        . ".eo{"
          . "position: fixed;"
          . "bottom: 0;"
          . "z-index: 999;"
          . "background-color: #87ceeb;"
          . "margin: 5px;"
          . "padding: 10px;"
        . "}"
      . "body{"
        . "font-family: arial;"
      . "}"
      . "</style>";
    $category = array(1 => "Europe", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand");
    $botton = "<div class='eo'>";
    foreach($category AS $key => $kat){
      $block = ($key == 1 ? "block" : "none");
      $html .= "<table border='1' style='border-spacing: 0; display: {$block}' id='gory{$key}' class='tutup'>"
          . "<thead style='background-color: white'>"
            . "<tr>"
              . "<th>No</th>"
              . "<th style='width: 500px;'>Name</th>"
              . "<th style='width: 30px;'>Days</th>"
              . "<th style='width: 45px;'>P.News</th>"
              . "<th style='width: 200px;'>Remarks</th>"
              . "<th style='width: 100px;'>At Airport</th>"
              . "<th style='width: 100px;'>Dep</th>"
              . "<th style='width: 70px;'>ETD</th>"
              . "<th style='width: 100px;'>Arr</th>"
              . "<th style='width: 70px;'>ETA</th>"
              . "<th style='width: 70px;'>FLT</th>"
              . "<th style='width: 70px;'>Seats</th>"
              . "<th style='width: 70px;'>STS</th>"
              . "<th style='width: 120px;'>IN/OUT</th>"
              . "<th style='width: 50px;'>PAX</th>"
              . "<th style='width: 50px;'>DP</th>"
              . "<th style='width: 100px;'>AD Twin</th>"
              . "<th style='width: 100px;'>C Twin</th>"
              . "<th style='width: 100px;'>C E-Bed</th>"
              . "<th style='width: 100px;'>C N-Bed</th>"
              . "<th style='width: 100px;'>SGL</th>"
              . "<th style='width: 100px;'>APO</th>"
            . "</tr>"
          . "</thead>"
          . "<tbody id='isi{$key}'>"

          . "</tbody>"
          . "<tfoot>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
            . "<tr>"
              . "<td colspan='22'>&nbsp;</td>"
            . "</tr>"
          . "</tfoot>"
        . "</table>";
        $botton .= " <span style='padding: 5px'><a href='#' isi='{$key}' class='gory'>{$kat}</a></span>";
        $ambil_data .= ""
          . "if(!localStorage.getItem('nbsview{$key}')){"
            . "ambil_data(0, {$key});"
          . "}"
          . "else{"
            . "load_from_cache({$key});"
          . "}";
    }
//    $ambil_data .= "ambil_data(0, 1);";
    $botton .= "</div>";
      $link_itin = site_url("store/print-store/tour-schedule");
      $link_book = site_url("grouptour/product-tour/book-tour");
      $html .= "{$botton}"
      . "<script>"
//        . "localStorage.setItem('nbsview1', '');"
        . "function load_from_cache(cate){"
          . "var ls = localStorage.getItem('nbsview'+cate);"
          . "var pn = '';"
          . "if(ls){"
            . "var isi_temp = $.parseJSON(ls);"
            . "for(var t = 0 ; t < isi_temp.length ; t++){"
        
              . "if(pn != isi_temp[t].no_pn){"
                . "var td2 = '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';"
                . "pn = isi_temp[t].no_pn;"
                . "$('#isi'+cate).append(td2);"
              . "}"
        
              . "if(isi_temp[t].status == 5) var background = 'background-color: yellow;'; else var background='';";
          $html .= <<<EOD
                  var td = '<tr style="'+background+'"><td>'+(t+1)+'</td><td style="width: 500px;"><a href="{$link_itin}/'+isi_temp[t].code1+'/'+isi_temp[t].code2+'" target="_blank">'+isi_temp[t].title+'</a></td><td style="text-align: right;width: 30px;">'+isi_temp[t].days+'</td><td style="text-align: right;width: 45px;">'+isi_temp[t].no_pn+'</td><td style="width: 200px;"></td><td style="width: 100px;"><a href="{$link_book}/'+isi_temp[t].code2+'" target="_blank">'+isi_temp[t].at_airport+'</a></td><td style="width: 100px;">'+isi_temp[t].start_date+'</td><td style="text-align: right;width: 70px;">'+isi_temp[t].start_time+'</td><td style="width: 100px;">'+isi_temp[t].end_date+'</td><td style="text-align: right;width: 70px;">'+isi_temp[t].end_time+'</td><td style="width: 70px;">'+isi_temp[t].flt+'</td><td style="text-align: right;width: 70px;">'+isi_temp[t].available_seat+'</td><td style="width: 70px;">'+isi_temp[t].sts+'</td><td style="width: 120px;">'+isi_temp[t].in+'/ '+isi_temp[t].out+'</td><td style="text-align: right;width: 50px;">'+isi_temp[t].pax+'</td><td style="text-align: right;width: 50px;">'+isi_temp[t].dp+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].adult_triple_twin+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].child_twin_bed+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].child_extra_bed+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].child_no_bed+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].sgl_supp+'</td><td style="text-align: right;width: 100px;">'+isi_temp[t].airport_tax+'</td></tr>';
EOD;
        
    $html   .= ""
              . "$('#isi'+cate).append(td);"
            . "}"
          . "}"
        . "}"
        
        . "function ambil_data(start, cate){"
          . "$.post('".site_url("tour/tour-ajax/sales-view-get")."', {start: start, year: ".$year.", cate: cate}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "var pn = '';"
            . "if(hasil.status == 2){"
              . "for(var t = 0 ; t < hasil.data.length ; t++){"
                . "var ls = localStorage.getItem('nbsview'+cate);"
                . "if(ls){"
                  . "var isi_temp = $.parseJSON(ls);"
//        . "console.log(isi_temp);"
                  . "isi_temp[isi_temp.length] = hasil.data[t];"
//                  . "console.log(isi_temp);"
                  . "localStorage.setItem('nbsview'+cate, JSON.stringify(isi_temp));"
                . "}"
                . "else{"
                  . "var isi_ls = [hasil.data[t]];"
//        . "console.log(isi_ls);"
                  . "localStorage.setItem('nbsview'+cate, JSON.stringify(isi_ls));"
                . "}"
//                . "console.log(localStorage.getItem('nbsview'+cate));"
                . "if(pn != hasil.data[t].no_pn){"
                  . "var td2 = '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';"
                  . "pn = hasil.data[t].no_pn;"
                  . "$('#isi'+cate).append(td2);"
                . "}"
                . "if(hasil.data[t].status == 5) var background = 'background-color: yellow;'; else var background='';"
                . "";
                
                $html .= <<<EOD
                  var td = '<tr style="'+background+'"><td>'+t+'</td><td style="width: 500px;"><a href="{$link_itin}/'+hasil.data[t].code1+'/'+hasil.data[t].code2+'" target="_blank">'+hasil.data[t].title+'</a></td><td style="text-align: right;width: 30px;">'+hasil.data[t].days+'</td><td style="text-align: right;width: 45px;">'+hasil.data[t].no_pn+'</td><td style="width: 200px;"></td><td style="width: 100px;"><a href="{$link_book}/'+hasil.data[t].code2+'" target="_blank">'+hasil.data[t].at_airport+'</a></td><td style="width: 100px;">'+hasil.data[t].start_date+'</td><td style="text-align: right;width: 70px;">'+hasil.data[t].start_time+'</td><td style="width: 100px;">'+hasil.data[t].end_date+'</td><td style="text-align: right;width: 70px;">'+hasil.data[t].end_time+'</td><td style="width: 70px;">'+hasil.data[t].flt+'</td><td style="text-align: right;width: 70px;">'+hasil.data[t].available_seat+'</td><td style="width: 70px;">'+hasil.data[t].sts+'</td><td style="width: 120px;">'+hasil.data[t].in+'/ '+hasil.data[t].out+'</td><td style="text-align: right;width: 50px;">'+hasil.data[t].pax+'</td><td style="text-align: right;width: 50px;">'+hasil.data[t].dp+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].adult_triple_twin+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].child_twin_bed+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].child_extra_bed+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].child_no_bed+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].sgl_supp+'</td><td style="text-align: right;width: 100px;">'+hasil.data[t].airport_tax+'</td></tr>';
EOD;
            $html .= "$('#isi'+cate).append(td);"
                . "var tr1 = $('.tr1'+cate).width();"
//              . "console.log(tr1);"
                . "$('#htr1'+cate).width(tr1);"
              . "}"
              . "ambil_data(hasil.start, cate);"
              
            . "}"
            . "else{"
              . "var title = ['Pilih', 'Europe', 'Africa', 'America', 'Australia', 'Asia', 'China', 'New Zealand'];"
              . "alert('Done '+title[cate]);"
            . "}"
      
          . "});"
        . "}"
              
        . "$(document).on( 'click', '.gory', function (evt) {"
          . "$('.tutup').hide();"
          . "$('.gory').css('background-color', '#87ceeb');"
          . "var gory = $(this).attr('isi');"
          . "$('#gory'+gory).show();"
          . "$(this).css('background-color', '#778f9d');"
        . "});"

        . "$('tbody').on( 'click', 'tr', function () {"
          . "if ( $(this).hasClass('selected') ) {"
          . "}"
          . "else {"
            . "$('tr.selected').removeClass('selected');"
            . "$(this).addClass('selected');"
          . "}"
        . "});"
              
//        . "console.log(localStorage.getItem('nbsview1'));"
              
        . "{$ambil_data}"
      . "</script>"
      . "";
    print $html;
    die;
  }
  
  function tour_series_open(){
    
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
	  $pst = $this->input->post();
    if($pst){
      $foot .= "<script>"
        
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'asc' ]],"
          . "'responsive': true"
        . "});"
        ."ambil_data(table, 0);"
        . "function ambil_data(table, start){"
          . "$.post('".site_url("tour/tour-ajax/tour-series-open-get")."', {start: start, nomor: $('#nomor').val(), awal: '{$pst['awal']}', akhir: '{$pst['akhir']}'}, function(data){"
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
    }
    
    $this->template->build('tour-management/tour-series-open', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-series-open",
        'title'         => lang("Tour Series"),
        'foot'          => $foot,
        'css'           => $css,
      ));
    $this->template
      ->set_layout('default')
      ->build('tour-management/tour-series-open');
  }
  
  function tour_close(){
    
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-all-store");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    
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
      . "th, td { white-space: nowrap;}"
      . ".odd{"
        . "background-color: #f5f5f5; "
      . "}"
      . ".even{"
        . "background-color: #d3cabf !important; "
      . "}"
      . "div.dataTables_wrapper {
            margin: 0 auto;
        }"
      . "</style>";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.fixedColumns.min.js' type='text/javascript'></script>"
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
	  $pst = $this->input->post();
    if($pst){
      $foot .= "<script>"
        
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "order: [[ 0, 'asc' ]],"
          . "responsive: true,"
          . "scrollY: '450px',"
          . "scrollX: true,"
          . "scrollCollapse: true,"
          . "paging: false,"
          . "fixedColumns: {"
            . "leftColumns: 5,"
            . "rightColumns: 0"
          . "}"
        . "});"
        ."ambil_data(table, 0);"
        . "function ambil_data(table, start){"
          . "$.post('".site_url("tour/tour-ajax/tour-series-close-get")."', {start: start, nomor: $('#nomor').val(), awal: '{$pst['awal']}', akhir: '{$pst['akhir']}'}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(hasil.status == 2){"
              . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . "$('#nomor').val(hasil.nomor);"
                . 'for(ind2 = 0; ind2 < hasil.jumlah[ind].length; ++ind2){'
                  . 'var jml = hasil.jumlah[ind][ind2].pax * 1;'
                  . 'var tharga = hasil.jumlah[ind][ind2].harga * 1;'
            
                  . 'var jml_curr = $("#store"+hasil.jumlah[ind][ind2].id).text() * 1;'
                  . 'var tharga_curr = str_replace(",", "", $("#store-tharga"+hasil.jumlah[ind][ind2].id).text()) * 1;'
            
                  . 'var total = jml + jml_curr;'
                  . 'var total_harga = tharga + tharga_curr;'
//            . 'console.log(jml);'
//            . 'console.log(jml_curr);'
//            . 'console.log(total_harga);'
//            . 'console.log("#store"+hasil.jumlah[ind][ind2].id);'
                  . '$("#store"+hasil.jumlah[ind][ind2].id).text(total);'
                  . '$("#store-tharga"+hasil.jumlah[ind][ind2].id).text(number_format(total_harga));'
                . '}'
              . '}'
              ."ambil_data(table, hasil.start);"
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
            
        . "function number_format(number, decimals, dec_point, thousands_sep){"
        . "number = (number + '').replace(/[^0-9+\-Ee.]/g, '');"
        . "var n = !isFinite(+number) ? 0 : +number"
          . ", prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)"
          . ", sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep"
          . ", dec = (typeof dec_point === 'undefined') ? '.' : dec_point"
          . ", s = ''"
          . ", toFixedFix = function (n, prec){"
              . "var k = Math.pow(10, prec);"
              . "return '' + (Math.round(n * k) / k).toFixed(prec);"
            . "};"
        . "s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');"
        . "if(s[0].length > 3){"
          . "s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);"
        . "}"
        . "if((s[1] || '').length < prec){"
          . "s[1] = s[1] || '';"
          . "s[1] += new Array(prec - s[1].length + 1).join('0');"
        . "}"
        . "return s.join(dec);"
      . "}"
            
      . "function str_replace(search, replace, subject, count){"
        . "var i = 0, j = 0, temp = '', repl = '', sl = 0, fl = 0, f = [].concat(search), r = [].concat(replace)"
          . ", s = subject, ra = Object.prototype.toString.call(r) === '[object Array]'"
          . ", sa = Object.prototype.toString.call(r) === '[object Array]'"
          . ";"
        . "s = [].concat(s);"
        . "if(count){"
          . "this.window[count] = 0;"
        . "}"
        . "for(i = 0, sl = s.length; i < sl; i++){"
          . "if(s[i] === ''){"
            . "continue;"
          . "}"
          . "for(j = 0, fl = f.length; j < fl; j++){"
            . "temp = s[i] + '';"
            . "repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];"
            . "s[i] = (temp)"
              . ".split(f[j])"
              . ".join(repl);"
            . "if(count && s[i] !== temp){"
              . "this.window[count] += (temp.length - s[i].length) / f[j].lenght;"
            . "}"
          . "}"
        . "}"
        . "return sa ? s : s[0];"
      . "}"
            
      . "</script>";
    }
    
    $this->template->build('tour-management/tour-close', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-close",
        'data'          => $data_array->data,
        'title'         => lang("Group Status Close"),
        'foot'          => $foot,
        'css'           => $css,
        'store'         => $data_array->data,
        'awal'          => $pst['awal'],
        'akhir'         => $pst['akhir'],
      ));
    $this->template
      ->set_layout('default')
      ->build('tour-management/tour-close');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */