<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Book Request</a></li>
                <li><a href="#tab_2" data-toggle="tab">Contact Person</a></li>
                <li><a href="#tab_3" data-toggle="tab">Passenger</a></li>
                <li><a href="#tab_4" data-toggle="tab">Price Detail</a></li>
                <li><a href="#tab_6" data-toggle="tab">ToC</a></li>
                <li><a href="#tab_5" data-toggle="tab">Log History</a></li>
                <li class="dropdown pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print site_url("store/print-store/tour-fit-proposal/{$book[0]->kode}")?>" target="_blank">Print Itin</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Print Price</a></li>
                    </ul>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                      <div class="col-xs-6">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title">FIT Request</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <table class="table table-striped">
                                <tr>
                                  <th>Book Code</th>
                                  <th><?php print $book[0]->kode?></th>
                                </tr>
                                <tr>
                                  <th>Client</th>
                                  <td><?php print $book[0]->client?></td>
                                </tr>
                                <tr>
                                  <th>Project Name</th>
                                  <td><?php print $book[0]->title?></td>
                                </tr>
                                <tr>
                                  <th>Period</th>
                                  <td>
                                    <?php print date("d M Y", strtotime($book[0]->departure))?> -
                                    <?php print date("d M Y", strtotime($book[0]->arrive))?>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Number of Pax</th>
                                  <td>
                                    <?php print $book[0]->adult?> Adult <br />
                                    <?php print $book[0]->child?> Child
                                  </td>
                                </tr>
                                <tr>
                                  <th>Destination</th>
                                  <td><?php print $book[0]->destination?></td>
                                </tr>
                                <tr>
                                  <th>Budget</th>
                                  <td><?php print number_format($book[0]->budget_start)?> - <?php print number_format($book[0]->budget_end)?></td>
                                </tr>
                                <tr>
                                  <th>Airline</th>
                                  <td><?php print $book[0]->airline?></td>
                                </tr>
                                <tr>
                                  <th>Hotel</th>
                                  <td><?php print $book[0]->hotel?></td>
                                </tr>
                                <tr>
                                  <th>Other Request</th>
                                  <td><?php print nl2br($book[0]->other)?></td>
                                </tr>
                                <tr>
                                  <th>Date of Enquiry</th>
                                  <td><?php print date("d F Y", strtotime($book[0]->tanggal))?></td>
                                </tr>
                                <tr>
                                  <th>Sales</th>
                                  <td><?php print $book[0]->name?></td>
                                </tr>
                              </table>
                            </div>
                        </div>
                      </div>
                      
                      <div class="col-xs-6">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <h3 class="box-title">FIT Quotation</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <table class="table table-striped">
                                <tr>
                                  <th>Destination</th>
                                  <td><?php print $quo[0]->destination?></td>
                                </tr>
                                <?php
                                if($quo[0]->date_limit){
                                ?>
                                <tr>
                                  <th>Timelimit</th>
                                  <td><?php print $quo[0]->date_limit." ".$quo[0]->time_limit?></td>
                                </tr>
                                  <?php
                                  if($quo[0]->status == 9){
                                ?>
                                <tr>
                                  <th>&nbsp;</th>
                                  <td>
                                    <button id="confirm-time-limit" type='button' class='btn btn-success'>
                                      Confirm
                                    </button>
                                  </td>
                                </tr>
                                <?php
                                  }
                                  ?>
                                <?php
                                }
                                ?>
                                <tr>
                                  <th>Airline</th>
                                  <td><?php print $quo[0]->airline?></td>
                                </tr>
                                <tr>
                                  <th>Hotel</th>
                                  <td><?php print $quo[0]->hotel?></td>
                                </tr>
                                <tr>
                                  <th>Stars</th>
                                  <td><?php
                                  $stars = "";
                                  for($r = 1 ; $r <= 5 ; $r++){
                                    if($quo[0]->stars >= $r){
                                      $stars .= "<i style='color: yellow' class='fa fa-fw fa-star'></i>";
                                    }
                                    else{
                                      $stars .= "<i class='fa fa-fw fa-star-o'></i>";
                                    }
                                  }
                                  print $stars?></td>
                                </tr>
                                <tr>
                                  <th>Status</th>
                                  <td><?php 
                                  $status = array(
                                    1 => "<span id='status-asli' class='label label-warning'>Request</span>",
                                    2 => "<span id='status-asli' class='label label-info'>Proposal</span>",
                                    3 => "<span id='status-asli' class='label label-success'>Book</span>",
                                    4 => "<span id='status-asli' class='label label-success'>DP</span>",
                                    5 => "<span id='status-asli' class='label label-danger'>Cancel</span>",
                                    6 => "<span id='status-asli' class='label label-success'>Lunas</span>",
                                    7 => "<span id='status-asli' class='label label-success'>Quotation</span>",
                                    8 => "<span id='status-asli' class='label label-success'>Req Timelimit</span>",
                                  );
                                  print $status[$quo[0]->status]?>
                                    <span id='status-update3' style="display: none" class='label label-success'>Book</span>
                                    <span id='status-update4' style="display: none" class='label label-success'>DP</span>
                                    <span id='status-update6' style="display: none" class='label label-success'>Lunas</span>
                                    <span id='status-update7' style="display: none" class='label label-success'>Quotation</span>
                                    <span id='status-update8' style="display: none" class='label label-success'>Req Timelimit</span>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Note</th>
                                  <td><?php print nl2br($quo[0]->note)?></td>
                                </tr>
                                <?php
                                if($quo[0]->status == 5){?>
                                <tr>
                                  <th>Note Cancel</th>
                                  <td><?php print nl2br($quo[0]->note_cancel)?></td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <th></th>
                                  <td>
                                    <?php
                                    if($quo[0]->status == 2){
                                    ?>
                                    <button id="add-pax" type='button' class='btn btn-success form-quotation' data-toggle='modal' data-target='#form-quotation'>
                                      Confirm Quotation
                                    </button>
                                    <?php }?>
                                    <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#form-cancel'>
                                      Cancel
                                    </button>
                                  </td>
                                </tr>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  if($price_tag){
                  ?>
                    <div class="row">
                      <?php
                      for($t = 0 ; $t < 3 ; $t++){
                      ?>
                      <div class="col-xs-3">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title"><?php print $price_tag[$t]->title?></h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <dl>
                                <dt>Adult Triple/Twin</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->adult_triple_twin)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->adult_triple_twin_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Adult Sgl SUPP</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->adult_sgl_supp)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->adult_sgl_supp_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Child Twin Bed</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->child_twin_bed)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->child_twin_bed_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Child Extra Bed</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->child_extra_bed)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->child_extra_bed_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Child No Bed</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->child_no_bed)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->child_no_bed_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Ticket Adult</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->adult_fare)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->adult_fare_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Ticket Child</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->child_fare)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->child_fare_sell)?></dd>
                              </dl>
                              <dl>
                                <dt>Ticket Infant</dt>
                                <dd style="text-align: right"><?php print number_format($price_tag[$t]->infant_fare)?></dd>
                                <dd style="text-align: right"><i>HET</i> <?php print number_format($price_tag[$t]->infant_fare_sell)?></dd>
                              </dl>
                            </div>
                        </div>
                      </div>
                      <?php
                        $bracket_array[] = $price_tag[$t]->title;
                        if($price_tag[$t]->pilih == 2){
                          $bracket = $t;
                        }
                      }
                      ?>
                      <div class="col-xs-3">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Price FIT</h3>
                                <div class="box-tools pull-right">
                                  <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <div class="form-group">
                                <label>Bracket Price</label>
                                <?php print $this->form_eksternal->form_dropdown('adult_triple_twin', $bracket_array, array($bracket), 'id="pt-bracket" class="form-control input-sm"');?>
                              </div>
                              <div class="form-group">
                                <label>Adult Triple/Twin</label>
                                <?php print $this->form_eksternal->form_input('adult_triple_twin', $quo[0]->adult_triple_twin, 'id="pt-adult-triple-twin" class="form-control input-sm harga" placeholder="Adult Triple Twin"');?>
                              </div>
                              <div class="form-group">
                                <label>Adult Sgl SUPP</label>
                                <?php print $this->form_eksternal->form_input('adult_sgl_supp', $quo[0]->adult_sgl_supp, 'id="pt-adult-sgl-supp" class="form-control input-sm harga" placeholder="Adult Sgl SUPP"');?>
                              </div>
                              <div class="form-group">
                                <label>Child Twin Bed</label>
                                <?php print $this->form_eksternal->form_input('child_twin_bed', $quo[0]->child_twin_bed, 'id="pt-child-twin-bed" class="form-control input-sm harga" placeholder="Child Twin Bed"');?>
                              </div>
                              <div class="form-group">
                                <label>Child Extra Bed</label>
                                <?php print $this->form_eksternal->form_input('child_extra_bed', $quo[0]->child_extra_bed, 'id="pt-child-extra-bed" class="form-control input-sm harga" placeholder="Child Extra Bed"');?>
                              </div>
                              <div class="form-group">
                                <label>Child No Bed</label>
                                <?php print $this->form_eksternal->form_input('child_no_bed', $quo[0]->child_no_bed, 'id="pt-child-no-bed" class="form-control input-sm harga" placeholder="Child No Bed"');?>
                              </div>
                              <div class="form-group">
                                <label>Ticket Adult</label>
                                <?php print $this->form_eksternal->form_input('adult_fare', $quo[0]->adult_fare, 'id="pt-adult-fare" class="form-control input-sm harga" placeholder="Ticket Adult"');?>
                              </div>
                              <div class="form-group">
                                <label>Ticket Child</label>
                                <?php print $this->form_eksternal->form_input('child_fare', $quo[0]->child_fare, 'id="pt-child-fare" class="form-control input-sm harga" placeholder="Ticket Child"');?>
                              </div>
                              <div class="form-group">
                                <label>Ticket Infant</label>
                                <?php print $this->form_eksternal->form_input('infant_fare', $quo[0]->infant_fare, 'id="pt-infant-fare" class="form-control input-sm harga" placeholder="Ticket Infant"');?>
                              </div>
                              <div class="form-group">
                                <button id="save-quotation" type="button" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  if($quo[0]->status < 3 OR $quo[0]->status == 7){
                  ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title">Itinerary</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <table id="table-pax" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Day</th>
                                    <th>Stretches</th>
                                    <th>Meal Plan</th>
                                    <th>Specific Resto Req</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $meal = array(
                                    0 => "<span class='label label-default'>None</span>",
                                    1 => "<span class='label label-success'>FB</span>",
                                    2 => "<span class='label label-info'>HB</span>",
                                  );
                                  foreach($itin_req AS $ir){
                                    print "<tr>"
                                      . "<td>{$ir->sort}</td>"
                                      . "<td>".nl2br($ir->itinerary)."</td>"
                                      . "<td>{$meal[$ir->meal]}</td>"
                                      . "<td>".nl2br($ir->specific)."</td>"
                                    . "</tr>";
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                    <?php
                    if($quo[0]->status > 1 OR $quo[0]->status == 7){
                    ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title">Itinerary Quotation</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                          <div id="loading-itin-quo" style="display: none"><img width="30" src="<?php print $url?>img/ajax-loader.gif" /></div>
                            <div class="box-body">
                              <table id="tableboxy" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Day</th>
                                    <th>Stretches</th>
                                    <th>Meal Plan</th>
                                    <th>Entrance Fee</th>
                                    <th>Specific Resto Req</th>
                                    <th>&nbsp;</th>
                                  </tr>
                                </thead>
                                <tbody>

                                </tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                  <?php
                    }
                  }
                  else{
                  ?>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-solid box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Itinerary</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <table id="table-pax" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Day</th>
                                    <th>Stretches</th>
                                    <th>Meal Plan</th>
                                    <th>Entrance Fee</th>
                                    <th>Specific Resto Req</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $meal = array(
                                    0 => "<span class='label label-default'>None</span>",
                                    1 => "<span class='label label-success'>FB</span>",
                                    2 => "<span class='label label-info'>HB</span>",
                                  );
                                  foreach($itin_req AS $ir){
                                    print "<tr>"
                                      . "<td>{$ir->sort}</td>"
                                      . "<td>".nl2br($ir->itinerary)."</td>"
                                      . "<td>{$meal[$ir->meal]}</td>"
                                      . "<td style='text-align: right'>".number_format($ir->entrance)."</td>"
                                      . "<td>".nl2br($ir->specific)."</td>"
                                    . "</tr>";
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  }
                  ?>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title">Contact Person</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <form action="<?php print site_url("tour/tour-fit/update-contact-person/{$kode}")?>" method="post">
                              <table class="table table-striped">
                                <tr>
                                  <th>Name</th>
                                  <th>
                                    <?php print $this->form_eksternal->form_input('name', $cp[0]->name, 'class="form-control input-sm" placeholder="Name"');?>
                                  </th>
                                </tr>
                                <tr>
                                  <th>Email</th>
                                  <td>
                                    <?php print $this->form_eksternal->form_input('email', $cp[0]->email, 'class="form-control input-sm" placeholder="Email"');?>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Telp</th>
                                  <td>
                                    <?php print $this->form_eksternal->form_input('telp', $cp[0]->telp, 'class="form-control input-sm" placeholder="Telp"');?>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Alamat</th>
                                  <td>
                                    <?php print $this->form_eksternal->form_textarea('alamat', $cp[0]->alamat, 'class="form-control input-sm" placeholder="Alamat"');?>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Note</th>
                                  <td>
                                    <?php print $this->form_eksternal->form_textarea('note', $cp[0]->note, 'class="form-control input-sm" placeholder="Note"');?>
                                  </td>
                                </tr>
                                <tr>
                                  <th colspan="2"><button type="submit" class="btn btn-primary pull-left"> Submit</button></th>
                                </tr>
                              </table>
                              </form>
                            </div>
                        </div>
                      </div>
                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title">Passenger</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div id="loading-pax" style="display: none"><img width="30" src="<?php print $url?>img/ajax-loader.gif" /></div>
                            <div class="box-body">
                              <table id="tableboxy-pax" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Telp</th>
                                    <th>No Passport</th>
                                    <th>Ticket</th>
                                    <th>Option</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td>
                                      <button id="add-pax" type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-pax' isi=''>
                                        <i class='fa fa-plus-square'></i>
                                      </button>
                                    </td>
                                    <td colspan="5">
                                      <a href="<?php print site_url("tour/tour-fit/generate-price/{$kode}")?>" type='button' class='btn btn-warning'>
                                        Generate Price
                                      </a>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_4">
                    <div class="row">
                      <?php
                      if($quo[0]->status < 3){
                      ?>
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="callout callout-danger">
                                        <h4>Confirmasi Quotation</h4>
                                        <p>Quotation belum di confirm.</p>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                      <?php }?>
                      <div class="col-xs-12">
                        <div class="box box-solid box-warning">
                            <div class="box-header">
                                <h3 class="box-title">Price</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="box-body">
                              <table id="table-price" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Note</th>
                                    <th>Qty</th>
                                    <th>Price/qty</th>
                                    <th>Total</th>
                                    <th>&nbsp;</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                    //              $this->debug($price, true);
                                  foreach($price->all AS $dbp){
                                    if($dbp->pos == 1){
                                      $kredit = $dbp->total;
                                      $debit  = 0;
                                    }
                                    else{
                                      $kredit = 0;
                                      $debit  = $dbp->total;
                                    }
                                    print ""
                                    . "<tr>"
                                      . "<td>{$dbp->title}</td>"
                                      . "<td>{$dbp->qty}</td>"
                                      . "<td style='text-align: right'>".number_format($dbp->price)."</td>"
                                      . "<td style='text-align: right'>".number_format($kredit)."</td>"
                                      . "<td style='text-align: right'>".number_format($debit)."</td>"
                                    . "</tr>";
                                    $total_kredit += $kredit;
                                    $total_debit  += $debit;
                                  }

                                  ?>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th colspan="5">SUM</th>
                                    <th style='text-align: right' id="sum-debit"></th>
                                    <th style='text-align: right' id="sum-kredit"></th>
                                  </tr>
                                  <tr>
                                    <th colspan="6">BALANCE</th>
                                    <th style='text-align: right' id="total"></th>
                                  </tr>
                                  <tr>
                                    <th colspan="7">
                                      <button id="button-payment" type='button' class='btn btn-success' data-toggle='modal' data-target='#payment'>
                                        Payment
                                      </button>
                                      <button id="button-price" type='button' class='btn btn-success' data-toggle='modal' data-target='#add-price-manual'>
                                        Add Price Tag
                                      </button>
                                      <div id="loading-payment" style="display: none"><img width="30" src="<?php print $url?>img/ajax-loader.gif" /></div>
                                    </th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_5">
                    <div class="row" id="history-log">
                      <div class="col-md-12">
                          <!-- The time line -->
                          <ul class="timeline">
                              <!-- timeline time label -->
                            <?php
                            $tanggal = "";
                            foreach($log AS $lg){
                              if($tanggal != date("d M y", strtotime($lg->tanggal))){
                                $tanggal = date("d M y", strtotime($lg->tanggal));
                                print "<li class='time-label'>"
                                  . "<span class='bg-red'>"
                                    . "{$tanggal}"
                                  . "</span>"
                                . "</li>";
                              }
                              print "<li>"
                                . "<i class='fa fa-user bg-aqua'></i>"
                                . "<div class='timeline-item'>"
                                  . "<span class='time'><i class='fa fa-clock-o'></i> ".date("H:i:s", strtotime($lg->tanggal))."</span>"
                                  . "<h3 class='timeline-header no-border'><a href='#'>{$lg->name}</a> {$lg->title}</h3>"
                                  . "<div class='timeline-body'>"
                                    . "{$lg->note}"
                                  . "</div>"
                                . "</div>"
                              . "</li>";
                            }
                            ?>
                              <li>
                                  <i class="fa fa-clock-o"></i>
                              </li>
                          </ul>
                      </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_6">
                    <div class="row" id="history-log">
                      <div class="col-md-12">
                        <?php // print $this->form_eksternal->form_open("tour/tour-fit/toc/{$book[0]->kode}", 'role="form"')?>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-xs-12">
                              <?php print $quo[0]->toc?>
                              <?php // print $this->form_eksternal->form_textarea('toc', $quo[0]->toc,
//                                'class="form-control input-sm" placeholder="Itinerary" id="editor2"')?>
                            </div>
                          </div>
                        </div>
<!--                        <div class="row">
                          <div class="col-xs-3">
                            <br />
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <hr />
                          </div>
                        </div>-->
                        <!--</form>--> 
                      </div>
                    </div>
                </div>
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <section class="col-lg-12 connectedSortable">
      <div class="box box-success">
          <div class="box-header">
              <i class="fa fa-comments-o"></i>
              <h3 class="box-title">Chat</h3>
          </div>
          <div class="box-footer">
              <div class="input-group">
                  <input class="form-control" placeholder="Type message..." id="isi-chat"/>
                  <div class="input-group-btn">
                      <button class="btn btn-success" id="post-chat"><i class="fa fa-plus"></i></button>
                      <?php print $this->form_eksternal->form_input('sort_ajax', 0, 'id="sort-ajax" style="display: none"');?>
                      <div id="loading-chat" style="display: none"><img width="30" src="<?php print $url?>img/ajax-loader.gif" /></div>
                  </div>
              </div>
          </div>
          <div class="box-body chat" id="chat-box">
            <?php
            foreach($chat AS $r => $cht){
              if($r == 0){
                $sort_chat = $cht->sort;
              }
              print ""
              . "<div class='item'>"
                . "<img src='{$url}img/no-pic.png' alt='user image' class='offline'/>"
                . "<p class='message'>"
                  . "<a href='#' class='name'><small class='text-muted pull-right'><i class='fa fa-clock-o'></i> {$cht->tanggal}</small>{$cht->name}</a>"
                  . "{$cht->note}"
                . "</p>"
              . "</div>"
              . "";
            }
            ?>
          </div>
      </div>
    </section>
  </div>
</div>


<div class="modal fade" id="edit-detail-pax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Pax</h4>
            </div>
          <div id="loading-form" style="display: none"><img width="30" src="<?php print $url?>img/ajax-loader.gif" /></div>
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Ticket</label>
                      <?php print $this->form_eksternal->form_dropdown('ticket', array(1 => "Ticket", 2 => "Ticketless"), array(), 'id="edit-pax-ticket" class="form-control input-sm"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Type</label>
                      <?php print $this->form_eksternal->form_dropdown('pax_type', array(1 => "Adult", 2 => "Child", 3 => "Infant"), array(), 'id="edit-pax-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Title</label>
                      <?php print $this->form_eksternal->form_dropdown('title', array(1 => "Mr", 2 => "Mrs"), array(), 'id="edit-pax-title" class="form-control input-sm"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Bed Type</label>
                      <?php print $this->form_eksternal->form_dropdown('pax_bed_type', array(1 => "Adult Triple/Twin", 2 => "Adult Sgl SUPP", 3 => "Child Twin Bed", 4 => "Child Extra Bed", 5 => "Child No Bed"), array(), 'id="edit-pax-bed-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('first_name', "", 'id="edit-pax-first-name" class="form-control input-sm" placeholder="First Name"');?>
                      <?php print $this->form_eksternal->form_input('id_tour_fit_request_pax', "", 'id="edit-id" style="display: none"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('last_name', "", 'id="edit-pax-last-name" class="form-control input-sm" placeholder="Last Name"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Email</label>
                      <?php print $this->form_eksternal->form_input('email', "", 'class="form-control input-sm" id="edit-pax-email" placeholder="Email"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('telp', "", 'class="form-control input-sm" id="edit-pax-telp" placeholder="No Telp"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Tempat Lahir</label>
                      <?php print $this->form_eksternal->form_input('tempat_lahir', "", 'id="edit-pax-tempat-lahir" class="form-control input-sm" placeholder="Place Of Birth"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Tanggal Lahir</label>
                      <?php print $this->form_eksternal->form_input('tanggal_lahir', "", 'id="edit-pax-tanggal-lahir" class="form-control input-sm tanggal" placeholder="Tanggal Lahir"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Passport</label>
                      <?php print $this->form_eksternal->form_input('passport', "", 'id="edit-pax-passport" class="form-control input-sm" placeholder="No Passport"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Place Of Issued</label>
                      <?php print $this->form_eksternal->form_input('tempat_passport', "", 'id="edit-pax-tempat-passport" class="form-control input-sm" placeholder="Place Of Issue"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Date Of Issued</label>
                      <?php print $this->form_eksternal->form_input('tanggal_passport', "", 'id="edit-pax-tanggal-passport" class="form-control input-sm tanggal" placeholder="Date Of Issued"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Date Of Expired</label>
                      <?php print $this->form_eksternal->form_input('expired_passport', "", 'id="edit-pax-expired-passport" class="form-control input-sm tanggal" placeholder="Date Of Expired"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="edit-pax-note" class="form-control input-sm" placeholder="Note"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" id="simpan-pax" class="btn btn-primary pull-left" data-dismiss="modal"> Submit</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="form-quotation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm Quotation</h4>
            </div>
            <form action="<?php print site_url("tour/tour-fit/confirm-quotation/{$kode}")?>" method="post">
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <p>
                        Confirm?
                      </p>
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

<div class="modal fade" id="form-cancel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cancel</h4>
            </div>
            <form action="<?php print site_url("tour/tour-fit/cancel-quotation/{$kode}")?>" method="post">
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="edit-pax-note" class="form-control input-sm" placeholder="Note"');?>
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

<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Payment</h4>
            </div>
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>No Payment</label>
                      <?php print $this->form_eksternal->form_input('nomor', "", 'id="payment-nomor" class="form-control input-sm" placeholder="No Payment"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>No TTU</label>
                      <?php print $this->form_eksternal->form_input('nomor_ttu', "", 'class="form-control input-sm" id="payment-nomor-ttu" placeholder="Nomor TTU"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Nominal</label>
                      <?php print $this->form_eksternal->form_input('price', "", 'class="form-control input-sm harga" id="payment-price" placeholder="Nominal"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Rek Penerima</label>
                      <?php print $this->form_eksternal->form_dropdown('rekening', array(1 => "Cash", 2 => "BCA", 3 => "Mega", 4 => "Kartu Kredit Mega", 5 => "Kartu Kredit Mega Priority", 6 => "Kartu Kredit", 7 => "Mandiri", 8 => "BNI", 9 => "CIMB"), array(), 'id="payment-rekening" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="payment-note" class="form-control input-sm" placeholder="Note"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" id="simpan-payment" class="btn btn-primary pull-left" data-dismiss="modal"> Submit</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="add-price-manual" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Price Tag</h4>
            </div>
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Type</label>
                      <?php print $this->form_eksternal->form_dropdown('type', array(
                        2 => "Additional",
                        3 => "PPN",
                        4 => "Visa",
                        5 => "Discount",
                      ), array(), 'id="price-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Title</label>
                      <?php print $this->form_eksternal->form_input('title', "", 'class="form-control input-sm" id="price-title" placeholder="Title"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-8">
                      <label>Nominal</label>
                      <?php print $this->form_eksternal->form_input('price', "", 'class="form-control input-sm harga" id="price-price" placeholder="Nominal"');?>
                    </div>
                    <div class="col-xs-4">
                      <label>Qty</label>
                      <?php print $this->form_eksternal->form_input('qty', "", 'class="form-control input-sm" id="price-qty" placeholder="Qty"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Pos</label>
                      <?php print $this->form_eksternal->form_dropdown('pos', array(1 => "Penambahan", 2 => "Pengurangan"), array(), 'id="price-pos" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', "", 'id="price-note" class="form-control input-sm" placeholder="Note"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" id="simpan-price" class="btn btn-primary pull-left" data-dismiss="modal"> Submit</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>