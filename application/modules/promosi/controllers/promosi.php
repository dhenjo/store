<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promosi extends MX_Controller {
    
  function __construct() {      
    
  }
  
  function sort($with){
    $set = array(
      "promosi_sort" => $with,
    );
    $this->session->set_userdata($set);
    redirect("promosi");
  }
  
  function filter($hargaa, $hargab){
    $set = array(
      "promosi_filter_hargaa" => $hargaa,
      "promosi_filter_hargab" => $hargab,
    );
    $this->session->set_userdata($set);
    redirect("promosi");
  }
  
  function ajax_load_more(){
    $count = $this->input->post("count");
    if($this->session->userdata("promosi_sort") == 1){
      $order = "title ASC";
    }
    else if($this->session->userdata("promosi_sort") == 2){
      $order = "title DESC";
    }
    else if($this->session->userdata("promosi_sort") == 3){
      $order = "price ASC";
    }
    else if($this->session->userdata("promosi_sort") == 4){
      $order = "price DESC";
    }
    else{
      $order = "price ASC";
    }
    
//    filter
    if($this->session->userdata("promosi_filter_hargaa"))
      $promosi_filter_hargaa = $this->session->userdata("promosi_filter_hargaa");
    else
      $promosi_filter_hargaa = 0;
    if($this->session->userdata("promosi_filter_hargab"))
      $promosi_filter_hargab = $this->session->userdata("promosi_filter_hargab");
    else
      $promosi_filter_hargab = 5000;
    
    $data = $this->global_models->get_query("SELECT *"
      . " FROM website_promosi"
      . " WHERE status <> 3"
      . " AND (price BETWEEN {$promosi_filter_hargaa} AND {$promosi_filter_hargab})"
      . " ORDER BY {$order}"
      . " LIMIT {$count}, 8");
    print "<div class='image-box style9 column-4'>";
    foreach($data AS $dt){  
      print "
          <article class='box'>
              <figure>
                  <a href='".site_url("promosi/detail/{$dt->nicename}")."' title='' class='hover-effect yellow'>
                      <img src='".base_url()."files/antavaya/promosi/{$dt->file_temp}' alt='' width='160' /></a>
              </figure>
              <div class='details'>
                  <h4 style='min-height: 175px; color: #bd2330'>{$dt->title}<br />
                      <small style='color: black'>{$dt->sub_title}
                      <br /><span style='font-size: 11px; color: #727070'></span>{$dt->summary}</small></h4>
                  <a style='margin-top: 0' href='".site_url("promosi/detail/{$dt->nicename}")."' title='' class='button'>Detail</a>
              </div>
          </article>
      ";
      $count++;
    }
    print "</div>"
    . "<script>"
      . "$('#kondisi').val({$count});"
    . "</script>";
    die;
  }
  
  public function index(){
    if($this->session->userdata("promosi_sort") == 1){
      $order = "title ASC";
    }
    else if($this->session->userdata("promosi_sort") == 2){
      $order = "title DESC";
    }
    else if($this->session->userdata("promosi_sort") == 3){
      $order = "price ASC";
    }
    else if($this->session->userdata("promosi_sort") == 4){
      $order = "price DESC";
    }
    else{
      $order = "price ASC";
    }
    
//    filter
    if($this->session->userdata("promosi_filter_hargaa"))
      $promosi_filter_hargaa = $this->session->userdata("promosi_filter_hargaa");
    else
      $promosi_filter_hargaa = 0;
    if($this->session->userdata("promosi_filter_hargab"))
      $promosi_filter_hargab = $this->session->userdata("promosi_filter_hargab");
    else
      $promosi_filter_hargab = 5000;
    
    $data = $this->global_models->get_query("SELECT *"
      . " FROM website_promosi"
      . " WHERE status <> 3"
      . " AND (price BETWEEN {$promosi_filter_hargaa} AND {$promosi_filter_hargab})"
      . " ORDER BY {$order}"
      . " LIMIT 0, 8");
      
    $foot = "<script>"
      . "tjq(document).ready(function() {"
        . "tjq('#price-range').slider({"
          . "range: true,"
          . "min: 0,"
          . "max: 5000,"
          . "values: [ {$promosi_filter_hargaa}, {$promosi_filter_hargab} ],"
          . "slide: function( event, ui ) {"
            . "tjq('.min-price-label').html( ui.values[ 0 ]);"
            . "tjq('.max-price-label').html( ui.values[ 1 ]);"
            . "tjq('#hargaa').val( ui.values[ 0 ]);"
            . "tjq('#hargab').val( ui.values[ 1 ]);"
          . "}"
        . "});"
        . "tjq('.min-price-label').html( tjq('#price-range').slider( 'values', 0 ));"
        . "tjq('.max-price-label').html( tjq('#price-range').slider( 'values', 1 ));"
      . "});"
        
      . "$(document).ready(function() {"
        . "$('#sorting').change(function(){"
          . "window.location = '".site_url("promosi/sort/")."/'+$('#sorting').val();"
        . "});"
      
      . "});"
      . "function filter_promosi(){"
        . "var hargaa = $('#hargaa').val();"
        . "var hargab = $('#hargab').val();"
        . "window.location = '".site_url("promosi/filter/")."/'+hargaa+'/'+hargab;"
      . "}"
            
      . "function load_more(){"
        . "var count = $('#count').val() * 1;"
        . "var kondisi = $('#kondisi').val() * 1;"
        . "$.post('".site_url("promosi/ajax-load-more")."', {count: kondisi}, function(data){"
          . "var baru = count - 8;"
          . "$('#count').val(baru);"
          . "$('#lolo').html(data);"
          . "if(baru > 0){"
            . "$('#lainnya-b').hide();"
          . "}"
        . "});"
      . "}"
            
      . "</script>";
    $sum_all = $this->global_models->get_query("SELECT COUNT(id_website_promosi) AS jml"
      . " FROM website_promosi"
      . " WHERE status <> 3"
      . " AND (price BETWEEN {$promosi_filter_hargaa} AND {$promosi_filter_hargab})"
      . "");
    $this->template->build("inti", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'promosi'     => $promosi,
        'data'        => $data,
        'foot2'       => $foot,
        'count'       => $sum_all[0]->jml
      ));
    $this->template
      ->set_layout('default')
      ->build("inti");
  }
  
  function ajax_book_promosi(){
    $pst = $this->input->post();
    if($pst['email'] AND $pst['id_website_promosi']){
      $promosi = $this->global_models->get("website_promosi", array("id_website_promosi" => $pst['id_website_promosi']));
      $kirim = array(
        "id_website_promosi"        => $pst['id_website_promosi'],
        "name"                      => $pst['name'],
        "email"                     => $pst['email'],
        "telp"                      => $pst['telp'],
        "status"                    => 1,
        "note"                      => $pst['note'],
        "create_by_users"           => $this->session->userdata("id"),
        "create_date"               => date("Y-m-d H:i:s"),
      );
      $id_website_promosi_book = $this->global_models->insert("website_promosi_book", $kirim);


      $this->load->library('email');
      $this->email->initialize($this->global_models->email_conf());

      $this->email->from($pst['email'], $pst['name']);
      $this->email->to('tour@antavaya.com'); 
      $this->email->cc('nugroho.budi@antavaya.com');

      $this->email->subject("Inquiry Product Tour {$promosi[0]->title} ".date("Y-m-d H:i:s"));
      $this->email->message(""
        . "Dear Tour Admin <br />"
        . "Mohon informasi lebih detail untuk product tour <a href='".site_url("promosi/detail/{$promosi[0]->nicename}")."'>{$promosi[0]->title}</a>.<br />"
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
    $promosi = $this->global_models->get("website_promosi", array("nicename" => $nicename));
    $foot = ""
      . "<script>"
        . "$(function() {"
          . "function submit_form(){"
            . "var nama = $('#name').val();"
            . "var email = $('#email').val();"
            . "var telp = $('#telp').val();"
            . "var note = $('#note').val();"
            . "var id_website_promosi = $('#id_website_promosi').val();"
            . "if(email){"
              . "$.post('".site_url("promosi/ajax-book-promosi")."', {name: nama, email: email, telp: telp, id_website_promosi: id_website_promosi, note: note}, function(data){"
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
                . "$('#form_inquiry').trigger( 'reset' );"
//              . "form[ 0 ].reset();"
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
//    $this->debug($promosi, true);
    $this->template->build("main", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'promosi'     => $promosi,
        'foot2'       => $foot,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */