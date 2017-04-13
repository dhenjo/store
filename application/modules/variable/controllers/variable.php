<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variable extends MX_Controller {
    
  function __construct() {
    $this->menu = $this->cek();
  }
  
  public function add_settings_patern($id_patern = 0){
    if($this->input->post()){
      $pst = $this->input->post();
      if($pst['id_detail']){
        $kirim = array(
            'EmployeeFirstName'         => $pst['EmployeeFirstName'],
            'id_hrm_prospective_biodata' => $pst['id_hrm_prospective_biodata'],
						'FingerPrintID'             => $pst['FingerPrintID'],
						'EmployeeID'                => $pst['EmployeeID'],
						'id_users'                  => $pst['id_users'],
            'EmployeeAddress'           => $pst['EmployeeAddress'],
						'EmployeeGender'            => $pst['EmployeeGender'],
            'status'                    => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_hrm_employee = $this->global_models->update("hrm_employee", array("id_hrm_employee" => $pst['id_detail']), $kirim);
      }
      else{
        $pisah = explode(",", $pst['note']);
        foreach ($pisah AS $psh){
          if(trim($psh)){
            $pisah_akhir = explode(":", $psh);
            $note_array[$pisah_akhir[0]] = $pisah_akhir[1];
          }
        }
        
        $kirim = array(
            'title'                     => $pst['title'],
            'table'                     => $pst['table'],
						'note'                      => serialize($note_array),
            "create_by_users"           => $this->session->userdata("id"),
            "create_date"               => date("Y-m-d H:i:s")
        );
        $id_patern = $this->global_models->insert("patern", $kirim);
      }
      if($id_patern){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("variable/settings-patern");
    }
    else{
      $patern = $this->global_models->get("patern", array("id_patern" => $id_patern));
//      $this->debug($employee, true);
      $this->template->build("add-settings-patern",
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'hrm/employee',
              'title'       => "Settings Variable Patern",
              'detail'      => $patern,
            ));
      $this->template
        ->set_layout('default')
        ->build("add-settings-patern");
    }
	}
	
  function settings_patern(){
    $patern = $this->global_models->get("patern");
    $this->template->build("settings-patern",
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'variable/settings-patern',
            'title'       => "Settings Variable Patern",
            'data'        => $patern
          ));
    $this->template
      ->set_layout('default')
      ->build("settings-patern");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */