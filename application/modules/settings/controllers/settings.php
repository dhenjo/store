<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MX_Controller {
    
  function __construct() {      
    
    $this->load->library('template');
    $this->load->library('form_eksternal');
    $this->load->library('global_models');
    $this->load->library('PHPExcel');
    $this->load->library('encrypt');
    $this->load->helper('path');
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('parser');
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->library('pagination');
    $this->menu = $this->cek();
    
//    $this->debug($this->menu, true);
  }
	public function index(){
    $this->template->build("main", 
      array(
            'title_table' => "Settings",
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings',
          ));
    $this->template
      ->set_layout('default')
      ->build("main");
	} 
	public function get_module(){
    $dir = "application/modules";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          if($file != "."  AND $file != ".."){
            $cek = $this->global_models->get_field("m_module", "id_module", array("name" => $file));
            if($cek < 1){
              $this->global_models->insert("m_module", array(
                "name"            => $file,
                "desc"            => ucfirst($file),
                "status"          => 0,
                "create_by_users" => $this->session->userdata("id"),
                "create_date"     => date("Y-m-d H:i:s")
              ));
            }
          }
        }
        closedir($dh);
      }
    }
    
    redirect("settings/module");
  }
  
	public function get_controller($id_module){
    $s_module = $this->global_models->get_field("m_module", "name", array("id_module" => $id_module));
    $dir = "application/modules/{$s_module}/controllers";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          $info = pathinfo("application/modules/{$s_module}/controllers/".$file);
          if($info['extension'] == "php"){
            $cek = $this->global_models->get_field("m_controller", "id_controller", array("link" => $info['filename']));
            if($cek < 1){
              $kirim = array(
                "id_module"           => $id_module,
                "name"                => ucfirst($info['filename']),
                "link"                => $info['filename'],
                "create_by_users"     => $this->session->userdata("id"),
                "create_date"         => date("Y-m-d H:i:s")
              );
              $this->global_models->insert("m_controller", $kirim);
            }
          }
        }
        closedir($dh);
      }
    }
    redirect("settings/module");
  }
  
	public function module(){
    $module = $this->global_models->get("m_module");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-module")."'><i class='icon-plus'></i> Add New</a></li>"
      . "<li><a href='".site_url("settings/get-module")."'><i class='icon-plus'></i> Get Module</a></li>";
    $this->template->build("module", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/module',
            'title'       => "Setting Module",
            'data'        => $module,
            'foot'        => $foot,
            'css'         => $css,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("module");
	}
	public function form(){
    $form = $this->global_models->get("m_form");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-form")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build("form", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/form',
            'title'       => "Setting Form",
            'data'        => $form,
            'css'         => $css,
            'foot'        => $foot,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("form");
	}
	public function control(){
    $control = $this->global_models->get_query("
      SELECT A.*, B.desc AS module
      FROM m_controller AS A
      LEFT JOIN m_module AS B ON A.id_module = B.id_module
      ");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= "
            <script type='text/javascript'>
                $(function() {
                    $('#tableboxy').dataTable();
                });
            </script>";
    $menutable = "<li><a href='".site_url("settings/add-new-control")."'><i class='icon-plus'></i> Add New</a></li>";
    $this->template->build("control", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/control',
            'title'       => "Setting Controller",
            'data'        => $control,
            'css'         => $css,
            'foot'        => $foot,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build("control");
	} 
	public function add_new_module($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_module", array("id_module" => $id_detail));
      $this->template->build("add-new-module", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/module',
              'title'       => "Create Module",
              'detail'      => $detail,
              'breadcrumb'  => array(
                    "Modules"  => "settings/module"
                ),
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-module");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "desc"            => $pst['desc'],
//            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_module = $this->global_models->update("m_module", array("id_module" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "desc"            => $pst['desc'],
//            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_module = $this->global_models->insert("m_module", $kirim);
      }
      if($id_module){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("settings/module");
    }
	}
	public function add_new_form($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_form", array("id_form" => $id_detail));
      $this->template->build("add-new-form", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/form',
              'title' => "Create Form",
              'detail' => $detail,
              'foot'        => ""
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-form");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"            => $pst['nicename'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_form = $this->global_models->update("m_form", array("id_form" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "nicename"            => $pst['nicename'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_form = $this->global_models->insert("m_form", $kirim);
      }
      if($id_form){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("settings/form");
    }
	}
	public function add_new_control($id_detail = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("m_controller", array("id_controller" => $id_detail));
      $this->template->build("add-new-control", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'settings/control',
              'title'   => "Create Controller",
              'detail' => $detail,
              'module'  => $this->global_models->get_dropdown("m_module", "id_module", "desc", FALSE),
            ));
      $this->template
        ->set_layout('default')
        ->build("add-new-control");
    }
    else{
      $pst = $this->input->post(NULL);
      if($pst['id_detail']){
        $kirim = array(
            "name"            => $pst['name'],
            "link"            => $pst['link'],
            "id_module"       => $pst['id_module'],
            "update_by_users" => $this->session->userdata("id"),
        );
        $id_controller = $this->global_models->update("m_controller", array("id_controller" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "name"            => $pst['name'],
            "link"            => $pst['link'],
            "id_module"       => $pst['id_module'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        $id_controller = $this->global_models->insert("m_controller", $kirim);
      }
      if($id_controller){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("settings/control");
    }
	}
  
  
  public function addrow_page(){
    $key = $this->input->post('no');
    $in = $this->form_eksternal->form_input("page[]");
    print <<<EOD
    <tr id='tr_{$key}'>
      <td>{$in}</td>
      <td><a href='#' class='remove-element' onclick='del_row_tambahan("tr_{$key}")' title='Remove' >Remove</a></td>
    </tr>
EOD;
    die;
  }
  public function page($id){
    $data_detail = $this->global_models->get("m_controller", array("id_controller" => $id));
    $module = $this->global_models->get("m_module", array("id_module" => $data_detail[0]->id_module));
    require_once 'application/modules/'.$module[0]->name.'/controllers/'.$data_detail[0]->link.'.php';
    $list_page = get_class_methods($data_detail[0]->link);  
//    $this->debug($list_page, true);
    foreach ($list_page as $value) {
      if($value[0] != "_"){
        if($this->global_models->get_field("m_page", "link", array("link" => $value, "id_controller" => $id)) === false){
//          die;
          $this->global_models->insert("m_page", array("id_controller" => $id, "link" => $value));
        }
      }
    }
    redirect("settings/control");
  }
  
  function store(){
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jQueryUI/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' type='text/css' />"
      . "<style>"
        . ".working{"
          . "background:url('".base_url()."themes/".DEFAULTTHEMES."/img/ajax-loader.gif') no-repeat right center;"
          . "background-size: 20px;"
        . "}"
      . "</style>";
      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.ui.autocomplete.min.js' type='text/javascript'></script>"
        . "<script>"
          . "$(function() {"
            . "$( '#privilege' ).autocomplete({"
              . "source: '".site_url("ajax/privilege")."',"
              . "minLength: 1,"
              . "search  : function(){ $(this).addClass('working');},"
              . "open    : function(){ $(this).removeClass('working');},"
              . "select: function( event, ui ) {"
                . "$('#id_privilege').val(ui.item.id);"
              . "}"
            . "});"
        . "});"
        . "</script>";
      
    $pst = $this->input->post();
    if($pst){
      $this->nbscache->put_tunggal("store", "privilege", $pst['id_privilege']);
    }
    
    $privilege = $this->nbscache->get_explode("store", "privilege");
    $detail = array(
      "id_privilege"      => $privilege[1]
    );
      
    $this->template->build("store", 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => 'settings/store',
            'title'       => "Store Settings",
            'detail'      => $detail,
            'foot'        => $foot,
            'css'         => $css
          ));
    $this->template
      ->set_layout('default')
      ->build("store");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */