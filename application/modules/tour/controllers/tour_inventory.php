<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_inventory extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function search($id_inventory){
//      print $id_inventory;
//      die;
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
                . "url: '".site_url("tour/tour-inventory-ajax/load-tooltip-harga-tour/{$id_inventory}")."/'+$(this).attr('isi'),"
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
      
      . "function ambil_data(table, mulai){"
        . '$.post("'.site_url("tour/tour-inventory-ajax/get-tour-product").'/"+mulai+"/"+"'.$id_inventory.'", function(data){'
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
//    $foot .= "<script>"
//      
//      . "$(function() {"
//        . "$('#tableboxy').dataTable({"
//          . "'bLengthChange': false,"
//          . "'iDisplayLength': -1"
//        . "});"
//        . "$( '.tanggal' ).datepicker({"
//          . "showOtherMonths: true,"
//          . "format: 'yyyy-mm-dd',"
//          . "selectOtherMonths: true,"
//          . "selectOtherYears: true"
//        . "});"
//      . "});"
//      
//      . "$('#cari-status').change(function(){"
//        . 'window.location = "'.site_url("tour/list-tour-book/{$code}/").'/"+$("#cari-status").val();'
//      . "});"
//      
//      . "</script>";
    $post = array(
      "users"         => USERSSERVER,
      "password"      => PASSSERVER,
      "id_inventory"  => $id_inventory,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-get-detail");  
    $data_array = json_decode($data);
    
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-ttu-get");  
    $data_ttu = json_decode($data);
    
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
    
//    $data1 = implode("|", $data_array->data->inventory);
    
//    print "<pre>";
//    print_r($data_ttu->data);
//    print "</pre>";
//    die;
    
      $this->template->build('inventory/tour-search', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/search",
        'data'          => $data_array->data->inventory,
        'ttu'           => $data_ttu->data,  
        'title'         => lang("List Tour"),
        'foot'          => $foot,
        'css'           => $css,
//        'cetak'         => $cetak,
//        'total'         => $total,
        'store_dd'      => $store_dd,
//        'info'          => $data_tour_array,
//        'stat'          => $stat
      ));
    $this->template
      ->set_layout('default')
      ->build('inventory/tour-search');
    
  }
  
    function tour_detail($id_inventory,$tour_code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $tour_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-detail");
    $detail_array = json_decode($detail);
//   $this->debug($detail_array, true);
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
        $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
        $(function() {
          $('#example1').dataTable();
        });
		$(document).on('click', '#print-detail', function(evt){
      window.open('".site_url("store/print-store/tour/{$tour_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');
    });
		$(document).on('click', '.tour-print', function(evt){
      var code = $(this).attr('isi');
      window.open('".site_url("store/print-store/tour-schedule/{$tour_code}")."/'+code, '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');
    });
        $(document).on('click', '.tour-edit', function(evt){
          $.post('".site_url("grouptour/product-tour/ajax-tour-detail")."', {kode_tour_information: $(this).attr('isi')}, function(data){
            var hasil = $.parseJSON(data);
           
            $('#kode').val(hasil.kode);
            $('#id_product_tour_information').val(hasil.id_product_tour_information);
            $('#kode_ps').val(hasil.kode_ps);
            $('#start_date_0').val(hasil.start_date);
            $('#end_date_0').val(hasil.end_date);
            $('#start_time_1').val(hasil.start_time);
            $('#end_time_1').val(hasil.end_time);
            $('#available_seat').val(hasil.available_seat);
            $('#id_currency').val(hasil.id_currency);
            $('#adult_triple_twin').val(hasil.adult_triple_twin);
            $('#child_twin_bed').val(hasil.child_twin_bed);
            $('#child_extra_bed').val(hasil.child_extra_bed);
            $('#child_no_bed').val(hasil.child_no_bed);
            $('#sgl_supp').val(hasil.sgl_supp);
            $('#airport_tax').val(hasil.airport_tax);
            $('#visa').val(hasil.visa);
            $('#stnb_discount_tetap').val(hasil.tour_discount);
            $('#flt').val(hasil.flt);
            $('#in').val(hasil.in);
            $('#out').val(hasil.out);
            $('.dt_discount').remove();
            $('#tambah-items-discount').append(hasil.tour_discount);
        
          });
          
        });
        
function tambah_discount(discount){
            $('.dt_discount').remove();
           var dataString2 = 'id_discount='+ discount;
      $.ajax({
      type : 'POST',
      url : '".site_url("inventory/ajax/add-discount")."',
      data: dataString2,
      dataType : 'html',
      success: function(data) {
            $('#tambah-items-discount').append(data);
      },
    });
        }
    </script>";
      
    $this->template->build('inventory/tour-detail', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/product-tour",
            'data'        => $detail_array,
            'foot'        => $foot,
            'css'         => $css,
            'id_inventory'=> $id_inventory,
            'title'       => lang("Detail Book Product Tour"),
            'breadcrumb'  => array(
              "product_tour"  => "grouptour/product-tour"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('inventory/tour-detail');
  }
  
    function room_list_umum($id_inventory,$code, $status = 1){
    
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
     
    $this->template->build('inventory/room-list-umum', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/search",
        'data_table'    => $hasil,
        'data'          => $data_array,
        'title'         => lang("Room List"),
        'foot'          => $foot,
        'id_inventory'  => $id_inventory,  
        'css'           => $css,
        'status'        => $status
      ));
    $this->template
      ->set_layout('default')
      ->build('inventory/room-list-umum');
  }
  
    function list_tour_book_umum($id_inventory,$code, $stat){
    
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
     
    $this->template->build('inventory/list-tour-book-umum', 
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
        'id_inventory'  => $id_inventory,  
        'info'          => $data_tour_array,
        'stat'          => $stat
      ));
    $this->template
      ->set_layout('default')
      ->build('inventory/list-tour-book-umum');
  }
  
 function book_tour($id_inventory,$book_code){
     
    $pst = $this->input->post(NULL);
//    $this->debug($pst, true);
   /* print "<pre>";
   print_r($pst); 
   print "</pre>";
   die; */
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-information-detail");
    $detail_array = json_decode($detail);
    if($detail_array->information->dp >= $detail_array->information->seat){
      $this->session->set_flashdata('notice', 'Full');
      redirect("tour/search");
    }
//    $this->debug($detail_array, true);
//    print "<pre>";
//    print_r($detail_array);
//    print "</pre>";
//    die; 
    $currency = $detail_array->information->price->currency;
   $adl_triple_twin = $detail_array->information->price->adult_triple_twin;
   $chl_twin_bed = $detail_array->information->price->child_twin_bed;
   $chl_extra_bed = $detail_array->information->price->child_extra_bed;
   $chl_no_bed = $detail_array->information->price->child_no_bed;
   $sgl_supp = $detail_array->information->price->sgl_supp;
   
   $arr_additional = array("0" => "-Pilih-"); 
    $arr_additional2 = array("1" => "data"); 
   foreach ($detail_array->tour->additional as $val) {
       $arr_additional[$val->id_product_tour_master_additional] =  $val->name." ,Price ".$val->nominal;
   }
    $ses_arr_add = array(
           "arradd"   => $arr_additional,
          );
                
    $this->session->set_userdata($ses_arr_add); 
    
   
   // print_r($this->session->userdata("arradd")); die;
   /*print "<pre>";
   print_r($arr_additional); 
   print "</pre>"; die; */
   
   if($adl_triple_twin){
     $adl_triple_twin = $adl_triple_twin;
   }else{
     if($adl_triple_twin == ""){
       $adl_triple_twin = "";
     }else{
       $adl_triple_twin = $this->session->userdata("adl_triple_twin");
     }
     
   }
   
   if($chl_twin_bed){
     $chl_twin_bed = $chl_twin_bed;
   }else{
     if($chl_twin_bed == ""){
       $chl_twin_bed = "";
     }else{
       $chl_twin_bed = $this->session->userdata("chl_twin_bed");
     } 
   }
   
   if($chl_extra_bed){
     $chl_extra_bed = $chl_extra_bed;
   }else{
     if($chl_extra_bed == ""){
       $chl_extra_bed = "";
     }else{
       $chl_extra_bed = $this->session->userdata("chl_extra_bed");
     }
     
   }
   
   if($chl_no_bed){
     $chl_no_bed = $chl_no_bed;
   }else{
     if($chl_no_bed == ""){
       $chl_no_bed ="";
     }else{
       $chl_no_bed = $this->session->userdata("chl_no_bed");
     }
     
   }
   
   if($sgl_supp){
     $sgl_supp = $sgl_supp;
   }else{
     if($sgl_supp == ""){
       $sgl_supp = "";
     }else{
       $sgl_supp = $this->session->userdata("sgl_supp");
     }
     
   }
   
   $adl_triple_twin1 = number_format($adl_triple_twin, 0, ".", ",");
   $chl_twin_bed1 = number_format($chl_twin_bed, 0, ".", ",");
   $chl_extra_bed1 = number_format($chl_extra_bed, 0, ".", ",");
   $chl_no_bed1 = number_format($chl_no_bed, 0, ".", ",");
   $sgl_supp1 = number_format($sgl_supp, 0, ".", ",");
   
//   $data_type2 = array("0" => "Type Bed");
   $data_type2 = array();
   if($adl_triple_twin > 0){
     $adl_triple_twin3 = array("1" => "Adult Triple Twin, Price {$currency} {$adl_triple_twin1}");
   }else{
     $adl_triple_twin3 = array();
   }
   
   if($chl_twin_bed > 0){
     $chl_twin_bed3 = array("2" => "Child Twin Bed, Price {$currency} {$chl_twin_bed1}");
   }else{
     $chl_twin_bed3 = array();
   }
   
   if($chl_extra_bed > 0){
     $chl_extra_bed3 = array("3" => "Child Extra Bed, Price {$currency} {$chl_extra_bed1}");
   }else{
     $chl_extra_bed3 = array();
   }
   
   if($chl_no_bed > 0){
     $chl_no_bed3 = array("4" => "Child No Bed, Price {$currency} {$chl_no_bed1}");
   }else{
     $chl_no_bed3 = array();
   }
   
   $single_adult = $adl_triple_twin + $sgl_supp;
   $single_adult1 = number_format($single_adult, 0, ".", ",");
   
   if($single_adult > 0){
     $single_adult3 = array("5" => "Single Adult, Price {$currency} {$single_adult1}");
   }else{
     $single_adult3 = array();
   }
   
   $data_array4 = $data_type2 + $adl_triple_twin3 + $chl_twin_bed3 + $single_adult3;
   $data_array5 = $data_type2 + $chl_twin_bed3 + $chl_extra_bed3 + $chl_no_bed3;
//  $data_array4 = array_merge($data_type2,$adl_triple_twin3,$single_adult3);
//  $data_array5 = array_merge($data_type2,$chl_twin_bed3,$chl_extra_bed3,$chl_no_bed3);
  
  $ses_type_bed = array(
           "adl_triple_twin"   => $adl_triple_twin,
           "chl_twin_bed"       => $chl_twin_bed,
           "chl_extra_bed"      => $chl_extra_bed,
           "chl_no_bed"         => $chl_no_bed,
           "sgl_supp"           => $sgl_supp,
           "single_adult"           => $single_adult,
           "type_bed"           => $data_array4,
           "type_bed2"           => $data_array5
          );
          $this->session->set_userdata($ses_type_bed);  
  
//  print_r($data_array4);
//  die;
  
  
//   $type_bed = array("0"      => "Type Bed",
//                    "1"       => "Adult Triple Twin, Price {$currency} {$adl_triple_twin1}",
//                    "2"       => "Child Twin Bed, Price {$currency} {$chl_twin_bed1}",
//                    "3"       => "Child Extra Bed, Price {$currency} {$chl_extra_bed1}",
//                    "4"       => "Child No Bed, Price {$currency} {$chl_no_bed1}",
//                    "5"       => "SGL SUPP, Price {$currency} {$sgl_supp1}",
//                    );
                    
        /*$data_bed = array("0" => "0",
                    "Adult Triple Twin" => $detail_array->information->price->adult_triple_twin,
                    "Child Twin Bed"    => $detail_array->information->price->child_twin_bed,
                    "Child Extra Bed"   => $detail_array->information->price->child_extra_bed,
                    "Child No Bed"      => $detail_array->information->price->child_no_bed,
                    "SGL SUPP"    => $detail_array->information->price->sgl_supp,
                    ); */
                    
      /* $type_bed = array("0" => "Type Bed",
                    $detail_array->information->price->adult_triple_twin => "Adult Triple Twin, Price {$adl_triple_twin}",
                    $detail_array->information->price->child_twin_bed => "Child Twin Bed, Price {$chl_twin_bed}",
                    $detail_array->information->price->child_extra_bed => "Child Extra Bed, Price {$chl_extra_bed}",
                    $detail_array->information->price->child_no_bed => "Child No Bed, Price {$chl_no_bed}",
                    $detail_array->information->price->sgl_supp => "Child AGL SUPP, Price {$sgl_supp}",
                    );  */
                    
//     $ses_type_bed = array(
//           "adl_triple_twin"   => $adl_triple_twin,
//           "chl_twin_bed"       => $chl_twin_bed,
//           "chl_extra_bed"      => $chl_extra_bed,
//           "chl_no_bed"         => $chl_no_bed,
//           "sgl_supp"           => $sgl_supp,
//          // "type_bed"           => $type_bed
//          );
//          $this->session->set_userdata($ses_type_bed);               
     
       $dt_type_bed = "data_type_bed";
       $dt_qty = "data_qty";
    
    $foot = "<script>"
      
      . "$(document).on('click', '.del-req', function(evt){"
        . "var target = $(this).attr('isi');"
        . "$('#'+target).remove();"
      . "});"
     
      . "$(document).on('click', '#add-discount-req', function(evt){"
        . "$.post('".site_url('grouptour/product-tour/add-row-discount')."', function(data){"
          . "$('#tempat-discount-req').append(data);"
        . "});"
      . "});"
     
     ."function tambah_items_additional(){"
      ."var num = $('.number_additional').length;"
      ."var dataString2 = 'name='+ num;"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-additional-book-tour")."',"
      ."data: dataString2,"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-additional').append(data);"
      ."},"
    ."});"
        ."}"
      ."function numberformat(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }"
      ."function tambah_test(){"
      ."var num_addrow = $('.type_bedq').length;"
       ."var dasar_adult_triple_twin = $('input[name=dasar_adult_triple_twin]').val()* 1;"
      ."var dasar_child_twin_bed = $('input[name=dasar_child_twin_bed]').val()* 1;"
      ."var dasar_child_extra_bed = $('input[name=dasar_child_extra_bed]').val()* 1;"
      ."var dasar_child_no_bed = $('input[name=dasar_child_no_bed]').val()* 1;"
      ."var sgl_supp = $('input[name=sgl_supp]').val()* 1;"
      ."var tax_ins = $('input[name=tax_and_insurance]').val()* 1;"
      ."var disc = $('input[name=discount]').val()* 1;"
      ."var status_discount = $('input[name=status_discount]').val();"
      ."var total_adl_qty = 0;"
      ."var total_adl_all = 0;"
      ."var total_chtb_qty = 0;"
      ."var total_chtb_all = 0;"
      ."var total_cheb_qty = 0;"
      ."var total_cheb_all = 0;"
      ."var total_chnb_qty = 0;"
      ."var total_chnb_all = 0;"
      ."var total_sgl_supp_qty = 0;"
      ."var total_sgl_supp_all = 0;"
      ."var total_price_all = 0;"
      ."var total_tax_ins = 0;"
      ."var total_qty = 0;"
      ."var ppn = 0;"
      ."var total_all_pax = 0;"
      ."var hasil_keseluruhan = 0;"
      ."var ank = 0;"
      ."var disc_adl = 0;"
      ."var disc_chtb = 0;"
      ."var disc_cheb = 0;"
      ."var disc_chnb = 0;"
      ."var disc_sgl_supp = 0;"      
      ."var type_bed = 'data_type_bed';"
      ."var data_qty = 'data_qty';"
        ."for (var i = 1; i <= num_addrow; i++) {"
           ."ank = ank + 1;"
           ."aa = type_bed + ank;"
           ."bb = data_qty + ank;"
           ."var type_bd = $('#'+aa+'').val();"
                 
            ."if(type_bd == '1'){
              var dt_qty1 = parseFloat($('#'+bb+'').val());
                var dsr_adl = dasar_adult_triple_twin * dt_qty1;
                  if(dsr_adl != ''){
                    total_adl_qty +=  dt_qty1;
                  }else{
                    total_adl_qty =0;
                  }
                total_adl_all = total_adl_all + dsr_adl;
                if(status_discount == 'Nominal'){
                disc_adl = total_adl_all - (disc * total_adl_qty);
                }else if(status_discount == 'Persen'){
                disc_adl = ((total_adl_all * disc)/100);
                }
            }"      
         ."if(type_bd == '2'){
           var dt_qty2    = parseFloat($('#'+bb+'').val());
           var dsr_chtb   = dasar_child_twin_bed * dt_qty2;
           if(dsr_chtb != ''){
           total_chtb_qty   += dt_qty2;
          }else{
           total_chtb_qty =0;
          }
          
           total_chtb_all = total_chtb_all + dsr_chtb;
           if(status_discount == 'Nominal'){
            disc_chtb = total_chtb_all - (disc * total_chtb_qty);
            }else if(status_discount == 'Persen'){
            disc_chtb = ((total_chtb_all * disc)/100);
            }
          }"
          ."if(type_bd == '3'){
           var dt_qty3    = parseFloat($('#'+bb+'').val());
           var dsr_cheb   = dasar_child_extra_bed * dt_qty3;
           if(dsr_cheb != ''){
            total_cheb_qty   += dt_qty3;
           }else{
            total_cheb_qty = 0;
           }
            
           total_cheb_all = total_cheb_all + dsr_cheb;
           if(status_discount == 'Nominal'){
            disc_cheb = total_cheb_all - (disc * total_cheb_qty);
            }else if(status_discount == 'Persen'){
            disc_cheb = ((total_cheb_all * disc)/100);
            }
          }"
          ."if(type_bd == '4'){
           var dt_qty4    = parseFloat($('#'+bb+'').val());
           var dsr_chnb   = dasar_child_no_bed * dt_qty4;
           if(dsr_chnb != ''){
           total_chnb_qty   += dt_qty4;
           }else{
           total_chnb_qty = 0;
           }
           total_chnb_all = total_chnb_all + dsr_chnb;
            if(status_discount == 'Nominal'){
            disc_chnb = total_chnb_all - (disc * total_chnb_qty);
            }else if(status_discount == 'Persen'){
            disc_chnb = ((total_chnb_all * disc)/100);
            }
          }"
        ."if(type_bd == '5'){
           var dt_qty5    = parseFloat($('#'+bb+'').val());
           var dsr_sgl_supp   = sgl_supp * dt_qty5;
           if(dsr_sgl_supp != ''){
              total_sgl_supp_qty   += dt_qty5;
            }else{
            total_sgl_supp_qty = 0;
            }
            
           total_sgl_supp_all = total_sgl_supp_all + dsr_sgl_supp;
            if(status_discount == 'Nominal'){
            disc_sgl_supp = total_sgl_supp_all - (disc * total_sgl_supp_qty);
            }else if(status_discount == 'Persen'){
            disc_sgl_supp = ((total_sgl_supp_all * disc)/100);
            }
          }"
        ."}"
            ." var hasil_adl_twin = (isNaN(total_adl_qty)) ? 0 : total_adl_qty;"
            ." $('#adl_twin').text(hasil_adl_twin);"
            ." var hasil_adl_twin_disc = (isNaN(disc_adl)) ? 0 : disc_adl;"
            ." $('#disc_adl_twin').text(numberformat(hasil_adl_twin_disc));"
            ." var hasil_total_adl_all = (isNaN(total_adl_all)) ? 0 : total_adl_all;"
            ." $('#total_adl_twin').text(numberformat(hasil_total_adl_all));"
            ." var hasil_chtb_qty = (isNaN(total_chtb_qty)) ? 0 : total_chtb_qty;"
            ." $('#chl_tb').text(hasil_chtb_qty);"
             ." var hasil_total_chtb_all = (isNaN(total_chtb_all)) ? 0 : total_chtb_all;"
            ." $('#total_chl_tb').text(numberformat(hasil_total_chtb_all));"
            ." var hasil_total_chtb_all_disc = (isNaN(disc_chtb)) ? 0 : disc_chtb;"
            ." $('#disc_chl_tb').text(numberformat(hasil_total_chtb_all_disc));"
            ." var hasil_cheb_qty = (isNaN(total_cheb_qty)) ? 0 : total_cheb_qty;"
            ." $('#chl_eb').text(hasil_cheb_qty);"
            ." var hasil_total_cheb_all = (isNaN(total_cheb_all)) ? 0 : total_cheb_all;"
            ." $('#total_chl_eb').text(numberformat(hasil_total_cheb_all));"
            ." var hasil_total_cheb_all_disc = (isNaN(disc_cheb)) ? 0 : disc_cheb;"
            ." $('#disc_chl_eb').text(numberformat(hasil_total_cheb_all_disc));"
            ." var hasil_chnb_qty = (isNaN(total_chnb_qty)) ? 0 : total_chnb_qty;"
            ." $('#chl_nb').text(hasil_chnb_qty);"
            ." var hasil_total_chnb_all = (isNaN(total_chnb_all)) ? 0 : total_chnb_all;"
            ." $('#total_chl_nb').text(numberformat(hasil_total_chnb_all));"
            ." var hasil_total_chnb_all_disc = (isNaN(disc_chnb)) ? 0 : disc_chnb;"
            ." $('#disc_chl_nb').text(numberformat(hasil_total_chnb_all_disc));"
            ." var hasil_sgl_supp_qty = (isNaN(total_sgl_supp_qty)) ? 0 : total_sgl_supp_qty;"
            ." $('#sgl_supp').text(hasil_sgl_supp_qty);"
            ." var hasil_total_sgl_supp_all_disc = (isNaN(disc_sgl_supp)) ? 0 : disc_sgl_supp;"
            ." $('#disc_sgl_supp').text(numberformat(hasil_total_sgl_supp_all_disc));"
             ." var hasil_total_sgl_supp_all = (isNaN(total_sgl_supp_all)) ? 0 : total_sgl_supp_all;"
            ." $('#total_sgl_supp').text(numberformat(hasil_total_sgl_supp_all));"
      ." total_qty = total_adl_qty + total_chtb_qty + total_cheb_qty + total_chnb_qty + total_sgl_supp_qty;"
      ." var hasil_total_qty = (isNaN(total_qty)) ? 0 : total_qty;"
      ." $('#tax').text(hasil_total_qty);"
      . "total_tax_ins = hasil_total_qty * tax_ins;"
      ." var hasil_total_tax_ins = (isNaN(total_tax_ins)) ? 0 : total_tax_ins;"
      ." $('#total_tax').text(numberformat(hasil_total_tax_ins));"
      ." total_price_all = parseFloat(hasil_total_adl_all + hasil_total_chtb_all + hasil_total_cheb_all + hasil_total_chnb_all + hasil_total_sgl_supp_all + hasil_total_tax_ins);"
      ." total_price_person = parseFloat(hasil_total_adl_all + hasil_total_chtb_all + hasil_total_cheb_all + hasil_total_chnb_all + hasil_total_sgl_supp_all);"
      ." $('.tot_price').text(numberformat(total_price_person));"
      ." total_person_disc = parseFloat(hasil_adl_twin_disc + hasil_total_chtb_all_disc + hasil_total_cheb_all_disc + hasil_total_chnb_all_disc + hasil_total_sgl_supp_all_disc);"
      ." $('.disc_tot_all').text(numberformat(total_person_disc));"
      ." hasil_keseluruhan = total_price_all - total_person_disc;"
     // ."if(status_discount == 'Nominal'){"
     // ." hasil_keseluruhan = total_price_all - (disc * total_price_person);"
     // ."}else if(status_discount == 'Persen'){"
     // ."hasil_price_person = ((total_price_person * disc)/100);"
     // ."hasil_keseluruhan = total_price_all - hasil_price_person; "
     // ." $('.tot_discount').text(numberformat(hasil_price_person));"
     // ."}"
      ." $('.tot_all').text(numberformat(hasil_keseluruhan));"
      ." ppn = parseFloat((1 * hasil_keseluruhan)/100);"
      ." $('.ppn').text(numberformat(ppn));"
      ." total_all_pax = ppn + hasil_keseluruhan;"
      ." $('.total_all').text(numberformat(total_all_pax));"
      ." $('#total_pr').val(total_all_pax);"
      ."}"
      
      . "function hitung_information(){"
        . "var adult_triple_twin          = $('#jml_adult').val() * 1;"
        . "var dasar_adult_triple_twin    = $('input[name=dasar_adult_triple_twin]').val() * 1;"
      
        . "var child                    = $('#jml_child').val() * 1;"
        . "var dasar_child_twin_bed    = $('input[name=dasar_child]').val() * 1;"
      
        . "var infant         = $('#jml_infant').val() * 1;"
        . "var dasar_infant   = $('input[name=dasar_infant]').val() * 1;"
      
        . " var total_adult   = adult * dasar_adult;"
        . " var total_child   = child * dasar_child;"
        . " var total_infant  = infant * dasar_infant;"
      
        . " var total = total_adult + total_child + total_infant;"
      
        . "$('#harga_adult').text(total_adult);"
        . "$('#harga_child').text(total_child);"
        . "$('#harga_infant').text(total_infant);"
        . "$('#harga_total').text(total);"
      . "}"
      ."function tambah_items(){"
      ."var num = $('.number').length;"
      ."var num_addrow = $('.type_bedq').length;"
      ."var jmldata = (num_addrow + 1);"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-book-tour")."',"
      ."data: {name: num, datarow: jmldata},"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-items').append(data);"
      ."},"
    ."});"
        ."}"
      ."function tambah_items_delete(id){"
      ."var num = $('.data-bed'+id+'').remove();"
        ."}"
      ."function tambah_delete_room(id){"
      ."var num = $('.data-room'+id+'').remove();"
        ."}"
      ."function tambah_item_rooms(){"
      ."var numItems = $('.number').length;"
    //  ."var dataString = 'name1='+ numItems;"
      ."var jml = (numItems + 1);"
      ."$('#jml_room').val(jml);"
      ."var num_addrow = $('.type_bedq').length;"
      ."var jmldata = (num_addrow + 1);"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-room-book-tour")."',"
      ."data: {name1: numItems, datarow1: jmldata},"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-item-rooms').append(data);"
      ."},"
    ."});"
        ."}"
      . "</script>";
    $foot .= "<script>
function FormatCurrency(objNum)
{
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue)
   {
     num = MoneyToNumber(num);
     if (isNaN(num))
     {
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
       {
        // alert(num.split('.')[1]);
         objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else
       {
         objNum.value = AddCommas(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function MoneyToNumber(num)
{
   return (num.replace(/,/g, ''));
}

function AddCommas(num)
{
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+=',';
   }
   return numArr.reverse().join('');
} 
        
function formatCurrency(num) {
   num = num.toString().replace(/\$|\,/g,'');
   if(isNaN(num))
   num = '0';
   sign = (num == (num = Math.abs(num)));
   num = Math.floor(num*100+0.50000000001);
   cents = num0;
   num = Math.floor(num/100).toString();
   for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
   num = num.substring(0,num.length-(4*i+3))+'.'+
   num.substring(num.length-(4*i+3));
   return (((sign)?'':'-') + num);
}
</script>";
//   print "a";
//   die;
     $post = array(
      "users"         => USERSSERVER,
      "password"      => PASSSERVER,
      "id_inventory"  => $id_inventory,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-get-detail");  
    $data_array = json_decode($data);
    
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-ttu-get");  
    $data_ttu = json_decode($data);
    
    $this->template->build('inventory/book-tour', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "payment/inventory",
            'title'       => "Form Book Tour",
            'detail'      => $detail_array,
            'id_inventory' => $id_inventory,
            'data'          => $data_array->data->inventory,
            'ttu'           => $data_ttu->data, 
            'breadcrumb'  => array(
              "product_tour"  => "payment/inventory"
            ),
            'foot'        => $foot,
          ));
    $this->template
      ->set_layout('form')
      ->build('inventory/book-tour');
  }
  
    function book_info(){
    $pst = $this->input->post(NULL);
    
    
     $post = array(
      "users"         => USERSSERVER,
      "password"      => PASSSERVER,
      "id_inventory"  => $pst['id_inventory'],
//      "id_users"      => 5   
      "id_users"      => $this->session->userdata("id")   
    );
     
    $js_inventory       = $this->global_variable->curl_mentah($post, URLSERVER."json/json-inventory/cek-tour-inventory");  
    $js_inventory_array = json_decode($js_inventory);
//        $this->debug($js_inventory, true);
        
//    print_r($post);
//        print_r($js_inventory_array);
//        die;
    if($js_inventory_array->status == 1){
        $this->session->set_flashdata('notice', 'Tidak di izinkan');
        redirect("tour/tour-inventory/search/{$pst['id_inventory']}");
    }elseif($js_inventory_array->status == 3){
        $this->session->set_flashdata('notice', 'Tidak ada Akses untuk book tour dari inventory');
        redirect("tour/tour-inventory/search/{$pst['id_inventory']}");
    }
    
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-get-detail");  
    $data_array = json_decode($data);
//    $this->debug($data, true);
    
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-ttu-get");  
    $data_ttu = json_decode($data);
    
    if($pst['jumlah_room']){
      $jml_room = $pst['jumlah_room'];
    }else{
      $jml_room = $this->session->userdata('jml_room');
    }
                        
     $ses_type_bed = array(
           "jml_room"   => $jml_room
          );
          $this->session->set_userdata($ses_type_bed);     
    
          if($this->session->userdata('jml_room')){
              for($k = 1 ; $k <= $this->session->userdata('jml_room'); $k++){
                $type_bed = "type_bed".$k;
                $qty = "qty".$k;
                if($pst[$type_bed]){
                    $type_bed = $pst[$type_bed];
                }else{
                  $type_bed = $this->session->userdata($type_bed);
                }
                
                if($pst[$qty]){
                    $qty = $pst[$qty];
                }else{
                  $qty = $this->session->userdata($qty);
                }
                
                $ses_datatype= array(
            "type_bed".$k   => $type_bed,
                  "qty".$k => $qty
          );
          $this->session->set_userdata($ses_datatype); 
                foreach($pst['qty'.$k] AS $pstqty){
                  $total_pstqty += $pstqty;
                }
              }
            }
           
//    $this->debug($pst, true);
    if(($total_pstqty + $pst['dp']) > $pst['seat']){
      $this->session->set_flashdata('notice', 'Full. Hanya memungkinkan untuk '.($pst['seat'] - $pst['dp']));
      redirect("grouptour/product-tour/book-tour/{$pst['tour_information_code']}");
    }
    
    
    $foot = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<script type='text/javascript'>"
      
        . "function set_nama(){"
          . "var depan = $('#pemesan_depan').val();"
          . "var belakang = $('#pemesan_belakang').val();"
          . "var no_telp = $('#no_telp_pemesan').val();"
          . "$('#tfirst0').val(depan);"
          . "$('#tlast0').val(belakang);"
          . "$('#ano_telp_pemesan').val(no_telp);"
        . "}"
      ."function tambah_items(){"
      ."var num = $('.number').length;"
      ."var dataString2 = 'name='+ num;"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-additional-book-tour")."',"
      ."data: dataString2,"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-items').append(data);"
      ."},"
    ."});"
        ."}" 
        . "$(document).ready(function () {"
            
        . '$("#but_sub").click(function(){'
        . "var ndepan     = $('#pemesan_depan').val();"
        . "var nbelakang  = $('#pemesan_belakang').val();"
        . "var email_pemesan  = $('#email_pemesan').val();"
        . "var no_telp_pemesan  = $('#no_telp_pemesan').val();"
        . "var address  = $('#address_pemesan').val();"
        . "var total_person  = $('#total_person').val();"
       
      . "var tfirst2 = 'tfirst'; "
      . "var tlast2 = 'tlast'; "
      . "var ttlahir2 = 'tlahir'; "
      ."for(var i = 0; i < total_person; i++) {"
            ."aa = tfirst2 + i;"
            ."bb = tlast2 + i;"
            ."cc = ttlahir2 + i;"
            ."var fstname = $('#'+aa+'').val();"
            ."var ltname = $('#'+bb+'').val();"
//            ."var tlhr = $('#'+cc+'').val();"
//            ."if(fstname == ''){"
//              ."alert('First Name Harus di Isi');"
//              ."return false;"
//            ."}"
//            ."if(ltname == ''){"
//                ."alert('Last Name Harus di Isi');"
//                ."return false;"
//            ."}"
//            ."if(tlhr == ''){"
//                ."alert('Tanggal Lahir Harus di Isi');"
//                ."return false;"
//            ."}"
      ."}"
        . "if(ndepan ==''){"
        . "alert('Nama Depan Pemesan Harus di isi');"
        . "return false; }" 
        . "if(nbelakang == ''){"
        . "alert('Nama Belakang Pemesan Harus di isi');"
        . "return false; }"
        . "if(email_pemesan ==''){"
        . "alert ('Email Pemesan Harus di Isi');"
        . "return false; }"
        . "if(no_telp_pemesan == ''){"
        . "alert('No Telp Pemesan Harus di Isi');"
        . "return false; }"
        . "if(address == ''){"
        . "alert('Alamat Pemesan Harus di Isi');"
        . "return false; }"
//        . "if(dasar_adult_triple_twin == ''){"
//        . "alert('Adult Triple Twin');"
//        . "return false; } "
        
        . "return true;"
       . '});'
          . "$( '.adult_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-75:-13',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
          . "$( '.child_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-12:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
        . "$( '.passport' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-5:+7',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
          . "$( '.infant_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-2:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
		  
		  . "$( '#agent' ).change(function(){"
            . "$.post('".site_url('grouptour/grouptour-ajax/set-detail')."', {id: $(this).val()}, function(hasil){"
              . "var data = $.parseJSON(hasil);"
              . "$('#pemesan_depan').val(data.pic1);"
              . "$('#pemesan_belakang').val(data.pic2);"
              . "$('#email_pemesan').val(data.email);"
              . "$('#no_telp_pemesan').val(data.telp);"
              . "$('#address_pemesan').val(data.alamat);"
            . "});"
          . "});"
		  
        . "})"
      . "</script>";
	  
//	$post_agent = array(
//      "users"             => USERSSERVER,
//      "password"          => PASSSERVER,
//      "status"            => 1
//    );
//  $this->debug($pst, true);
//    $agent = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-sub-agent");  
//    $agent_array = json_decode($agent);
//    foreach($agent_array->data AS $aa){
//      $sub_agent[$aa->id_master_sub_agent] = $aa->name;
//    }
    
//    $pameran = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
//    $pameran_array = json_decode($pameran);
//    $pameran_drop[NULL] = '- Pilih -';
//    foreach($pameran_array->data AS $pp){
//      $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d M y", strtotime($pp->date_start));
//    }
    
    $this->template->build('inventory/book-info', 
      array(
            'url'           => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'          => "payment/inventory",
            'pst'           => $pst,
            'title'         => lang("Book Informasi Penumpang"),
            'foot'          => $foot,
            'sub_agent'     => $sub_agent,
            'pameran'       => $pameran_drop,
            'id_inventory'  => $pst['id_inventory'],
            'payment'       => $js_inventory_array->payment,
            'data'          => $data_array->data->inventory,
            'ttu'           => $data_ttu->data, 
            'breadcrumb'    => array(
            "product_tour"  => "payment/inventory"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('inventory/book-info');
  }
  
}  