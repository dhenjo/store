<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_haji extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function delete_haji($id_website_haji){
    $this->global_models->delete("website_haji", array("id_website_haji" => $id_website_haji));
    $this->session->set_flashdata('success', 'Data terhapus');
    redirect("haji/master-haji");
  }
  
  function book(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS promosi, B.nicename"
      . " FROM website_haji_book AS A"
      . " LEFT JOIN website_haji AS B ON A.id_website_haji = B.id_website_haji"
      . "");
    
//    $menutable = '
//      <li><a href="'.site_url("promosi/master-promosi/add-new-promosi").'"><i class="icon-plus"></i> Add New</a></li>
//      ';
    $this->template->build('master/book', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "haji/master-haji/book",
            'data'        => $list,
            'title'       => lang("antavaya_haji_book"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/book');
  }

  function index(){
    $list = $this->global_models->get("website_haji");
    
    $menutable = '
      <li><a href="'.site_url("haji/master-haji/add-new-haji").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/haji', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "haji/master-haji",
            'data'        => $list,
            'title'       => lang("antavaya_haji"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/haji');
  }
  
  public function add_new_haji($id_website_haji = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_haji", array("id_website_haji" => $id_website_haji));
      
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
      
      $this->template->build("master/add-new-haji", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'haji/master-haji',
              'title'       => lang("antavaya_add_haji"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_haji"  => "haji/master-haji"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-haji");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/haji/';
      $config['allowed_types'] = '*';
      $config['max_width']  = '3100';
      $config['max_height']  = '3100';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("haji/master-haji/add-new-haji/".$id_website_haji)."'>Back</a>";
          die;
        }
      }
      if($_FILES['file_pdf']['name']){
        if (  $this->upload->do_upload('file_pdf')){
          $data_pdf = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("haji/master-haji/add-new-haji/".$id_website_haji)."'>Back</a>";
          die;
        }
      }
      if($_FILES['file_temp']['name']){
        if (  $this->upload->do_upload('file_temp')){
          $data_temp = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("haji/master-haji/add-new-haji/".$id_website_haji)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_haji", "id_website_haji"),
            "sub_title"       => $pst['sub_title'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_pdf['upload_data']['file_name']){
          $kirim['file_pdf'] = $data_pdf['upload_data']['file_name'];
        }
        if($data_temp['upload_data']['file_name']){
          $kirim['file_temp'] = $data_temp['upload_data']['file_name'];
        }
        $id_website_haji = $this->global_models->update("website_haji", array("id_website_haji" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_haji", "id_website_haji"),
            "sub_title"       => $pst['sub_title'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_pdf['upload_data']['file_name']){
          $kirim['file_pdf'] = $data_pdf['upload_data']['file_name'];
        }
        if($data_temp['upload_data']['file_name']){
          $kirim['file_temp'] = $data_temp['upload_data']['file_name'];
        }
        $id_website_haji = $this->global_models->insert("website_haji", $kirim);
      }
      if($id_website_haji){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("haji/master-haji");
    }
  }
 
  public function edit_book($id_website_haji_book = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_haji_book", array("id_website_haji_book" => $id_website_haji_book));
      
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
      
      $this->template->build("master/add-book", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'promosi/master-promosi/book',
              'title'       => lang("antavaya_add_promosi_book"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_promosi_book"  => "promosi/master-promosi/book"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-book");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "id_website_haji"      => $pst['id_website_haji'],
            "name"                    => $pst['name'],
            "email"                   => $pst['email'],
            "telp"                    => $pst['telp'],
            "status"                  => $pst['status'],
            "note"                    => $pst['note'],
            "update_by_users"         => $this->session->userdata("id"),
        );
        
        $id_website_haji_book = $this->global_models->update("website_haji_book", array("id_website_haji_book" => $pst['id_detail']),$kirim);
      }
      
      if($id_website_haji_book){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("haji/master-haji/book");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */