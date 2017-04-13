<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Haji extends MX_Controller {
    
  function __construct() {      
    
  }
  
  function ajax_book_haji(){
    $pst = $this->input->post();
    if($pst['email'] AND $pst['id_website_haji']){
      $haji = $this->global_models->get("website_haji", array("id_website_haji" => $pst['id_website_haji']));
      $kirim = array(
        "id_website_haji"           => $pst['id_website_haji'],
        "name"                      => $pst['name'],
        "email"                     => $pst['email'],
        "telp"                      => $pst['telp'],
        "note"                      => $pst['note'],
        "status"                    => 1,
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $id_website_haji_book = $this->global_models->insert("website_haji_book", $kirim);

      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('umroh@antavaya.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Product Hajj & Umrah {$haji[0]->title} ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Dear Hajj & Umrah Admin <br />"
        . "Mohon informasi lebih detail untuk product Hajj & Umrah <a href='".site_url("haji/detail/{$haji[0]->nicename}")."'>{$haji[0]->title}</a><br />"
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

  public function detail($nicename){
    $haji = $this->global_models->get("website_haji", array("nicename" => $nicename));
    $foot = ""
      . "<script>"
        . "$(function() {"
          . "function submit_form(){"
            . "var nama = $('#name').val();"
            . "var email = $('#email').val();"
            . "var telp = $('#telp').val();"
            . "var note = $('#note').val();"
            . "var id_website_haji = $('#id_website_haji').val();"
            . "if(email){"
              . "$.post('".site_url("haji/ajax-book-haji")."', {name: nama, email: email, telp: telp, id_website_haji: id_website_haji, note: note}, function(data){"
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
    
    $this->template->build("detail", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'haji'        => $haji,
        'foot2'       => $foot,
      ));
    $this->template
      ->set_layout('default')
      ->build("detail");
  }
  
  public function index(){
    $data = $this->global_models->get("website_haji", array("status" => 1));
    $this->template->build("main", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'promosi'     => $promosi,
        'data'        => $data,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */