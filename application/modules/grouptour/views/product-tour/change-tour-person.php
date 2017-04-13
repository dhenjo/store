<?php
//print "<pre>";
//print_r($data);
//print "</pre>";
?>
<div class="row">
  <div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Passenger Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="nav-tabs-custom">
 <ul class="nav nav-tabs">
   <li class='active' ><a href="#tour_info" data-toggle="tab">Tour Detail</a></li>
   <li><a href="#info" data-toggle="tab">Contact Person</a></li>
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
 <li><a href="#price" data-toggle="tab">Price Detail</a></li>
 </ul>
   <div class="tab-content">
     <div class="tab-pane active" id="tour_info">
          <table class="table table-condensed">
                <tr>
                  <th>Name Tour</th>
                  <td><?php print $data->tour->title?></td>
                </tr>
                <tr>
                  <th>Season & Region</th>
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
               <!-- <tr>
                  <th>Committed Book</th>
                  <td><?php print $data->tour->information->committed_book?> %</td>
                </tr> -->
                <tr>
                  <th>Status</th>
                  <td><?php 
                  $status = array(
                    1 => "Book",
                    2 => "Deposit",
                    3 => "Clear",
                    4 => "Cancel",
                  );
                  
                  $nobook     = 0;
                  $nocommit   = 0;
                  $nolunas    = 0;
                  $nocancel   = 0;
                  $wt_app     = 0;
//                  foreach ($data->book->passenger as $valps) {
                   // echo $valps['status'];
//                    if($data->book->status == "Book"){
//                      $nobook2 +=  $nobook + 1;
//                    }elseif($data->book->status == "Committed Book"){
//                      $nocommit2 +=  $nocommit + 1;
//                    }elseif($data->book->status == "Lunas"){
//                      $nolunas2 +=  $nolunas + 1;
//                    }elseif($data->book->status == "Cancel"){
//                      $nocancel2 +=  $nocancel + 1;
//                    }elseif($data->book->status == "[Cancel] Waiting Approval"){
//                      $wt_app2 += $wt_app + 1;
//                     
//                    }
//                  }
                  
//                  if($nobook2 > 0){
//                    $st_book = "Book For ".$nobook2." Person<br>";
//                  }
//                  if($nocommit2 > 0){
//                    $st_commit = "Deposit For ".$nocommit2." Person<br>";
//                  }
//                  if($nolunas2 > 0){
//                    $st_lunas = "Lunas For ".$nolunas2." Person<br>";
//                  }
//                  if($nocancel2 > 0){
//                    $st_cancel = "Cancel For ".$nocancel2." Person<br>";
//                  }
//                  if($wt_app2 > 0){
//                    $st_wtapp = "[Cancel] Waiting Approval For ".$wt_app2." Person<br>";
//                  }
                  
                 $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                  print "<b>".$status[$data->book->status]." For ".$total_person." Person </b>";
                  print "<b>".$data->book->status."For 1 Person"."</b>";
                  
//                  $total_person =($data->book->jumlah_person_adult_triple_twin + $data->book->jumlah_person_child_twin + $data->book->jumlah_person_child_extra + $data->book->jumlah_person_child_no_bed + $data->book->jumlah_person_sgl_supp);
//                  print "<b>".$status[$data->book->status]." For ".$total_person." Person </b>"; ?></td>
                </tr>
                
            </table>      
       </div>
     <div class="tab-pane" id="info">
          <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <th>Tanggal Lahir</th>
                  <th>No Telp</th>
                </tr>
                <tr>
                  <td><?php print $data->book->first_name." ".$data->book->last_name; ?></td>
                  <td><?php print date("d F Y", strtotime($data->book->tanggal_lahir)); ?></td>
                  <td><?php print $data->book->telphone; ?></td>
                </tr>
               
            </table>      
       </div>
                    
   
       <div class="tab-pane" id="price">
          <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <th>Person</th>
                  <th>Price</th>
                  <th></th>
                </tr>
               <tr>
                  <td>Adult Triple Twin</td>
                  <td><?php print $data->book->jumlah_person_adult_triple_twin; ?></td>
                  <td><?php print number_format($data->tour->information->price->adult_triple_twin,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin),0,",","."); ?></td>
                </tr>
                
                <tr>
                  <td>Child Twin Bed</td>
                  <td><?php print $data->book->jumlah_person_child_twin; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_twin_bed,0,",","."); ?></td>
                 <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed),0,",","."); ?></td>
               
                </tr>
                
                <tr>
                  <td>Child Extra Bed</td>
                  <td><?php print $data->book->jumlah_person_child_extra; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_extra_bed,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed),0,",","."); ?></td>
               
                </tr>
                
                 <tr>
                  <td>Child No Bed</td>
                  <td><?php print $data->book->jumlah_person_child_no_bed; ?></td>
                  <td><?php print number_format($data->tour->information->price->child_no_bed,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed),0,",","."); ?></td>
               
                </tr>
                <tr>
                  <td>SGL SUPP</td>
                  <td><?php print $data->book->jumlah_person_sgl_supp; ?></td>
                  <td><?php print number_format($data->tour->information->price->sgl_supp,0,",","."); ?></td>
                  <td  style="text-align:right"><?php print number_format(($data->book->jumlah_person_sgl_supp * $data->tour->information->price->sgl_supp),0,",","."); ?></td>
               
                </tr>
                <tr>
                  <?php
                  $total_adult_ttwin = ($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin);
                  $total_child_twin = ($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed);
                  $total_child_extra = ($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed);
                  $total_child_no_bed = ($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed);
                  $total_sgl_supp = ($data->book->jumlah_person_sgl_supp * $data->tour->information->price->sgl_supp);
                  $total_all_person = $total_adult_ttwin + $total_child_twin + $total_child_extra + $total_child_no_bed + $total_sgl_supp;
                  $total_tax = ($total_person * $data->tour->information->price->tax_and_insurance);
                 
                  ?>
                  
                  <td><b>Total Price</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print $total = number_format($total_adult_ttwin + $total_child_twin + $total_child_extra + $total_child_no_bed + $total_sgl_supp,0,",","."); ?></b></td>
                 
                </tr>
                <tr>
                  <td><b>Airport Tax & Flight Insurance</b></td>
                  
                  <td><?php print $total_person; ?></td>
                  <td><?php print number_format($data->tour->information->price->tax_and_insurance,0,",","."); ?></td>
                  <td  style="text-align:right"><b><?php print number_format(($total_person * $data->tour->information->price->tax_and_insurance),0,",","."); ?></b></td>
               
                </tr>
                <?php if($data->book->total_visa[0]->totl_visa > 0){ 
                  $total_visa = $data->book->total_visa[0]->totl_visa * $data->tour->information->price->visa;
                  
                  ?>
                <tr>
                  <td><b>Visa</b></td>
                  
                  <td><?php print $data->book->total_visa[0]->totl_visa; ?></td>
                  <td><?php print number_format($data->tour->information->price->visa,0,",","."); ?></td>
                  <td  style="text-align:right"><b><?php print number_format(($total_visa),0,",","."); ?></b></td>
               
                </tr>
                <?php } ?>
                 <?php 
                if($data->book->status_discount){
                $stnb = "[".$data->book->status_discount."]"; 
                }else{
                  $stnb = "";
                }
                
                $status_price="";
               // print_r($data->book->status_discount);die;
                if($data->book->status_discount == "Persen"){
                  $status_price = $data->book->discount;
                  $tot_disc_price =  (($total_all_person * $data->book->discount)/100);
                }elseif($data->book->status_discount == "Nominal") {
                 $tot_disc_price = number_format($data->book->status_discount,0,",",".");
                }
                if($data->book->discount){
                  $tnd_minus = "-";
                }else{
                  $tnd_minus = "";
                }
                ?>
                  <tr>
                  <td><b>Discount <?php print $status_price." ".$stnb; ?></b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print $total = number_format($tot_disc_price,0,",","."); ?></b></td>
                  </tr>
                   
                <tr>
                  <?php
                  $total_adult_ttwin = ($data->book->jumlah_person_adult_triple_twin * $data->tour->information->price->adult_triple_twin);
                  $total_child_twin = ($data->book->jumlah_person_child_twin * $data->tour->information->price->child_twin_bed);
                  $total_child_extra = ($data->book->jumlah_person_child_extra * $data->tour->information->price->child_extra_bed);
                  $total_child_no_bed = ($data->book->jumlah_person_child_no_bed * $data->tour->information->price->child_no_bed);
                  $total_sgl_supp = ($data->book->jumlah_person_sgl_supp * $data->tour->information->price->sgl_supp);
                  $total = ($total_adult_ttwin + $total_child_twin + $total_child_extra + $total_child_no_bed + $total_sgl_supp + $total_tax + $total_visa)-$tot_disc_price;
                  ?>
                  
                  <td><b>Total</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print number_format($total,0,",","."); ?></b></td>
                  
                </tr>
                  <tr>
                    <?php
                    $ppn = (1 * $total)/100;
                    ?>
                  <td><b>PPN 1%</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print number_format($ppn,2,",","."); ?></b></td>
                  </tr>
                  <tr>
                  <td><b>Total All</b></td>
                  <td colspan="3" style="text-align:right" ><b><?php print number_format($total + $ppn,2,",","."); ?></b></td>
                  </tr>
            </table>      
       </div>
   </div><!-- /.tab-content -->
       </div>
          
        </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Search For Change Tour</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php
            $category = array(0 => "Pilih",1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran", 4 => "School Holiday Period");
   $sub_category = array(0 => "Pilih",1 => "Eropa", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand");
    
             $before_table = "<div>"
      . "{$this->form_eksternal->form_open("", 'role="form"')}"
        . "<div class='box-body col-sm-12' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Name Tour</label><br>"
            . "{$this->form_eksternal->form_input('title', $serach_data['title'], ' class="form-control input-sm" placeholder="Title"')}"
          . "</div>"
        . "</div>"
            
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>Start Date</label>"
            . "{$this->form_eksternal->form_input('start_date', $serach_data['start_date'], 'id="start_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          . "<div class='control-group'>"
            . "<label>Season</label>"
            . "{$this->form_eksternal->form_dropdown('kategori1', $category, $serach_data['kategori1'], 'class="form-control" placeholder="Kategori 1"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-6' style='padding-left:2%'>"
          . "<div class='control-group'>"
            . "<label>End Date</label>"
            . "{$this->form_eksternal->form_input('end_date', $serach_data['end_date'], 'id="end_date" class="form-control input-sm" placeholder="Date"')}"
          . "</div>"
          . "<div class='control-group'>"
            . "<label>Region</label>"
            . "{$this->form_eksternal->form_dropdown('kategori2', $sub_category, $serach_data['kategori2'], 'class="form-control" placeholder="Kategori 2"')}"
          . "</div>"
        . "</div>"
              
        . "<div class='box-body col-sm-12' style='padding-left:2%'>"
          . "<div class='control-group' style='margin-bottom:5%'>"
            . "<button id='bb' class='btn btn-primary' type='submit'>Search</button>"
          . "</div>"
        . "</div>"
       
      . "</form>"
    . "</div>";
            print $before_table;
            ?>
         

          <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Available Seat</th>
        <th>Date</th>
        <th>Change</th>
    </tr>
</thead> 
<tbody>
  <?php
  if($data->status == 2){
      
    foreach ($data->data_search_tour as $key => $value) {
          
      $price = number_format($value->information[0]->price->adult, 0, '.', ',');
      
      if($value->file_thumb)
        $gambar = $value->file_thumb;
      else
        $gambar = base_url()."files/no-pic.png";
      
      $start_date = "";
    //  foreach($value->information AS $info){
        $start_date .= "<a href='javascript:void(0)' id='datatoltip{$key}'>"
          . date("d M y", strtotime($data->tour_info[$key]->start_date))." - ".date("d M y", strtotime($data->tour_info[$key]->end_date))."</a>"
          . "<div style='display: none' id='isi{$key}'>"
            . "<table width='100%'>"
              . "<tr>"
                . "<td>Adult Triple/Twin</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->adult_triple_twin)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child Twin Bed</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->child_twin_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child Extra Bed</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->child_extra_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Child No Bed</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->child_no_bed)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>SGL SUPP</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->sgl_supp)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Airport Tax & Flight Insurance</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->price->airport_tax)."</td>"
              . "</tr>"
              . "<tr>"
                . "<td>Available Seat</td>"
                . "<td style='text-align: left'>".number_format($data->tour_info[$key]->available_seat)."</td>"
              . "</tr>"
              
            . "</table>"
          . "</div>"
          . "<script>"
            . "$(function() {"
              . "$('#datatoltip{$key}').tooltipster({"
                . "content: $('#isi{$key}').html(),"
                . "minWidth: 300,"
                . "maxWidth: 300,"
                . "contentAsHTML: true,"
                . "interactive: true"
              . "});"
            . "});"
          . "</script>"
          . "<br />";
     // }
    if($data->tour->information->code == $data->tour_info[$key]->code){
      print '
      <tr>
        <td>'.$value->title.'</td>
        <td>'.$value->category->name.' <br /> '.$value->sub_category->name.'</td>
          <td>'.$data->tour_info[$key]->available_seat.'</td>
          <td>'.$start_date.'</td>
       <td>
          
        </td>
      </tr>';
    }else{
      print '
      <tr>
        <td>'.$value->title.'</td>
        <td>'.$value->category->name.' <br /> '.$value->sub_category->name.'</td>
          <td>'.$data->tour_info[$key]->available_seat.'</td>
        <td>'.$start_date.'</td>
       <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
                   <li><a href="'.site_url("grouptour/product-tour/change-tour-person/".$data->book->code_customer."/".$data->tour_info[$key]->code).'">Change</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }  
      
      }
  }
  ?>
 
</tbody>
</table>   
        </div>
    </div>
  </div>
</div>


