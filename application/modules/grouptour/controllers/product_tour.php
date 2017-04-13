<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_tour extends MX_Controller {
    
  function __construct() {      
    $this->menu = $this->cek();
  }

  function curl_mentah($pst, $url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pst);
    $hasil_1 = curl_exec($ch);
    curl_close($ch);
    return $hasil_1;
  }
  
  function index(){
     
      $pst = $this->input->post(NULL);
     
	 if($pst['dt_status']){
        $pst['dt_status'] = $pst['dt_status'];
      }else{
        $pst['dt_status'] = 5;
      }
	  
      if($pst){
    
        $newdata = array(
            'product_tour_landmark'                   => $pst['landmark'],
            'product_tour_title'                      => $pst['title'],
            'product_tour_destination'                => $pst['destination'],
            'product_tour_start_date'                 => $pst['start_date'],
            'product_tour_end_date'                   => $pst['end_date'],
            'product_tour_kategori1'                  => $pst['kategori1'],
            'product_tour_kategori2'                  => $pst['kategori2'],
            'product_tour_keberangkatan'              => $pst['keberangkatan'],
			'product_tour_status'                     => $pst['dt_status'],
            'product_tour_code'                       => $pst['code'],
            'product_tour_sort1'                      => $pst['sort1'],
            'product_tour_sort2'                      => $pst['sort2'],
            'product_tour_sort3'                      => $pst['sort3'],
            'product_tour_sort4'                      => $pst['sort4'],
            'product_tour_store'                      => $pst['id_store'],
            
          );
          $this->session->set_userdata($newdata);
    }
    
    $data = array(
                    "users"             => USERSSERVER,
                    "password"          => PASSSERVER,
                    "landmark"          =>  $this->session->userdata('product_tour_landmark'),
                      "title"           =>  $this->session->userdata('product_tour_title'),
                    "destination"       =>  $this->session->userdata('product_tour_destination'),
                    "start_date"        =>  $this->session->userdata('product_tour_start_date'),
                    "end_date"          =>  $this->session->userdata('product_tour_end_date'),
                    "kategori1"         =>  $this->session->userdata('product_tour_kategori1'),
                    "kategori2"         =>  $this->session->userdata('product_tour_kategori2'),
                    "keberangkatan"     =>  $this->session->userdata('product_tour_keberangkatan'),
					"status"            =>  $this->session->userdata('product_tour_status'),
                    "code"              =>  $this->session->userdata('product_tour_code'),
                    "sort1"             =>  $this->session->userdata('product_tour_sort1'),
                    "sort2"             =>  $this->session->userdata('product_tour_sort2'),
                    "sort3"             =>  $this->session->userdata('product_tour_sort3'),
                    "sort4"             =>  $this->session->userdata('product_tour_sort4'),
                    "store"             =>  $this->session->userdata('product_tour_store'),
                    "limit"             => 40,
                    "id_users"          => $this->session->userdata("id"),
                    );
//     if($serach){
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-product-tour");  
      $data_array = json_decode($data);
	  
	  $store_post = array(
    "users"             => USERSSERVER,
    "password"          => PASSSERVER,
      "master"          => 2,
    );
//     if($serach){
      $store = $this->curl_mentah($store_post, URLSERVER."json/json-midlle-system/get-all-store");  
      $store_array = json_decode($store);
      $store_dd[NULL] = "- Pilih -";
      foreach ($store_array->data AS $sad){
        $store_dd[$sad->id_store] = $sad->title;
      }
//      print_r($data); die;
//      print_r($data_array->total); die;
//       $this->debug($data, true);
//      if($data_array)
   ///    $this->debug($data_array, true);
//     }else{
//         $data_array = "";
//     }
   
     $url_list = site_url("grouptour/product-tour/ajax-product-tour/".$data_array->total);
    $url_list_halaman = site_url("grouptour/product-tour/ajax-halaman-product-tour/".$data_array->total);

//    $list = $data_array;
    $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia",6 => "China", 7 => "New Zealand");
    
	$dt_status = array(9 => "Available", 5 => "Push Selling");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
       
        <script type='text/javascript'>
             $(document).ready(function () { 
           
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
            })
        </script>";
    $foot .= "<script type='text/javascript'>"

      ."function get_list(start){"
        ."if(typeof start === 'undefined'){"
         ."start = 0;"
          ."}"
           ."$.post('{$url_list}/'+start, function(data){"
            ."$('#data_list').html(data);"
             ."$.post('{$url_list_halaman}/'+start, function(data){"
              ."$('#halaman_set').html(data);"
               ." });"
                ."});"
            ."}"
            ."get_list(0);"
      . "</script> ";
    
   // print_r($serach_data); die;
    $sort_array = array(
      NULL                  => "- Pilih -",
      "A.title ASC"         => "Tour Name ASC",
      "A.title DESC"        => "Tour Name DESC",
      "B.start_date ASC"    => "Keberangkatan ASC",
      "B.start_date DESC"   => "Keberangkatan DESC",
	  "B.status ASC"        => "Status ASC",
      "B.status DESC"       => "status DESC",
      "A.days ASC"          => "Days ASC",
      "A.days DESC"         => "Days DESC",
      "B.seat_update ASC"   => "Available ASC",
      "B.seat_update DESC"  => "Available DESC",
    );
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name Tour</label><br>"
            . "{$this->form_eksternal->form_input('title', $this->session->userdata('product_tour_title'), ' class="form-control input-sm" placeholder="Name Tour"')}"
          . "</div>"
        . "</div>"
              . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Kota-Kota Tujuan</label><br>"
            . "{$this->form_eksternal->form_input('destination', $this->session->userdata('product_tour_destination'), ' class="form-control input-sm" placeholder="Kota-Kota Tujuan"')}"
          . "</div>"
        . "</div>"
             . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Object Landmark</label><br>"
            . "{$this->form_eksternal->form_input('landmark', $this->session->userdata('product_tour_landmark'), ' class="form-control input-sm" placeholder="Tour Termasuk"')}"
          . "</div>"
        . "</div>"
             . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Store</label>"
            . "{$this->form_eksternal->form_dropdown('id_store', $store_dd, array($this->session->userdata('product_tour_store')), 'class="form-control input-sm"')}"
          . "</div>"
        . "</div>"
		. "</div>"
             . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Keberangkatan</label>"
            . "{$this->form_eksternal->form_input('keberangkatan', $this->session->userdata('product_tour_keberangkatan'), ' class="form-control input-sm" placeholder="Keberangkatan"')}"
          . "</div>"
        . "</div>"
		. "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Status</label>"
            . "{$this->form_eksternal->form_dropdown('dt_status', $dt_status, array($this->session->userdata('product_tour_status')), 'class="form-control input-sm" placeholder="Status"')}"
          . "</div>"
        . "</div>"    
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Keberangkatan (start)</label>"
            . "{$this->form_eksternal->form_input('start_date', $this->session->userdata('product_tour_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          . "<div class='control-group'>"
            . "<label>Tour Code</label>"
            . "{$this->form_eksternal->form_input('code', $this->session->userdata('product_tour_code'), 'class="form-control input-sm" placeholder="Tour Code"')}"
          . "</div>"
        . "</div>"              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Keberangkatan (end)</label>"
            . "{$this->form_eksternal->form_input('end_date', $this->session->userdata('product_tour_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          . "<div class='control-group'>"
            . "<label>Region</label>"
            . "{$this->form_eksternal->form_dropdown('kategori2', $sub_category, array($this->session->userdata('product_tour_kategori2')), 'class="form-control input-sm" placeholder="Region"')}"
          . "</div>"
        . "</div>"  
        . "<div class='box-body'>"
          . "<div class='row'>"
            . "<div class='col-xs-3'>"
              . "<label>Sort Level 1</label>"
              . "{$this->form_eksternal->form_dropdown('sort1', $sort_array, array($this->session->userdata('product_tour_sort1')), 'class="form-control input-sm"')}"
            . "</div>"
            . "<div class='col-xs-3'>"
              . "<label>Sort Level 2</label>"
              . "{$this->form_eksternal->form_dropdown('sort2', $sort_array, array($this->session->userdata('product_tour_sort2')), 'class="form-control input-sm"')}"
            . "</div>"
            . "<div class='col-xs-3'>"
              . "<label>Sort Level 3</label>"
              . "{$this->form_eksternal->form_dropdown('sort3', $sort_array, array($this->session->userdata('product_tour_sort3')), 'class="form-control input-sm"')}"
            . "</div>"
            . "<div class='col-xs-3'>"
              . "<label>Sort Level 4</label>"
              . "{$this->form_eksternal->form_dropdown('sort4', $sort_array, array($this->session->userdata('product_tour_sort4')), 'class="form-control input-sm"')}"
            . "</div>"
          . "</div>"
        . "</div>"  
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('product-tour/tour', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'         => base_url()."themes/antavaya/",
            'menu'        => "grouptour/product-tour",
            'data'        => $data_array,
            'title'       => lang("Search_Tour"),
            'category'            => $category,
            'sub_category'        =>$sub_category,
            'foot'                => $foot,
            'css'                 => $css,
            'serach_data'         => $serach_data,
          'serach'                => $serach,
          'before_table'    => $before_table,
          ));
    $this->template
    //  ->set_layout($datatables)
      ->set_layout('tableajax')
      ->build('product-tour/tour');
  }
  function ajax_halaman_product_tour($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 40; 
    $config['uri_segment'] = 5; 
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
  
  function ajax_halaman_book_list($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 10; 
    $config['uri_segment'] = 5; 
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
  
   function ajax_product_tour($total = 0, $start = 0){
	   
	if($this->session->userdata('product_tour_sort1')){
		 $sort = "ORDER BY {$this->session->userdata('product_tour_sort1')}";
		 if($this->session->userdata('product_tour_sort2'))
		   $sort .= ",{$this->session->userdata('product_tour_sort2')}";
		 if($this->session->userdata('product_tour_sort3'))
		   $sort .= ",{$this->session->userdata('product_tour_sort3')}";
		 if($this->session->userdata('product_tour_sort4'))
		   $sort .= ",{$this->session->userdata('product_tour_sort4')}";
	}
	else{
	 $sort = "";
	}
    
      $data = array(
                    "users"             => USERSSERVER,
                    "password"          => PASSSERVER,
                    "landmark"          =>  $this->session->userdata('product_tour_landmark'),
                      "title"           =>  $this->session->userdata('product_tour_title'),
                    "destination"       =>  $this->session->userdata('product_tour_destination'),
                    "start_date"        =>  $this->session->userdata('product_tour_start_date'),
                    "end_date"          =>  $this->session->userdata('product_tour_end_date'),
                    "kategori1"         =>  $this->session->userdata('product_tour_kategori1'),
                    "kategori2"         =>  $this->session->userdata('product_tour_kategori2'),
                    "id_store"          =>  $this->session->userdata('product_tour_store'),
                    "keberangkatan"     =>  $this->session->userdata('product_tour_keberangkatan'),
					"status"            =>  $this->session->userdata('product_tour_status'),
                    "code"              =>  $this->session->userdata('product_tour_code'),
                    "limit"             => 40,
					"sort"              => $sort,
                    "start"             => $start,
                    "id_users"          => $this->session->userdata("id"),
                    );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-product-tour");  
      $data_array = json_decode($data);
       $st_status = array(NULL => "<span style='color:black' class='label label-success'>Available</span>",
	   "1" => "<span style='color:black' class='label label-success'>Available</span>",
						"5" => "<span style='color:black' class='label label-warning'>Push Selling</span>",
            "3" => "<span style='color:black' class='label label-default'>Cancel</span>",
            "4" => "<span style='color:black' class='label label-danger'>Close</span>");
			
    if($data_array->status == 2){
     
    foreach ($data_array->tour as $key => $value) {
       
      $price = number_format($value->information->price->adult, 0, '.', ',');
      
      $start_date = "";
     
          $avai_seat[$key] .= "<a href='".site_url("grouptour/product-tour/book-list/".$value->information->code)."'>{$value->information->available_seat}</a><br>";
          $seat_book[$key] .= $value->information->total_seat_book."<br>";
          $seat_seat_committed[$key] .= $value->information->total_seat_committed."<br>";
          $seat[$key] .= $value->information->seat."<br>";
        $start_date .= "<a href='javascript:void(0)' id='{$value->information->code}'>"
          . date("d M y", strtotime($value->information->start_date))." - ".date("d M y", strtotime($value->information->end_date))."</a>"
          . "<div style='display: none' id='isi{$value->information->code}'>"
            . "<table width='100%'>"
              . "<tr>"
                . "<td>Tour Code</td>"
                . "<td style='text-align: left'>{$value->information->code}</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Adult Triple/Twin</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->adult_triple_twin)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child Twin Bed</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->child_twin_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child Extra Bed</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->child_extra_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child No Bed</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->child_no_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>SGL SUPP</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->sgl_supp)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Airport Tax & Flight Insurance</td>"
                . "<td style='text-align: left'>".number_format($value->information->price->airport_tax)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Available Seat</td>"
                . "<td style='text-align: left'>".number_format($value->information->available_seat)."</td>"
              . "</tr>"
            . "<tr>"
                . "<td colspan='2'><center><a href='".site_url("grouptour/product-tour/book-tour/".$value->information->code)."' class='btn btn-primary'>BOOK</a></center></td>"
                . "<td></td>"
              . "</tr>"
              .""
            . "</table>"
          . "</div>"
          . "<script>"
            . "$(function() {"
              . "$('#{$value->information->code}').tooltipster({"
                . "content: $('#isi{$value->information->code}').html(),"
                . "minWidth: 300,"
                . "maxWidth: 300,"
                . "contentAsHTML: true,"
                . "interactive: true"
              . "});"
            . "});"
          . "</script>"
          . "<br />";
  
      $kota = strip_tags($value->destination);
      $detail_kota = "";
      if (strlen($kota) > 20) {
          $kotaCut = substr($kota, 0, 20);
          $kota = substr($kotaCut, 0, strrpos($kotaCut, ' ')).'... <a href="javascript:void(0)" id="kota1-'.$value->information->code.'">View</a>';
          $detail_kota = "<div style='display: none' id='isi-kota1-{$value->information->code}'>{$value->destination}</div>";
          $script .= "$('#kota1-{$value->information->code}').tooltipster({"
            . "content: $('#isi-kota1-{$value->information->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});";
      }
	  
	  $landmark = strip_tags($value->landmark);
      $detail_landmark = "";
      if (strlen($landmark) > 20) {
          $landmarkCut = substr($landmark, 0, 20);
          $landmark = substr($landmarkCut, 0, strrpos($landmarkCut, ' ')).'... <a href="javascript:void(0)" id="landmark1-'.$value->information->code.'">View</a>';
          $detail_landmark = "<div style='display: none' id='isi-landmark1-{$value->information->code}'>{$value->landmark}</div>";
          $script .= "$('#landmark1-{$value->information->code}').tooltipster({"
            . "content: $('#isi-landmark1-{$value->information->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});";
      }
	  
       $info_umum = "<a href=".site_url("grouptour/product-tour/tour-detail/".$value->code)." id='info-".$value->information->code."'>{$value->title}/ {$value->sub_category->name}</a>"
      . "<div style='display: none' id='info-isi-{$value->information->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Store</td>"
            . "<td>{$value->store}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Flight</td>"
            . "<td>{$value->information->flight}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>STS</td>"
            . "<td>{$value->information->sts}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>IN</td>"
            . "<td>{$value->information->in}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>OUT</td>"
            . "<td>{$value->information->out}</td>"
          . "</tr>"
		  . "<tr>"
            . "<td>Keberangkatan</td>"
            . "<td>{$value->information->keberangkatan}</td>"
          . "</tr>"
		  . "<tr>"
           . "<br<br><td style='font-size: 15px'><center>Klik nama tour untuk detail Itin</center></td>"
          . "</tr>" 
        . "</table>"
      . "</div>";
      $script .= "$('#info-{$value->information->code}').tooltipster({"
        . "content: $('#info-isi-{$value->information->code}').html(),"
        . "minWidth: 300,"
        . "maxWidth: 300,"
        . "contentAsHTML: true,"
        . "interactive: true"
      . "});";
	  
      $tampil = '
      <tr>
      <td>'.$info_umum.'</td>
       <td>'.$start_date.'</td>
		<td>'.$st_status[$value->status].'</td>
         <td>'.$value->days.'</td>
           <td>'.$seat[$key].'</td>
        <td>'.$seat_book[$key].'</td>
          <td>'.$seat_seat_committed[$key].'</td>
            <td>'.$avai_seat[$key].'</td>
        <td>'.$kota.$detail_kota.'</td>
            <td>'.$landmark.$detail_landmark.'</td>
        
      </tr></form>';
    
   $tampil .= "<script>"
        . "$(function() {"
          . "{$script}"
        . "});"
      . "</script>";
    print $tampil;
      }
  }
   
    
    die;
  }
  
  function ajax_book_list($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('book_list_start_date'),
        "end_date"        => $this->session->userdata('book_list_end_date'),
        "title"           => $this->session->userdata('book_list_tour_title'),
        "name"            => $this->session->userdata('book_list_name'),
        "code"            => $this->session->userdata('book_list_code'),
        "status"          => $this->session->userdata('book_list_status'),
        "limit"           => 10,
        "start"             => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list");  
      $data_array = json_decode($data);
//      $this->debug($data, true); 
      if($data_array->status == 2){
   /* $status = array(
      1 => "<span class='label label-default'>Book</span>",
      2 => "<span class='label label-info'>Committed Payment</span>",
      3 => "<span class='label label-success'>Clear</span>",
      4 => "<span class='label label-warning'>Cancel</span>",
    ); */
       $status = array(
                    1 => "Book",
                    2 => "Deposit",
                    3 => "Lunas",
                    4 => "Cancel",
                  );
    foreach ($data_array->book as $key => $value) {
      if($value->status < 3){
        $payment = "<li><a href='".site_url("grouptour/product-tour/payment-book/".$value->code)."'>Payment</a></li>";
      }
      
      if($value->tc){
        if($value->store){
          $name_store = " [".$value->store."]";
        }else{
          $name_store = "";
        }
        
        $tc = $value->tc."<br>".$name_store;
      }else{
        $tc = "";
      }
    
//                    print "<pre>";
//                  print_r($value->passenger->first_name);
//                  print "</pre>";
                  $nobook     = 0;
                  $nocommit   = 0;
                  $nolunas    = 0;
                  $nocancel   = 0;
                  $wt_app     = 0;
                  foreach ($value->passenger as $key1 => $valps) {
//                       print "<pre>";
//                  print_r($valps);
//                  print "</pre>";
                   
                   // echo $valps['status'];
                    if($valps->status == 1){
                      $nobook2[$key] +=  $nobook[$key] + 1;
                    }elseif($valps->status == 2){
                      $nocommit2[$key] +=  $nocommit[$key] + 1;
                    }elseif($valps->status == 3){
                      $nolunas2[$key] +=  $nolunas[$key] + 1;
                    }elseif($valps->status == 4){
                      $nocancel2[$key] +=  $nocancel[$key] + 1;
                    }elseif($valps->status == 5){
                      $wt_app2[$key] += $wt_app[$key] + 1;
                     
                    }
                  }
                  
                  if($nobook2[$key] > 0){
                    $st_book[$key] = "Book For ".$nobook2[$key]." Person<br>";
                  }
                  if($nocommit2[$key] > 0){
                    $st_commit[$key] = "Deposit Book For ".$nocommit2[$key]." Person<br>";
                  }
                  if($nolunas2[$key] > 0){
                    $st_lunas[$key] = "Lunas For ".$nolunas2[$key]." Person<br>";
                  }
                  if($nocancel2[$key] > 0){
                    $st_cancel[$key] = "Cancel For ".$nocancel2[$key]." Person<br>";
                  }
                  if($wt_app2[$key] > 0){
                    $st_wtapp[$key] = "[Cancel] Waiting Approval For ".$wt_app2[$key]." Person<br>";
                  }
                 $dt_status_all = "<b>".$st_book[$key].$st_commit[$key].$st_lunas[$key].$st_cancel[$key].$st_wtapp[$key]."</b>";
                  
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Biaya</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
      //$total_visa = 0;
      //if($value->total_visa){
       // $total_visa = (int)$value->total_visa;
     // $detail_beban .= "<tr>"
        //    . "<td>Visa1</td>"
         //   . "<td style='text-align: left'>".number_format($total_visa,0,".",",")."</td>"
         // . "</tr>";
      //}
      //$array_additional = json_decode($data_add);
    
//        $total_additional = 0;
//        if(is_array($value->additional)){
//        //  print_r($value->additional);
//          foreach ($value->additional as $val) {
//          //  $total_additional += $val->nominal;
//             if($val->id_currency == 1){
//                  $nom_add0_usd[$key] = $val->nominal;
//                  $nom_add0_idr[$key] = $val->nominal * $value->currency_rate;
//                }elseif($val->id_currency == 2){
//                  $nom_add0_usd[$key] = $val->nominal/$value->currency_rate;
//                  $nom_add0_idr[$key] = $val->nominal;
//                }
//                if($val->pos == 1){
//                  $mins = "- ";
//                $total_kredit2_usd[$key] += $nom_add0_usd[$key];
//                $total_kredit2_idr[$key] += $nom_add0_idr[$key];
//              }else{
//                $mins = "";
//                $total_debit2_usd[$key] += $nom_add0_usd[$key];
//                $total_debit2_idr[$key] += $nom_add0_idr[$key];
//              }
//            $detail_beban .= "<tr>"
//            . "<td>{$val->name}</td>"
//            . "<td style='text-align: left'>"."{$mins}".number_format($nom_add0_idr[$key],0,".",",")."</td>"
//          . "</tr>";
//          }
//        }
        $tot_disc_price=0;
        if($value->status_discount == "Persen"){
          $tot_disc_price =  (($value->beban_awal * $value->discount)/100);
        }elseif($value->status_discount == "Nominal") {
          $tot_disc_price = $value->discount;
        }
            
//        $detail_beban .= "<tr>"
//            . "<td>Discount</td>"
//            . "<td style='text-align: left'>- ".number_format($tot_disc_price,0,".",",")."</td>"
//          . "</tr>";
//        print $value->discount_tambahan[0]->status."aa";
//        if($value->discount_tambahan[0]->discount_request > 0){
//              if($value->discount_tambahan[0]->status_discount == 1){
//                    $status_disc_tambh = "[Persen]";
//                    $tot_disc_tambahan[$key] =  (($value->beban_awal * $value->discount_tambahan[0]->discount_request)/100);
//                  }elseif($value->discount_tambahan[0]->status_discount == 2) {
//                   
//                      $status_disc_tambh = "Nominal";
//                   $tot_disc_tambahan[$key] = $value->discount_tambahan[0]->discount_request;
//                  }
//          $detail_beban .= "<tr>"
//            . "<td>Discount Tambahan</td>"
//            . "<td style='text-align: left'>- ".number_format($tot_disc_tambahan[$key],2,".",",")."</td>"
//          . "</tr>";
//        }
        if($value->potongan){
             $detail_beban .= "<tr>"
            . "<td>Potongan Biaya</td>"
            . "<td style='text-align: left'>- ".number_format($value->potongan,2,".",",")."</td>"
          . "</tr>";
        }
        
          $detail_beban .= "<tr>"
            . "<td>Pembayaran</td>"
            . "<td style='text-align: left'>- ".number_format($value->pembayaran,2,".",",")."</td>"
          . "</tr>"
         // . "<tr>"
         //   . "<td>Committed Book</td>"
         //   . "<td style='text-align: left'>".number_format($value->committed_book)."</td>"
         // . "</tr>"
        . "</table>"
      . "</div>"
      . "<div style='display: none' id='isiinfo{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Tour</td>"
            . "<td style='text-align: left'><a href='".site_url("grouptour/product-tour/tour-detail/{$value->tour_code}")."'>{$value->tour}</a></td>"
          . "</tr>"
          . "<tr>"
            . "<td>Start Date</td>"
            . "<td style='text-align: left'>".date("d F Y", strtotime($value->start_date))."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>End Date</td>"
            . "<td style='text-align: left'>".date("d F Y", strtotime($value->end_date))."</td>"
          . "</tr>"
        . "</table>"
      . "</div>"
              . "<div style='display: none' id='isiinfo1{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Email</td>"
            . "<td style='text-align: left'>{$value->email}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>No Telp</td>"
            . "<td style='text-align: left'>".$value->telp."</td>"
          . "</tr>"
        . "</table>"
      . "</div>"
      . "<script>"
        . "$(function() {"
          . "$('#{$value->code}').tooltipster({"
            . "content: $('#isi{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
          . "$('#info{$value->code}').tooltipster({"
            . "content: $('#isiinfo{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
              . "$('#info1{$value->code}').tooltipster({"
            . "content: $('#isiinfo1{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
        . "});"
      . "</script>";
      $status = array(
        1 => "<span class='label label-warning'>Book</span>",
        2 => "<span class='label label-info'>Deposit</span>",
        3 => "<span class='label label-success'>Lunas</span>",
        4 => "<span class='label label-default'>Cancel</span>",
        5 => "<span class='label label-danger'>Cancel Deposit</span>",
        6 => "<span class='label label-default'>Cancel Deposit<br>[Waiting Approval]</span>",
        7 => "<span class='label label-default'>Change Tour<br>[Waiting Approval]</span>",
        8 => "<span class='label label-danger'>Cancel<br>Change Tour</span>", 
        9 => "<span class='label label-danger'>Reject<br>Change Tour</span>",   
      );
      print "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->tour}</td>"
        . "<td>{$tc}</td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$status[$value->status]}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan)),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("grouptour/product-tour/book-information/".$value->code)."'>Detail</a></li>"
             . "<li><a href='".site_url("grouptour/product-tour/change-tour/".$value->code)."'>Change Tour</a></li>"
            // . "<li><a href='".site_url("store/cancel-book/".$value->code)."'>Cancel Book</a></li>"
			. "<li><a href='javascript:void(0)' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$value->code}' id='id-customer-cancel' >Cancel Tour</a></li>"
           
        . "</td>"
      . "</tr>";
    }
  }
    
    die;
  }
  
  function ajax_book_list_keseluruhan($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('book_list_keseluruhan_start_date'),
        "end_date"        => $this->session->userdata('book_list_keseluruhan_end_date'),
        "title"           => $this->session->userdata('book_list_keseluruhan_tour_title'),
        "name"            => $this->session->userdata('book_list_keseluruhan_name'),
        "code"            => $this->session->userdata('book_list_keseluruhan_code'),
        "status"          => $this->session->userdata('book_list_keseluruhan_status'),
        "limit"           => 10,
        "start"             => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list-keseluruhan");  
      $data_array = json_decode($data);
//       print "<pre>";
//       print_r($data_array->book);
//       print "</pre>";
//       
      if($data_array->status == 2){
   /* $status = array(
      1 => "<span class='label label-default'>Book</span>",
      2 => "<span class='label label-info'>Committed Payment</span>",
      3 => "<span class='label label-success'>Clear</span>",
      4 => "<span class='label label-warning'>Cancel</span>",
    ); */
      $status = array(
        1 => "<span class='label label-warning'>Book</span>",
        2 => "<span class='label label-info'>Deposit</span>",
        3 => "<span class='label label-success'>Lunas</span>",
        4 => "<span class='label label-default'>Cancel</span>",
        5 => "<span class='label label-danger'>Cancel Deposit</span>",
        6 => "<span class='label label-default'>Cancel Deposit<br>[Waiting Approval]</span>",
        7 => "<span class='label label-default'>Change Tour<br>[Waiting Approval]</span>",
        8 => "<span class='label label-danger'>Cancel<br>Change Tour</span>", 
        9 => "<span class='label label-danger'>Reject<br>Change Tour</span>", 
      );
    foreach ($data_array->book as $key => $value) {
      if($value->status < 3){
        $payment = "<li><a href='".site_url("grouptour/product-tour/payment-book/".$value->code)."'>Payment</a></li>";
      }
      if($value->name_tc){
        if($value->name_store){
          $name_store = " [".$value->name_store."]";
        }else{
          $name_store = "";
        }
        
        $tc = $value->name_tc."<br>".$name_store;
      }else{
        $tc = "";
      }
      
    
//                    print "<pre>";
//                  print_r($value->passenger->first_name);
//                  print "</pre>";
                  $nobook     = 0;
                  $nocommit   = 0;
                  $nolunas    = 0;
                  $nocancel   = 0;
                  $wt_app     = 0;
                  foreach ($value->passenger as $key1 => $valps) {
//                       print "<pre>";
//                  print_r($valps);
//                  print "</pre>";
                   
                   // echo $valps['status'];
                    if($valps->status == 1){
                      $nobook2[$key] +=  $nobook[$key] + 1;
                    }elseif($valps->status == 2){
                      $nocommit2[$key] +=  $nocommit[$key] + 1;
                    }elseif($valps->status == 3){
                      $nolunas2[$key] +=  $nolunas[$key] + 1;
                    }elseif($valps->status == 4){
                      $nocancel2[$key] +=  $nocancel[$key] + 1;
                    }elseif($valps->status == 5){
                      $wt_app2[$key] += $wt_app[$key] + 1;
                     
                    }
                  }
                  
                  if($nobook2[$key] > 0){
                    $st_book[$key] = "Book For ".$nobook2[$key]." Person<br>";
                  }
                  if($nocommit2[$key] > 0){
                    $st_commit[$key] = "Deposit Book For ".$nocommit2[$key]." Person<br>";
                  }
                  if($nolunas2[$key] > 0){
                    $st_lunas[$key] = "Lunas For ".$nolunas2[$key]." Person<br>";
                  }
                  if($nocancel2[$key] > 0){
                    $st_cancel[$key] = "Cancel For ".$nocancel2[$key]." Person<br>";
                  }
                  if($wt_app2[$key] > 0){
                    $st_wtapp[$key] = "[Cancel] Waiting Approval For ".$wt_app2[$key]." Person<br>";
                  }
                 $dt_status_all = "<b>".$st_book[$key].$st_commit[$key].$st_lunas[$key].$st_cancel[$key].$st_wtapp[$key]."</b>";
                  
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Awal</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
     // $total_visa = 0;
     // if($value->total_visa){
      //  $total_visa = (int)$value->total_visa;
      //$detail_beban .= "<tr>"
      //      . "<td>Visa1</td>"
        //    . "<td style='text-align: left'>".number_format($total_visa,0,".",",")."</td>"
       //   . "</tr>";
     // }
      //$array_additional = json_decode($data_add);
    
//        $total_additional = 0;
//        if(is_array($value->additional)){
//        //  print_r($value->additional);
//          foreach ($value->additional as $val) {
//          //  $total_additional += $val->nominal;
//             if($val->id_currency == 1){
//                  $nom_add0_usd[$key] = $val->nominal;
//                  $nom_add0_idr[$key] = $val->nominal * $value->currency_rate;
//                }elseif($val->id_currency == 2){
//                  $nom_add0_usd[$key] = $val->nominal/$value->currency_rate;
//                  $nom_add0_idr[$key] = $val->nominal;
//                }
//                if($val->pos == 1){
//                  $mins = "- ";
//                $total_kredit2_usd[$key] += $nom_add0_usd[$key];
//                $total_kredit2_idr[$key] += $nom_add0_idr[$key];
//              }else{
//                $mins = "";
//                $total_debit2_usd[$key] += $nom_add0_usd[$key];
//                $total_debit2_idr[$key] += $nom_add0_idr[$key];
//              }
//            $detail_beban .= "<tr>"
//            . "<td>{$val->name}</td>"
//            . "<td style='text-align: left'>"."{$mins}".number_format($nom_add0_idr[$key],0,".",",")."</td>"
//          . "</tr>";
//          }
//        }
//        $tot_disc_price=0;
//        if($value->status_discount == "Persen"){
//          $tot_disc_price =  (($value->beban_awal * $value->discount)/100);
//        }elseif($value->status_discount == "Nominal") {
//          $tot_disc_price = $value->discount;
//        }
       // $ppn = 1 *((($value->beban_awal + $total_debit2_idr[$key] + $value->tax_and_insurance)+$total_visa)-$tot_disc_price)/100;      
//        $detail_beban .= "<tr>"
//            . "<td>Discount</td>"
//            . "<td style='text-align: left'>- ".number_format($tot_disc_price,0,".",",")."</td>"
//          . "</tr>";
       
//        print $value->discount_tambahan[0]->status."aa";
//        if($value->discount_tambahan[0]->discount_request > 0){
//              if($value->discount_tambahan[0]->status_discount == 1){
//                    $status_disc_tambh = "[Persen]";
//                    $tot_disc_tambahan[$key] =  (($value->beban_awal * $value->discount_tambahan[0]->discount_request)/100);
//                  }elseif($value->discount_tambahan[0]->status_discount == 2) {
//                   
//                      $status_disc_tambh = "Nominal";
//                   $tot_disc_tambahan[$key] = $value->discount_tambahan[0]->discount_request;
//                  }
//          $detail_beban .= "<tr>"
//            . "<td>Discount Tambahan</td>"
//            . "<td style='text-align: left'>- ".number_format($tot_disc_tambahan[$key],2,".",",")."</td>"
//          . "</tr>";
//        }
        if($value->potongan){
             $detail_beban .= "<tr>"
            . "<td>Potongan Biaya</td>"
            . "<td style='text-align: left'>- ".number_format($value->potongan,2,".",",")."</td>"
          . "</tr>";
        }
        
          $detail_beban .= "<tr>"
            . "<td>Pembayaran</td>"
            . "<td style='text-align: left'>- ".number_format($value->pembayaran,2,".",",")."</td>"
          . "</tr>"
         // . "<tr>"
         //   . "<td>Committed Book</td>"
         //   . "<td style='text-align: left'>".number_format($value->committed_book)."</td>"
         // . "</tr>"
        . "</table>"
      . "</div>"
      . "<div style='display: none' id='isiinfo{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Tour</td>"
            . "<td style='text-align: left'><a href='".site_url("grouptour/product-tour/tour-detail/{$value->tour_code}")."'>{$value->tour}</a></td>"
          . "</tr>"
          . "<tr>"
            . "<td>Start Date</td>"
            . "<td style='text-align: left'>".date("d F Y", strtotime($value->start_date))."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>End Date</td>"
            . "<td style='text-align: left'>".date("d F Y", strtotime($value->end_date))."</td>"
          . "</tr>"
        . "</table>"
      . "</div>"
              . "<div style='display: none' id='isiinfo1{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Email</td>"
            . "<td style='text-align: left'>{$value->email}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>No Telp</td>"
            . "<td style='text-align: left'>".$value->telp."</td>"
          . "</tr>"
        . "</table>"
      . "</div>"
      . "<script>"
        . "$(function() {"
          . "$('#{$value->code}').tooltipster({"
            . "content: $('#isi{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
          . "$('#info{$value->code}').tooltipster({"
            . "content: $('#isiinfo{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
              . "$('#info1{$value->code}').tooltipster({"
            . "content: $('#isiinfo1{$value->code}').html(),"
            . "minWidth: 300,"
            . "maxWidth: 300,"
            . "contentAsHTML: true,"
            . "interactive: true"
          . "});"
        . "});"
      . "</script>";
      print "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>"
          . "{$value->tour}<br />"
          . date("d M y", strtotime($value->start_date))
        . "</td>"
        . "<td>{$tc}</td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$status[$value->status]}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan )),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("grouptour/product-tour/book-information/".$value->code)."'>Detail</a></li>"
        . "</td>"
      . "</tr>";
    }
  }
    
    die;
  }
  
  function book_list($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'book_list_start_date'           => $pst['start_date'],
            'book_list_end_date'             => $pst['end_date'],
            'book_list_Tour_title'           => $pst['title'],
            'book_list_name'                 => $pst['name'],
            'book_list_code'                 => $pst['code'],
            'book_list_status'               => $pst['status'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('book_list_start_date'),
        "end_date"        => $this->session->userdata('book_list_end_date'),
        "title"           => $this->session->userdata('book_list_tour_title'),
        "name"            => $this->session->userdata('book_list_name'),
        "code"            => $this->session->userdata('book_list_code'),
        "status"          => $this->session->userdata('book_list_status'),
        "limit"           => 10,
        "id_users"        => $this->session->userdata("id"),
        );
//      if($data_array)
//        $this->debug($data_array, true);
//     }else{
//       $serach_data["start_date"] = date("Y-m-d");
//       $serach_data["end_date"] = date("Y-m-d");
//        $data = array(
//        "users"           => USERSSERVER,
//        "password"        => PASSSERVER,
//        "start_date"    => $serach_data["start_date"],
//        "end_date"      => $serach_data["end_date"],
//        "code"           => $code_tour_information,    
//        "id_users"      => $this->session->userdata("id"),
//        );
//     }
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list");  
    $data_array = json_decode($data);
//    print "<pre>";
//    print_r($data_array); 
//    print "</pre>";
//    die;
//    print $data_array->total; die;
     $url_list = site_url("grouptour/product-tour/ajax-book-list/".$data_array->total);
    $url_list_halaman = site_url("grouptour/product-tour/ajax-halaman-book-list/".$data_array->total);
    
  // $this->debug($data_array, true);
// print_r($data); die;
//    $list = $data_array;
    $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
       
        <script type='text/javascript'>
             $(document).ready(function () { 
           
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });  
            })
        </script>";
    $foot .= "<script type='text/javascript'>"
	. "$(document).on('click', '#id-customer-cancel', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id_customer_book').val(id);"
      . "});"
      ."function get_list(start){"
        ."if(typeof start === 'undefined'){"
         ."start = 0;"
          ."}"
           ."$.post('{$url_list}/'+start, function(data){"
            ."$('#data_list').html(data);"
             ."$.post('{$url_list_halaman}/'+start, function(data){"
              ."$('#halaman_set').html(data);"
               ." });"
                ."});"
            ."}"
            ."get_list(0);"
      . "</script> ";
             
   // print_r($serach_data); die;
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('title', $this->session->userdata('book_list_Tour_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('code', $this->session->userdata('book_list_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $this->session->userdata('book_list_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $this->session->userdata('book_list_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('name', $this->session->userdata('book_list_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Status</label><br>"
            . "{$this->form_eksternal->form_dropdown('status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_status')), ' class="form-control input-sm"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
	 $link = site_url('store/cancel-book/1');
    $before_table .= "<div class='modal fade' id='edit-keterangan-cancel' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                <h4 class='modal-title'>Note Cancel</h4>
            </div>
            <form action='{$link}' method='post'>
                <div class='modal-body'>
                    <div class='form-group'>
                        <div class='input-group'>
<!--                            <span class='input-group-addon'>Note Cancel:</span>-->
                            <input name='book_code' class='form-control' id='dt_id_customer_book' style='display: none'>
                            <textarea name='note_cancel' placeholder='Note Cancel' style='margin: 0px; width: 553px; height: 227px;'></textarea>
                        </div>
                    </div>
                </div>
                <div class='modal-footer clearfix'>

                    <button type='button' class='btn btn-danger' data-dismiss='modal'><i class='fa fa-times'></i> Cancel</button>

                    <button type='submit' class='btn btn-primary pull-left'> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>"  ;
    
    $this->template->build('product-tour/book-list', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "grouptour/product-tour/book-list",
          'data'          => $data_array,
          'title'         => lang("Customer Book"),
          'category'      => $category,
          'sub_category'  => $sub_category,
          'foot'          => $foot,
          'css'           => $css,
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout('tableajax')
      ->build('product-tour/book-list');
  }
  
  function book_list_keseluruhan($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'book_list_keseluruhan_start_date'                   => $pst['cust_book_start_date'],
            'book_list_keseluruhan_end_date'                      => $pst['cust_book_end_date'],
            'book_list_keseluruhan_tour_title'                      => $pst['cust_book_title'],
            'book_list_keseluruhan_name'                 => $pst['cust_book_name'],
            'book_list_keseluruhan_status'                 => $pst['cust_book_status'],
            'book_list_keseluruhan_code'                   => $pst['cust_book_code'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('book_list_keseluruhan_start_date'),
        "end_date"        => $this->session->userdata('book_list_keseluruhan_end_date'),
         "title"          => $this->session->userdata('book_list_keseluruhan_tour_title'),
        "name"            => $this->session->userdata('book_list_keseluruhan_name'),
        "code"            => $this->session->userdata('book_list_keseluruhan_code'),
        "status"          => $this->session->userdata('book_list_keseluruhan_status'),
        "limit"           => 10,
        "id_users"        => $this->session->userdata("id"),
        );
//      if($data_array)
//        $this->debug($data_array, true);
//     }else{
//       $serach_data["start_date"] = date("Y-m-d");
//       $serach_data["end_date"] = date("Y-m-d");
//        $data = array(
//        "users"           => USERSSERVER,
//        "password"        => PASSSERVER,
//        "start_date"    => $serach_data["start_date"],
//        "end_date"      => $serach_data["end_date"],
//        "code"           => $code_tour_information,    
//        "id_users"      => $this->session->userdata("id"),
//        );
//     }
     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list-keseluruhan");  
    $data_array = json_decode($data);
//    print_r($data_array); die;
//    print $data_array->total; die;
     $url_list = site_url("grouptour/product-tour/ajax-book-list-keseluruhan/".$data_array->total);
    $url_list_halaman = site_url("grouptour/product-tour/ajax-halaman-book-list/".$data_array->total);
    
  // $this->debug($data_array, true);
// print_r($data); die;
//    $list = $data_array;
    $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
       
        <script type='text/javascript'>
             $(document).ready(function () { 
           
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });  
            })
        </script>";
    $foot .= "<script type='text/javascript'>"

      ."function get_list(start){"
        ."if(typeof start === 'undefined'){"
         ."start = 0;"
          ."}"
           ."$.post('{$url_list}/'+start, function(data){"
            ."$('#data_list').html(data);"
             ."$.post('{$url_list_halaman}/'+start, function(data){"
              ."$('#halaman_set').html(data);"
               ." });"
                ."});"
            ."}"
            ."get_list(0);"
      . "</script> ";
             
   // print_r($serach_data); die;
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_book_title', $this->session->userdata('book_list_keseluruhan_tour_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('cust_book_code', $this->session->userdata('book_list_keseluruhan_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('cust_book_start_date', $this->session->userdata('book_list_keseluruhan_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('cust_book_end_date', $this->session->userdata('book_list_keseluruhan_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_book_name', $this->session->userdata('book_list_keseluruhan_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Status</label><br>"
            . "{$this->form_eksternal->form_dropdown('cust_book_status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_keseluruhan_status')), ' class="form-control input-sm"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('product-tour/book-list', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "grouptour/product-tour/book-list",
          'data'          => $data_array,
          'title'         => lang("Customer Book"),
          'category'      => $category,
          'sub_category'  => $sub_category,
          'foot'          => $foot,
          'css'           => $css,
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout('tableajax')
      ->build('product-tour/book-list-keseluruhan');
  }
  
  function ajax_customer_tours($total = 0,$id_product_tour_information,$first_name,$last_name,$notelp,$status, $start = 0){
   
     //  $pst = $this->input->post(NULL);
    if($first_name || $last_name || $notelp || $status){
        
        $data = array(
                    "users"                       => USERSSERVER,
                    "password"                    => PASSSERVER,
                    "start"                       => $start,
                    "total"                       => $total,
                    "first_name"                  => $first_name,
                   "last_name"                    => $last_name,
                   "notelp"                       => $notelp,
                   "status"                       => $status,
                    "search_data_customer_tour"   => "search_data_customer_tour");
       
    }else{
        $data = array("users"                         => USERSSERVER,
                    "password"                        => PASSSERVER,
                    "start"                           =>$start,
                    "total"                           =>$total,
                    "search_data_customer_tour"       => "search_data_customer_tour");
    
    }
      if($id_product_tour_information){
        $data[]= array("id_product_tour_information"     =>$id_product_tour_information,
                  );
    }else{
        $data[]= array("id_product_tour_information"     =>0,
                  );
    }
   // print_r($data); die;
      $data = $this->curl_mentah(http_build_query($data), URLSERVER."json/json-midlle-system/get-customer-tour");  
      $data_array = json_decode($data);
     
   // print_r($data_array); die;
   
    foreach($data_array->data as $key => $value) {
      
        if($value->status == 1){
            $status = "Book";
        }elseif($value->status == 2){
            $status = "DP";
        }elseif($value->status == 3){
            $status = "Lunas";
        }
        
        if($value->child){
            $child = $value->child;
        }else{
            $child = 0;
        }
        
        if($value->adult){
            $adult = $value->adult;
        }else{
            $adult = 0;
        }
        
        if($value->infant){
            $inf = $value->infant;
        }else{
            $inf = 0;
        }
        
      $hasil .= "<tr>"
        . "<td>".$value->first_name." ".$value->last_name."</td>"
        . "<td>{$value->telphone}</td>"
        . "<td>{$value->email}</td>"
        ."<td>{$status}</td>"
        ."<td>{$adult}</td>"
        ."<td>{$child}</td>"
        ."<td>{$inf}</td>"
       // ."<td></td>"
       // ."<td></td>"
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
          . "<li><a href='".site_url("antavaya/product-tour/customer-detail/".$value->id_product_tour_book)."'>Detail</a></li>"
          . "<li><a href='".site_url("antavaya/product-tour/customer-payment/".$value->id_product_tour_book)."'>Payment</a></li>"      
          . "</ul>"
          . "</div>"
        . "</td>"
        . "</tr>";
        }
    
    print $hasil;
    die;
  }
  
  function ajax_halaman_customer_tours($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 10; 
    $config['uri_segment'] = 5; 
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
  
function customer_tour($id_product_tour_information = 0){
   
    $pst = $this->input->post(NULL);
   
    $search_data = array("first_name" => $pst["first_name"],
                         "last_name"  => $pst["last_name"],
                         "telp"  => $pst["telp"],
                         "status"  => $pst["status"],
                        );
    if($pst){
        $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                   "first_name"                                         => $pst["first_name"],
                   "last_name"                                         => $pst["last_name"],
                   "notelp"                                         => $pst["telp"],
                   "status"                                         => $pst["status"],
                    "search_total_customer_tour"                        => "search_total_customer_tour"
                    );
        
    }else{
        $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                    "search_total_customer_tour"                       => "search_total_customer_tour"
                    );
    }
    
    if($id_product_tour_information){
        $data[]= array("id_product_tour_information"     =>$id_product_tour_information,
                  );
    }else{
        $data[]= array("id_product_tour_information"     =>0,
                  );
    }
    
   //echo $data[0]['id_product_tour_information'];
  // print_r($data);die;
      $data = $this->curl_mentah(http_build_query($data), URLSERVER."json/json-midlle-system/get-customer-tour");  
      $detail = json_decode($data);
    
      if($pst['first_name']){
          $first_name = $pst['first_name'];
      }else{
          $first_name = 0;
      }
      
      if($pst['last_name']){
          $last_name = $pst['last_name'];
      }else{
          $last_name = 0;
      }
      
      if($pst["telp"]){
          $telp = $pst["telp"];
      }else{
          $telp = 0;
      }
      
      if($pst['status']){
          $status = $pst['status'];
      }else{
          $status = 0;
      }
   
      
   $jumlah_list = $detail->data[0]->total;  
  
    $url_list = site_url("antavaya/product-tour/ajax-customer-tours/".$jumlah_list."/".$id_product_tour_information."/".$first_name."/".$last_name."/".$telp."/".$status);
    $url_list_halaman = site_url("antavaya/product-tour/ajax-halaman-customer-tours/".$jumlah_list);
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

   $type_status = array(0 => "Pilih",
                        1 => "Book",
                        2 => "DP",
                        3 => "Lunas");
    $this->template->build('product-tour/main', 
      array(
            'url'           => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'          => "master-tour",
            'title'         => lang("Customer Tour"),
            'foot'          => $foot,
            'type_status'   => $type_status,
            'search_data'   => $search_data,
         'menutable'   => $menutable,
            'menu_action' => 5
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('product-tour/main');

  }
  
  function customer_detail($id_product_tour_book){
   
    $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                    "search_detail_customer_tour"                       => "search_detail_customer_tour",
                    "id_product_tour_book"                       => $id_product_tour_book
                    );
     
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-tour");  
      $detail = json_decode($data);
   
        
   
    $this->template->build('product-tour/customer-detail', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "master-tour",
            'title'       => lang("Customer Tour"),
            'customer_adult'    => $detail->data->customer_adult,
            'customer_child'    => $detail->data->customer_child,
            'customer_inf'      => $detail->data->customer_inf,
            'data'      => $detail->data,
            'menutable'   => $menutable,
            'menu_action' => 5
          ));
    $this->template
      ->set_layout('tableajax')
      ->build('product-tour/customer-detail');

  }
  
    function change_tour($book_code,$code_change=""){
   
    $pst = $this->input->post(NULL);
    $data = array(
                    "users"             => USERSSERVER,
                    "password"          => PASSSERVER,
                    "title"             => $pst["title"],
                    "start_date"        => $pst["start_date"],
                    "end_date"          => $pst["end_date"],
                    "kategori1"         => $pst["kategori1"],
                    "kategori2"         => $pst["kategori2"],
                    "code"              => $book_code,
                    "code_change_book"  => $code_change,
                    "id_users"          => $this->session->userdata("id"),
                    );
    
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-change-book-tour");  
      $detail_array = json_decode($data);
      
//      $data = array(
//                    "users"             => USERSSERVER,
//                    "password"          => PASSSERVER,
//                    "title"             => $pst["title"],
//                    "start_date"        => $pst["start_date"],
//                    "end_date"          => $pst["end_date"],
//                    "kategori1"         => $pst["kategori1"],
//                    "kategori2"         => $pst["kategori2"],
//                    "code"              => $book_code,
//                    "code_change_book"  => $code_change,
//                    "id_users"          => $this->session->userdata("id"),
//                    );
//    
//      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-change-book-tour");  
//      $detail_array = json_decode($data);
      
      
      if($detail_array->status == "2"){
        if($detail_array->status_update == "2"){
          $this->session->set_flashdata('success', 'Tour Berhasil di Pindahkan dengan kode book baru '.$detail_array->kode_book);
          redirect("store/list-customer-change-book");
        }elseif($detail_array->status_update == "4"){
            $post2 = array(
            "users"       => USERSSERVER,
            "password"    => PASSSERVER,
            "code"        => $book_code,
             "status"       => 1,      
            "url"        => base_url()."store/list-customer-change-book",
            "id_users"    => $this->session->userdata("id"),
          );
       $data_array2 =   $this->curl_mentah($post2, URLSERVER."json/json-mail/info-change-approval");
          $data_array2 = json_decode($data_array2);
//        print "<pre>";
//        print_r($data_array); 
//        print "</pre>";
//        die;
          $this->session->set_flashdata('success', 'Pindah Tour Perlu Approval dengan kode book baru '.$detail_array->kode_book);
          redirect("store/list-customer-change-book");
        }
      }else{
        $this->session->set_flashdata('failed', 'gagal Change Tour');
        redirect("store/list-customer-change-book");
      }
      
    /* print "<pre>";
      print_r($detail_array);
      print "</pre>"; die; */
   $css = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>
     <link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />
<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />
      <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
   
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
          <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
              
        <script type='text/javascript'>
          
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
                $(function() {
                $('#tableboxy').dataTable();
                $('#tableboxydesc').dataTable({
                  'order': [[ 0, 'desc' ]]
                });
            });

        </script>";
    
    $this->template->build('product-tour/change-tour', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "master-tour",
            'title'       => lang("Customer Tour"), 
          'serach_data'                => $pst,
            'data'              => $detail_array,
            'menutable'         => $menutable,
            'menu_action'       => 5,
            'foot'              =>$foot,
            'css'               =>$css
          ));
    $this->template
      ->set_layout('default')
      ->build('product-tour/change-tour');

  }
  
  function change_tour_person($customer_code,$code_change=""){
   
    $pst = $this->input->post(NULL);
    $data = array(
                    "users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                    "title"           => $pst["title"],
                    "id_users"        => $this->session->userdata("id"),
                    "start_date"      => $pst["start_date"],
                    "end_date"        => $pst["end_date"],
                    "kategori1"       => $pst["kategori1"],
                    "kategori2"           => $pst["kategori2"],
                    "code"                => $customer_code,
                    );
    
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-change-person-book-tour");  
      $detail_array = json_decode($data);
     
      if($code_change){
        $data = array(
                    "users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                    "id_users"        => $this->session->userdata("id"),
                    "code"            => $customer_code,
                    "code_change"     => $code_change
                    );
    
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/insert-change-person-book-tour");  
      $detail_array = json_decode($data);
      
      }
      if($detail_array->status == "2"){
        if($detail_array->status_update == "2"){
          $this->session->set_flashdata('success', 'Tour Berhasil di Pindahkan dengan kode book baru '.$detail_array->kode_book);
          redirect("store/list-customer-change-pax");
        }elseif($detail_array->status_update == "4"){
             $post2 = array(
            "users"       => USERSSERVER,
            "password"    => PASSSERVER,
            "code"        => $customer_code,
            "url"        => base_url()."list-customer-change-pax",
            "status"       => 2,     
            "id_users"    => $this->session->userdata("id"),
          );
       $data_array2 =   $this->curl_mentah($post2, URLSERVER."json/json-mail/info-change-perpax-approval");
          $data_array2 = json_decode($data_array2);
          
          $this->session->set_flashdata('success', 'Pindah Tour Perlu Approval dengan kode book baru '.$detail_array->kode_book);
          redirect("store/list-customer-change-pax");
        }
      }else{
        $this->session->set_flashdata('failed', 'gagal Change Tour');
        redirect("store/list-customer-change-pax");
      }
      
    /* print "<pre>";
      print_r($detail_array);
      print "</pre>"; die; */
   $css = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>
     <link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />
<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />
      <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
   
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
          <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datepicker/bootstrap-datepicker.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
              
        <script type='text/javascript'>
          
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                format: 'yyyy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
                $(function() {
                $('#tableboxy').dataTable();
                $('#tableboxydesc').dataTable({
                  'order': [[ 0, 'desc' ]]
                });
            });

        </script>";
    
        
   
    $this->template->build('product-tour/change-tour-person', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "master-tour",
            'title'       => lang("Customer Tour"), 
          'serach_data'                => $pst,
            'data'              => $detail_array,
            'menutable'         => $menutable,
            'menu_action'       => 5,
            'foot'              =>$foot,
            'css'               =>$css
          ));
    $this->template
      ->set_layout('default')
      ->build('product-tour/change-tour-person');

  }
  
  function customer_payment($id_product_tour_book = 0){
    
      $pst = $this->input->post(NULL);
      
      $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                    "search_detail_customer_tour_payment"        => "search_detail_customer_tour_payment",
                    "id_product_tour_book"                       => $id_product_tour_book
                    );
     
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-tour");  
      $detail = json_decode($data);
      
         $sess = array(
        "gagal_status"        => "",
      );
        $this->session->unset_userdata($sess);
      
     if($pst){
         
          $payment = $pst["total_payment"] + $pst["nominal"];
       
        $gagal = "true";
        $gagal_status = "";
        if($pst["nominal"] == ""){
            $gagal = "false";
            $gagal_status = 1;
        }
        
        if($payment > $pst["total_price"]){
            $gagal = "false";
            $gagal_status = 2;
        }
        
       /* if(is_numeric($pst["nominal"]) == false){
           echo "gagal";
       }else{
           echo "berhasil"; 
       } */
        
        if($gagal == "true"){
          $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                   "id_product_tour_book"                           => $pst["id_detail"],
                   "nominal"                                        => $pst["nominal"],
                   "dp"                                             => $pst["dp"],
                   "total_price"                                    => $pst["total_price"],
                   "total_payment"                                  => $pst["total_payment"],
                   "payment"                                        => $payment,
                   "id_users"                                      => $this->session->userdata("id"),
                   "save_data_payment"                             => "save_data_payment"
                    );
     
      $data2 = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-tour");  
      $detail2 = json_decode($data2);
         redirect("antavaya/product-tour/customer-tour/");
            
        }
        
      }
     
     
     
    $this->template->build('product-tour/customer-payment', 
      array(
            'url'                   => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'                  => "antavaya/product-tour",
            'detail'                => $detail->detail_product_tour_book,
            'title'                 => lang("Customer Payment"),
            'data'                  => $detail->data,
            'data_payment'          => $detail->data_payment,
            'data_tour'             => $detail->tour_inf,
            'gagal_status'          => $gagal_status,
            'nominal'               => $pst["nominal"],
            'breadcrumb'  => array(
                    "product_tour"  => "antavaya/product_tour"
                ),
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/customer-payment');
  }
  function ajax_add_row_book_tour(){
     $pos = $_POST['name'];
     $number = $_POST['datarow'];
     if($pos){
       $type_bed = "type_bed".$pos."[]";
       $qty = "qty".$pos."[]";
     }else{
       $type_bed  = "type_bed1[]";
       $qty       = "qty1[]";
     }
     $class_data = "data-bed".$number;
     $id_data = "data_type_bed".$number;
     $id_qty = "data_qty".$number;
    $html = "<div class='box-body col-sm-5 {$class_data} '>
      <div class='control-group'>
        <label>Type Bed</label>";
        $html .= $this->form_eksternal->form_dropdown($type_bed, $this->session->userdata('type_bed2'), "", 'onblur="tambah_test()" id='.$id_data.' class="form-control type_bedq input-sm"');
      $html .= "</div>"
    ."</div>";
      
    $html .= "<div class='box-body col-sm-5 {$class_data}'>
      <div class='control-group'>
        <label>Qty</label>";
    $html .= $this->form_eksternal->form_input($qty, "", 'onblur="tambah_test()" id='.$id_qty.' class="form-control input-sm" placeholder="Qty"');
    $html .= "</div></div>";
    $html .= "<div class='box-body col-sm-2 {$class_data}'>
      <div class='control-group'>
       <br>
        <a href='javascript:void(0)' onclick='tambah_items_delete({$number})' class='btn btn-danger'>".lang("X")."</a>
      </div>
            <br>
    </div> ";
    
    print $html;
    die;
  }
  
  function ajax_add_row_additional_book_tour(){
     $pos = $_POST['name'];
     $pos++;
    
    $html = "<div class='box-body col-sm-6'>
      <div class='control-group'>
        <label><div class='number_additional'>Additional {$pos}</div></label>";
        $html .= $this->form_eksternal->form_dropdown('type_add[]', $this->session->userdata("arradd"), "", ' id="data_type_bed1" class="form-control type_bedq input-sm"');
      
      $html .= "</div>"
    ."</div>";
      
    $html .= "<div class='box-body col-sm-6' style='padding-bottom: 7%'>
      <div class='control-group'>";
   
    $html .= "</div>"
    ."</div><br><br><br>";
    
    print $html;
    die;
  }
  
  /* function ajax_price_tour(){
     $pos = $_POST['name'];
     $pos_data = $_POST['dasar_adult_triple_twin'];
    
    
    $html = "<div id='test_data1'><div class='control-group data-price' id='wus_{$pos}'>
      <table width='100%' class='table'>
      <tr>
      <th>Date</th>
      <th>Adult Triple Twin</th>
      <th>Child Twin Bed</th>
      <th>Child Extra Bed</th>
      <th>Child No Bed</th>
      <th>SGL SUPP</th>
      <th>Total</th>
      </tr>
        <tr>
      <td> ".date('d M Y', strtotime($detail->information->start_date))." - ".date('d M Y', strtotime($detail->information->end_date))."</td>
      <td >".print_r($pos_data)."</td>
      <td>tes2</td>
      <td>test3</td>
      <td>test4</td>
      <td>test5</td>
      <td>test6</td>                                                                                                                                                </span></td>
    </tr></table></div></div>";
    
    print $html;
    die;
  } */
  function ajax_add_row_room_book_tour(){
    
     $number = $_POST['datarow1'];
       $pos = $_POST['name1'];  
       $pos = $pos + 1;
       
       $type_bed = "type_bed".$pos."[]";
       $data_room_type = "room_type".$pos."[]";
       $qty = "qty".$pos."[]";
       $room_type = array("1" => "SINGLE",
                           "2"  => "DOUBLE",
                            "3" => "TRIPLE");
     $class_data = "data-bed".$number;
       $class_data_room = "data-room".$pos;
     $id_data = "data_type_bed".$number;
     $id_qty = "data_qty".$number;
    $html = " <script>"
           ."function tambah_items{$_POST['name1']}(){"
           ."var num = $('.number').length;"
      ."var num_addrow = $('.type_bedq').length;"
      ."var jmldata = (num_addrow + 1);"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-book-tour")."',"
       ."data: {name: num, datarow: jmldata},"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-items-{$_POST['name1']}').append(data);"
      ."},"
    ."});"
        ."}"
        ."</script>"; 
   
    $html .= "<br><div class='box box-info $class_data_room'>
            <div class='box-header'>
           <h3 class='box-title'> <div class='number'> Room ".$pos ." </div></h3>";
    $html .= "</div><div class='box-body pad'>";
//    $html .= "<div class='box-body col-sm-4'>
//      <div class='control-group'>
//        <label>ROOM TYPE</label>";
//        $html .= $this->form_eksternal->form_dropdown($data_room_type, $room_type, "", ' id='.$id_data.' class="form-control  input-sm"');
//     
//     $html .= "</div>
//    </div><br> <br> <br> <br>   <br>";
    $html .= "<div class='box-body col-sm-5 $class_data'>
      <div class='control-group'>
        <label>Type Bed</label>";
        $html .= $this->form_eksternal->form_dropdown($type_bed, $this->session->userdata('type_bed'), "", 'onblur="tambah_test()" id='.$id_data.' class="form-control type_bedq input-sm"');
      $html .= "</div>"
    ."</div>";
      
    $html .= "<div class='box-body col-sm-5 $class_data'>
      <div class='control-group'>
        <label>Qty</label>";
    $html .= $this->form_eksternal->form_input($qty, "", 'onblur="tambah_test()" id='.$id_qty.' class="form-control input-sm" placeholder="Qty"');
    $html .= "</div></div>";
    $html .= "<div class='box-body col-sm-2 {$class_data}'>
      <div class='control-group'>
       <br>
        <a href='javascript:void(0)' onclick='tambah_items_delete({$number})' class='btn btn-danger'>".lang("X")."</a>
      </div>
            <br>
    </div> ";
    $html .= "<br><br><br>
  <span id='tambah-items-{$_POST['name1']}'>
                    </span>
             <a href='javascript:void(0)' onclick='tambah_items{$_POST['name1']}()' class='btn btn-info'>".lang('Add Bed')."</a>
                    <br><br>
      </div>";
    print $html;
    die;
  }
  function book_tour($book_code){
    
    $pst = $this->input->post(NULL);
//    $this->debug($pst, true);
   /* print "<pre>";
   print_r($pst); 
   print "</pre>";
   die; */
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-information-detail");
    $detail_array = json_decode($detail);
    if($detail_array->information->dp >= $detail_array->information->seat){
      $this->session->set_flashdata('notice', 'Full');
      redirect("tour/search");
    }
//    $this->debug($detail_array, true);
//    print "<pre>";
//    print_r($detail_array);
//    print "</pre>";
//    die; 
    $currency = $detail_array->information->price->currency;
   $adl_triple_twin = $detail_array->information->price->adult_triple_twin;
   $chl_twin_bed = $detail_array->information->price->child_twin_bed;
   $chl_extra_bed = $detail_array->information->price->child_extra_bed;
   $chl_no_bed = $detail_array->information->price->child_no_bed;
   $sgl_supp = $detail_array->information->price->sgl_supp;
   
   $arr_additional = array("0" => "-Pilih-"); 
    $arr_additional2 = array("1" => "data"); 
   foreach ($detail_array->tour->additional as $val) {
       $arr_additional[$val->id_product_tour_master_additional] =  $val->name." ,Price ".$val->nominal;
   }
    $ses_arr_add = array(
           "arradd"   => $arr_additional,
          );
                
    $this->session->set_userdata($ses_arr_add); 
    
   
   // print_r($this->session->userdata("arradd")); die;
   /*print "<pre>";
   print_r($arr_additional); 
   print "</pre>"; die; */
   
   if($adl_triple_twin){
     $adl_triple_twin = $adl_triple_twin;
   }else{
     if($adl_triple_twin == ""){
       $adl_triple_twin = "";
     }else{
       $adl_triple_twin = $this->session->userdata("adl_triple_twin");
     }
     
   }
   
   if($chl_twin_bed){
     $chl_twin_bed = $chl_twin_bed;
   }else{
     if($chl_twin_bed == ""){
       $chl_twin_bed = "";
     }else{
       $chl_twin_bed = $this->session->userdata("chl_twin_bed");
     } 
   }
   
   if($chl_extra_bed){
     $chl_extra_bed = $chl_extra_bed;
   }else{
     if($chl_extra_bed == ""){
       $chl_extra_bed = "";
     }else{
       $chl_extra_bed = $this->session->userdata("chl_extra_bed");
     }
     
   }
   
   if($chl_no_bed){
     $chl_no_bed = $chl_no_bed;
   }else{
     if($chl_no_bed == ""){
       $chl_no_bed ="";
     }else{
       $chl_no_bed = $this->session->userdata("chl_no_bed");
     }
     
   }
   
   if($sgl_supp){
     $sgl_supp = $sgl_supp;
   }else{
     if($sgl_supp == ""){
       $sgl_supp = "";
     }else{
       $sgl_supp = $this->session->userdata("sgl_supp");
     }
     
   }
   
   $adl_triple_twin1 = number_format($adl_triple_twin, 0, ".", ",");
   $chl_twin_bed1 = number_format($chl_twin_bed, 0, ".", ",");
   $chl_extra_bed1 = number_format($chl_extra_bed, 0, ".", ",");
   $chl_no_bed1 = number_format($chl_no_bed, 0, ".", ",");
   $sgl_supp1 = number_format($sgl_supp, 0, ".", ",");
   
//   $data_type2 = array("0" => "Type Bed");
   $data_type2 = array();
   if($adl_triple_twin > 0){
     $adl_triple_twin3 = array("1" => "Adult Triple Twin, Price {$currency} {$adl_triple_twin1}");
   }else{
     $adl_triple_twin3 = array();
   }
   
   if($chl_twin_bed > 0){
     $chl_twin_bed3 = array("2" => "Child Twin Bed, Price {$currency} {$chl_twin_bed1}");
   }else{
     $chl_twin_bed3 = array();
   }
   
   if($chl_extra_bed > 0){
     $chl_extra_bed3 = array("3" => "Child Extra Bed, Price {$currency} {$chl_extra_bed1}");
   }else{
     $chl_extra_bed3 = array();
   }
   
   if($chl_no_bed > 0){
     $chl_no_bed3 = array("4" => "Child No Bed, Price {$currency} {$chl_no_bed1}");
   }else{
     $chl_no_bed3 = array();
   }
   
   $single_adult = $adl_triple_twin + $sgl_supp;
   $single_adult1 = number_format($single_adult, 0, ".", ",");
   
   if($single_adult > 0){
     $single_adult3 = array("5" => "Single Adult, Price {$currency} {$single_adult1}");
   }else{
     $single_adult3 = array();
   }
   
   $data_array4 = $data_type2 + $adl_triple_twin3 + $chl_twin_bed3 + $single_adult3;
   $data_array5 = $data_type2 + $chl_twin_bed3 + $chl_extra_bed3 + $chl_no_bed3;
//  $data_array4 = array_merge($data_type2,$adl_triple_twin3,$single_adult3);
//  $data_array5 = array_merge($data_type2,$chl_twin_bed3,$chl_extra_bed3,$chl_no_bed3);
  
  $ses_type_bed = array(
           "adl_triple_twin"   => $adl_triple_twin,
           "chl_twin_bed"       => $chl_twin_bed,
           "chl_extra_bed"      => $chl_extra_bed,
           "chl_no_bed"         => $chl_no_bed,
           "sgl_supp"           => $sgl_supp,
           "single_adult"           => $single_adult,
           "type_bed"           => $data_array4,
           "type_bed2"           => $data_array5
          );
          $this->session->set_userdata($ses_type_bed);  
  
//  print_r($data_array4);
//  die;
  
  
//   $type_bed = array("0"      => "Type Bed",
//                    "1"       => "Adult Triple Twin, Price {$currency} {$adl_triple_twin1}",
//                    "2"       => "Child Twin Bed, Price {$currency} {$chl_twin_bed1}",
//                    "3"       => "Child Extra Bed, Price {$currency} {$chl_extra_bed1}",
//                    "4"       => "Child No Bed, Price {$currency} {$chl_no_bed1}",
//                    "5"       => "SGL SUPP, Price {$currency} {$sgl_supp1}",
//                    );
                    
        /*$data_bed = array("0" => "0",
                    "Adult Triple Twin" => $detail_array->information->price->adult_triple_twin,
                    "Child Twin Bed"    => $detail_array->information->price->child_twin_bed,
                    "Child Extra Bed"   => $detail_array->information->price->child_extra_bed,
                    "Child No Bed"      => $detail_array->information->price->child_no_bed,
                    "SGL SUPP"    => $detail_array->information->price->sgl_supp,
                    ); */
                    
      /* $type_bed = array("0" => "Type Bed",
                    $detail_array->information->price->adult_triple_twin => "Adult Triple Twin, Price {$adl_triple_twin}",
                    $detail_array->information->price->child_twin_bed => "Child Twin Bed, Price {$chl_twin_bed}",
                    $detail_array->information->price->child_extra_bed => "Child Extra Bed, Price {$chl_extra_bed}",
                    $detail_array->information->price->child_no_bed => "Child No Bed, Price {$chl_no_bed}",
                    $detail_array->information->price->sgl_supp => "Child AGL SUPP, Price {$sgl_supp}",
                    );  */
                    
//     $ses_type_bed = array(
//           "adl_triple_twin"   => $adl_triple_twin,
//           "chl_twin_bed"       => $chl_twin_bed,
//           "chl_extra_bed"      => $chl_extra_bed,
//           "chl_no_bed"         => $chl_no_bed,
//           "sgl_supp"           => $sgl_supp,
//          // "type_bed"           => $type_bed
//          );
//          $this->session->set_userdata($ses_type_bed);               
     
       $dt_type_bed = "data_type_bed";
       $dt_qty = "data_qty";
    
    $foot = "<script>"
      
      . "$(document).on('click', '.del-req', function(evt){"
        . "var target = $(this).attr('isi');"
        . "$('#'+target).remove();"
      . "});"
     
      . "$(document).on('click', '#add-discount-req', function(evt){"
        . "$.post('".site_url('grouptour/product-tour/add-row-discount')."', function(data){"
          . "$('#tempat-discount-req').append(data);"
        . "});"
      . "});"
     
     ."function tambah_items_additional(){"
      ."var num = $('.number_additional').length;"
      ."var dataString2 = 'name='+ num;"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-additional-book-tour")."',"
      ."data: dataString2,"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-additional').append(data);"
      ."},"
    ."});"
        ."}"
      ."function numberformat(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }"
      ."function tambah_test(){"
      ."var num_addrow = $('.type_bedq').length;"
       ."var dasar_adult_triple_twin = $('input[name=dasar_adult_triple_twin]').val()* 1;"
      ."var dasar_child_twin_bed = $('input[name=dasar_child_twin_bed]').val()* 1;"
      ."var dasar_child_extra_bed = $('input[name=dasar_child_extra_bed]').val()* 1;"
      ."var dasar_child_no_bed = $('input[name=dasar_child_no_bed]').val()* 1;"
      ."var sgl_supp = $('input[name=sgl_supp]').val()* 1;"
      ."var tax_ins = $('input[name=tax_and_insurance]').val()* 1;"
      ."var disc = $('input[name=discount]').val()* 1;"
      ."var status_discount = $('input[name=status_discount]').val();"
      ."var total_adl_qty = 0;"
      ."var total_adl_all = 0;"
      ."var total_chtb_qty = 0;"
      ."var total_chtb_all = 0;"
      ."var total_cheb_qty = 0;"
      ."var total_cheb_all = 0;"
      ."var total_chnb_qty = 0;"
      ."var total_chnb_all = 0;"
      ."var total_sgl_supp_qty = 0;"
      ."var total_sgl_supp_all = 0;"
      ."var total_price_all = 0;"
      ."var total_tax_ins = 0;"
      ."var total_qty = 0;"
      ."var ppn = 0;"
      ."var total_all_pax = 0;"
      ."var hasil_keseluruhan = 0;"
      ."var ank = 0;"
      ."var disc_adl = 0;"
      ."var disc_chtb = 0;"
      ."var disc_cheb = 0;"
      ."var disc_chnb = 0;"
      ."var disc_sgl_supp = 0;"      
      ."var type_bed = 'data_type_bed';"
      ."var data_qty = 'data_qty';"
        ."for (var i = 1; i <= num_addrow; i++) {"
           ."ank = ank + 1;"
           ."aa = type_bed + ank;"
           ."bb = data_qty + ank;"
           ."var type_bd = $('#'+aa+'').val();"
                 
            ."if(type_bd == '1'){
              var dt_qty1 = parseFloat($('#'+bb+'').val());
                var dsr_adl = dasar_adult_triple_twin * dt_qty1;
                  if(dsr_adl != ''){
                    total_adl_qty +=  dt_qty1;
                  }else{
                    total_adl_qty =0;
                  }
                total_adl_all = total_adl_all + dsr_adl;
                if(status_discount == 'Nominal'){
                disc_adl = total_adl_all - (disc * total_adl_qty);
                }else if(status_discount == 'Persen'){
                disc_adl = ((total_adl_all * disc)/100);
                }
            }"      
         ."if(type_bd == '2'){
           var dt_qty2    = parseFloat($('#'+bb+'').val());
           var dsr_chtb   = dasar_child_twin_bed * dt_qty2;
           if(dsr_chtb != ''){
           total_chtb_qty   += dt_qty2;
          }else{
           total_chtb_qty =0;
          }
          
           total_chtb_all = total_chtb_all + dsr_chtb;
           if(status_discount == 'Nominal'){
            disc_chtb = total_chtb_all - (disc * total_chtb_qty);
            }else if(status_discount == 'Persen'){
            disc_chtb = ((total_chtb_all * disc)/100);
            }
          }"
          ."if(type_bd == '3'){
           var dt_qty3    = parseFloat($('#'+bb+'').val());
           var dsr_cheb   = dasar_child_extra_bed * dt_qty3;
           if(dsr_cheb != ''){
            total_cheb_qty   += dt_qty3;
           }else{
            total_cheb_qty = 0;
           }
            
           total_cheb_all = total_cheb_all + dsr_cheb;
           if(status_discount == 'Nominal'){
            disc_cheb = total_cheb_all - (disc * total_cheb_qty);
            }else if(status_discount == 'Persen'){
            disc_cheb = ((total_cheb_all * disc)/100);
            }
          }"
          ."if(type_bd == '4'){
           var dt_qty4    = parseFloat($('#'+bb+'').val());
           var dsr_chnb   = dasar_child_no_bed * dt_qty4;
           if(dsr_chnb != ''){
           total_chnb_qty   += dt_qty4;
           }else{
           total_chnb_qty = 0;
           }
           total_chnb_all = total_chnb_all + dsr_chnb;
            if(status_discount == 'Nominal'){
            disc_chnb = total_chnb_all - (disc * total_chnb_qty);
            }else if(status_discount == 'Persen'){
            disc_chnb = ((total_chnb_all * disc)/100);
            }
          }"
        ."if(type_bd == '5'){
           var dt_qty5    = parseFloat($('#'+bb+'').val());
           var dsr_sgl_supp   = sgl_supp * dt_qty5;
           if(dsr_sgl_supp != ''){
              total_sgl_supp_qty   += dt_qty5;
            }else{
            total_sgl_supp_qty = 0;
            }
            
           total_sgl_supp_all = total_sgl_supp_all + dsr_sgl_supp;
            if(status_discount == 'Nominal'){
            disc_sgl_supp = total_sgl_supp_all - (disc * total_sgl_supp_qty);
            }else if(status_discount == 'Persen'){
            disc_sgl_supp = ((total_sgl_supp_all * disc)/100);
            }
          }"
        ."}"
            ." var hasil_adl_twin = (isNaN(total_adl_qty)) ? 0 : total_adl_qty;"
            ." $('#adl_twin').text(hasil_adl_twin);"
            ." var hasil_adl_twin_disc = (isNaN(disc_adl)) ? 0 : disc_adl;"
            ." $('#disc_adl_twin').text(numberformat(hasil_adl_twin_disc));"
            ." var hasil_total_adl_all = (isNaN(total_adl_all)) ? 0 : total_adl_all;"
            ." $('#total_adl_twin').text(numberformat(hasil_total_adl_all));"
            ." var hasil_chtb_qty = (isNaN(total_chtb_qty)) ? 0 : total_chtb_qty;"
            ." $('#chl_tb').text(hasil_chtb_qty);"
             ." var hasil_total_chtb_all = (isNaN(total_chtb_all)) ? 0 : total_chtb_all;"
            ." $('#total_chl_tb').text(numberformat(hasil_total_chtb_all));"
            ." var hasil_total_chtb_all_disc = (isNaN(disc_chtb)) ? 0 : disc_chtb;"
            ." $('#disc_chl_tb').text(numberformat(hasil_total_chtb_all_disc));"
            ." var hasil_cheb_qty = (isNaN(total_cheb_qty)) ? 0 : total_cheb_qty;"
            ." $('#chl_eb').text(hasil_cheb_qty);"
            ." var hasil_total_cheb_all = (isNaN(total_cheb_all)) ? 0 : total_cheb_all;"
            ." $('#total_chl_eb').text(numberformat(hasil_total_cheb_all));"
            ." var hasil_total_cheb_all_disc = (isNaN(disc_cheb)) ? 0 : disc_cheb;"
            ." $('#disc_chl_eb').text(numberformat(hasil_total_cheb_all_disc));"
            ." var hasil_chnb_qty = (isNaN(total_chnb_qty)) ? 0 : total_chnb_qty;"
            ." $('#chl_nb').text(hasil_chnb_qty);"
            ." var hasil_total_chnb_all = (isNaN(total_chnb_all)) ? 0 : total_chnb_all;"
            ." $('#total_chl_nb').text(numberformat(hasil_total_chnb_all));"
            ." var hasil_total_chnb_all_disc = (isNaN(disc_chnb)) ? 0 : disc_chnb;"
            ." $('#disc_chl_nb').text(numberformat(hasil_total_chnb_all_disc));"
            ." var hasil_sgl_supp_qty = (isNaN(total_sgl_supp_qty)) ? 0 : total_sgl_supp_qty;"
            ." $('#sgl_supp').text(hasil_sgl_supp_qty);"
            ." var hasil_total_sgl_supp_all_disc = (isNaN(disc_sgl_supp)) ? 0 : disc_sgl_supp;"
            ." $('#disc_sgl_supp').text(numberformat(hasil_total_sgl_supp_all_disc));"
             ." var hasil_total_sgl_supp_all = (isNaN(total_sgl_supp_all)) ? 0 : total_sgl_supp_all;"
            ." $('#total_sgl_supp').text(numberformat(hasil_total_sgl_supp_all));"
      ." total_qty = total_adl_qty + total_chtb_qty + total_cheb_qty + total_chnb_qty + total_sgl_supp_qty;"
      ." var hasil_total_qty = (isNaN(total_qty)) ? 0 : total_qty;"
      ." $('#tax').text(hasil_total_qty);"
      . "total_tax_ins = hasil_total_qty * tax_ins;"
      ." var hasil_total_tax_ins = (isNaN(total_tax_ins)) ? 0 : total_tax_ins;"
      ." $('#total_tax').text(numberformat(hasil_total_tax_ins));"
      ." total_price_all = parseFloat(hasil_total_adl_all + hasil_total_chtb_all + hasil_total_cheb_all + hasil_total_chnb_all + hasil_total_sgl_supp_all + hasil_total_tax_ins);"
      ." total_price_person = parseFloat(hasil_total_adl_all + hasil_total_chtb_all + hasil_total_cheb_all + hasil_total_chnb_all + hasil_total_sgl_supp_all);"
      ." $('.tot_price').text(numberformat(total_price_person));"
      ." total_person_disc = parseFloat(hasil_adl_twin_disc + hasil_total_chtb_all_disc + hasil_total_cheb_all_disc + hasil_total_chnb_all_disc + hasil_total_sgl_supp_all_disc);"
      ." $('.disc_tot_all').text(numberformat(total_person_disc));"
      ." hasil_keseluruhan = total_price_all - total_person_disc;"
     // ."if(status_discount == 'Nominal'){"
     // ." hasil_keseluruhan = total_price_all - (disc * total_price_person);"
     // ."}else if(status_discount == 'Persen'){"
     // ."hasil_price_person = ((total_price_person * disc)/100);"
     // ."hasil_keseluruhan = total_price_all - hasil_price_person; "
     // ." $('.tot_discount').text(numberformat(hasil_price_person));"
     // ."}"
      ." $('.tot_all').text(numberformat(hasil_keseluruhan));"
      ." ppn = parseFloat((1 * hasil_keseluruhan)/100);"
      ." $('.ppn').text(numberformat(ppn));"
      ." total_all_pax = ppn + hasil_keseluruhan;"
      ." $('.total_all').text(numberformat(total_all_pax));"
      ." $('#total_pr').val(total_all_pax);"
      ."}"
      
      . "function hitung_information(){"
        . "var adult_triple_twin          = $('#jml_adult').val() * 1;"
        . "var dasar_adult_triple_twin    = $('input[name=dasar_adult_triple_twin]').val() * 1;"
      
        . "var child                    = $('#jml_child').val() * 1;"
        . "var dasar_child_twin_bed    = $('input[name=dasar_child]').val() * 1;"
      
        . "var infant         = $('#jml_infant').val() * 1;"
        . "var dasar_infant   = $('input[name=dasar_infant]').val() * 1;"
      
        . " var total_adult   = adult * dasar_adult;"
        . " var total_child   = child * dasar_child;"
        . " var total_infant  = infant * dasar_infant;"
      
        . " var total = total_adult + total_child + total_infant;"
      
        . "$('#harga_adult').text(total_adult);"
        . "$('#harga_child').text(total_child);"
        . "$('#harga_infant').text(total_infant);"
        . "$('#harga_total').text(total);"
      . "}"
      ."function tambah_items(){"
      ."var num = $('.number').length;"
      ."var num_addrow = $('.type_bedq').length;"
      ."var jmldata = (num_addrow + 1);"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-book-tour")."',"
      ."data: {name: num, datarow: jmldata},"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-items').append(data);"
      ."},"
    ."});"
        ."}"
      ."function tambah_items_delete(id){"
      ."var num = $('.data-bed'+id+'').remove();"
        ."}"
      ."function tambah_delete_room(id){"
      ."var num = $('.data-room'+id+'').remove();"
        ."}"
      ."function tambah_item_rooms(){"
      ."var numItems = $('.number').length;"
    //  ."var dataString = 'name1='+ numItems;"
      ."var jml = (numItems + 1);"
      ."$('#jml_room').val(jml);"
      ."var num_addrow = $('.type_bedq').length;"
      ."var jmldata = (num_addrow + 1);"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-room-book-tour")."',"
      ."data: {name1: numItems, datarow1: jmldata},"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-item-rooms').append(data);"
      ."},"
    ."});"
        ."}"
      . "</script>";
    $foot .= "<script>
function FormatCurrency(objNum)
{
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue)
   {
     num = MoneyToNumber(num);
     if (isNaN(num))
     {
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
       {
        // alert(num.split('.')[1]);
         objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else
       {
         objNum.value = AddCommas(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function MoneyToNumber(num)
{
   return (num.replace(/,/g, ''));
}

function AddCommas(num)
{
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+=',';
   }
   return numArr.reverse().join('');
} 
        
function formatCurrency(num) {
   num = num.toString().replace(/\$|\,/g,'');
   if(isNaN(num))
   num = '0';
   sign = (num == (num = Math.abs(num)));
   num = Math.floor(num*100+0.50000000001);
   cents = num0;
   num = Math.floor(num/100).toString();
   for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
   num = num.substring(0,num.length-(4*i+3))+'.'+
   num.substring(num.length-(4*i+3));
   return (((sign)?'':'-') + num);
}
</script>";
   
    $this->template->build('product-tour/book-tour', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/product-tour",
            'title'       => "Form Book Tour",
            'detail'      => $detail_array,
            'breadcrumb'  => array(
              "product_tour"  => "grouptour/product_tour"
            ),
            'foot'        => $foot,
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/book-tour');
  }
  
  function book_info(){
    $pst = $this->input->post(NULL);
//    $this->debug($pst, true);
    
    
    
    
    if($pst['jumlah_room']){
      $jml_room = $pst['jumlah_room'];
    }else{
      $jml_room = $this->session->userdata('jml_room');
    }
                        
     $ses_type_bed = array(
           "jml_room"   => $jml_room
          );
          $this->session->set_userdata($ses_type_bed);     
    
          if($this->session->userdata('jml_room')){
              for($k = 1 ; $k <= $this->session->userdata('jml_room'); $k++){
                $type_bed = "type_bed".$k;
                $qty = "qty".$k;
                if($pst[$type_bed]){
                    $type_bed = $pst[$type_bed];
                }else{
                  $type_bed = $this->session->userdata($type_bed);
                }
                
                if($pst[$qty]){
                    $qty = $pst[$qty];
                }else{
                  $qty = $this->session->userdata($qty);
                }
                
                $ses_datatype= array(
            "type_bed".$k   => $type_bed,
                  "qty".$k => $qty
          );
          $this->session->set_userdata($ses_datatype); 
                foreach($pst['qty'.$k] AS $pstqty){
                  $total_pstqty += $pstqty;
                }
              }
            }
            
//    $this->debug($pst, true);
    if(($total_pstqty + $pst['dp']) > $pst['seat']){
      $this->session->set_flashdata('notice', 'Full. Hanya memungkinkan untuk '.($pst['seat'] - $pst['dp']));
      redirect("grouptour/product-tour/book-tour/{$pst['tour_information_code']}");
    }
    
    
    $foot = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<script type='text/javascript'>"
      
        . "function set_nama(){"
          . "var depan = $('#pemesan_depan').val();"
          . "var belakang = $('#pemesan_belakang').val();"
          . "var no_telp = $('#no_telp_pemesan').val();"
          . "$('#tfirst0').val(depan);"
          . "$('#tlast0').val(belakang);"
          . "$('#ano_telp_pemesan').val(no_telp);"
        . "}"
      ."function tambah_items(){"
      ."var num = $('.number').length;"
      ."var dataString2 = 'name='+ num;"
      ."$.ajax({"
      ."type : 'POST',"
      ."url : '".site_url("grouptour/product-tour/ajax-add-row-additional-book-tour")."',"
      ."data: dataString2,"
      ."dataType : 'html',"
      ."success: function(data) {"
            ."$('#tambah-items').append(data);"
      ."},"
    ."});"
        ."}" 
        . "$(document).ready(function () {"
        . '$("#but_sub").click(function(){'
        . "var ndepan     = $('#pemesan_depan').val();"
        . "var nbelakang  = $('#pemesan_belakang').val();"
        . "var email_pemesan  = $('#email_pemesan').val();"
        . "var no_telp_pemesan  = $('#no_telp_pemesan').val();"
        . "var address  = $('#address_pemesan').val();"
        . "var total_person  = $('#total_person').val();"
      . "var tfirst2 = 'tfirst'; "
      . "var tlast2 = 'tlast'; "
      . "var ttlahir2 = 'tlahir'; "
      ."for(var i = 0; i < total_person; i++) {"
            ."aa = tfirst2 + i;"
            ."bb = tlast2 + i;"
            ."cc = ttlahir2 + i;"
            ."var fstname = $('#'+aa+'').val();"
            ."var ltname = $('#'+bb+'').val();"
//            ."var tlhr = $('#'+cc+'').val();"
//            ."if(fstname == ''){"
//              ."alert('First Name Harus di Isi');"
//              ."return false;"
//            ."}"
//            ."if(ltname == ''){"
//                ."alert('Last Name Harus di Isi');"
//                ."return false;"
//            ."}"
//            ."if(tlhr == ''){"
//                ."alert('Tanggal Lahir Harus di Isi');"
//                ."return false;"
//            ."}"
      ."}"
        . "if(ndepan ==''){"
        . "alert('Nama Depan Pemesan Harus di isi');"
        . "return false; }" 
        . "if(nbelakang == ''){"
        . "alert('Nama Belakang Pemesan Harus di isi');"
        . "return false; }"
        . "if(email_pemesan ==''){"
        . "alert ('Email Pemesan Harus di Isi');"
        . "return false; }"
        . "if(no_telp_pemesan == ''){"
        . "alert('No Telp Pemesan Harus di Isi');"
        . "return false; }"
        . "if(address == ''){"
        . "alert('Alamat Pemesan Harus di Isi');"
        . "return false; }"
//        . "if(dasar_adult_triple_twin == ''){"
//        . "alert('Adult Triple Twin');"
//        . "return false; } "
        
        . "return true;"
       . '});'
          . "$( '.adult_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-75:-13',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
          . "$( '.child_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-12:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
        . "$( '.passport' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-5:+7',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
          . "$( '.infant_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-2:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
		  
		  . "$( '#agent' ).change(function(){"
            . "$.post('".site_url('grouptour/grouptour-ajax/set-detail')."', {id: $(this).val()}, function(hasil){"
              . "var data = $.parseJSON(hasil);"
              . "$('#pemesan_depan').val(data.pic1);"
              . "$('#pemesan_belakang').val(data.pic2);"
              . "$('#email_pemesan').val(data.email);"
              . "$('#no_telp_pemesan').val(data.telp);"
              . "$('#address_pemesan').val(data.alamat);"
            . "});"
          . "});"
		  
        . "})"
      . "</script>";
	  
	$post_agent = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "status"            => 1
    );

    $agent = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-sub-agent");  
    $agent_array = json_decode($agent);
    foreach($agent_array->data AS $aa){
      $sub_agent[$aa->id_master_sub_agent] = $aa->name;
    }
    
    $pameran = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
    $pameran_array = json_decode($pameran);
    $pameran_drop[NULL] = '- Pilih -';
    foreach($pameran_array->data AS $pp){
      $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d M y", strtotime($pp->date_start));
    }
     
    $this->template->build('product-tour/book-info', 
      array(
            'url'           => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'          => "grouptour/product-tour",
            'pst'           => $pst,
            'title'         => lang("Book Informasi Penumpang"),
            'foot'          => $foot,
            'sub_agent'     => $sub_agent,
            'pameran'       => $pameran_drop,
            'breadcrumb'    => array(
            "product_tour"  => "grouptour/product-tour"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/book-info');
  }
  
  function book_detail_cust($id_product_tour_book = 0){
    
      $pst = $this->input->post(NULL);
      if($pst){
          $gagal = "true";
        $gagal_status = "";
        if($pst["nominal"] == ""){
            $gagal = "false";
            $gagal_status = 1;
        }
        
        if($gagal == "true"){
            $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                   "id_product_tour_book"                       => $id_product_tour_book,
                   "nominal"                                    => $pst["nominal"],
                   "total_all"                                  => $pst["total_all"],
                   "dp"                                         => $pst["dp"],
                    "id_users"                                  => $this->session->userdata("id"),
                    "save_data_payment"                         => "save_data_payment"
                    );
     
      $data2 = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-fee-product-tour");  
      $detail2 = json_decode($data2);
          redirect("antavaya/product-tour/customer-tour/");
        }
          
      }
      $data = array("users"           => USERSSERVER,
                    "password"        => PASSSERVER,
                   "id_product_tour_book"                       => $id_product_tour_book,
                    "search_data"                       => "search_data"
                    );
     
      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-fee-product-tour");  
      $detail = json_decode($data);
     
     
    $this->template->build('product-tour/book-detail-cust', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "antavaya/product-tour",
            'detail'        => $detail->detail_product_tour_book,
            'gagal_status'  => $gagal_status,
            'title'       => lang("Detail Book Product Tour"),
            'breadcrumb'  => array(
                    "product_tour"  => "antavaya/product_tour"
                ),
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/book-detail-cust');
  }
  
//   function book(){
//      
//      $serach_data = $this->input->post(NULL);
//      if($serach_data){
//          $datatables = "datatables";
//          $serach = "search_data";
//      }else{
//          $datatables = "tableajax";
//          $serach = "";
//      }
//    $data = array("users"           =>"test",
//                   "password"      =>"123",
//                   "title"          =>$serach_data["title"],
//                    "start_date"    => $serach_data["start_date"],
//                    "end_date"      => $serach_data["end_date"],
//                    "kategori1"      => $serach_data["kategori1"],
//                    "kategori2"      => $serach_data["kategori2"],
//                    "search_data"   => $serach,
//                    );
//     if($serach){
//      $data = $this->curl_mentah($data, URLSERVICETOUR);  
//      $data_array = json_decode($data);
//     }else{
//         $data_array = "";
//     }
//    
//   
//    $list = $data_array;
//   $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran");
//    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
//    
//    
//    $foot = "
//        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
//       
//        <script type='text/javascript'>
//             $(document).ready(function () { 
//           
//            
//           $('#bb').click( function()
//           {
//             $('#loading-tour').show();
//           }
//        );
//            
//          
//            
//             $( '#start_date' ).datepicker({
//                showOtherMonths: true,
//                dateFormat: 'yy-mm-dd',
//                selectOtherMonths: true,
//                selectOtherYears: true
//              });
//              
//              $( '#end_date' ).datepicker({
//                showOtherMonths: true,
//                dateFormat: 'yy-mm-dd',
//                selectOtherMonths: true,
//                selectOtherYears: true
//              });          
//
//            })
//              
//          
//        </script>";
//    
//   // print_r($serach_data); die;
//    $this->template->build('product-tour/tour', 
//      array(
//            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
//          'url_image'         => base_url()."themes/antavaya/",
//            'menu'        => "Search Tour",
//            'data'        => $list,
//            'title'       => lang("Search_Tour"),
//            'category'      => $category,
//            'sub_category'  =>$sub_category,
//            'foot'              => $foot,
//            'serach_data'                => $serach_data,
//          'serach'                => $serach
//          ));
//    $this->template
//      ->set_layout($datatables)
//      ->build('product-tour/tour');
//  } 
  
  function tour_detail($tour_code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $tour_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-detail");
    $detail_array = json_decode($detail);
//   $this->debug($detail_array, true);
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />";
        $foot = "
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery.price_format.1.8.min.js' type='text/javascript'></script>
        <script type='text/javascript'>
        $(function() {
          $('#example1').dataTable();
        });
		$(document).on('click', '#print-detail', function(evt){
      window.open('".site_url("store/print-store/tour/{$tour_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');
    });
		$(document).on('click', '.tour-print', function(evt){
      var code = $(this).attr('isi');
      window.open('".site_url("store/print-store/tour-schedule/{$tour_code}")."/'+code, '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');
    });
        $(document).on('click', '.tour-edit', function(evt){
          $.post('".site_url("grouptour/product-tour/ajax-tour-detail")."', {kode_tour_information: $(this).attr('isi')}, function(data){
            var hasil = $.parseJSON(data);
           
            $('#kode').val(hasil.kode);
            $('#id_product_tour_information').val(hasil.id_product_tour_information);
            $('#kode_ps').val(hasil.kode_ps);
            $('#start_date_0').val(hasil.start_date);
            $('#end_date_0').val(hasil.end_date);
            $('#start_time_1').val(hasil.start_time);
            $('#end_time_1').val(hasil.end_time);
            $('#available_seat').val(hasil.available_seat);
            $('#id_currency').val(hasil.id_currency);
            $('#adult_triple_twin').val(hasil.adult_triple_twin);
            $('#child_twin_bed').val(hasil.child_twin_bed);
            $('#child_extra_bed').val(hasil.child_extra_bed);
            $('#child_no_bed').val(hasil.child_no_bed);
            $('#sgl_supp').val(hasil.sgl_supp);
            $('#airport_tax').val(hasil.airport_tax);
            $('#visa').val(hasil.visa);
            $('#stnb_discount_tetap').val(hasil.tour_discount);
            $('#flt').val(hasil.flt);
            $('#in').val(hasil.in);
            $('#out').val(hasil.out);
            $('.dt_discount').remove();
            $('#tambah-items-discount').append(hasil.tour_discount);
        
          });
          
        });
        
function tambah_discount(discount){
            $('.dt_discount').remove();
           var dataString2 = 'id_discount='+ discount;
      $.ajax({
      type : 'POST',
      url : '".site_url("inventory/ajax/add-discount")."',
      data: dataString2,
      dataType : 'html',
      success: function(data) {
            $('#tambah-items-discount').append(data);
      },
    });
        }
    </script>";
      
    $this->template->build('product-tour/tour-detail', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/product-tour",
            'data'        => $detail_array,
            'foot'        => $foot,
            'css'         => $css,
            'title'       => lang("Detail Book Product Tour"),
            'breadcrumb'  => array(
              "product_tour"  => "grouptour/product-tour"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/tour-detail');
  }
   function ajax_tour_detail(){
     
    $kode = $this->input->post('kode_tour_information');
     
     $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $kode,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-detail-information");
    $detail_array = json_decode($detail);
    
    if($detail_array->tour->start_time){
      $start_time =  date("H:i", strtotime($detail_array->tour->start_time));
    }else{
      $start_time = "";
    }
    
    if($detail_array->tour->end_time){
      $end_time = date("H:i", strtotime($detail_array->tour->end_time));
    }else{
      $end_time = "";
    }
    
    $dt_status_disc2 = array("1" => "Persen",
                                            "2" => "Nominal");
                  $no = 1;
                  $info = "";
                        foreach ( $detail_array->tour->info_disc as $dval) {
                             $batas = ($dt_dis + 1);
                             $bts +=  $dval->batas_discount;
                            if($no == 1){
                                $dt = "Pertama";
                                $batas_all = $dval->batas_discount;
                                $dt_dis = $dval->batas_discount;
                            }else{
                                $dt = "Selanjutnya";
                                $batas_all = $batas." - ".$bts;
                                
                               
                            }
                            $info .= "Untuk ".$batas_all." Orang Deposit {$dt} Akan mendapatkan discount ".$dval->discount." ".$dt_status_disc2[$dval->status_discount]."<br>";
                            $dt_dis = $bts;
                            $no++;
                            }
    $hasil = array(
      'kode'                  => $detail_array->tour->code,
      'kode_ps'               => $detail_array->tour->kode_ps,
      'start_date'            => date("d M Y", strtotime($detail_array->tour->start_date)),
      'end_date'              => date("d M Y", strtotime($detail_array->tour->end_date)),
      'start_time'            => $start_time,
      'end_time'              => $end_time,
      'available_seat'        => $detail_array->tour->available_seat,
      'id_currency'           => $detail_array->tour->currency,
      'adult_triple_twin'     => number_format($detail_array->tour->price->adult_triple_twin, 0, ".",","),
      'child_twin_bed'        => number_format($detail_array->tour->price->child_twin_bed, 0, ".",","),
      'child_extra_bed'       => number_format($detail_array->tour->price->child_extra_bed, 0, ".",","),
      'child_no_bed'          => number_format($detail_array->tour->price->child_no_bed, 0, ".",","),
      'sgl_supp'              => number_format($detail_array->tour->price->sgl_supp, 0, ".",","),
      'airport_tax'           => number_format($detail_array->tour->price->airport_tax, 0, ".",","),
      'visa'                  => number_format($detail_array->tour->price->visa, 0, ".",","),
      'tour_discount'         => "<div class='dt_discount'><b>Info Discount</b><br>".$info."</div>",
      'days'                  => $detail_array->tour->days,
      'flt'                   => $detail_array->tour->flt,
      'in'                    => $detail_array->tour->in,
      'out'                   => $detail_array->tour->out,
    );
//    print "<pre>";
//    print_r($hasil);
//    print "</pre>";
    print json_encode($hasil);
    die;

  }
  
  function book_information($book_code,$customer_code){
    
    $pst = $this->input->post(NULL);
//    print "<pre>";
//    print_r($pst);
//    print "</pre>";
//    die;
    
    
    
    if($pst['request_additional_tour']){
      if($pst['note_additional_tour']){
          $kirim = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "kode"                      => $pst['id_detail'],
            "name"                      => $this->session->userdata("name"),
            "note"                      => $pst['note_additional_tour'],
            "create_by_users"           => $this->session->userdata("id"),
            "create_date"               => date("Y-m-d"),
        );
          
          $discount_detail = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/insert-log-request-additional-tour");
       
          $discount_array = json_decode($discount_detail);
		  
		  $kirim_additional = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "note"                      => $pst['note_additional_tour'],
          "id_users"                  => $this->session->userdata("id"),
          "code"                      =>  $pst['id_detail'],
              
        );
        $this->global_variable->curl_mentah($kirim_additional, URLSERVER."json/json-mail/chat-additional");
		
        if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Log Request Additional');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }else{
         $this->session->set_flashdata('notice', 'Gagal');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      
      }else{
        $this->session->set_flashdata('notice', 'Message Request Additional tidak Boleh Kosong');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      
    }
    
    if($pst['val_request_discount']){
      if($pst['nominal_request_discount']){
          $kirim = array(
            "users"                                   => USERSSERVER,
            "password"                                => PASSSERVER,
            "kode"                                    => $pst['id_detail'],
            "user_approval"                           => $this->session->userdata("id"),
            "nominal_request_discount"                =>  str_replace(",","",$pst['nominal_request_discount']),
            "confirm"                                 => "data_submit" 
           
        );
          
          $discount_detail = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/request-discount-tambahan");
       
          $discount_array = json_decode($discount_detail);
        if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Submit Request Discount');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }else{
         $this->session->set_flashdata('notice', 'Gagal');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      
      }else{
        $this->session->set_flashdata('notice', 'Nominal Request Discount tidak Boleh Kosong');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
     
    }
    
    if($pst['reject_request_discount']){
        $kirim = array(
            "users"                                   => USERSSERVER,
            "password"                                => PASSSERVER,
            "kode"                                    => $pst['id_detail'],
            "user_approval"                           => $this->session->userdata("id"),
            "confirm"                                 => "data_reject"       
        );
        
         $reject_discount_req = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/request-discount-tambahan");
       
          $reject_discount_req_array = json_decode($reject_discount_req);
        if($reject_discount_req_array->status == 2){
          $this->session->set_flashdata('success', 'Reject Request Discount');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }else{
         $this->session->set_flashdata('notice', 'Gagal');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
    }
    
    
//    if($customer_code){
//       $post = array(
//          "users"                     => USERSSERVER,
//          "password"                  => PASSSERVER,
//          "code"                      => $book_code,
//          "name_user"                 => $this->session->userdata("name"),
//          "customer_code"             => $customer_code
//        );
//    
//        $discount_detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/cancel-customer-tour");
//        $discount_array = json_decode($discount_detail);
//        if($discount_array->status == 2){
//          $this->session->set_flashdata('success', 'Request Cancel Customer Diajukan');
//          redirect("grouptour/product-tour/book-information/{$book_code}");
//      }else{
//         $this->session->set_flashdata('notice', 'Gagal');
//          redirect("grouptour/product-tour/book-information/{$book_code}");
//      }
//    }
    if($pst['customer_edit']){
      $adult_triple_twin = $child_tb = $child_eb = $child_nb = $single_supp = array();
//      $this->debug($pst, true);
    if(isset($pst['first_name_adl_tt'])){
      foreach($pst['first_name_adl_tt'] AS $ka => $adl_tt){
      if($adl_tt){
        $adult_triple_twin[] = array(
          "first_name"        => $adl_tt,
          "last_name"         => $pst['last_name_adl_tt'][$ka],
          "tempat_lahir"      => $pst['place_birth_adl'][$ka],
          "lahir"             => $pst['date_adl_tt'][$ka],
          "passport"          => $pst['adl_passport'][$ka],
          "telp"              => $pst['telp_adl_tt'][$ka],
          "place_issued"      => $pst['place_issued_adl'][$ka],
          "date_issued"       => $pst['date_issued_adl'][$ka],
          "date_expired"      => $pst['date_expired_adl'][$ka],
          "customer_code"     => $pst['customer_code_adl'][$ka],
          "visa"              => $pst['visa_adl'][$ka],
          "room"              => $pst['room_adl_tt'][$ka],
          "type"              => $pst['type_adl_tt'][$ka],
        );
      }
    }
    }
    
    if(isset($pst['first_name_chl_tb'])){
      foreach($pst['first_name_chl_tb'] AS $tb => $chl_tb){
      if($chl_tb){
        $child_tb[] = array(
          "first_name"        => $chl_tb,
          "last_name"         => $pst['last_name_chl_tb'][$tb],
          "tempat_lahir"      => $pst['place_birth_chl_tb'][$tb],
          "lahir"             => $pst['date_chl_tb'][$tb],
          "passport"          => $pst['chl_tb_passport'][$tb],
          "telp"              => $pst['telp_chl_tb'][$tb],
          "place_issued"      => $pst['place_issued_chl_tb'][$tb],
          "date_issued"       => $pst['date_issued_chl_tb'][$tb],
          "date_expired"      => $pst['date_expired_chl_tb'][$tb],
          "customer_code"     => $pst['customer_code_chl_tb'][$tb],
          "visa"              => $pst['visa_chl_tb'][$tb],
          "room"              => $pst['room_chl_tb'][$tb],
          "type"              => $pst['type_chl_tb'][$tb],
        );
      }
    }
    }
    
    if(isset($pst['first_name_chl_eb'])){
      foreach($pst['first_name_chl_eb'] AS $eb => $chl_eb){
      if($chl_eb){
        $child_eb[] = array(
          "first_name"        => $chl_eb,
          "last_name"         => $pst['last_name_chl_eb'][$eb],
          "tempat_lahir"             => $pst['place_birth_chl_eb'][$eb],
          "lahir"             => $pst['date_chl_eb'][$eb],
          "passport"          => $pst['chl_eb_passport'][$eb],
          "telp"          => $pst['telp_chl_eb'][$eb],
          "place_issued"          => $pst['place_issued_chl_eb'][$eb],
          "date_issued"          => $pst['date_issued_chl_eb'][$eb],
          "date_expired"          => $pst['date_expired_chl_eb'][$eb],
          "customer_code"          => $pst['customer_code_chl_eb'][$eb],
          "visa"                  => $pst['visa_chl_eb'][$eb],
          "room"              => $pst['room_chl_eb'][$eb],
          "type"              => $pst['type_chl_eb'][$eb],
        );
      }
    }
    }
    
    if(isset($pst['first_name_chl_nb'])){
      foreach($pst['first_name_chl_nb'] AS $nb => $chl_nb){
      if($chl_nb){
        $child_nb[] = array(
          "first_name"        => $chl_nb,
          "last_name"         => $pst['last_name_chl_nb'][$nb],
          "tempat_lahir"             => $pst['place_birth_chl_nb'][$nb],
          "lahir"               => $pst['date_chl_nb'][$nb],
          "passport"            => $pst['chl_nb_passport'][$nb],
          "telp"                => $pst['telp_chl_nb'][$nb],
          "place_issued"        => $pst['place_issued_chl_nb'][$nb],
          "date_issued"         => $pst['date_issued_chl_nb'][$nb],
          "date_expired"        => $pst['date_expired_chl_nb'][$nb],
          "customer_code"       => $pst['customer_code_chl_nb'][$nb],
          "visa"                => $pst['visa_chl_nb'][$nb],
          "room"              => $pst['room_chl_nb'][$nb],
          "type"              => $pst['type_chl_nb'][$nb],
        );
      }
    }
    }
    
    if(isset($pst['first_name_sgl'])){
      foreach($pst['first_name_sgl'] AS $sgl => $single){
      if($single){
        $single_supp[] = array(
          "first_name"        => $single,
          "last_name"         => $pst['last_name_chl_sgl'][$sgl],
          "tempat_lahir"      => $pst['place_birth_chl_sgl'][$sgl],
          "lahir"             => $pst['date_chl_sgl'][$sgl],
          "passport"          => $pst['chl_sgl_passport'][$sgl],
          "telp"              => $pst['telp_chl_sgl'][$sgl],
          "place_issued"      => $pst['place_issued_chl_sgl'][$sgl],
          "date_issued"       => $pst['date_issued_chl_sgl'][$sgl],
          "date_expired"      => $pst['date_expired_chl_sgl'][$sgl],
          "customer_code"     => $pst['customer_code_chl_sgl'][$sgl],
          "visa"              => $pst['visa_sgl'][$sgl],
          "room"              => $pst['room_sgl'][$sgl],
          "type"              => $pst['type_sgl'][$sgl],
        );
      }
    }
    }
//    $this->debug($single_supp, true);
        $post = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "code"                      => $pst['id_detail'],
          "name_user"                 => $this->session->userdata("name"),
          "first_name"                => $pst['first_name_adl_tt'][0],
          "last_name"                 => $pst['last_name_adl_tt'][0],
          "telp"                      => $pst['telp_adl_tt'][0],
          "address"                   => $pst['address0'],
          "id_users"                  => $this->session->userdata("id"),
          "adult_triple_twin"         => json_encode($adult_triple_twin),
          "child_tb"                  => json_encode($child_tb),
          "child_eb"                  => json_encode($child_eb),
          "child_nb"                  => json_encode($child_nb),
          "single_supp"               => json_encode($single_supp),
        );
//        print "<pre>";
//        print_r($post);
//        print "</pre>"; die;
    
        $discount_detail2 = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/update-customer-tour");
//        $this->debug($discount_detail2, true);
        $discount_array2 = json_decode($discount_detail2);
        if($discount_array2->status == 2){
          $this->session->set_flashdata('success', 'Update Customer Berhasil');
        }
        elseif($discount_array2->status == 4){
          $this->session->set_flashdata('success', 'Update Customer Berhasil. <br />Terdapat Perubahan Biaya');
        }
        else{
           $this->session->set_flashdata('notice', 'Gagal');
        }
        redirect("grouptour/product-tour/book-information/{$book_code}");
    }
//   print_r($pst); die;
   /* if($pst['approve_additional_req']){
      if($pst["type_add"]){
        
      foreach($pst['type_add'] AS $val_nominal){
      if($val_nominal){
        $additional[] = array(
          "id"            => $val_nominal,
        );
      }
    }
 
          $post = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "code"                      => $book_code,
          "additional"                  => json_encode($additional),
          "name_user"                  => $this->session->userdata("name"),
          "status"                    => "additional_request"
        );
    
        $additional_req = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/request-additional-tour");
        $addreq_array = json_decode($additional_req);
      //  print_r($additional_req); die;
      }
    } */
    
    /*
    if($pst['request_dicount']){
      if($pst["discount"]){
          $post = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "code"                      => $book_code,
          "discount"                  => $pst["discount"],
          "note"                      => $pst["note"],
          "name_user"                  => $this->session->userdata("name"),
          "status"                    => "request_dicount"
        );
    
        $discount_detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/request-discount-tour");
        $discount_array = json_decode($discount_detail);
        
        if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Request Discount Diajukan');
          redirect("grouptour/product-tour/book-information/{$book_code}");
        }
      }else{
         $this->session->set_flashdata('notice', 'Nominal Discount Tidak boleh kosong');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
    }
    
    if($pst['approval']){
       $post = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "code"                      => $book_code,
          "name_user"                  => $this->session->userdata("name"),
          "status"                    => "approval"
        );
    
        $discount_detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/request-discount-tour");
        $discount_array = json_decode($discount_detail);
    } */
    
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
      "committed"       => $pst["committed_book"],
      "dt_users"        => $this->session->userdata("id")
    );
    
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
//    $this->debug($detail_array->payment, true);
    $detail_users_post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_users"        => $this->session->userdata("id")
    );
    
    $detail_users = $this->global_variable->curl_mentah($detail_users_post, URLSERVER."json/json-tour/get-detail-users");
    $detail_users_array = json_decode($detail_users);
//    $this->debug($detail_array);
//    $this->debug($detail_users_array, true);
    
    if($this->session->userdata("id") != 1){
      if($detail_array->book->id_store != $detail_users_array->store->id_store){
        redirect("tour/book-view/{$book_code}");
      }
      else{
        if($detail_array->book->own_user != $detail_users_array->users->email){
//          print $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "edit-book", "edit");die;
          if($this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "edit-book", "edit") === FALSE){
            redirect("tour/book-view/{$book_code}");
          }
        }
      }
    }
    
    if($detail_array->data_committed == "Sukses"){
    $this->session->set_flashdata('success', 'Data tersimpan');
    redirect("grouptour/product-tour/book-information/{$book_code}");
    }
    
     $arr_additional = array("0" => "-Pilih-"); 
   foreach ($detail_array->book->additional_req as $val2) {
       $arr_additional[$val2->id_product_tour_master_additional] =  $val2->name." ,Price ".$val2->nominal;
   }
    /*$ses_arr_add = array(
           "arradd"   => $arr_additional,
          );
                     
    $this->session->set_userdata($ses_arr_add); */
    
  // $this->debug($detail_array, true);
    
   $post_approval = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "code"                      => $book_code,
    );

    $approval = $this->global_variable->curl_mentah($post_approval, URLSERVER."json/json-tour/get-users-approval");
    $approval_array = json_decode($approval);
	
	foreach ($approval_array->data as $vale) {
            
            $eml_adl .= $this->global_models->get_field("m_users", "email", array("id_users" => $vale)).",";
            $nm_usr .= $this->global_models->get_field("m_users", "name", array("id_users" => $vale)).",";
           
        }
		
    $foot = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>"
      . "";
    
    $foot .= "<script type='text/javascript'>"
      
//      . "$(function() { "
        . "$('#table-pax').dataTable({ "
          . "'bPaginate': false, "
          . "'bLengthChange': false, "
          . "'bFilter': true, "
          . "'bSort': true, "
          . "'bInfo': true, "
          . "'bAutoWidth': true"
        . "}); "
        . "$('#table-ttue').DataTable({"
          . "'order': [[ 0, 'desc' ]]"
        . '});'
//        . "$('#table-ttu').DataTable({ "
//          . "'bPaginate': true, "
//          . "'bLengthChange': false, "
//          . "'bFilter': true, "
//          . "'bSort': true, "
//          . "'bInfo': true, "
//          . "'bAutoWidth': true,"
//          . "'order': [[ 0, 'desc' ]]"
//        . "}); "
//      . "});"
      
      . "$(document).on('click', '#print-price-detail', function(evt){"
        . "window.open('".site_url("store/print-store/price-detail/{$book_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
      
      . "$(document).on('click', '#print-itinerary-detail', function(evt){"
        . "window.open('".site_url("store/print-store/tour-schedule/{$detail_array->tour->code}/{$detail_array->tour->information->code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
          
      . "$(document).on('click', '#hide-info', function(evt){"
        . "$('.box-khusus').hide();"
      . "});"
          
      . "$(document).on('click', '.show-info', function(evt){"
        . "$('.box-khusus').show();"
      . "});"
          
      . "$(document).on('click', '.edit-deposit', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#id_payment').val(id);"
      . "});"
	  
      . "$(document).on('click', '#id-customer-cancel', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id_customer_book').val(id);"
      . "});"
      
      . "$(document).on('click', '.payment-void2', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id_payment').val(id);"
      . "});"
          
    //  . "$(document).on('click', '#req-discount', function(evt){"
    //    . "$.post('".site_url("grouptour/product-tour/post-req-discount")."', {note: $('#note-req-disk').val(), nominal: $('#nominal-req-disk').val(), code: '{$book_code}'},function(data){"
    //      . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
     //   . "});"
    //  . "});"
	
	. "$(document).on('click', '#req-discount', function(evt){"
		. "$('#req-discount').hide();"
        . "$('#img-req-disc').show();"
        . "$.post('".site_url("grouptour/product-tour/post-req-discount")."', {note: $('#note-req-disk').val(),status_user: $('#usr-status2').val(),own_tc: '{$detail_array->book->own_user}',user_approval: '{$eml_adl}',name_user: '{$nm_usr}', nominal: $('#nominal-req-disk').val(), code: '{$book_code}'},function(data){"
        . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
        . "});"
      . "});"
                
      
     // . "$(document).on('click', '#req-approved', function(evt){"
     //   . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 2,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
     //     . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
     //   . "});"
     // . "});"
	 
	 . "$(document).on('click', '#req-approved', function(evt){"
	 . "$('#req-approved').hide();"
          . "$('#req-rejected').hide();"
          . "$('#img-5').show();"
        . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 2,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
          . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
        . "});"
      . "});"
          
     // . "$(document).on('click', '#req-rejected', function(evt){"
     //   . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 3,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
     //    . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
     //   . "});"
     // . "});"
	 
	 . "$(document).on('click', '#disc-ap', function(evt){"
	. "$('#disc-ap').hide();"
          . "$('#disc-rj').hide();"
          . "$('#img-disc').show();"
      
    . "});"
       
        . "$(document).on('click', '#disc-rj', function(evt){"
	. "$('#disc-ap').hide();"
          . "$('#disc-rj').hide();"
          . "$('#img-disc').show();"
      
    . "});"
	 
    . "$(document).on('click', '#req-rejected', function(evt){"
	. "$('#req-approved').hide();"
          . "$('#req-rejected').hide();"
          . "$('#img-5').show();"
      . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 3,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
        . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
      . "});"
    . "});"
        
    . "$(document).on('click', '.tour-edit-pax', function(evt){"
      . "$.post('".site_url("store/ajax/edit-pax-book")."', {code: $(this).attr('isi')},function(data){"
        . "var hasil = $.parseJSON(data);"
        . "$('#edit-room').val(hasil.data.room);"
        . "$('#edit-type').val(hasil.data.type);"
        . "$('#edit-first-name').val(hasil.data.first_name);"
        . "$('#edit-last-name').val(hasil.data.last_name);"
        . "$('#edit-telp').val(hasil.data.telphone);"
        . "$('#edit-tempat-lahir').val(hasil.data.tempat_tanggal_lahir);"
        . "$('#edit-tanggal-lahir').val(hasil.data.tanggal_lahir);"
        . "$('#edit-passport').val(hasil.data.passport);"
        . "$('#edit-place-of-issued').val(hasil.data.place_of_issued);"
        . "$('#edit-date-of-issued').val(hasil.data.date_of_issued);"
        . "$('#edit-date-of-expired').val(hasil.data.date_of_expired);"
        . "$('#edit-note').val(hasil.data.note);"
        . "$('#edit-code').val(hasil.data.kode);"
        . "$('#edit-visa').val(hasil.data.visa);"
      . "});"
    . "});"
          
      . "$( '.adult_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-75:-13',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
     
          . "$( '.child_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-75:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
       
        . "$( '.passport' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-5:+7',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
          . "$( '.infant_date' ).datepicker({"
            . "changeMonth: true,"
            . "changeYear: true,"
            . "yearRange : '-2:+0',"
            . "dateFormat: 'yy-mm-dd',"
          . "});"
      . "</script>";
    $foot .= "
        <script>
        
function FormatCurrency(objNum)
{
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue)
   {
     num = MoneyToNumber(num);
     if (isNaN(num))
     {
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
       {
        // alert(num.split('.')[1]);
         objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else
       {
         objNum.value = AddCommas(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function MoneyToNumber(num)
{
   return (num.replace(/,/g, ''));
}

function AddCommas(num)
{
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+=',';
   }
   return numArr.reverse().join('');
} 
        
function formatCurrency(num) {
   num = num.toString().replace(/\$|\,/g,'');
   if(isNaN(num))
   num = '0';
   sign = (num == (num = Math.abs(num)));
   num = Math.floor(num*100+0.50000000001);
   cents = num0;
   num = Math.floor(num/100).toString();
   for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
   num = num.substring(0,num.length-(4*i+3))+'.'+
   num.substring(num.length-(4*i+3));
   return (((sign)?'':'-') + num);
}
</script>";
    
    $log_history_discount =$this->global_models->get("product_tour_log_request_discount_tour", array("kode_product_tour_book" => $detail_array->book->code));
    //$last = $this->db->last_query();
//    $this->debug($detail_array, true);
    
    $post_discount = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "code"                      => $book_code,
    );

    $get_discount = $this->global_variable->curl_mentah($post_discount, URLSERVER."json/json-tour/get-discount");
    $get_discount_array = json_decode($get_discount);
//    $this->debug($get_discount_array, true);
    
//    $this->debug($detail_array, true);

if($pst['request_dicount_tour']){
   
      $kirim = array(
            "kode_product_tour_book"      => $pst['id_detail'],
            "id_users"                    => $this->session->userdata("id"),
            "note"                        => $pst['note_tour'],
            "status"                      => $pst['status_user'],
            "tanggal"                     => date("Y-m-d H:i:s"),
            "create_by_users"             => $this->session->userdata("id"),
            "create_date"                 => date("Y-m-d H:i:s"),
        );

        $id_log_history_request_discount = $this->global_models->insert("product_tour_log_request_discount_tour", $kirim);
        
         
        foreach ($approval_array->data as $val_aproval) {
         
             $email = $this->global_models->get_field("m_users", "email", array("id_users" => $val_aproval));
             $dname_user = $this->global_models->get_field("m_users", "name", array("id_users" => $val_aproval));
             $name_user .= $dname_user.",";
             $email_user .= $email.",";
            }
            //$nama_tc = $this->global_models->get_field("m_users", "name", array("id_users" => $this->session->userdata("id")));
        
            if($pst['status_user'] == 1){
              $sd_email = $email_user;
              $name_user = $name_user;
            }else{
              $sd_email = $detail_array->book->own_user;
              $name_user = $this->global_models->get_field("m_users", "name", array("email" => $detail_array->book->own_user));;
            
              }
            
	$kirim_dis2 = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "note"                      => $pst['note_tour'],
            "id_users"                  => $this->session->userdata("id"),
            "code"                      => $pst['id_detail'],
            "name_user"                 => $name_user,
             "email_user"               => $sd_email,    
            "url"                       => base_url()."grouptour/product-tour/book-information/".$pst['id_detail'],
          );
        $this->global_variable->curl_mentah($kirim_dis2, URLSERVER."json/json-mail/chat-discount");
    
        if($id_log_history_request_discount > 0){
          $this->session->set_flashdata('success', 'Log Request Discount Tour');
          redirect("grouptour/product-tour/book-information/{$pst['id_detail']}");
      }else{
         $this->session->set_flashdata('notice', 'Gagal Log Request Discount Tour');
          redirect("grouptour/product-tour/book-information/{$pst['id_detail']}");
      }
    }
    
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $book_code,
      "id_users"    => $this->session->userdata("id"),
    );
      
    $view_history_void = $this->curl_mentah($post, URLSERVER."json/json-tour/history-payment-void"); 
    $history_void = json_decode($view_history_void);
    
//    print_r($history_void);
//    die;
    $this->template->build('product-tour/book-information', 
      array(
            'url'          => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'         => "grouptour/product-tour",
            'data'         => $detail_array,
            'history_void' => $history_void,
            'add_req2'    => $arr_additional,
            'approval_array'       => $approval_array->data,
            'discount'    => $get_discount_array->data,
          //  'last'        => $last,
            'log_history_discount' => $log_history_discount,
            'title'       => lang("Book {$book_code}"),
            'book_code'   => $book_code,
            'foot'        => $foot,
            'breadcrumb'  => array(
            "product_tour"  => "grouptour/product-tour/book-list"
            ),
          ));
    $this->template
      ->set_layout('form')
      ->build('product-tour/book-information');
  }
  
  
  
  function send_passenger(){
  
    $pst = $this->input->post();
//    $this->debug($pst, true);
//    print "<pre>";
//    print_r($pst);
//    print "</pre>";
//    die; 
    $adult_triple_twin = $child_tb = $child_eb = $child_nb = $single_supp = $additional = array();
    $note_tambahan = "";
    if(isset($pst['first_name_adl_tt'])){
      foreach($pst['first_name_adl_tt'] AS $ka => $adl_tt){
        $adl_tt = ($adl_tt ? $adl_tt : 'TBA');
      if($adl_tt){
        $adult_triple_twin[] = array(
          "first_name"        => $adl_tt,
          "last_name"         => ($pst['last_name_adl_tt'][$ka] ? $pst['last_name_adl_tt'][$ka] : 'TBA'),
          "tempat_lahir"      => $pst['place_birth_adl'][$ka],
          "lahir"             => $pst['date_adl_tt'][$ka],
          "room"              => $pst['room_adl_tt'][$ka],
          "passport"          => $pst['adl_passport'][$ka],
          "telp"              => $pst['telp_adl_tt'][$ka],
          "place_issued"      => $pst['place_issued_adl'][$ka],
          "date_issued"       => $pst['date_issued_adl'][$ka],
          "date_expired"      => $pst['date_expired_adl'][$ka],
          "visa"              => $pst['visa_adl'][$ka],
          "less_ticket"       => $pst['less_ticket_adl'][$ka],
        );
        if(!$pst['visa_adl'][$ka]){
          $note_tambahan .= "<br />Tidak Menggunakan Visa : {$adl_tt} {$pst['last_name_adl_tt'][$ka]} Adult Triple Twin";
        }
        if($pst['less_ticket_adl'][$ka]){
          $note_tambahan .= "<br />Less Ticket: {$adl_tt} {$pst['last_name_adl_tt'][$ka]} Adult Triple Twin";
        }
      }
    }
    }
    
    if(isset($pst['first_name_chl_tb'])){
      foreach($pst['first_name_chl_tb'] AS $tb => $chl_tb){
        $chl_tb = ($chl_tb ? $chl_tb : 'TBA');
        if($chl_tb){
          $child_tb[] = array(
            "first_name"        => $chl_tb,
            "last_name"         => ($pst['last_name_chl_tb'][$tb] ? $pst['last_name_chl_tb'][$tb] : 'TBA'),
            "tempat_lahir"      => $pst['place_birth_chl_tb'][$tb],
            "lahir"             => $pst['date_chl_tb'][$tb],
            "room"              => $pst['room_chl_tb'][$tb],
            "passport"          => $pst['chl_tb_passport'][$tb],
            "telp"              => $pst['telp_chl_tb'][$tb],
            "place_issued"      => $pst['place_issued_chl_tb'][$tb],
            "date_issued"       => $pst['date_issued_chl_tb'][$tb],
            "date_expired"      => $pst['date_expired_chl_tb'][$tb],
            "visa"              => $pst['visa_chl_tb'][$tb],
            "less_ticket"       => $pst['less_ticket_chl_tb'][$tb],
          );
          if(!$pst['visa_chl_tb'][$tb]){
            $note_tambahan .= "<br />Tidak Menggunakan Visa : {$chl_tb} {$pst['last_name_chl_tb'][$tb]} Child Twin Bed";
          }
          if($pst['less_ticket_chl_tb'][$tb]){
            $note_tambahan .= "<br />Less Ticket: {$chl_tb} {$pst['last_name_chl_tb'][$tb]} Child Twin Bed";
          }
        }
      }
    }
    
    if(isset($pst['first_name_chl_eb'])){
      foreach($pst['first_name_chl_eb'] AS $eb => $chl_eb){
        $chl_eb = ($chl_eb ? $chl_eb : 'TBA');
        if($chl_eb){
          $child_eb[] = array(
            "first_name"        => $chl_eb,
            "last_name"         => ($pst['last_name_chl_eb'][$eb] ? $pst['last_name_chl_eb'][$eb] : 'TBA'),
            "tempat_lahir"      => $pst['place_birth_chl_eb'][$eb],
            "lahir"             => $pst['date_chl_eb'][$eb],
            "room"              => $pst['room_chl_eb'][$eb],
            "passport"          => $pst['chl_eb_passport'][$eb],
            "telp"              => $pst['telp_chl_eb'][$eb],
            "place_issued"          => $pst['place_issued_chl_eb'][$eb],
            "date_issued"          => $pst['date_issued_chl_eb'][$eb],
            "date_expired"          => $pst['date_expired_chl_eb'][$eb],
            "visa"               => $pst['visa_chl_eb'][$eb],
            "less_ticket"       => $pst['less_ticket_chl_eb'][$eb],
          );
          if(!$pst['visa_chl_eb'][$eb]){
            $note_tambahan .= "<br />Tidak Menggunakan Visa : {$chl_eb} {$pst['last_name_chl_eb'][$eb]} Child Extra Bed";
          }
          if($pst['less_ticket_chl_eb'][$eb]){
            $note_tambahan .= "<br />Less Ticket: {$chl_eb} {$pst['last_name_chl_eb'][$eb]} Child Extra Bed";
          }
        }
      }
    }
    
    if(isset($pst['first_name_chl_nb'])){
      foreach($pst['first_name_chl_nb'] AS $nb => $chl_nb){
        $chl_nb = ($chl_nb ? $chl_nb : 'TBA');
        if($chl_nb){
          $child_nb[] = array(
            "first_name"        => $chl_nb,
            "last_name"         => ($pst['last_name_chl_nb'][$nb] ? $pst['last_name_chl_nb'][$nb] : 'TBA'),
            "tempat_lahir"      => $pst['place_birth_chl_nb'][$nb],
            "lahir"             => $pst['date_chl_nb'][$nb],
            "room"              => $pst['room_chl_nb'][$nb],
            "passport"          => $pst['chl_nb_passport'][$nb],
            "telp"              => $pst['telp_chl_nb'][$nb],
            "place_issued"          => $pst['place_issued_chl_nb'][$nb],
            "date_issued"          => $pst['date_issued_chl_nb'][$nb],
            "date_expired"          => $pst['date_expired_chl_nb'][$nb],
            "visa"               => $pst['visa_chl_nb'][$nb],
            "less_ticket"       => $pst['less_ticket_chl_nb'][$nb],
          );
          if(!$pst['visa_chl_nb'][$nb]){
            $note_tambahan .= "<br />Tidak Menggunakan Visa : {$chl_nb} {$pst['last_name_chl_nb'][$nb]} Child No Bed";
          }
          if($pst['less_ticket_chl_nb'][$nb]){
            $note_tambahan .= "<br />Less Ticket: {$chl_nb} {$pst['last_name_chl_nb'][$nb]} Child No Bed";
          }
        }
      }
    }
    
    if(isset($pst['first_name_sgl'])){
      foreach($pst['first_name_sgl'] AS $sgl => $single){
        $single = ($single ? $single : 'TBA');
        if($single){
          $single_supp[] = array(
            "first_name"        => $single,
            "last_name"         => ($pst['last_name_chl_sgl'][$sgl] ? $pst['last_name_chl_sgl'][$sgl] : 'TBA'),
            "tempat_lahir"      => $pst['place_birth_chl_sgl'][$sgl],
            "lahir"             => $pst['date_chl_sgl'][$sgl],
            "room"              => $pst['room_chl_sgl'][$sgl],
            "passport"          => $pst['chl_sgl_passport'][$sgl],
            "telp"              => $pst['telp_chl_sgl'][$sgl],
            "place_issued"      => $pst['place_issued_chl_sgl'][$sgl],
            "date_issued"       => $pst['date_issued_chl_sgl'][$sgl],
            "date_expired"      => $pst['date_expired_chl_sgl'][$sgl],
            "visa"              => $pst['visa_chl_sgl'][$sgl],
            "less_ticket"       => $pst['less_ticket_chl_sgl'][$sgl],
          );
          if(!$pst['visa_chl_sgl'][$sgl]){
            $note_tambahan .= "<br />Tidak Menggunakan Visa : {$single} {$pst['last_name_chl_sgl'][$sgl]} Adult Single";
          }
          if($pst['less_ticket_chl_sgl'][$sgl]){
            $note_tambahan .= "<br />Less Ticket: {$single} {$pst['last_name_chl_sgl'][$sgl]} Adult Single";
          }
        }
      }
    }
    if(isset($pst['type_add'])){
      foreach($pst['type_add'] AS $val_nominal){
      if($val_nominal){
        $additional[] = array(
          "id"            => $val_nominal,
        );
      }
    }
    }
    
    $paket = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "id_master_sub_agent"       => $pst['id_master_sub_agent'],
      "id_tour_pameran"           => $pst['id_tour_pameran'],
      "code"                      => $pst['tour_information_code'],
      "first_name"                => $pst['ifirst_name'],
      "last_name"                 => $pst['ilast_name'],
      "email"                     => $pst['iemail'],
      "telp"                      => $pst['itelp'],
      "id_users"                  => $this->session->userdata("id"),
      "jumlah_room"               => $pst['jumlah_room'],
      "discount"                  => $pst['discount'],
      "status_discount"           => $pst['status_discount'],
      "batas_discount_tambahan"   => $pst['batas_discount_tambahan'],
      "discount_request"          =>  str_replace(",","",$pst['discount_request']),
       "stnb_discount_req"        => $pst['stnb_discount_req'], 
      "dp"                        => $pst['dp'],
      "currency"                  => $pst['currency'],
      "note_additional"           => $pst['note_additional'],
      "total_price"               => $pst['total_price'],
      "status_dp"                 => $pst['status_dp'],
      "address"                   => $pst['address'],
      "remark"                   => $pst['remark'],
      "adult_triple_twin"         => json_encode($adult_triple_twin),
      "child_tb"                  => json_encode($child_tb),
      "child_eb"                  => json_encode($child_eb),
      "child_nb"                  => json_encode($child_nb),
      "single_supp"               => json_encode($single_supp),
      "additional"                => json_encode($additional),
    );
    
    $detail = $this->global_variable->curl_mentah($paket, URLSERVER."json/json-midlle-system/insert-book-tour");
//    $this->debug($detail, true);
   $detail_array = json_decode($detail);
   
   
   $kirim_info_customer = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $detail_array->book_code,
        );
        $this->global_variable->curl_mentah($kirim_info_customer, URLSERVER."json/json-mail/info-book-to-customer");	
 
// print "<pre>";
//  print_r($detail);
//   print "</pre>"; die;
    if($detail_array->status == 2){
      
      if($pst['note_additional'] OR $note_tambahan){
        $kirim_additional = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "note"                      => $pst['note_additional'].$note_tambahan,
          "id_users"                  => $this->session->userdata("id"),
          "name"                      => $this->session->userdata("name"),
          "code"                      => $detail_array->book_code,
          "status"                    => 1,
		  "request"                   => "request_additional"
        );
        $this->global_variable->curl_mentah($kirim_additional, URLSERVER."json/json-tour/chat-additional");
		
		$this->global_variable->curl_mentah($kirim_additional, URLSERVER."json/json-mail/request-additional");
      }
      
      foreach($pst['discount_request'] AS $key => $pdr){
        $nilai = str_replace(",", "", $pdr);
        if($nilai > 0){
          $kirim_discount[] = array(
            "kode_product_tour_book"      => $detail_array->book_code,
            "id_users"                    => $this->session->userdata("id"),
            "note"                        => $pst['note_discount_request'][$key]." ".$pdr,
            "tanggal"                     => date("Y-m-d H:i:s"),
            "status"                      => 1,
            "create_by_users"             => $this->session->userdata("id"),
            "create_date"                 => date("Y-m-d"),
          );
          $kirim_dis = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "nominal"                   => $nilai,
            "note"                      => $pst['note_discount_request'][$key],
            "id_users"                  => $this->session->userdata("id"),
            "code"                      => $detail_array->book_code,
            "status"                    => 1,
          );
         $req_disc = $this->global_variable->curl_mentah($kirim_dis, URLSERVER."json/json-tour/req-discount");
          $detail_req_disc = json_decode($req_disc);
		  $nl_flag .= $nilai;
		  $dta_req_disc .= $pst['note_discount_request'][$key]." ".$pdr."<br>";
        }
      }
      if($kirim_discount)
        $this->global_models->insert_batch("product_tour_log_request_discount_tour", $kirim_discount);
       
      $this->session->set_flashdata('success', 'Book Berhasil');
	
      if($pst['id_payment']){
        $kirim_dis = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "id_payment"                => $pst['id_payment'],
            "code"                      => $detail_array->book_code,
            "id_inventory"              => $pst['id_inventory'],
            "id_users"                  => $this->session->userdata("id"),
          );
        $this->global_variable->curl_mentah($kirim_dis, URLSERVER."json/json-inventory/book-tour-inventory-set");  
      }
      
	   $kirim_dis2 = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "note"                      => $dta_req_disc,
            "id_users"                  => $this->session->userdata("id"),
            "code"                      => $detail_array->book_code,
            "url"                       => base_url()."grouptour/product-tour/book-information/".$detail_array->book_code,
          );
		  if($nl_flag !=""){
			  $this->global_variable->curl_mentah($kirim_dis2, URLSERVER."json/json-mail/request-discount");
		  }
         
		
    }
    else{
      $this->session->set_flashdata('notice', 'Book Gagal');
    }
    redirect("grouptour/product-tour/book-information/{$detail_array->book_code}");
  }
  
  public function payment_book($book_code){
    if(!$this->input->post(NULL)){
       $post = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "code"            => $book_code,
        "committed"       => "",
      );

      $post_agent = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "status"            => 1
      );

      $pameran = $this->curl_mentah($post_agent, URLSERVER."json/json-tour/get-master-pameran");  
      $pameran_array = json_decode($pameran);
      $pameran_drop[NULL] = '- Pilih -';
  //    $this->debug($pameran, true);
      foreach($pameran_array->data AS $pp){
        $pameran_drop[$pp->id_tour_pameran] = $pp->title." ".date("d M y", strtotime($pp->date_start));
      }

      $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
      $detail_array = json_decode($detail);

      $css = ""
  //      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />"
        . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>";

      $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
        . "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"

        ."<script type='text/javascript'>"
        . "$(function() { "
          . "$('.select2').select2();"
          . "$( '#tanggal' ).datetimepicker({ "
            . "dateFormat: 'yy-mm-dd', "
          . "}); "
        . "}); "
        . "</script> 
          <script>
  function FormatCurrency(objNum)
  {
     var num = objNum.value
     var ent, dec;
     if (num != '' && num != objNum.oldvalue)
     {
       num = MoneyToNumber(num);
       if (isNaN(num))
       {
         objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
       } else {
         var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
         if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
         {
          // alert(num.split('.')[1]);
           objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
         }
         else
         {
           objNum.value = AddCommas(num.split('.')[0]);
         }
         objNum.oldvalue = objNum.value;
       }
     }
  }
  function MoneyToNumber(num)
  {
     return (num.replace(/,/g, ''));
  }

  function AddCommas(num)
  {
     numArr=new String(num).split('').reverse();
     for (i=3;i<numArr.length;i+=3)
     {
       numArr[i]+=',';
     }
     return numArr.reverse().join('');
  } 

  function formatCurrency(num) {
     num = num.toString().replace(/\$|\,/g,'');
     if(isNaN(num))
     num = '0';
     sign = (num == (num = Math.abs(num)));
     num = Math.floor(num*100+0.50000000001);
     cents = num0;
     num = Math.floor(num/100).toString();
     for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
     num = num.substring(0,num.length-(4*i+3))+'.'+
     num.substring(num.length-(4*i+3));
     return (((sign)?'':'-') + num);
  }
  </script>";
//      $this->debug($detail_array, true);
      $this->template->build("product-tour/payment-tour", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'grouptour/product-tour/book-list',
              'title'       => lang("Payment TTU"),
              'book_code'   =>  $book_code,
              'data'        =>  $detail_array,
              'breadcrumb'  => array(
                  "book_list"  => "grouptour/product-tour/book-list"
                ),
              'css'         => $css,
              'foot'        => $foot,
              'pameran'     => $pameran_drop,
            ));
      $this->template
        ->set_layout('form')
        ->build("product-tour/payment-tour");
    }
    else{
      $pst = $this->input->post(NULL);
//      $this->debug($pst, true);
      
      if($pst['nominal'] > 0){
          $paket = array(
            "users"           => USERSSERVER,
            "password"        => PASSSERVER,
            "code"            => $pst['book_code'],
            "nominal"         => str_replace(",","",$pst['nominal']),
            "tanggal"         => $pst['tanggal'],
            "id_tour_pameran" => $pst['id_tour_pameran'],
            "id_users"        => $this->session->userdata("id"),
            "type"            => 3,
            "remark"          => $pst['remark'],
          );
//          $this->debug($paket, true);
          $detail = $this->global_variable->curl_mentah($paket, URLSERVER."json/json-tour/payment-book");
          $detail_array = json_decode($detail);
          

//		$kirim_info_customer = array(
//          "users"                     => USERSSERVER,
//          "password"                  => PASSSERVER,
//          "id_users"                  => $this->session->userdata("id"),
//          "code"                      => $pst['book_code'],
//		  "nominal"					  => $pst['nominal']
//        );
//        $this->global_variable->curl_mentah($kirim_info_customer, URLSERVER."json/json-mail/info-book-status-to-customer");	
 
      }
      else{
//        if(!$pst["no_ttu"]){
//          if(!$pst['no_deposit']){
//            $this->session->set_flashdata('notice', "No TTU atau No Deposit Harus diisi");
//          }
//        }
//        else{
          $this->session->set_flashdata('notice', "Nominal Angka Tidak Boleh Kosong");
//        }
        redirect("grouptour/product-tour/payment-book/{$pst['book_code']}");
      }
      

      
     // print "<pre>";
    //  print_r($detail);
    //  print "</pre>"; die;
      if($detail_array->status % 2 == 0){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      else{
        $this->session->set_flashdata('notice', $detail_array->status.' Data tidak tersimpan');
        redirect("grouptour/product-tour/payment-book/{$book_code}");
      }
    }
  }
  
  public function refund_book($book_code){
    if(!$this->input->post(NULL)){
       $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
      "committed"       => "",
    );
    
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
    
    $css = ""
//      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>"
      . "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/jquery-ui-timepicker-addon.min.css' rel='stylesheet' type='text/css' />";
    
    $foot = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery-ui-timepicker-addon.js' type='text/javascript'></script>"
 
      ."<script type='text/javascript'>"
      . "$(function() { "
        . "$( '#tanggal' ).datetimepicker({ "
          . "dateFormat: 'yy-mm-dd', "
        . "}); "
      . "}); "
      . "</script> 
        <script>
function FormatCurrency(objNum)
{
   var num = objNum.value
   var ent, dec;
   if (num != '' && num != objNum.oldvalue)
   {
     num = MoneyToNumber(num);
     if (isNaN(num))
     {
       objNum.value = (objNum.oldvalue)?objNum.oldvalue:'';
     } else {
       var ev = (navigator.appName.indexOf('Netscape') != -1)?Event:event;
       if (ev.keyCode == 190 || !isNaN(num.split('.')[1]))
       {
        // alert(num.split('.')[1]);
         objNum.value = AddCommas(num.split('.')[0])+'.'+num.split('.')[1];
       }
       else
       {
         objNum.value = AddCommas(num.split('.')[0]);
       }
       objNum.oldvalue = objNum.value;
     }
   }
}
function MoneyToNumber(num)
{
   return (num.replace(/,/g, ''));
}

function AddCommas(num)
{
   numArr=new String(num).split('').reverse();
   for (i=3;i<numArr.length;i+=3)
   {
     numArr[i]+=',';
   }
   return numArr.reverse().join('');
} 
        
function formatCurrency(num) {
   num = num.toString().replace(/\$|\,/g,'');
   if(isNaN(num))
   num = '0';
   sign = (num == (num = Math.abs(num)));
   num = Math.floor(num*100+0.50000000001);
   cents = num0;
   num = Math.floor(num/100).toString();
   for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
   num = num.substring(0,num.length-(4*i+3))+'.'+
   num.substring(num.length-(4*i+3));
   return (((sign)?'':'-') + num);
}
</script>";
           
      $this->template->build("product-tour/refund-tour", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'grouptour/product-tour/book-list',
              'title'       => lang("payment_book"),
              'book_code'   =>  $book_code,
              'data'        =>  $detail_array,
              'breadcrumb'  => array(
                  "book_list"  => "grouptour/product-tour/book-list"
                ),
              'css'         => $css,
              'foot'        => $foot
            ));
      $this->template
        ->set_layout('form')
        ->build("product-tour/refund-tour");
    }
    else{
      $pst = $this->input->post(NULL);
//      $this->debug($pst, true);
      
      if($pst['nominal'] > 0 AND $pst['no_refund']){
//        if($pst['nominal'] > 0 ){
          $paket = array(
          "users"         => USERSSERVER,
          "password"      => PASSSERVER,
          "code"          => $pst['book_code'],
          "nominal"       => str_replace(",","",$pst['nominal']),
          "tanggal"       => $pst['tanggal'],
          "payment"       => $pst['payment'],
          "no_refund"    => $pst['no_refund'],
          "note"          => $pst['note'],  
          "currency"      => $pst['currency'],
          "id_users"      => $this->session->userdata("id"),
        );
          $detail = $this->global_variable->curl_mentah($paket, URLSERVER."json/json-tour/refund-book");
          $detail_array = json_decode($detail);

      }
      else{
        if(!$pst["no_refund"]){
            $this->session->set_flashdata('notice', "No Refund Harus diisi");
        
        }
        else{
          $this->session->set_flashdata('notice', "Nominal Angka Tidak Boleh Kosong");
        }
        redirect("grouptour/product-tour/refund-book/{$pst['book_code']}");
      }
      
      if($detail_array->status % 2 == 0){
        $this->session->set_flashdata('success', 'Data tersimpan');
        redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      else{
        $this->session->set_flashdata('notice', $detail_array->status.' Data tidak tersimpan');
        redirect("grouptour/product-tour/refund-book/{$book_code}");
      }
    }
  }
  
  function cek_payment($payment_code){
     
      if($payment_code){
        $data = array(
        "users"               => USERSSERVER,
        "password"            => PASSSERVER, 
        "payment_code"        => $payment_code, 
        "id_users"            => $this->session->userdata("id"),
        "limit"               => 10,  
        );
      }else{
        $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER, 
        "id_users"        => $this->session->userdata("id"),
        "limit"           => 10,  
        "payment_code"    => "",   
        );
      }
        
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/cek-payment");  
    $data_array = json_decode($data);
//    print "<pre>";
//    print_r($data_array);
//    print "</pre>"; die;
    
    $url_list = site_url("grouptour/product-tour/ajax-cek-payment/".$data_array->total);
    $url_list_halaman = site_url("grouptour/product-tour/ajax-halaman-cek-payment/".$data_array->total);
    
    $foot = "<script type='text/javascript'>"

      ."function get_list(start){"
        ."if(typeof start === 'undefined'){"
         ."start = 0;"
          ."}"
           ."$.post('{$url_list}/'+start, function(data){"
            ."$('#data_list').html(data);"
             ."$.post('{$url_list_halaman}/'+start, function(data){"
              ."$('#halaman_set').html(data);"
               ." });"
                ."});"
            ."}"
            ."get_list(0);"
      . "</script> ";
             
//   print $data_array->total_all."aa"; die;
   if($data_array->confirm == "Berhasil"){
            $this->session->set_flashdata('success', 'Confirm');
            redirect("grouptour/product-tour/cek-payment");
      }elseif($data_array->confirm == "Gagal"){
          $this->session->set_flashdata('notice', 'Gagal');
            redirect("grouptour/product-tour/cek-payment");
        }
        
    $this->template->build('product-tour/cek-payment', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'menu'          => "grouptour/product-tour",
          'data'          => $data_array,
          'title'         => lang("Konfirmasi Pembayaran"),
          'foot'          => $foot,
          
        ));
    $this->template
      ->set_layout("tableajax")
      ->build('product-tour/cek-payment');
  }
  
  function ajax_cek_payment($total = 0, $start = 0){
    
      $data = array(
                    "users"           => USERSSERVER,
                    "password"        => PASSSERVER, 
                    "id_users"        => $this->session->userdata("id"),
                    "limit"           => 10,
                    "start"           => $start
                    );

        $cek = $this->global_models->get_field("m_users_approval", "id_users_approval", array("id_users" => $this->session->userdata("id")));
        $dropdown = $this->global_models->get_dropdown("m_users_approval", "id_users", "id_users", FALSE, array("parent" => $cek)); 
  
       $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/cek-payment");  
        $data_array = json_decode($data);
       
       $status = array(
      1 => "<b>Draft</b>",
      2 => "<b>Paid</b>",
      3 => "<b>Not Paid</b>",
      4 => "<b>Cancal</b>",
    );
    
    foreach ($data_array->payment as $value) {
    // if($dropdown[$value->id_user] !=""){
       
    $nom = number_format($value->nominal,2,".",",");
    $nominal = $value->currency." ".$nom;
      $data = "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->name_tc}</td>"
         . "<td>{$value->name_konfirm}</td>"
        . "<td><a href='".site_url("grouptour/product-tour/book-information/{$value->book_code}")."'>{$value->book_code}</a></td>"
        . "<td>{$value->first_name} {$value->last_name}</td>"
        . "<td>{$nominal}</td>"
        . "<td>{$value->status}</td>";
       if($value->status != "Confirm"){
        $data .= "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("grouptour/product-tour/cek-payment/{$value->kode_payment}")."'>Confirm</a></li>"          
        . "</td>";
       }else{
         $data .= "<td>"
         . "</td>";
       }   
      $data .= "</tr>";
   print $data;
  } //}
   
    
    die;
  }
  
  function ajax_halaman_cek_payment($total = 0, $start = 0){
    
    $this->load->library('pagination');

    $config['base_url'] = '';
    $config['total_rows'] = $total;
    $config['per_page'] = 10; 
    $config['uri_segment'] = 5; 
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
  
  function report_payment(){
   
      $serach_data = $this->input->post(NULL);
//     print_r($serach_data); die;
     
     if($serach_data["start_date"] OR $serach_data["end_date"] OR $serach_data["status"] OR $serach_data["payment_type"] OR $serach_data["code"]){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $serach_data["start_date"],
        "end_date"        => $serach_data["end_date"],
        "status"          => $serach_data["status"],
        "payment_type"    => $serach_data["payment_type"],
        "code"            => $serach_data["code"],
        "id_users"        => $this->session->userdata("id"),
        );
//      if($data_array)
//        $this->debug($data_array, true);
     }else{
        $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"    => date("Y-m-01"),
        "end_date"      => date("Y-m-t"),
        "code"           => $code_tour_information,    
        "id_users"      => $this->session->userdata("id"),
        );
     }
     
     
     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/report-payment");  
    $data_array = json_decode($data);
    
    if($serach_data['export']){
      $this->load->model('grouptour/mproduct_tour');
      $this->mproduct_tour->export_xls("Report-Payment",$data_array);
    }
// $this->debug($data, true);
//    print "<pre>";
//    print_r($data_array);
//    print "</pre>";
//die;
//    $list = $data_array;
    $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
    $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
    
    $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/css/tooltipster.css' rel='stylesheet' type='text/css' />"
      . "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
        <script src='".base_url()."themes/".DEFAULTTHEMES."/js/plugins/tooltipster-master/js/jquery.tooltipster.min.js' type='text/javascript'></script>
       
        <script type='text/javascript'>
             $(document).ready(function () { 
           
            
           $('#bb').click( function()
           {
             $('#loading-tour').show();
           }
        );
            
             $( '#start_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });
              
              $( '#end_date' ).datepicker({
                showOtherMonths: true,
                dateFormat: 'yy-mm-dd',
                selectOtherMonths: true,
                selectOtherYears: true
              });          

            })
        </script>";
    
   // print_r($serach_data); die;
   
        $status = array("0"	=> "All",
                        "1" => "Draft", 
                        "2" => "Confirm");
         $channel = array("0" => "All",
                  1 => "Cash",
                  2 => "BCA",
                  3 => "Mega",
                  4 => "Mandiri",
                  5 => "CC");
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-12' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('code', $serach_data['code'], ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $serach_data['start_date'], 'id="start_date" class="form-control input-sm" placeholder="Start Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $serach_data['end_date'], 'id="end_date" class="form-control input-sm" placeholder="End Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Status</label>"
            . "{$this->form_eksternal->form_dropdown('status', $status, array($serach_data['status']), 'class="form-control" placeholder="Status"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Payment Type</label>"
            . "{$this->form_eksternal->form_dropdown('payment_type', $channel, array($serach_data['payment_type']), 'class="form-control" placeholder="Payment Type"')}"
          . "</div>"
        . "</div>"      
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
               ."<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<input name='export' class='btn btn-primary' value='Export XLS' type='submit'></input>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('product-tour/report-payment', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "grouptour/product-tour/report-payment",
          'data'          => $data_array,
          'title'         => lang("report_payment"),
          'category'      => $category,
          'sub_category'  => $sub_category,
          'foot'          => $foot,
          'css'           => $css,
         'tableboxy'   => 'tableboxydesc',
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout("tableajax")
      ->build('product-tour/report-payment');
  }
  public function users_approval($action = "list", $pesan = "hal", $hal = 0){
//    $this->debug($this->menu, true);
    $list = $this->global_models->get_query("SELECT B.*, A.id_users AS ayah
      FROM m_users_approval AS A
      RIGHT JOIN m_users_approval AS B ON A.id_users_approval = B.parent
      WHERE ISNULL(A.parent)
      GROUP BY B.id_users_approval");
    
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
      <li><a href="'.site_url("grouptour/product-tour/add-new-users-approval").'"><i class="icon-plus"></i> Add New</a></li>
     <!-- <li><a href="'.site_url("menu/menu-cache").'"><i class="icon-plus"></i> Clear Cache</a></li>
      <li><a href="'.site_url("menu/export-xls").'"><i class="black-icons excel_document"></i> Export to XLS</a></li> -->
      ';
    $data_user = $this->global_models->get_dropdown("m_users", "id_users", "name", FALSE);
   
    $this->template
      ->set_layout('datatables')
      ->build('product-tour/main-users-approval', array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "menu",
            'data'        => $list,
            'title'       => "User Approval",
            'foot'        => $foot,
            'css'         => $css,
            'data_user'   => $data_user,
            'menutable'   => $menutable,
          ));
	}
  
  public function additional_request($status=0,$book_code=0,$kode_additional=0){
  
//    print $status."<br>";
//    print $book_code."<br>";
//    print $kode_additional."<br>"; die;
    if($status > 0){
     
          $kirim = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "book_code"                 => $book_code,
            "status"                    => $status,
            "kode_additional"           => $kode_additional,
            "id_users"                  => $this->session->userdata("id"),
            "name"                      => $this->session->userdata("name"),
            "create_by_users"           => $this->session->userdata("id"),
            "create_date"               => date("Y-m-d H:i:s"),
        );
          
          $add_detail = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/request-additional-tour");
       
          $discount_array = json_decode($add_detail);
		  
		   $kirim_additional = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      =>  $book_code,
          "status"                    => $status,
           "kode_additional"           => $kode_additional,      
              
        );
        $this->global_variable->curl_mentah($kirim_additional, URLSERVER."json/json-mail/approval-additional");
		
        if($discount_array->status == 2){
          $this->session->set_flashdata('success', 'Request Additional');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }else{
         $this->session->set_flashdata('notice', 'Gagal');
          redirect("grouptour/product-tour/book-information/{$book_code}");
      }
      
    }
	}
  
  public function add_new_users_approval($parent = 0, $id = 0, $pesan = "hal"){
//    print_r($this->input->post(NULL, TRUE)); die;
    $this->template->title('Sistem', "Menu Edit");
    if($id > 0){
      $data_detail = $this->global_models->get("m_users_approval", array("id_users_approval" => $id));
//      $this->debug($data_detail, true);
    }
    else{
      $data_detail[0]->id_menu = 0;
      $data_detail[0]->name = "";
      $data_detail[0]->link = "";
      $data_detail[0]->id_menu_kategori = 0;
    }
    $data_user = $this->global_models->get_dropdown("m_users", "id_users", "name", TRUE);
      
    if(!$this->input->post(NULL, TRUE)){
      $kate = $this->global_models->get_dropdown("m_users_approval", "id_users_approval", "name", TRUE);
      $this->template->build('product-tour/add-new-users-approval', 
        array('message' => $pesan,
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => "menu",
              'title'   => 'Add Menu',
              'data_user'    => $data_user,
              'detail'  => $data_detail,
              'kate'    => $kate,
              'breadcrumb'  => array(
                  "Menu"  => "menu"
              ),
              'parent'  => $parent,
            ));
      $this->template
        ->set_layout('default')
        ->build('product-tour/add-new-users-approval');
    }
    else{
      if($this->input->post("id_detail", TRUE)){
        $kirim = array(
              "id_users"              =>  $this->input->post("name", TRUE),
              "name"                  =>  $data_user[$this->input->post("name", TRUE)],
              "jabatan"                  =>  $this->input->post("jabatan", TRUE),
              "parent"      =>  $this->input->post("parent", TRUE),
              "sort"        =>  $this->input->post("sort", TRUE),
              "update_by_users"       =>  $this->session->userdata('id')
          );
        $hasil_in = $this->global_models->update("m_users_approval", array("id_users_approval" => $this->input->post("id_detail", TRUE)), $kirim);
      }
      else{
        $pst = $this->input->post(NULL, TRUE);
//        $pst = $pst['addressform']['addressform'][0];
        if($pst['name']){
          $kirim = array(
              "id_users"                  =>  $pst['name'],
            "name"                        =>  $data_user[$pst['name']],
              "jabatan"                   =>  $pst['jabatan'],
              "parent"                    =>  $pst['parent'],
              "sort"                      =>  $pst['sort'],
              "create_by_users"       =>  $this->session->userdata('id'),
              "create_date"           =>  date("Y-m-d H:i:s"),
              "update_by_users"       =>  $this->session->userdata('id')
          );
          $hasil_in = $this->global_models->insert("m_users_approval", $kirim);
        }
      }
      if($hasil_in){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect ("grouptour/product-tour/child/{$parent}");
    }
  }
  public function child($parent){
//    $this->debug($this->menu, true);
    $list = $this->global_models->get_query("SELECT B.*, A.id_users AS ayah
      FROM m_users_approval AS A
      RIGHT JOIN m_users_approval AS B ON A.id_users_approval = B.parent
      WHERE B.parent = '{$parent}'
      GROUP BY B.id_users_approval");
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
      <li><a href="'.site_url("grouptour/product-tour/add-new-users-approval/{$parent}").'"><i class="icon-plus"></i> Add New</a></li>
      
      ';
    $data_user = $this->global_models->get_dropdown("m_users", "id_users", "name", FALSE);
   
    $this->template
      ->set_layout('datatables')
      ->build('product-tour/main-users-approval', array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "menu",
            'data'        => $list,
            'title'       => "Menu",
            'foot'        => $foot,
            'css'         => $css,
            'data_user'   => $data_user,
            'menutable'   => $menutable,
          ));
	}
  
  function add_row_discount(){
    $kode_data = random_string('alnum', 10);
    $html_add = '<div id="'.$kode_data.'">'.$this->form_eksternal->form_input('note_discount[]', "", 'style="width:60%" class="form-control input-sm"  placeholder="Note"').$this->form_eksternal->form_input('discount_request[]', "", 'onkeyup="FormatCurrency(this)" style="width:30%" class="form-control input-sm"  placeholder="Discount Request"').' <a class="btn btn-danger btn-sm del-req" isi="'.$kode_data.'" >X</a>';
    print $html_add;
    die;
  }
  
  function ubah_deposit(){
    $pst = $this->input->post();
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $pst['id_payment'],
      "no_deposit"      => $pst['new_deposit'],
    );
//    $this->debug($pst, true);
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/update-deposit");
    $detail_array = json_decode($detail);
//    $this->debug($detail, true);
    redirect("grouptour/product-tour/book-information/{$pst['book_code']}");
  }
  
  function post_req_discount(){
    $pst = $this->input->post();
//    $this->debug($pst);
    $kirim_discount = array(
      "kode_product_tour_book"      => $pst['code'],
      "id_users"                    => $this->session->userdata("id"),
      "note"                        => $pst['note']." ".number_format($pst['nominal']),
      "tanggal"                     => date("Y-m-d H:i:s"),
      "status"                      => 1,
      "create_by_users"             => $this->session->userdata("id"),
      "create_date"                 => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("product_tour_log_request_discount_tour", $kirim_discount);
    $kirim_dis = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "nominal"                   => $pst['nominal'],
      "note"                      => $pst['note'],
      "id_users"                  => $this->session->userdata("id"),
      "code"                      => $pst['code'],
      "status"                    => 1,
    );
    $this->global_variable->curl_mentah($kirim_dis, URLSERVER."json/json-tour/req-discount");
	
	 if($pst['status_user'] == 1){
              $sd_email = $pst['user_approval'];
              $name_user = $pst['name_user'];
			   $keterangan = " Request Discount ini butuh Approval dari <b>{$name_user}</b>";
            }else{
               $sd_email = $pst['own_tc'];
               $name_user = $this->global_models->get_field("m_users", "name", array("email" => $pst['own_tc']));;
			   $keterangan = "";
              }
              
              $kirim_dis2 = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "note"                      =>$pst['note']." ".number_format($pst['nominal']),
            "id_users"                  => $this->session->userdata("id"),
            "code"                      => $pst['code'],
            "name_user"                 => $name_user,
             "email_user"               => $sd_email,   
				"keterangan"                    => $keterangan,
            "url"                       => base_url()."grouptour/product-tour/book-information/".$pst['code'],
          );
        $this->global_variable->curl_mentah($kirim_dis2, URLSERVER."json/json-mail/post-req-discount");
        
		
    print "";
    die;
  }
  
  function req_discount_approved(){
    $pst = $this->input->post();
//    $this->debug($pst);
    $status = array(
      2 => "Approved",
      3 => "Rejected"
    );
    $kirim_discount = array(
      "kode_product_tour_book"      => $pst['code'],
      "id_users"                    => $this->session->userdata("id"),
      "note"                        => $status[$pst['status']],
      "tanggal"                     => date("Y-m-d H:i:s"),
      "status"                      => 2,
      "create_by_users"             => $this->session->userdata("id"),
      "create_date"                 => date("Y-m-d H:i:s"),
    );
//    $this->debug($kirim_discount, true);
    $this->global_models->insert("product_tour_log_request_discount_tour", $kirim_discount);
    $kirim_dis = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "id"                        => $pst['id'],
      "id_users"                  => $this->session->userdata("id"),
      "status"                    => $pst['status'],
    );
    $this->global_variable->curl_mentah($kirim_dis, URLSERVER."json/json-tour/set-discount");
	
	  $sd_email = $pst['own_tc'];
       $name_user = $this->global_models->get_field("m_users", "name", array("email" => $pst['own_tc']));;
            
        $kirim_dis2 = array(
            "users"                     => USERSSERVER,
            "password"                  => PASSSERVER,
            "note"                      =>$pst['note']." ".number_format($pst['nominal']),
            "id_users"                  => $this->session->userdata("id"),
            "code"                      => $pst['code'],
            "name_user"                 => $name_user,
             "email_user"               => $sd_email,
            "status"                    => $status[$pst['status']],
            "url"                       => base_url()."grouptour/product-tour/book-information/".$pst['code'],
          );
        $this->global_variable->curl_mentah($kirim_dis2, URLSERVER."json/json-mail/req-discount-approved");       
          
		  
    print "";
    die;
  }
 
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */