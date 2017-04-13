<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_pameran extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function master(){
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "";
    $foot .= "<script>"
      
      . "$(function() {"
        . "$('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
      
      . "});"
      . "</script>";
    
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-pameran");  
    $data_array = json_decode($data);
     
    $this->template->build('pameran/master', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/master",
        'title'         => lang("Master Pameran"),
        'foot'          => $foot,
        'css'           => $css,
        'data'           => $data_array->data,
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/master');
  }
  
  function report(){
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "";
    $foot .= "<script>"
      
      . "$(function() {"
        . "$('#tableboxy').dataTable({"
          . "'bLengthChange': false,"
          . "'iDisplayLength': -1"
        . "});"
      
      . "});"
      . "</script>";
    
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-pameran");  
    $data_array = json_decode($data);
     
    $this->template->build('pameran/report', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/report",
        'title'         => lang("Pameran"),
        'foot'          => $foot,
        'css'           => $css,
        'data'           => $data_array->data,
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/report');
  }
  
  public function add_new($id_tour_pameran = 0){
    if(!$this->input->post(NULL)){
      $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
      $foot = ""
        . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
        . "";
      $foot .= "<script>"

        . "$(function() {"
          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true"
          . "});"
        . "});"

      . "</script>";
      
      if($id_tour_pameran){
        $post = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "id_tour_pameran"   => $id_tour_pameran
        );
        $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-pameran");  
        $data_array = json_decode($data);
      }
      
      $this->template->build("pameran/add-new", 
        array(
          'url'         => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'        => 'tour/tour-pameran/master',
          'title'       => lang("Form Master Pameran"),
          'breadcrumb'  => array(
                "Master Pameran"  => "tour/pameran/master"
          ),
          'css'         => $css,
          'foot'        => $foot,
          'detail'      => $data_array->data,
        ));
      $this->template
        ->set_layout('form')
        ->build("pameran/add-new");
    }
    else{
      $pst = $this->input->post(NULL);
      $post = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
        "title"       => $pst['title'],
        "code"        => $pst['code'],
        "date_start"  => $pst['date_start'],
        "date_end"    => $pst['date_end'],
        "location"    => $pst['location'],
        "note"        => $pst['note'],
        "id_users"    => $this->session->userdata("id"),
      );
      if($pst['id_detail'])
        $post['id_tour_pameran'] = $pst['id_detail'];
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/set-master-pameran");  
      $data_array = json_decode($data);
//      $this->debug($data, true);
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/tour-pameran/master");
    }
  }
  
  public function list_users($id_tour_pameran){
    if(!$this->input->post(NULL)){
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />";
      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
        . "<script>"
          . "$(function() {"
            . "$( '#users' ).autocomplete({"
              . "source: '".site_url("tour/ajax/users")."',"
              . "minLength: 1,"
              . "search  : function(){ $(this).addClass('working');},"
              . "open    : function(){ $(this).removeClass('working');},"
              . "select: function( event, ui ) {"
                . "$('#id_users').val(ui.item.id);"
              . "}"
            . "});"
            . "$(document).on('click', '.delete', function(evt){"
              . "var didelete = $(this).attr('isi');"
              . "$('#'+didelete).remove();"
            . "});"
            . "$(document).on('click', '#add-row', function(evt){"
              . "$.post('".site_url("tour/ajax/add-row")."',{no: $('#nomor').val()},function(data){"
//                . "$('#wadah').insertBefore(data);"
                . "$(data).insertBefore('#wadah');"
                . "var t = ($('#nomor').val() * 1) + 1;"
                . "$('#nomor').val(t);"
              . "});"
            . "});"
          . "});"
        . "</script>";
      
      $list_users = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "id_tour_pameran"   => $id_tour_pameran
      );
      $l_users = $this->global_variable->curl_mentah($list_users, URLSERVER."json/json-tour/get-pameran-users");  
      $users_array = json_decode($l_users);
//      $this->debug($l_users, true);
      foreach ($users_array->data AS $key => $det){
        $hasil .= "<div class='input-group margin' id='users-box{$key}'>"
            . "<input type='text' class='form-control' value='{$det->name} <{$det->email}>' id='users{$key}' name='users[]'>"
            . "<input type='text' class='form-control' value='{$det->id_users}' id='id_users{$key}' name='id_users[]' style='display: none'>"
            . "<span class='input-group-btn'>"
              . "<a href='javascript:void(0)' class='btn btn-danger btn-flat delete' isi='users-box{$key}'>"
                . "<i class='fa fa-fw fa-times'></i>"
              . "</a>"
            . "</span> "
          . "</div>";
        $foot .= "<script>"
              . "$(function() {"
                . "$( '#users{$key}' ).autocomplete({"
                  . "source: '".site_url("tour/ajax/users")."',"
                  . "minLength: 1,"
                  . "search  : function(){ $(this).addClass('working');},"
                  . "open    : function(){ $(this).removeClass('working');},"
                  . "select: function( event, ui ) {"
                    . "$('#id_users{$key}').val(ui.item.id);"
                  . "}"
                . "});"
              . "});"
          . "</script>";
      }
      $this->template->build("pameran/list-users", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'tour/tour-pameran/master',
              'title'       => lang("Management Users"),
              'detail'      => count($detail),
              'hasil'       => $hasil,
              'breadcrumb'  => array(
                    "Master Pameran"  => "tour/pameran/master"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("pameran/list-users");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "id_tour_pameran"   => $id_tour_pameran,
        "id_users"          => json_encode($pst['id_users']),
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/set-pameran-users");  
      $data_array = json_decode($data);
//      $this->debug($data, true);
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/tour-pameran/master");
    }
  }
  
  function report_book($id_tour_pameran){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      $this->session->set_userdata($pst);
    }
    
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_tour_pameran" => $id_tour_pameran,
      "region"      => $this->session->userdata("tour_region"),
      "store"       => $this->session->userdata("tour_store"),
      "code"        => $this->session->userdata("tour_code"),
      "status"          => $this->session->userdata("tour_status"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-penjualan-pameran");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store = json_decode($data_store);
    
//    $this->debug($data, true);
//    $this->debug($data_array, true);
//    $this->debug($store, true);
    
    $status = array(
      1 => "<span class='label label-warning'>Book</span>",
      2 => "<span class='label label-info'>Deposit</span>",
      3 => "<span class='label label-success'>Lunas</span>",
      4 => "<span class='label label-danger'>Batal</span>",
    );
    $region = array(
      1 => "Eropa",
      2 => "Middle East Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
    );
    $total = $data_store = array();
    foreach ($data_array->data AS $dt){
      $pax = 0;
      $pax = $dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp;
      $cetak .= "<tr>"
         . "<td>".date("d M y H:i:s", strtotime($dt->tanggal))."</td>"
        . "<td>{$region[$dt->sub_category]}</td>"
        . "<td>{$dt->tour_name}</td>"
        . "<td>{$dt->kode}</td>"
        . "<td>{$dt->bstore} {$dt->cstore}</td>"
        . "<td>{$status[$dt->status]}</td>"
        . "<td style='text-align: right'>{$pax}</td>"
        . "<td style='text-align: right'>".number_format($dt->debit)."</td>"
        . "<td style='text-align: right'>".number_format($dt->kredit)."</td>"
        . "<td style='text-align: right'>".number_format(($dt->debit-$dt->kredit))."</td>"
      . "</tr>";
      $total['pax']               += $pax;
      $total['penjualan']         += $dt->debit;
      $total['deposit']           += $dt->kredit;
      
      if($dt->bid_store){
        $data_store[$dt->bid_store]['pax']        += $pax;
        $data_store[$dt->bid_store]['penjualan']  += round(($dt->debit/1000000),2);
        $data_store[$dt->bid_store]['deposit']    += round(($dt->kredit/1000000),2);
      }
      else{
        $data_store[$dt->cid_store]['pax']        += $pax;
        $data_store[$dt->cid_store]['penjualan']  += round(($dt->debit/1000000), 2);
        $data_store[$dt->cid_store]['deposit']    += round(($dt->kredit/1000000), 2);
      }
    }
    $labels = $data_pax = "";
    $store_dd[NULL] = '- Pilih -';
    foreach ($store->data AS $sd){
      $store_dd[$sd->id_store] = $sd->title;
      $labels .= "'{$sd->title}',";
      if($data_store[$sd->id_store]['penjualan'])
        $data_penjualan .= "{$data_store[$sd->id_store]['penjualan']},";
      else
        $data_penjualan .= "0,";
      if($data_store[$sd->id_store]['deposit'])
        $data_deposit .= "{$data_store[$sd->id_store]['deposit']},";
      else
        $data_deposit .= "0,";
      if($data_store[$sd->id_store]['pax'])
        $data_pax .= "{$data_store[$sd->id_store]['pax']},";
      else
        $data_pax .= "0,";
    }
    
//    $this->debug($labels);
//    $this->debug($data_store, true);
    
     $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    $css .= "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/jquery.jqplot.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/styles/shCoreDefault.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/styles/shThemejqPlot.min.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>";
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.js' type='text/javascript'></script>";

   $foot .= ""
     // . "<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' type='text/javascript'></script>"
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/jquery.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/jquery.jqplot.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/scripts/shCore.min.js' type='text/javascript'></script>"
      //. "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/scripts/shBrushJScript.min.js' type='text/javascript'></script>"
      //. "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/scripts/shBrushXml.min.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.barRenderer.min.js' type='text/javascript'></script>"
    //  . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.pieRenderer.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.pointLabels.min.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasAxisLabelRenderer.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasAxisTickRenderer.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.logAxisRenderer.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasTextRenderer.js' type='text/javascript'></script>"
      
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.dateAxisRenderer.js' type='text/javascript'></script>"
     // . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.js' type='text/javascript'></script>"
      ;
    
	$foot .= "
    <script class='code' type='text/javascript'>$(document).ready(function(){
        var s1 = [{$data_penjualan}];
        var s2 = [{$data_deposit}];
        var ticks = [{$labels}];
        
        plot2 = $.jqplot('canvas', [s1, s2], {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true },
                
            },
        legend: {
            show: true,
            placement: 'outside',
        rendererOptions: {
                numberRows: 1
            }, 
            location: 'nw',     // compass direction, nw, n, ne, e, se, s, sw, w.
        },
        series: [
            {
                fill: true,
                label: 'TTL Sales'
                
            },
            {
                label: 'Payment'
            }
        ],
        
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks,
                    label: 'Store',
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                       //  labelPosition: 'middle',
                        angle: -70
                    },
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer,
                      label:'STORE', 
                      labelOptions:{
                      fontFamily:'Times New Roman',
                      fontSize: '12pt'
                    },
                },
                yaxis:{
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer,
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    labelOptions:{
                        fontFamily:'Times New Roman',
                        fontSize: '12pt'
                    },
                    label:'JUTAAN RUPIAH'
                  } 
            },
        
        });
    });</script>
         <script class='code' type='text/javascript'>$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        var s1 = [{$data_pax}];
        var ticks = [{$labels}];
        
        plot1 = $.jqplot('canvas-pax', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            legend: {
            show: true,
            placement: 'outside',
        rendererOptions: {
                numberRows: 1
            }, 
            location: 'nw',     // compass direction, nw, n, ne, e, se, s, sw, w.
        },
        series: [
            {
                fill: true,
                label: 'PAX '
            },
        ],
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks,
                   // label: 'Store',
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    tickRenderer: $.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                       //  labelPosition: 'middle',
                        angle: -70
                    },
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer,
                      label:'STORE', 
                      labelOptions:{
                      fontFamily:'Helvetica',
                      fontSize: '12pt'
                    },
                },
                yaxis:{
                    tickRenderer:$.jqplot.CanvasAxisTickRenderer,
                    labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
                    labelOptions:{
                        fontFamily:'Helvetica',
                        fontSize: '12pt'
                    },
                    label:'JUMLAH PAX'
                  } 
            },
        });
    });</script>";
        
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
      . "</script>";
        
    $post_pameran = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "id_tour_pameran"   => $id_tour_pameran
    );
    $row_pameran = $this->global_variable->curl_mentah($post_pameran, URLSERVER."json/json-tour/get-master-pameran");  
    $pameran = json_decode($row_pameran);
     
    $this->template->build('pameran/report-book', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/report",
        'data'          => $data_array->data,
        'title'         => lang("Report Pameran")." ".$pameran->data[0]->title,
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd,
        'pameran'       => $pameran->data[0],
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/report-book');
  }
  
  function finance_report(){
    
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-all-store");
    $data_array = json_decode($data);
    $store[NULL] = "- All -";
    foreach ($data_array->data AS $da){
      $store[$da->id_store] = $da->title;
    }
    
    $post2 = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $pameran = $this->global_variable->curl_mentah($post2, URLSERVER."json/json-tour/tour-pameran-get");
    $pameran_array = json_decode($pameran);
    $pameran_d[NULL] = "- All -";
    foreach ($pameran_array->data AS $da){
      $pameran_d[$da->id_tour_pameran] = $da->title." ".date("d M y", strtotime($da->date_start));
    }
//    $this->debug($pameran, true);
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>"
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
      . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"
      . "<script>"
        . "$('.select2').select2();"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "</script>";
	  $pst = $this->input->post();
    if($pst){
      if($pst['sbt'] == 'xls'){
        $this->load->model('tour/mtour');
        $this->mtour->export_finance_report("payment", $pst);
      }
      
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
      foreach($kode_type AS $kt){
        $foot_ex .= ""
          . "var cash{$kt['col']} = hasil.jumlah.{$kt['id']} * 1;"
          . "console.log('{$kt['id']}');"
          . "console.log(cash{$kt['col']});"
          . "var jml_cash{$kt['col']} = str_replace(',','',$('#{$kt['id']}').html()) * 1;"
          . "console.log(jml_cash{$kt['col']});"
          . "var total_cash{$kt['col']} = cash{$kt['col']} + jml_cash{$kt['col']};"
          . "console.log(total_cash{$kt['col']});"
          . "$('#{$kt['id']}').html(number_format(total_cash{$kt['col']}));"
          . "";
      }
      
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
            . "leftColumns: 0,"
            . "rightColumns: 0"
          . "}"
        . "});"
        ."ambil_data(table, 0);"
        . "function ambil_data(table, start){"
          . "$.post('".site_url("tour/tour-pameran-ajax/finance-report-get")."', {start: start, "
          . "nomor: $('#nomor').val(),"
          . "awal: '{$pst['awal']}',"
          . "akhir: '{$pst['akhir']}',"
          . "id_tour_pameran: '{$pst['id_tour_pameran']}',"
          . "id_store: '{$pst['id_store']}'}, function(data){"
            . "var hasil = $.parseJSON(data);"
            . "if(hasil.status == 2){"
              . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
//                . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                . "$('#nomor').val(hasil.nomor);"
              . '}'
              
              . "{$foot_ex}"
//              . "$('#tttt').html;"
            
              . "ambil_data(table, hasil.start);"
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
    
    $this->template->build('pameran/finance-report', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/finance-report",
        'data'          => $data_array->data,
        'title'         => lang("Group Status Close"),
        'foot'          => $foot,
        'css'           => $css,
        'store'         => $store,
        'pameran'       => $pameran_d,
        'awal'          => $pst['awal'],
        'akhir'         => $pst['akhir'],
        'detail'        => array("id_tour_pameran" => $pst['id_tour_pameran'], "id_store" => $pst['id_store']),
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/finance-report');
  }
  
  function cashier_report(){
    
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-all-store");
    $data_array = json_decode($data);
    $store[NULL] = "- All -";
    foreach ($data_array->data AS $da){
      $store[$da->id_store] = $da->title;
    }
    
    $post2 = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $pameran = $this->global_variable->curl_mentah($post2, URLSERVER."json/json-tour/tour-pameran-get");
    $pameran_array = json_decode($pameran);
    $pameran_d[NULL] = "- All -";
    foreach ($pameran_array->data AS $da){
      $pameran_d[$da->id_tour_pameran] = $da->title." ".date("d", strtotime($da->date_start))." -".date("d M y", strtotime($da->date_end));
    }
//    $this->debug($pameran, true);
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>"
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
      . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"
      . "<script>"
        . "$('.select2').select2();"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "</script>";
	  $pst = $this->input->post();
    if($pst){
      if($pst['sbt'] == 'xls'){
        $this->load->model('tour/mtour');
        $this->mtour->export_cashier_report("payment", $pst);
      }
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "awal"                => $pst['awal'],
        "akhir"               => $pst['akhir'],
        "id_tour_pameran"     => $pst['id_tour_pameran'],
        "id_store"            => $pst['id_store'],
        "type"                => $pst['type'],
        "jenis"               => $pst['jenis'],
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cashier-get");
      $data_array = json_decode($data);
      
//      $kode_type = array(
//        1   => array("id" => "tunai", "col" => 7),
//        3   => array("id" => "mega", "col" => 8),
//        2   => array("id" => "bca", "col" => 9),
//        4   => array("id" => "mandiri", "col" => 10),
//        7   => array("id" => "dbca", "col" => 11),
//        14  => array("id" => "dmandiri", "col" => 12),
//        15  => array("id" => "dbni", "col" => 13),
//        9   => array("id" => "ccbca", "col" => 14),
//        5   => array("id" => "ccmega", "col" => 15),
//        11  => array("id" => "ccbni", "col" => 16),
//        12  => array("id" => "ccmandiri", "col" => 17),
//        13  => array("id" => "cccity", "col" => 18),
//        10  => array("id" => "cclain", "col" => 19),
//        16  => array("id" => "certificate", "col" => 20),
//        17  => array("id" => "voucher", "col" => 21),
//        18  => array("id" => "ctcorp", "col" => 22),
//        19  => array("id" => "point", "col" => 23),
//        20  => array("id" => "kupon", "col" => 24),
//      );
//      foreach($kode_type AS $kt){
//        $foot_ex .= ""
//          . "var cash{$kt['col']} = hasil.jumlah.{$kt['id']} * 1;"
//          . "console.log('{$kt['id']}');"
//          . "console.log(cash{$kt['col']});"
//          . "var jml_cash{$kt['col']} = str_replace(',','',$('#{$kt['id']}').html()) * 1;"
//          . "console.log(jml_cash{$kt['col']});"
//          . "var total_cash{$kt['col']} = cash{$kt['col']} + jml_cash{$kt['col']};"
//          . "console.log(total_cash{$kt['col']});"
//          . "$('#{$kt['id']}').html(number_format(total_cash{$kt['col']}));"
//          . "";
//      }
      
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
            . "leftColumns: 0,"
            . "rightColumns: 0"
          . "}"
        . "});"
            
      . "</script>";
    }
    
    $this->template->build('pameran/cashier-report', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/cashier-report",
        'data'          => $data_array->data,
        'title'         => lang("Kasir Report"),
        'foot'          => $foot,
        'css'           => $css,
        'store'         => $store,
        'pameran'       => $pameran_d,
        'awal'          => $pst['awal'],
        'akhir'         => $pst['akhir'],
        'detail'        => array("id_tour_pameran" => $pst['id_tour_pameran'], "id_store" => $pst['id_store'], "type" => $pst['type'], "jenis" => $pst['jenis']),
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/cashier-report');
  }
  
   function report_pameran(){
     
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-all-store");
    $data_array = json_decode($data);
    $store[NULL] = "- All -";
    foreach ($data_array->data AS $da){
      $store[$da->id_store] = $da->title;
    }
    
    $post2 = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $pameran = $this->global_variable->curl_mentah($post2, URLSERVER."json/json-tour/tour-pameran-get");
    $pameran_array = json_decode($pameran);
    $pameran_d[NULL] = "- All -";
    foreach ($pameran_array->data AS $da){
      $pameran_d[$da->id_tour_pameran] = $da->title." ".date("d M y", strtotime($da->date_start));
    }
//    $this->debug($pameran, true);
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>"
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
      . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"
      . "<script>"
        . "$('.select2').select2();"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "</script>";
	  $pst = $this->input->post();
    if($pst){
      if($pst['sbt'] == 'xls'){
        $this->load->model('tour/mtour');
        $this->mtour->export_cashier_report("payment", $pst);
      }
      $post = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER,
        "awal"                => $pst['awal'],
        "akhir"               => $pst['akhir'],
        "id_tour_pameran"     => $pst['id_tour_pameran'],
        "id_store"            => $pst['id_store'],
        "type"                => $pst['type'],
        "jenis"               => $pst['jenis'],
      );
      $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-series-cashier-get");
      $data_array = json_decode($data);
      
//      $kode_type = array(
//        1   => array("id" => "tunai", "col" => 7),
//        3   => array("id" => "mega", "col" => 8),
//        2   => array("id" => "bca", "col" => 9),
//        4   => array("id" => "mandiri", "col" => 10),
//        7   => array("id" => "dbca", "col" => 11),
//        14  => array("id" => "dmandiri", "col" => 12),
//        15  => array("id" => "dbni", "col" => 13),
//        9   => array("id" => "ccbca", "col" => 14),
//        5   => array("id" => "ccmega", "col" => 15),
//        11  => array("id" => "ccbni", "col" => 16),
//        12  => array("id" => "ccmandiri", "col" => 17),
//        13  => array("id" => "cccity", "col" => 18),
//        10  => array("id" => "cclain", "col" => 19),
//        16  => array("id" => "certificate", "col" => 20),
//        17  => array("id" => "voucher", "col" => 21),
//        18  => array("id" => "ctcorp", "col" => 22),
//        19  => array("id" => "point", "col" => 23),
//        20  => array("id" => "kupon", "col" => 24),
//      );
//      foreach($kode_type AS $kt){
//        $foot_ex .= ""
//          . "var cash{$kt['col']} = hasil.jumlah.{$kt['id']} * 1;"
//          . "console.log('{$kt['id']}');"
//          . "console.log(cash{$kt['col']});"
//          . "var jml_cash{$kt['col']} = str_replace(',','',$('#{$kt['id']}').html()) * 1;"
//          . "console.log(jml_cash{$kt['col']});"
//          . "var total_cash{$kt['col']} = cash{$kt['col']} + jml_cash{$kt['col']};"
//          . "console.log(total_cash{$kt['col']});"
//          . "$('#{$kt['id']}').html(number_format(total_cash{$kt['col']}));"
//          . "";
//      }
      
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
            . "leftColumns: 0,"
            . "rightColumns: 0"
          . "}"
        . "});"
            
      . "</script>";
    }
    
    $this->template->build('pameran/report-pameran', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-pameran/report-pameran",
        'data'          => $data_array->data,
        'title'         => lang("Report Pameran"),
        'foot'          => $foot,
        'css'           => $css,
        'store'         => $store,
        'pameran'       => $pameran_d,
        'awal'          => $pst['awal'],
        'akhir'         => $pst['akhir'],
        'detail'        => array("id_tour_pameran" => $pst['id_tour_pameran'], "id_store" => $pst['id_store'], "type" => $pst['type'], "jenis" => $pst['jenis']),
      ));
    $this->template
      ->set_layout('default')
      ->build('pameran/report-pameran');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */