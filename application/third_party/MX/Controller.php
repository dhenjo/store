<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/** load the CI class for Modular Extensions **/
require dirname(__FILE__).'/Base.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library replaces the CodeIgniter Controller class
 * and adds features allowing use of modules and the HMVC design pattern.
 *
 * Install this file as application/third_party/MX/Controller.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Controller 
{
	public $autoload = array();
	
	public function __construct() 
	{
		$class = str_replace(CI::$APP->config->item('controller_suffix'), '', get_class($this));
		log_message('debug', $class." MX_Controller Initialized");
		Modules::$registry[strtolower($class)] = $this;	
		
		/* copy a loader instance and initialize */
		$this->load = clone load_class('Loader');
		$this->load->initialize($this);	
		
		/* autoload module items */
		$this->load->_autoloader($this->autoload);
    
    $this->load->helper('form');
    
    $this->load->library('template');
	}
	
	public function __get($class) {
		return CI::$APP->$class;
	}
  public function cek($spesial = ""){
    if($spesial == "spesial"){
      $id_affiliate = $this->input->get('a');
      if($id_affiliate){
        $affiliate = array(
            'name'   => 'affiliate',
            'value'  => $id_affiliate,
            'expire' => '86500'
        );
        $this->input->set_cookie($affiliate);
      }
    }
    if($this->session->userdata('logged_in') === true){
//      $this->debug($this->privilege_page(), true);
//      die($this->privilege_page());
      if($this->privilege() === false AND $this->session->userdata('id') != 1){
//        die('dsgsdg');
        redirect($this->session->userdata('dashbord'));
      }
      else if($this->privilege_page() === false AND $this->session->userdata('id') != 1){
//        die('2ds343');
        redirect($this->session->userdata('dashbord'));
      }
      else{
        return true;
      }
    }
    else{
      if($spesial == "spesial")
        return true;
      else
        redirect("login");
    }
  }
  public function privilege_page(){
    $query = "
      SELECT A.id_privilege_page FROM 
      d_privilege_page as A 
      JOIN m_page as B ON A.id_page = B.id_page
      JOIN m_controller as C ON B.id_controller = C.id_controller
      WHERE 
      A.id_privilege = '".$this->session->userdata('id_privilege')."' AND
      B.link = '".$this->router->fetch_method()."' AND
      C.link = '".$this->router->fetch_class()."'
      GROUP BY A.id_privilege_page
      ";
//    $this->debug($query);
    $til = $this->global_models->get_query($query);
    if($til){
      return true;
    }
    else {
      return false;
    }
  }
  public function privilege(){
//    print $this->router->fetch_class().'<br />';
//    print $this->router->fetch_method();die;
    $id_module = $this->global_models->get_field("m_module", "id_module", array("name" => $this->uri->segment(1, 0)));
//    print $this->session->userdata('dashbord');die;
//    print_r(array(
//                "id_privilege" => $this->session->userdata('id_privilege'),
//                "id_module" =>  $id_module));die;
    if($this->global_models->get_field("d_privilege_module", "id_privilege_module", 
            array(
                "id_privilege" => $this->session->userdata('id_privilege'),
                "id_module" =>  $id_module
                    )) > 0){
      return true;
    }
    else {
      return false;
    }
  }
  public function debug($option = "", $die = false){
    print '<pre>';
    print_r($option);
    print '</pre>';
    if($die === true)
      die;
  }
}