<?php
//print $data->payment[1]->pos;
//print $this->session->userdata("email");
//print "<pre>";
//print_r($data);
//print "</pre>";
$room_type = array("1" => "Adult Triple/ Twin",
                            "2"  => "Child Twin Bed",
                            "3" => "Child Extra Bed",
                            "4" => "Child No Bed",
                            "5" => "Adult Single",
                        );
print $this->form_eksternal->form_open("", 'role="form"', array(
  "id_detail" => $data->book->code, 
  "status_user" => $data->book->status,
  ));
?>
<div class="row">
  <div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Passenger Detail</h3>
            <div class="widget-control pull-right">
          <a href="#" data-toggle="dropdown" class="btn"><span class="glyphicon glyphicon-cog"></span> Menu</a>
          <ul class="dropdown-menu">
            <li><a href="javascript:void(0)" id="print-price-detail"><i class="fa fa-print"></i> Print Price Detail</a></li>
            <!--<li><a href="http://localhost/app/bersih/store/menu/menu-cache"><i class="fa fa-envelope"></i> Send Email</a></li>-->
          </ul>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="nav-tabs-custom">
 <ul class="nav nav-tabs">
   <li class='active' ><a href="#tour_detail" data-toggle="tab">Tour Detail</a></li>
   <li><a href="#info" data-toggle="tab">Informasi Pemesan</a></li>
   <?php                                   
           if($data->book->room){
            for($r = 1 ; $r <= $data->book->room ; $r++){
              if($r == 1){
                $class_data= "class='active'";
              }else{
                $class_data ="";
              }
     ?>
 <li><a href="#room_<?php echo $r; ?>" data-toggle="tab">Room  <?php echo $r; ?></a></li>
      <?php }} ?>
 <!--<li><a href="#price" data-toggle="tab">Price Detail</a></li>-->
 </ul>
   <div class="tab-content">
     <div class="tab-pane active" id="tour_detail">
                <table class="table table-condensed">
                <tr>
                  <th>Title</th>
                  <td><?php print $data->tour->title?></td>
                </tr>
                <tr>
                  <th>Category</th>
                  <td><?php print $data->tour->category->name." ".$data->tour->sub_category->name?></td>
                </tr>
                <?php
                if($data->payment[1]->pos < "2" AND $data->payment[1]->nominal < "1"){
                if($data->book->info_disc){
                ?>
                 <tr>
                  <th>Total Customer Tour</th>
                  <td><?php print $data->book->total_customer." People"; ?></td>
                </tr>
                 <tr>
                  <th>Info Discount</th>
                  <td>
                  <?php
                  $dt_status_disc2 = array("1" => "Persen",
                                            "2" => "Nominal");
                  $no = 1;
                        foreach ( $data->book->info_disc as $dval) {
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
                            print "Untuk ".$batas_all." Orang Deposit {$dt} Akan mendapatkan discount ".$dval->discount." ".$dt_status_disc2[$dval->status_discount]."<br>";
                            $dt_dis = $bts;
                            $no++;
                            }
                  ?>
                  </td>
                </tr>
                <?php } } ?>
                <tr>
                  <th>Start Date</th>
                  <td><?php print date("d F Y", strtotime($data->tour->information->start_date))?></td>
                </tr>
                <tr>
                  <th>End Date</th>
                  <td><?php print date("d F Y", strtotime($data->tour->information->end_date))?></td>
                </tr>
               <!--  <tr>
                  <th>Min DP</th>
                  <td><?php print $data->tour->information->price->currency." ".number_format($data->book->dp,2,".",","); ?></td>
                </tr>
               <tr>
                  <th>Committed Book</th>
                  <td><?php print $data->tour->information->committed_book; ?> %</td>
                </tr> -->
                <tr>
                  <th>Status</th>
                  <td><?php 
                  $status = array(
                    1 => "Book",
                    2 => "Deposit",
                    3 => "Lunas",
                    4 => "Cancel",
                  );
                  
                  $nobook     = 0;
                  $nocommit   = 0;
                  $nolunas    = 0;
                  $nocancel   = 0;
                  $wt_app     = 0;
                  $cancel_depo     = 0;
                  foreach ($data->book->passenger as $valps) {
                   // echo $valps['status'];
                    if($valps->status == "Book"){
                      $nobook2 +=  $nobook + 1;
                    }elseif($valps->status == "Deposit"){
                      $nocommit2 +=  $nocommit + 1;
                    }elseif($valps->status == "Lunas"){
                      $nolunas2 +=  $nolunas + 1;
                    }elseif($valps->status == "Cancel"){
                      $nocancel2 +=  $nocancel + 1;
                    }elseif($valps->status == "[Cancel] Waiting Approval"){
                      $wt_app2 += $wt_app + 1;
                    }elseif($valps->status == "Cancel Deposit"){
                      $cancel_depo2 += $cancel_depo+1;
                    }
                  }
                  
                  if($nobook2 > 0){
                    $st_book = "Book For ".$nobook2." Person<br>";
                  }
                  if($nocommit2 > 0){
                    $st_commit = "Deposit For ".$nocommit2." Person<br>";
                  }
                  if($nolunas2 > 0){
                    $st_lunas = "Lunas For ".$nolunas2." Person<br>";
                  }
                  if($nocancel2 > 0){
                    $st_cancel = "Cancel For ".$nocancel2." Person<br>";
                  }
                  if($wt_app2 > 0){
                    $st_wtapp = "[Cancel] Waiting Approval For ".$wt_app2." Person<br>";
                  }
                  if($cancel_depo2 > 0){
                    $st_cancel_deposit = "Cancel Deposit For ".$cancel_depo2." Person<br>";
                  }
                  
                 $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                  print "<b>".$status[$data->book->status]." For ".$total_person." Person </b>";
                  print "<b>".$st_book.$st_commit.$st_lunas.$st_cancel.$st_wtapp.$st_cancel_deposit."</b>";
                  ?></td>
                </tr>
                
               <tr>
                  <th></th>
                  <td>
                    <?php
                    if($data->book->own_user == $this->session->userdata('email') OR in_array($this->session->userdata("id"), $approval_array) OR $this->session->userdata("id") == 1){
                    ?>
<!--                    <a href="<?php print site_url("grouptour/product-tour/payment-book/".$data->book->code)?>" class="btn btn-primary"><?php print lang("Payment")?></a>
                    <a href="<?php print site_url("grouptour/product-tour/refund-book/".$data->book->code)?>" class="btn btn-info"><?php print lang("Refund")?></a>-->
                    <?php }?>
                  </td>                  
                </tr>
                <tr style="display:none">
                  <th></th>
                  
                  <?php if($data->book->status == 1 ){?>
<!--                  <td><input class="btn btn-primary" type="submit" name="committed_book" value="Committed Book"></input></td>-->
                  <?php } ?>
                </tr>
            </table>
       </div>
     
     <div class="tab-pane" id="info">
      
        <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <td><?php print $data->book->first_name." ".$data->book->last_name; ?></td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td><?php print $data->book->email; ?></td>
                </tr>
                <tr>
                  <th>No Telp</th>
                  <td><?php print $data->book->telphone; ?></td>
                </tr>
                <tr>
                  <th>Address</th>
                  <td><?php print $data->book->address; ?></td>
                </tr>
            </table>
       </div>
      <?php    if($data->book->room){
            for($k = 1 ; $k <= $data->book->room ; $k++){
              $type_bed = "type_bed".$k;
              $qty = "qty".$k;
              
              if($k == 1){
                $class_active = "active";
              }else{
                $class_active = "";
              }
              
     ?>
       <div class="tab-pane" id="room_<?php echo $k; ?>">
         <?php
                foreach($data->book->passenger AS $dbp){
                   $btn_change_tour = site_url("grouptour/product-tour/change-tour-person/".$dbp->customer_code);  
                  if($dbp->room == $k){
                    if($dbp->status == "Cancel" OR $dbp->status == "[Cancel] Waiting Approval"){
                    $btn_url = "";
                    }else{
                      $btn_url2 = site_url("store/cancel-tour-per-pax/".$data->book->code."/".$dbp->customer_code);
//                      $btn_url = "<a style='  margin-left: 70%;margin-top: 3%;' href='$btn_url2' class='btn btn-danger'>Cancel Tour</a>";
                     $btn_url = "<a href='javascript:void(0)' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$dbp->customer_code}' class='btn btn-danger' id='id-customer-cancel' >Cancel Tour</a>";
                  
                    } ?>
         <?php
         if($dbp->type->code == 1){
         ?>
         <div class="panel box box-primary">
              <div class="box-header with-border">
                  <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                      <?php print $dbp->type->desc; ?>
                  </a>
                  </h4>
              </div>
              <div id="collapse1" class="panel-collapse collapse in">
                  <?php
                  if( ($dbp->cstatus < 4)){
                  ?>
                <div class="box-body">    
                   <dl class="dl-horizontal">
                        <dt>Room</dt>
                        <dd><?php print $dbp->room?></dd>
                        
                        <dt>Bed Type</dt>
                        <dd><?php print $room_type[$dbp->type->code]?></dd>
                        
                        <dt>Name</dt>
                        <dd><?php print $dbp->first_name." ".$dbp->last_name?></dd>
                        
                        <dt>No Telp</dt>
                        <dd><?php print $dbp->telphone?></dd>
                        
                        <dt>Tempat Lahir</dt>
                        <dd><?php print $dbp->tempat_tanggal_lahir?></dd>
                        
                        <dt>Tanggal Lahir</dt>
                        <dd><?php print $dbp->tanggal_lahir?></dd>
                        
                        <dt>No Passport</dt>
                        <dd><?php print $dbp->no_passport?></dd>
                        
                        <dt>Tempat Pembuatan</dt>
                        <dd><?php print $dbp->place_of_issued?></dd>
                        
                        <dt>Tanggal Pembuatan</dt>
                        <dd><?php print $dbp->date_of_issued?></dd>
                        
                        <dt>Tanggal Berakhir</dt>
                        <dd><?php print $dbp->date_of_expired?></dd>
                        
                        <dt>Alamat</dt>
                        <dd><?php print $data->book->address?></dd>
                        
                        <dt>Status</dt>
                        <dd><?php print $dbp->status?></dd>
                    </dl>
                  
                  </div>
                <?php
                  }
                  else{
                    ?>
                <div class="box-body">    
                    <div class="col-md-12">
                      <div class="control-group">
                        <label><?php print $dbp->status; ?></label>
                        <label><?php print $dbp->first_name?></label>
                        <label><?php print $dbp->last_name?></label>
                      </div>
                    </div>
                </div>
                <?php
                  }
                ?>
                
              </div>
      </div> <?php }elseif($dbp->type->code == 2){ ?>
         <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $dbp->type->desc; ?> 
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                      <?php
                      if($dbp->cstatus < 4){
                      ?>
                        <div class="box-body">
                   
                      <dl class="dl-horizontal">
                        <dt>Room</dt>
                        <dd><?php print $dbp->room?></dd>
                        
                        <dt>Bed Type</dt>
                        <dd><?php print $room_type[$dbp->type->code]?></dd>
                        
                        <dt>Name</dt>
                        <dd><?php print $dbp->first_name." ".$dbp->last_name?></dd>
                        
                        <dt>No Telp</dt>
                        <dd><?php print $dbp->telphone?></dd>
                        
                        <dt>Tempat Lahir</dt>
                        <dd><?php print $dbp->tempat_tanggal_lahir?></dd>
                        
                        <dt>Tanggal Lahir</dt>
                        <dd><?php print $dbp->tanggal_lahir?></dd>
                        
                        <dt>No Passport</dt>
                        <dd><?php print $dbp->no_passport?></dd>
                        
                        <dt>Tempat Pembuatan</dt>
                        <dd><?php print $dbp->place_of_issued?></dd>
                        
                        <dt>Tanggal Pembuatan</dt>
                        <dd><?php print $dbp->date_of_issued?></dd>
                        
                        <dt>Tanggal Berakhir</dt>
                        <dd><?php print $dbp->date_of_expired?></dd>
                        
                        <dt>Alamat</dt>
                        <dd><?php print $data->book->address?></dd>
                        
                        <dt>Status</dt>
                        <dd><?php print $dbp->status?></dd>
                    </dl>
                        </div>
                      <?php
                      }
                      else{
                        ?>
                    <div class="box-body">    
                        <div class="col-md-12">
                          <div class="control-group">
                            <label><?php print $dbp->status; ?></label>
                            <label><?php print $dbp->first_name?></label>
                            <label><?php print $dbp->last_name?></label>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    </div>
        </div> 
         <?php }elseif($dbp->type->code == 3){?>
         <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $dbp->type->desc; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                      <?php
                      if($dbp->cstatus < 4){
                      ?>
                        <div class="box-body">
                        
                  <dl class="dl-horizontal">
                        <dt>Room</dt>
                        <dd><?php print $dbp->room?></dd>
                        
                        <dt>Bed Type</dt>
                        <dd><?php print $room_type[$dbp->type->code]?></dd>
                        
                        <dt>Name</dt>
                        <dd><?php print $dbp->first_name." ".$dbp->last_name?></dd>
                        
                        <dt>No Telp</dt>
                        <dd><?php print $dbp->telphone?></dd>
                        
                        <dt>Tempat Lahir</dt>
                        <dd><?php print $dbp->tempat_tanggal_lahir?></dd>
                        
                        <dt>Tanggal Lahir</dt>
                        <dd><?php print $dbp->tanggal_lahir?></dd>
                        
                        <dt>No Passport</dt>
                        <dd><?php print $dbp->no_passport?></dd>
                        
                        <dt>Tempat Pembuatan</dt>
                        <dd><?php print $dbp->place_of_issued?></dd>
                        
                        <dt>Tanggal Pembuatan</dt>
                        <dd><?php print $dbp->date_of_issued?></dd>
                        
                        <dt>Tanggal Berakhir</dt>
                        <dd><?php print $dbp->date_of_expired?></dd>
                        
                        <dt>Alamat</dt>
                        <dd><?php print $data->book->address?></dd>
                        
                        <dt>Status</dt>
                        <dd><?php print $dbp->status?></dd>
                    </dl>
                        </div>
                      <?php
                      }
                      else{
                        ?>
                    <div class="box-body">    
                        <div class="col-md-12">
                          <div class="control-group">
                            <label><?php print $dbp->status; ?></label>
                            <label><?php print $dbp->first_name?></label>
                            <label><?php print $dbp->last_name?></label>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    </div>
        </div>
         <?php }elseif($dbp->type->code == 4){?>
         <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $dbp->type->desc; ?>
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                      <?php
                      if($dbp->cstatus < 4 ){
                      ?>
                        <div class="box-body">
                         <dl class="dl-horizontal">
                        <dt>Room</dt>
                        <dd><?php print $dbp->room?></dd>
                        
                        <dt>Bed Type</dt>
                        <dd><?php print $room_type[$dbp->type->code]?></dd>
                        
                        <dt>Name</dt>
                        <dd><?php print $dbp->first_name." ".$dbp->last_name?></dd>
                        
                        <dt>No Telp</dt>
                        <dd><?php print $dbp->telphone?></dd>
                        
                        <dt>Tempat Lahir</dt>
                        <dd><?php print $dbp->tempat_tanggal_lahir?></dd>
                        
                        <dt>Tanggal Lahir</dt>
                        <dd><?php print $dbp->tanggal_lahir?></dd>
                        
                        <dt>No Passport</dt>
                        <dd><?php print $dbp->no_passport?></dd>
                        
                        <dt>Tempat Pembuatan</dt>
                        <dd><?php print $dbp->place_of_issued?></dd>
                        
                        <dt>Tanggal Pembuatan</dt>
                        <dd><?php print $dbp->date_of_issued?></dd>
                        
                        <dt>Tanggal Berakhir</dt>
                        <dd><?php print $dbp->date_of_expired?></dd>
                        
                        <dt>Alamat</dt>
                        <dd><?php print $data->book->address?></dd>
                        
                        <dt>Status</dt>
                        <dd><?php print $dbp->status?></dd>
                    </dl>
                  
                        </div>
                      <?php
                      }
                      else{
                        ?>
                    <div class="box-body">    
                        <div class="col-md-12">
                          <div class="control-group">
                            <label><?php print $dbp->status; ?></label>
                            <label><?php print $dbp->first_name?></label>
                            <label><?php print $dbp->last_name?></label>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    </div>
</div> 
         <?php }elseif($dbp->type->code == 5){ ?>
         <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                            <?php print $dbp->type->desc; ?>  
                        </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse in">
                      <?php
                      if($dbp->cstatus < 4){
                      ?>
                        <div class="box-body">
                     <dl class="dl-horizontal">
                        <dt>Room</dt>
                        <dd><?php print $dbp->room?></dd>
                        
                        <dt>Bed Type</dt>
                        <dd><?php print $room_type[$dbp->type->code]?></dd>
                        
                        <dt>Name</dt>
                        <dd><?php print $dbp->first_name." ".$dbp->last_name?></dd>
                        
                        <dt>No Telp</dt>
                        <dd><?php print $dbp->telphone?></dd>
                        
                        <dt>Tempat Lahir</dt>
                        <dd><?php print $dbp->tempat_tanggal_lahir?></dd>
                        
                        <dt>Tanggal Lahir</dt>
                        <dd><?php print $dbp->tanggal_lahir?></dd>
                        
                        <dt>No Passport</dt>
                        <dd><?php print $dbp->no_passport?></dd>
                        
                        <dt>Tempat Pembuatan</dt>
                        <dd><?php print $dbp->place_of_issued?></dd>
                        
                        <dt>Tanggal Pembuatan</dt>
                        <dd><?php print $dbp->date_of_issued?></dd>
                        
                        <dt>Tanggal Berakhir</dt>
                        <dd><?php print $dbp->date_of_expired?></dd>
                        
                        <dt>Alamat</dt>
                        <dd><?php print $data->book->address?></dd>
                        
                        <dt>Status</dt>
                        <dd><?php print $dbp->status?></dd>
                    </dl>
                        </div>
                      <?php
                      }
                      else{
                        ?>
                    <div class="box-body">    
                        <div class="col-md-12">
                          <div class="control-group">
                            <label><?php print $dbp->status; ?></label>
                            <label><?php print $dbp->first_name?></label>
                            <label><?php print $dbp->last_name?></label>
                          </div>
                        </div>
                    </div>
                    <?php
                      }
                    ?>
                    </div>
           
      </div> 
         
         <?php } ?>
       <?php
         
                  
                    $no++;
                }}
                ?>
       <!--   <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <th>Birthdate</th>
                  <th>Type</th>
                  <th>Passport</th>
                  <th>Status</th>
                  <th></th>
                </tr>
            </table>      -->
         <?php   if($data->book->own_user == $this->session->userdata("email") OR $this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "edit-book", "edit") !== FALSE){?>
<!--         <input class="btn btn-primary" type="submit" name="customer_edit" value="Submit"></input>-->
         <?php } ?>
       </div>
              <?php } ?>
              
            <?php  } 
   if($data->book->additional) {           
   ?>  
   <div class="tab-pane" id="additional">
          <table class="table table-condensed">
                <tr>
                  <th>Additional</th>
                  <th>Nominal</th>
                  <th></th>
                </tr>
               <?php
                foreach($data->book->additional AS $add){
                  print "<tr>"
                    . "<td>{$add->name_additional}</td>"
                    . "<td>".number_format($add->nominal_additional,2,".",",")."</td>"
                  . "</tr>";
                }
                ?>
            </table>  
     <br><br>
      
     
           
       </div>
       <?php } ?> 
<!--       <div class="tab-pane" id="price">
          <table class="table table table-bordered">
                <tr>
                  <th>Name</th>
                  <th>Person</th>
                  <th>Price</th>
                  <th></th>
                  <th></th>
                </tr>
               <tr>
                  <td>Adult Triple Twin</td>
                  <td><?php print $data->book->jumlah_person_adult_triple_twin; ?></td>
                  <td><?php print number_format($data->tour->information->price->adult_triple_twin,2,".",","); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin),2,".",","); ?></td>
                  <td style="text-align:right"></td>
               </tr>
                
                <tr>
                  <td>Child Twin Bed</td>
                  <td><?php print $data->book->jumlah_person_child_twin; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_twin_bed,0,",","."); ?></td>
                 <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed),2,".",","); ?></td>
                  <td style="text-align:right"></td>
                </tr>
                <tr>
                  <td>Child Extra Bed</td>
                  <td><?php print $data->book->jumlah_person_child_extra; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_extra_bed,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed),2,".",","); ?></td>               
                  <td style="text-align:right"></td>
                </tr>
                
                 <tr>
                  <td>Child No Bed</td>
                  <td><?php print $data->book->jumlah_person_child_no_bed; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_no_bed,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed),2,".",","); ?></td>
                  <td style="text-align:right"></td>
                </tr>
                <tr>
                  <td>Single Adult</td>
                  <?php
                  $single_adult = $data->tour->information->price->sgl_supp + $data->tour->information->price->adult_triple_twin;
                  ?>
                  <td><?php print $data->book->jumlah_person_sgl_supp; ?></td>
                  <td><?php print number_format($single_adult,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_sgl_supp * $single_adult),2,".",","); ?></td>
                  <td style="text-align:right"></td>
                </tr>
                
                <tr>
                  <?php
                  $total_adult_ttwin = ($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin);
                  $total_child_twin = ($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed);
                  $total_child_extra = ($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed);
                  $total_child_no_bed = ($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed);
                  $total_sgl_adult = ($data->book->jumlah_person_sgl_supp * $single_adult);
                  $total_all_person = $total_adult_ttwin + $total_child_twin + $total_child_extra + $total_child_no_bed + $total_sgl_adult;
                  $total_tax = ($total_person * $data->tour->information->price->tax_and_insurance);
                  ?>
                  
                  <td><b>Total Price</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print number_format($total_all_person,2,".",","); ?></b></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Airport Tax & Flight Insurance</td>
                  <td><?php print $total_person; ?></td>
                  <td><?php print number_format($data->tour->information->price->tax_and_insurance,2,".",","); ?></td>
                  <td  style="text-align:right"><?php print number_format(($total_person * $data->tour->information->price->tax_and_insurance),2,".",","); ?></td>
                  <td></td>
                </tr>
                <?php 
                
                if($data->book->total_visa > 0){
                  $totl_visa = $data->book->total_visa * $data->tour->information->price->visa;
                ?>
                <tr>
                  <td><b>Visa</b></td>
                  <td><?php print $data->book->total_visa; ?></td>
                  <td><?php print number_format($data->tour->information->price->visa,2,".",","); ?></td>
                  <td  style="text-align:right"><b><?php print number_format(($totl_visa),2,".",","); ?></b></td>
                  <td></td>
                </tr>
                <?php }?>
                <?php 
                if($data->book->status_discount){
                $stnb = "[".$data->book->status_discount."]"; 
                }else{
                  $stnb = "";
                }
                
                $status_price="";
                if($data->book->status_discount == "Persen"){
                  $status_price = $data->book->discount;
                  $tot_disc_price =  (($total_all_person * $data->book->discount)/100);
                }elseif($data->book->status_discount == "Nominal") {
                 $tot_disc_price = number_format($data->book->status_discount,2,".",",");
                }
                if($data->book->discount){
                  $tnd_minus = "-";
                }else{
                  $tnd_minus = "";
                }
                ?>
                  <tr>
                  <td>Discount <?php print $status_price." ".$stnb; ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td colspan="" style="text-align:right" ><?php print $tnd_minus; ?> <?php print $total = number_format($tot_disc_price,2,".",","); ?></td>
                  </tr>
                <tr>
                  <?php
                  $total_adult_ttwin = ($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin);
                  $total_child_twin = ($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed);
                  $total_child_extra = ($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed);
                  $total_child_no_bed = ($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed);
                  $total_sgl_adult = ($data->book->jumlah_person_sgl_supp * $single_adult);
                  $tot_prc =($total_all_person + $total_tax + $totl_visa);
                  $ppn = (1 * ($tot_prc - $tot_disc_price))/100;
                  ?>
                  
                  <td><b>Total</b></td>
                  <td></td>
                  <td></td>
                  <td style="text-align:right" ><b><?php print number_format($tot_prc,2,".",","); ?></b></td>
                  <td style="text-align:right" ><b>-<?php print number_format($tot_disc_price,2,".",","); ?></b></td>
                </tr>
               <tr>
                  <td>PPN 1%</b></td>
                  <td colspan="4" style="text-align:right" ><?php print number_format($ppn,2,".",","); ?></td>
                 </tr>
                 <tr>
                  <td><b>Total All</b></td>
                  <td colspan="4" style="text-align:right" ><b><?php print number_format(($tot_prc - $tot_disc_price) + $ppn,2,".",","); ?></b></td>
                  </tr>
            </table>      
       </div>-->
   </div><!-- /.tab-content -->
       </div>
          
        </div>
    </div>
  </div>
 <!-- <div class="col-md-6">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Payment Detail [USD]</h3>
        </div>
        <div class="box-body">
          <table class="table table table-bordered">
                <tr>
                  <th>Tanggal</th>
                  <th>Status Payment</th>
                  <th>Payment</th>
                  <th>Debit</th>
                  <th>Kredit</th>
                </tr>
                <?php
                $total_debit = $total_kredit = $total_debit2 = $total_kredit2 = 0 ;
                $status_payment = array(
                  1 => "Draft",
                  2 => "Confirm",
                  3 => "Not Paid"
                );
                $channel = array(
                  1 => "Cash",
                  2 => "BCA",
                  3 => "Mega",
                  4 => "Mandiri",
                  5 => "CC"
                );
               
                
                foreach($data->payment AS $dp){
                  if($dp->currency == 1){
                      $tot_nom0 = $dp->nominal;
                    }elseif($dp->currency == 2){
                      $tot_nom0 = $dp->nominal/$data->currency_rate;
                    }
                  if($dp->pos == 1){
                    $debit = number_format($tot_nom0, 2, ".", ",");
                    $kredit = "";
                    $total_debit += $tot_nom0;
                  }
                  else{
                    $kredit = number_format($tot_nom0, 2, ".", ",");
                    $debit = "";
                    $total_kredit += $tot_nom0;
                  }
                  print "<tr>"
                  . "<td>{$dp->tanggal}</td>"
                  . "<td>{$status_payment[$dp->status]}</td>"
                  . "<td>{$channel[$dp->status_payment]}</td>"
                  . "<td style='text-align: right'>{$debit}</td>"
                  . "<td style='text-align: right'>{$kredit}</td>"
                  . "</tr>";
                }
                ?>
                <tfoot>
                  <tr>
                    <?php
                    $data_tax = $total_person * $data->tour->information->price->tax_and_insurance;
                    
                    ?>
                    <th colspan="3">Airport Tax & Flight Insurance</th>
                    <th style='text-align: right'><?php print number_format($data_tax,0,".",","); ?></th>
                    <th style='text-align: right'>0</th>
                  </tr>
                   <?php
                foreach($data->book->additional AS $add){
                
                  if($add->nominal_additional){
                    $nom_ad1 = "";
                    $nom_ad2 = "";
                    if($add->id_currency == 1){
                        $nom_add0 = $add->nominal_additional;
                      }elseif($add->id_currency == 2){
                        $nom_add0 = $add->nominal_additional/$data->currency_rate;
                      }
                    if($add->pos == 1){
                      $nom_ad1 = $nom_add0;
                      $total_kredit2 += $nom_add0;
                    }else{
                      $nom_ad2 = $nom_add0;
                      $total_debit2 += $nom_add0;
                    }
                  print "<tr>"
                    . "<th colspan='3'>{$add->name_additional}</th>"
                    . "<th style='text-align: right'>".number_format($nom_ad2,2,".",",")."</th>"
                      . "<th style='text-align: right'>".number_format($nom_ad1,2,".",",")."</th>"
                  . "</tr>";
                }}
                ?>
                 <?php
                  if($data->book->discount){
                 ?>
                  <?php 
                if($data->book->status_discount){
                $stnb = "[".$data->book->status_discount."]"; 
                }else{
                  $stnb = "";
                }
                
                $status_price1="";
                if($data->book->status_discount == "Persen"){
                  $status_price = $data->book->discount;
                  $tot_disc_price1 =  (($total_debit * $data->book->discount)/100);
                }elseif($data->book->status_discount == "Nominal") {
                 $tot_disc_price1 = $data->book->discount;
                }
                
                ?>
                  <tr>
                    <th colspan="3">Discount <?php print $status_price." ".$stnb; ?></th>
                    <th style='text-align: right'>0</th>
                    <th style='text-align: right'><?php print number_format($tot_disc_price1, 2, ".", ",")?></th>
                  </tr>
                  <?php } 
                  $tot_disc_price = 0;
                  if($data->book->discount_tambahan){
                    if($data->book->st_discount_tambahan == 1){
                        $stnb_tambahan = "[Persen]";
                     $tot_disc_price =  (($total_debit * $data->book->discount_tambahan)/100);
                   }elseif($value->status_discount == 2) {
                       $stnb_tambahan = "[Nominal]";
                     $tot_disc_price = $data->book->discount_tambahan;
                   }   
                   ?>
                  <tr>
                    <th colspan="3">Discount Tambahan <?php print $data->book->discount_tambahan." ".$stnb_tambahan; ?></th>
                    <th style='text-align: right'>0</th>
                    <th style='text-align: right'><?php print number_format($tot_disc_price, 2, ".", ",")?></th>
                  </tr>
                  <?php } ?>
                  <tr>
                    <?php
                   // $ppn = (1 * (($total_debit + $total_debit2 + $data_tax)-$tot_disc_price1)/100);
                    ?>
                    <th colspan="3">PPN 1% </th>
                    <th style='text-align: right'><?php print $ppn; ?></th>
                    <th style='text-align: right'>0</th>
                  </tr>
                  <tr>
                    <th colspan="3">TOTAL</th>
                    <th style='text-align: right'><?php print number_format($total_debit + $total_debit2 + $data_tax , 2, ".", ",")?></th>
                    <th style='text-align: right'><?php print number_format(($total_kredit + $total_kredit2 + $tot_disc_price1 + $tot_disc_price), 2, ".", ",")?></th>
                  </tr>
                  <tr>
                    <th colspan="3">BALANCE</th>
                    <th></th>
                    <th style='text-align: right'><?php print number_format((((($total_debit + $total_debit2) - ($tot_disc_price1 + $tot_disc_price))  + $data_tax)-($total_kredit + $total_kredit2)), 2, ".", ",")?></th>
                  </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div> -->
  
  <div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Payment Detail [IDR]<br><!-- [1USD = <?php print number_format($data->currency_rate);?> IDR] --></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table table table-bordered">
                <tr>
                  <th>Tanggal</th>
                  <th>Status Payment</th>
                  <th>Payment</th>
                  <th>Note</th>
                  <th>Debit</th>
                  <th>Kredit</th>
                </tr>
                <?php
                $total_debit = $total_kredit = $total_debit2 = $total_kredit2 = 0 ;
                $status_payment = array(
                  1 => "Draft",
                  2 => "Deposit",
                  3 => "Not Paid",
                  8 => "Refund",
                );
                $channel = array(
                  1 => "Cash",
                  2 => "BCA",
                  3 => "Mega",
                  4 => "Mandiri",
                  5 => "CC",
                  6 => "Transfer"
                );
                foreach($data->payment AS $dp){
                  if($dp->no_deposit){
                    $dt_deposit = " [".$dp->no_deposit."]";
                  }else{
                    $dt_deposit = "";
                  }
                  if($dp->currency == 1){
                        $nom1 = $dp->nominal * $data->currency_rate;
                      }elseif($dp->currency == 2){
                        $nom1 = $dp->nominal;
                      }
                  if($dp->pos == 1){
                    $debit = number_format($nom1, 2, ".", ",");
                    $kredit = "";
                    $total_debit += $nom1;
                  }
                  else{
                    $kredit = number_format($nom1, 2, ".", ",");
                    $debit = "";
                    $total_kredit += $nom1;
                  }
                  
                  if($dp->status == 2 AND !$dp->no_deposit){
                    $dp->note = "<a href='javascript:void(0)' data-toggle='modal' data-target='#edit-no-deposit' isi='{$dp->id}' class='edit-deposit '>{$dp->note}</a>";
                  }
                  
                  
                  
                  print "<tr>"
                  . "<td>{$dp->tanggal}</td>"
                  . "<td>{$status_payment[$dp->status]}</td>"
                  . "<td>{$channel[$dp->status_payment] }</td>"
                  . "<td>{$dp->note}</td>"
                  . "<td style='text-align: right'>{$debit}</td>"
                  . "<td style='text-align: right'>{$kredit}</td>"
                  . "</tr>";
                }
                ?>
                <tfoot>
                  <tr>
                    <?php
                  
//                    if($data->tour->information->price->currency == "IDR"){
//                      $data_tax = ($total_person * $data->tour->information->price->tax_and_insurance);
//                    }elseif($data->tour->information->price->currency == "USD"){
//                      $data_tax = ($total_person * $data->tour->information->price->tax_and_insurance) * $data->currency_rate;
//                    }
                    
                    ?>
<!--                    <th colspan="3">Airport Tax & Flight Insurance</th>
                    <th style='text-align: right'><?php print number_format($data_tax,2,".",","); ?></th>
                    <th style='text-align: right'>0</th>-->
                  </tr>
                  
                   <?php
//                foreach($data->book->additional AS $add){
//                
//                  if($add->nominal_additional){
//                    if($add->id_currency == 1){
//                        $nom_add1 = $add->nominal_additional * $data->currency_rate;
//                      }elseif($add->id_currency == 2){
//                        $nom_add1 = $add->nominal_additional;
//                      }
//                    $nom_ad1 = "";
//                    $nom_ad2 = "";
//                    if($add->pos == 1){
//                      $nom_ad1 = $nom_add1;
//                      $total_kredit2 += $nom_add1;
//                    }else{
//                      $nom_ad2 = $nom_add1;
//                      $total_debit2 += $nom_add1;
//                    }
//                  print "<tr>"
//                    . "<th colspan='3'>{$add->name_additional}</th>"
//                    . "<th style='text-align: right'>".number_format($nom_ad2,2,".",",")."</th>"
//                      . "<th style='text-align: right'>".number_format($nom_ad1,2,".",",")."</th>"
//                  . "</tr>";
//                }}
                ?>
                 <?php
                  if($data->book->discount){
                 ?>
                  <?php 
                if($data->book->status_discount){
                $stnb = "[".$data->book->status_discount."]"; 
                }else{
                  $stnb = "";
                }
                
                $status_price1="";
                if($data->book->status_discount == "Persen"){
                  $status_price = $data->book->discount;
                  $tot_disc_price1 =  (($total_debit * $data->book->discount)/100);
                }elseif($data->book->status_discount == "Nominal") {
                 $tot_disc_price1 = number_format($data->book->status_discount,2,".",",");
                }
                
                ?>
                  <tr>
                    <td colspan="3">Discount <?php print $status_price." ".$stnb; ?></td>
                    <td style='text-align: right'>0</td>
                    <td style='text-align: right'><?php print number_format($tot_disc_price1, 2, ".", ",")?></td>
                  </tr>
                  <?php } 
                
                  $tot_disc_price = 0;
                  if($data->book->discount_tambahan){ 
                      if($data->book->st_discount_tambahan == 1){
                          $stnb_tambahan = "[Persen]";
                     $tot_disc_price =  (($total_debit * $data->book->discount_tambahan)/100);
                   }elseif($data->book->st_discount_tambahan == 2) {
                   
                       $stnb_tambahan = "[Nominal]";
                     $tot_disc_price = $data->book->discount_tambahan;
                   } 
                      
                      ?>
<!--                  <tr>
                    <td colspan="3">Discount Tambahan <?php print $data->book->discount_tambahan." ".$stnb_tambahan; ?></td>
                    <td style='text-align: right'>0</td>
                    <td style='text-align: right'><?php print number_format($tot_disc_price, 2, ".", ",")?></td>
                  </tr>-->
                  <?php } ?>
<!--                   <tr>
                     <?php
                    // $ppn = 1 *(($total_debit + $total_debit2 + $totl_visa)-$tot_disc_price1)/100;
                     ?>
                    <td colspan="4">PPN 1%</td>
                    <td style='text-align: right'><?php print number_format($ppn,2,".",","); ?></td>
                    <td style='text-align: right'>0</td>
                  </tr>-->
                  <tr>
                    <th colspan="4">TOTAL</th>
                    <th style='text-align: right'><?php print number_format(($total_debit), 2, ".", ",")?></th>
                    <th style='text-align: right'><?php print number_format(($total_kredit), 2, ".", ",")?></th>
                  </tr>
                  <tr>
                    <th colspan="4">BALANCE</th>
                    <th></th>
                    <th style='text-align: right'><?php print number_format(((($total_debit ))-($total_kredit)), 2, ".", ",")?></th>
                  </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
<?php
if($data->book->own_user == $this->session->userdata('email') OR in_array($this->session->userdata("id"), $approval_array) OR $this->session->userdata("id") == 1){
?>
  <div class="col-md-12">
     
    <?php
    $status_discount = array(
      1 => "<span class='label label-warning'>Request</span>",
      2 => "<span class='label label-success'>Approved</span>",
      3 => "<span class='label label-danger'>Rejected</span>",
    );
    $jumlah_add_aktif = $jumlah_diskon_aktif = "";
    foreach($discount AS $disc){
      $action = "";
      if($disc->status == 1 AND in_array($this->session->userdata("id"), $approval_array)){
//        $action = "<a class='btn btn-success btn-sm' id='req-approved' isi='{$disc->id_product_tour_discount_tambahan}'>Approve</a>"
//          . " <a class='btn btn-danger btn-sm' id='req-rejected' isi='{$disc->id_product_tour_discount_tambahan}'>Reject</a>";
      }
      if($disc->status == 1)
        $jumlah_diskon_aktif++;
      $tampil_diskon .= "<tr>"
       . "<td>".nl2br($disc->note)."</td>"
       . "<td style='text-align: right'>".  number_format($disc->discount_request)."</td>"
       . "<td>{$disc->request}</td>"
       . "<td>{$disc->approval}</td>"
       . "<td>{$status_discount[$disc->status]}</td>"
       . "<td>{$action}</td>"
      . "</tr>";
    }
    
    $pos = array(1 => "Penambahan Biaya",
            2 => "Pengurangan Biaya");
    foreach($data->book->additional AS $add){
//      $link_additional_approval = site_url("grouptour/product-tour/additional-request/1/".$data->book->code."/".$add->kode);
//      $link_additional_reject = site_url("grouptour/product-tour/additional-request/2/".$data->book->code."/".$add->kode);
      if($add->code_status == 1)
        $jumlah_add_aktif++;
      $ad2 .= "<tr>"
        . "<td>{$add->name_additional}</td>"
        . "<td>{$pos[$add->pos]}</td>"
        . "<td> IDR ".number_format($add->nominal_additional,0,",",".")."</td>"
        . "<td>{$add->user_pengaju}</td>"
        . "<td>{$add->user_approval}</td>"
        . "<td>{$add->status}</td>";
        if($add->status == "Pengajuan"){
//        $ad2 .= "<td><a href='{$link_additional_approval}' class='btn btn-primary'>Approve</a> <a href='{$link_additional_reject}' class='btn btn-danger'>Reject</a></td>";
        }
        $ad2 .= "</tr>";
    }
    ?>
    
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
              <li class="active"><a href="#log_discount_tour" data-toggle="tab">Request Discount <span class="label label-success"><?php print $jumlah_diskon_aktif?></span></a></li>
              <li><a href="#log_additional" data-toggle="tab">Request Additional <span class="label label-success"><?php print $jumlah_add_aktif?></span></a></li>
          </ul>
          <div class="tab-content">
              <div class="tab-pane active" id="log_discount_tour">
                <table class="table table-condensed">
                <tr>
                  <th>Note</th>
                  <th>Nominal</th>
                  <th>User Request</th>
                  <th>User Approval</th>
                  <th>Status</th>
                  <th></th>
                </tr>
                
               <?php
               
               print $tampil_diskon;
//               print "<tr>"
//                  . "<td>".$this->form_eksternal->form_input('note_req_disk', "", 'id="note-req-disk" class="form-control input-sm " placeholder="Note"')."</td>"
//                  . "<td style='text-align: right'>".$this->form_eksternal->form_input('nominal_req_disk', "", 'id="nominal-req-disk" class="form-control input-sm " placeholder="Nominal"')."</td>"
//                  . "<td>".$this->form_eksternal->form_input('st_usr', $data->book->status, 'style ="display:none" id="usr-status2" class="form-control input-sm" placeholder=""')."</td>"
//                  . "<td></td>"
//                  . "<td></td>"
//                  . "<td><a class='btn btn-info btn-sm' id='req-discount'>Submit</a></td>"
//                 . "</tr>";
               ?>
            </table> 
                
                  <div class="box">
        <div class="box box-success">
                               <?php
                            
             foreach($log_history_discount AS $sld){
                if($sld->status == 1){
                 $dta_cls = "class='online'";
                }else{
                   $dta_cls = "class='offline'";
                }
                  ?>
                   <div class="box-body chat" id="chat-box">
                                    <!-- chat item -->
                                    <div class="item">
                                        <img src="<?php print base_url("themes/lte/img/no-pic.png");?>" alt="user image" <?php print $dta_cls; ?> />
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php print date("d M Y H:m:i", strtotime($sld->tanggal)); ?></small>
                                                <?php
                                                $name_user = $this->global_models->get_field("m_users", "name", array("id_users" => $sld->id_users));
       
                                                print $name_user; ?>
                                            </a>
                                           <?php print $sld->note; ?>
                                        </p>
                                    </div>
                                   
                                </div>
                   <?php
                   $no++;
                }
                ?>
<!--                                <div class="box-footer">
                                    <div class="input-group">
                                        <input class="form-control" name="note_tour" placeholder="Type message..."/>
                                      
                                        <div class="input-group-btn">
                                            <input class="btn btn-success" type="submit" name="request_dicount_tour" value="Submit"></input>

                                        </div>
                                    </div>
                                </div>-->
                            </div>
    </div>
                 
              </div>
              <div class="tab-pane" id="log_additional">
        
      <table class="table table-condensed">
                <tr>
                  <th>Additional</th>
                  <th>Type</th>
                  <th>Nominal</th>
                  <th>User Pengaju</th>
                  <th>User Approval</th>
                  <th>Status</th>
                  <th></th>
                </tr>
               <?php
                print $ad2;
                ?>
               
            </table>    <br><br>
                 <div class="box">
        <div class="box box-success">
                               <?php
                    $no = 1;           
             foreach($data->log_request_additional AS $lra){
                if($no % 2 == 0){
                 $dta_cls = "class='online'";
                }else{
                   $dta_cls = "class='offline'";
                }
                  ?>
                   <div class="box-body chat" id="chat-box">
                                    <!-- chat item -->
                                    <div class="item">
                                        <img src="<?php print base_url("themes/lte/img/no-pic.png");?>" alt="user image" <?php print $dta_cls; ?> />
                                        <p class="message">
                                            <a href="#" class="name">
                                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php print date("d M Y H:m:i", strtotime($lra->tanggal)); ?></small>
                                                <?php print $lra->name; ?>
                                            </a>
                                           <?php print nl2br($lra->text); ?>
                                        </p>
                                    </div>
                                   
                                </div>
                   <?php
                   $no++;
                }
                ?>
<!--                                <div class="box-footer">
                                    <div class="input-group">
                                        <input class="form-control" name="note_additional_tour" placeholder="Type message..."/>
                                      
                                        <div class="input-group-btn">
                                            <input class="btn btn-success" type="submit" name="request_additional_tour" value="Submit"></input>

                                        </div>
                                    </div>
                                  
                                </div>-->
                            </div>
    </div>
               
                </div>
          </div>
      </div>
  </div>
<?php }?>

  <!--
  <div class="col-md-7">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">History Request Discount</h3>
        </div>
        <div class="box-body">
          
          <table class="table table-condensed">
               <tr>
                  <th>Log</th>
                  <th>Note</th>
                  <th>Discount</th>
                  <th>Users</th>
                  <th>Status</th>
                </tr>
                <?php
               $log_status = array(1 => "Default",
                                    2 => "Pengajuan User",
                                    3 => "Revisi Admin",
                                    4 => "Approval Admin",
                                    5 => "Approval User");
            
             foreach($data->log_request_discount AS $sld){
                  
                 print "<tr>"
                    . "<td>{$sld->kode}</td>"
                    . "<td>{$sld->text}</td>"
                    . "<td>{$sld->discount}</td>"
                    . "<td>{$sld->name}</td>"
                    . "<td>{$log_status[$sld->status]}</td>"
                  . "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
  </div>
  <div class="col-md-5">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Request Discount</h3>
        </div>
        <div class="box-body">
          <table class="table table-condensed">
            
                <tr>
                  <th>Note</th>
                  <td><?php print $this->form_eksternal->form_textarea('note', "", 'class="form-control input-sm" id="Note"')?></td>
                </tr>
                <tr>
                  <th>Discount</th>
                  <td><?php print $this->form_eksternal->form_input('discount', "", 'class="form-control input-sm" placeholder="Nominal Discount"');?></td>
                </tr>
                <tr>
                  <?php
                  if($data->book->status_log_discount == 4){
                  ?>
                  <th><input class="btn btn-primary" type="submit" name="approval" value="Approval"></input></th>
                  <?php } ?>
                  <td><input class="btn btn-primary" type="submit" name="request_dicount" value="Submit"></input></td>
                </tr>
            </table>
        </div>
    </div>
  </div> -->
</div>

</form>
