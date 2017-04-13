<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_management extends MX_Controller {
    
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
  
  function request(){
    
    $pst = $this->input->post();
    if($pst){
      if(!$pst['tour_start'])
        $pst['tour_start'] = date("Y-m-")."01";
      if(!$pst['tour_end'])
        $pst['tour_end'] = date("Y-m-t");
      
      $this->session->set_userdata($pst);
    }
    
    if(!$this->session->userdata("tour_start")){
      $this->session->set_userdata(array(
        "tour_start"        => date("Y-m-01"),
        "tour_end"          => date("Y-m-t"),
      ));
    }
    
    $post_store = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
    );
    $store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($store);
    
//    $this->debug($labels);
    foreach($store_array->data AS $store_data){
      $store_detail[$store_data->id_store] = array(
        "pax"       => 0,
        "debit"     => 0,
        "kredit"    => 0,
        "title"     => $store_data->title,
      );
    }
//    $this->debug($store_detail, true);
    
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
    
	$foot .= "<script class='code' type='text/javascript'>"
    . "$.jqplot.config.enablePlugins = true;"
    . "var s1 = [2, 6, 7, 10];"
    . "var s2 = [2, 6, 7, 10];"
    . "var ticks = ['aas', 'bas', 'csas', 'dsa'];"
//    . "olah_chart_pax(s1,ticks);"
    . "function olah_chart(r1,r2,ticks){"
      . "plot1 = $.jqplot('canvas', [r1, r2], {"
          . "animate: !$.jqplot.use_excanvas, seriesDefaults:{ renderer:$.jqplot.BarRenderer, pointLabels: {"
            . "show: true"
          . "}"
        . "},"
        . "axes: {"
          . "xaxis: {"
            . "renderer: $.jqplot.CategoryAxisRenderer,"
            . "ticks: ticks,"
            . "label: 'Store',"
            . "labelRenderer: $.jqplot.CanvasAxisLabelRenderer,"
            . "tickRenderer: $.jqplot.CanvasAxisTickRenderer,"
            . "tickOptions: { angle: -70 },"
            . "tickRenderer:$.jqplot.CanvasAxisTickRenderer,"
            . "label:'STORE',"
            . "labelOptions:{"
              . "fontFamily:'Times New Roman',"
              . "fontSize: '12pt'"
            . "},"
          . "}"
        . "},"
        . "highlighter: {"
          . "show: false"
        . "}"
      . "}).replot();"
    . "}"
//    . "$('#chart1').bind('jqplotDataClick', function (ev, seriesIndex, pointIndex, data) {"
//      . "$('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);"
//    . "});"
    
    . "function olah_chart_pax(r1,ticks){"
      . "plot1 = $.jqplot('canvas-pax', [r1], {"
          . "animate: !$.jqplot.use_excanvas, seriesDefaults:{ renderer:$.jqplot.BarRenderer, pointLabels: {"
            . "show: true"
          . "}"
        . "},"
        . "axes: {"
          . "xaxis: {"
            . "renderer: $.jqplot.CategoryAxisRenderer,"
            . "ticks: ticks,"
            . "label: 'Store',"
            . "labelRenderer: $.jqplot.CanvasAxisLabelRenderer,"
            . "tickRenderer: $.jqplot.CanvasAxisTickRenderer,"
            . "tickOptions: { angle: -70 },"
            . "tickRenderer:$.jqplot.CanvasAxisTickRenderer,"
            . "label:'PAX',"
            . "labelOptions:{"
              . "fontFamily:'Times New Roman',"
              . "fontSize: '12pt'"
            . "},"
          . "}"
        . "},"
        . "highlighter: {"
          . "show: false"
        . "}"
      . "}).replot();"
    . "}"
    
    . "function pengolahan_chart(string_json){"
      . "var data_chart = $.parseJSON(string_json);"
      . "var s1 = new Array();"
      . "var s2 = new Array();"
      . "var s3 = new Array();"
      . "var ticks = new Array();"
      . "var ft = 0;"
      . "$.each(data_chart, function(index, value){"
//    . "alert(index);"
        . "s1[ft] = value.debit/1000000;"
        . "s2[ft] = value.kredit/1000000;"
        . "s3[ft] = value.pax;"
        . "ticks[ft] = value.title;"
        . "ft = ft + 1;"
      . "});"
//    . "console.log(ticks);"
      . "olah_chart(s1,s2,ticks);"
      . "olah_chart_pax(s3,ticks);"
    . "}"
    . "</script>";
        
        $foot .= "<script>"
      . "$(function() {"
        . 'var table = '
        . '$("#tableboxy").dataTable({'
          . '"order": [[ 0, "desc" ]],'
        . '});'
          
        . "var store_json = '".json_encode($store_detail)."';"
        . 'ambil_data(table, 0, store_json);'
          
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
      . "});"
      . 'function ambil_data(table, mulai, sj){'
        . '$.post("'.site_url("tour/tour-fit-ajax/get-chart-tour-fit-request").'/"+mulai, {sj: sj}, function(data){'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.fnAddData(hasil.hasil);'
            . 'ambil_data(table, hasil.start, hasil.sj);'
            . 'var jml_pax = ($("#jml-pax").text() * 1) + (hasil.pax * 1);'
            . '$("#jml-pax").html(jml_pax);'
          
            . 'var jml_debit = ($("#jml-debit").text() * 1) + (hasil.debit * 1);'
            . '$("#jml-debit").html(jml_debit);'
          
            . 'var jml_kredit = ($("#jml-kredit").text() * 1) + (hasil.kredit * 1);'
            . '$("#jml-kredit").html(jml_kredit);'
          
            . 'var jml_balance = ($("#jml-balance").text() * 1) + (hasil.balance * 1);'
            . '$("#jml-balance").html(jml_balance);'
          . '}'
          . 'else{'
            . 'var jml_debit = $("#jml-debit").text() * 1;'
            . '$("#jml-debit").html(number_format(jml_debit));'
          
            . 'var jml_kredit = $("#jml-kredit").text() * 1;'
            . '$("#jml-kredit").html(number_format(jml_kredit));'
          
            . 'var jml_balance = $("#jml-balance").text() * 1;'
            . '$("#jml-balance").html(number_format(jml_balance));'
          
            . "pengolahan_chart(hasil.sj);"
          
          . '}'
        . '});'
      . '}'
          
      . "function number_format(number, decimals, dec_point, thousands_sep) {"
        . "number = (number + '').replace(/[^0-9+\-Ee.]/g, '');"
        . "var n = !isFinite(+number) ? 0 : +number,"
          . "prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),"
          . "sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,"
          . "dec = (typeof dec_point === 'undefined') ? '.' : dec_point,"
          . "s = '',"
          . "toFixedFix = function(n, prec) {"
            . "var k = Math.pow(10, prec);"
            . "return '' + (Math.round(n * k) / k).toFixed(prec);"
          . "}"
        . ";"
//        . "// Fix for IE parseFloat(0.55).toFixed(0) = 0;"
        . "s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');"
        . "if (s[0].length > 3) {"
          . "s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);"
        . "}"
        . "if ((s[1] || '').length < prec) {"
          . "s[1] = s[1] || '';"
          . "s[1] += new Array(prec - s[1].length + 1).join('0');"
        . "}"
        . "return s.join(dec);" 
      . "}"
          
      . "</script>";
     
    $this->template->build('tour-management/request', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "tour/tour-management/request",
        'data'          => $data_array->data,
        'title'         => lang("Request FIT"),
        'foot'          => $foot,
        'css'           => $css,
        'cetak'         => $cetak,
        'total'         => $total,
        'store_dd'      => $store_dd
      ));
    $this->template
      ->set_layout('default')
      ->build('tour-management/request');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */