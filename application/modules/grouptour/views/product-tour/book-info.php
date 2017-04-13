<?php print $this->form_eksternal->form_open("grouptour/product-tour/send-passenger", 'id=form2 role="form"', 
                    array(
                      "tour_code"                       => $pst['tour_code'],
                      "tour_information_code"           => $pst['tour_information_code'],
                      "discount"                        => $pst['discount'],
                      "status_discount"                 => $pst['status_discount'],
                      "name_additional"                 => $pst['name_additional'],
                      "nominal_additional"              => $pst['nominal_additional'],
                      "dp"                              => $pst['dp'],
                      "status_dp"                       => $pst['status_dp'],
                      "type_add"                        => $pst['type_add'],
                      "note_additional"                 => $pst['note_additional'],
                      "note_discount_request"           => $pst['note_discount'],
                      "discount_request"                => $pst['discount_request'],
                      "stnb_discount_req"               => $pst['stnb_discount_req'],
                      "batas_discount_tambahan"         => $pst['discount_tambahan'],
                      "currency"                        => $pst['currency'],
                      "total_price"                     => $pst['total_price'],
                      "visa"                            => $pst['visa'],
                    ))?>

<?php

//print "<pre>";
//print_r($pst);
//print "</pre>";
//print "<pre>";
//// print_r($this->session->all_userdata()); 
//print "</pre>"; 
//die; 
?>
<div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#info_pemesan" data-toggle="tab">Contact Person</a></li>
                                   <?php
                                   
            if($this->session->userdata('jml_room')){
            for($r = 1 ; $r <= $this->session->userdata('jml_room'); $r++){
     ?>
                                    <li><a href="#room_<?php echo $r; ?>" data-toggle="tab">Room  <?php echo $r; ?></a></li>
                                    <?php }} ?>
                                    <?php if($_POST['discount_request'] > $_POST['discount_tambahan']){?>
                                    <li><a href="#req_discont" data-toggle="tab">Discount Request</a></li>
                                    <?php } ?>
                                    <?php if($pst['type_add'][0] > 0){?>
                                    <li><a href="#additional" data-toggle="tab">Additional</a></li>
                                    <?php } ?>
                                     <li><a href="#price" data-toggle="tab">Price Detail</a></li>
                                </ul>
  <div class="tab-content">
          <div class="tab-pane active" id="info_pemesan">
      <div class="control-group">
        <label>Pameran</label>
        <?php print $this->form_eksternal->form_dropdown('id_tour_pameran', $pameran, array($this->session->userdata("id_tour_pameran")), 'id="pameran" class="form-control input-sm"');?>
      </div>
            
      <div class="control-group">
        <label>Sub Agent</label>
        <?php print $this->form_eksternal->form_dropdown('id_master_sub_agent', $sub_agent, array(""), 'id="agent" class="form-control input-sm"');?>
      </div>
            
       <div class="control-group">
      <label>Nama Depan Pemesan</label>
      <?php print $this->form_eksternal->form_input('ifirst_name', "", 'onblur="set_nama()" id="pemesan_depan" class="form-control input-sm" placeholder="Nama Depan"');?>
      </div>
      <div class="control-group">
      <label>Nama Belakang Pemesan</label>
      <?php print $this->form_eksternal->form_input('ilast_name', "", 'onblur="set_nama()" id="pemesan_belakang" class="form-control input-sm" placeholder="Nama Belakang"');?>
      </div>
      <div class="control-group">
      <label>Email</label>
      <?php print $this->form_eksternal->form_input('iemail', "", 'class="form-control input-sm" id="email_pemesan" placeholder="Email"');?>
      </div>
      <div class="control-group">
      <label>No Telp</label>
      <?php print $this->form_eksternal->form_input('itelp', "", 'onblur="set_nama()" class="form-control input-sm" id="no_telp_pemesan" placeholder="No Telp"');?>
      </div>
       <div class="control-group">
      <label>Alamat Pemesan</label>
      
      <?php print $this->form_eksternal->form_textarea('address', "", 'class="form-control input-sm" id="address_pemesan" placeholder="Address"');?>
      </div>     
          </div><!-- /.tab-pane -->
       <?php  
       $data_type_bed = array("0" => "Type Bed",
                    "1"           => "Adult Triple Twin",
                    "2"           => "Child Twin Bed",
                    "3"           => "Child Extra Bed",
                    "4"           => "Child No Bed",
                    "5"           => "SGL SUPP",
                    );
        $jumlah_adult_twin = 0;
        $jumlah_child_twin = 0;
        $jumlah_child_extra = 0;
        $jumlah_child_no_bed = 0;
        $jumlah_sgl_supp = 0;
        
        $total_no   = 0;
        $total_no1 = 0;
        $total_no2 = 0;
        $total_no3 = 0;
        $total_no4 = 0;
       if($this->session->userdata('jml_room')){
            for($k = 1 ; $k <= $this->session->userdata('jml_room'); $k++){
              $type_bed = "type_bed".$k;
              $qty = "qty".$k;
              
     ?>
          <div class="tab-pane" id="room_<?php echo $k; ?>">
            <?php 
            
            if($pst[$type_bed]){
              $no = 1;
                 foreach ($this->session->userdata($type_bed) as $key => $val) {
                  $data_qty = $this->session->userdata($qty);
              for($k_qty = 1 ; $k_qty <= $data_qty[$key] ; $k_qty++){ 
                
                if($val == 1){
                  if($pst['dasar_adult_triple_twin']){
                 $jumlah_adult_twin = $jumlah_adult_twin + 1;
                   ?>
  <div class="panel box box-primary">
              <div class="box-header with-border">
                  <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                      <?php print $data_type_bed[$val]." ".$k_qty; ?>
                  </a>
                  </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                  <div class="box-body">
                    <div class="control-group">
                      <label>Visa </label>
                      <div class="input-group">
                        <div class="checkbox">
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_adl[]', 1, TRUE);
                                  print $this->form_eksternal->form_input('visa_adl_nom[]', $pst['visa'], "style='display: none'");
                                  print number_format($pst['visa'],0,".",",");
                                  print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                ?>
                        </div>
                      </div>
                    </div>
                    <div class="control-group">
                      <label>Less Ticket </label>
                      <div class="input-group">
                        <div class="checkbox">
                                <?php
                                  print $this->form_eksternal->form_checkbox('less_ticket_adl[]', 1, FALSE);
                                  print $this->form_eksternal->form_input('lt_adl_nom[]', $pst['less_ticket_adl'], "style='display: none'");
                                  print number_format($pst['less_ticket_adl'],0,".",",");
                                  print " Centang Jika Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                ?>
                        </div>
                      </div>
                    </div>
                      <div class="control-group">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('first_name_adl_tt[]', "", 'id="tfirst'.$total_no++.'"  class="form-control adulttw input-sm" placeholder="First Name"');?>
                      </div>
                      <div class="control-group">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('last_name_adl_tt[]', "", 'id="tlast'.$total_no1++.'" class="form-control input-sm" placeholder="Last Name"');?>
                      </div>
                     <div class="control-group">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('telp_adl_tt[]', "", 'class="form-control input-sm" id="ano_telp_pemesan" placeholder="No Telp"');?>
                      </div>
                     <div class="col-md-6">
                      <div class="control-group">
                      <label>Place Of Birth</label>
                       <?php print $this->form_eksternal->form_input('place_birth_adl[]', "", 'id="tmpt_lahir" class="form-control input-sm" placeholder="Place Of Birth"');?>
                      </div>
                       </div>
                    <div class="col-md-6">
                      <div class="control-group">
                      <label>Date Of Birth</label>
                      <?php print $this->form_eksternal->form_input('date_adl_tt[]', "", 'id="tlahir'.$total_no2++.'" class="form-control input-sm adult_date" placeholder="Date Of Birth"');?>
                      <?php print $this->form_eksternal->form_input('room_adl_tt[]', $k, 'style ="display:none" class="form-control input-sm" placeholder="Room"');?>
                      </div>
                     </div>
                     
                    <div class="col-md-6">
                      <div class="control-group">
                      <label>No Passport</label>
                      <?php print $this->form_eksternal->form_input('adl_passport[]', "", 'class="form-control input-sm" placeholder="No Passport"');?>
                     </div>
                    </div>
                    <div class="col-md-6">
                    <div class="control-group">
                      <label>Place Of Issued</label>
                      <?php print $this->form_eksternal->form_input('place_issued_adl[]', "", 'class="form-control input-sm" placeholder="Place Of Issue"');?>
                     </div>
                      </div>
                    <div class="control-group">
                      <label>Date Of Issued</label>
                      <?php print $this->form_eksternal->form_input('date_issued_adl[]', "", 'id="date_issued_adl'.$total_no3++.'" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                      </div>
                    <div class="control-group">
                      <label>Date Of Expired</label>
                      <?php print $this->form_eksternal->form_input('date_expired_adl[]', "", 'id="date_expired_adl'.$total_no4++.'" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                      </div>
                    <?php
                    if($pst['visa']){
                    ?>
<!--                    <div class="control-group">
                  <label>Visa </label>
											<div class="input-group">
                        <div class="checkbox">
                            <label>
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_adl[]', 1, FALSE);
                                ?>
                                <?php print number_format($pst['visa'],0,".",","); ?>
                            </label>
                        </div>
											</div>
										</div>-->
                    <?php } ?>
                  </div>
              </div>
</div>  <?php } ?>
            <?php }elseif($val == 2){
              if($pst['dasar_child_twin_bed']){
              $jumlah_child_twin = $jumlah_child_twin + 1;
              ?>
  <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $data_type_bed[$val]." ".$k_qty; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="box-body">
                          <div class="control-group">
                            <label>Visa </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('visa_chl_tb[]', 1, TRUE);
                                        print $this->form_eksternal->form_input('visa_chl_tb_nom[]', $pst['visa'], "style='display: none'");
                                        print number_format($pst['visa'],0,".",",");
                                        print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                      ?>
                              </div>
                            </div>
                          </div>
                          <div class="control-group">
                            <label>Less Ticket </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('less_ticket_chl_tb[]', 1, FALSE);
                                        print " Centang Jika Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                      ?>
                              </div>
                            </div>
                          </div>
                            <div class="control-group">
                            <label>First Name</label>
                            <?php print $this->form_eksternal->form_input('first_name_chl_tb[]', "", 'id="tfirst'.$total_no++.'" class="form-control input-sm" placeholder="First Name"');?>
                            </div>
                            <div class="control-group">
                            <label>Last Name</label>
                            <?php print $this->form_eksternal->form_input('last_name_chl_tb[]', "", 'id="tlast'.$total_no1++.'" class="form-control input-sm" placeholder="Last Name"');?>
                            </div>
                          <div class="control-group">
                            <label>No Telp</label>
                            <?php print $this->form_eksternal->form_input('telp_chl_tb[]', "", 'class="form-control input-sm" id="no_telp_pemesan" placeholder="No Telp"');?>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Place Of Birth</label>
                            <?php print $this->form_eksternal->form_input('place_birth_chl_tb[]', "", 'id="tmpt_lahir_chl_tb" class="form-control input-sm" placeholder="Place Of Birth"');?>
                            </div>
                           </div> 
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Date Of Birth</label>
                            <?php print $this->form_eksternal->form_input('date_chl_tb[]', "", 'id="tlahir'.$total_no2++.'" class="form-control input-sm child_date" placeholder="Date Of Birth"');?>
                            <?php print $this->form_eksternal->form_input('room_chl_tb[]', $k, 'style ="display:none" class="form-control input-sm" placeholder="Room"');?>
                            </div>
                          </div>  
                           <div class="col-md-6">
                            <div class="control-group">
                            <label>No Passport</label>
                            <?php print $this->form_eksternal->form_input('chl_tb_passport[]', "", 'class="form-control input-sm" placeholder="No Passport"');?>
                            </div>
                           </div>  
                          <div class="col-md-6">
                            <div class="control-group">
                          <label>Place Of Issued</label>
                          <?php print $this->form_eksternal->form_input('place_issued_chl_tb[]', "", 'class="form-control input-sm" placeholder="Place Of Issue"');?>
                        </div>
                            </div>
                        
                        <div class="control-group">
                          <label>Date Of Issued</label>
                          <?php print $this->form_eksternal->form_input('date_issued_chl_tb[]', "", 'id="date_issued_chl_tb'.$total_no3++.'" class="form-control input-sm passport" placeholder="Date Of Issued"');?>

                          </div>
                        <div class="control-group">
                          <label>Date Of Expired</label>
                          <?php print $this->form_eksternal->form_input('date_expired_chl_tb[]', "", 'id="date_expired_chl_tb'.$total_no4++.'" class="form-control input-sm passport" placeholder="Date Of Expired"');?>

                          </div>
                            <?php
                    if($pst['visa']){
                    ?>
<!--                    <div class="control-group">
                  <label>Visa </label>
											<div class="input-group">
                        <div class="checkbox">
                            <label>
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_chl_tb[]', 1, FALSE);
                                ?>
                                <?php print number_format($pst['visa'],0,".",","); ?>
                            </label>
                        </div>
											</div>
										</div>-->
                    <?php } ?>
                        </div>
                    </div>
</div>       <?php } ?>
        <?php }elseif($val == 3){
          if($pst['dasar_child_extra_bed']){
          $jumlah_child_extra = $jumlah_child_extra + 1;
          ?>
   <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $data_type_bed[$val]." ".$k_qty; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="box-body">
                          <div class="control-group">
                            <label>Visa </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('visa_chl_eb[]', 1, TRUE);
                                        print $this->form_eksternal->form_input('visa_chl_eb_nom[]', $pst['visa'], "style='display: none'");
                                        print number_format($pst['visa'],0,".",",");
                                        print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                      ?>
                              </div>
                            </div>
                          </div>
                          <div class="control-group">
                            <label>Less Ticket </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('less_ticket_chl_eb[]', 1, FALSE);
                                        print " Centang Jika Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                      ?>
                              </div>
                            </div>
                          </div>
                            <div class="control-group">
                            <label>First Name</label>
                            <?php print $this->form_eksternal->form_input('first_name_chl_eb[]', "", 'id="tfirst'.$total_no++.'" class="form-control input-sm" placeholder="Nama Depan"');?>
                            </div>
                            <div class="control-group">
                            <label>Last Name</label>
                            <?php print $this->form_eksternal->form_input('last_name_chl_eb[]', "", 'id="tlast'.$total_no1++.'" class="form-control input-sm" placeholder="Nama Belakang"');?>
                            </div>
                          <div class="control-group">
                            <label>No Telp</label>
                            <?php print $this->form_eksternal->form_input('telp_chl_eb[]', "", 'class="form-control input-sm" id="no_telp_pemesan" placeholder="No Telp"');?>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Place Of Birth</label>
                            <?php print $this->form_eksternal->form_input('place_birth_chl_eb[]', "", 'id="tmpt_lahir_chl_eb" class="form-control input-sm" placeholder="Place Of Birth"');?>
                            </div>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Date Of Birth</label>
                            <?php print $this->form_eksternal->form_input('date_chl_eb[]', "", 'id="tlahir'.$total_no2++.'" class="form-control input-sm child_date" placeholder="Tanggal Lahir"');?>
                            <?php print $this->form_eksternal->form_input('room_chl_eb[]', $k, ' style ="display:none" class="form-control input-sm" placeholder="Room"');?>                           
                            </div>
                            </div>
                           <div class="col-md-6">
                            <div class="control-group">
                            <label>No Passport</label>
                            <?php print $this->form_eksternal->form_input('chl_eb_passport[]', "", 'class="form-control input-sm" placeholder="No Passport"');?>
                            </div>
                             </div>
                          <div class="col-md-6">
                            <div class="control-group">
                          <label>Place Of Issued</label>
                          <?php print $this->form_eksternal->form_input('place_issued_chl_eb[]', "", 'class="form-control input-sm" placeholder="Place Of Issue"');?>
                        </div>
                            </div>
                        <div class="control-group">
                          <label>Date Of Issued</label>
                          <?php print $this->form_eksternal->form_input('date_issued_chl_eb[]', "", 'id="date_issued_chl_eb'.$total_no3++.'" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                          </div>
                        <div class="control-group">
                          <label>Date Of Expired</label>
                          <?php print $this->form_eksternal->form_input('date_expired_chl_eb[]', "", 'id="date_expired_chl_eb'.$total_no4++.'" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                          </div>
                            <?php
                    if($pst['visa']){
                    ?>
<!--                    <div class="control-group">
                  <label>Visa </label>
											<div class="input-group">
                        <div class="checkbox">
                            <label>
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_chl_eb[]', 1, FALSE);
                                ?>
                                <?php print number_format($pst['visa'],0,".",","); ?>
                            </label>
                        </div>
											</div>
										</div>-->
                    <?php } ?>
                        </div>
                    </div>
</div>         <?php } ?>
        <?php }elseif($val == 4){
          if($pst['dasar_child_no_bed']){
          $jumlah_child_no_bed = $jumlah_child_no_bed + 1;
          
          ?>
  <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $data_type_bed[$val]." ".$k_qty; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="box-body">
                          <div class="control-group">
                            <label>Visa </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('visa_chl_nb[]', 1, TRUE);
                                        print $this->form_eksternal->form_input('visa_chl_nb_nom[]', $pst['visa'], "style='display: none'");
                                        print number_format($pst['visa'],0,".",",");
                                        print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                      ?>
                              </div>
                            </div>
                          </div>
                          <div class="control-group">
                            <label>Less Ticket </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('less_ticket_chl_nb[]', 1, FALSE);
                                        print " Centang Jika Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                      ?>
                              </div>
                            </div>
                          </div>
                            <div class="control-group">
                            <label>First Name</label>
                            <?php print $this->form_eksternal->form_input('first_name_chl_nb[]', "", 'id="tfirst" class="form-control input-sm" placeholder="First Name"');?>
                            </div>
                            <div class="control-group">
                            <label>Last Name</label>
                            <?php print $this->form_eksternal->form_input('last_name_chl_nb[]', "", 'id="tlast" class="form-control input-sm" placeholder="Last Name"');?>
                            </div>
                           <div class="control-group">
                            <label>No Telp</label>
                            <?php print $this->form_eksternal->form_input('telp_chl_nb[]', "", 'class="form-control input-sm" id="no_telp_pemesan" placeholder="No Telp"');?>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Place Of Birth</label>
                            <?php print $this->form_eksternal->form_input('place_birth_chl_nb[]', "", 'id="tmpt_lahir_chl_eb" class="form-control input-sm" placeholder="Place Of Birth"');?>
                            </div>
                           </div> 
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Date Of Birth</label>
                            <?php print $this->form_eksternal->form_input('date_chl_nb[]', "", 'id="tlahir'.$total_no2++.'" class="form-control input-sm child_date" placeholder="Date Of Birth"');?>
                            <?php print $this->form_eksternal->form_input('room_chl_nb[]', $k, 'style ="display:none" class="form-control input-sm" placeholder="Room"');?>                          
                            </div>
                         </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>No Passport</label>
                            <?php print $this->form_eksternal->form_input('chl_nb_passport[]', "", 'class="form-control input-sm" placeholder="No Passport"');?>
                            </div>
                            </div>
                          <div class="col-md-6">
                          <div class="control-group">
                          <label>Place Of Issued</label>
                          <?php print $this->form_eksternal->form_input('place_issued_chl_nb[]', "", 'class="form-control input-sm" placeholder="Place Of Issue"');?>
                        </div>
                            </div>
                        <div class="control-group">
                          <label>Date Of Issued</label>
                          <?php print $this->form_eksternal->form_input('date_issued_chl_nb[]', "", 'id="date_issued_chl_nb'.$total_no3++.'" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                          </div>
                        <div class="control-group">
                          <label>Date Of Expired</label>
                          <?php print $this->form_eksternal->form_input('date_expired_chl_nb[]', "", 'id="date_expired_chl_nb'.$total_no4++.'" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                          </div>
                            <?php
                    if($pst['visa']){
                    ?>
<!--                    <div class="control-group">
                  <label>Visa </label>
											<div class="input-group">
                        <div class="checkbox">
                            <label>
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_chl_nb[]', 1, FALSE);
                                ?>
                                <?php print number_format($pst['visa'],0,".",","); ?>
                            </label>
                        </div>
											</div>
										</div>-->
                    <?php } ?>
                        </div>
                    </div>
</div>          <?php } ?>
         <?php }elseif($val == 5){
           if($pst['sgl_supp']){
            $jumlah_sgl_supp  = $jumlah_sgl_supp + 1;
           ?>
   <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $data_type_bed[$val]." ".$k_qty; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                        <div class="box-body">
                          <div class="control-group">
                            <label>Visa </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('visa_chl_sgl[]', 1, TRUE);
                                        print $this->form_eksternal->form_input('visa_chl_sgl_nom[]', $pst['visa'], "style='display: none'");
                                        print number_format($pst['visa'],0,".",",");
                                        print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                      ?>
                              </div>
                            </div>
                          </div>
                          <div class="control-group">
                            <label>Less Ticket </label>
                            <div class="input-group">
                              <div class="checkbox">
                                      <?php
                                        print $this->form_eksternal->form_checkbox('less_ticket_chl_sgl[]', 1, FALSE);
                                        print " Centang Jika Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                      ?>
                              </div>
                            </div>
                          </div>
                            <div class="control-group">
                            <label>First Name</label>
                            <?php print $this->form_eksternal->form_input('first_name_sgl[]', "", 'id="tfirst'.$total_no++.'" class="form-control input-sm" placeholder="First Name"');?>
                            </div>
                            <div class="control-group">
                            <label>Last Name</label>
                            <?php print $this->form_eksternal->form_input('last_name_chl_sgl[]', "", 'id="tlast'.$total_no1++.'" class="form-control input-sm" placeholder="Last Name"');?>
                            </div>
                           <div class="control-group">
                            <label>No Telp</label>
                            <?php print $this->form_eksternal->form_input('telp_chl_sgl[]', "", 'class="form-control input-sm" id="no_telp_pemesan" placeholder="No Telp"');?>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Place Of Birth</label>
                            <?php print $this->form_eksternal->form_input('place_birth_chl_sgl[]', "", 'id="tmpt_lahir_chl_eb" class="form-control input-sm" placeholder="Place Of Birth"');?>
                            </div>
                            </div>
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>Date Of Birth</label>
                            <?php print $this->form_eksternal->form_input('date_chl_sgl[]', "", 'id="tlahir'.$total_no2++.'" class="form-control input-sm adult_date" placeholder="Tanggal Lahir"');?>
                            <?php print $this->form_eksternal->form_input('room_chl_sgl[]', $k, 'style ="display:none" class="form-control input-sm" placeholder="Room"');?>                         
                            </div>
                          </div>  
                          <div class="col-md-6">
                            <div class="control-group">
                            <label>No Passport</label>
                            <?php print $this->form_eksternal->form_input('chl_sgl_passport[]', "", 'class="form-control input-sm " placeholder="No Passport"');?>
                            </div>
                            </div>
                          <div class="col-md-6">
                          <div class="control-group">
                          <label>Place Of Issued</label>
                          <?php print $this->form_eksternal->form_input('place_issued_chl_sgl[]', "", 'class="form-control input-sm" placeholder="Place Of Issue"');?>
                        </div>
                            </div>
                        <div class="control-group">
                          <label>Date Of Issued</label>
                          <?php print $this->form_eksternal->form_input('date_issued_chl_sgl[]', "", 'id="date_issued_chl_sgl'.$total_no3++.'" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                          </div>
                        <div class="control-group">
                          <label>Date Of Expired</label>
                          <?php print $this->form_eksternal->form_input('date_expired_chl_sgl[]', "", 'id="date_expired_chl_sgl'.$total_no4++.'" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                          </div>
                            <?php
                    if($pst['visa']){
                    ?>
<!--                    <div class="control-group">
                  <label>Visa </label>
											<div class="input-group">
                        <div class="checkbox">
                            <label>
                                <?php
                                  print $this->form_eksternal->form_checkbox('visa_chl_sgl[]', 1, FALSE);
                                ?>
                                <?php print number_format($pst['visa'],0,".",","); ?>
                            </label>
                        </div>
											</div>
										</div>-->
                    <?php } ?>
                        </div>
                    </div>
</div>         <?php } ?>
         <?php } ?>   
            <?php } } ?>
          </div>
          <?php }
                }} ?>
          <!-- /.tab-pane -->
   <?php if($_POST['discount_request']){?>
    <div class="tab-pane" id="req_discont">
           <div class='box-body col-sm-12'>
              <div class="control-group">
                   <?php
                      $status_nb = array(1 => "Persen (%)",
                                      2 => "Nominal");
                      ?>
      <label>Discount Request</label>
      <ul>
        <?php foreach($pst['discount_request'] AS $gt => $dr){?>
        <li><?php print $pst['note_discount'][$gt]?> => <?php print $dr?></li>
        <?php }?>
      </ul>
      </div>
      </div>      
       </div>
   <?php } ?>
           <?php if($pst['type_add'][0] > 0){?>
            <div class="tab-pane" id="additional">
       <?php
       $no = 0;
foreach ($_POST['type_add'] as $val_add) { ?>
<div class='box-body col-sm-12'>
              <div class="control-group">
      <label><div class='number_additional'>Additional <?php $no = $no + 1; ?> </div></label>
      <?php print $this->form_eksternal->form_dropdown('type_add1[]', $this->session->userdata("arradd"), $val_add, ' disabled id="data_type_bed1" class="form-control type_bedq input-sm"');?>
      </div>
      </div>
<?php }
       ?>         
               
       </div>
        <?php } ?>
          <div class="tab-pane" id="price">
          <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <th>Person</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th></th>
                </tr>
            <?php
            $disc_adult_twin = 0;
             if($jumlah_adult_twin > 0){
                  if($pst['status_discount'] == 'Nominal'){
            $disc_adult_twin = $pst['dasar_adult_triple_twin'] - ($pst['discount'] * $jumlah_adult_twin);
            }else if($pst['status_discount'] == 'Persen'){
            $disc_adult_twin = ((($pst['dasar_adult_triple_twin'] * $jumlah_adult_twin)* $pst['discount'])/100);
            
             }
            }
              ?>       
               <tr>
                  <td>Adult Triple Twin</td>
                  <td><?php print $jumlah_adult_twin; ?></td>
                  <td><?php print number_format($pst['dasar_adult_triple_twin'],0,",","."); ?></td>
                  <td><?php print number_format($disc_adult_twin,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($jumlah_adult_twin * $pst['dasar_adult_triple_twin']),0,",","."); ?></td>
                </tr>
              <?php
              $disc_child_twin = 0;
              if($jumlah_child_twin > 0){
                  if($pst['status_discount'] == 'Nominal'){
            $disc_child_twin = $pst['dasar_child_twin_bed'] - ($pst['discount'] * $jumlah_child_twin);
            }else if($pst['status_discount'] == 'Persen'){
            $disc_child_twin = ((($pst['dasar_child_twin_bed'] * $jumlah_child_twin) * $pst['discount'])/100);
            }
              }
              ?>      
                <tr>
                  <td>Child Twin Bed</td>
                  <td><?php print $jumlah_child_twin; ?></td>
                  <td><?php print number_format($pst['dasar_child_twin_bed'],0,",","."); ?></td>
                  <td><?php print number_format($disc_child_twin,0,",","."); ?></td>
                 <td  style="text-align:right"><?php print number_format(($jumlah_child_twin * $pst['dasar_child_twin_bed']),0,",","."); ?></td>
                </tr>
                <?php
                $disc_child_extra = 0;
              if($jumlah_child_extra > 0){
                  if($pst['status_discount'] == 'Nominal'){
            $disc_child_extra = $pst['dasar_child_extra_bed'] - ($pst['discount'] * $jumlah_child_extra);
            }else if($pst['status_discount'] == 'Persen'){
            $disc_child_extra = ((($pst['dasar_child_extra_bed'] * $jumlah_child_extra)* $pst['discount'])/100);
            }
              }
              ?>    
                <tr>
                  <td>Child Extra Bed</td>
                  <td><?php print $jumlah_child_extra; ?></td>
                  <td><?php print number_format($pst['dasar_child_extra_bed'],0,",","."); ?></td>
                  <td><?php print number_format($disc_child_extra,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($jumlah_child_extra * $pst['dasar_child_extra_bed']),0,",","."); ?></td>
               
                </tr>
                 <?php
                 $disc_child_no = 0;
              if($jumlah_child_no_bed > 0){
                  if($pst['status_discount'] == 'Nominal'){
            $disc_child_no = $pst['dasar_child_no_bed'] - ($pst['discount'] * $jumlah_child_no_bed);
            }else if($pst['status_discount'] == 'Persen'){
            $disc_child_no = ((($pst['dasar_child_no_bed'] * $jumlah_child_no_bed)* $pst['discount'])/100);
            }
              }
              ?>    
                 <tr>
                  <td>Child No Bed</td>
                  <td><?php print $jumlah_child_no_bed; ?></td>
                  <td><?php print number_format($pst['dasar_child_no_bed'],0,",","."); ?></td>
                   <td><?php print number_format($disc_child_no,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($jumlah_child_no_bed * $pst['dasar_child_no_bed']),0,",","."); ?></td>
               
                </tr>
                <?php
                $disc_sgl_supp = 0;
              if($jumlah_sgl_supp > 0){
                  if($pst['status_discount'] == 'Nominal'){
            $disc_sgl_supp = $pst['sgl_supp'] - ($pst['discount'] * $jumlah_sgl_supp);
            }else if($pst['status_discount'] == 'Persen'){
            $disc_sgl_supp = ((($pst['sgl_supp'] * $jumlah_sgl_supp)* $pst['discount'])/100);
            }
              }
              ?>    
                <tr>
                  <td>SGL SUPP</td>
                  <td><?php print $jumlah_sgl_supp; ?></td>
                  <td><?php print number_format($pst['sgl_supp'],0,",","."); ?></td>
                   <td><?php print number_format($disc_sgl_supp,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($jumlah_sgl_supp * $pst['sgl_supp']),0,",","."); ?></td>
                </tr>
                
                <tr>
                  <?php
                  $total_adult_ttwin = ($jumlah_adult_twin * $pst['dasar_adult_triple_twin']);
                  if($total_adult_ttwin){
                    $jumlah_adult_twin = $jumlah_adult_twin;
                  }else{
                    $jumlah_adult_twin = 0;
                  }
                  $total_child_twin = ($jumlah_child_twin * $pst['dasar_child_twin_bed']);
                  if($total_child_twin){
                    $jumlah_child_twin = $jumlah_child_twin;
                  }else{
                    $jumlah_child_twin =0;
                  }
                  $total_child_extra = ($jumlah_child_extra * $pst['dasar_child_extra_bed']);
                  if($total_child_extra){
                    $jumlah_child_extra = $jumlah_child_extra;
                  }else{
                    $jumlah_child_extra = 0;
                  }
                  $total_child_no_bed = ($jumlah_child_no_bed * $pst['dasar_child_no_bed']);
                  if($total_child_no_bed){
                    $jumlah_child_no_bed = $jumlah_child_no_bed;
                  }else{
                    $jumlah_child_no_bed = 0;
                  }
                  $total_sgl_supp = ($jumlah_sgl_supp * $pst['sgl_supp']);
                  if($jumlah_sgl_supp){
                    $jumlah_sgl_supp = $jumlah_sgl_supp;
                  }else{
                    $jumlah_sgl_supp = 0;
                  }
                  $total_all_person = $total_adult_ttwin + $total_child_twin + $total_child_extra + $total_child_no_bed + $total_sgl_supp;
               
                  ?>
                  
                  <td><b>Total Price</b></td>
                  <td colspan="4" style="text-align:right" ><b><?php print number_format($total_all_person,0,",","."); ?></b></td>
                 
                </tr>
                <tr>
                  <td><b>Airport Tax & Flight Insurance</b></td>
                  <?php
                  $total_person = ($jumlah_adult_twin + $jumlah_child_twin + $jumlah_child_extra + $jumlah_child_no_bed + $jumlah_sgl_supp);
                  ?>
                   <?php print $this->form_eksternal->form_input('total_person', $total_person, ' style="display:none" id="total_person"  class="form-control input-sm"');?>
                  <td><?php print $total_person; ?></td>
                  <td><?php print number_format($pst['tax_and_insurance'],0,",","."); ?></td>
                  <?php $tot_tax_and_insurance = $total_person * $pst['tax_and_insurance'];?>
                  <td colspan="2"  style="text-align:right"><b><?php print number_format(($tot_tax_and_insurance),0,",","."); ?></b></td>
               
                </tr>
                  <tr>
                    <?php
                    if($pst['discount']){
                      $data_discount = $pst['discount'];
                      $tnd_minus = "-";
                    }else{
                      $data_discount = 0;
                      $tnd_minus = "";
                    }
                    ?>
                    
                    <?php if($pst['status_discount']){
                $stnb = "[".$pst['status_discount']."]"; 
                }else{
                  $stnb = "";
                }
                $status_price="";
                
                $tot_disc_price=0;
                if($pst['status_discount'] == "Persen"){
                  $status_price = $pst['discount'];
                  $tot_disc_price =  ((($total_all_person * $pst['discount'])/100)/$total_person);
                }elseif($pst['status_discount'] == "Nominal") {
                     $status_price = $pst['discount'];
                 $tot_disc_price = $pst['discount'];
                } 
               
                $tot_disc = $disc_adult_twin + $disc_child_twin + $disc_child_extra + $disc_child_no + $disc_sgl_supp;
                ?>
                  <td><b>Discount <?php print $status_price." ".$stnb; ?></b></td>
                  <td></td>
                  <td></td>
                  <td><?php print number_format($tot_disc); ?></td>
                  <td style="text-align:right" ><?php print $tnd_minus; ?> <b><?php print number_format($tot_disc); ?></b></td>
                  </tr>
                <!--  <tr>
                      
                   <?php
                  if($_POST['discount_request']){
                       $dis_req = $_POST['discount_request'];
                   if($_POST['discount_request'] < $_POST['discount_tambahan']){?>
                  
                  <td><b>Discount Tambahan</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print number_format($dis_req,0,",","."); ?></b></td>
                   <?php  }else{
                       $dis_req = 0;
                   }}  ?>
                </tr> -->
                <tr>
                  <td><b>Total</b></td>
                  <?php
                  $tot_prc = ($total_all_person + $tot_tax_and_insurance) - ($tot_disc);
                  ?>
                  <td colspan="4" style="text-align:right" ><b><?php print number_format($tot_prc,0,",","."); ?></b></td>                
                </tr>
                <tr>
                  <td><b>PPN 1%</b></td>
                  <?php
                  $ppn = (1 * $tot_prc)/100;
                  ?>
                  <td colspan="4" style="text-align:right" ><b><?php print number_format($ppn,0,",","."); ?></b></td>                
                </tr>
               <tr>
                  <td><b>Total All</b></td>
                  <td colspan="4" style="text-align:right" ><b><?php print number_format(($tot_prc + $ppn),0,",","."); ?></b></td>                
                </tr>
            </table>   
            <div class="control-group">
              <label>Remark TTU</label>
              <?php print $this->form_eksternal->form_textarea('remark', "", 'class="form-control input-sm"');?>
            </div>
            <div class="box-footer">
   <?php print $this->form_eksternal->form_input('jumlah_room', $pst["jumlah_room"], ' style="display:none" id="jml_room"  class="form-control input-sm" placeholder="jumlah_room"');?>
                 <center><button class="btn btn-primary" id="but_sub" type="submit">BOOK</button> 
                 <a href="<?php print site_url("grouptour/product-tour/book-tour/{$pst['tour_information_code']}")?>" class="btn btn-warning"><?php print lang("cancel")?></a></center>
   </div>
       </div>
          
  </div><!-- /.tab-content -->
                            </div>


</form>