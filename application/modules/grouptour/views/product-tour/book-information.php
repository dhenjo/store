<?php
//print $data->payment[1]->pos;
//print $this->session->userdata("email");
//print "<pre>";
//print_r($data);
//print "</pre>";
//die;
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

<?php
              $airlines = "";
              if($data->tour->airlines){
              $airlines = $data->tour->airlines;    
              }
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
             <li><a href="javascript:void(0)" id="print-itinerary-detail"><i class="fa fa-print"></i> Print itinerary</a></li>
            <!--<li><a href="http://localhost/app/bersih/store/menu/menu-cache"><i class="fa fa-envelope"></i> Send Email</a></li>-->
          </ul>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="nav-tabs-custom">
 <ul class="nav nav-tabs">
   <li class='active' ><a href="#tour_detail" data-toggle="tab" class="show-info">Tour Detail</a></li>
   <li><a href="#info" data-toggle="tab" class="show-info">Contact Person</a></li>
   <li><a href="#pax-view" data-toggle="tab" class="show-info">Passanger</a></li>
   <li><a href="#ttu" data-toggle="tab" id="hide-info">TTU</a></li>
<?php
if($history_void[0]->name){
?> 
   <li><a href="#history-void" data-toggle="tab" id="history-void-payment">History Void Payment</a></li>
<?php } ?>  
 </ul>
   <div class="tab-content">
     <div class="tab-pane active" id="tour_detail">
                <table class="table table-condensed">
                <tr>
                  <th>Title</th>
                  <td><?php print $data->tour->title; ?></td>
                </tr>
                 <tr>
                  <th>Tour Schedule Code</th>
                  <td><?php print $data->tour->information->code; ?></td>
                </tr>
                <tr>
                  <th>Airlines</th>
                  <td><?php print $airlines; ?></td>
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
                  
                 $nobook = $nocommit = $nolunas = $nocancel = $wt_app = $cancel_depo = $change_wp = $change_cancel = 0;
                  
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
                    }elseif($valps->status == "[Change Tour] Waiting Approval"){
                      $change_wp2 += $change_wp+1;
                    }elseif($valps->status == "[Cancel] Change Tour"){
                      $change_cancel2 += $change_cancel+1;
                    }elseif($valps->status == "Reject Change Tour"){
                      $change_reject2 += $change_reject+1;
                    }
                  }
                  
                    if($nobook2 > 0){
                    $st_book = "<span class='label label-info'>Book For ".$nobook2." Person </span><br>";
                  }
                  if($nocommit2 > 0){
                    $st_commit = "<span class='label label-info'>Deposit For ".$nocommit2." Person</span><br>";
                  }
                  if($nolunas2 > 0){
                    $st_lunas = "<span class='label label-success'>Lunas For ".$nolunas2." Person</span><br>";
                  }
                  if($nocancel2 > 0){
                    $st_cancel = "<span class='label label-danger'>Cancel For ".$nocancel2." Person</span><br>";
                  }
                  if($wt_app2 > 0){
                    $st_wtapp = "<span class='label label-warning'>[Cancel] Waiting Approval For ".$wt_app2." Person</span><br>";
                  }
                  if($cancel_depo2 > 0){
                    $st_cancel_depo = "<span class='label label-danger'><span class='label label-danger'>[Cancel] Deposit For ".$cancel_depo2." Person</span><br>";
                  }
                  if($change_wp2 > 0){
                    $st_change_wp = "<span class='label label-warning'>[Change Tour] Waiting Approval For ".$change_wp2." Person</span><br>";
                  }
                  if($change_cancel2 > 0){
                    $st_change_cancel = "<span class='label label-danger'>[Cancel] Change Tour For ".$change_cancel2." Person</span><br>";
                  }
                  if($change_reject2 > 0){
                    $st_change_reject = "<span class='label label-danger'>Reject Change Tour For ".$change_reject2." Person</span><br>";
                  }
				  
                 $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                  print "<b>".$status[$data->book->status]." For ".$total_person." Person </b>";
                  print "<b>".$st_book.$st_commit.$st_lunas.$st_cancel.$st_wtapp.$st_cancel_depo.$st_change_wp.$st_change_cancel.$st_change_reject."</b>";
                  ?></td>
                </tr>
                
               <tr>
                  <th></th>
                  <td>
                    <?php
                    if($data->book->own_user == $this->session->userdata('email') OR in_array($this->session->userdata("id"), $approval_array) OR $this->session->userdata("id") == 1){
                    ?>
                    <a href="<?php print site_url("grouptour/product-tour/payment-book/".$data->book->code)?>" class="btn btn-primary"><?php print lang("Payment")?></a>
                    <a href="<?php print site_url("grouptour/product-tour/refund-book/".$data->book->code)?>" class="btn btn-info"><?php print lang("Refund")?></a>
                    <a href="<?php print site_url("tour/harga-all-in/".$data->book->code)?>" class="btn btn-warning"><?php print lang("Harga All In")?></a>
					<?php if($this->session->userdata("id") == 1){ ?>
					<a href="<?php print site_url("tour/adjust-harga/".$data->book->code)?>" class="btn btn-warning"><?php print lang("Adjust Harga")?></a>
                   <!-- <a href="<?php print site_url("grouptour/generate-price/index/".$data->book->code)?>" class="btn btn-info"><?php print lang("Generate Total Harga visa tanpa ppn")?></a> -->
					<a href="<?php print site_url("grouptour/generate-price/ppn/".$data->book->code)?>" class="btn btn-info"><?php print lang("Generate Total Harga Dengan PPN")?></a>
                   <?php } ?> 
					<?php }?>
                  </td>                  
                </tr>
                <tr style="display:none">
                  <th></th>
                  
                  <?php if($data->book->status == 1 ){?>
                  <td><input class="btn btn-primary" type="submit" name="committed_book" value="Committed Book"></input></td>
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
                <?php if($data->book->own_user == $this->session->userdata('email')){?>
                <tr>
                    <th><a href='javascript:void(0)' data-toggle='modal' data-target='#edit-contact-person' class='btn btn-primary'>EDIT</a></th>
                  <td></td>
                </tr>
                <?php } ?>
              
            </table>
       </div>
    <div class="tab-pane" id="pax-view">
     <div class="box-body table-responsive">
      <table id="table-pax" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Room</th>
            <th>Type Bed</th>
            <th>Name</th>
            <th>Telp</th>
            <th>No Passport</th>
            <th>Visa</th>
            <th>Ticket</th>
            <th>Status</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $status_visa = array(
            NULL => "<span class='label label-danger'>Tidak Menggunakan</span>",
            0 => "<span class='label label-danger'>Tidak Menggunakan</span>",
            1 => "<span class='label label-success'>Jasa Pengurusan</span>",
            2 => "<span class='label label-success'>Jasa Pengurusan</span>",
            3 => "<span class='label label-success'>Jasa Pengurusan</span>",
          );
          $status_ticket = array(
            NULL => "<span class='label label-success'>Ticket</span>",
            0 => "<span class='label label-success'>Ticket</span>",
            1 => "<span class='label label-danger'>Less Ticket</span>",
            2 => "<span class='label label-danger'>Less Ticket</span>",
            3 => "<span class='label label-danger'>Less Ticket</span>",
          );
          $cstatus = array(
            1 => "<span class='label label-warning'>Book</span>",
            2 => "<span class='label label-info'>Deposit</span>",
            3 => "<span class='label label-success'>Lunas</span>",
            4 => "<span class='label label-draft'>Cancel</span>",
            5 => "<span class='label label-danger'>Cancel Deposit</span>",
            6 => "<span class='label label-danger'>Proses Cancel</span>",
          );
          foreach($data->book->passenger AS $dbp){
            if($data->book->own_user == $this->session->userdata("email") OR $this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "edit-book", "edit") !== FALSE){
              $btn_pax = "<button type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-pax' isi='{$dbp->customer_code}'>"
                  . "<i class='fa fa-edit'></i>"
                . "</button>"
               . "<a type='button' class='btn btn-info' href='".site_url("grouptour/product-tour/change-tour-person/{$dbp->customer_code}")."'>"
                  . "<i class='fa fa-exchange'></i>"
                . "</a>"
                . "<button type='button' class='btn btn-danger tour-delete' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$dbp->customer_code}' class='btn btn-danger' id='id-customer-cancel'>"
                  . "<i class='fa fa-times'></i>"
                . "</button>";
            }
            else{
              $btn_pax = "";
            }
            
            if($dbp->cstatus > 3){
              $btn_pax = "";
            }
            print "<tr>"
              . "<td>{$dbp->room}</td>"
              . "<td>{$room_type[$dbp->type->code]}</td>"
              . "<td>{$dbp->first_name} {$dbp->last_name}</td>"
              . "<td>{$dbp->telphone}</td>"
              . "<td>{$dbp->no_passport}</td>"
              . "<td>{$status_visa[$dbp->visa]}</td>"
              . "<td>{$status_ticket[$dbp->less_ticket]}</td>"
              . "<td>{$cstatus[$dbp->cstatus]}</td>"
              . "<td>"
                . "<div class='btn-group'>"
                . $btn_pax  
                . "</div>"
              . "</td>"
            . "</tr>";
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="9">
              <button type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-pax' isi=''>
                <i class='fa fa-plus-square'></i>
              </button>
            </td>
          </tr>
        </tfoot>
      </table>
     </div>
    </div>
    <div class="tab-pane" id="ttu">
     <div class="box-body table-responsive">
      <table id="table-ttue" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>No TTU</th>
            <th>Agent</th>
            <th>Status</th>
            <th>Nominal</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_debit = $total_kredit = $total_debit2 = $total_kredit2 = 0 ;
          $status_payment = array(
            1 => "<span class='label label-warning'>Draft</span>",
            2 => "<span class='label label-success'>Deposit</span>",
            3 => "<span class='label label-warning'>Not Paid</span>",
            4 => "<span class='label label-success'>Confirm</span>", 
            8 => "<span class='label label-info'>Refund</span>",
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
            else if($dp->status != 3){
              $kredit = number_format($nom1, 2, ".", ",");
              $debit = "";
              $total_kredit += $nom1;
            }
            
            if($dp->status == 2 AND !$dp->no_deposit){
              $dp->note = "<a href='javascript:void(0)' data-toggle='modal' data-target='#edit-no-deposit' isi='{$dp->id}' class='edit-deposit' >{$dp->note}</a>";
            }
            $delete ="";
            if($data->book->status <=3){
            if($dp->status != 4 AND $dp->status >= 2 AND $dp->status <= 6){
                if($data->book->own_user == $this->session->userdata("email")){
                $delete = "<a href='javascript:void(0)' data-toggle='modal' data-target='#payment-cancel' isi='{$dp->id}' class='btn btn-danger payment-void2'><i class='fa fa-trash-o'></i></a>";
            
                }
            }
            }
            
            if($dp->status != 3){
              $payment_all .= "<tr>"
              . "<td>{$dp->tanggal}</td>"
              . "<td>{$status_payment[$dp->status]}</td>"
              . "<td>{$channel[$dp->status_payment] }</td>"
              . "<td>{$dp->note}</td>"
              . "<td style='text-align: right'>{$debit}</td>"
              . "<td style='text-align: right'>{$kredit}</td>"
              . "<td>{$delete}</td>"
              . "</tr>";
            }
            
            if(($dp->status == 2 OR $dp->status == 3 OR $dp->status == 4)AND $dp->pos == 2){
              $status_paid = array(
                2 => "<label class='label label-primary'>Payment</label>",
                3 => "<label class='label label-danger'>Reject</label>",
                4 => "<label class='label label-success'>Confirm</label>",
              );
              
              print ""
              . "<tr>"
                . "<td>{$dp->tanggal}</td>"
                . "<td>{$dp->no_ttu} <br />{$dp->no_deposit}</td>"
                . "<td>".$this->global_models->get_field("m_users", "name", array("id_users" => $dp->agent))."</td>"
                . "<td>{$status_paid[$dp->status]}</td>"
                . "<td style='text-align: right'>".number_format($dp->nominal)."</td>"
                . "<td>"
                  . "<a href='".site_url("store/print-store/ttu/{$dp->id}")."' target='_blank' class='btn btn-warning'>"
                    . "<i class='fa fa-search'></i>"
                  . "</a>"
                  . "<a href='".site_url("store/print-store/ttu-kwitansi/{$dp->id}")."' target='_blank' class='btn btn-info'>"
                    . "<i class='fa fa-print'></i>"
                  . "</a>"
                  . "<a href='".site_url("tour/tour-payment/ttu/{$dp->id}")."' class='btn btn-success'>"
                    . "<i class='fa fa-money'></i>"
                  . "</a>"
                . "</td>"
              . "</tr>"
              . "";
            }
          }
          ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6">
              <a href="<?php print site_url("grouptour/product-tour/payment-book/".$data->book->code)?>" class='btn btn-success'>
                <i class='fa fa-plus-square'></i>
              </a>
            </td>
          </tr>
        </tfoot>
      </table>
     </div>
    </div>
<?php
if($history_void[0]->name){
?>   
    <div class="tab-pane" id="history-void">
            <?php $this->load->view('history-payment'); ?>
    </div> 
<?php } ?>       
   </div>
       </div>
          
        </div>
    </div>
  </div>
 
  <div class="col-md-12 box-khusus">
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
                  <th></th>
                </tr>
                <?php
                print $payment_all;
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
                    <th></th>
                  </tr>
                  <tr>
                    <th colspan="4">BALANCE</th>
                    <th></th>
                    <th style='text-align: right'><?php print number_format(((($total_debit ))-($total_kredit)), 2, ".", ",")?></th>
                    <th></th>
                  </tr>
                </tfoot>
            </table>
        </div>
    </div>
  </div>
<?php
if($data->book->own_user == $this->session->userdata('email') OR in_array($this->session->userdata("id"), $approval_array) OR $this->session->userdata("id") == 1){
?>
  <div class="col-md-12 box-khusus">
     
    <?php
	$img5 =$url."img/ajax-loader.gif";
    $status_discount = array(
      1 => "<span class='label label-warning'>Request</span>",
      2 => "<span class='label label-success'>Approved</span>",
      3 => "<span class='label label-danger'>Rejected</span>",
    );
    $jumlah_add_aktif = $jumlah_diskon_aktif = "";
    foreach($discount AS $disc){
      $action = "";
      if($disc->status == 1 AND in_array($this->session->userdata("id"), $approval_array)){
        $action = "<a class='btn btn-success btn-sm' id='req-approved' isi='{$disc->id_product_tour_discount_tambahan}'>Approve</a>"
          . " <a class='btn btn-danger btn-sm' id='req-rejected' isi='{$disc->id_product_tour_discount_tambahan}'>Reject</a>"
		   . "<img src='{$img5}' style='display:none' id='img-5' alt=''>";
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
      $link_additional_approval = site_url("grouptour/product-tour/additional-request/1/".$data->book->code."/".$add->kode);
      $link_additional_reject = site_url("grouptour/product-tour/additional-request/2/".$data->book->code."/".$add->kode);
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
         $ad2 .= "<td><a href='{$link_additional_approval}' class='btn btn-primary' id='disc-ap'>Approve</a> <a href='{$link_additional_reject}' class='btn btn-danger' id='disc-rj'>Reject</a></td><td><img src='{$img5}' style='display:none' id='img-disc' alt=''></td>";
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
               print "<tr>"
                  . "<td>".$this->form_eksternal->form_input('note_req_disk', "", 'id="note-req-disk" class="form-control input-sm " placeholder="Note"')."</td>"
                  . "<td style='text-align: right'>".$this->form_eksternal->form_input('nominal_req_disk', "", 'id="nominal-req-disk" class="form-control input-sm " placeholder="Nominal"')."</td>"
                  . "<td>".$this->form_eksternal->form_input('st_usr', $data->book->status, 'style ="display:none" id="usr-status2" class="form-control input-sm" placeholder=""')."</td>"
                  . "<td></td>"
                  . "<td></td>"
                  . "<td><a class='btn btn-info btn-sm' id='req-discount'>Submit</a></td>"
				  . "<td><img src='{$img5}' style='display:none' id='img-req-disc' alt=''></td>"
                 . "</tr>";
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
                                <div class="box-footer" class="box-khusus">
                                    <div class="input-group">
                                        <input class="form-control" name="note_tour" placeholder="Type message..."/>
                                      
                                        <div class="input-group-btn">
                                            <input class="btn btn-success" type="submit" name="request_dicount_tour" value="Submit"></input>

                                        </div>
                                    </div>
                                </div>
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
                                <div class="box-footer">
                                    <div class="input-group">
                                        <input class="form-control" name="note_additional_tour" placeholder="Type message..."/>
                                      
                                        <div class="input-group-btn">
                                            <input class="btn btn-success" type="submit" name="request_additional_tour" value="Submit"></input>

                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
    </div>
               
                </div>
          </div>
      </div>
  </div>
<?php }?>

  
</div>

</form>
<div class="modal fade" id="edit-no-deposit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> No Deposit</h4>
            </div>
            <form action="<?php print site_url("grouptour/product-tour/ubah-deposit")?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">No Deposit:</span>
                            <input name="id_payment" class="form-control" id="id_payment" style="display: none">
                            <input name="book_code" class="form-control" value="<?php print $book_code?>" style="display: none">
                            <input name="new_deposit" class="form-control" placeholder="No Deposit">
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                    <button type="submit" class="btn btn-primary pull-left"> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="payment-cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Note Void</h4>
            </div>
            <form action="<?php print site_url("store/payment-void")?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
<!--                            <span class="input-group-addon">Note Cancel:</span>-->
                            <input name="id_payment" class="form-control" id="dt_id_payment" style="display: none">
                            <input name="book_code" class="form-control" value="<?php print $book_code; ?>" style="display: none">
                            <textarea name="note_cancel" placeholder="Note Void" style="margin: 0px; width: 553px; height: 227px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                    <button type="submit" class="btn btn-primary pull-left"> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="edit-keterangan-cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Note Cancel</h4>
            </div>
            <form action="<?php print site_url("store/cancel-tour-per-pax")?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
<!--                            <span class="input-group-addon">Note Cancel:</span>-->
                            <input name="customer_code" class="form-control" id="dt_id_customer_book" style="display: none">
                            <input name="book_code" class="form-control" value="<?php print $book_code?>" style="display: none">
                            <textarea name="note_cancel" placeholder="Note Cancel" style="margin: 0px; width: 553px; height: 227px;"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>

                    <button type="submit" class="btn btn-primary pull-left"> Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="edit-detail-pax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Pax</h4>
            </div>
            <form action="<?php print site_url("store/edit-book-pax")?>" method="post">
              <div class="box-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Visa</label>
                      <?php print $this->form_eksternal->form_dropdown('visa', array(1 => "Membutuhkan Jasa Pengurusan ".number_format($data->tour->information->price->visa,0,".",","),NULL => "Tidak Membutuhkan"), array(), 'id="edit-visa" class="form-control input-sm"');
                      print $this->form_eksternal->form_input('code', "", "id='edit-code' class='form-control' style='display: none'");
                      print $this->form_eksternal->form_input('book_code', $data->book->code, "class='form-control' style='display: none'");
                      print " <span id='visa-info'>".number_format($data->tour->information->price->visa,0,".",",")."</span>";
                      print " Harga Dapat Berubah Sewaktu-waktu";
                      ?>
                    </div>
                    <div class="col-xs-12" id="tampilan-less-ticket">
                      <label>Less Ticket</label>
                      <?php print $this->form_eksternal->form_dropdown('less_ticket', array(NULL => "Ticket", 1 => "Less Ticket"), array(), 'id="edit-less-ticket" class="form-control input-sm"');
                      print " <span id='less-ticket-info'>".number_format($data->tour->information->price->less_ticket,0,".",",")."</span>";
                      print " Harga Dapat Berubah Sewaktu-waktu";
                      ?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Room</label>
                      <?php print $this->form_eksternal->form_input('room', "", 'id="edit-room" class="form-control input-sm" placeholder="Room"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Bed Type</label>
                      <?php print $this->form_eksternal->form_dropdown('type', $room_type, array(), 'id="edit-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('first_name', "", 'id="edit-first-name" class="form-control input-sm" placeholder="Nama Depan"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('last_name', "", 'id="edit-last-name" class="form-control input-sm" placeholder="Nama Belakang"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('telp', "", 'class="form-control input-sm" id="edit-telp" placeholder="No Telp"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Tempat Lahir</label>
                      <?php print $this->form_eksternal->form_input('tempat_lahir', "", 'id="edit-tempat-lahir" class="form-control input-sm" placeholder="Place Of Birth"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Tanggal Lahir</label>
                      <?php print $this->form_eksternal->form_input('tanggal_lahir', "", 'id="edit-tanggal-lahir" class="form-control input-sm child_date" placeholder="Tanggal Lahir"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Passport</label>
                      <?php print $this->form_eksternal->form_input('passport', "", 'id="edit-passport" class="form-control input-sm" placeholder="No Passport"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Place Of Issued</label>
                      <?php print $this->form_eksternal->form_input('place_of_issued', "", 'id="edit-place-of-issued" class="form-control input-sm" placeholder="Place Of Issue"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Date Of Issued</label>
                      <?php print $this->form_eksternal->form_input('date_of_issued', "", 'id="edit-date-of-issued" class="form-control input-sm passport" placeholder="Date Of Issued"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Date Of Expired</label>
                      <?php print $this->form_eksternal->form_input('date_of_expired', "", 'id="edit-date-of-expired" class="form-control input-sm passport" placeholder="Date Of Expired"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="edit-note" class="form-control input-sm" placeholder="Note"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-primary pull-left"> Submit</button>
              </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php if($data->book->own_user == $this->session->userdata('email')){ ?>
<div class="modal fade" id="edit-contact-person" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Contact Person</h4>
            </div>
            <form action="<?php print site_url("store/edit-contact-person")?>" method="post">
              <div class="box-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('efirst_name', $data->book->first_name, 'id="efirst_name" class="form-control input-sm" placeholder="First Name"');?>
                      <?php print $this->form_eksternal->form_input('ebook_code', $data->book->code, "class='form-control' style='display: none'");
                      ?>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('elast_name', $data->book->last_name, 'id="elast_name" class="form-control input-sm" placeholder="Last Name"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Email</label>
                      <?php print $this->form_eksternal->form_input('e_email', $data->book->email, 'id="e_email" class="form-control input-sm" placeholder="Email"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('etelp', $data->book->telphone, 'class="form-control input-sm" id="etelp" placeholder="No Telp"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Address</label>
                      <?php print $this->form_eksternal->form_textarea('eaddress', $data->book->address, 'id="eaddress" class="form-control input-sm" placeholder="Address"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>Cancel</button>
                <button type="submit" class="btn btn-primary pull-left"> Submit</button>
              </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php } ?>