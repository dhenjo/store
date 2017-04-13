<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class print_store extends MX_Controller {
    
  function __construct() {
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
  
  function tour($tour_code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $tour_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail_array, true);
    $data = array(
      'title'     => $detail_array->tour->title,
      'kedua'     => $detail_array->tour->days." Hari / {$detail_array->tour->night} Malam - {$detail_array->tour->airlines}",
      'ketiga'    => $detail_array->tour->destination,
      'keempat'   => $detail_array->tour->landmark,
      'body'      => $detail_array->tour->text,
      'info'      => $detail_array->tour->information,
    );
    $this->load->view('print/detail-tour', $data);
  }
  
  function tour_fit_proposal($kode){
    $book_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "start"             => 0,
      "max"               => 1,
    );
    $book = $this->antavaya_lib->curl_mentah($book_post, URLSERVER."json/json-tour-fit/get-tour-fit-request");  
    $book_array = json_decode($book);

    $quo_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "start"             => 0,
      "max"               => 1,
    );
    $quo = $this->antavaya_lib->curl_mentah($quo_post, URLSERVER."json/json-tour-fit/get-tour-fit-quotation");  
    $quo_array = json_decode($quo);
    
    $itin_post = array(
      "users"             => USERSSERVER,
      "password"          => PASSSERVER,
      "code"              => $kode,
      "type"              => 2,
    );
    $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
    $itin_array = json_decode($itin);
    if($itin_array->status == 3){
      $itin_post = array(
        "users"             => USERSSERVER,
        "password"          => PASSSERVER,
        "code"              => $kode,
        "type"              => 3,
      );
      $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
      $itin_array = json_decode($itin);
      if($itin_array->status == 3){
        $itin_post = array(
          "users"             => USERSSERVER,
          "password"          => PASSSERVER,
          "code"              => $kode,
        );
        $itin = $this->antavaya_lib->curl_mentah($itin_post, URLSERVER."json/json-tour-fit/get-tour-fit-request-detail");  
        $itin_array = json_decode($itin);
      }
    }
//    $this->debug($itin_array, true);
    
    $meal = array(0 => "None", 1 => "FB", 2 => "HB");
    $day = 1;
    foreach($itin_array->data AS $itin){
      $body .= "<p><u><strong>Day {$day} : </strong></u></p>"
        . "<p>".nl2br($itin->itinerary)
        . "<br />Meal : <strong>{$meal[$itin->meal]}</strong>"
        . "<br />Entrance Fee : ".number_format($itin->entrance)."</p>";
      $day++;
    }
    $data = array(
      'title'     => $book_array->data[0]->title." - ".$book_array->data[0]->client,
      'kedua'     => date("d M Y", strtotime($book_array->data[0]->departure))." - ".date("d M Y", strtotime($book_array->data[0]->arrive))." / {$quo_array->data[0]->airline} <br />"
          . "{$quo_array->data[0]->destination} <br />"
          . "{$quo_array->data[0]->hotel} * {$quo_array->data[0]->stars}",
      'body'      => $body,
      'harga'     => array(
        "triple"      => $quo_array->data[0]->adult_triple_twin,
        "sgl"         => $quo_array->data[0]->adult_sgl_supp,
        "twin"        => $quo_array->data[0]->child_twin_bed,
        "extra"       => $quo_array->data[0]->child_extra_bed,
        "no"          => $quo_array->data[0]->child_no_bed,
        "adult"       => $quo_array->data[0]->adult_fare,
        "child"       => $quo_array->data[0]->child_fare,
        "infant"      => $quo_array->data[0]->infant_fare,
      ),
      'info'      => $quo_array->data[0]->toc,
    );
    $this->load->view('print/tour-fit-proposal', $data);
  }
  
  function tour_schedule($tour_code,$code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $tour_code,
      "code_schedule"   => $code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-product-tour-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail_array, true);
    $pst = $this->input->post();
    if($pst){
//      $this->debug($pst, true);
      $this->load->library('email');
      
      $this->email->initialize($this->global_models->email_conf());
      $this->email->from("no-reply@antavaya.com", "System TMS");
      $this->email->to($pst['email']);
      $this->email->bcc('nugroho.budi@antavaya.com');

      $this->email->subject("[TMS] Itin {$detail_array->tour->title}");
      $this->email->message("
        Dear {$pst['name']} <br />
        Berikut merupakan link untuk PDF Itin {$detail_array->tour->title}.<br /><br />

        <a href='{$detail_array->tour->file_itin}'>{$detail_array->tour->title}</a>
        <br /><br />

        Terima Kasih <br />
        {$users_book[0]->name}<br />
        {$this->session->userdata("id")}
        ");

      $this->email->send();
      
      redirect("store/print-store/tour-schedule/{$tour_code}/{$code}");
    }
    
//    $this->debug($detail_array, true);
    $data = array(
      'title'     => $detail_array->tour->title,
      'kedua'     => $detail_array->tour->days." Hari / {$detail_array->tour->night} Malam - {$detail_array->tour->airlines}",
      'ketiga'    => $detail_array->tour->destination,
      'keempat'   => $detail_array->tour->landmark,
      'body'      => $detail_array->tour->text,
      'info'      => $detail_array->tour->information,
      'pdf'       => $detail_array->tour->file_itin,
      'kode'      => $code,
    );
    $this->load->view('print/detail-tour', $data);
  }
  
  function price_detail($book_code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
    
    $id_users = $this->global_models->get_field("m_users", "id_users", array("email" => $detail_array->book->own_user));
//    $this->debug($this->session->all_userdata(), true);
    $post_store = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_users"        => $id_users,
    );
    $detail_store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($detail_store);
//    $this->debug($store_array, true);
    $data = array(
      'book_code'     => $book_code,
      'tour'          => $detail_array->tour,
      'book'          => $detail_array->book,
      'payment'       => $detail_array->payment,
      'store'         => $store_array->data[0],
    );
    $this->load->view('print/price-detail', $data);
  }
  
  function ttu($id){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $id,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-get-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail);
//    $this->debug($detail_array, true);
    $id_users = $this->global_models->get_field("m_users", "id_users", array("email" => $detail_array->book->own_user));
//    $this->debug($this->session->all_userdata(), true);
    $post_store = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_users"        => $id_users,
    );
    $detail_store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($detail_store);
//    $this->debug($detail_array, true);
    $data = array(
      'book_code'     => $book_code,
      'payment'       => $detail_array->data->payment,
      'all'           => $detail_array->data->all,
      'pax'           => $detail_array->data->pax,
      'store'         => $store_array->data[0],
    );
    $this->load->view('print/ttu', $data);
  }
  
  function ttu_kwitansi($id,$type){
    
    if($type == 2){
        $view_kwitansi = 'print/ttu-kwitansi-2';
    }else{
        $view_kwitansi = 'print/ttu-kwitansi';
    }  
    
//    $this->debug($this->global_variable->hitung_terbilang_ratusan("10"), true);
//    $this->debug($this->global_variable->terbilang("900,090,000"), TRUE);
    
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $id,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/tour-payment-get-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail);
//    $this->debug($detail_array, true);
    $id_users = $this->global_models->get_field("m_users", "id_users", array("email" => $detail_array->book->own_user));
//    $this->debug($this->session->all_userdata(), true);
    $post_store = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_users"        => $id_users,
    );
    $detail_store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($detail_store);
//    $this->debug($detail_array, true);
    $pax = explode("|", $detail_array->data->payment[0]->book);
    $data = array(
      'book_code'     => $book_code,
      'payment'       => $detail_array->data->payment_list,
      'all'           => $detail_array->data->all,
      'pax'           => $detail_array->data->ttu[0],
      'pax1'          => $pax,
      'store'         => $store_array->data[0],
      'ttu'           => $detail_array->data->payment[0],
    );
    $this->load->view($view_kwitansi, $data);
  }
  
  function ttu_indie($id){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id"              => $id,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/ttu-get-detail");
    $detail_array = json_decode($detail);
//    $this->debug($detail, true);
//    $this->debug($detail_array, true);
//    $id_users = $this->global_models->get_field("m_users", "id_users", array("email" => $detail_array->data[0]->id_users));
//    $this->debug($this->session->all_userdata(), true);
    $post_store = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "id_users"        => $detail_array->data[0]->id_users,
    );
//	$this->debug($post_store, true);
    $detail_store = $this->global_variable->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");
    $store_array = json_decode($detail_store);
//    $this->debug($store_array, true);
    $inventory = explode("|", $detail_array->data[0]->inventory);
    $payment = explode("|", $detail_array->data[0]->payment);
    $data = array(
      'book_code'     => $inventory,
      'payment'       => $detail_array->payment,
      'data'          => $detail_array->data[0],
      'store'         => $store_array->data[0],
    );
    $this->load->view('print/ttu-indie', $data);
  }
  
  function customer_detail($book_code){
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
    );
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
//    $this->debug($detail_array, true);
    $data = array(
      'book_code'     => $book_code,
      'tour'          => $detail_array->tour,
      'book'          => $detail_array->book,
      'payment'       => $detail_array->payment,
    );
    $this->load->view('print/customer-detail', $data);
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */