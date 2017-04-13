<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {
    
  function __construct() {      
  }
  function hotel_nation(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $pst = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER, 
      "q"                 => $q,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URLSERVER."json/json-hotel/get-master-nation");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    print $hasil_1;
    die;
  }
  
  function privilege(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM m_privilege
      WHERE 
      LOWER(name) LIKE '%{$q}%'
      LIMIT 0,10
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_privilege,
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
  
  function hotel_city($nation){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $pst = array(
      'users'             => USERSSERVER, 
      'password'          => PASSSERVER,
      "q"                 => $q,
      "nation"            => $nation,
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, URLSERVER."json/json-hotel/get-master-city");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    print $hasil_1;
    die;
  }
  
  function ajax_agent($total = 0, $start = 0){
    $privilege = $this->nbscache->get_explode("store", "privilege");
    $users = $this->global_models->get_query("SELECT A.*"
//      . ", B.point"
      . " FROM m_users AS A"
      . " LEFT JOIN d_user_privilege AS B ON A.id_users = B.id_users"
      . " LEFT JOIN m_privilege AS C ON B.id_privilege = C.id_privilege"
      . " WHERE C.id_privilege = '{$privilege[1]}'"
//      . " LEFT JOIN biodata AS B ON A.id_users = B.id_users"
      . " ORDER BY name LIMIT {$start}, 10");
    $status = array(
        0 => "<span class='label label-warning'>Non-Active</span>",
        1 => "<span class='label label-success'>Active</span>",
        2 => "<span class='label label-warning'>Non-Active</span>",
    );
    foreach($users AS $users){
      $hasil .= "<tr>"
        . "<td><a href='".site_url("flight/report-agent/{$users->id_users}")."'>{$users->name}</a></td>"
        . "<td>{$users->email}</td>"
        . "<td>{$users->point}</td>"
        . "<td>{$status[$users->id_status_user]}</td>"
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
          . "<li><a href='".site_url("users/add-new/".$users->id_users)."'>Edit</a></li>"
          . "</ul>"
          . "</div>"
        . "</td>"
        . "</tr>";
    }
    
    print $hasil;
    die;
  }
  
  function ajax_halaman($total = 0, $start = 0){
    
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
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */