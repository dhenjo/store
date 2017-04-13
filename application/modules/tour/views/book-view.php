<?php
$room_type = array("1" => "Adult Triple/ Twin",
                            "2"  => "Child Twin Bed",
                            "3" => "Child Extra Bed",
                            "4" => "Child No Bed",
                            "5" => "Adult Single",
                        );
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
 <li><a href="#ttu" data-toggle="tab" id="hide-info">TTU</a></li>
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
                <tr>
                  <th>Start Date</th>
                  <td><?php print date("d F Y", strtotime($data->tour->information->start_date))?></td>
                </tr>
                <tr>
                  <th>End Date</th>
                  <td><?php print date("d F Y", strtotime($data->tour->information->end_date))?></td>
                </tr>
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
                  
                 $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                  print "<b>".$status[$data->book->status]." For ".$total_person." Person </b>";
                  print "<b>".$st_book.$st_commit.$st_lunas.$st_cancel.$st_wtapp."</b>";
                  ?></td>
                </tr>
                <tr>
                  <th>TC</th>
                  <td><?php print $data->book->agent?></td>
                </tr>
                <tr>
                  <th>Store</th>
                  <td><?php print $data->book->store?></td>
                </tr>
               <tr>
                  <th></th>
                                
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
                  if($dbp->room == $k){ ?>
         <?php
//         if($dbp->type->code == 1){
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
                  if($dbp->cstatus != 4){
                  ?>
                <div class="box-body">    
                    <div class="col-md-12">
                      <div class="control-group">
                        <label>Visa </label>
                        <div class="input-group">
                          <div class="checkbox">
                                  <?php
                                  if($dbp->visa)
                                    $ceknya = TRUE;
                                  else
                                    $ceknya = FALSE;
                                    print $this->form_eksternal->form_checkbox('visa_adl[]', 1, $ceknya);
                                    print $this->form_eksternal->form_input('visa_adl_nom[]', $data->tour->information->price->visa, "style='display: none'");
                                    print " ".number_format($data->tour->information->price->visa,0,".",",");
                                    print " Centang Jika Memerlukan Jasa Pembuatan. Harga Dapat Berubah Sewaktu-waktu";
                                  ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                    if($dbp->less_ticket){
                  ?>
                    <div class="col-md-12">
                      <div class="control-group">
                        <label>Less Ticket </label>
                        <div class="input-group">
                          <div class="checkbox">
                                  <?php
                                    print $this->form_eksternal->form_checkbox('less_ticket_adl[]', 1, TRUE);
                                    print " Tidak Menggunakan Tiket. Pengurangan Harga Ditetapkan oleh Operasional Tour";
                                  ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php }?>
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
                        <label>Cancel</label>
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
       <?php      
                    $no++;
                }}
                ?>
       </div>
              <?php } ?>
              
            <?php  } ?>
     <div class="tab-pane" id="ttu">
     <div class="box-body table-responsive">
      <table id="table-ttue" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Date</th>
            <th>No TTU</th>
            <th>Agent</th>
            <th>Checker</th>
            <th>Status</th>
            <th>Nominal</th>
            <th>Option</th>
          </tr>
        </thead>
        <tbody>
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
            else if($dp->status != 3){
              $kredit = number_format($nom1, 2, ".", ",");
              $debit = "";
              $total_kredit += $nom1;
            }

            if($dp->status == 2 AND !$dp->no_deposit){
              $dp->note = "<a href='javascript:void(0)' data-toggle='modal' data-target='#edit-no-deposit' isi='{$dp->id}' class='edit-deposit' >{$dp->note}</a>";
            }
            if($dp->status != 3){
              $payment_all .= "<tr>"
              . "<td>{$dp->tanggal}</td>"
              . "<td>{$status_payment[$dp->status]}</td>"
              . "<td>{$channel[$dp->status_payment] }</td>"
              . "<td>{$dp->note}</td>"
              . "<td style='text-align: right'>{$debit}</td>"
              . "<td style='text-align: right'>{$kredit}</td>"
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
                . "<td>".$this->global_models->get_field("m_users", "name", array("id_users" => $dp->checker))."</td>"
                . "<td>{$status_paid[$dp->status]}</td>"
                . "<td style='text-align: right'>".number_format($dp->nominal)."</td>"
                . "<td>"
                  . "<a href='".site_url("store/print-store/ttu/{$dp->id}")."' target='_blank' class='btn btn-warning'>"
                    . "<i class='fa fa-search'></i>"
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
            <td colspan="9">
              <a href="<?php print site_url("grouptour/product-tour/payment-book/".$data->book->code)?>" class='btn btn-success'>
                <i class='fa fa-plus-square'></i>
              </a>
            </td>
          </tr>
        </tfoot>
      </table>
     </div>
    </div>
   </div><!-- /.tab-content -->
       </div>
          
        </div>
    </div>
  </div>
  
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
                  if($dp->status != 3){
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
                      $dp->note = "<a href='javascript:void(0)' data-toggle='modal' data-target='#edit-no-deposit' isi='{$dp->id}' class='edit-deposit' >{$dp->note}</a>";
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
                }
                ?>
                <tfoot>
                  <tr>
                  </tr>
                  
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

                  <?php } ?>

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
        $action = "<a class='btn btn-success btn-sm' id='req-approved' isi='{$disc->id_product_tour_discount_tambahan}'>Approve</a>"
          . " <a class='btn btn-danger btn-sm' id='req-rejected' isi='{$disc->id_product_tour_discount_tambahan}'>Reject</a>";
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
      if($add->code_status == 1)
        $jumlah_add_aktif++;
      $ad2 .= "<tr>"
        . "<td>{$add->name_additional}</td>"
        . "<td>{$pos[$add->pos]}</td>"
        . "<td> IDR ".number_format($add->nominal_additional,0,",",".")."</td>"
        . "<td>{$add->user_pengaju}</td>"
        . "<td>{$add->user_approval}</td>"
        . "<td>{$status_discount[$add->code_status]}</td>";
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
               
                </div>
          </div>
      </div>
  </div>
</div>