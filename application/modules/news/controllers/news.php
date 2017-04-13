<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MX_Controller {
    
  function __construct() {      
    
  }
  public function index(){
    
   // $page = $this->global_models->get("website_page", array("nicename" => $nicename));
   // $gambar = $this->global_models->get("website_page_picture", array("id_website_page" => $page[0]->id_website_page));
     
     $jumlah_list = $this->global_models->get_field("website_news", "count(id_website_news)", array("status" => 1));
    
    $url_list = site_url("news/ajax-news/".$jumlah_list);
    $url_list_halaman = site_url("news/ajax-halaman-news/".$jumlah_list);
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
                    
    $this->template->build("main", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'list'        => $list,
          'foot2'    => $foot,
       // 'gambar'      => $gambar,
      ));
    $this->template
      ->set_layout('default')
      ->build("main");
  }
  
  function ajax_news($total = 0, $start = 0){
    
    $list = $this->global_models->get_query("SELECT A.*"
//      . ", B.point"
      . " FROM website_news AS A"
//      . " LEFT JOIN biodata AS B ON A.id_users = B.id_users"
      . " ORDER BY title LIMIT {$start}, 15");
   
    foreach($list AS $value){
        $data_detail = site_url().'news/detail/'.$value->nicename;
        $words = explode(' ', $value->note);
         $read_more =   implode(' ', array_splice($words, 0, 25));
         $file_image = base_url().'files/antavaya/news/'.$value->file;
         $detail = site_url('news/detail/'.$value->nicename);
      $hasil .= "<div class='col-sm-6 col-md-4'>
                <article class='box'>
                    <figure>";
                     if($value->file){
                      $hasil .= "<a href='javascript:void(0)' class='hover-effect popup-gallery'><img style=' max-width:270px; max-height:160px;' src={$file_image} alt=''></a>";
                                  }

                   $hasil .= " </figure>
                    <div class='details'>

                        <h5 class='box-title'><a href='{$data_detail}'> {$value->title}</a></h5>

                        <p class='description'>  {$read_more}";
                     $hasil .= " <a style='font-size: 12px; margin-top: 0' href='{$detail}' title='' class='button'>Read More</a>
                        </p>

                    </div>
                </article>
                      </div>";
    }
    
    print $hasil;
    die;
  }
  
  function ajax_halaman_news($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 15; 
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
  
  
  public function detail($nicename){
   // print_r($_REQUEST); die;
  $list = $this->global_models->get("website_news", array("nicename" => $nicename,"status" => 1));
    $pst = $this->input->post(NULL);
  
       $data = $this->global_models->get_query("
        SELECT *,MIN(id_website_news) AS min,MAX(id_website_news) AS max
        FROM website_news
        WHERE status = 1
        ");
        if($pst['previous']){
          $id = $pst['id_detail'] - 1;
          
          $list = $this->global_models->get_query("
        SELECT *
        FROM website_news
        WHERE 
        id_website_news='{$id}' AND status = 1
        ");
        
        }
        
        if($pst['next']){
            $id = $pst['id_detail'] + 1;
        $list = $this->global_models->get_query("
        SELECT *
        FROM website_news
        WHERE 
        id_website_news='{$id}'
        ");
        }
        
        
    $this->template->build("detail", 
      array(
        'url'         => base_url()."themes/antavaya/",
        'theme2nd'    => 'antavaya',
        'list'        => $list,
        'data'        => $data
      ));
    $this->template
      ->set_layout('default')
      ->build("detail");
  }
  
  public function add_new_news($id_website_news = 0){
    if(!$this->input->post(NULL)){
      $detail = $this->global_models->get("website_news", array("id_website_news" => $id_website_news));
      
      $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>
        <script type='text/javascript'>
            $(function() {
              CKEDITOR.replace('editor2');
             
            });
        </script>
        ";
      
      $this->template->build("master/add-new-news", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'news/',
              'title'       => lang("antavaya_add_news"),
              'detail'      => $detail,
              'breadcrumb'  => array(
              'news'        => "news"
                ),
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("master/add-new-news");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $config['upload_path'] = './files/antavaya/news/';
      $config['allowed_types'] = '*';
      $config['max_width']  = '1000';
      $config['max_height']  = '1000';

      $this->load->library('upload', $config);
      
      if($_FILES['file']['name']){
        if (  $this->upload->do_upload('file')){
          $data = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("master-news/add-new-news/".$id_website_news)."'>Back</a>";
          die;
        }
      }
      
      if($_FILES['file_thumb']['name']){
        if (  $this->upload->do_upload('file_thumb')){
          $data_thumb = array('upload_data' => $this->upload->data());
        }
        else{
          print $this->upload->display_errors();
          print "<br /> <a href='".site_url("master-news/add-new-news/".$id_website_news)."'>Back</a>";
          die;
        }
      }     
      
      if($pst['id_detail']){
        $kirim = array(
            "title"           => $pst['title'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "update_by_users" => $this->session->userdata("id"),
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_thumb['upload_data']['file_name']){
          $kirim['file_thumb'] = $data_thumb['upload_data']['file_name'];
        }
        
        $id_website_news = $this->global_models->update("website_news", array("id_website_news" => $pst['id_detail']),$kirim);
      }
      else{
        $kirim = array(
            "title"           => $pst['title'],
            "note"            => $pst['note'],
            "status"          => $pst['status'],
            "create_by_users" => $this->session->userdata("id"),
            "create_date"     => date("Y-m-d")
        );
        if($data['upload_data']['file_name']){
          $kirim['file'] = $data['upload_data']['file_name'];
        }
        if($data_thumb['upload_data']['file_name']){
          $kirim['file_thumb'] = $data_thumb['upload_data']['file_name'];
        }
        
        $id_website_news = $this->global_models->insert("website_news", $kirim);
      }
      if($id_website_news){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("news");
    }
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */