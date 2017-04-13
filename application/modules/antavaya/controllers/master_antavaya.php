<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_antavaya extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function faq(){
    $list = $this->global_models->get("website_faq");
    
    $menutable = '
      <li><a href="'.site_url("antavaya/master-antavaya/add-new-faq").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/faq', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "antavaya/master-antavaya/faq",
            'data'        => $list,
            'title'       => lang("antavaya_faq"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/faq');
  }
  
  function terms(){
    $list = $this->global_models->get("website_terms");
    
    $menutable = '
      <li><a href="'.site_url("antavaya/master-antavaya/add-new-terms").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/terms', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "antavaya/master-antavaya/terms",
            'data'        => $list,
            'title'       => lang("antavaya_terms"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/terms');
  }

  function slideshow(){
    $list = $this->global_models->get("website_slideshow");
    
    $menutable = '
      <li><a href="'.site_url("antavaya/master-antavaya/add-new-slideshow").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/slideshow', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "antavaya/master-antavaya/slideshow",
            'data'        => $list,
            'title'       => lang("antavaya_slideshow"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/slideshow');
  }
  
  public function add_new_slideshow($id_website_slideshow = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_slideshow", array("id_website_slideshow" => $id_website_slideshow));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              
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
      
      $this->template->build("master/add-new-slideshow", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'antavaya/master-antavaya/promo',
              'title'       => lang("antavaya_add_slideshow"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_slideshow"  => "antavaya/master-antavaya/slideshow"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-slideshow");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/slideshow/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '2200';
      $config['max_height']  = '2200';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("antavaya/master-antavaya/add-new-slideshow/".$id_website_slideshow)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "link"            => $pst['link'],
            "sort"            => $pst['sort'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_website_slideshow = $this->global_models->update("website_slideshow", array("id_website_slideshow" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "link"            => $pst['link'],
            "status"          => $pst['status'],
            "sort"            => $pst['sort'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_website_slideshow = $this->global_models->insert("website_slideshow", $kirim);
      }
      if($id_website_slideshow){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("antavaya/master-antavaya/slideshow");
    }
  }
 
  public function add_new_faq($id_website_faq = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_faq", array("id_website_faq" => $id_website_faq));
      
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
            });
        </script>
        ";
      
      $this->template->build("master/add-new-faq", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'antavaya/master-antavaya/faq',
              'title'       => lang("antavaya_add_faq"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_faq"  => "antavaya/master-antavaya/faq"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-faq");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_faq", "id_website_faq"),
            "sort"            => $pst['sort'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_website_faq = $this->global_models->update("website_faq", array("id_website_faq" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_faq", "id_website_faq"),
            "sort"            => $pst['sort'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_website_faq = $this->global_models->insert("website_faq", $kirim);
      }
      if($id_website_faq){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("antavaya/master-antavaya/faq");
    }
  }
 
  public function add_new_terms($id_website_terms = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_terms", array("id_website_terms" => $id_website_terms));
      
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
            });
        </script>
        ";
      
      $this->template->build("master/add-new-terms", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'antavaya/master-antavaya/terms',
              'title'       => lang("antavaya_add_terms"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_terms"  => "antavaya/master-antavaya/terms"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-terms");
    }
    else{
      $pst = $this->input->post(NULL);
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_terms", "id_website_terms"),
            "sort"            => $pst['sort'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_website_terms = $this->global_models->update("website_terms", array("id_website_terms" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_terms", "id_website_terms"),
            "sort"            => $pst['sort'],
            "status"          => $pst['status'],
            "note"            => $pst['note'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_website_terms = $this->global_models->insert("website_terms", $kirim);
      }
      if($id_website_terms){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("antavaya/master-antavaya/terms");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */