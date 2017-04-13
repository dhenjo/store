<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_fit_ajax extends MX_Controller {
  function __construct() {
    $this->menu = $this->cek();
  }
  
  function add_itin_fit(){
    $nomor = $this->input->post("nomor") + 1;
    print ""
    . "<div class='form-group first' id='first'>"
      . "<div class='col-xs-4'>"
        . "<label>Itinerary</label>"
        . $this->form_eksternal->form_textarea('itinerary[]', '',"class='form-control input-sm' placeholder='Itinerary'")
      . "</div>"
      . "<div class='col-xs-4'>"
        . "<label>Meal Plan</label>"
        . $this->form_eksternal->form_dropdown('meal[]', array(0 => "None", 1 => "FB", 2 => "HB"), array(),"class='form-control input-sm'")
      . "</div>"
      . "<div class='col-xs-4'>"
        . "<label>Specific</label>"
        . $this->form_eksternal->form_textarea('specific[]', '',"class='form-control input-sm' placeholder='Specific'")
      . "</div>"
    . "</div>";
    die;
  }
  
  function get_tour_fit_request($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "id_users"            => $this->session->userdata("id"),
      "tanggal_start"       => $this->session->userdata('fit_search_start'),
      "tanggal_end"         => $this->session->userdata('fit_search_end'),
      "title"               => $this->session->userdata('fit_search_title'),
      "code"                => $this->session->userdata('fit_search_code'),
      "client"              => $this->session->userdata('fit_search_client'),
      "status"              => $this->session->userdata('fit_search_status'),
      "destination"         => $this->session->userdata('fit_search_destination'),
      "departure_start"     => $this->session->userdata('fit_search_p_start'),
      "departure_end"       => $this->session->userdata('fit_search_p_end'),
    );
    if($this->input->post("id_store")){
      $post['id_store'] = $this->input->post("id_store");
    }
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/get-tour-fit-request");
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
      1 => "<span class='label label-warning'>Request</span>",
      2 => "<span class='label label-info'>Proposal</span>",
      3 => "<span class='label label-success'>Book</span>",
      4 => "<span class='label label-success'>DP</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-success'>Lunas</span>",
      7 => "<span class='label label-success'>Quotation</span>",
      8 => "<span class='label label-success'>Req Timellimit</span>",
      9 => "<span class='label label-success'>Set Timellimit</span>",
    );
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        "<span style='display: none'>{$da->tanggal}</span>"
        . date("d M y", strtotime($da->tanggal)),
        "<a href='".site_url("tour/tour-fit/book-fit-request/{$da->kode}")."'>".$da->kode."</a>",
        $da->client,
        $da->title,
        $da->departure,
        $da->days,
        $da->destination,
        $status[$da->status],
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_chart_tour_fit_request($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "date_start"          => $this->session->userdata('tour_start'),
      "date_end"            => $this->session->userdata('tour_end'),
      "status"              => $this->session->userdata('tour_status'),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/get-chart-tour-fit-request");
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
      1 => "<span class='label label-warning'>Request</span>",
      2 => "<span class='label label-info'>Proposal</span>",
      3 => "<span class='label label-success'>Book</span>",
      4 => "<span class='label label-success'>DP</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-success'>Lunas</span>",
      7 => "<span class='label label-success'>Quotation</span>",
      8 => "<span class='label label-success'>Req Timelimit</span>",
      9 => "<span class='label label-success'>Set Timellimit</span>",
    );
    $sj = json_decode($this->input->post('sj'));
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        $da->tanggal,
        $da->title,
        $da->store,
        $status[$da->status],
        "<div style='width: 100%; text-align: right;'>".$da->pax."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format($da->debit)."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format($da->kredit)."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format(($da->debit-$da->kredit))."</div>",
      );
      $pax += $da->pax;
      $debit += $da->debit;
      $kredit += $da->kredit;
      $balance += ($da->debit - $da->kredit);
      $sj->{$da->id_store}->pax += $da->pax;
      $sj->{$da->id_store}->debit += $da->debit;
      $sj->{$da->id_store}->kredit += $da->kredit;
    }
//    $this->debug($sj, true);
    $return['hasil'] = $hasil;
    $return['pax'] = $pax;
    $return['debit'] = $debit;
    $return['kredit'] = $kredit;
    $return['balance'] = $balance;
    $return['sj'] = json_encode($sj);
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function post_pax(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata("id"),
      "code"                => $pst['code'],
      "ticket"              => $pst['ticket'],
      "title"               => $pst['title'],
      "type"                => $pst['type'],
      "bed_type"            => $pst['bed_type'],
      "first_name"          => $pst['first_name'],
      "id"                  => $pst['id'],
      "last_name"           => $pst['last_name'],
      "email"               => $pst['email'],
      "telp"                => $pst['telp'],
      "tempat_lahir"        => $pst['tempat_lahir'],
      "tanggal_lahir"       => $pst['tanggal_lahir'],
      "passport"            => $pst['passport'],
      "tempat_passport"     => $pst['tempat_passport'],
      "tanggal_passport"    => $pst['tanggal_passport'],
      "expired_passport"    => $pst['expired_passport'],
      "note"                => $pst['note'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-pax");
//    $data_array = json_decode($data);
    print $data;
    die;
  }
  
  function post_price_quotation(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata("id"),
      "code"                => $pst['code'],
      "adult_triple_twin"   => str_replace(",","",str_replace("Rp ","",$pst['adult_triple_twin'])),
      "adult_sgl_supp"      => str_replace(",","",str_replace("Rp ","",$pst['adult_sgl_supp'])),
      "child_twin_bed"      => str_replace(",","",str_replace("Rp ","",$pst['child_twin_bed'])),
      "child_extra_bed"     => str_replace(",","",str_replace("Rp ","",$pst['child_extra_bed'])),
      "child_no_bed"        => str_replace(",","",str_replace("Rp ","",$pst['child_no_bed'])),
      "adult_fare"          => str_replace(",","",str_replace("Rp ","",$pst['adult_fare'])),
      "child_fare"          => str_replace(",","",str_replace("Rp ","",$pst['child_fare'])),
      "infant_fare"         => str_replace(",","",str_replace("Rp ","",$pst['infant_fare'])),
      "bracket"             => $pst['pt_bracket'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-price-quotation");
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata("id"),
      "code"                => $pst['code'],
      "status"              => 2,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-status-fit-request");
//    $data_array = json_decode($data);
    print '1';
    die;
  }
  
  function post_payment(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata("id"),
      "code"                => $pst['code'],
      "nomor"               => $pst['nomor'],
      "nomor_ttu"           => $pst['nomor_ttu'],
      "price"               => str_replace(",","",str_replace("Rp ","",$pst['price'])),
      "rekening"            => $pst['rekening'],
      "note"                => $pst['note'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-payment");
//    $data_array = json_decode($data);
    print '1';
    die;
  }
  
  function post_price(){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata("id"),
      "code"                => $pst['code'],
      "type"                => $pst['type'],
      "title"               => $pst['title'],
      "price"               => str_replace(",","",str_replace("Rp ","",$pst['price'])),
      "qty"                 => $pst['qty'],
      "pos"                 => $pst['pos'],
      "note"                => $pst['note'],
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-price");
//    $data_array = json_decode($data);
    print '1';
    die;
  }
  
  function post_price_tag($sort){
    $pst = $this->input->post();
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "id_users"            => $this->session->userdata('id'),
      "id_store_region"     => $this->session->userdata('id_store_region'),
      "code"                => $pst['code'],
      "title"               => $pst['title'],
      "adult_triple_twin"   => str_replace(",","",str_replace("Rp ","",$pst['adult_triple_twin'])),
      "adult_triple_twin_sell"   => str_replace(",","",str_replace("Rp ","",$pst['adult_triple_twin_sell'])),
      "adult_sgl_supp"      => str_replace(",","",str_replace("Rp ","",$pst['adult_sgl_supp'])),
      "adult_sgl_supp_sell"      => str_replace(",","",str_replace("Rp ","",$pst['adult_sgl_supp_sell'])),
      "child_twin_bed"      => str_replace(",","",str_replace("Rp ","",$pst['child_twin_bed'])),
      "child_twin_bed_sell"      => str_replace(",","",str_replace("Rp ","",$pst['child_twin_bed_sell'])),
      "child_extra_bed"     => str_replace(",","",str_replace("Rp ","",$pst['child_extra_bed'])),
      "child_extra_bed_sell"     => str_replace(",","",str_replace("Rp ","",$pst['child_extra_bed_sell'])),
      "child_no_bed"        => str_replace(",","",str_replace("Rp ","",$pst['child_no_bed'])),
      "child_no_bed_sell"        => str_replace(",","",str_replace("Rp ","",$pst['child_no_bed_sell'])),
      "adult_fare"          => str_replace(",","",str_replace("Rp ","",$pst['adult_fare'])),
      "adult_fare_sell"          => str_replace(",","",str_replace("Rp ","",$pst['adult_fare_sell'])),
      "child_fare"          => str_replace(",","",str_replace("Rp ","",$pst['child_fare'])),
      "child_fare_sell"          => str_replace(",","",str_replace("Rp ","",$pst['child_fare_sell'])),
      "infant_fare"         => str_replace(",","",str_replace("Rp ","",$pst['infant_fare'])),
      "infant_fare_sell"         => str_replace(",","",str_replace("Rp ","",$pst['infant_fare_sell'])),
      "sort"                => $sort,
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/set-tour-fit-request-price-tag");
//    $data_array = json_decode($data);
    print '1';
    die;
  }
  
  function get_opt_tour_fit_request($start = 0){
    $post = array(
      "users"               => USERSSERVER,
      "password"            => PASSSERVER,
      "start"               => $start,
      "max"                 => 10,
      "id_users"            => $this->session->userdata("id"),
      "tanggal_start"       => $this->session->userdata('fit_search_start'),
      "tanggal_end"         => $this->session->userdata('fit_search_end'),
      "title"               => $this->session->userdata('fit_search_title'),
      "code"                => $this->session->userdata('fit_search_code'),
      "client"              => $this->session->userdata('fit_search_client'),
      "status"              => $this->session->userdata('fit_search_status'),
      "destination"         => $this->session->userdata('fit_search_destination'),
      "departure_start"     => $this->session->userdata('fit_search_p_start'),
      "departure_end"       => $this->session->userdata('fit_search_p_end'),
    );
    $data = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour-fit/get-tour-fit-request");
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
      1 => "<span class='label label-warning'>Request</span>",
      2 => "<span class='label label-info'>Proposal</span>",
      3 => "<span class='label label-success'>Book</span>",
      4 => "<span class='label label-success'>DP</span>",
      5 => "<span class='label label-danger'>Cancel</span>",
      6 => "<span class='label label-success'>Lunas</span>",
      7 => "<span class='label label-success'>Quotation</span>",
      8 => "<span class='label label-success'>Req Timelimit</span>",
      9 => "<span class='label label-success'>Set Timellimit</span>",
    );
    foreach ($data_array->data AS $da){
      $hasil[] = array(
        "<span style='display: none'>{$da->tanggal}</span>"
        . date("d M y", strtotime($da->tanggal)),
        "<a href='".site_url("tour/opt-tour/book-fit-request/{$da->kode}")."'>".$da->kode."</a>",
        $da->client,
        $da->name,
        $da->title,
        $da->departure,
        $da->days,
        $da->destination,
        $status[$da->status],
      );
    }
    $return['hasil'] = $hasil;
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function post_chat(){
    $pst = $this->input->post();
    $sort = $this->global_models->get_field("chat_request", "MAX(sort)", array("code" => $pst['code']));
    $post = array(
      "sort"            => ($sort + 1),
      "id_users"        => $pst['id'],
      "code"            => $pst['code'],
      "tanggal"         => date("Y-m-d H:i:s"),
      "note"            => $pst['chat'],
      "create_by_users" => $this->session->userdata("id"),
      "create_date"     => date("Y-m-d H:i:s"),
    );
    $this->global_models->insert("chat_request", $post);
  }
  
  function load_chat(){
    $pst = $this->input->post();
    $data = $this->global_models->get_query("SELECT A.*"
      . ",B.name"
      . " FROM chat_request AS A"
      . " LEFT JOIN m_users AS B ON A.id_users = B.id_users"
      . " WHERE A.sort > '{$pst['sort']}' AND A.code = '{$pst['code']}'"
      . " ORDER BY A.tanggal DESC");
    if($data){
      foreach($data AS $r => $cht){
        if($r == 0){
          $sort = $cht->sort;
        }
        $html .= ""
          . "<div class='item'>"
            . "<img src='".base_url()."themes/".DEFAULTTHEMES."/img/no-pic.png' alt='user image' class='offline'/>"
            . "<p class='message'>"
              . "<a href='#' class='name'><small class='text-muted pull-right'><i class='fa fa-clock-o'></i> {$cht->tanggal}</small>{$cht->name}</a>"
              . "{$cht->note}"
            . "</p>"
          . "</div>"
          . "";
      }
      $hasil = array(
        "status"      => 2,
        "html"        => $html,
        "sort"        => $sort,
      );
    }
    else{
      $hasil = array(
        "status"      => 3,
        "html"        => "",
        "sort"        => $pst['sort'],
      );
    }
    print json_encode($hasil);
    die;
  }
  
  function get_pax_request($start = 0){
    $itin_quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $this->input->post("code"),
    );
    $itin_quo = $this->antavaya_lib->curl_mentah($itin_quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-pax");  
    $itin_quo_array = json_decode($itin_quo);

    $return['status'] = 3;
    $ticket = array(
      1 => "<span class='label label-success'>Ticket</span>",
      2 => "<span class='label label-warning'>Ticketless</span>",
    );
    $type = array(
      1 => "<span class='label label-success'>Adult</span>",
      2 => "<span class='label label-info'>Child</span>",
      3 => "<span class='label label-warning'>Infant</span>",
    );
    foreach ($itin_quo_array->data AS $iq){
      if($start == 2){
        $btn_pax = "";
      }
      else{
        $btn_pax = "<div class='btn-group-vertical'>"
          . "<button type='button' class='btn btn-success pax-edit' data-toggle='modal' data-target='#edit-detail-pax' isi='{$iq->id_tour_fit_request_pax}'>"
            . "<i class='fa fa-edit'></i>"
          . "</button>"
//          . "<button type='button' class='btn btn-danger tour-delete' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='WQKJZFLEIB' id='id-customer-cancel'"
//            . "><i class='fa fa-times'></i>"
//          . "</button>"
        . "</div>";
      }
      $hasil[] = array(
        $type[$iq->type],
        $iq->first_name." ".$iq->last_name,
        $iq->telp,
        $iq->passport,
        $ticket[$iq->ticket],
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
  
  function confirm_time_limit(){
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $this->input->post("code"),
      "status"            => 3,
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-status-fit-request");  
    print "2";die;
  }
  
  function set_time_limit(){
    $pst = $this->input->post();
    $tl = $pst['time_limit'];
    $tl_ex = explode(" ", $tl);
    $tl_time = explode(":", $tl_ex[0]);
    if($tl_ex[1] == "PM"){
      $tl_time[0] += 12;
    }
    $time_limit = $tl_time[0].":".$tl_time[1].":00";
    
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $pst['code'],
      "status"            => 9,
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-status-fit-request");
    $data_array = json_decode($book);
    $post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $pst['code'],
      "status"            => 9,
      "date_limit"        => $pst['date_limit'],
      "time_limit"        => $time_limit,
      "id_users"          => $this->session->userdata("id"),
    );
    $book = $this->antavaya_lib->curl_mentah($post, URLSERVER."json/json-tour-fit/set-timelimit-fit-request");
    
    $users_opt = $this->global_models->get("m_users", array("id_users" => $this->session->userdata("id")));
    $users_to_users = $this->global_models->get("m_users", array("id_users" => $data_array->users));
      
    $this->load->library('email');
    $this->email->initialize($this->global_models->email_conf());
    $this->email->from($users_opt[0]->email, $users_opt[0]->name);
    $this->email->to($users_to_users[0]->email);
    $this->email->bcc('nugroho.budi@antavaya.com');

    $this->email->subject("[FIT] Set Timelimit {$pst['code']}");
    $this->email->message("
      Dear {$users_to_users[0]->name} <br />
      Untuk book code <a href='".site_url("tour-fit/book-fit-request/{$pst['code']}")."'>{$pst['code']}</a><br />
      Telah di set timelimit <br />
      Terima Kasih <br />
      {$users_opt[0]->name}
      ");

    $this->email->send();
    
    print $pst['date_limit']." ".$time_limit;
    die;
  }
  
  function get_price_request($start = 0){
    $itin_quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $this->input->post("code"),
    );
    $itin_quo = $this->antavaya_lib->curl_mentah($itin_quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-price");  
    $itin_quo_array = json_decode($itin_quo);
    
    if($this->input->post("quo") >= 3 && $this->input->post("quo") != 5){
      $gen_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $this->input->post("code"),
      );
      $gen = $this->antavaya_lib->curl_mentah($gen_post, URLSERVER."json/json-tour-fit/generate-tour-fit-request-status");
      $gen_array = json_decode($gen);
      $return['quo'] = $gen_array->data;
    }
    else{
      $return['quo'] = 2;
    }

    $return['status'] = 3;
    foreach ($itin_quo_array->data AS $iq){
      if($iq->pos == 1){
        $total_debit = $iq->qty * $iq->price;
        $total_kredit = 0;
      }
      else{
        $total_kredit = $iq->qty * $iq->price;
        $total_debit = 0;
      }
      $hasil[] = array(
        $iq->tanggal,
        $iq->kode,
        $iq->title,
        "<div style='width: 100%; text-align: right;'>".number_format($iq->qty)."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format($iq->price)."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format($total_debit)."</div>",
        "<div style='width: 100%; text-align: right;'>".number_format($total_kredit)."</div>",
      );
      $sum_debit += $total_debit;
      $sum_kredit += $total_kredit;
    }
    $return['hasil']  = $hasil;
    $return['debit']  = number_format($sum_debit);
    $return['kredit'] = number_format($sum_kredit);
    $return['total'] = number_format(($sum_debit-$sum_kredit));
//    $this->debug($return, true);
    print json_encode($return);
    die;
  }
  
  function get_detail_pax(){
    $pst = $this->input->post();
    $itin_quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "id"                => $pst['id'],
    );
    $itin_quo = $this->antavaya_lib->curl_mentah($itin_quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-pax-detail");  
    print $itin_quo;
    die;
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */