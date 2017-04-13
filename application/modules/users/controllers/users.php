<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MX_Controller {
  function __construct() {
    $this->load->library('PHPExcel');
    $this->load->library('encrypt');
    $this->load->model('users/musers');
    $this->load->helper('string');
    $this->menu = $this->cek();
  }
	public function add_new($id = 0, $pesan = "hal"){
    $this->template->title('Sistem', "Users Edit");
    $data_privilege = 0;
    $data_user_privilege = 0;
    if($id > 0){
      $data_detail = $this->musers->get_detail($id);
      $data_privilege = $this->global_models->get_field("d_user_privilege", "id_privilege", array("id_users" => $id));
      $data_user_privilege = $this->global_models->get_field("d_user_privilege", "id_user_privilege", array("id_users" => $id));
//      $this->debug($data_privilege, true);
    }
    else{
      $data_detail->name = "";
      $data_detail->email = "";
      $data_detail->id_status_user = "";
      $data_detail->id_users = "";
    }
    if(!$this->input->post(NULL, TRUE)){
      $dropdown = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name", TRUE, array("parent > " => 0));
      $store_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
      );
      $store = $this->antavaya_lib->curl_mentah($store_post, URLSERVER."json/json-tour/get-all-store-region");  
      $store_array = json_decode($store);
      if($store_array->status == 2){
        $store_dd[NULL] = "- Pilih -";
        foreach($store_array->data AS $sd){
          $store_dd[$sd->id_store_region] = $sd->title;
        }
      }
      $store_post2 = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
      );
      $store2 = $this->antavaya_lib->curl_mentah($store_post2, URLSERVER."json/json-midlle-system/get-all-store");  
      $store_array2 = json_decode($store2);
//      $this->debug($store_array2, true);
      if($store_array2->status == 2){
        $store_dd2[NULL] = "- Pilih -";
        foreach($store_array2->data AS $sd2){
          $store_dd2[$sd2->id_store] = $sd2->title;
        }
      }
      
      $store_set = $this->global_models->get_field("store_users", "id_store", array("id_users" => $id));
      $store_region_set = $this->global_models->get_field("store_region_users", "id_store_region", array("id_users" => $id));
      
      $this->template->build('add-new', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users',
              'title'   => 'Add User',
              'detail'  => array($data_detail),
              'dropdown'  => array($dropdown),
              'selectd'  => array($data_privilege),
              'id_relasi'  => array($data_user_privilege),
              'store_region'  => $store_dd,
              'store'  => $store_dd2,
              'store_set' => $store_set,
              'store_region_set' => $store_region_set,
              'breadcrumb'  => array(
                    "Users"  => "users"
                ),
            ));
      $this->template
        ->set_layout('default')
        ->build('add-new');
    }
    else{
      if($this->input->post("id_detail", TRUE)){
        $kirim = array(
            'name'            =>  $this->input->post("name", TRUE),
            'email'           =>  $this->input->post("email", TRUE),
            'id_status_user'  =>  $this->input->post("status", TRUE),
            'update_by_users' =>  $this->session->userdata("id"),
            'users'           =>  USERSSERVER,
            'password'        =>  PASSSERVER,
            'id_privilege'    =>  $this->input->post("privilege", TRUE),
            'id_users'        =>  $this->input->post("id_detail", TRUE)
        );
        if($this->input->post("pass", TRUE)){
          if($this->input->post("pass", TRUE) == $this->input->post("repass", TRUE)){
            $kirim['pass'] = $this->encrypt->encode($this->input->post("pass", TRUE));
          }
        }
        
        $users_channel = $this->antavaya_lib->curl_mentah($kirim, URLSERVER."json/json-midlle-system/update-users");
        $data_array = json_decode($users_channel);
        if($data_array->status == 2){
          unset($kirim['id_privilege']);
          unset($kirim['users']);
          unset($kirim['password']);
          unset($kirim['id_users']);
          $hasil_in = $this->global_models->update("m_users", array("id_users" => $this->input->post("id_detail", TRUE)), $kirim);
          
          if($this->input->post('store')){
            $this->global_models->delete("store_users", array("id_users" => $this->input->post("id_detail", TRUE)));
            $this->global_models->insert("store_users", array("id_users" => $this->input->post("id_detail", TRUE), "id_store" => $this->input->post('store')));
          }
          if($this->input->post('store_region')){
            $this->global_models->delete("store_region_users", array("id_users" => $this->input->post("id_detail", TRUE)));
            $this->global_models->insert("store_region_users", array("id_users" => $this->input->post("id_detail", TRUE), "id_store_region" => $this->input->post('store_region')));
          }

          if($this->input->post("privilege", TRUE) != 0){
            $hasil_pr = $this->global_models->update_duplicate("d_user_privilege", 
                    array(
                        "id_user_privilege" => $this->input->post("id_relasi", TRUE),
                        "id_privilege"  =>  $this->input->post("privilege", TRUE),
                        "id_users"  =>  $this->input->post("id_detail", TRUE),
                        "update_by_users" => $this->session->userdata('id')
                        ), 
                    array("id_privilege" => $this->input->post("privilege", TRUE)));
          }
        }
      }
      else{
        $pst = $this->input->post(NULL, TRUE);
//        $pst = $pst['addressform']['addressform'][0];
//        if(is_array($pst['name'])){
//          foreach($pst['name'] as $key => $pst_name){
        if($pst['pass'] == $pst['repass']){
          $kirim = array(
              'users'           =>  USERSSERVER,
              'password'        =>  PASSSERVER,
              'name'            =>  $pst['name'],
              'pass'            =>  $this->encrypt->encode($pst['pass']),
              'email'           =>  $pst['email'],
              'id_status_user'  =>  $pst['status'],
              'id_privilege'    =>  $pst['privilege'],
              "create_by_users" =>  $this->session->userdata('id'),
              "create_date"     =>  date("Y-m-d H:i:s"),
          );
          $users_channel = $this->antavaya_lib->curl_mentah($kirim, URLSERVER."json/json-midlle-system/set-users");
          $data_array = json_decode($users_channel);
          if($data_array->status == 2){
            if($pst['store']){
              $this->global_models->insert("store_users", array("id_users" => $data_array->id_users, "id_store" => $pst['store']));
            }
            if($pst['store_region']){
              $this->global_models->insert("store_region_users", array("id_users" => $data_array->id_users, "id_store_region" => $pst['store_region']));
            }
            $kirim['id_users'] = $data_array->id_users;
            unset($kirim['id_privilege']);
            unset($kirim['users']);
            unset($kirim['password']);
            $hasil_in = $this->global_models->insert("m_users", $kirim);
            if($pst['privilege'] > 0){
              $kirim_privilege = array(
                  'id_privilege'    =>  $pst['privilege'],
                  'id_users'        =>  $hasil_in,
              );
              $hasil_pr = $this->global_models->insert("d_user_privilege", $kirim_privilege);
            }
          }
        }
      }
      if($hasil_in){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect ("users");
    }
  }
	public function delete($id){
    if($this->musers->change_status($id, 3))
      redirect("users/index/list/sukses");
    else
      redirect("users/index/list/filed");
  }
	public function status($id, $status){
    if($this->musers->change_status($id, $status))
      redirect("users/index/list/sukses");
    else
      redirect("users/index/list/filed");
  }
	public function export_xls(){
    $this->musers->export_xls("data-users");
  }
  
//	public function index($action = "list", $pesan = "hal", $hal = 0){
//    $list = $this->musers->get();
//    
//    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
//    
//    $foot = "
//      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
//      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
//      ";
//    $foot .= '
//            <script type="text/javascript">
//                $(function() {
//                    $("#tableboxy").dataTable();
//                });
//            </script>';
//    $menutable = "<li><a href='".site_url("users/add-new")."'><i class='icon-plus'></i> Add New</a></li>";
//    $this->template->build('main', 
//      array(
//            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
//            'menu'        => 'users',
//            'data'    => $list,
//            'title'   => "Users",
//            'foot'    => $foot,
//            'css'     => $css,
//            'menutable'   => $menutable,
//          ));
//    $this->template
//      ->set_layout('datatables')
//      ->build('main');
//	}
  
  function index(){
	  $pst = $this->input->post();
    if($pst){
      $set_sess = array(
        "users_name"         => $pst['name'],
      );
      $this->session->set_userdata($set_sess);
    }
    if($this->session->userdata("users_name")){
      $where .= " AND (LOWER(name) LIKE '%".strtolower($this->session->userdata("users_name"))."%'"
        . " OR LOWER(email) LIKE '%".strtolower($this->session->userdata("users_name"))."%')";
    }
    
//    if($this->session->userdata("users_status")){
//      $where .= " AND id_status_user = '{$this->session->userdata("users_status")}'";
//    }
    
    $jl = $this->global_models->get_query("SELECT count(id_users) AS jml"
      . " FROM m_users"
      . " WHERE 1 = 1 "
      . " {$where}");
//      $aa = $this->db->last_query();
      $jumlah_list = $jl[0]->jml;
//      print_r($aa); die;
//    $jumlah_list = $this->global_models->get_field("m_users", "count(id_users)", array());
    
    //$jumlah_list = $this->global_models->get_field("m_users", "count(id_users)", array());
    
    $url_list = site_url("users/ajax-users/".$jumlah_list);
    $url_list_halaman = site_url("users/ajax-halaman-users/".$jumlah_list);
    $foot = <<<EOD
      <script>
            
            function get_list(start){
                  if(typeof start === "undefined"){
                    start = 0;
                  }
                  $.post('{$url_list}/'+start, function(data){
                    $("#data_list").html(data);
                    $.post('{$url_list_halaman}/'+start, function(data){
                      $("#halaman_set").html(data);
                    });
                  });
            }
            get_list(0);
      </script>
EOD;

    $menutable = "<li><a href='".site_url("users/add-new")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build('main', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'users',
            'title'   => "Users",
            'foot'    => $foot,
            'css'     => $css,
            'menutable'   => $menutable,
            'menu_action' => 5
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('main');

  }
  
  public function edit_profile($pesan = "hal"){
    $id = $this->session->userdata("id");
    $this->template->title('Sistem', "Users Edit");
    $data_privilege = 0;
    $data_user_privilege = 0;
    if($id > 0){
      $data_detail = $this->musers->get_detail($id);
      $data_privilege = $this->global_models->get_field("d_user_privilege", "id_privilege", array("id_users" => $id));
      $data_user_privilege = $this->global_models->get_field("d_user_privilege", "id_user_privilege", array("id_users" => $id));
//      $this->debug($data_privilege, true);
    }
    else{
      $data_detail->name = "";
      $data_detail->email = "";
      $data_detail->id_status_user = "";
      $data_detail->id_users = "";
    }
    if(!$this->input->post(NULL, TRUE)){
      $dropdown = $this->global_models->get_dropdown("m_privilege", "id_privilege", "name");
      $this->template->build('edit-profile', 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users',
              'title'   => 'Add User',
              'detail'  => array($data_detail),
              'dropdown'  => array($dropdown),
              'selectd'  => array($data_privilege),
              'id_relasi'  => array($data_user_privilege),
            ));
      $this->template
        ->set_layout('default')
        ->build('edit-profile');
    }
    else{
      if($this->input->post("id_detail", TRUE)){
        $kirim = array(
            'email'           =>  $this->input->post("email", TRUE)
        );
        if($this->input->post("pass", TRUE)){
          if($this->input->post("pass", TRUE) == $this->input->post("repass", TRUE)){
            $kirim['pass'] = $this->encrypt->encode($this->input->post("pass", TRUE));
          }
        }
        $hasil_in = $this->musers->update_user($this->input->post("id_detail", TRUE), $kirim);
        if($hasil_in){
          redirect ($this->session->userdata('dashbord'));
        }
        else
          redirect ($this->session->userdata('dashbord'));
      }
    }
  }
  
  public function generate_password($id_users) {
      
      $new_password = random_string('alnum',8);
      $enpass = $this->encrypt->encode($new_password);
      $email_user = $this->global_models->get("m_users", array("id_users" => $id_users));
      if($id_users > 0) {
        $this->global_models->update('m_users', array("id_users" => $id_users),array('pass' => $enpass));
                
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
          redirect ("users");
        }
        else
          redirect ("home");
      }
      
  }
  public function email_pass($id_users) {
      $email_user = $this->global_models->get("m_users", array("id_users" => $id_users));
      if($id_users > 0) {
                
        //kirim email
        $this->email->from('no-reply@technomotor.co.id', 'Aplikasi Mr.Montir');
        $this->email->to($email_user[0]->email);

        $this->email->subject('Notifikasi Perubahan Password');
        $this->email->message("
          Berikut adalah akunt untuk akses Outlet Monitoring :
          link => ".base_url()."
          user => {$email_user[0]->name}
          pass => ".$this->encrypt->decode($email_user[0]->pass)."
          ");

        if($this->email->send() === TRUE){
          redirect ("users");
        }
        else
          redirect ("home");
      }
  }
  public function generate_password_no_mail($id_users) {
      $new_password = random_string('alnum',8);
      $enpass = $this->encrypt->encode($new_password);
      $email_user = $this->global_models->get("m_users", array("id_users" => $id_users));
      if($id_users > 0) {
        $this->global_models->update('m_users', array("id_users" => $id_users),array('pass' => $enpass));
        
        redirect ("outlet/master-outlet");
        
      }
  }
  
  function auto_users(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM m_users
      WHERE 
      LOWER(name) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_users,
            "label" => $tms->name,
            "value" => $tms->name,
        );
      }
    }
    else{
      $result[] = array(
          "id"    => 0,
          "label" => "No Found",
          "value" => "No Found",
      );
    }
    echo json_encode($result);
    die;
  }
  
  public function biodata($id_users){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("hrm_prospective_biodata", array("id_users" => $id_users));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {

              $( '#frm_account' ).autocomplete({
                source: '".site_url("frm/portal-frm/auto-account-company")."',
                minLength: 1,
                select: function( event, ui ) {
                  $('#id_frm_account').val(ui.item.id);
                }
              });

              CKEDITOR.replace('editor1');
              CKEDITOR.replace('editor2');
              CKEDITOR.replace('editor3');
              
              $( '#tanggal_lahir' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            });
        </script>
        ";
      
      $this->template->build("biodata", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users',
              'title'       => "Biodata",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Users"  => "users"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("biodata");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/hrm/prospective_employee/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '700';
      $config['max_height']  = '700';

      $this->load->library('upload', $config);
      
      if($_FILES['photo']['name']){
        if (  $this->upload->do_upload('photo')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("users/biodata/$id_users")."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_hrm_prospective_biodata']){
        $kirim = array(
            "id_users"              => $id_users,
            "id_frm_account"        => $pst['id_frm_account'],
            "title"                 => $pst['title'],
            "first_name"            => $pst['first_name'],
            "last_name"             => $pst['last_name'],
            "sex"                   => $pst['sex'],
            "tinggi_badan"          => $pst['tinggi_badan'],
            "berat_badan"           => $pst['berat_badan'],
            "tempat_lahir"          => $pst['tempat_lahir'],
            "tanggal_lahir"         => $pst['tanggal_lahir'],
            "address"               => $pst['address'],
            "telphone"              => $pst['telphone'],
            "handphone"             => $pst['handphone'],
            "email"                 => $pst['email'],
            "status_tinggal"        => $pst['status_tinggal'],
            "card_id"               => $pst['card_id'],
            "about_us"              => $pst['about_us'],
            "note"            => $pst['note'],
            "shipping"              => $pst['shipping'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['photo'] = $data['upload_data']['file_name'];
        }
        $id_hrm_prospective_biodata = $this->global_models->update("hrm_prospective_biodata", array("id_hrm_prospective_biodata" => $pst['id_hrm_prospective_biodata']),$kirim);
      }
      else{
        $kirim = array(
            "id_users"              => $id_users,
            "id_frm_account"        => $pst['id_frm_account'],
            "title"                 => $pst['title'],
            "first_name"            => $pst['first_name'],
            "last_name"             => $pst['last_name'],
            "sex"                   => $pst['sex'],
            "tinggi_badan"          => $pst['tinggi_badan'],
            "berat_badan"           => $pst['berat_badan'],
            "tempat_lahir"          => $pst['tempat_lahir'],
            "tanggal_lahir"         => $pst['tanggal_lahir'],
            "address"               => $pst['address'],
            "telphone"              => $pst['telphone'],
            "handphone"             => $pst['handphone'],
            "email"                 => $pst['email'],
            "status_tinggal"        => $pst['status_tinggal'],
            "card_id"               => $pst['card_id'],
            "about_us"              => $pst['about_us'],
            "note"            => $pst['note'],
            "shipping"              => $pst['shipping'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['photo'] = $data['upload_data']['file_name'];
        }
        $id_hrm_prospective_biodata = $this->global_models->insert("hrm_prospective_biodata", $kirim);
      }
      if($id_hrm_prospective_biodata){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("users");
    }
  }
  
  function ajax_users($total = 0, $start = 0){
    
	 if($this->session->userdata("users_name")){
      $where .= " AND (LOWER(A.name) LIKE '%".strtolower($this->session->userdata("users_name"))."%'"
        . " OR LOWER(A.email) LIKE '%".strtolower($this->session->userdata("users_name"))."%')";
    }
    
//    if($this->session->userdata("users_status")){
//      $where .= " AND A.id_status_user = '{$this->session->userdata("users_status")}'";
//    }
//    
    $users = $this->global_models->get_query("SELECT A.* "
      . " FROM m_users AS A "
      . " WHERE 1=1 "
      ."{$where}"
      . " ORDER BY name LIMIT {$start}, 10");
     
    $status = array(
        0 => "<span class='label label-warning'>Non-Active</span>",
        1 => "<span class='label label-success'>Active</span>",
        2 => "<span class='label label-warning'>Non-Active</span>",
    );
    foreach($users AS $users){
      $hasil .= "<tr>"
        . "<td>{$users->name}</td>"
        . "<td>{$users->email}</td>"
        . "<td>{$users->point}</td>"
        . "<td>{$status[$users->id_status_user]}</td>"
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
          . "<li><a href='".site_url("users/add-new/".$users->id_users)."'>Edit</a></li>"
          . "<li><a href='".site_url("users/generate-password/".$users->id_users)."'>Generate Password</a></li>"
          . "<li><a href='".site_url("users/email-pass/".$users->id_users)."'>Email Password</a></li>"
          . "<li><a href='".site_url("users/biodata/".$users->id_users)."'>Biodata</a></li>"
          . "<li><a href='".site_url("users/history-point/".$users->id_users)."'>History Point</a></li>"
          . "</ul>"
          . "</div>"
        . "</td>"
        . "</tr>";
    }
    
    print $hasil;
    die;
  }
  
  function ajax_halaman_users($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 10; 
    $config['uri_segment'] = 4; 
    $config['cur_tag_open'] = "<li class='active'><a href='javascript:void(0)'>"; 
    $config['cur_tag_close'] = "</a></li>"; 
    $config['first_tag_open'] = "<li>"; 
    $config['first_tag_close'] = "</li>"; 
    $config['last_tag_open'] = "<li>"; 
    $config['last_tag_close'] = "</li>"; 
    $config['next_tag_open'] = "<li>"; 
    $config['next_tag_close'] = "</li>"; 
    $config['prev_tag_open'] = "<li>"; 
    $config['prev_tag_close'] = "</li>"; 
    $config['num_tag_open'] = "<li>"; 
    $config['num_tag_close'] = "</li>";
    $config['function_js'] = "get_list";
    $this->pagination->initialize($config); 
    
      print "<ul id='halaman_delete' class='pagination pagination-sm no-margin pull-right'>"
    . "{$this->pagination->create_links_ajax()}"
    . "</ul>";
    die;
  }
  
  function history_point($id_users){
    $list = $this->global_models->get_query("SELECT A.*"
      . " FROM portal_point_history AS A");
    
    $menutable = '
      <li><a href="'.site_url("users/add-history-point").'"><i class="icon-plus"></i> Add History Point</a></li>
      ';
    $this->template->build('history-point', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "users",
            'data'        => $list,
            'title'       => lang("portal_history_point"),
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('history-point');
  }
  
  function detail_biodata(){
    $id_users = $this->session->userdata("id");
    $biodata = $this->global_models->get("hrm_prospective_biodata", array("id_users" => $this->session->userdata("id")));
    if($this->session->userdata("id_portal_company")){
      $company = $this->global_models->get_query("SELECT A.*, B.title AS bidang_usaha, C.title AS propinsi"
        . " FROM portal_company AS A"
        . " LEFT JOIN portal_bidang_usaha AS B ON A.id_portal_bidang_usaha = B.id_portal_bidang_usaha"
        . " LEFT JOIN portal_lokasi AS C ON A.id_portal_lokasi = C.id_portal_lokasi"
        . " WHERE A.id_portal_company = {$this->session->userdata("id_portal_company")}");
    }
    $this->template->build('detail-biodata', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "users/detail-biodata",
            'title'       => lang("portal_detail_biodata"),
            'biodata'     => $biodata,
            'company'     => $company
          ));
    $this->template
      ->set_layout('default')
      ->build('detail-biodata');
  }
  
  function edit_biodata(){
    if($this->input->post()){
      $pst = $this->input->post();
      
      $config['upload_path'] = './files/hrm/prospective_employee/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_width']  = '700';
      $config['max_height']  = '700';

      $this->load->library('upload', $config);
      $this->load->library('manimage');
      
      if($_FILES['photo']['name']){
        if (  $this->upload->do_upload('photo')){
          $data = array('upload_data' => $this->upload->data());
          $this->manimage->load('./files/hrm/prospective_employee/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(270); 
          $this->manimage->save('./files/hrm/prospective_employee/270/'.$data['upload_data']['file_name']);

          $this->manimage->load('./files/hrm/prospective_employee/'.$data['upload_data']['file_name']); 
          $this->manimage->resizeToWidth(50); 
          $this->manimage->save('./files/hrm/prospective_employee/50/'.$data['upload_data']['file_name']);
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("portal/master-portal/add-new-company/".$id_portal_company)."'>Back</a>";
          die;
        }
      }
      
      if($pst['id_hrm_prospective_biodata']){
        $kirim = array(
          "id_users"                  => $this->session->userdata("id"),
          "title"                     => $pst['title'],
          "first_name"                => $pst['first_name'],
          "last_name"                 => $pst['last_name'],
          "sex"                       => $pst['sex'],
          "tinggi_badan"              => $pst['tinggi_badan'],
          "berat_badan"               => $pst['berat_badan'],
          "tempat_lahir"              => $pst['tempat_lahir'],
          "tanggal_lahir"             => $pst['tanggal_lahir'],
          "address"                   => $pst['address'],
          "telphone"                  => $pst['telphone'],
          "handphone"                 => $pst['handphone'],
          "status_tinggal"            => $pst['status_tinggal'],
          "card_id"                   => $pst['card_id'],
          "about_us"                  => $pst['about_us'],
          "note"                      => $pst['note'],
          "update_by_users"           => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['photo'] = $data['upload_data']['file_name'];
        }
        
        $id_hrm_prospective_biodata = $this->global_models->update("hrm_prospective_biodata", array("id_hrm_prospective_biodata" => $pst['id_hrm_prospective_biodata']), $kirim);
      }
      else{
        $kirim = array(
          "id_users"                  => $this->session->userdata("id"),
          "title"                     => $pst['title'],
          "first_name"                => $pst['first_name'],
          "last_name"                 => $pst['last_name'],
          "sex"                       => $pst['sex'],
          "tinggi_badan"              => $pst['tinggi_badan'],
          "berat_badan"               => $pst['berat_badan'],
          "tempat_lahir"              => $pst['tempat_lahir'],
          "tanggal_lahir"             => $pst['tanggal_lahir'],
          "address"                   => $pst['address'],
          "telphone"                  => $pst['telphone'],
          "handphone"                 => $pst['handphone'],
          "status_tinggal"            => $pst['status_tinggal'],
          "card_id"                   => $pst['card_id'],
          "about_us"                  => $pst['about_us'],
          "note"                      => $pst['note'],
          "create_by_users"           => $this->session->userdata("id"),
          "create_date"               => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['photo'] = $data['upload_data']['file_name'];
        }
        
        $id_hrm_prospective_biodata = $this->global_models->insert("hrm_prospective_biodata", $kirim);
      }
      
      if($id_hrm_prospective_biodata){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("users/detail-biodata");
      
    }
    else{
      $detail = $this->global_models->get("hrm_prospective_biodata", array("id_users" => $this->session->userdata("id")));
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor1');
              CKEDITOR.replace('editor2');
              CKEDITOR.replace('editor3');
              
              $( '#tanggal_lahir' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            });
        </script>
        ";
      $this->template->build("biodata", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'users/detail-biodata',
              'title'       => "Form Biodata",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Biodata"  => "users/detail-biodata"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("biodata");
    }
  }
  
  function import_users(){
    $users = $this->global_models->get_query("SELECT A.*, B.id_privilege"
      . " FROM m_users AS A"
      . " LEFT JOIN d_user_privilege AS B ON A.id_users = B.id_users");
    foreach($users AS $us){
      $kirim = array(
          'users'           =>  USERSSERVER,
          'password'        =>  PASSSERVER,
          'name'            =>  $us->name,
          'pass'            =>  $us->pass,
          'email'           =>  $us->email,
          'id_status_user'  =>  $us->id_status_user,
          'id_privilege'    =>  $us->id_privilege,
          "create_by_users" =>  $us->create_by_users,
          "create_date"     =>  $us->create_date,
      );
      $users_channel = $this->antavaya_lib->curl_mentah($kirim, URLSERVER."json/json-midlle-system/set-users");
    }
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */