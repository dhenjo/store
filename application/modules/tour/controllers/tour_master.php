<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_master extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function index(){
    
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
          . '"order": [[ 1, "asc" ]],'
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
        . '$.post("'.site_url("tour/ajax/get-master-tour").'/"+mulai, function(data){'
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
     
    $this->template->build('master/main', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master",
        'data'          => $data_array->data,
        'title'         => lang("Master Tour"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('master/main');
  }
  
  function fit(){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_code"          => $pst['fit_search_code'],
        "fit_search_title"         => $pst['fit_search_title'],
        "fit_search_ex"            => $pst['fit_search_ex'],
        "fit_search_region"        => $pst['fit_search_region'],
        "fit_search_status"        => $pst['fit_search_status'],
        "fit_search_destination"   => $pst['fit_search_destination'],
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
          . '"order": [[ 1, "asc" ]],'
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
     
    $this->template->build('master/fit', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master/fit",
        'data'          => $data_array->data,
        'title'         => lang("Master Tour FIT"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('master/fit');
  }
  
  function manage_schedule_fit($kode){
    
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $set = array(
        "fit_search_tanggal"            => $pst['fit_search_tanggal'],
        "fit_search_kode"               => $pst['fit_search_kode'],
        "fit_search_stars"              => $pst['fit_search_stars'],
        "fit_search_status"             => $pst['fit_search_status'],
        "fit_search_hotel"              => $pst['fit_search_hotel'],
      );
      $this->session->set_userdata($set);
    }
//    $this->debug($this->session->all_userdata(), true);
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
          . '"order": [[ 1, "asc" ]],'
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
        . '$.post("'.site_url("tour/ajax/get-master-tour-fit-schedule").'/"+mulai, {kode: "'.$kode.'"},function(data){'
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
     
    $this->template->build('master/manage-schedule-fit', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-master/fit",
        'data'          => $data_array->data,
        'title'         => lang("Master Tour Schedule FIT"),
        'foot'          => $foot,
        'kode'          => $kode,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store'         => $store_dd,
      ));
    $this->template
      ->set_layout('default')
      ->build('master/manage-schedule-fit');
  }
  
  function add_schedule_fit($kode){
    
    $pst = $this->input->post();
    if($pst){
      if($pst['id_detail']){
        
      }
      else{
        $post = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "id_users"            => $this->session->userdata("id"),
          "fit"                 => $kode,
          "start_date"          => $pst['start_date'],
          "end_date"            => $pst['end_date'],
          "days"                => $pst['days'],
          "nights"              => $pst['nights'],
          "hotel"               => $pst['hotel'],
          "desc"                => $pst['desc'],
          "stars"               => $pst['stars'],
          "bfast"               => $pst['bfast'],
          "bfast_price"         => str_replace(",","",str_replace("Rp ","",$pst['bfast_price'])),
          "twn"                 => str_replace(",","",str_replace("Rp ","",$pst['twn'])),
          "sgl"                 => str_replace(",","",str_replace("Rp ","",$pst['sgl'])),
          "x_bed"               => str_replace(",","",str_replace("Rp ","",$pst['x_bed'])),
          "remarks"             => $pst['remarks'],
          "status"              => $pst['status'],
        );
        $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-master-tour-fit-schedule");
        $data_array = json_decode($data);
//        $this->debug($data, true);
      }
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/tour-master/manage-schedule-fit/{$kode}");
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

      $this->template->build('master/add-schedule-fit', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-master/fit",
          'data'          => $data_array->data,
          'title'         => lang("Master Tour Schedule FIT"),
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'cetak'         => $cetak,
          'total'         => $total,
          'store'         => $store_dd,
        ));
      $this->template
        ->set_layout('default')
        ->build('master/add-schedule-fit');
    }
  }
  
  function add_fit($kode = ""){
    
    $pst = $this->input->post();
    if(!$pst){
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
        . "";

      $foot .= "<script>"
        . "$(function() {"
          . "CKEDITOR.replace('editor2');"
          . "$('.harga').priceFormat({"
            . "prefix: 'Rp ',"
            . "centsLimit: 0"
          . "});"
        . "});"
        
        . "$(document).on('click', '.delete-add-on-tour', function(evt){"
          . "var del_add = $(this).attr('isi');"
          . "$('#'+del_add).remove();"
        . "});"
        . "$(document).on('click', '#add-on-tour', function(evt){"
          . "var nomor = $('#nomor').val() * 1;"
          . "$.post('".site_url("tour/ajax/add-on-tour")."', {nomor: nomor}, function(hasil){"
            . "$('#isi-add-tour').append(hasil);"
            . "$('#nomor').val((nomor+1));"
          . "});"
        . "});"
      . "</script>";
      
      if($kode){
        $post_fit = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "code"                => $kode,
          "start"               => 0,
          "max"                 => 1,
        );
        $fit = $this->antavaya_lib->curl_mentah($post_fit, URLSERVER."json/json-tour/get-master-tour-fit");
        $fit_array = json_decode($fit);
        $post_add = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "code"                => $kode,
        );
        $add = $this->antavaya_lib->curl_mentah($post_add, URLSERVER."json/json-tour/get-master-add-on-tour-fit");
        $add_array = json_decode($add);
      }
//      $this->debug($fit, true);
      $this->template->build('master/add-fit', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-master/fit",
          'data'          => $data_array->data,
          'title'         => lang("Master Add Tour FIT"),
          'foot'          => $foot,
          'css'           => $css,
          'detail'        => $fit_array->data,
          'add_on'        => $add_array->data,
        ));
      $this->template
        ->set_layout('default')
        ->build('master/add-fit');
    }
    else{
      
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "id_store_region"     => $this->session->userdata("id_store_region"),
        "title"               => $pst['title'],
        "summary"             => $pst['summary'],
        "region"              => $pst['region'],
        "destination"         => $pst['destination'],
        "status"              => $pst['status'],
      );
      if($pst['id_detail']){
        $post['code']         = $pst['id_detail'];
      }
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-master-tour-fit");
      $data_array = json_decode($data);

      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id"                  => $data_array->id,
        "title"               => json_encode($pst['add']),
        "adult"               => json_encode($pst['add_adult']),
        "child"               => json_encode($pst['add_child']),
      );
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/set-master-tour-fit-add-on");
      $data_array = json_decode($data);
        
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/tour-master/fit");
    }
  }
  
  function edit_master_tour($code){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $code,
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-master-tour-detail");
    $data_array = json_decode($data);
    $this->debug($data_array, true);
    if($pst){
      
    }
    else{
      $this->template->build('master/edit-master-tour', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-master",
          'data'          => $data_array->data,
          'title'         => lang("Edit Master Tour"),
          'foot'          => $foot,
          'css'           => $css,
          'cetak'         => $cetak,
          'total'         => $total,
          'store'         => $store_dd,
        ));
      $this->template
        ->set_layout('form')
        ->build('master/edit-master-tour');
    }
  }
  
  function edit_master_tour_schedule($kode, $code){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $code,
    );
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-master-tour-fit-schedule-detail");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    if($pst){
      $post_fit = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $code,
        "id_users"          => $this->session->userdata("id"),
        "start_date"        => $pst['start_date'],
        "end_date"          => $pst['end_date'],
        "days"              => $pst['days'],
        "nights"            => $pst['nights'],
        "hotel"             => $pst['hotel'],
        "desc"              => $pst['desc'],
        "stars"             => $pst['stars'],
        "bfast"             => $pst['bfast'],
        "bfast_price"       => trim(str_replace(",", "",str_replace("Rp ","",$pst['bfast_price']))),
        "twn"               => trim(str_replace(",", "",str_replace("Rp ","",$pst['twn']))),
        "sgl"               => trim(str_replace(",", "",str_replace("Rp ","",$pst['sgl']))),
        "x_bed"             => trim(str_replace(",", "",str_replace("Rp ","",$pst['x_bed']))),
        "remarks"           => $pst['remarks'],
        "status"            => $pst['status'],
      );
      $data_fit = $this->antavaya_lib->curl_mentah($post_fit, URLSERVER."json/json-tour/set-master-tour-fit-schedule");
      $data_fit_array = json_decode($data_fit);
//      $this->debug($data_fit, true);
      if($data_fit_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/tour-master/manage-schedule-fit/{$kode}");
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
      
      $this->template->build('master/edit-master-fit-schedule', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-master",
          'data'          => $data_array->data,
          'title'         => lang("Edit Master Tour"),
          'foot'          => $foot,
          'css'           => $css,
          'kode'          => $kode,
          'detail'        => $data_array->data,
        ));
      $this->template
        ->set_layout('default')
        ->build('master/edit-master-fit-schedule');
    }
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
    
    $foot .= "<script type='text/javascript'>"
      . "$(document).on('click', '#print-price-detail', function(evt){"
        . "window.open('".site_url("store/print-store/price-detail/{$book_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
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
  
  function duplicate_tour_fit($kode){
    $post = array(
      "users"                 => USERSSERVER,
      "password"              => PASSSERVER,
      "id_users"              => $this->session->userdata("id"),
      "code"                  => $kode,
    );
    
    $pax = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/duplicate-tour-fit");
    $pax_array = json_decode($pax);
//    $this->debug($pax, true);
    if($pax_array->status == 2){
      $this->session->set_flashdata('success', 'Duplicate Berhasil');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal');
    }
    redirect("tour/tour-master/fit");
  }
  
  function duplicate_master_fit_schedule($kode, $code){
    $post = array(
      "users"                 => USERSSERVER,
      "password"              => PASSSERVER,
      "id_users"              => $this->session->userdata("id"),
      "code"                  => $code,
    );
    
    $pax = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/duplicate-tour-fit-schedule");
    $pax_array = json_decode($pax);
//    $this->debug($pax, true);
    if($pax_array->status == 2){
      $this->session->set_flashdata('success', 'Duplicate Berhasil');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal');
    }
    redirect("tour/tour-master/manage-schedule-fit/{$kode}");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */