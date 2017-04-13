<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diskon extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  public function diskon_mega(){
    $list = $this->global_models->get("website_hemat_mega");
    $menutable = '
      <li><a href="'.site_url("diskon/add-diskon-mega").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('diskon-mega', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "diskon/diskon-mega",
            'data'        => $list,
            'title'       => lang("antavaya_diskon_mega"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc'
          ));
    $this->template
      ->set_layout('datatables')
      ->build('diskon-mega');
  }
  
  public function add_diskon_mega($id_website_hemat_mega = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_hemat_mega", array("id_website_hemat_mega" => $id_website_hemat_mega));
      
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
              $( '#start_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            });
        </script>
        ";
      
      $this->template->build("add-diskon-mega", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'diskon/diskon-mega',
              'title'       => lang("antavaya_add_diskon_mega"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_diskon_mega"  => "diskon/diskon-mega"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("add-diskon-mega");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "hemat"           => $pst['diskon'],
            "nilai"           => $pst['nilai'],
            "mulai"           => $pst['periodestart']." ".$pst['waktumulai'],
            "akhir"           => $pst['periodeend']." ".$pst['waktuselesai'],
            "waktumulai"      => $pst['waktumulai'],
            "waktuselesai"    => $pst['waktuselesai'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        
        $id_website_hemat_mega = $this->global_models->update("website_hemat_mega", array("id_website_hemat_mega" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "hemat"           => $pst['diskon'],
            "nilai"           => $pst['nilai'],
            "waktumulai"      => $pst['waktumulai'],
            "waktuselesai"    => $pst['waktuselesai'],
            "mulai"           => $pst['periodestart']." ".$pst['waktumulai'],
            "akhir"           => $pst['periodeend']." ".$pst['waktuselesai'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        
        $id_website_hemat_mega = $this->global_models->insert("website_hemat_mega", $kirim);
      }
      if($id_website_hemat_mega){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("diskon/diskon-mega");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */