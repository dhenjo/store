<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MX_Controller {
  function __construct() {
    $this->load->library('PHPExcel');
    $this->load->library('encrypt');
    $this->load->model('menu/mmenu');
    $this->menu = $this->cek();
  }
	public function add_new($id = 0, $pesan = "hal"){
    $this->template->title('Sistem', "Menu Edit");
    if($id > 0){
      $data_detail = $this->global_models->get("m_menu", array("id_menu" => $id));
//      $this->debug($data_detail, true);
    }
    else{
      $data_detail[0]->id_menu = 0;
      $data_detail[0]->name = "";
      $data_detail[0]->link = "";
      $data_detail[0]->id_menu_kategori = 0;
    }
    if(!$this->input->post(NULL, TRUE)){
      $kate = $this->global_models->get_dropdown("m_menu", "id_menu", "name", TRUE);
      $this->template->build('add-new', 
        array('message' => $pesan,
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "menu",
              'title'   => 'Add Menu',
              'kate'    => $kate,
              'detail'  => $data_detail,
              'breadcrumb'  => array(
                  "Menu"  => "menu"
              ),
            ));
      $this->template
        ->set_layout('default')
        ->build('add-new');
    }
    else{
      if($this->input->post("id_detail", TRUE)){
        $kirim = array(
              "name"                  =>  $this->input->post("name", TRUE),
              "link"                  =>  $this->input->post("link", TRUE),
              "parent"      =>  $this->input->post("parent", TRUE),
              "sort"        =>  $this->input->post("sort", TRUE),
              "icon"        =>  $this->input->post("icon", TRUE),
              "update_by_users"       =>  $this->session->userdata('id')
          );
        $hasil_in = $this->global_models->update("m_menu", array("id_menu" => $this->input->post("id_detail", TRUE)), $kirim);
      }
      else{
        $pst = $this->input->post(NULL, TRUE);
//        $pst = $pst['addressform']['addressform'][0];
        if($pst['name']){
          $kirim = array(
              "name"                  =>  $pst['name'],
              "link"                  =>  $pst['link'],
              "parent"      =>  $pst['parent'],
              "sort"      =>  $pst['sort'],
              "icon"        =>  $this->input->post("icon", TRUE),
              "create_by_users"       =>  $this->session->userdata('id'),
              "create_date"           =>  date("Y-m-d H:i:s"),
              "update_by_users"       =>  $this->session->userdata('id')
          );
          $hasil_in = $this->global_models->insert("m_menu", $kirim);
        }
      }
      if($hasil_in){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect ("menu");
    }
  }
	public function delete($id){
    if($this->global_models->delete("m_menu", array("id_menu" => $id))){
      $this->session->set_flashdata('success', 'Data terhapus');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak terhapus');
    }
      redirect("menu/index/list/filed");
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
	public function index($action = "list", $pesan = "hal", $hal = 0){
//    $this->debug($this->menu, true);
    $list = $this->global_models->get_query("SELECT B.*, A.name AS ayah
      FROM m_menu AS A
      RIGHT JOIN m_menu AS B ON A.id_menu = B.parent
      GROUP BY B.id_menu");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
    
    $foot = "
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
      <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
      ";
    $foot .= '<script type="text/javascript">
                $(function() {
                    $("#tableboxy").dataTable();
                });
            </script>';
    $menutable = '
      <li><a href="'.site_url("menu/add-new").'"><i class="icon-plus"></i> Add New</a></li>
      <li><a href="'.site_url("menu/menu-cache").'"><i class="icon-plus"></i> Clear Cache</a></li>
      <li><a href="'.site_url("menu/export-xls").'"><i class="black-icons excel_document"></i> Export to XLS</a></li>
      ';
    $this->template->build('main', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "menu",
            'data'        => $list,
            'title'       => "Menu",
            'foot'        => $foot,
            'css'         => $css,
            'menutable'   => $menutable,
          ));
    $this->template
      ->set_layout('datatables')
      ->build('main');
	}
  function menu_cache(){
    //parent
    $list_parent = $this->get_child(0);
    $this->nbscache->put_tunggal("menu", 0, serialize($list_parent));
    
    $privilege = $this->global_models->get("m_privilege");
    foreach($privilege as $pvl){
      $list_per = $this->get_child(0, $pvl->id_privilege);
      $this->nbscache->put_tunggal("menu", $pvl->id_privilege, serialize($list_per));
    }
    
    redirect("menu");
  }
  private function get_child($id_parent, $privilege = 0){
    if($privilege == 0)
      $data = $this->global_models->get_query("
        SELECT *
        FROM m_menu
        WHERE parent = '{$id_parent}'
        ORDER BY sort ASC
        ");
    else{
      $data = $this->global_models->get_query("
        SELECT A.*
        FROM m_menu AS A
        JOIN d_privilege_menu AS B ON A.id_menu = B.id_menu
        WHERE
        A.parent = {$id_parent}
        AND B.id_privilege = {$privilege}
        GROUP BY A.id_menu
        ORDER BY A.sort ASC
        ");
    }
    
    foreach($data as $lp){
      $menu[] = array(
          "name"    =>  $lp->name,
          "icon"    =>  $lp->icon,
          "link"    =>  $lp->link,
          "child"   =>  $this->get_child($lp->id_menu, $privilege)
      );
    }
    
    return $menu;
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */