<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Store extends MX_Controller {
    
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
  
  function book(){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $this->input->post("start_date"),
      "end"         => $this->input->post("end_date"),
      "code"        => $this->input->post("code"),
      "title"       => $this->input->post("title"),
      "status"      => $this->input->post("status"),
      "id_users"    => $this->session->userdata("id"),
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book-list-store");  
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
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
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name/Email/Telphone</label><br>"
            . "{$this->form_eksternal->form_input('title', $pst['title'], ' class="form-control input-sm" placeholder="Name/Email/Telphone"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('code', $pst['code'], ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $pst['start_date'], 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $pst['end_date'], 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('book', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/book",
          'data'          => $data_array->book,
          'title'         => lang("Manage Store Book"),
          'foot'          => $foot,
          'css'           => $css,
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout("datatables")
      ->build('book');
  }
  
  function report_penjualan(){
    
       $serach_data = $this->input->post(NULL);
     
     if($serach_data["start_date_report_penjualan"] OR $serach_data["end_date_report_penjualan"]){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $serach_data["start_date_report_penjualan"],
        "end_date"        => $serach_data["end_date_report_penjualan"],
        "id_users"        => $this->session->userdata("id"),
        );

     }else{
       $serach_data["start_date_report_penjualan"] = date("Y-m-01");
       $serach_data["end_date_report_penjualan"] = date("Y-m-t");
        $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"    => date("Y-m-01"),
        "end_date"      => date("Y-m-t"),
        "id_users"      => $this->session->userdata("id"),
        );
     }
     
     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/report-penjualan");  
    $data_array = json_decode($data);

    
    $css = "<script src='".base_url()."themes/".DEFAULTTHEMES."/js/jquery1.10.2.min.js' type='text/javascript'></script>";
    $foot = "
        <link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />
       
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
    
 
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date_report_penjualan', $serach_data['start_date_report_penjualan'], 'id="start_date" class="form-control input-sm" placeholder="Start Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date_report_penjualan', $serach_data['end_date_report_penjualan'], 'id="end_date" class="form-control input-sm" placeholder="End Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
//               ."<div class='box-body col-sm-6' style='padding-left:2%'>"
//          . "<div class='control-group'>"
//            . "<input name='export' class='btn btn-primary' value='Export XLS' type='submit'></input>"
//          . "</div>"
//        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('report-penjualan', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "grouptour/product-tour/report-payment",
          'data'          => $data_array,
          'title'         => lang("Report Penjualan"),
          'category'      => $category,
          'sub_category'  => $sub_category,
          'foot'          => $foot,
          'css'           => $css,
          'tableboxy'     => 'tableboxydesc',
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout("datatables")
      ->build('report-penjualan');
  }
  
   function payment_void(){
    $pst = $_POST;
//    print_r($pst);
//    die;
    
    if($pst['note_cancel']){
      $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $pst['book_code'],
      "id_payment"  => $pst['id_payment'],     
      "note"        => $pst['note_cancel'],
      "id_users"    => $this->session->userdata("id"),
    );
      
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/payment-void");
    $data_array = json_decode($data);
    
//    $post2 = array(
//      "users"       => USERSSERVER,
//      "password"    => PASSSERVER,
//      "id_book"     => $data_array->id_book,
//    );
//    print $data_array->id_book;
//    $this->curl_mentah($post2, URLSERVER."json/json-inventory/update-sort-book");  
//   die;
    if($data_array->status == 2){
      $this->session->set_flashdata('success', 'Void Berhasil');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal Void');
    }

   }else{
       $this->session->set_flashdata('notice', 'Note Void Harus di isi');
   }
   redirect("grouptour/product-tour/book-information/{$pst['book_code']}");
  }
  
  function cancel_book($id,$code){
  
    $pst = $_POST;
    
    if($pst['note_cancel']){
      $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $pst['book_code'],
      "note"        => $pst['note_cancel'],
      "id_users"    => $this->session->userdata("id"),
    );
      
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/cancel-book");  
    $data_array = json_decode($data);

    if($data_array->status == 4){
       $post2 = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $pst['book_code'],
      "note"        => $pst['note_cancel'],   
      "url"        => base_url()."store/list-all-customer-cancel",
      "info_cancel" => "1",   
      "id_users"    => $this->session->userdata("id"),
    );
    $this->curl_mentah($post2, URLSERVER."json/json-mail/info-cancel-approval");
    
      $this->session->set_flashdata('success', 'Cancel Menunggu persetujuan dari Approval. Terdapat Deposit Sebesar <br /> '.number_format($data_array->deposit));
    }
    elseif($data_array->status == 2){
      $this->session->set_flashdata('success', 'Cancel Book Berhasil');
    }
    else{
      $this->session->set_flashdata('notice', $data_array->note);
    }
   
    }else{
        $this->session->set_flashdata('notice', 'Note Cancel Tidak Boleh Kosong');
    }
      if($id == 1){
        redirect("grouptour/product-tour/book-list");
    }elseif($id == 2){
        redirect("/tour/monitoring-book");
    }
    
  }
  
  function cancel_book_information($book_code,$customer_code){
    
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

    
    $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $book_code,
      "committed"       => $pst["committed_book"],
      "dt_users"        => $this->session->userdata("id")
    );
    
    $detail = $this->global_variable->curl_mentah($post, URLSERVER."json/json-midlle-system/get-tour-book");
    $detail_array = json_decode($detail);
    
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
		
    $foot = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/datepicker/datepicker3.css' rel='stylesheet' type='text/css' />";
    
    $foot .= "<script type='text/javascript'>"
      . "$(document).on('click', '#print-price-detail', function(evt){"
        . "window.open('".site_url("store/print-store/price-detail/{$book_code}")."', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=0, left=0, width=1000, height=600');"
      . "});"
          
      . "$(document).on('click', '.edit-deposit', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#id_payment').val(id);"
      . "});"
          
      . "$(document).on('click', '#id-customer-cancel', function(evt){"
        . "var id = $(this).attr('isi');"
        . "$('#dt_id_customer_book').val(id);"
      . "});"
          
    
	
	. "$(document).on('click', '#req-discount', function(evt){"
        . "$.post('".site_url("grouptour/product-tour/post-req-discount")."', {note: $('#note-req-disk').val(),status_user: $('#usr-status2').val(),own_tc: '{$detail_array->book->own_user}',user_approval: '{$eml_adl}',name_user: '{$nm_usr}', nominal: $('#nominal-req-disk').val(), code: '{$book_code}'},function(data){"
        . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
        . "});"
      . "});"
          
    
	 . "$(document).on('click', '#req-approved', function(evt){"
        . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 2,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
          . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
        . "});"
      . "});"
          
    
	 . "$(document).on('click', '#req-rejected', function(evt){"
        . "$.post('".site_url("grouptour/product-tour/req-discount-approved")."', {id: $(this).attr('isi'), status: 3,own_tc: '{$detail_array->book->own_user}', code: '{$book_code}'},function(data){"
          . "window.location = '".site_url('grouptour/product-tour/book-information/'.$book_code)."';"
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
   
    
    $post_discount = array(
      "users"                     => USERSSERVER,
      "password"                  => PASSSERVER,
      "code"                      => $book_code,
    );

    $get_discount = $this->global_variable->curl_mentah($post_discount, URLSERVER."json/json-tour/get-discount");
    $get_discount_array = json_decode($get_discount);

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
	
    $this->template->build('store/cancel-book-information', 
      array(
            'url'         => base_url()."themes/".DEFAULTTHEMES."/",
            'menu'        => "grouptour/product-tour",
            'data'        => $detail_array,
            'add_req2'    => $arr_additional,
            'approval_array'       => $approval_array->data,
            'discount'    => $get_discount_array->data,
        
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
      ->build('store/cancel-book-information');
  }
  
  public function move_bookers($code){
    if(!$this->input->post(NULL)){
      $post_store = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
      );
      $data_store = $this->curl_mentah($post_store, URLSERVER."json/json-midlle-system/get-all-store");  
      $data_store_array = json_decode($data_store);
      foreach($data_store_array->data AS $dsa){
        $store[$dsa->id_store] = $dsa->title;
      }
      
      $post_users = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
        "id_store"    => $data_store_array->data[0]->id_store,
      );
      $data_users = $this->curl_mentah($post_users, URLSERVER."json/json-midlle-system/get-users-store");  
      $data_users_array = json_decode($data_users);
//      $this->debug($data_users_array, true);
      $users_select = '<select name="id_users" class="form-control users">';
      foreach($data_users_array->data AS $dua){
        $users_select .= '<option value="'.$dua->isi->id_users.'">'.$dua->isi->name.'</option>';
        $users[$dua->isi->id_users] = $dua->isi->name;
      }
      $users_select .= "</select>";
      
      $css = "<link href='".base_url()."themes/".DEFAULTTHEMES."/css/select2.css' type='text/css' rel='stylesheet'>";
      $foot .= "<script type='text/javascript' src='".base_url()."themes/".DEFAULTTHEMES."/js/select2.js'></script>"
        ."<script type='text/javascript'>"
        . "$('.users').select2();"
        . "$('#users-view').html('".$users_select."');"
        . "$('#id-store').change(function(){"
          . "$.post('".site_url("store/get-users-store")."', {id_store: $(this).val()}, function(hasil){"
            . "$('#users-view').html(hasil);"
          . "});"
        . "});"
        . "</script> ";
      
      $this->template->build("move-bookers", 
        array(
              'url'         => base_url()."themes/".DEFAULTTHEMES."/",
              'menu'        => 'store/book',
              'title'       => lang("Move Bookers"),
              'breadcrumb'  => array(
                    "Manage Store Book"  => "store/book"
                ),
              'css'         => $css,
              'foot'        => $foot,
              'store'       => $store,
              'users'       => $users,
              'code'        => $code
            ));
      $this->template
        ->set_layout('form')
        ->build("move-bookers");
    }
    else{
      $pst = $this->input->post(NULL);
      
      $post = array(
        "users"       => USERSSERVER,
        "password"    => PASSSERVER,
        "code"        => $this->input->post("code"),
        "id_users"    => $this->input->post("id_users"),
      );
      $data = $this->curl_mentah($post, URLSERVER."json/json-midlle-system/set-move-bookers");  
      $data_array = json_decode($data);
//      $this->debug($data, true);
      if($data_array->status == 2){
        $this->session->set_flashdata('success', 'Data tersimpan');
      }
      else{
        $this->session->set_flashdata('notice', 'Data tidak tersimpan');
      }
      redirect("tour/monitoring-book");
    }
  }
  
  function get_users_store(){
    $post_users = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "id_store"    => $this->input->post("id_store"),
    );
    $data_users = $this->curl_mentah($post_users, URLSERVER."json/json-midlle-system/get-users-store");  
    $data_users_array = json_decode($data_users);
//      $this->debug($data_users_array, true);
    $users_select = '<select name="id_users" class="form-control users">';
    foreach($data_users_array->data AS $dua){
      $users_select .= '<option value="'.$dua->isi->id_users.'">'.$dua->isi->name.'</option>';
      $users[$dua->isi->id_users] = $dua->isi->name;
    }
    $users_select .= "</select>";
    print $users_select;die;
  }
  
  function cek_finance(){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "start"       => $this->input->post("start_date"),
      "end"         => $this->input->post("end_date"),
      "code"        => $this->input->post("code"),
      "status"      => $this->input->post("status"),
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/get-payment-book");  
    $data_array = json_decode($data);
//    $this->debug($data_array, true);
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
              
          $(document).on('click', '.tolak-payment', function(evt){
            var code = $(this).attr('isi');
            $('#code-payment').val(code);
          });
        </script>";
    
   // print_r($serach_data); die;
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name/Email/Telphone</label><br>"
            . "{$this->form_eksternal->form_input('title', $pst['title'], ' class="form-control input-sm" placeholder="Name/Email/Telphone"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('code', $pst['code'], ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $pst['start_date'], 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $pst['end_date'], 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('payment', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/cek-finance",
          'data'          => $data_array->book,
          'title'         => lang("Manage Finance"),
          'foot'          => $foot,
          'css'           => $css,
          'serach_data'   => $serach_data,
          'serach'        => $serach,
          'before_table'  => $before_table,
        ));
    $this->template
      ->set_layout("datatables")
      ->build('payment');
  }
  
  function finance_accept($code){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $code,
      "id_users"    => $this->session->userdata("id"),
      "status"      => 4,
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/set-finance-payment");  
    $data_array = json_decode($data);
//      $this->debug($data, true);
    if($data_array->status == 2){
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("store/cek-finance");
  }
  
  function finance_reject(){
    $post = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $this->input->post('code_payment'),
      "note"        => $this->input->post('note'),
      "id_users"    => $this->session->userdata("id"),
      "status"      => 3,
    );
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/set-finance-payment");  
    $data_array = json_decode($data);
//      $this->debug($data, true);
    if($data_array->status == 2 OR $data_array->status == 4){
      $this->session->set_flashdata('success', 'Data tersimpan');
    }
    else{
      $this->session->set_flashdata('notice', 'Data tidak tersimpan');
    }
    redirect("store/cek-finance");
  }
  
  function cancel_tour_per_pax($book_code,$customer_code){
    
   $pst = $_POST;
   
   if($pst['note_cancel']){
     $post = array(
      "users"           => USERSSERVER,
      "password"        => PASSSERVER,
      "code"            => $pst['book_code'],
      "pax_code"        => $pst['customer_code'],
      "note_cancel"     => $pst['note_cancel'],
      "id_users"        => $this->session->userdata("id"),
    );
	
    $data = $this->curl_mentah($post, URLSERVER."json/json-tour/cancel-tour-pax");  
    $data_array = json_decode($data);
   // $this->debug($data, true);
    if($data_array->status == 2){
      $this->session->set_flashdata('success', 'Cancel Berhasil');
    }
    elseif($data_array->status == 4){
       $post2 = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"        => $pst['book_code'],
      "note"        => $pst['note_cancel'],
      "info_cancel" => "2",    
      "url"        => base_url()."store/list-pax-customer-cancel",    
      "id_users"    => $this->session->userdata("id"),
    );
    $this->curl_mentah($post2, URLSERVER."json/json-mail/info-cancel-approval");
    
    $this->session->set_flashdata('success', 'Cancel Butuh Persetujuan Dari Approval');
      
    }
    else{
      $this->session->set_flashdata('notice', 'Cancel Gagal');
    }
   }else{
      $this->session->set_flashdata('notice', 'Note Cancel Tidak Boleh Kosong');
   }
   
    
    redirect("grouptour/product-tour/book-information/{$pst['book_code']}");
  }
  
  function list_pax_customer_cancel($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'customer_cancel_pax_start_date'           => $pst['cust_cancel_pax_start_date'],
            'customer_cancel_pax_end_date'             => $pst['cust_cancel_pax_end_date'],
            'customer_cancel_pax_title'                => $pst['cust_cancel_pax_title'],
            'customer_cancel_pax_name'                 => $pst['cust_cancel_pax_name'],
            'customer_cancel_pax_code'                 => $pst['cust_cancel_pax_code'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('customer_cancel_pax_start_date'),
        "end_date"        => $this->session->userdata('customer_cancel_pax_end_date'),
         "title"          => $this->session->userdata('customer_cancel_pax_title'),
        "name"            => $this->session->userdata('customer_cancel_pax_name'),
        "code"            => $this->session->userdata('customer_cancel_pax_code'),
        "limit"           => 10,
        "list_cancel"     => 1,
        "id_users"        => $this->session->userdata("id"),
        );
      
     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-cancel-list");  
    $data_array = json_decode($data);
//    print "<pre>";
//    print 
//    print_r($data_array); 
//    print "</pre>";
//    die;
    $all_total = count($data_array->total);
     $url_list = site_url("store/ajax-list-pax-customer-cancel/".$all_total);
    $url_list_halaman = site_url("store/ajax-halaman-list-all-customer-cancel/".$all_total);
    

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
             
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_pax_title', $this->session->userdata('customer_cancel_pax_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_pax_code', $this->session->userdata('customer_cancel_pax_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [Start]</label>"
            . "{$this->form_eksternal->form_input('cust_cancel_pax_start_date', $this->session->userdata('customer_cancel_pax_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [End]</label>"
            . "{$this->form_eksternal->form_input('cust_cancel_pax_end_date', $this->session->userdata('customer_cancel_pax_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_pax_name', $this->session->userdata('customer_cancel_pax_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
//        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
//          . "<div class='control-group'>"
//            . "<label>Status</label><br>"
//            . "{$this->form_eksternal->form_dropdown('cust_cancel_pax_status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_keseluruhan_status')), ' class="form-control input-sm"')}"
//          . "</div>"
//        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group' style='margin-top: 20%;' >"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('list-customer-cancel', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/list-pax-customer-cancel",
          'data'          => $data_array,
          'title'         => lang("Customer Cancel"),
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
      ->build('list-customer-cancel');
  }
  
  function list_all_customer_cancel($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'customer_cancel_all_start_date'                   => $pst['cust_cancel_all_start_date'],
            'customer_cancel_all_end_date'                      => $pst['cust_cancel_all_end_date'],
            'customer_cancel_all_title'                      => $pst['cust_cancel_all_title'],
            'customer_cancel_all_name'                 => $pst['cust_cancel_all_name'],
            'customer_cancel_all_code'                   => $pst['cust_cancel_all_code'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('customer_cancel_all_start_date'),
        "end_date"        => $this->session->userdata('customer_cancel_all_end_date'),
         "title"          => $this->session->userdata('customer_cancel_all_title'),
        "name"            => $this->session->userdata('customer_cancel_all_name'),
        "code"            => $this->session->userdata('customer_cancel_all_code'),
        "limit"           => 10,
        "list_cancel"     => 2,
        "id_users"        => $this->session->userdata("id"),
        );

     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-cancel-list");  
    $data_array = json_decode($data);
//    print "<pre>";
//    print 
//    print_r($data_array); 
//    print "</pre>";
//    die;
    $all_total = count($data_array->total);
     $url_list = site_url("store/ajax-list-all-customer-cancel/".$all_total);
    $url_list_halaman = site_url("store/ajax-halaman-list-all-customer-cancel/".$all_total);
    

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
             
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_all_title', $this->session->userdata('customer_cancel_all_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_all_code', $this->session->userdata('customer_cancel_all_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [Start]</label>"
            . "{$this->form_eksternal->form_input('cust_cancel_all_start_date', $this->session->userdata('customer_cancel_all_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [End]</label>"
            . "{$this->form_eksternal->form_input('cust_cancel_all_end_date', $this->session->userdata('customer_cancel_all_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_cancel_all_name', $this->session->userdata('customer_cancel_all_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
//        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
//          . "<div class='control-group'>"
//            . "<label>Status</label><br>"
//            . "{$this->form_eksternal->form_dropdown('cust_cancel_all_status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_keseluruhan_status')), ' class="form-control input-sm"')}"
//          . "</div>"
//        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%;'>"
          . "<div class='control-group' style='margin-top: 20%;'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('list-customer-cancel', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/list-all-customer-cancel",
          'data'          => $data_array,
          'title'         => lang("Customer Cancel"),
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
      ->build('list-customer-cancel');
  }
  
  function ajax_list_all_customer_cancel($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
         "start_date"      => $this->session->userdata('customer_cancel_all_start_date'),
        "end_date"        => $this->session->userdata('customer_cancel_all_end_date'),
         "title"          => $this->session->userdata('customer_cancel_all_title'),
        "name"            => $this->session->userdata('customer_cancel_all_name'),
        "code"            => $this->session->userdata('customer_cancel_all_code'),
        "limit"           => 10,
         "list_cancel"     => 2,
        "start"           => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-cancel-list");  
      $data_array = json_decode($data);
//       print "<pre>";
//       print_r($data_array);
//       print "</pre>"; die;
//       
      if($data_array->status == 2){
  
    foreach ($data_array->book as $key => $value) {
      
      
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

                
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Awal</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
   
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
              . "<div style='display: none' id='isiinfo2{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td style='text-align: left'>{$value->note}</td>"
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
           . "$('#info2{$value->code}').tooltipster({"
            . "content: $('#isiinfo2{$value->code}').html(),"
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
      $link_approval = site_url("store/status-list-customer-cancel/2/1/".$value->code);
      $link_reject   = site_url("store/status-list-customer-cancel/2/2/".$value->code);
     if($value->status->flag == 1){
        if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "cancel-approval", "edit") !== FALSE){     
            $dt_status = "<td><a href='{$link_approval}' class='btn btn-primary'>Approve</a> <a href='{$link_reject}' class='btn btn-danger'>Reject</a></td>";
          }else{
               $dt_status ="<td></td>";
          }
     }else{
       $dt_status ="<td></td>";
     }
     
     $show .= "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->tour}</td>"
        . "<td><a href='javascript:void(0)' id='info2{$value->code}'>{$tc}</a></td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$value->status->status_customer}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan )),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . $dt_status   
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("store/cancel-book-information/".$value->code)."'>Detail</a></li>"
        . "</td>"
      . "</tr>";
    }
    print $show; die;
  }
    
    die;
  }
  
  function ajax_list_pax_customer_cancel($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('customer_cancel_pax_start_date'),
        "end_date"        => $this->session->userdata('customer_cancel_pax_end_date'),
         "title"          => $this->session->userdata('customer_cancel_pax_title'),
        "name"            => $this->session->userdata('customer_cancel_pax_name'),
        "code"            => $this->session->userdata('customer_cancel_pax_code'),
        "limit"           => 10,
        "list_cancel"     => 1,
        "start"           => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-cancel-list");  
      $data_array = json_decode($data);
//       print "<pre>";
//       print_r($data_array);
//       print "</pre>"; die;
//       
      if($data_array->status == 2){
  
    foreach ($data_array->book as $key => $value) {
      
      
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

                
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Awal</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
   
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
              . "<div style='display: none' id='isiinfo2{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td style='text-align: left'>{$value->note}</td>"
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
           . "$('#info2{$value->code}').tooltipster({"
            . "content: $('#isiinfo2{$value->code}').html(),"
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
      $link_approval = site_url("store/status-list-customer-cancel/1/1/".$value->code);
      $link_reject   = site_url("store/status-list-customer-cancel/1/2/".$value->code);
     if($value->status->flag == 1){
       if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "cancel-approval", "edit") !== FALSE){     
            $dt_status = "<td><a href='{$link_approval}' class='btn btn-primary'>Approve</a> <a href='{$link_reject}' class='btn btn-danger'>Reject</a></td>";
          }else{
               $dt_status ="<td></td>";
          }
     }else{
       $dt_status ="<td></td>";
     }
     
     $show .= "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->tour}</td>"
        . "<td><a href='javascript:void(0)' id='info2{$value->code}'>{$tc}</a></td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$value->status->status_customer}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan )),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . $dt_status   
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("store/cancel-book-information/".$value->code)."'>Detail</a></li>"
        . "</td>"
      . "</tr>";
    }
    print $show; die;
  }
    
    die;
  }
  
   function status_list_customer_cancel($list_cancel,$status_customer,$kode_book){
    $status = "";
    if($status_customer == 1){
      $status = $status_customer;
      $ket = "Approve";
    }elseif($status_customer == 2){
      $status = $status_customer;
      $ket = "Reject";
    }
    
    if($list_cancel == 1){
      $link = "store/list-pax-customer-cancel";
      // flag untuk cancel pax
      $flag = 1; 
    }elseif($list_cancel == 2){
      //flag untuk cancel book
      $flag = 2; 
      $link = "store/list-all-customer-cancel";
    }
   
    
    if($status){
      $kirim = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $kode_book,
          "status"                    => $status,
		  "flag"                      => $flag,
        );
      
        $data = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/status-customer-cancel");
        $data_array = json_decode($data);
        
    }
   
    if($data_array->status == 2){
      
       $post2 = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"         => $kode_book,
      "status"       => $status,
      "id_users"    => $this->session->userdata("id"),
    );
    $data2 = $this->curl_mentah($post2, URLSERVER."json/json-mail/cancel-book-reject");
    
    $this->session->set_flashdata('success', 'Cancel Di Batalkan Approval');
      }elseif($data_array->status == 4){
         
     $post5 = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"         => $kode_book,
      "status"       => $status,
       "note"       => $data_array->keterangan,
      "id_users"    => $this->session->userdata("id"),
    );
    $data2 = $this->curl_mentah($post5, URLSERVER."json/json-mail/cancel-book-approve");
        
        $this->session->set_flashdata('success', 'Cancel Deposit di Setujui Approval <br />Jika terdapat biaya pembatalan, akan diputuskan oleh operasional');
      }else{
        $this->session->set_flashdata('notice', 'Cancel Gagal');
      }
     
      redirect($link);
        
  }
  
  function ajax_halaman_list_all_customer_cancel($total = 0, $start = 0){
    
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
  
    function edit_book_pax(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $post = array(
      "users"                 => USERSSERVER,
      "password"              => PASSSERVER,
      "id_users"              => $this->session->userdata("id"),
      "code"                  => $pst['code'],
      "book_code"             => $pst['book_code'],
      "first_name"            => $pst['first_name'],
      "last_name"             => $pst['last_name'],
      "tanggal_lahir"         => $pst['tanggal_lahir'],
      "tempat_lahir"          => $pst['tempat_lahir'],
      "type"                  => $pst['type'],
      "room"                  => $pst['room'],
      "visa"                  => $pst['visa'],
      "less_ticket"           => $pst['less_ticket'],
      "passport"              => $pst['passport'],
      "place_of_issued"       => $pst['place_of_issued'],
      "date_of_issued"        => $pst['date_of_issued'],
      "date_of_expired"       => $pst['date_of_expired'],
      "telp"                  => $pst['telp'],
      "note"                  => $pst['note'],
    );
    
    $pax = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/update-pax-book");
    $pax_array = json_decode($pax);
//    $this->debug($pax, true);
    if($pax_array->status == 2){
      $this->session->set_flashdata('success', 'Update Customer Berhasil');
    }
    elseif($pax_array->status == 4){
      $this->session->set_flashdata('success', 'Update Customer Berhasil. <br />Terdapat Perubahan Biaya');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal');
    }
    redirect("grouptour/product-tour/book-information/{$pst['book_code']}");
  }
  
  function edit_contact_person(){
    $pst = $this->input->post();
//    $this->debug($pst, true);
    $post = array(
      "users"                 => USERSSERVER,
      "password"              => PASSSERVER,
      "id_users"              => $this->session->userdata("id"),
      "book_code"             => $pst['ebook_code'],
      "first_name"            => $pst['efirst_name'],
      "last_name"             => $pst['elast_name'],
      "email"                 => $pst['e_email'],
      "telp"                  => $pst['etelp'],
      "eaddress"              => $pst['eaddress'],
    );
    
    $pax = $this->global_variable->curl_mentah($post, URLSERVER."json/json-tour/update-contact-person");
    $pax_array = json_decode($pax);
//    $this->debug($pax, true);
    if($pax_array->status == 2){
      $this->session->set_flashdata('success', 'Update Contact Berhasil');
    }
    elseif($pax_array->status == 3){
      $this->session->set_flashdata('notice', 'gagal update contact');
    }
    else{
      $this->session->set_flashdata('notice', 'Gagal');
    }
    redirect("grouptour/product-tour/book-information/{$pst['ebook_code']}");
  }
  
   function list_customer_change_book($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'customer_change_book_start_date'             => $pst['cust_change_book_start_date'],
            'customer_change_book_end_date'               => $pst['cust_change_book_end_date'],
            'customer_change_book_title'                  => $pst['cust_change_book_title'],
            'customer_change_book_name'                   => $pst['cust_change_book_name'],
            'customer_change_book_code'                   => $pst['cust_change_book_code'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('customer_change_book_start_date'),
        "end_date"        => $this->session->userdata('customer_change_book_end_date'),
         "title"          => $this->session->userdata('customer_change_book_title'),
        "name"            => $this->session->userdata('customer_change_book_name'),
        "code"            => $this->session->userdata('customer_change_book_code'),
        "limit"           => 10,
        "list_change"     => 1,
        "id_users"        => $this->session->userdata("id"),
        );

     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-change-list");  
    $data_array = json_decode($data);
//    print "<pre>";
//    print_r($data_array); 
//    print "</pre>";
//    die;
    $all_total = count($data_array->total);
     $url_list = site_url("store/ajax-list-customer-change-book/".$all_total);
    $url_list_halaman = site_url("store/ajax-halaman-list-customer-change-book/".$all_total);
    

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
             
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_title', $this->session->userdata('customer_change_book_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_code', $this->session->userdata('customer_change_book_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [Start]</label>"
            . "{$this->form_eksternal->form_input('cust_change_book_start_date', $this->session->userdata('customer_change_book_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [End]</label>"
            . "{$this->form_eksternal->form_input('cust_change_book_end_date', $this->session->userdata('customer_change_book_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_name', $this->session->userdata('customer_change_book_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
//        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
//          . "<div class='control-group'>"
//            . "<label>Status</label><br>"
//            . "{$this->form_eksternal->form_dropdown('cust_cancel_all_status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_keseluruhan_status')), ' class="form-control input-sm"')}"
//          . "</div>"
//        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%;'>"
          . "<div class='control-group' style='margin-top: 20%;'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('list-customer-change-tour', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/list-customer-change-book",
          'data'          => $data_array,
          'title'         => lang("Customer Change Tour"),
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
      ->build('list-customer-change-tour');
  }
  
  function ajax_list_customer_change_book($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
         "start_date"      => $this->session->userdata('customer_change_book_start_date'),
        "end_date"        => $this->session->userdata('customer_change_book_end_date'),
         "title"          => $this->session->userdata('customer_change_book_title'),
        "name"            => $this->session->userdata('customer_change_book_name'),
        "code"            => $this->session->userdata('customer_change_book_code'),
        "limit"           => 10,
         "list_change"     => 1,
        "start"           => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-change-list");  
      $data_array = json_decode($data);
//       print "<pre>";
//       print_r($data_array->note);
//       print "</pre>"; die;
//       
      if($data_array->status == 2){
  
    foreach ($data_array->book as $key => $value) {
      
      
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

                
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Awal</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
   
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
              . "<div style='display: none' id='isiinfo2{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td style='text-align: left'>{$value->note}</td>"
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
           . "$('#info2{$value->code}').tooltipster({"
            . "content: $('#isiinfo2{$value->code}').html(),"
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
      $link_approval = site_url("store/status-list-customer-change/1/1/".$value->code);
      $link_reject   = site_url("store/status-list-customer-change/1/2/".$value->code);
     if($value->status->flag == 1){
        if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "change-approval", "edit") !== FALSE){     
            $dt_status = "<td><a href='{$link_approval}' class='btn btn-primary'>Approve</a> <a href='{$link_reject}' class='btn btn-danger'>Reject</a></td>";
          }else{
               $dt_status ="<td></td>";
          }
     }else{
       $dt_status ="<td></td>";
     }
     
     $show .= "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->tour}</td>"
        . "<td><a href='javascript:void(0)' id='info2{$value->code}'>{$tc}</a></td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$value->status->status_customer}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan )),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . $dt_status   
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("store/cancel-book-information/".$value->code)."'>Detail</a></li>"
        . "</td>"
      . "</tr>";
    }
    print $show; die;
  }
    
    die;
  }
  
  function ajax_list_customer_change_pax($total = 0, $start = 0){
    
      $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
         "start_date"      => $this->session->userdata('customer_change_book_start_date'),
        "end_date"        => $this->session->userdata('cust_change_book_end_date'),
         "title"          => $this->session->userdata('cust_change_book_title'),
        "name"            => $this->session->userdata('cust_change_book_name'),
        "code"            => $this->session->userdata('cust_change_book_code'),
        "limit"           => 10,
         "list_change"     => 2,
        "start"           => $start,
        "id_users"        => $this->session->userdata("id"),
        );

      $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-change-list");  
      $data_array = json_decode($data);
//       print "<pre>";
//       print_r($data_array->note);
//       print "</pre>"; die;
//       
      if($data_array->status == 2){
  
    foreach ($data_array->book as $key => $value) {
      
      
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

                
      $detail_beban = ""
      . "<div style='display: none' id='isi{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td>Beban Awal</td>"
            . "<td style='text-align: left'>".number_format($value->beban,0,".",",")."</td>"
          . "</tr>";
   
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
              . "<div style='display: none' id='isiinfo2{$value->code}'>"
        . "<table width='100%'>"
          . "<tr>"
            . "<td style='text-align: left'>{$value->note}</td>"
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
           . "$('#info2{$value->code}').tooltipster({"
            . "content: $('#isiinfo2{$value->code}').html(),"
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
      $link_approval = site_url("store/status-list-customer-change/2/1/".$value->code);
      $link_reject   = site_url("store/status-list-customer-change/2/2/".$value->code);
     
     if($value->status->flag == 1){
        if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "cancel-approval", "edit") !== FALSE){     
            $dt_status = "<td><a href='{$link_approval}' class='btn btn-primary'>Approve</a> <a href='{$link_reject}' class='btn btn-danger'>Reject</a></td>";
          }else{
               $dt_status ="<td></td>";
          }
     }else{
       $dt_status ="<td></td>";
     }
     
     $show .= "<tr>"
        . "<td>{$value->tanggal}</td>"
        . "<td>{$value->tour}</td>"
        . "<td><a href='javascript:void(0)' id='info2{$value->code}'>{$tc}</a></td>"
        . "<td><a href='javascript:void(0)' id='info{$value->code}'>{$value->code}</a></td>"
        . "<td><a href='javascript:void(0)' id='info1{$value->code}'>{$value->first_name} {$value->last_name}</a></td>"
        . "<td>{$value->status->status_customer}</td>"
        . "<td style='text-align: right; font-weight: bold;'>"
          . "<a href='javascript:void(0)' id='{$value->code}'>".number_format((($value->beban) - ($value->pembayaran + $value->potongan )),2,".",",")."</a>"
          . $detail_beban
        . "</td>"
        . $dt_status   
        . "<td>"
          . "<div class='btn-group'>"
          . "<button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>"
          . "<ul class='dropdown-menu'>"
            . "<li><a href='".site_url("store/cancel-book-information/".$value->code)."'>Detail</a></li>"
        . "</td>"
      . "</tr>";
    }
    print $show; die;
  }
    
    die;
  }
  
  function list_customer_change_pax($code_tour_information){
     
      $pst = $this->input->post(NULL);
      
       if($pst){
    
        $newdata = array(
            'customer_change_book_start_date'             => $pst['cust_change_book_start_date'],
            'customer_change_book_end_date'               => $pst['cust_change_book_end_date'],
            'customer_change_book_title'                  => $pst['cust_change_book_title'],
            'customer_change_book_name'                   => $pst['cust_change_book_name'],
            'customer_change_book_code'                   => $pst['cust_change_book_code'],
          );
          $this->session->set_userdata($newdata);
    }
    
//     if($serach_data){
       $data = array(
        "users"           => USERSSERVER,
        "password"        => PASSSERVER,
        "start_date"      => $this->session->userdata('customer_change_book_start_date'),
        "end_date"        => $this->session->userdata('customer_change_book_end_date'),
         "title"          => $this->session->userdata('customer_change_book_title'),
        "name"            => $this->session->userdata('customer_change_book_name'),
        "code"            => $this->session->userdata('customer_change_book_code'),
        "limit"           => 10,
        "list_change"     => 2,
        "id_users"        => $this->session->userdata("id"),
        );

     
    $data = $this->curl_mentah($data, URLSERVER."json/json-midlle-system/get-customer-change-list");  
    $data_array = json_decode($data);

    $all_total = count($data_array->total);
     $url_list = site_url("store/ajax-list-customer-change-pax/".$all_total);
    $url_list_halaman = site_url("store/ajax-halaman-list-customer-change-book/".$all_total);
    

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
             
    
    $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tour Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_title', $this->session->userdata('customer_change_book_title'), ' class="form-control input-sm" placeholder="Tour Name"')}"
          . "</div>"
        . "</div>"
               . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Code</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_code', $this->session->userdata('customer_change_book_code'), ' class="form-control input-sm" placeholder="Code"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [Start]</label>"
            . "{$this->form_eksternal->form_input('cust_change_book_start_date', $this->session->userdata('customer_change_book_start_date'), 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Tanggal Book [End]</label>"
            . "{$this->form_eksternal->form_input('cust_change_book_end_date', $this->session->userdata('customer_change_book_end_date'), 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name</label><br>"
            . "{$this->form_eksternal->form_input('cust_change_book_name', $this->session->userdata('customer_change_book_name'), ' class="form-control input-sm" placeholder="Name"')}"
          . "</div>"
        . "</div>"
//        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
//          . "<div class='control-group'>"
//            . "<label>Status</label><br>"
//            . "{$this->form_eksternal->form_dropdown('cust_cancel_all_status', array(NULL => '- Pilih -', 1 => "Book", 2 => "Deposit", 3 => "Lunas", 100 => "Deposit & Lunas", 4 => "Cancel", 5 => "Cancel Deposit"), array($this->session->userdata('book_list_keseluruhan_status')), ' class="form-control input-sm"')}"
//          . "</div>"
//        . "</div>"
        . "<div class='box-body col-sm-6' style='padding-left:2%;'>"
          . "<div class='control-group' style='margin-top: 20%;'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
      . "</form>"
    . "</div>";
    
    $this->template->build('list-customer-cancel', 
      array(
          'url'           => base_url()."themes/".DEFAULTTHEMES."/",
          'url_image'     => base_url()."themes/antavaya/",
          'menu'          => "store/list-all-customer-cancel",
          'data'          => $data_array,
          'title'         => lang("Customer Cancel"),
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
      ->build('list-customer-cancel');
  }
  
  function ajax_halaman_list_customer_change_book($total = 0, $start = 0){
    
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
  
  function status_list_customer_change($list_change,$status_customer,$kode_book){
    $status = "";
    if($status_customer == 1){
      $status = $status_customer;
      $ket = "Approve";
    }elseif($status_customer == 2){
      $status = $status_customer;
      $ket = "Reject";
    }
    
    if($list_change == 1){
     
      $link = "store/list-customer-change-book";
      // flag untuk cancel pax
      $flag = 1; 
       $kirim = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $kode_book,
          "status"                    => $status,
          "flag"                      => $flag,
        );
     
        $data = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/status-customer-change-book");
        $data_array = json_decode($data);
//          print "<pre>";
//        print_r($data);
//        print "</pre>"; die;
    }elseif($list_change == 2){
     
      //flag untuk cancel book
      $flag = 2; 
      $link = "store/list-customer-change-pax";
       $kirim = array(
          "users"                     => USERSSERVER,
          "password"                  => PASSSERVER,
          "id_users"                  => $this->session->userdata("id"),
          "code"                      => $kode_book,
          "status"                    => $status,
          "flag"                      => $flag,
        );
    
        $data = $this->global_variable->curl_mentah($kirim, URLSERVER."json/json-midlle-system/status-customer-change-pax");
        $data_array = json_decode($data);
//        print "<pre>";
//        print_r($data);
//        print "</pre>"; die;
    }
    
   
    if($data_array->status == 2){
      
       $post2 = array(
      "users"       => USERSSERVER,
      "password"    => PASSSERVER,
      "code"         => $kode_book,
      "status"       => $status,
      "new_code"    =>  $data_array->kode,     
      "id_users"    => $this->session->userdata("id"),
    );
     
    $data2 = $this->curl_mentah($post2, URLSERVER."json/json-mail/change-tour-reject");
    
    $this->session->set_flashdata('success', 'Change Tour Di Batalkan Approval');
      }elseif($data_array->status == 4){
         
     
        $this->session->set_flashdata('success', 'Change di Setujui Approval');
      }else{
        $this->session->set_flashdata('notice', 'Cancel Gagal');
      }
     
      redirect($link);
        
  }
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */