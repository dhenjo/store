<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function delete($id_website_promosi){
    $this->global_models->delete("website_promosi", array("id_website_promosi" => $id_website_promosi));
    $this->session->set_flashdata('success', 'Data terhapus');
    redirect("promosi/master-promosi");
  }
  
  function index(){
    $list = $this->global_models->get("website_banner");
    
    $menutable = '
      <li><a href="'.site_url("banner/add-new").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/banner', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "banner",
            'data'        => $list,
            'title'       => lang("antavaya_banner"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/banner');
  }
  
  public function add_new($id_website_banner = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_banner", array("id_website_banner" => $id_website_banner));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
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
      
      $this->template->build("master/add-new", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'banner',
              'title'       => lang("antavaya_add_banner"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_banner"  => "banner"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/ads/';
      $config['allowed_types'] = '*';
      $config['max_width']  = '2000';
      $config['max_height']  = '2000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("banner/add-new/".$id_website_banner)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "periodestart"    => $pst['periodestart'],
            "periodeend"      => $pst['periodeend'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        
        $id_website_banner = $this->global_models->update("website_banner", array("id_website_banner" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "periodestart"    => $pst['periodestart'],
            "periodeend"      => $pst['periodeend'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        
        $id_website_banner = $this->global_models->insert("website_banner", $kirim);
      }
      if($id_website_banner){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("banner");
    }
  }
 
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */