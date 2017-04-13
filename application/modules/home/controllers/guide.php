<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Guide extends MX_Controller {
    
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
        . "var table = "
        . "$('#tableboxy').DataTable({"
          . "'order': [[ 0, 'desc' ]]"
        . "});"
      
        . 'function ambil_data(table, start){'
          . 'ajax_inventory = $.post("'.site_url("pameran/pameran-ajax/transaksi-pameran-get").'", {start: start, id_tour_pameran: "'.$id_tour_pameran.'"}, function(data){'
            . 'var hasil = $.parseJSON(data);'
            . '$("#loader-page").show();'
            . 'if(hasil.status == 2){'
              . 'if(hasil.hasil){'
                . 'for(ind = 0; ind < hasil.hasil.length; ++ind){'
                  . "var rowNode = table.row.add(hasil.hasil[ind]).draw().node();"
                  . "$( rowNode ).attr('isi',hasil.banding[ind]);"
                  . "var tt = str_replace(',','',$('#total').text()) * 1;"
                  . "var jm = tt + (hasil.nominal[ind]*1);"
                  . "$('#total').html(number_format(jm));"
                . '}'
              . '}'
              . 'ambil_data(table, hasil.start);'
            . '}'
            . 'else{'
              . '$("#loader-page").hide();'
            . '}'
          . '});'
        . '}'
      
        . 'ambil_data(table, 0);'
      
      . "});"
      
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
      
      . "</script>";
         
    $this->template->build('master', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "home/guide/master",
        'title'         => lang("MAster"),
        'foot'          => $foot,
        'css'           => $css,
      ));
    $this->template
      ->set_layout('default')
      ->build('master');
  }
  
  function master_add($id_guide_master){
    $pst = $this->input->post();
    if($pst){
      $post = array(
        "id_privilege"        => $pst['id_privilege'],
        "tanggal"             => date("Y-m-d H:i:s"),
        "title"               => $pst['title'],
        "note"                => $pst['note'],
        "create_by_users"     => $this->session->userdata(),
        "create_date"         => date("Y-m-d H:i:s"),
      );
      
      $data = $this->global_models->insert("guide_master", $post);
      
      if($data)
        $this->session->set_flashdata('success', 'Data tersimpan');
      else
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      
      redirect("home/guide/master");
    }
    
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
    . "";
    
    $foot = ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>"
      . "";
    $foot .= "<script>"

      . "$(function() {"
        . "CKEDITOR.replace('editor2');"
        . "$( '.tanggal' ).datepicker({"
          . "showOtherMonths: true,"
          . "format: 'yyyy-mm-dd',"
          . "selectOtherMonths: true,"
          . "selectOtherYears: true"
        . "});"
        . "$('.harga').priceFormat({"
          . "prefix: '',"
          . "centsLimit: 0"
        . "});"
      . "});"

    . "</script>";
    
    $this->template->build('master-add', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "home/guide/master",
        'title'         => lang("Guide"),
        'foot'          => $foot,
        'css'           => $css,
        'id_tour_pameran' => $id_tour_pameran,
      ));
    $this->template
      ->set_layout('default')
      ->build('master-add');
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */