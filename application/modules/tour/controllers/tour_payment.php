<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_payment extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function ttu($id){
    $pst = $this->input->post();
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $id,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-get-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail_array, true);
    if($detail_array->data->payment[0]->id_ttu){
      $post["id"] = $detail_array->data->payment[0]->id_ttu;
      $det = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/inventory-get-detail");
      $det_array = json_decode($det);
      
      $inv = explode("|", $det_array->data->inventory[0]->inventory);
      
      $detail_array->status = $det_array->status;
      $detail_array->note= $det_array->note;
      $detail_array->data->payment[0]->nominal                      = $det_array->data->inventory[0]->nominal;
      $detail_array->data->payment[0]->id_ttu                       = $det_array->data->inventory[0]->id_ttu;
      $detail_array->data->payment[0]->id_product_tour_book_payment = $det_array->data->ttu[0]->ttu->id_product_tour_book_payment;
      $detail_array->data->payment[0]->no_ttu                       = $det_array->data->ttu[0]->ttu->no_ttu;
      $detail_array->data->payment[0]->remark                       = $det_array->data->inventory[0]->remark;
      $detail_array->data->payment[0]->type                         = $det_array->data->inventory[0]->type;
      $detail_array->data->payment[0]->book                         = "{$inv[0]}|{$inv[2]}|{$inv[3]}|{$inv[5]}|{$inv[4]}|{$inv[1]}|".date("Y-m-d", strtotime($det_array->data->inventory[0]->tanggal));
      
//      $detail_array->data->all[0]->nominal    = $det_array->data->inventory[0]->nominal;
//      $detail_array->data->all[0]->pos        = 1;
      
//      $this->debug($det_array);
//      $this->debug($detail_array, true);
    }
//    $this->debug($detail_array, true);
    $book = $detail_array->data->payment[0]->book;
    $bk = explode("|", $book);
    
    if($pst){
//      $this->debug($pst, true);
      if($pst['void']){
        $post_void = array(
          "users"           => USERSSERVER,
          "password"        => PASSSERVER,
          "id_users"        => $this->session->userdata("id"),
          "id_tour_payment" => $pst['void'],
          "id"              => $id,  
          "note"            => $pst['note_void'][$pst['void']],
        );
//        print_r($post_void);
//        die;
        $void = $this->global_variable->curl_mentah($post_void, URLSERVER."json/json-tour/tour-payment-void");
        $void_array = json_decode($void);
//         $this->debug($void, true);
//         die;
        if($void_array->status == 2){
          $this->session->set_flashdata('success', 'Success');
        }elseif($void_array->status == 5){
            $this->session->set_flashdata('notice', 'Note Harus di isi');
        }else{
            $this->session->set_flashdata('notice', 'Fail');
        }
          
        redirect("tour/tour-payment/ttu/{$id}");
      }
      else{
        $post = array(
          "users"       => USERSSERVER,
          "password"    => PASSSERVER,
          "id_create"   => $this->session->userdata("id"),
          "status"      => 0,
          "id"          => $id,
          "tanggal"     => date("Y-m-d H:i:s"),
          "type"        => json_encode($pst['type']),
          "nominal"     => json_encode($pst['nominal']),
          "mdr"         => json_encode($pst['mdr']),
          "number"      => json_encode($pst['number']),
          "tanggal"     => json_encode($pst['tanggal']),
          "remark"      => json_encode($pst['remark']),
        );
        $lolos = FALSE;
        if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "tour-payment-confirm", "edit") !== FALSE){
          $lolos = TRUE;
          $post['id_confirm']   = $this->session->userdata("id");
          $post['status']       = 2;
        }
        $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-set");  
        $data_array = json_decode($data);
//        $this->debug($data, true);
        if($data_array->status == 2)
          $this->session->set_flashdata('success', 'Success');
        else
          $this->session->set_flashdata('notice', 'Fail');
        if($lolos === FALSE)
          redirect("grouptour/product-tour/book-information/{$bk[0]}");
        else
          redirect("tour/tour-payment/kasir");
      }
    }
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "";
    
    $hari_ini = date("Y-m-d");
    
    $ft = <<<EOD
      <hr /> <div class="row"> <div class="col-xs-4"> <label>Type</label> <select class="form-control input-sm select2" name="type[]"> <optgroup label="Tunai"> <option value="1">Tunai</option> </optgroup> <optgroup label="Transfer"> <option value="3">Transfer Mega</option> <option value="2">Transfer BCA</option> <option value="4">Transfer Mandiri</option> </optgroup> <optgroup label="Debit"> <option value="7">Debit BCA</option> <option value="14">Debit Mandiri</option> <option value="15">Debit BNI</option> </optgroup> <optgroup label="Kartu Kredit"> <option value="9">Kartu Kredit BCA</option> <option value="5">Kartu Kredit Mega</option> <option value="11">Kartu Kredit BNI</option> <option value="12">Kartu Kredit Mandiri</option> <option value="13">Kartu Kredit Citibank</option> <option value="10">Kartu Kredit Lainnya</option> </optgroup> <optgroup label="Others"> <option value="16">Travel Certificate</option> <option value="17">Travel Voucher</option> <option value="18">Voucher CT Corp</option> <option value="19">Point Rewards</option> <option value="20">Kupon</option> </optgroup> </select> </div> <div class="col-xs-4"> <label>Nominal</label> <input type="text" name="nominal[]" class="form-control input-sm harga" placeholder="Nominal"> </div> <div class="col-xs-2"> <label>MDR</label> <input type="text" name="mdr[]" class="form-control input-sm harga" placeholder="MDR"> </div> <div class="col-xs-2"> <label>Status</label>&nbsp; </div> </div> <div class="row"> <div class="col-xs-4"> <label>Card Number</label> <input type="text" name="number[]" class="form-control input-sm" placeholder="Card Number"> </div> <div class="col-xs-4"> <label>Tanggal</label> <input type="text" name="tanggal[]" value="{$hari_ini}" class="form-control input-sm tanggal" placeholder="Tanggal"> </div> <div class="col-xs-4"> <label>Remarks</label> <textarea name="remark[]" class="form-control input-sm" placeholder="Remarks"></textarea> </div> </div>
EOD;

    $foot = ""
      . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>"
      . ""
      . "<script>"
        . "function ref(){"
          . "$('.select2').select2();"
          . "$('.harga').priceFormat({"
            . "prefix: '',"
            . "centsLimit: 0"
          . "});"
          . "$( '.tanggal' ).datepicker({"
            . "showOtherMonths: true,"
            . "format: 'yyyy-mm-dd',"
            . "selectOtherMonths: true,"
            . "selectOtherYears: true"
          . "});"
        . "}"
        . "$(document).on('click', '#add-type', function(evt){"
            . "var data = '{$ft}';"
//          . "$.post('".site_url("tour/tour-payment-ajax/type-payment-add-row")."', function(data){"
            . "$('#isi').append(data);"
            . "ref();"
//          . "});"
        . "});"
        . "ref();"
        . "function pameran(id_pameran){"
           . "$.post('".site_url("tour/tour-payment-ajax/change-pameran")."', {id_pameran: id_pameran, id: '{$id}'}, function(data){"
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
                   . "window.location = '".site_url("tour/tour-payment/ttu/{$id}")."'"
          . '}'
        . '});'
        . "}"
      . "</script>";
    
    $tanggungan = 0;
    foreach($detail_array->data->all AS $all){
      $tanggungan = ($all->pos == 2 ? ($tanggungan - $all->nominal) : ($tanggungan + $all->nominal));
      $debit_temp += $all->nominal;
    }
    
    $post_agent = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "status"            => 1
      );

      $pameran = $this->global_variable->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
      
       $pameran_array = json_decode($pameran);
      $pameran_drop[NULL] = '- Pilih -';
  //    $this->debug($pameran, true);
      foreach($pameran_array->data AS $pp){
        $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d", strtotime($pp->date_start))."-".date("d M y", strtotime($pp->date_end));
      }
//    $this->debug($detail_array->data->all);
//    $this->debug($debit_temp);
//    $this->debug($detail_array->data->payment_list, true);
    $this->template->build('tour-payment/ttu', 
      array(
        'url'           => base_url()."themes/".DEFAULTTHEMES."/",
        'menu'          => "payment/inventory",
        'title'         => lang("Payment TTU"),
        'foot'          => $foot,
        'css'           => $css,
        'id'            => $id,
        'payment'       => $detail_array->data->payment,
        'payment_list'  => $detail_array->data->payment_list,
        'tanggungan'    => $tanggungan,
        'bk'            => $bk,
        'pameran'     	=> $pameran_drop,
        'ttu'           => $detail_array->data->ttu,
      ));
    $this->template
      ->set_layout('default')
      ->build('tour-payment/ttu');
  }
  
  function cek_kasir(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js'></script>"
      . '<script type="text/javascript">'
      
      . 'var table = '
      . '$("#tableboxy").DataTable({'
        . '"order": [[ 0, "desc" ]]'
      . '});'
      . 'ambil_data(table, 0);'
      
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/tour-payment-ajax/tour-payment-get").'", {start: mulai}, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.rows.add(hasil.hasil).draw();'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
          . '}'
        . '});'
      . '}'
      
      . "$(document).on('click', '.tour-payment-delete', function(evt){"
        . "var isi = $(this).attr('isi');"
        . "$('#id-tour-payment').val(isi)"
      . "});"
      
    . '</script>';
    
    $this->template->build('tour-payment/cek-kasir', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-payment/kasir",
          'data'          => $data_array->book,
          'title'         => lang("Manage Finance"),
          'foot'          => $foot,
          'css'           => $css,
        ));
    $this->template
      ->set_layout("default")
      ->build('tour-payment/cek-kasir');
  }
  
  function kasir(){
    $pst = $this->input->post();
//    if($pst){
//      $this->debug($pst, true);
//    }
    
    $post['awal']  = ($pst['awal'] ? $pst['awal'] : date("Y-m-d", strtotime("-7 days")));
    $post['akhir'] = ($pst['akhir'] ? $pst['akhir'] : date("Y-m-d"));
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
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
    
    $foot .= ""
      . '<script type="text/javascript">'
      
      . 'var table = '
      . '$("#tableboxy").DataTable({'
        . '"order": [[ 0, "desc" ]]'
      . '});'
      . 'ambil_data(table, 0);'
      
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/tour-payment-ajax/product-tour-book-payment-get").'", {start: mulai, mulai: "'.$post['awal'].'", akhir: "'.$post['akhir'].'"}, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.rows.add(hasil.hasil).draw();'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
          . '}'
        . '});'
      . '}'
      
    . '</script>';
    
    $this->template->build('tour-payment/kasir', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-payment/kasir",
          'data'          => $data_array->book,
          'title'         => lang("TTU"),
          'foot'          => $foot,
          'css'           => $css,
          'post'          => $post,
        ));
    $this->template
      ->set_layout("default")
      ->build('tour-payment/kasir');
  }
  
  function payment_ttu(){
    $css = ""
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".selected{"
          . "background-color: aquamarine !important;"
        . "}"
      . "</style>";
    
    $foot .= ""
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js'></script>"
      . '<script type="text/javascript">'
      
      . 'var table = '
      . '$("#tableboxy").DataTable({'
        . '"order": [[ 0, "desc" ]]'
      . '});'
      . 'ambil_data(table, 0);'
      
      . 'function ambil_data(table, mulai){'
        . '$.post("'.site_url("tour/tour-payment-ajax/product-tour-book-payment-get").'", {start: mulai}, function(data){'
          . '$("#loader-page").show();'
          . 'var hasil = $.parseJSON(data);'
          . 'if(hasil.status == 2){'
            . 'table.rows.add(hasil.hasil).draw();'
            . 'ambil_data(table, hasil.start);'
          . '}'
          . 'else{'
            . '$("#loader-page").hide();'
          . '}'
        . '});'
      . '}'
      
    . '</script>';
    
    $this->template->build('tour-payment/kasir', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "tour/tour-payment/kasir",
          'data'          => $data_array->book,
          'title'         => lang("TTU"),
          'foot'          => $foot,
          'css'           => $css,
        ));
    $this->template
      ->set_layout("default")
      ->build('tour-payment/kasir');
  }
  
  function payment_confirm($id){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $id,
      "status"          => 2,
      "id_users"        => $this->session->userdata("id"),
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-status");
    $detail_array = json_decode($detail);
    if($data_array->status == 2)
      $this->session->set_flashdata('success', 'Success');
    else
      $this->session->set_flashdata('notice', 'Fail');
    
    redirect("tour/tour-payment/cek-kasir");
  }
  
  function tour_payment_cancel(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $note = trim($pst['note_cancel']);
    if($note){
      $post = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "id"              => $pst['id'],
        "note"            => $pst['note_cancel'],
        "id_users"        => $this->session->userdata("id"),
      );

      $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-cancel");
      $detail_array = json_decode($detail);
//      $this->debug($detail, true);
      if($detail_array->status == 2)
        $this->session->set_flashdata('success', 'Success');
      else
        $this->session->set_flashdata('notice', 'Fail');
      
      redirect("tour/tour-payment/cek-kasir");
    }else{
        $this->session->set_flashdata('notice', 'Note harus di isi');
        redirect("tour/tour-payment/cek-kasir");
    }
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */