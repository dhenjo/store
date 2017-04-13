<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grouptour extends MX_Controller {
    
  function __construct() {      
    
  }
  
  function ajax_book_group(){
    $pst = $this->input->post();
    if($pst['email'] AND $pst['id_website_group_tour']){
      $grouptour = $this->global_models->get("website_group_tour", array("id_website_group_tour" => $pst['id_website_group_tour']));
      $kirim = array(
        "id_website_group_tour"     => $pst['id_website_group_tour'],
        "name"                      => $pst['name'],
        "email"                     => $pst['email'],
        "telp"                      => $pst['telp'],
        "status"                    => 1,
        "note"                      => $pst['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $id_website_group_tour_book = $this->global_models->insert("website_group_tour_book", $kirim);

      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('tour@antavaya.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Group Tour {$grouptour[0]->title} ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Mohon informasi lebih detail untuk product group tour <a href='".site_url("grouptour/detail/{$grouptour[0]->nicename}")."'>{$grouptour[0]->title}</a>.<br />"
        . "Kepada <br />"
        . "Nama : {$pst['name']}<br />"
        . "Email : {$pst['email']}<br />"
        . "Telp : {$pst['telp']}<br />"
        . "Desc <br />"
        . "{$pst['note']} <br />"
        . "Terima Kasih"
        . "");  
  //die;
      $this->email->send();
      print 'ok';
    }
    else{
      print 'ko';
    }
    die;
  }

  public function index($session = 0, $tujuan = 0){
    
    if($session == 1){
      $category = 1;
      $db_category = "category =1 AND ";
    } elseif ($session == 2) {
      $category = 2;
      $db_category = "category =2 AND ";
    }elseif ($session == 3) {
      $category = 3;
      $db_category = "category =3 AND ";
    }elseif ($session == 4) {
      $category = 4;
      $db_category = "category =4 AND ";
    }else{
      $category = 1;
      $db_category = "category =1 AND ";
    }
    
    if($tujuan == 1){
      $sub_category = 1;
      $db_sub_category = "sub_category =1 AND ";
    }elseif($tujuan == 2){
      $sub_category = 2;
      $db_sub_category = "sub_category =2 AND ";
    }elseif($tujuan == 3){
      $sub_category = 3;
      $db_sub_category = "sub_category =3 AND ";
    }elseif($tujuan == 4){
      $sub_category = 4;
      $db_sub_category = "sub_category =4 AND ";
    }elseif($tujuan == 5){
      $sub_category = 5;
      $db_sub_category = "sub_category =5 AND ";
    }elseif($tujuan == 6){
      $sub_category = 6;
      $db_sub_category = "sub_category =6 AND ";
    }else{
      $sub_category = 1;
      $db_sub_category = "sub_category =1 AND ";
    }
    
    
   /* $foot = "<script>"
        . "$(document).ready(function() {"
        . " $('#paket_eropa1_1').show();"  
        . "});"
      . "function cek_show(num){"
        . "$('.season').switchClass('selected-effect', 'hover-effect');"
        . "var hight = new Array();"
        . "hight[1] = $('#hight1_cek').val();"
        . "hight[2] = $('#hight2_cek').val();"
        . "hight[3] = $('#hight3_cek').val();"
        . "hight[4] = $('#hight4_cek').val();"
      
        . "$('#hight1_cek').val(1);"
        . "$('#hight2_cek').val(1);"
        . "$('#hight3_cek').val(1);"
        . "$('#hight4_cek').val(1);"
      
        . "if(hight[num] == 2){"
          . "$('#hight'+num+'_cek').val(1);"
          . "hight[num] = 1;"
          . "$('#hight'+num).switchClass('selected-effect', 'hover-effect');"
        . "}"
        . "else{"
          . "$('#hight'+num+'_cek').val(2);"
          . "hight[num] = 2;"
          . "$('#hight'+num).switchClass('hover-effect', 'selected-effect');"
        . "}"
        . "cek_lvl2();"
      . "}"
      . "function cek_lvl2(){" */
//          . "$('.tujuan').switchClass('selected-effect', 'hover-effect');"
      /*    . "var hight = new Array();"
          . "$('#tujuan1').hide();"
          . "$('#tujuan2').hide();"
          . "$('#tujuan3').hide();"
          . "$('#tujuan4').hide();"
          . "for(var t = 1 ; t <= 4 ; t++){"
            . "if($('#hight'+t+'_cek').val() == '2'){"
              . "var deal = t;"
            . "}"
          . "}"
          . "$('#tujuan'+deal).show();"
          . "$('#tujuan'+deal+'1').switchClass('hover-effect', 'selected-effect');"
          . "hasil_akhir(deal, 1);"
        . "}"
      
        . "function cek_tujuan(ke, yang){"
          . "$('#tujuan'+ke+'1').switchClass('selected-effect', 'hover-effect');"
          . "$('#tujuan'+ke+'2').switchClass('selected-effect', 'hover-effect');"
          . "$('#tujuan'+ke+'3').switchClass('selected-effect', 'hover-effect');"
          . "$('#tujuan'+ke+'4').switchClass('selected-effect', 'hover-effect');"
          . "$('#tujuan'+ke+'5').switchClass('selected-effect', 'hover-effect');"
          . "$('#tujuan'+ke+'6').switchClass('selected-effect', 'hover-effect');"
          . "var tujuan = new Array();"
          . "tujuan[1] = $('#tujuan'+ke+'1_cek').val();"
          . "tujuan[2] = $('#tujuan'+ke+'2_cek').val();"
          . "tujuan[3] = $('#tujuan'+ke+'3_cek').val();"
          . "tujuan[4] = $('#tujuan'+ke+'4_cek').val();"
          . "tujuan[5] = $('#tujuan'+ke+'5_cek').val();"
          . "tujuan[6] = $('#tujuan'+ke+'6_cek').val();"
      
          . "$('#tujuan'+ke+'1_cek').val(1);"
          . "$('#tujuan'+ke+'2_cek').val(1);"
          . "$('#tujuan'+ke+'3_cek').val(1);"
          . "$('#tujuan'+ke+'4_cek').val(1);"
          . "$('#tujuan'+ke+'5_cek').val(1);"
          . "$('#tujuan'+ke+'6_cek').val(1);"
      
          . "if(tujuan[yang] == 2){"
            . "$('#tujuan'+ke+''+yang+'_cek').val(1);"
            . "tujuan[yang] = 1;"
            . "$('#tujuan'+ke+''+yang).switchClass('selected-effect', 'hover-effect');"
          . "}"
          . "else{"
            . "$('#tujuan'+ke+''+yang+'_cek').val(2);"
            . "tujuan[yang] = 2;"
            . "$('#tujuan'+ke+''+yang).switchClass('hover-effect', 'selected-effect');"
          . "}"
          . "hasil_akhir(ke, yang);"
        . "}"
      
      . "function hasil_akhir(season, tujuan){"
        . "$('.paket').hide();"
        . "$('#paket_eropa'+season+'_'+tujuan).show();"
      . "}"
      
      . "</script>"; */
//    $group = $this->global_models->get("website_group_tour", array("status" => 1), "nbs", array(), "id_website_group_tour, title, sub_title, price, nicename, category, sub_category");
    $group = $this->global_models->get_query("SELECT id_website_group_tour, title, sub_title, price, nicename, category, sub_category"
      . " FROM website_group_tour"
      . " WHERE {$db_category} {$db_sub_category}  status <> 3"
      . " ORDER BY price ASC");
    foreach($group AS $gr){
      if($gr->price){
        $price = "Start From {$gr->price}";
      }
      else{
        $price = "";
      }
      $list[$gr->category][$gr->sub_category] .= "<li>"
          . "<a href='".site_url("grouptour/detail/{$gr->nicename}")."' target='_target'>"
            . "<h6 class='box-title'>{$gr->title} {$gr->sub_title} {$price}</h6>"
          . "</a>"
        . "</li>";
    }
    $aha = $this->db->last_query();
//    $this->debug($list, true);
    $this->template->build("main", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => $foot,
        'list'        => $list,
        'category'    => $category,
        'sub_category' => $sub_category,
        'aha'         => $aha
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
  
  public function detail($nicename){
    $foot = ""
      . "<script>"
        . "$(function() {"
          . "function submit_form(){"
            . "var nama = $('#name').val();"
            . "var email = $('#email').val();"
            . "var telp = $('#telp').val();"
            . "var note = $('#note').val();"
            . "var id_website_group_tour = $('#id_website_group_tour').val();"
            . "if(email){"
              . "$.post('".site_url("grouptour/ajax-book-group")."', {name: nama, email: email, telp: telp, id_website_group_tour: id_website_group_tour, note: note}, function(data){"
                . "alert('Permintaan akan di proses.');"
                . "dialog.dialog( 'close' );"
              . "});"
            . "}"
            . "else{"
              . "alert('Email harus diisi.')"
            . "}"
          . "}"
          . "dialog = $( '#dialog-form' ).dialog({"
            . "autoOpen: false,"
            . "height: 500,"
            . "width: 500,"
            . "modal: true,"
            . "buttons: {"
              . "'Submit': function() {"
                . "var tg = submit_form();"
              . "},"
              . "Cancel: function() {"
                . "dialog.dialog( 'close' );"
              . "}"
            . "},"
            . "close: function() {"
              . "form[ 0 ].reset();"
            . "}"
          . "});"
          . "form = dialog.find( 'form' ).on( 'submit', function( event ) {"
            . "event.preventDefault();"
          . "});"
          . "$( '#book-now' ).button().on( 'click', function() {"
            . "dialog.dialog( 'open' );"
          . "});"
        . "});"
      . "</script>";
    $group = $this->global_models->get("website_group_tour", array("nicename" => $nicename));
    $this->template->build("detail", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'group'       => $group,
        'foot2'       => $foot
      ));
    $this->template
      ->set_layout('default')
      ->build("detail");
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */