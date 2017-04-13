<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_fit extends MX_Controller {
    
  function __construct() {
    $this->load->library('email');
    $this->menu = $this->cek();
  }
  
  function quotation_request(){
    
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
        . '$.post("'.site_url("tour/tour-fit-ajax/get-tour-fit-request").'/"+mulai, {id_store: "'.$this->session->userdata("id_store").'"}, function(data){'
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
     
    $this->template->build('tour-fit/quotation-request', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-fit/quotation-request",
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
      ->build('tour-fit/quotation-request');
  }
  
  function add_quotation_request(){
    $this->load->library('form_validation');
    $config = array(
        array(
              'field'   => 'departure', 
              'label'   => 'Periode Start', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'arrive', 
              'label'   => 'Periode End', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'adult', 
              'label'   => 'Total Pax (Adult)', 
              'rules'   => 'required'
           ),   
        array(
              'field'   => 'airline', 
              'label'   => 'Airline', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'destination', 
              'label'   => 'Destination', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'hotel', 
              'label'   => 'Hotel', 
              'rules'   => 'required'
           ),
        array(
            'field'   => 'client', 
            'label'   => 'Client', 
            'rules'   => ''
         ),
        array(
            'field'   => 'title', 
            'label'   => 'Project Name', 
            'rules'   => ''
         ),
        array(
            'field'   => 'child', 
            'label'   => 'Child', 
            'rules'   => ''
         ),
        array(
            'field'   => 'budget_start', 
            'label'   => 'Budget Start', 
            'rules'   => ''
         ),
        array(
            'field'   => 'budget_end', 
            'label'   => 'Budget End', 
            'rules'   => ''
         ),
        array(
            'field'   => 'other', 
            'label'   => 'Other', 
            'rules'   => ''
         ),
     );

    $this->form_validation->set_rules($config);

    if ($this->form_validation->run() == FALSE){
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";

      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>";

      $foot .= "<script>"
        
        . "function validateForm(){"
          . "var tt = 0;"
          . "if(!$('#destination').val()){"
            . "alert('Destination is required');"
            . "tt = 2;"
          . "}"
          . "if(!$('#departure').val()){"
            . "alert('Periode Start is required');"
            . "tt = 2;"
          . "}"
          . "if(!$('#arrive').val()){"
            . "alert('Periode End is required');"
            . "tt = 2;"
          . "}"
          . "if(!$('#adult').val()){"
            . "alert('Total Pax (Adult) is required');"
            . "tt = 2;"
          . "}"
          . "if(!$('#airline').val()){"
            . "alert('Airline is required');"
            . "tt = 2;"
          . "}"
          . "if(!$('#hotel').val()){"
            . "alert('Hotel is required');"
            . "tt = 2;"
          . "}"
        
          . "if(tt == 2){"
            . "return false;"
          . "}"
          . "else{"
            . "return true;"
          . "}"
        . "}"

        . '$(function() {'
          . "$('.harga').priceFormat({"
            . "prefix: 'Rp ',"
            . "centsLimit: 0"
          . "});"

          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true"
          . "});"

        . '});'
        
        . "$(document).on('click', '.delete-add-on-tour', function(evt){"
          . "$('.first').last().remove();"
        . "});"
        . "$(document).on('click', '#add-on-tour', function(evt){"
          . "var nomor = $('#nomor').val() * 1;"
          . "$.post('".site_url("tour/tour-fit-ajax/add-itin-fit")."', {nomor: nomor}, function(hasil){"
            . "$('#isi-add-tour').append(hasil);"
            . "$('#nomor').val((nomor+1));"
          . "});"
        . "});"

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

      $this->template->build('tour-fit/add-quotation-request', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-fit/quotation-request",
          'data'          => $data_array->data,
          'title'         => lang("Form Quotation Request"),
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'cetak'         => $cetak,
          'total'         => $total,
          'store'         => $store_dd,
        ));
      $this->template
        ->set_layout('default')
        ->build('tour-fit/add-quotation-request');
    }
    else{
      $pst = $this->input->post();
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "id_users"            => $this->session->userdata("id"),
        "id_store"            => $this->session->userdata("id_store"),
        "adult"               => $pst['adult'],
        "child"               => $pst['child'],
        "budget_start"        => str_replace(",", "", str_replace("Rp ", "", $pst['budget_start'])),
        "budget_end"          => str_replace(",", "", str_replace("Rp ", "", $pst['budget_end'])),
        "destination"         => $pst['destination'],
        "hotel"               => $pst['hotel'],
        "other"               => $pst['other'],
        "departure"           => $pst['departure'],
        "arrive"              => $pst['arrive'],
        "title"               => $pst['title'],
        "client"              => $pst['client'],
        "airline"             => $pst['airline'],
        "tanggal"             => date("Y-m-d"),
        "status"              => 1,
      );
      $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request");
      $data_array = json_decode($data);
//      $this->debug($data, true);
      if($data_array->status == 2){
        $post = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "id_users"            => $this->session->userdata("id"),
          "id_tour_fit_request" => $data_array->id,
          "itinerary"           => json_encode($pst['itinerary']),
          "meal"                => json_encode($pst['meal']),
          "specific"            => json_encode($pst['specific']),
        );
        $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-detail");
        
        $users_book = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
        $users_to = $this->global_models->get_query("SELECT A.email"
          . " FROM m_users AS A"
          . " LEFT JOIN d_user_privilege AS B ON A.id_users = B.id_users"
          . " LEFT JOIN m_privilege AS C ON B.id_privilege = C.id_privilege"
          . " WHERE C.name LIKE 'Portal - FIT Opt'");
        foreach($users_to AS $ut){
          $email_to[] = $ut->email;
        }
        
        $this->email->initialize($this->global_models->email_conf());
        $this->email->from($users_book[0]->email, $users_book[0]->name);
        $this->email->to($email_to);
        $this->email->bcc('nugroho.budi@antavaya.com');

        $this->email->subject("[FIT] Quotation Request {$data_array->code}");
        $this->email->message("
          Dear Operation Team <br />
          Berikut book code untuk quotation request. <a href='".site_url("tour/opt-tour/book-fit-request/{$data_array->code}")."'>{$data_array->code}</a><br />
          Mohon Quotation Price <br />
          Terima Kasih <br />
          {$users_book[0]->name}
          ");

        $this->email->send();
        
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("tour/tour-fit/book-fit-request/{$data_array->code}");
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
        redirect("tour/tour-fit/quotation-request");
      }
    }
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
//      $this->debug($log_array, true);
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
      
//      if($quo_array->data[0]->status < 4 OR $quo_array->data[0]->status == 7){
        $itin_post = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "code"              => $kode,
          "type"			  => 2,
        );
        $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
        $itin_array = json_decode($itin);
		if($itin_array->status == 3){
      $itin_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
        "type"              => 3,
      );
      $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
      $itin_array = json_decode($itin);
      if($itin_array->status == 3){
        $itin_post = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "code"              => $kode,
        );
        $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
        $itin_array = json_decode($itin);
      }
		}
//      }
/*      else{
        $itin_post = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "code"              => $kode,
          "type"              => 3,
        );
        $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
        $itin_array = json_decode($itin);
      }
*/
      $cp_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $cp = $this->antavaya_lib->curl_mentah($cp_post, URLSERVER."json/json-tour-fit/get-contact-person-fit-request");  
      $cp_array = json_decode($cp);
      
      $price_tag_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
      );
      $price_tag = $this->antavaya_lib->curl_mentah($price_tag_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-price-tag");  
      $price_tag_array = json_decode($price_tag);
//      $this->debug($quo_array,true);
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
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>";

      $foot .= "<script>"
//        . "CKEDITOR.replace('editor2');"
        . 'var table = '
        . '$("#tableboxy").dataTable({'
          . '"order": [[ 0, "asc" ]],'
//          . "'iDisplayLength': 20"
        . '});'
        
        . 'var table_pax = '
        . '$("#tableboxy-pax").dataTable({'
          . '"order": [[ 0, "asc" ]],'
//          . "'iDisplayLength': 20"
        . '});'
        
        . 'var table_price = '
        . '$("#table-price").dataTable({'
          . '"order": [[ 0, "asc" ]],'
        . '});'
        
        . "$('#chat-box').slimScroll({"
          . "height: '250px'"
        . "});"
        
        . "$('#history-log').slimScroll({"
          . "height: '500px'"
        . "});"
        
        . '$(function() {'
        
          . "$('.harga').priceFormat({"
            . "prefix: 'Rp ',"
            . "centsLimit: 0"
          . "});"

          . 'ambil_data_pax(table_pax, 0);'
          . 'ambil_data_price(table_price, 0);'

          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true,"
          . "});"

        . '});'

        . 'function ambil_data(table, mulai){'
          . '$("#loading-itin-quo").show();'
          . '$.post("'.site_url("tour/ajax/get-itin-quo-detail/2").'/"+mulai, {code: "'.$kode.'"}, function(data){'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.hasil){'
              . 'table.fnAddData(hasil.hasil);'
            . '}'
            . '$("#loading-itin-quo").hide();'
          . '});'
        . '}'

        . 'function ambil_data_pax(table_pax, mulai){'
          . '$("#loading-itin-quo").show();'
          . '$.post("'.site_url("tour/tour-fit-ajax/get-pax-request").'/"+mulai, {code: "'.$kode.'"}, function(data){'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.hasil){'
              . 'table_pax.fnAddData(hasil.hasil);'
            . '}'
            . '$("#loading-itin-quo").hide();'
          . '});'
        . '}'
        
        . 'function ambil_data_price(table_price, mulai){'
          . '$("#loading-price").show();'
          . '$("#status-update3").hide();'
          . '$("#status-update4").hide();'
          . '$("#status-update6").hide();'
          . '$("#status-update7").hide();'
          . '$("#status-update8").hide();'
          . '$.post("'.site_url("tour/tour-fit-ajax/get-price-request").'/"+mulai, {code: "'.$kode.'", quo: "'.$quo_array->data[0]->status.'"}, function(data){'
            . 'var hasil = $.parseJSON(data);'
            . 'if(hasil.hasil){'
              . 'table_price.fnAddData(hasil.hasil);'
              . '$("#sum-debit").html(hasil.debit);'
              . '$("#sum-kredit").html(hasil.kredit);'
              . '$("#total").html(hasil.total);'
            . '}'
//            . 'alert(hasil.quo);'
            . 'if(hasil.quo != 2){'
              . '$("#status-update"+hasil.quo).show();'
              . '$("#status-asli").hide();'
            . '}'
            . '$("#loading-price").hide();'
          . '});'
        . '}'
        
        . "$(document).on('click', '#add-pax', function(evt){"
          . "$('#edit-pax-ticket').val(1);"
          . "$('#edit-pax-title').val(1);"
          . "$('#edit-pax-type').val(1);"
          . "$('#edit-pax-first-name').val('');"
          . "$('#edit-id').val('');"
          . "$('#edit-pax-last-name').val('');"
          . "$('#edit-pax-email').val('');"
          . "$('#edit-pax-telp').val('');"
          . "$('#edit-pax-tempat-lahir').val('');"
          . "$('#edit-pax-tanggal-lahir').val('');"
          . "$('#edit-pax-passport').val('');"
          . "$('#edit-pax-tempat-passport').val('');"
          . "$('#edit-pax-tanggal-passport').val('');"
          . "$('#edit-pax-expired-passport').val('');"
          . "$('#edit-note').val('');"
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

        . "$(document).on('click', '#simpan-pax', function(evt){"
          . "$('#loading-pax').show();"
          . "$.post('".site_url("tour/tour-fit-ajax/post-pax")."', {"
              . "id_users: '{$this->session->userdata('id')}',"
              . "code: '{$kode}',"
              . "ticket: $('#edit-pax-ticket').val(),"
              . "title: $('#edit-pax-title').val(),"
              . "type: $('#edit-pax-type').val(),"
              . "bed_type: $('#edit-pax-bed-type').val(),"
              . "first_name: $('#edit-pax-first-name').val(),"
              . "id: $('#edit-id').val(),"
              . "last_name: $('#edit-pax-last-name').val(),"
              . "email: $('#edit-pax-email').val(),"
              . "telp: $('#edit-pax-telp').val(),"
              . "tempat_lahir: $('#edit-pax-tempat-lahir').val(),"
              . "tanggal_lahir: $('#edit-pax-tanggal-lahir').val(),"
              . "passport: $('#edit-pax-passport').val(),"
              . "tempat_passport: $('#edit-pax-tempat-passport').val(),"
              . "tanggal_passport: $('#edit-pax-tanggal-passport').val(),"
              . "expired_passport: $('#edit-pax-expired-passport').val(),"
              . "note: $('#edit-note').val()"
            . "}, function(html){"
            . "table_pax.fnClearTable();"
            . "ambil_data_pax(table_pax, 0);"
            . "$('#loading-pax').hide();"
          . "});"
        . "});"

        . "$(document).on('click', '#simpan-payment', function(evt){"
          . "$('#loading-payment').show();"
          . "$('#button-payment').hide();"
          . "$.post('".site_url("tour/tour-fit-ajax/post-payment")."', {"
              . "id_users: '{$this->session->userdata('id')}',"
              . "code: '{$kode}',"
              . "nomor: $('#payment-nomor').val(),"
              . "nomor_ttu: $('#payment-nomor-ttu').val(),"
              . "price: $('#payment-price').val(),"
              . "rekening: $('#payment-rekening').val(),"
              . "note: $('#payment-note').val()"
            . "}, function(html){"
            . "table_price.fnClearTable();"
            . "ambil_data_price(table_price, 0);"
            . "$('#loading-payment').hide();"
            . "$('#button-payment').show();"
          . "});"
        . "});"

        . "$(document).on('click', '#simpan-price', function(evt){"
          . "$('#loading-payment').show();"
          . "$('#button-price').hide();"
          . "$.post('".site_url("tour/tour-fit-ajax/post-price")."', {"
              . "id_users: '{$this->session->userdata('id')}',"
              . "code: '{$kode}',"
              . "type: $('#price-type').val(),"
              . "title: $('#price-title').val(),"
              . "price: $('#price-price').val(),"
              . "qty: $('#price-qty').val(),"
              . "pos: $('#price-pos').val(),"
              . "note: $('#payment-note').val()"
            . "}, function(html){"
            . "table_price.fnClearTable();"
            . "ambil_data_price(table_price, 0);"
            . "$('#loading-payment').hide();"
            . "$('#button-price').show();"
          . "});"
        . "});"
            
        . "$(document).on('click', '#save-quotation', function(evt){"
          . "$.post('".site_url("tour/tour-fit-ajax/post-price-quotation")."', {"
              . "id_users: '{$this->session->userdata('id')}',"
              . "code: '{$kode}',"
              . "pt_bracket: $('#pt-bracket').val(),"
              . "adult_triple_twin: $('#pt-adult-triple-twin').val(),"
              . "adult_sgl_supp: $('#pt-adult-sgl-supp').val(),"
              . "child_twin_bed: $('#pt-child-twin-bed').val(),"
              . "child_extra_bed: $('#pt-child-extra-bed').val(),"
              . "child_no_bed: $('#pt-child-no-bed').val(),"
              . "adult_fare: $('#pt-adult-fare').val(),"
              . "child_fare: $('#pt-child-fare').val(),"
              . "infant_fare: $('#pt-infant-fare').val()"
            . "}, function(html){"
              . "window.location = '".site_url("tour/tour-fit/book-fit-request/{$kode}")."';"
          . "});"
        . "});"
            
        . "$(document).on('click', '#confirm-time-limit', function(evt){"
          . "$.post('".site_url("tour/tour-fit-ajax/confirm-time-limit")."', {code: '{$kode}'}, function(html){"
              . "window.location = '".site_url("tour/tour-fit/book-fit-request/{$kode}")."';"
          . "});"
        . "});"
            
        . "$(document).on('click', '.pax-edit', function(evt){"
          . "$('#loading-form').show();"
          . "$.post('".site_url("tour/tour-fit-ajax/get-detail-pax")."', {id: $(this).attr('isi')}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "$('#edit-pax-ticket').val(hasil.data.ticket);"
            . "$('#edit-pax-title').val(hasil.data.title);"
            . "$('#edit-pax-type').val(hasil.data.type);"
            . "$('#edit-pax-first-name').val(hasil.data.first_name);"
            . "$('#edit-id').val(hasil.data.id_tour_fit_request_pax);"
            . "$('#edit-pax-last-name').val(hasil.data.last_name);"
            . "$('#edit-pax-email').val(hasil.data.email);"
            . "$('#edit-pax-telp').val(hasil.data.telp);"
            . "$('#edit-pax-tempat-lahir').val(hasil.data.tempat_lahir);"
            . "$('#edit-pax-tanggal-lahir').val(hasil.data.tanggal_lahir);"
            . "$('#edit-pax-passport').val(hasil.data.passport);"
            . "$('#edit-pax-tempat-passport').val(hasil.data.tempat_passport);"
            . "$('#edit-pax-tanggal-passport').val(hasil.data.tanggal_passport);"
            . "$('#edit-pax-expired-passport').val(hasil.data.expired_passport);"
            . "$('#edit-note').val(hasil.data.note);"
            . "$('#loading-form').hide();"
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
      if($quo_array->data[0]->status < 3 OR $quo_array->data[0]->status == 7){
        $foot .= "<script>"
          . 'ambil_data(table, 0);'
          . "</script>";
      }
//      $chat = $this->global_models->get_query("SELECT A.*"
//        . " ,B.name"
//        . " FROM chat_request AS A"
//        . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
//        . " ORDER BY A.tanggal DESC");
//      $this->debug($quo_array, true);
      $this->template->build('tour-fit/book-fit-request', 
        array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-fit/quotation-request",
          'data'          => $data_array->data,
          'title'         => lang("Book Request")." {$kode}",
          'foot'          => $foot,
          'kode'          => $kode,
          'css'           => $css,
          'book'          => $book_array->data,
          'itin_req'      => $itin_array->data,
          'quo'           => $quo_array->data,
          'cp'            => $cp_array->data,
          'log'           => $log_array->data,
          'price_tag'     => $price_tag_array->data,
        ));
      $this->template
        ->set_layout('default')
        ->build('tour-fit/book-fit-request');
    }
  }
  
  function confirm_quotation($kode){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "status"            => 8,
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-status-fit-request");  
    $book_array = json_decode($book);
//    $this->debug($book, true);
    if($book_array->status == 2){
      
      $users_book = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
      $users_to = $this->global_models->get("m_users", array("id_users" => $book_array->users_opt));

      $this->email->initialize($this->global_models->email_conf());
      $this->email->from($users_book[0]->email, $users_book[0]->name);
      $this->email->to($users_to[0]->email);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[FIT] Timelimit Request {$kode}");
      $this->email->message("
        Dear {$users_to[0]->name} <br />
        Untuk book code <a href='".site_url("tour/opt-tour/book-fit-request/{$kode}")."'>{$kode}</a><br />
        Sudah confirm, mohon informasi timelimit<br />
        Terima Kasih <br />
        {$users_book[0]->name}
        ");

      $this->email->send();
      
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/tour-fit/book-fit-request/{$kode}");
  }
  
  function cancel_quotation($kode){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "status"            => 5,
      "note_cancel"       => $this->input->post("note"),
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-status-fit-request");  
    $book_array = json_decode($book);
//    $this->debug($book, true);
    if($book_array->status == 2){
      
      $users_book = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
      $users_to = $this->global_models->get("m_users", array("id_users" => $book_array->users_opt));

      $this->email->initialize($this->global_models->email_conf());
      $this->email->from($users_book[0]->email, $users_book[0]->name);
      $this->email->to($users_to[0]->email);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[FIT] Cancel {$kode}");
      $this->email->message("
        Dear {$users_to[0]->name} <br />
        Untuk book code <a href='".site_url("tour/opt-tour/book-fit-request/{$kode}")."'>{$kode}</a><br />
        Telah di Cancel<br />
        Terima Kasih <br />
        {$users_book[0]->name}
        ");

      $this->email->send();
      
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/tour-fit/book-fit-request/{$kode}");
  }
  
  function toc($kode){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "toc"               => $this->input->post("toc"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-toc");  
    $book_array = json_decode($book);
//    $this->debug($book, true);
    if($book_array->status == 2){
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/opt-tour/book-fit-request/{$kode}");
  }
  
  function generate_price($kode){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/generate-price-fit-request");  
    $book_array = json_decode($book);
//    $this->debug($book, true);
    if($book_array->status == 2){
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/tour-fit/book-fit-request/{$kode}");
  }
  
  function update_contact_person($kode){
    $pst = $this->input->post();
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "id_users"          => $this->session->userdata("id"),
      "name"              => $pst['name'],
      "email"             => $pst['email'],
      "telp"              => $pst['telp'],
      "alamat"            => $pst['alamat'],
      "note"              => $pst['note'],
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-contact-person-fit-request");  
    $book_array = json_decode($book);
    if($data_array->status == 2 OR $data_array->status == 4){
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("tour/tour-fit/book-fit-request/{$kode}");
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */