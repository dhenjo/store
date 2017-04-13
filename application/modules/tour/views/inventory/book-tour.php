<?php
//print "<pre>";
//print_r($detail);
//print "</pre>";
?>
<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Data Inventory</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="box">
              <div class="box-body table-responsive">
                <table class="table table-bordered table-hover">
                  <tr>
                      <td style="width: 150px">First Name</td>
                    <td><?php print $data[0]->first_name; ?></td>
                    <td>Last Name</td>
                    <td><?php print $data[0]->last_name; ?></td>
                  </tr>
                  <tr>
                    <td>Title</td>
                    <td><?php print nl2br($data[0]->title); ?></td>
                    <td>No Telp</td>
                    <td><?php print $data[0]->telp; ?></td>
                  </tr>
                  <tr>
                    <td>Address</td>
                    <td colspan="3"><?php print $data[0]->alamat; ?></td>
                  </tr>
                  <?php $no = 1; ?>
                  <?php  foreach ($ttu as $k => $v) { ?>
                   <tr>
                    <td>No. TTU <?php print $no; ?></td>
                    <td><?php print $v->no_ttu."<br>"; ?></td>
                    <td>Nominal <?php print $no; ?></td>
                    <td><?php print number_format($v->nominal); ?></td>
                  </tr>
                  <tr>
                    <td>Remark <?php print $no; ?></td>
                    <td colspan="3"><?php print nl2br($v->remark); ?></td>
                  </tr>
                  <?php 
                   $no++;
                  } ?>
                </table>
              </div>
            </div>
          </div>  
        </div>
    </div>
  </div>
</div>
<div class='row'>
   <?php print $this->form_eksternal->form_open("tour/tour-inventory/book-info", 'role="form"', 
                    array(
                      "tour_information_code"               => $detail->information->code, 
                      "tour_code"                           => $detail->tour->code,
                      "dasar_adult_triple_twin"             => $this->session->userdata("adl_triple_twin"),
                      "dasar_child_twin_bed"                => $this->session->userdata("chl_twin_bed"),
                      "dasar_child_extra_bed"               => $this->session->userdata("chl_extra_bed"),
                      "dasar_child_no_bed"                  => $this->session->userdata("chl_no_bed"),
                      "sgl_supp"                            => $this->session->userdata("single_adult"),
                      "tax_and_insurance"                   => $detail->information->price->tax_and_insurance,
                      "seat"                                => $detail->information->seat,
                      "dp"                                  => $detail->information->dp,
                      "visa"                                => $detail->information->visa,
                      "less_ticket_adl"                     => $detail->information->less_ticket_adl,
                      "less_ticket_chl"                     => $detail->information->less_ticket_chl,
                      "status_dp"                           => $detail->information->status_dp,
                      "discount"                            => $detail->information->discount_tetap,
                      "status_discount"                     => $detail->information->status_discount_tetap,
                      "currency"                            => $detail->information->price->currency,
                      "id_inventory"                        => $id_inventory, 
                   //   "discount_tambahan"                            => $detail->information->discount_tambahan,
                   //   "status_discount_tambahan"                            => $detail->information->status_discount_tambahan,
                    ))?>
  
  
  <div class='col-md-12'>
     <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#room" data-toggle="tab">Room</a></li>
            <li><a href="#additional" data-toggle="tab">Additional</a></li>
            <li><a href="#discount" data-toggle="tab">Discount</a></li>
            <li><a href="#price" data-toggle="tab">Price Detail</a></li>
            <li class="pull-right"><button class="btn btn-primary" type="submit">Book Now</button></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="room">
               <div class='box box-info data-room1'>
        <div class="box-header">
          <dl class="dl-horizontal">
              <dt>Max Seat</dt>
              <dd><?php print $detail->information->seat?></dd>
              <dt>Confirm Book</dt>
              <dd><?php print $detail->information->dp?></dd>
              <dt>Book</dt>
              <dd><?php print ($detail->information->book - $detail->information->dp)?></dd>
              <dt>Available Seat</dt>
              <dd><?php print ($detail->information->seat - $detail->information->dp)?></dd>
          </dl>
          <h3 class="box-title"><div class='number'>Room 1 </div></h3> 
        
        </div>
          <div class='box-body pad'>
           
    <!--  <div class="box-body col-sm-4">
      <div class="control-group">
        <label>ROOM TYPE</label>
        <?php
        $room_type = array("1" => "SINGLE",
                           "2"  => "DOUBLE",
                            "3" => "TRIPLE");
        ?>
        <?php print $this->form_eksternal->form_dropdown('room_type1[]', $room_type, "", 'onblur="tambah_test()"  id="data_type_bed1" class="form-control type_bedq input-sm"')."<br>";?>
      </div>
    </div> -->
    <div class="box-body col-sm-5 data-bed1">
      <div class="control-group">
        <label>Type Bed</label>
        <?php print $this->form_eksternal->form_dropdown('type_bed1[]', $this->session->userdata('type_bed'), "", 'onblur="tambah_test()"  id="data_type_bed1" class="form-control type_bedq input-sm"');?>
      </div>
    </div>
         
   <div class="box-body col-sm-5 data-bed1">
      <div class="control-group">
        <label>Qty</label>
      <?php print $this->form_eksternal->form_input('qty1[]', "", 'onblur="tambah_test()" id="data_qty1" class="form-control qty input-sm" placeholder="Qty"');?>
       </div>
    </div>
      <div class="box-body col-sm-2 data-bed1">
      <div class="control-group">
       <br>
        <a href="javascript:void(0)" onclick="tambah_items_delete(1)" class="btn btn-danger"><?php print lang("X")?></a>
      </div>
            <br>
    </div> 
      
       <span id="tambah-items">
                    </span>
             <a href="javascript:void(0)" onclick="tambah_items()" class="btn btn-info"><?php print lang("Add Bed")?></a>
                    <br><br>
              
            
          </div>
      </div>
    <div class="control-group">
      
       <span id="tambah-item-rooms" >
                    </span>
            <span style="padding-left: 60%"> <a href="javascript:void(0)" onclick="tambah_item_rooms()" class="btn btn-info" ><?php print lang("Add Room")?></a></span>
                  <button disabled class="btn btn-primary" type="submit">Total Price <?php print $detail->information->price->currency; ?> <span class="tot_price">0</span></button>
            <br><br>
                    
              </div>
  
            
            </div><!-- /.tab-pane -->
            
            <div class="tab-pane" id="additional">
       <div class='box-body col-sm-12'>
              <div class="control-group">
      <label>Additional Request </label>
     <?php print $this->form_eksternal->form_textarea('note_additional', "", 'class="form-control input-sm" id="Note"')?>
      </div>
      </div> 
    
     <?php if($detail->tour->additional){ ?>        
   <!-- <div class='box-body col-sm-6'>
              <div class="control-group">
      <label><div class='number_additional'>Additional 1 </div></label>
      <?php print $this->form_eksternal->form_dropdown('type_add[]', $this->session->userdata("arradd"), "", '  id="data_type_bed1" class="form-control type_bedq input-sm"');?>
      </div>
      </div>
               
     <div class='box-body col-sm-6' style="padding-bottom: 7%">
      <div class="control-group">
      </div>
      </div>
    
       <span id="tambah-additional" >
                    </span>
             <a href="javascript:void(0)" onclick="tambah_items_additional()" class="btn btn-info"><?php print lang("Add")?></a>
           <br><br>     --> 
          <?php } ?>  
            
          </div>
            <?php
                      $status_nb = array(2 => "Nominal");
                      ?>
            <div class="tab-pane" id="discount">
    <div class='box-body col-sm-8'>
              <div class="control-group" id="tempat-discount-req">
      <label style="width: 60%"><div>Keterangan</div></label>
      <label style="width: 30%"><div>Nilai Discount</div></label><br>
      <div id="discount_req1">
      <?php 
      print $this->form_eksternal->form_input('note_discount[]', "", 'style="width:60%" class="form-control input-sm"  placeholder="Note"');
      print $this->form_eksternal->form_input('discount_request[]', "", 'onkeyup="FormatCurrency(this)" style="width:30%" class="form-control input-sm"  placeholder="Discount Request"');
      ?>
        <a class="btn btn-danger btn-sm del-req" isi="discount_req1" >X</a>
      </div>
    </div>
      <br />
      <a class="btn btn-info btn-sm" id="add-discount-req" >Add</a>
    </div>
    
    <br>
    <br><br>
          </div>
            <div class="tab-pane" id="price">
          <table class="table table-condensed">
                <tr>
                  <th>Name</th>
                  <th>Person</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th></th>
                </tr>
             
               <tr>
                  <td>Adult Triple Twin</td>
                  <td><span id="adl_twin">0</td>
                  <td><?php print number_format($this->session->userdata("adl_triple_twin"),0,",","."); ?></td>
                  <td><span id="disc_adl_twin">0</td>
                  <td  style="text-align:right"><span id="total_adl_twin">0</span></td>
                </tr>
                
                <tr>
                  <td>Child Twin Bed</td>
                  <td><span id="chl_tb">0</td>
                  <td><?php print number_format($this->session->userdata("chl_twin_bed"),0,",","."); ?></td>
                  <td><span id="disc_chl_tb">0</td>
                 <td  style="text-align:right"><span id="total_chl_tb">0</span></td>
               
                </tr>
                
                <tr>
                  <td>Child Extra Bed</td>
                  <td><span id="chl_eb">0</td>
                  <td><?php print number_format($this->session->userdata("chl_extra_bed"),0,",","."); ?></td>
                  <td><span id="disc_chl_eb">0</td>
                  <td  style="text-align:right"><span id="total_chl_eb">0</span></td>
               
                </tr>
                
                 <tr>
                  <td>Child No Bed</td>
                  <td><span id="chl_nb">0</td>
                  <td><?php print number_format($this->session->userdata("chl_no_bed"),0,",","."); ?></td>
                  <td><span id="disc_chl_nb">0</td>
                  <td  style="text-align:right"><span id="total_chl_nb">0</span></td>
               
                </tr>
                <tr>
                  <?php ?>
                  <td>Single Adult</td>
                  <td><span id="sgl_supp">0</td>
                  <td><?php print number_format($this->session->userdata("single_adult"),0,",","."); ?></td>
                  <td><span id="disc_sgl_supp">0</td>
                  <td  style="text-align:right"><span id="total_sgl_supp">0</span></td>
                </tr>
                <tr>
                  <td><b>Total Price</b></td>
                  <td colspan="4" style="text-align:right" ><b><span class="tot_price">0</span></b></td>
                </tr>
                <?php if($detail->information->status_discount_tetap){
                $stnb = "[".$detail->information->status_discount_tetap."]"; 
                }else{
                  $stnb = "";
                }
                $status_price="";
                if($detail->information->status_discount_tetap == "Persen"){
                  $status_price = $detail->information->discount_tetap;
                  $tot_disc_price =  0;
                }elseif($detail->information->status_discount_tetap == "Nominal") {
                 $tot_disc_price = number_format($detail->information->discount_tetap,0,",",".");
                }
                if($detail->information->discount_tetap){
                  $tnd_minus = "-";
                }else{
                  $tnd_minus = "";
                }
                ?>
                <tr>
                  <td>Airport Tax & Flight Insurance</td>
                  <td><span id="tax">0</td>
                  <td><?php print number_format($detail->information->price->tax_and_insurance,0,",","."); ?></td>
                    <td><span id="tax">0</td>
                  <td  style="text-align:right"><span id="total_tax">0</span></td>
                </tr>
                <span class="discount2" style="display:none"><?php print $detail->information->discount_tetap; ?></span>
<!--                <tr>
                  <td><b>Discount <?php print $status_price." ".$stnb; ?></b></td>
                  <td></td>
                  <td></td>
                  <td><b><span class="disc_tot_all">0</span></td>
                  <td style="text-align:right" ><b><?php print $tnd_minus; ?> <span class="disc_tot_all"><?php print $tot_disc_price; ?></span></b></td>
                </tr>-->
                <tr>
                  <td><b>Total</b></td>
                  <td colspan="4" style="text-align:right" ><b><?php print $detail->information->price->currency; ?> <span class="tot_all">0</span></b></td>
                </tr>
               <tr>
                  <td>PPN 1%</td>
                  <td colspan="4" style="text-align:right" ><?php print $detail->information->price->currency; ?> <span class="ppn">0</span></td>
                </tr>
                <tr>
                  <td><b>Total All</b></td>
                  <td colspan="4" style="text-align:right" ><b><?php print $detail->information->price->currency; ?> <span class="total_all">0</span></b></td>
                </tr>
            </table>
              <div class="box-footer">
                <?php print $this->form_eksternal->form_input('jumlah_room', "1", ' style="display:none" id="jml_room"  class="form-control input-sm" placeholder="jumlah_room"');?>
                <?php print $this->form_eksternal->form_input('total_price', "1", ' style="display:none" id="total_pr"  class="form-control input-sm" placeholder="total"');?>
     
                  <button class="btn btn-primary" type="submit">Book</button>
                  <a href="<?php print site_url("grouptour/product-tour/tour-detail/{$detail->tour->code}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              
              </div>
       </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
    </div>
      
          </div>
  </form><!-- /.box -->
  </div><!-- /.col-->
</div>