<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends MX_Controller {
    
  function __construct() {      
    
  }

  public function index($nicename){
    $page = $this->global_models->get("website_page", array("nicename" => $nicename));
    $gambar = $this->global_models->get("website_page_picture", array("id_website_page" => $page[0]->id_website_page));
    $this->template->build("main", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'page'        => $page,
        'gambar'      => $gambar,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
  
  public function html($nicename){
    if($this->input->post()){
      $pst = $this->input->post();
      if($nicename == 'careers'){
        $config['upload_path'] = './files/antavaya/cv/';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);

        if($_FILES['file']['name']){
          if (  $this->upload->do_upload('file')){
            $data = array('upload_data' => $this->upload->data());
          }
          else{
            print $this->upload->display_errors();
            print "<br /> <a href='".site_url("page/html/{$nicename}")."'>Back</a>";
            die;
          }
        }
        $kirim = array(
          "id_website_hrm_lowongan" => $pst['id_website_hrm_lowongan'],
          "first_name"        => $pst['first_name'],
          "last_name"         => $pst['last_name'],
          "hp"                => $pst['hp'],
          "email"             => $pst['email'],
          "status"            => 1,
          "create_date"       => date("Y-m-d H:i:s")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        $id_website_travel_consultant = $this->global_models->insert("website_travel_consultant", $kirim);
        $lowongan = $this->global_models->get_field("website_hrm_lowongan", "title", array("id_website_hrm_lowongan" => $pst['id_website_hrm_lowongan']));
        
        $this->load->library('email');
        $this->email->initialize($this->global_models->email_conf());

        $this->email->from($pst['email'], $pst['name']);
        $this->email->to('recruitment@antavaya.com'); 
        $this->email->cc(array('afiah.isnainingsih@antavaya.com', 'ari.widayanti@antavaya.com', 'nugroho.budi@antavaya.com'));

        $this->email->subject("Careers {$pst['first_name']} {$pst['last_name']} ".date("Y-m-d H:i:s"));
        $this->email->message(""
          . "Careers untuk {$lowongan} <a href='".site_url("hrm/consultant/{$id_website_travel_consultant}")."'>{$pst['first_name']} {$pst['last_name']}</a>.<br />"
          . "Nama : {$pst['first_name']} {$pst['last_name']} <br />"
          . "Email : {$pst['email']}<br />"
          . "Telepon : {$pst['hp']}<br />"
          . "Terima Kasih"
          . "");  
    //die;
        $this->email->send();
        
        if($id_website_travel_consultant){
          $this->session->set_flashdata('success', 'Data terkirim');
        }
        else{
          $this->session->set_flashdata('notice', 'Data tidak terkirim');
        }
        redirect("page/html/{$nicename}");
      }
    }
    $this->template->build("html/".str_replace("_", "-", $nicename), 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'foot2'       => $foot
      ));
    $this->template
      ->set_layout('default')
      ->build("html/".str_replace("_", "-", $nicename));
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */