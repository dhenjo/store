<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subagent extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function tour_list($id_master_sub_agent){
    
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
      "id_master_sub_agent" => $id_master_sub_agent,
      "start"         => $this->session->userdata("tour_start"),
      "end"           => $this->session->userdata("tour_end"),
      "region"        => $this->session->userdata("tour_region"),
      "store"         => $this->session->userdata("tour_store"),
      "code"          => $this->session->userdata("tour_code"),
      "status"        => $this->session->userdata("tour_status"),
      "book_start"    => $this->session->userdata("tour_book_start"),
      "book_end"      => $this->session->userdata("tour_book_end"),
      "book_status2"  => $this->session->userdata("tour_book_status2"),
    );
//    $this->debug($post, true);
    $data = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour/get-report-status-tour");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    $post_store = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
    );
    $data_store = $this->antavaya_lib->curl_mentah($post_store, URLSERVER."json/json-tour/get-all-store-region");
    $store = json_decode($data_store);
    
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
     
    $this->template->build('tour-list', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "store/report-store/penjualan-tour",
        'data'          => $data_array->data,
        'title'         => lang("Report Group Status"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd
      ));
    $this->template
      ->set_layout('default')
      ->build('tour-list');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */