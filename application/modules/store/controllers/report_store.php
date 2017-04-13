<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_store extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
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
  
  function penjualan_tour(){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      $this->session->set_userdata($pst);
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $this->session->userdata("tour_start"),
      "end"         => $this->session->userdata("tour_end"),
      "region"      => $this->session->userdata("tour_region"),
      "store"       => $this->session->userdata("tour_store"),
      "code"        => $this->session->userdata("tour_code"),
      "status"      => $this->session->userdata("tour_status"),
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-penjualan-tour");
    $data_array = json_decode($data);
    
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store = json_decode($data_store);
    
//    $this->debug($data, true);
//    $this->debug($data_array, true);
//    $this->debug($store, true);
    
    $status = array(
      1 => "<span class='label label-warning'>Book</span>",
      2 => "<span class='label label-info'>Deposit</span>",
      3 => "<span class='label label-success'>Lunas</span>",
      4 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-warning'>Request Cancel</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      7 => "<span class='label label-warning'>Change</span>",
      8 => "<span class='label label-danger'>Cancel</span>",
      9 => "<span class='label label-danger'>Cancel</span>",
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
     
    $this->template->build('report/penjualan-tour', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/penjualan-tour",
        'data'          => $data_array->data,
        'title'         => lang("Report Penjualan"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd
      ));
    $this->template
      ->set_layout('default')
      ->build('report/penjualan-tour');
  }
  
  function keberangkatan_tour(){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      $this->session->set_userdata($pst);
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $this->session->userdata("tour_start"),
      "end"         => $this->session->userdata("tour_end"),
      "region"      => $this->session->userdata("tour_region"),
      "store"       => $this->session->userdata("tour_store"),
      "code"        => $this->session->userdata("tour_code"),
      "status"      => $this->session->userdata("tour_status"),
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-penjualan-tour-keberangkatan");
    $data_array = json_decode($data);
    
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
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
        . "<td>".date("d M y", strtotime($dt->start_date))."</td>"
        . "<td>".date("d M y", strtotime($dt->end_date))."</td>"
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
//    $foot = "";
    
    
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
     
    $this->template->build('report/keberangkatan-tour', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/penjualan-tour",
        'data'          => $data_array->data,
        'title'         => lang("Report Penjualan Berdasarkan Keberangkatan"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd
      ));
    $this->template
      ->set_layout('default')
      ->build('report/keberangkatan-tour');
  }
  
  function tour_close(){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
//      $this->debug($pst, true);
      $this->session->set_userdata($pst);
    }
//    print $this->session->userdata("tour_store");die;
    $post = array(
      "users"         => USERSSERVER,
      "password"      => PASSSERVER,
      "start"         => $this->session->userdata("tour_start"),
      "end"           => $this->session->userdata("tour_end"),
      "region"        => $this->session->userdata("tour_region"),
      "store"         => $this->session->userdata("tour_store"),
      "id_store"      => $this->session->userdata("tour_store_real"),
      "code"          => $this->session->userdata("tour_code"),
      "status"        => $this->session->userdata("tour_status"),
      "book_start"    => $this->session->userdata("tour_book_start"),
      "book_end"      => $this->session->userdata("tour_book_end"),
      "book_status2"  => $this->session->userdata("tour_book_status2"),
    );
//    $this->debug($post, true);
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-report-status-tour");
    $data_array = json_decode($data);
//    $this->debug($data);
//    $this->debug($data_array, true);
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-tour/get-all-store-region");
    $store = json_decode($data_store);
    
    $post_store_real = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store_real = $this->curl_mentah($post_store_real, URLSERVER."json/json-midlle-system/get-all-store");
    $store_real = json_decode($data_store_real);
    
//    $this->debug($data, true);
//    $this->debug($data_array, true);
//    $this->debug($store, true);
    
    $status = array(
      NULL => "<span class='label label-info'>Active</span>",
      1 => "<span class='label label-info'>Active</span>",
      3 => "<span class='label label-warning'>Cancel</span>",
      4 => "<span class='label label-success'>Close</span>",
    );
    $region = array(
      1 => "Eropa",
      2 => "Middle East Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand",
    );
    
    $total = $data_store = array();
    $total['all'] = 1;
    foreach ($data_array->data AS $key => $dt){
      $pax = 0;
      $pax = $dt->adult_triple_twin + $dt->child_twin_bed + $dt->child_extra_bed + $dt->child_no_bed + $dt->sgl_supp;
      $cetak .= "<tr>"
//        . "<td>".$total['all']++."</td>"
        . "<td><a href='".site_url("tour/list-tour-book/{$dt->kode}")."'>".date("d M y", strtotime($dt->start_date))."</a></td>"
        . "<td>".date("d M y", strtotime($dt->end_date))."</td>"
        . "<td><a class='pilih-code' isi='{$dt->kode}' data-toggle='modal'>{$dt->tour_name}</a></td>"
        . "<td>{$region[$dt->region]}</td>"
        . "<td>{$dt->store_region}</td>"
        . "<td>{$status[$dt->status]}</td>"
        . "<td style='text-align: right'>{$dt->available_seat}</td>"
        . "<td style='text-align: right'>{$dt->book}</td>"
        . "<td style='text-align: right'>{$dt->dp}</td>"
        . "<td style='text-align: right'>{$dt->lunas}</td>"
        . "<td style='text-align: right'>".number_format($data_array->payment[$key]->debit)."</td>"
        . "<td style='text-align: right'>".number_format($data_array->payment[$key]->kredit)."</td>"
        . "<td style='text-align: right'>".number_format(($data_array->payment[$key]->debit-$data_array->payment[$key]->kredit))."</td>"
      . "</tr>";
      $total[$dt->id_store_region]['as']        += $dt->available_seat;
      $total[$dt->id_store_region]['bs']        += $dt->book;
      $total[$dt->id_store_region]['ds']        += $dt->dp;
      $total[$dt->id_store_region]['ls']        += $dt->lunas;
      $total[$dt->id_store_region]['penjualan'] += $data_array->payment[$key]->debit;
      $total[$dt->id_store_region]['deposit']   += $data_array->payment[$key]->kredit;
      $total['open']                            += $dt->available_seat;
      $total['book']                            += $dt->book;
      $total['deposit']                         += $dt->dp;
      $total['lunas']                           += $dt->lunas;
      $total['penjualan']                       += $data_array->payment[$key]->debit;
      $total['payment']                         += $data_array->payment[$key]->kredit;
      $total['all']++;
    }
//    $this->debug($total, true);
    $labels = $data_pax = "";
    $store_dd[NULL] = '- Pilih -';
    $store_dd_real[NULL] = '- Pilih -';
    foreach ($store_real->data AS $sd){
      $store_dd_real[$sd->id_store] = $sd->title;
    }
    foreach ($store->data AS $sd){
      $store_dd[$sd->id_store_region] = $sd->title;
      $labels .= "'{$sd->title}',";
      if($total[$sd->id_store_region]['penjualan'])
        $data_penjualan .= round(($total[$sd->id_store_region]['penjualan']/1000000), 2).",";
      else
        $data_penjualan .= "0,";
      if($total[$sd->id_store_region]['deposit'])
        $data_deposit .= round(($total[$sd->id_store_region]['deposit']/1000000), 2).",";
      else
        $data_deposit .= "0,";
      
      if($total[$sd->id_store_region]['ds'])
        $data_ds .= "{$total[$sd->id_store_region]['ds']},";
      else
        $data_ds .= "0,";
      if($total[$sd->id_store_region]['ls'])
        $data_ls .= "{$total[$sd->id_store_region]['ls']},";
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
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/scripts/shBrushJScript.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/examples/syntaxhighlighter/scripts/shBrushXml.min.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.barRenderer.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.pieRenderer.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.pointLabels.min.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasAxisLabelRenderer.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasAxisTickRenderer.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.logAxisRenderer.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.canvasTextRenderer.js' type='text/javascript'></script>"
      
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.dateAxisRenderer.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.js' type='text/javascript'></script>"
      ;
	  
    $foot .= "<script>"
      . "$(document).on('click', '.pilih-code', function(evt){"
        . "var kode = $(this).attr('isi');"
        . "window.open('".site_url("store/report-store/chart-kontribusi")."/'+kode,"
          . "'_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
      
//      . "$('input').on('ifChanged', function(e){"
//        . "$('#tour-book-status2').hide();"
//        . "$('#tour-book-status4').val(1);"
//        . "$('input').on('ifChecked', function(event){"
//          . "$('#tour-book-status2').show();"
//        . "});"
//      . "});"
      
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
        var s1 = [{$data_ls}];
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
     
    $this->template->build('report/tour-close', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/tour-close",
        'data'          => $data_array->data,
        'title'         => lang("Report Group Status"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd,
        'store_dd_real' => $store_dd_real,
      ));
    $this->template
      ->set_layout('default')
      ->build('report/tour-close');
  }
  
  function chart_kontribusi($kode){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $kode,
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-book-schedule");
    $data_array = json_decode($data);
    
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store = json_decode($data_store);
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-1.10.3.min.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/chart/chart.js' type='text/javascript'></script>"
      . "";
    foreach ($data_array->data AS $dt){
      if($dt->status == 1){
        $milik_store[$dt->id_store1]['bs'] += $dt->pax;
        if($dt->id_store2)
          $milik_store[$dt->id_store2]['bs'] += $dt->pax;
      }
      elseif($dt->status == 2){
        $milik_store[$dt->id_store1]['ds'] += $dt->pax;
        if($dt->id_store2)
          $milik_store[$dt->id_store2]['ds'] += $dt->pax;
      }
      elseif($dt->status == 3){
        $milik_store[$dt->id_store1]['ls'] += $dt->pax;
        if($dt->id_store2)
          $milik_store[$dt->id_store2]['ls'] += $dt->pax;
      }
      else{
        $milik_store[$dt->id_store1]['cs'] += $dt->pax;
        if($dt->id_store2)
          $milik_store[$dt->id_store2]['cs'] += $dt->pax;
      }
    }
    foreach ($store->data AS $key => $da){
      $labels .= "'{$da->title}',";
      if($milik_store[$da->id_store]['bs'])
        $data_bar_bs .= "{$milik_store[$da->id_store]['bs']},";
      else
        $data_bar_bs .= "0,";
      if($milik_store[$da->id_store]['ds'])
        $data_bar_ds .= "{$milik_store[$da->id_store]['ds']},";
      else
        $data_bar_ds .= "0,";
      if($milik_store[$da->id_store]['ls'])
        $data_bar_ls .= "{$milik_store[$da->id_store]['ls']},";
      else
        $data_bar_ls .= "0,";
      if($milik_store[$da->id_store]['cs'])
        $data_bar_cs .= "{$milik_store[$da->id_store]['cs']},";
      else
        $data_bar_cs .= "0,";
    }
//    $this->debug($data_array);
//    $this->debug($labels);
//    $this->debug($data_bar_bs);
//    $this->debug($data_bar_ds);
//    $this->debug($data_bar_ls);
//    $this->debug($data_bar_cs, true);
    $foot .= "<script>"
      . "var barChartData = {"
        . "labels : [{$labels}],"
        . "datasets : ["
          . "{"
            . "fillColor : 'rgba(0,128,255,0.5)',"
            . "strokeColor : 'rgba(220,220,220,0.8)',"
            . "highlightFill: 'rgba(0,128,255,0.75)',"
            . "highlightStroke: 'rgba(220,220,220,1)',"
            . "data : [{$data_bar_bs}]"
          . "},"
          . "{"
            . "fillColor : 'rgba(76,153,0,0.5)',"
            . "strokeColor : 'rgba(220,220,220,0.8)',"
            . "highlightFill: 'rgba(76,153,0,0.75)',"
            . "highlightStroke: 'rgba(220,220,220,1)',"
            . "data : [{$data_bar_ds}]"
          . "},"
          . "{"
            . "fillColor : 'rgba(255,153,204,0.5)',"
            . "strokeColor : 'rgba(220,220,220,0.8)',"
            . "highlightFill: 'rgba(255,153,204,0.75)',"
            . "highlightStroke: 'rgba(220,220,220,1)',"
            . "data : [{$data_bar_ls}]"
          . "},"
          . "{"
            . "fillColor : 'rgba(153,0,153,0.5)',"
            . "strokeColor : 'rgba(220,220,220,0.8)',"
            . "highlightFill: 'rgba(153,0,153,0.75)',"
            . "highlightStroke: 'rgba(220,220,220,1)',"
            . "data : [{$data_bar_cs}]"
          . "},"
        . "]"
      . "};"
      
      . "window.onload = function(){"
        . "var ctx = document.getElementById('kontribusi').getContext('2d');"
        . "window.myBar = new Chart(ctx).Bar(barChartData, {"
          . "responsive : true"
        . "});"    
      . "}"
      . "</script>";
    print ""
    . "<div>"
      . "<h3>Chart Kontribusi Penjualan {$kode}</h3>"
      . "<canvas id='kontribusi'></canvas>"
    . "</div>";
    print $foot;
    die;
  }
  
  function penjualan_tc(){
    
    $pst = $this->input->post();
    
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "id_users"    => $this->session->userdata("id"),
    );
    $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store = json_decode($data_store);
    
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      $this->session->set_userdata($pst);
    }
    else{
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      if(!$this->session->userdata("tour_store"))
        $pst['tour_store'] = $store->data[0]->id_store;
      $this->session->set_userdata($pst);
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $this->session->userdata("tour_start"),
      "end"         => $this->session->userdata("tour_end"),
      "region"      => $this->session->userdata("tour_region"),
      "id_store"    => $this->session->userdata("tour_store"),
      "code"        => $this->session->userdata("tour_code"),
      "status"      => $this->session->userdata("tour_status"),
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-penjualan-tc");
    $data_array = json_decode($data);
    
    $post_users = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "id_store"    => $this->session->userdata("tour_store"),
    );
    $data_users = $this->curl_mentah($post_users, URLSERVER."json/json-midlle-system/get-users-store");
    $data_users_array = json_decode($data_users);
    
//    $this->debug($data_users, true);
//    $this->debug($data_users_array, true);
//    $this->debug($store, true);
    
    $status = array(
      1 => "<span class='label label-warning'>Book</span>",
      2 => "<span class='label label-info'>Deposit</span>",
      3 => "<span class='label label-success'>Lunas</span>",
      4 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-warning'>Request Cancel</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      7 => "<span class='label label-warning'>Change</span>",
      8 => "<span class='label label-danger'>Cancel</span>",
      9 => "<span class='label label-danger'>Cancel</span>",
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
        . "<td>{$dt->users}</td>"
        . "<td>{$status[$dt->status]}</td>"
        . "<td style='text-align: right'>{$pax}</td>"
        . "<td style='text-align: right'>".number_format($dt->debit)."</td>"
        . "<td style='text-align: right'>".number_format($dt->kredit)."</td>"
        . "<td style='text-align: right'>".number_format(($dt->debit-$dt->kredit))."</td>"
      . "</tr>";
      $total['pax']               += $pax;
      $total['penjualan']         += $dt->debit;
      $total['deposit']           += $dt->kredit;
      
      $data_store[$dt->id_users]['pax']        += $pax;
      $data_store[$dt->id_users]['penjualan']  += round(($dt->debit/1000000),2);
      $data_store[$dt->id_users]['deposit']    += round(($dt->kredit/1000000),2);
      
    }
    foreach ($store->data AS $sd){
      $store_dd[$sd->id_store] = $sd->title;
    }
    $labels = $data_pax = "";
    foreach ($data_users_array->data AS $sd){
      $labels .= "'{$sd->isi->name}',";
      if($data_store[$sd->isi->id_users]['penjualan'])
        $data_penjualan .= "{$data_store[$sd->isi->id_users]['penjualan']},";
      else
        $data_penjualan .= "0,";
      if($data_store[$sd->isi->id_users]['deposit'])
        $data_deposit .= "{$data_store[$sd->isi->id_users]['deposit']},";
      else
        $data_deposit .= "0,";
      if($data_store[$sd->isi->id_users]['pax'])
        $data_pax .= "{$data_store[$sd->isi->id_users]['pax']},";
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
     
    $this->template->build('report/penjualan-tc', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/penjualan-tc",
        'data'          => $data_array->data,
        'title'         => lang("Report Penjualan TC"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd
      ));
    $this->template
      ->set_layout('default')
      ->build('report/penjualan-tc');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */