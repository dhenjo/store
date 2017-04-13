<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_grouptour extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function delete_grouptour($id_website_group_tour){
    $this->global_models->delete("website_group_tour", array("id_website_group_tour" => $id_website_group_tour));
    $this->session->set_flashdata('success', 'Data terhapus');
    redirect("grouptour/master-grouptour");
  }
  
  function book(){
    $list = $this->global_models->get_query("SELECT A.*, B.title AS promosi, B.nicename"
      . " FROM website_group_tour_book AS A"
      . " LEFT JOIN website_group_tour AS B ON A.id_website_group_tour = B.id_website_group_tour"
      . "");
    
//    $menutable = '
//      <li><a href="'.site_url("promosi/master-promosi/add-new-promosi").'"><i class="icon-plus"></i> Add New</a></li>
//      ';
    $this->template->build('master/book', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/master-grouptour/book",
            'data'        => $list,
            'title'       => lang("antavaya_grouptour_book"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/book');
  }

  function index(){
    $list = $this->global_models->get("website_group_tour");
    
    $menutable = '
      <li><a href="'.site_url("grouptour/master-grouptour/add-new-grouptour").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/group-tour', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/master-grouptour",
            'data'        => $list,
            'title'       => lang("antavaya_group_tour"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/group-tour');
  }
  
  public function add_new_grouptour($id_website_group_tour = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_group_tour", array("id_website_group_tour" => $id_website_group_tour));
      
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
      
      $this->template->build("master/add-new-group-tour", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'grouptour/master-grouptour',
              'title'       => lang("antavaya_add_group_tour"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_group_tour"  => "grouptour/master-grouptour"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-group-tour");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/grouptour/';
      $config['allowed_types'] = '*';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("grouptour/master-grouptour/add-new-grouptour/".$id_website_group_tour)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['file_thumb']['name']){
        if (  $this->upload->do_upload('file_thumb')){
          $data_thumb = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("grouptour/master-grouptour/add-new-grouptour/".$id_website_group_tour)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['link']['name']){
        if (  $this->upload->do_upload('link')){
          $link = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("grouptour/master-grouptour/add-new-grouptour/".$id_website_group_tour)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "sub_title"       => $pst['sub_title'],
            "summary"         => $pst['summary'],
            "price"           => $pst['price'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_group_tour", "id_website_group_tour"),
            "category"        => $pst['category'],
            "sub_category"    => $pst['sub_category'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_thumb['upload_data']['file_name']){
          $kirim['file_thumb'] = $data_thumb['upload_data']['file_name'];
        }
        if($link['upload_data']['file_name']){
          $kirim['link'] = $link['upload_data']['file_name'];
        }
        $id_website_group_tour = $this->global_models->update("website_group_tour", array("id_website_group_tour" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "sub_title"       => $pst['sub_title'],
            "summary"         => $pst['summary'],
            "price"           => $pst['price'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_promosi", "id_website_promosi"),
            "category"        => $pst['category'],
            "sub_category"    => $pst['sub_category'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_thumb['upload_data']['file_name']){
          $kirim['file_thumb'] = $data_thumb['upload_data']['file_name'];
        }
        if($link['upload_data']['file_name']){
          $kirim['link'] = $link['upload_data']['file_name'];
        }
        $id_website_group_tour = $this->global_models->insert("website_group_tour", $kirim);
      }
      if($id_website_group_tour){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("grouptour/master-grouptour");
    }
  }
  
  public function edit_book($id_website_group_tour_book = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_group_tour_book", array("id_website_group_tour_book" => $id_website_group_tour_book));
      
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
              'menu'        => 'grouptour/master-grouptour/book',
              'title'       => lang("antavaya_add_grouptour_book"),
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "antavaya_grouptour_book"  => "promosi/master-grouptour/book"
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
            "id_website_promosi"      => $pst['id_website_promosi'],
            "name"                    => $pst['name'],
            "email"                   => $pst['email'],
            "telp"                    => $pst['telp'],
            "status"                  => $pst['status'],
            "note"                    => $pst['note'],
            "update_by_users"         => $this->session->userdata("id"),
        );
        
        $id_website_promosi_book = $this->global_models->update("website_promosi_book", array("id_website_promosi_book" => $pst['id_detail']),$kirim);
      }
      
      if($id_website_promosi_book){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("promosi/master-promosi/book");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */