<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_news extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }
  
  function delete_news($id_website_news){
    $this->global_models->delete("website_news", array("id_website_news" => $id_website_news));
    $this->session->set_flashdata('success', 'Data terhapus');
    redirect("news/master-news");
  }

  function index(){
    $list = $this->global_models->get("website_news");
    
    $menutable = '
      <li><a href="'.site_url("news/master-news/add-new-news").'"><i class="icon-plus"></i> Add New</a></li>
      ';
    $this->template->build('master/news', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "news/master-news",
            'data'        => $list,
            'title'       => lang("antavaya_news"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('master/news');
  }
  
  public function add_new_news($id_website_news = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_news", array("id_website_news" => $id_website_news));
      
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
             
            });
        </script>
        ";
      
      $this->template->build("master/add-new-news", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'news/master-news',
              'title'       => lang("antavaya_add_news"),
              'detail'      => $detail,
              'breadcrumb'  => array(
              'news'        => "news/master-news"
                ),
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-news");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/news/';
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
          print "<br /> <a href='".site_url("news/master-news/add-new-news/".$id_website_news)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['file_thumb']['name']){
        if (  $this->upload->do_upload('file_thumb')){
          $data_thumb = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("news/master-news/add-new-news/".$id_website_news)."'>Back</a>";
          die;
        }
      }     
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "note"            => $pst['note'],
           "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_news", "id_website_news"),
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_thumb['upload_data']['file_name']){
          $kirim['file_thumb'] = $data_thumb['upload_data']['file_name'];
        }
        
        $id_website_news = $this->global_models->update("website_news", array("id_website_news" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "note"            => $pst['note'],
            "nicename"        => $this->global_models->nicename(trim($pst['title']), "website_news", "id_website_news"),
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
        
        $id_website_news = $this->global_models->insert("website_news", $kirim);
      }
      if($id_website_news){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("news/master-news");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */