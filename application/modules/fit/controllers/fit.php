<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fit extends MX_Controller {
    
  function __construct() {      
    
  }
  
  function ajax_book_fit(){
    $pst = $this->input->post();
    $kirim = array(
      "id_website_fit"            => $pst['id_website_fit'],
      "name"                      => $pst['name'],
      "email"                     => $pst['email'],
      "telp"                      => $pst['telp'],
      "status"                    => 1,
      "create_by_users"           => $this->session->userdata("id"),
      "create_date"               => date("Y-m-d H:i:s"),
    );
    $id_website_fit_book = $this->global_models->insert("website_fit_book", $kirim);
    print 'ok';die;
  }

  public function detail($nicename){
    $haji = $this->global_models->get("website_fit", array("nicename" => $nicename));
    $foot = ""
      . "<script>"
        . "$(function() {"
          . "function submit_form(){"
            . "var nama = $('#name').val();"
            . "var email = $('#email').val();"
            . "var telp = $('#telp').val();"
            . "var id_website_haji = $('#id_website_haji').val();"
            . "if(email){"
              . "$.post('".site_url("fit/ajax-book-fit")."', {name: nama, email: email, telp: telp, id_website_haji: id_website_haji}, function(data){"
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
            . "height: 300,"
            . "width: 350,"
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
    $data = $this->global_models->get("website_fit", array("status" => 1));
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