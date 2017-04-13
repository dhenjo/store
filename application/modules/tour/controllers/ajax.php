<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MX_Controller {
  function __construct() {
//    $this->menu = $this->cek();
  }
  
  function itin_quo_edit(){
    $pst = $this->input->post();
    $post = array(
      "users"                       => USERSSERVER,
      "password"                    => PASSSERVER,
      "id_tour_fit_request_detail"  => $pst['id'],
    );

    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail-items");  
    print $data;
    die;
  }
  
  function update_itin_quo(){
    $pst = $this->input->post();
    $post = array(
      "users"                       => USERSSERVER,
      "password"                    => PASSSERVER,
      "id_tour_fit_request_detail"  => $pst['id'],
      "id_tour_fit_request"         => $pst['id_tour_fit_request'],
      "id_users"                    => $this->session->userdata("id"),
      "sort"                        => $pst['sort'],
      "itinerary"                   => $pst['itinerary'],
      "meal"                        => $pst['meal'],
      "entrance"                    => str_replace(",","",str_replace("Rp ","",$pst['entrance'])),
      "specific"                    => $pst['specific'],
      "type"                        => 2
    );

    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/update-tour-fit-request-detail-items");  
    print $data;
    die;
  }
  
  function add_row(){
    $nomor = $this->input->post("no") + 1;
    print "<div class='input-group margin' id='users-box{$nomor}'>"
      . "<input type='text' class='form-control' id='users{$nomor}' name='users[]'>"
      . "<input type='text' class='form-control' id='id_users{$nomor}' name='id_users[]' style='display: none'>"
      . "<span class='input-group-btn'>"
        . "<a href='javascript:void(0)' class='btn btn-danger btn-flat delete' isi='users-box{$nomor}'>"
          . "<i class='fa fa-fw fa-times'></i>"
        . "</a>"
      . "</span> "
    . "</div>"
    . "<script>"
        . "$(function() {"
          . "$( '#users{$nomor}' ).autocomplete({"
            . "source: '".site_url("tour/ajax/users")."',"
            . "minLength: 1,"
            . "search  : function(){ $(this).addClass('working');},"
            . "open    : function(){ $(this).removeClass('working');},"
            . "select: function( event, ui ) {"
              . "$('#id_users{$nomor}').val(ui.item.id);"
            . "}"
          . "});"
        . "});"
    . "</script>";
    die;
  }
  
  function add_on_tour(){
    $nomor = $this->input->post("nomor") + 1;
    print "<div class='input-group input-group-sm' id='first{$nomor}'>"
      . $this->form_eksternal->form_input('add[]', "",'class="form-control input-sm" placeholder="Tour Name" style="width: 50%"')
      . $this->form_eksternal->form_input('add_adult[]', "",'class="form-control input-sm harga" placeholder="Adult" style="width: 25%"')
      . $this->form_eksternal->form_input('add_child[]', "",'class="form-control input-sm harga" placeholder="Child" style="width: 25%"')
      . "<span class='input-group-btn'>"
        . "<a href='javascript:void(0)' isi='first{$nomor}' class='btn btn-danger btn-flat delete-add-on-tour'>X</a>"
      . "</span>"
    . "</div>"
    . "<script>"
      . "$(function() {"
        . "$('.harga').priceFormat({"
          . "prefix: 'Rp ',"
          . "centsLimit: 0"
        . "});"
      . "});"
    . "</script>";
    die;
  }
  
  function users(){
    if (empty($_GET['term'])) exit ;
    $q = strtolower($_GET["term"]);
    if (get_magic_quotes_gpc()) $q = stripslashes($q);
    $items = $this->global_models->get_query("
      SELECT *
      FROM m_users
      WHERE 
      (LOWER(name) LIKE '%{$q}%' OR LOWER(email) LIKE '%{$q}%')
      LIMIT 0,20
      ");
    if(count($items) > 0){
      foreach($items as $tms){
        $result[] = array(
            "id"    => $tms->id_users,
            "label" => $tms->name." <".$tms->email.">",
            "value" => $tms->name." <".$tms->email.">",
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
  
  function book_list($total = 0, $start = 0){
    
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

      $data = $this->global_variable->curl_mentah($data, URLSERVER."json/json-midlle-system/get-tour-book-list");  
      $data_array = json_decode($data);
//      $this->debug($data, true); 
      if($data_array->status == 2){
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
    
          $nobook     = 0;
          $nocommit   = 0;
          $nolunas    = 0;
          $nocancel   = 0;
          $wt_app     = 0;
          foreach ($value->passenger as $key1 => $valps) {
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
      
          $tot_disc_price=0;
          if($value->status_discount == "Persen"){
            $tot_disc_price =  (($value->beban_awal * $value->discount)/100);
          }elseif($value->status_discount == "Nominal") {
            $tot_disc_price = $value->discount;
          }
            
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
            . "<li><a href='".site_url("store/move-bookers/".$value->code)."'>Move TC</a></li>"
             . "<li><a href='".site_url("grouptour/product-tour/change-tour/".$value->code)."'>Change Tour</a></li>"
            // . "<li><a href='".site_url("store/cancel-book/".$value->code)."'>Cancel Book</a></li>"
			. "<li><a href='javascript:void(0)' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$value->code}' id='id-customer-cancel' >Cancel Tour</a></li>"
        . "</td>"
      . "</tr>";
    }
  }
    
    die;
  }
  
  function halaman_default($total = 0, $start = 0){
    
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
  
  function get_sales_lead($start = 0){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $start,
      "max"         => 10,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-sales-lead");  
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) == 10){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->tanggal,
        $da->first_name." ".$da->last_name,
        $da->email,
        $da->telphone,
        $da->users,
      );
    }
    $return['hasil'] = $hasil;
    print json_encode($return);
    die;
  }
  
  function get_tour_product($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "start_date"          => $this->session->userdata("tour_search_start"),
      "end_date"            => $this->session->userdata("tour_search_end"),
      "status"              => $this->session->userdata("tour_search_status"),
      "code"                => $this->session->userdata("tour_search_kode"),
      "no_pn"               => $this->session->userdata("tour_search_no_pn"),
      "title"               => $this->session->userdata("tour_search_title"),
      "category_product"    => $this->session->userdata("tour_search_category_product"),
      "id_store_region"     => $this->session->userdata("tour_search_id_store_region"),
      "destination"         => $this->session->userdata("tour_search_destination"),
      "landmark"            => $this->session->userdata("tour_search_landmark"),
      "sub_category"        => $this->session->userdata("tour_search_sub_category"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-product-search");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-success'>Available</span>",
      5 => "<span class='label label-warning'>Push Selling</span>",
    );
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    $kategori = array(
      1 => "<span class='label label-success'>Viesta</span>",
      2 => "<span class='label label-warning'>Premium</span>",
    );
    
    foreach ($data_array->data AS $da){
	    
	    if($da->at_airport_date != "0000-00-00" AND $da->at_airport_date != ""){
            $date_start = $da->at_airport_date;
        }else{
            $date_start = $da->start_date;
        }
        
      $hasil[] = array(
        $status[$da->status_info]."<br>".$da->kode_info,
        "<span style='display: none'>{$date_start}</span>"
        . "<a class='tooltip-harga' isi='{$da->kode_info}' href='".site_url("grouptour/product-tour/book-tour/".$da->kode_info)."'>"
          . date("d M y", strtotime($date_start))
        . "</a>",
        "<span style='display: none'>{$da->end_date}</span>".date("d M y", strtotime($da->end_date)),
        "<a class='tooltip-title' isi='{$da->kode_info}' target='_blank' href='".site_url("grouptour/product-tour/tour-detail/".$da->kode)."'>".$da->title."</a>"
          . "<br />".$region[$da->sub_category]
          . "<br />".$kategori[$da->category_product],
        $da->no_pn,
        $da->flt,
        $da->days,
        $da->available_seat,
        $da->book,
        $da->conf,
        "<a href='".site_url("tour/list-tour-book-umum/{$da->kode_info}")."'>".($da->available_seat - $da->conf)."</a>",
        number_format($da->adult_triple_twin),
        number_format($da->airport_tax),
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_tour_product_fit($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "date_start"          => $pst['fit_search_start'],
      "date_end"            => $pst['fit_search_end'],
      "title"               => $pst['fit_search_title'],
      "hotel"               => $pst['fit_search_hotel'],
      "id_store_region"     => $pst['fit_search_id_store_region'],
      "kode"                => $pst['fit_search_kode'],
      "region"              => $pst['fit_search_region'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-product-fit-search");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    $bfast = array(
      1 => "<span class='label label-danger'>N/A</span>",
      2 => "<span class='label label-info'>Include</span>",
      3 => "<span class='label label-success'>For 1 Pax</span>",
      4 => "<span class='label label-success'>For 2 Pax</span>",
    );
    foreach ($data_array->data AS $da){
      $stars = "";
      for($r = 1 ; $r <= 5 ; $r++){
        if($da->stars >= $r){
          $stars .= "<i style='color: yellow' class='fa fa-fw fa-star'></i>";
        }
        else{
          $stars .= "<i class='fa fa-fw fa-star-o'></i>";
        }
      }
      $twn = number_format($da->twn);
      if(!$da->twn)
        $twn = "<span class='label label-danger'>N/A</span>";
      
      $sgl = number_format($da->sgl);
      if(!$da->sgl)
        $sgl = "<span class='label label-danger'>N/A</span>";
      
      $x_bed = number_format($da->x_bed);
      if(!$da->x_bed)
        $x_bed = "<span class='label label-danger'>N/A</span>";
      
      $tambah = "";
      if($da->bfast > 2)
        $tambah = "<br />".number_format($da->bfast_price);
      
      $hasil[] = array(
        "<span style='display: none'>{$da->start_date}</span>"
        . "<a href='".site_url("tour/book-fit/{$da->kode}")."'>".date("d M y", strtotime($da->start_date))." - ".date("d M y", strtotime($da->end_date))."</a>",
        "<b>".$da->title."</b><br />".$da->hotel."<br />".$stars,
        $da->kode,
        $da->days."/".$da->nights,
        $bfast[$da->bfast].$tambah,
        $twn,
        $sgl,
        $x_bed,
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_book_tour_fit($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "date_start"          => $pst['fit_search_start'],
      "date_end"            => $pst['fit_search_end'],
      "title"               => $pst['fit_search_title'],
      "hotel"               => $pst['fit_search_hotel'],
      "id_store_region"     => $pst['fit_search_id_store_region'],
      "kode"                => $pst['fit_search_kode'],
      "region"              => $pst['fit_search_region'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-book-tour-fit");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    $status = array(
      1     => "<span class='label label-default'>Draft</span>",
      2     => "<span class='label label-info'>Price Request</span>",
      3     => "<span class='label label-info'>Add Price</span>",
      4     => "<span class='label label-success'>Book</span>",
      5     => "<span class='label label-danger'>Cancel</span>",
      6     => "<span class='label label-success'>Departured</span>",
    );
    foreach ($data_array->data AS $da){
      $stars = "";
      for($r = 1 ; $r <= 5 ; $r++){
        if($da->stars >= $r){
          $stars .= "<i style='color: yellow' class='fa fa-fw fa-star'></i>";
        }
        else{
          $stars .= "<i class='fa fa-fw fa-star-o'></i>";
        }
      }
      
      $hasil[] = array(
        $da->tanggal,
        "<a href='".site_url("tour/book-fit-detail/{$da->kode}")."'>".$da->kode."</a>",
        $da->departure,
        $da->name,
        $da->email,
        "<b>".$da->fit."</b><br />"
        . "{$da->hotel}<br />"
        . "{$stars}",
        $status[$da->status],
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_master_tour($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "start_date"          => $this->session->userdata("tour_search_start"),
      "end_date"            => $this->session->userdata("tour_search_end"),
      "status"              => $this->session->userdata("tour_master_status"),
      "code"                => $this->session->userdata("tour_search_kode"),
      "no_pn"               => $this->session->userdata("tour_search_no_pn"),
      "title"               => $this->session->userdata("tour_search_title"),
      "category_product"    => $this->session->userdata("tour_search_category_product"),
      "id_store_region"     => $this->session->userdata("tour_search_id_store_region"),
      "destination"         => $this->session->userdata("tour_search_destination"),
      "landmark"            => $this->session->userdata("tour_search_landmark"),
      "sub_category"        => $this->session->userdata("tour_search_sub_category"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-tour");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-success'>Publish</span>",
      2 => "<span class='label label-warning'>Draft</span>",
    );
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    $kategori = array(
      1 => "<span class='label label-success'>Viesta</span>",
      2 => "<span class='label label-warning'>Premium</span>",
    );
    
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $this->form_eksternal->form_checkbox("pilih_master[]", $da->id_product_tour, FALSE),
        $da->no_pn,
        $da->title."<br />"
        . "{$kategori[$da->category_product]} <br />"
        . $region[$da->sub_category]." <br />"
        . $da->kode,
        $da->store_region,
        $da->days,
        $da->schedule,
        $da->available,
        $da->cancel,
        $da->go,
        $da->push,
        $status[$da->status],
        "<div class='btn-group'>"
          . "<a href='".site_url("tour/tour-master/edit-master-tour/{$da->kode}")."' type='button' class='btn btn-info btn-flat' style='width: 40px'><i class='fa fa-edit'></i></a>"
          . "<a href='".site_url("tour/tour-master/duplicate-schedule/{$da->id_tour_schedule}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'><i class='fa fa-copy'></i></a>"
          . "<a target='_blank' href='".site_url("tour/tour-series/schedule/{$da->kode}")."' type='button' class='btn btn-warning btn-flat' style='width: 40px'><i class='fa fa-calendar'></i></a>"
          . "<button type='button' class='btn btn-danger btn-flat' style='width: 40px'><i class='fa fa-times'></i></button>"
        . "</div>"
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_itin_quo_detail($start = 0){
    $itin_quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $this->input->post("code"),
//      "code"              => $start,
      "type"              => 23,
    );
    $itin_quo = $this->antavaya_lib->curl_mentah($itin_quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
    $itin_quo_array = json_decode($itin_quo);

    $return['status'] = 3;
    $meal = array(
      0 => "<span class='label label-default'>None</span>",
      1 => "<span class='label label-success'>FB</span>",
      2 => "<span class='label label-info'>HB</span>",
    );
    foreach ($itin_quo_array->data AS $iq){
      if($start == 2){
        $btn_pax = "";
      }
      else{
        $btn_pax = "<div class='btn-group-vertical'>"
          . "<button type='button' class='btn btn-success itin-quo-edit' data-toggle='modal' data-target='#edit-detail-quo' isi='{$iq->id_tour_fit_request_detail}'>"
            . "<i class='fa fa-edit'></i>"
          . "</button>"
          . "<button type='button' class='btn btn-danger tour-delete' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='WQKJZFLEIB' id='id-customer-cancel'"
            . "><i class='fa fa-times'></i>"
          . "</button>"
        . "</div>";
      }
      $hasil[] = array(
        $iq->sort,
        nl2br($iq->itinerary),
        $meal[$iq->meal],
        number_format($iq->entrance),
        nl2br($iq->specific),
        "<div class='btn-group'>"
        . "{$btn_pax}"
        . "</div>",
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_master_tour_fit($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "code"                => $this->session->userdata("fit_search_code"),
      "title"               => $this->session->userdata("fit_search_title"),
      "store_region"        => $this->session->userdata("fit_search_ex"),
      "region"              => $this->session->userdata("fit_search_region"),
      "status"              => $this->session->userdata("fit_search_status"),
      "destination"         => $this->session->userdata("fit_search_destination"),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-tour-fit");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-success'>Publish</span>",
      2 => "<span class='label label-warning'>Draft</span>",
    );
    $region = array(
      1 => "Europe",
      2 => "Africa",
      3 => "America",
      4 => "Australia",
      5 => "Asia",
      6 => "China",
      7 => "New Zealand"
    );
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $this->form_eksternal->form_checkbox("pilih_master[]", $da->kode, FALSE),
        $da->kode,
        $da->title,
        $da->store_region,
        $region[$da->region],
        $status[$da->status],
        "<div class='btn-group'>"
          . "<a href='".site_url("tour/tour-master/add-fit/{$da->kode}")."' type='button' class='btn btn-info btn-flat' style='width: 40px'><i class='fa fa-edit'></i></a>"
          . "<a href='".site_url("tour/tour-master/duplicate-tour-fit/{$da->kode}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'><i class='fa fa-copy'></i></a>"
          . "<a href='".site_url("tour/tour-master/manage-schedule-fit/{$da->kode}")."' type='button' class='btn btn-warning btn-flat' style='width: 40px'><i class='fa fa-calendar'></i></a>"
          . "<button type='button' class='btn btn-danger btn-flat' style='width: 40px'><i class='fa fa-times'></i></button>"
        . "</div>"
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_book_list_fit($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-book-list-fit");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-warning'>Book</span>",
      2 => "<span class='label label-info'>Request</span>",
      3 => "<span class='label label-info'>Quotation</span>",
      4 => "<span class='label label-success'>Confirm</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
    );
    
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->tanggal,
        $da->kode,
        $da->fit_code,
        $da->name,
        $da->email,
        $status[$da->status],
        "<div class='btn-group'>"
          . "<a href='".site_url("tour/book-fit-detail/{$da->kode}")."' type='button' class='btn btn-info btn-flat' style='width: 40px'><i class='fa fa-edit'></i></a>"
        . "</div>"
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_opt_book_list_fit($start = 0){
    if($this->session->userdata('fit_search_status')){
      $status = $this->session->userdata('fit_search_status');
    }
    else{
      $status = 234;
    }
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "status"              => $status,
      "date_start"          => $this->session->userdata('fit_search_start'),
      "date_end"            => $this->session->userdata('fit_search_end'),
      "code"                => $this->session->userdata('fit_search_code'),
      "fit_code"            => $this->session->userdata('fit_search_fit_code'),
      "name"                => $this->session->userdata('fit_search_name'),
      "email"               => $this->session->userdata('fit_search_email'),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-book-list-fit");
    $data_array = json_decode($data);
//    $this->debug($post);
//    $this->debug($data_array, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-warning'>Book</span>",
      2 => "<span class='label label-info'>Request</span>",
      3 => "<span class='label label-info'>Quotation</span>",
      4 => "<span class='label label-success'>Confirm</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-success'>Departured</span>",
    );
    
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->tanggal,
        $da->kode,
        $da->fit_code,
        $da->name,
        $da->email,
        $status[$da->status],
        "<div class='btn-group'>"
          . "<a href='".site_url("tour/opt-tour/book-fit-detail/{$da->kode}")."' type='button' class='btn btn-info btn-flat' style='width: 40px'><i class='fa fa-edit'></i></a>"
        . "</div>"
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_master_tour_fit_schedule($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "fit"                 => $this->input->post("kode"),
      "tanggal"             => $this->session->userdata('fit_search_tanggal'),
      "kode"                => $this->session->userdata('fit_search_kode'),
      "stars"               => $this->session->userdata('fit_search_stars'),
      "status"              => $this->session->userdata('fit_search_status'),
      "hotel"               => $this->session->userdata('fit_search_hotel'),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-master-tour-fit-schedule");
    $data_array = json_decode($data);
//    $this->debug($data, true);
    if(count($data_array->data) > 0){
      $return['status'] = 2;
      $return['start']  = $start + 10;
    }
    else{
      $return['status'] = 3;
    }
    
    $status = array(
      1 => "<span class='label label-success'>Publish</span>",
      2 => "<span class='label label-warning'>Draft</span>",
    );
    
    $bfast = array(
      1 => "<span class='label label-danger'>N/A</span>",
      2 => "<span class='label label-info'>Include</span>",
      3 => "<span class='label label-success'>For 1 Pax</span>",
      4 => "<span class='label label-success'>For 2 Pax</span>",
    );
    
    foreach ($data_array->data AS $da){
      $tambah = "";
      if($da->bfast > 2)
        $tambah = "<br />".number_format($da->bfast_price);
      
      $twn = number_format($da->twn);
      if(!$da->twn)
        $twn = "<span class='label label-danger'>N/A</span>";
      $sgl = number_format($da->sgl);
      if(!$da->sgl)
        $sgl = "<span class='label label-danger'>N/A</span>";
      $x_bed = number_format($da->x_bed);
      if(!$da->x_bed)
        $x_bed = "<span class='label label-danger'>N/A</span>";
      
      $hasil[] = array(
        $this->form_eksternal->form_checkbox("pilih_master[]", $da->id_product_tour, FALSE),
        "<span style='display: none'>{$da->start_date}</span>".date("d M y", strtotime($da->start_date))." - ".date("d M y", strtotime($da->end_date)),
        $da->kode,
        $da->hotel,
        $da->stars,
        "<span style='display: none'>{$da->days}</span>".$da->days."/".$da->nights,
        $bfast[$da->bfast].$tambah,
        $twn,
        $sgl,
        $x_bed,
        $status[$da->status],
        "<div class='btn-group'>"
          . "<a href='".site_url("tour/tour-master/edit-master-tour-schedule/{$this->input->post("kode")}/{$da->kode}")."' type='button' class='btn btn-info btn-flat' style='width: 40px'><i class='fa fa-edit'></i></a>"
          . "<a href='".site_url("tour/tour-master/duplicate-master-fit-schedule/{$this->input->post("kode")}/{$da->kode}")."' type='button' class='btn btn-success btn-flat' style='width: 40px'><i class='fa fa-copy'></i></a>"
          . "<button type='button' class='btn btn-danger btn-flat' style='width: 40px'><i class='fa fa-times'></i></button>"
        . "</div>"
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function load_tooltip_detail_tour($code){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-tour-information-detail");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $html = ""
      . "<table width='100%'>"
        . "<tbody>"
          . "<tr>"
            . "<td>Store</td>"
            . "<td>{$data_array->data[0]->store_region}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Flight</td>"
            . "<td>{$data_array->data[0]->flt}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>STS</td>"
            . "<td>{$data_array->data[0]->sts}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>IN</td>"
            . "<td>{$data_array->data[0]->in}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>OUT</td>"
            . "<td>{$data_array->data[0]->out}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Keberangkatan</td>"
            . "<td>{$data_array->data[0]->keberangkatan}</td>"
          . "</tr>"
          . "<tr>"
            . "<td colspan='2' style='font-size: 15px'>"
              . "<center>Klik nama tour untuk detail Itin</center>"
            . "</td>"
          . "</tr>"
          . "<tr>"
            . "<td colspan='2'>"
              . "<center>{$data_array->data[0]->destination}</center>"
            . "</td>"
          . "</tr>"
          . "<tr>"
            . "<td colspan='2'>"
              . "<center>{$data_array->data[0]->landmark}</center>"
            . "</td>"
          . "</tr>"
        . "</tbody>"
      . "</table>";
    print $html;
    die;
  }
  
  function load_tooltip_harga_tour($code){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "code"                => $code,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-tour-information-harga");
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
    $html = ""
      . "<table width='100%'>"
        . "<tbody>"
          . "<tr>"
            . "<td>Tour Code</td>"
            . "<td style='text-align: left'>{$data_array->data[0]->kode}</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Adult Triple/Twin</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->adult_triple_twin)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child Twin Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_twin_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child Extra Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_extra_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Child No Bed</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->child_no_bed)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>SGL SUPP</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->sgl_supp)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td>Airport Tax &amp; Flight Insurance</td>"
            . "<td style='text-align: left'>".number_format($data_array->data[0]->airport_tax)."</td>"
          . "</tr>"
          . "<tr>"
            . "<td colspan='2'>"
              . "<center>"
                . "<a href='".site_url("grouptour/product-tour/book-tour/{$data_array->data[0]->kode}")."' class='btn btn-primary'>BOOK</a>"
              . "</center>"
            . "</td>"
            . "<td></td>"
          . "</tr>"
        . "</tbody>"
      . "</table>";
    print $html;
    die;
  }
  
  function edit_pax_book(){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $this->input->post("code"),
//      "code"        => $_GET['code'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/get-detail-fit-pax-book");
    print $data;
    die;
  }
  
  function add_row_opt_book_price(){
    print ""
    . "<tr>"
      . "<td>".$this->form_eksternal->form_input("note[]", "", 'class="form-control input-sm" placeholder="Note"')."</td>"
      . "<td>".$this->form_eksternal->form_input("qty[]", "", 'class="form-control input-sm" placeholder="Qty"')."</td>"
      . "<td>".$this->form_eksternal->form_input("price[]", "", 'class="form-control input-sm harga" placeholder="Price / qty"')."</td>"
      . "<td></td>"
    . "</tr>"
    . "<script>"
      . "$('.harga').priceFormat({"
        . "prefix: 'Rp ',"
        . "centsLimit: 0"
      . "});"
    . "</script>";
    die;
  }
  
  function add_row_opt_book_discount(){
    print ""
    . "<tr>"
      . "<td>".$this->form_eksternal->form_input("note_discount[]", "", 'class="form-control input-sm" placeholder="Note"')."</td>"
      . "<td>".$this->form_eksternal->form_input("qty_discount[]", "", 'class="form-control input-sm" placeholder="Qty"')."</td>"
      . "<td>".$this->form_eksternal->form_input("price_discount[]", "", 'class="form-control input-sm harga" placeholder="Discount / qty"')."</td>"
      . "<td></td>"
    . "</tr>"
    . "<script>"
      . "$('.harga').priceFormat({"
        . "prefix: 'Rp ',"
        . "centsLimit: 0"
      . "});"
    . "</script>";
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */