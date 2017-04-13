<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_page extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function cv(){
    $list = $this->global_models->get("website_travel_consultant");
    
//    $menutable = '
//      <li><a href="'.site_url("promosi/master-promosi/add-new-promosi").'"><i class="icon-plus"></i> Add New</a></li>
//      ';
    $this->template->build('master/cv', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "page/master-page/cv",
            'data'        => $list,
            'title'       => lang("antavaya_page_cv"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/cv');
  }

  function index(){
    $list = $this->global_models->get("website_page");
    
    $menutable = '
      <li><a href="'.site_url("page/master-page/add-new-page").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/page', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "page/master-page",
            'data'        => $list,
            'title'       => lang("antavaya_page"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/page');
  }
  
  function gambar($id_website_page){
    $list = $this->global_models->get("website_page_picture", array("id_website_page" => $id_website_page));
    
    $menutable = '
      <li><a href="'.site_url("page/master-page/add-new-page-gambar/{$id_website_page}").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/gambar', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "page/master-page",
            'data'        => $list,
            'title'       => lang("antavaya_page_gambar"),
            'breadcrumb'  => array(
                    "antavaya_page"  => "page/master-page"
                ),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/gambar');
  }
  
  public function add_new_page($id_website_page = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_page", array("id_website_page" => $id_website_page));
      
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
      
      $this->template->build("master/add-new-page", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'page/master-page',
              'title'       => lang("antavaya_add_page"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_page"  => "page/master-page"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-page");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/page/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("page/master-page/add-new-page/".$id_website_page)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_page", "id_website_page"),
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_website_page = $this->global_models->update("website_page", array("id_website_page" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_page", "id_website_page"),
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_website_promosi = $this->global_models->insert("website_page", $kirim);
      }
      if($id_website_promosi){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("page/master-page");
    }
  }
 
  public function add_new_page_gambar($id_website_page, $id_website_page_picture = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_page_picture", array("id_website_page" => $id_website_page, "id_website_page_picture" => $id_website_page_picture));
      
      $this->template->build("master/add-new-page-gambar", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'page/master-page',
              'title'       => lang("antavaya_add_page_gambar"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_page"  => "page/master-page",
                    "antavaya_page_gambar"  => "page/master-page/gambar/{$id_website_page}"
                ),
              'id_website_page'  => $id_website_page
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-page-gambar");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/page/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("page/master-page/add-new-page-gambar/".$id_website_page."/{$id_website_page_picture}")."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        if($data['upload_data']['file_name']){
          $kirim = array(
              "file"            => $data['upload_data']['file_name'],
              "id_website_page" => $pst['id_website_page'],
              "update_by_users" => $this->session->userdata("id"),
          );
          $id_website_page_picture = $this->global_models->update("website_page_picture", array("id_website_page_picture" => $pst['id_detail']),$kirim);
        }
      }
      else{
        if($data['upload_data']['file_name']){
          $kirim = array(
              "file"            => $data['upload_data']['file_name'],
              "id_website_page" => $pst['id_website_page'],
              "create_by_users" => $this->session->userdata("id"),
              "create_date"     => date("Y-m-d H:i:s"),
          );
          $id_website_page_picture = $this->global_models->insert("website_page_picture", $kirim);
        }
      }
      if($id_website_page_picture){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("page/master-page/gambar/{$id_website_page}");
    }
  }
  
  public function edit_cv($id_website_travel_consultant = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_travel_consultant", array("id_website_travel_consultant" => $id_website_travel_consultant));
      
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
      
      $this->template->build("master/add-cv", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'page/master-page/cv',
              'title'       => lang("antavaya_add_page_cv"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_page_cv"  => "page/master-page/cv"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-cv");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "first_name"        => $pst['first_name'],
            "last_name"         => $pst['last_name'],
            "hp"                => $pst['hp'],
            "email"             => $pst['email'],
            "status"            => $pst['status'],
            "note"                    => $pst['note'],
            "update_by_users"         => $this->session->userdata("id"),
        );
        
        $id_website_travel_consultant = $this->global_models->update("website_travel_consultant", array("id_website_travel_consultant" => $pst['id_detail']),$kirim);
      }
      
      if($id_website_travel_consultant){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("page/master-page/cv");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */