<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal_home extends MX_Controller {
    
  function __construct() {      
    
    $this->menu = $this->cek();
    
//    $this->debug($this->menu, true);
  }
	
  function ajax_pesan_jendol(){
    $total = $this->global_models->get_query("SELECT count(A.id_cms_contact_us) AS jml"
      . " FROM cms_contact_us AS A"
      . " LEFT JOIN m_users AS B ON A.id_users_from = B.id_users"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.received_status = 1 AND status = 1");
    $pesan = $this->global_models->get_query("SELECT A.*"
      . " FROM cms_contact_us AS A"
      . " WHERE A.id_users = {$this->session->userdata("id")} AND A.received_status = 1"
      . " ORDER BY A.create_date DESC LIMIT 0, 3");
      
    if($this->session->userdata("avatar")){
      $avatar = $this->session->userdata("avatar");
    }
    else{
      $avatar = $url."img/no-pic.png";
    }
      
    $isi = "<ul class='menu'>";
      foreach ($pesan AS $psn){
    $isi .= " <li>"
      . "     <a href='#'>"
      . "       <div class='pull-left'>"
      . "         <img src='{$avatar}' class='img-circle' alt='User Image'/>"
      . "       </div>"
      . "       <h4>".  substr($psn->title, 0, 20)." ...."
      . "         <small><i class='fa fa-clock-o'></i> 5 mins</small>"
        . "     </h4>"
        . "     <p>Why not buy a new awesome theme?</p>"
        . "   </a>"
        . " </li>";
      }
    $isi .= "</ul>";
    
      
    $hasil = array(
        "jml"       => $total[0]->jml,
        "isi"       => $isi,
    );
    print json_encode($hasil);
    die;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */