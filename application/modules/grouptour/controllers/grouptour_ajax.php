<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grouptour_ajax extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function curl_mentah($pst, $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function set_detail(){
    $post_agent = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_master_sub_agent" => $this->input->post("id"),
    );

    $agent = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-sub-agent");  
    $agent_array = json_decode($agent);
    $pic = explode(" ", $agent_array->data[0]->pic);
    $hasil = array(
      "pic1"      => $pic[0],
      "pic2"      => $pic[1]." ".$pic[2]." ".$pic[3]." ".$pic[4],
      "email"     => $agent_array->data[0]->email,
      "telp"      => $agent_array->data[0]->telp,
      "alamat"    => $agent_array->data[0]->alamat,
    );
    print json_encode($hasil);die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */