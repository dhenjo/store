<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {
  function __construct() {
    $this->load->model('login/mlogin');
    $this->load->library('encrypt');
    $this->load->library('session');
  }
  
  
	public function index($pesan = "hal"){
//    $this->debug(uri_string(), true);
//      
//      
      $config = array(
      array(
            'field'   => 'memuname', 
            'label'   => 'Username', 
            'rules'   => 'required'
         ),
      array(
            'field'   => 'mempass', 
            'label'   => 'Password', 
            'rules'   => 'required'
         ),
    );
    
    $this->form_validation->set_rules($config);
    $this->template->title('Login', "Sistem");
    if ($this->form_validation->run() == FALSE){
      $this->session->sess_destroy();
//      print "gagal";
			$this->template->build('main', 
        array(
              'url'     => base_url()."themes/".DEFAULTTHEMES."/",
              'field'   => array('memuname' => $this->input->post('memuname'))
            ));
      $this->template
        ->set_layout('login')
        ->build('main');
		}
		else{
      $cek_login = $this->mlogin->cek_login($this->input->post('memuname'), $this->input->post('mempass'));
      if($cek_login === true){
        if($this->session->userdata("id") == 1)
          redirect('home');
        else
          redirect($this->session->userdata('dashbord'));
      }
      else{
        $this->session->sess_destroy();
        $this->template->build('main', 
        array(
              'url'     => base_url()."themes/".DEFAULTTHEMES."/",
              'pesan'   => 'Password tidak sesuai',
              'field'   => array('memuname' => $this->input->post('memuname'))
            ));
        $this->template
          ->set_layout('login')
          ->build('main');
      }
		}
	}
  function forgot_password(){
    if($this->input->post()){
      $new_password = random_string('alnum',8);
      $enpass = $this->encrypt->encode($new_password);
      $email_user = $this->global_models->get("m_users", array("email" => $this->input->post("email")));
      if($email_user){
        $this->global_models->update('m_users', array("id_users" => $email_user[0]->id_users),array('pass' => $enpass));

        //kirim email
        $this->load->library('email');
        $this->email->initialize($this->global_models->email_conf());
        $this->email->from('no-reply@antavaya.co.id', 'Administrator');
        $this->email->to($email_user[0]->email);
        $this->email->bcc('nugroho.budi@antavaya.com');

        $this->email->subject('Notifikasi Perubahan Password');
        $this->email->message("
          Berikut akses users untuk antavaya: <br />
          link => ".site_url("login")." <br />
          user => {$email_user[0]->email} <br />
          pass => {$new_password}
          ");

        if($this->email->send() === TRUE){
          $pesan = "New Password has been send to your mail";
        }
        else{
          $pesan = "Password has been changed, but the email delivery fails. Please contact your admin";
        }
      }
      else{
        $pesan = "Your e-mail has not been registered";
      }
    }
    
    $this->template->build('forgot-password', 
    array(
          'url'         => base_url()."themes/".DEFAULTTHEMES."/",
          'pesan'       => $pesan
        ));
    $this->template
      ->set_layout('login')
      ->build('forgot-password');
  }
  
  
}