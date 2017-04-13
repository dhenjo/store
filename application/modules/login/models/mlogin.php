<?php
class Mlogin extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get($memuname){
      $this->db->where("email", $memuname);
      $this->db->where("id_status_user", 1);
      $users = $this->db->get("m_users")->row();
      if($users)
        return $users;
      else
        return false;
    }
    function get_email($memuname){
      $this->db->where("email", $memuname);
      $this->db->where("id_status_user", 1);
      $users = $this->db->get("m_users")->row();
      if($users)
        return $users;
      else
        return false;
    }
    function cek_login($memuname, $mempass){
      $users = $this->get($memuname);
      if(!$users){
        $users = $this->get_email($memuname);
      }
//      $this->db->where("name", $memuname);
//      $this->db->where("sandi", md5($mempass));
//      $hasil = $this->db->get("users")->row();
//      print_r($mempass);
//      if(is_object($hasil)){
      if($users !== false){
        if($mempass == $this->encrypt->decode($users->pass)){
          $this->db->select("id_user_privilege, id_privilege");
          $this->db->where("id_users", $users->id_users);
          $priv = $this->db->get("d_user_privilege")->row();
          if(!$priv){
            $priv = (object) array('id_user_privilege' => "", 'id_privilege' => 0);
          }
//          $id_portal_company = $this->global_models->get_field("portal_company_users", "id_portal_company", array("id_users" => $users->id_users));
          $pame = array(
            "users"               => USERSSERVER,
            "password"            => PASSSERVER,
            "id_users"            => $users->id_users,
          );
          $pameran = $this->global_variable->curl_mentah($pame, URLSERVER."json/json-tour/pameran-users-get-detail");
          $pameran_array = json_decode($pameran);
          
          $newdata = array(
            'name'  => $users->name,
            'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($users->name),
            'epass'  => substr(md5(date("d")), -5).$users->pass,
            'email'     => $users->email,
            'id'     => $users->id_users,
            'outlet'     => 0,
            'privilege'     => $priv->id_user_privilege,
            'id_privilege'     => $priv->id_privilege,
            'dashbord'     => $this->global_models->get_field("m_privilege", "dashbord", array("id_privilege" => $priv->id_privilege)),
//            'id_portal_company' => $id_portal_company,
//            'id_portal_company_position' => $this->global_models->get_field("portal_company_users", "id_portal_company_position", array("id_users" => $users->id_users)),
//            'company_nicename' => $this->global_models->get_field("portal_company", "nicename", array("id_portal_company" => $id_portal_company)),
			'id_store' => $this->global_models->get_field("store_users", "id_store", array("id_users" => $users->id_users)),
            'id_store_region' => $this->global_models->get_field("store_region_users", "id_store_region", array("id_users" => $users->id_users)),
            'id_tour_pameran'  => $pameran_array->data->id_tour_pameran,
            'logged_in' => TRUE
          );
          $this->session->set_userdata($newdata);
          return true;
        }
        else
          return false;
      }
      else{
        
        $post = array(
          "users"               => USERSSERVER,
          "password"            => PASSSERVER,
          "name"                => $memuname,
          "pass"                => $mempass,
        );
        $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-series/login");
        $data_array = json_decode($data);
        if($data_array->status == 2){
          $pame = array(
            "users"               => USERSSERVER,
            "password"            => PASSSERVER,
            "id_users"            => $data_array->data->id_users,
          );
          $pameran = $this->global_variable->curl_mentah($pame, URLSERVER."json/json-tour/pameran-users-get-detail");
          $pameran_array = json_decode($pameran);
          
          $newdata = array(
            'name'  => $data_array->data->name,
            'ename'  => substr(md5(date("d")), 0, 5).$this->encrypt->encode($data_array->data->name),
            'epass'  => substr(md5(date("d")), -5).$data_array->data->pass,
            'email'     => $data_array->data->email,
            'id'     => $data_array->data->id_users,
//            'outlet'     => 0,
//            'privilege'     => $priv->id_user_privilege,
            'id_privilege'     => $data_array->data->id_privilege,
            'id_tour_pameran'  => $pameran_array->data->id_tour_pameran,
            'dashbord'     => "home",
            'logged_in' => TRUE
          );
          $this->session->set_userdata($newdata);
          return true;
        }
        else
          return false;
      }
    }
    function forget_password($email){
      $users = $this->get_email($email);
//      $this->db->where("name", $memuname);
//      $this->db->where("sandi", md5($mempass));
//      $hasil = $this->db->get("users")->row();
//      print_r($mempass);
//      if(is_object($hasil)){
      if($users !== false){
        $kirim = array(
            "pass"              => $this->encrypt->encode(random_string('alnum',8)),
            "id_status_user"    => $rand = rand(500, 999),
            "email"             => $users->email,
        );
        $this->db->update("m_users", $kirim, array("id_users" => $users->id_users));
        $kirim['id_users'] = $users->id_users;
        return $kirim;
      }
      else
        return false;
    }
}
?>
