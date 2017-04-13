<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrm extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  public function status_consultant($id_website_travel_consultant, $status){
    $this->global_models->update("website_travel_consultant", array("id_website_travel_consultant" => $id_website_travel_consultant), array("status", $status));
    redirect("hrm/consultant");
  }
  public function consultant(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS lowongan"
      . " FROM website_travel_consultant AS A"
      . " LEFT JOIN website_hrm_lowongan AS B ON A.id_website_hrm_lowongan = B.id_website_hrm_lowongan");
    $this->template->build('consultant', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "hrm/consultant",
            'data'        => $list,
            'title'       => lang("antavaya_travel_consultant"),
            'menutable'   => $menutable,
            'tableboxy'   => 'tableboxydesc'
          ));
    $this->template
      ->set_layout('datatables')
      ->build('consultant');
  }
  
  public function lowongan(){
    $list = $this->global_models->get("website_hrm_lowongan");
    $menutable = '
      <li><a href="'.site_url("hrm/add-lowongan").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('lowongan', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "hrm/lowongan",
            'data'        => $list,
            'title'       => lang("antavaya_hrm_lowongan"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('lowongan');
  }
  
  public function add_lowongan($id_website_hrm_lowongan = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_hrm_lowongan", array("id_website_hrm_lowongan" => $id_website_hrm_lowongan));
      
      $css = ""
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
              $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            });
        </script>
        ";
      
      $this->template->build("add-lowongan", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'hrm/lowongan',
              'title'       => lang("antavaya_add_hrm_lowongan"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_hrm_lowongan"  => "hrm/lowongan"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("add-lowongan");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "mulai"           => $pst['periodestart'],
            "akhir"           => $pst['periodeend'],
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        
        $id_website_hrm_lowongan = $this->global_models->update("website_hrm_lowongan", array("id_website_hrm_lowongan" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "mulai"           => $pst['periodestart'],
            "akhir"           => $pst['periodeend'],
            "note"            => $pst['note'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        
        $id_website_hrm_lowongan = $this->global_models->insert("website_hrm_lowongan", $kirim);
      }
      if($id_website_hrm_lowongan){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("hrm/lowongan");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */