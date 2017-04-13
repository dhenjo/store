<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_fit extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function book(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS promosi, B.nicename"
      . " FROM website_fit_book AS A"
      . " LEFT JOIN website_fit AS B ON A.id_website_fit = B.id_website_fit"
      . "");
    
//    $menutable = '
//      <li><a href="'.site_url("promosi/master-promosi/add-new-promosi").'"><i class="icon-plus"></i> Add New</a></li>
//      ';
    $this->template->build('master/book', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "haji/master-fit/book",
            'data'        => $list,
            'title'       => lang("antavaya_fit_book"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/book');
  }

  function index(){
    $list = $this->global_models->get("website_fit");
    $menutable = '
      <li><a href="'.site_url("fit/master-fit/add-new-fit").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/fit', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "fit/master-fit",
            'data'        => $list,
            'title'       => lang("antavaya_fit"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/fit');
  }
  
  public function add_new_fit($id_website_fit = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_fit", array("id_website_fit" => $id_website_fit));
      
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
      
      $this->template->build("master/add-new-fit", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'fit/master-fit',
              'title'       => lang("antavaya_add_fit"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_fit"  => "fit/master-fit"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-fit");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/fit/';
      $config['allowed_types'] = 'gif|jpg|png|pdf|jpeg|xls';
      $config['max_width']  = '3100';
      $config['max_height']  = '3100';

      $this->load->library('upload', $config);
//      $this->debug($_FILES, true);
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("fit/master-fit/add-new-fit/".$id_website_fit)."'>Back</a>";
          die;
        }
      }
      if($_FILES['file_pdf']['name']){
        if (  $this->upload->do_upload('file_pdf')){
          $data_pdf = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("fit/master-fit/add-new-fit/".$id_website_fit)."'>Back</a>";
          die;
        }
      }
      if($_FILES['file_temp']['name']){
        if (  $this->upload->do_upload('file_temp')){
          $data_temp = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("fit/master-fit/add-new-fit/".$id_website_fit)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_fit", "id_website_fit"),
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
        $id_website_fit = $this->global_models->update("website_fit", array("id_website_fit" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_fit", "id_website_fit"),
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
        $id_website_fit = $this->global_models->insert("website_fit", $kirim);
      }
      if($id_website_fit){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("fit/master-fit");
    }
  }
 
  public function edit_book($id_website_fit_book = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_fit_book", array("id_website_fit_book" => $id_website_fit_book));
      
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
              'menu'        => 'promosi/master-fit/book',
              'title'       => lang("antavaya_add_fit_book"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_promosi_book"  => "fit/master-fit/book"
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
            "id_website_fit"      => $pst['id_website_fit'],
            "name"                    => $pst['name'],
            "email"                   => $pst['email'],
            "telp"                    => $pst['telp'],
            "status"                  => $pst['status'],
            "note"                    => $pst['note'],
            "update_by_users"         => $this->session->userdata("id"),
        );
        
        $id_website_fit_book = $this->global_models->update("website_fit_book", array("id_website_fit_book" => $pst['id_detail']),$kirim);
      }
      
      if($id_website_fit_book){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("fit/master-fit/book");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */