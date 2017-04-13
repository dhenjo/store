<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function edit_pax_book(){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $this->input->post("code"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-detail-pax-book");  
    print $data;
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */