<div class="row">
    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Book Request</a></li>
                <li><a href="#tab_6" data-toggle="tab">ToC</a></li>
                <li><a href="#tab_2" data-toggle="tab">Contact Person</a></li>
                <li><a href="#tab_3" data-toggle="tab">Passenger</a></li>
                <li><a href="#tab_4" data-toggle="tab">Price Detail</a></li>
                <li><a href="#tab_5" data-toggle="tab">Log History</a></li>
                <li class="dropdown pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-gear"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Print Book</a></li>
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
                                  <th>Project Date</th>
                                  <td><?php print date("d F Y", strtotime($book[0]->departure))?></td>
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
                                if($quo[0]->status == 8){
                                ?>
                                  <tr id="timelimit-rep">
                                    <th>Timelimit</th>
                                    <td><?php print $this->form_eksternal->form_input('date_limit', $quo[0]->date_limit, 'id="set-date-limit"class="form-control input-sm tanggal" placeholder="Tanggal"');?></td>
                                  </tr>
                                  <tr id="timelimit-rep2">
                                    <th>&nbsp;</th>
                                    <td>
                                      <div class="col-xs-6 bootstrap-timepicker">
                                        <?php 
                                        $tl = explode(":", $quo[0]->time_limit);
                                        $ampm = "AM";
                                        if($tl[0] > 12){
                                          $tl[0] -= 12;
                                          $ampm = "PM";
                                        }
                                        $time_limit = $tl[0].":".$tl[1]." ".$ampm;
                                        print $this->form_eksternal->form_input('time_limit', $time_limit, 'id="set-time-limit" class="form-control input-sm timepicker" placeholder="Timelimit"');
                                        ?>
                                      </div>
                                      <button id="set-button-time-limit" type='button' class='btn btn-success'>
                                        Set Timelimit
                                      </button>
                                    </td>
                                  </tr>
                                <?php }
                                else{
                                  ?>
                                  <tr id="timelimit-rep">
                                    <th>Timelimit</th>
                                    <td><?php print $quo[0]->date_limit." ".$quo[0]->time_limit?></td>
                                  </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                  <th>Adult Triple/Twin</th>
                                  <td><?php print number_format($quo[0]->adult_triple_twin)?></td>
                                </tr>
                                <tr>
                                  <th>Adult Sgl SUPP</th>
                                  <td><?php print number_format($quo[0]->adult_sgl_supp)?></td>
                                </tr>
                                <tr>
                                  <th>Child Twin Bed</th>
                                  <td><?php print number_format($quo[0]->child_twin_bed)?></td>
                                </tr>
                                <tr>
                                  <th>Child Extra Bed</th>
                                  <td><?php print number_format($quo[0]->child_extra_bed)?></td>
                                </tr>
                                <tr>
                                  <th>Child No Bed</th>
                                  <td><?php print number_format($quo[0]->child_no_bed)?></td>
                                </tr>
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
                                  <th>Ticket Adult</th>
                                  <td><?php print number_format($quo[0]->adult_fare)?></td>
                                </tr>
                                <tr>
                                  <th>Ticket Child</th>
                                  <td><?php print number_format($quo[0]->child_fare)?></td>
                                </tr>
                                <tr>
                                  <th>Ticket Infant</th>
                                  <td><?php print number_format($quo[0]->infant_fare)?></td>
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
                                  );
                                  print $status[$quo[0]->status]?>
                                    <span id='status-update3' style="display: none" class='label label-success'>Book</span>
                                    <span id='status-update4' style="display: none" class='label label-success'>DP</span>
                                    <span id='status-update6' style="display: none" class='label label-success'>Lunas</span>
                                    <span id='status-update7' style="display: none" class='label label-success'>Quotation</span>
                                  </td>
                                </tr>
                                <tr>
                                  <th>Note</th>
                                  <td><?php print nl2br($quo[0]->note)?></td>
                                </tr>
                              </table>
                              <button id="add-pax" type='button' class='btn btn-success form-quotation' data-toggle='modal' data-target='#form-quotation'>
                                Form Quotation
                              </button>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <?php
                      print $this->form_eksternal->form_open("tour/opt-tour/set-fit-request-price-tag/{$kode}");
                      ?>
                      <div class="col-xs-12">
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <h3 class="box-title">FIT Quotation</h3>
                                <div class="box-tools pull-right">
                                  <button type="button" class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                              <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th rowspan="2">Quotation</th>
                                    <?php
                                      for($ji = 0 ; $ji < 3 ; $ji++){
                                    ?>
                                    <th colspan="2">
                                      <?php
                                        print $this->form_eksternal->form_input('title[]', $price_tag[$ji]->title, 'class="form-control input-sm" id="pt1-title" placeholder="Title"');
                                        print $this->form_eksternal->form_input('id_tour_fit_request_price_tag[]', $price_tag[$ji]->id_tour_fit_request_price_tag, 'style="display: none"');
                                      ?>
                                    </th>
                                      <?php }?>
                                  </tr>
                                  <tr>
                                    <th>Cost</th>
                                    <th>Sell</th>
                                    <th>Cost</th>
                                    <th>Sell</th>
                                    <th>Cost</th>
                                    <th>Sell</th>
                                  </tr>
                                </thead>
                                <tr>
                                  <th>Adult Triple/Twin</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_triple_twin[]', $price_tag[$ji]->adult_triple_twin, 'class="form-control input-sm harga" id="pt1-adult-triple-twin" placeholder="Adult Triple Twin"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_triple_twin_sell[]', $price_tag[$ji]->adult_triple_twin_sell, 'class="form-control input-sm harga" id="pt1-adult-triple-twin-sell" placeholder="Adult Triple Twin Sell"');?>
                                  </td>
                                  <?php
                                  }
                                  ?>
                                </tr>
                                <tr>
                                  <th>Adult Sgl SUPP</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_sgl_supp[]', $price_tag[$ji]->adult_sgl_supp, 'class="form-control input-sm harga" id="pt1-adult-sgl-supp" placeholder="Adult Sgl SUPP"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_sgl_supp_sell[]', $price_tag[$ji]->adult_sgl_supp_sell, 'class="form-control input-sm harga" id="pt1-adult-sgl-supp-sell" placeholder="Adult Sgl SUPP Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Child Twin Bed</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_twin_bed[]', $price_tag[$ji]->child_twin_bed, 'class="form-control input-sm harga" id="pt1-child-twin-bed" placeholder="Child Twin Bed"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_twin_bed_sell[]', $price_tag[$ji]->child_twin_bed_sell, 'class="form-control input-sm harga" id="pt1-child-twin-bed-sell" placeholder="Child Twin Bed Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Child Extra Bed</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_extra_bed[]', $price_tag[$ji]->child_extra_bed, 'class="form-control input-sm harga" id="pt1-child-extra-bed" placeholder="Child Extra Bed"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_extra_bed_sell[]', $price_tag[$ji]->child_extra_bed_sell, 'class="form-control input-sm harga" id="pt1-child-extra-bed-sell" placeholder="Child Extra Bed Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Child No Bed</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_no_bed[]', $price_tag[$ji]->child_no_bed, 'class="form-control input-sm harga" id="pt1-no-extra-bed" placeholder="Child No Bed"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_no_bed_sell[]', $price_tag[$ji]->child_no_bed_sell, 'class="form-control input-sm harga" id="pt1-no-extra-bed-sell" placeholder="Child No Bed Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Ticket Adult</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_fare[]', $price_tag[$ji]->adult_fare, 'class="form-control input-sm harga" id="pt1-adult-fare" placeholder="Ticket Adult"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('adult_fare_sell[]', $price_tag[$ji]->adult_fare_sell, 'class="form-control input-sm harga" id="pt1-adult-fare-sell" placeholder="Ticket Adult Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Ticket Child</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_fare[]', $price_tag[$ji]->child_fare, 'class="form-control input-sm harga" id="pt1-child-fare" placeholder="Ticket Child"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('child_fare_sell[]', $price_tag[$ji]->child_fare_sell, 'class="form-control input-sm harga" id="pt1-child-fare-sell" placeholder="Ticket Child Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tr>
                                  <th>Ticket Infant</th>
                                  <?php
                                  for($ji = 0 ; $ji < 3 ; $ji++){
                                  ?>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('infant_fare[]', $price_tag[$ji]->infant_fare, 'class="form-control input-sm harga" id="pt1-infant-fare" placeholder="Ticket Infant"');?>
                                  </td>
                                  <td style="text-align: right">
                                    <?php print $this->form_eksternal->form_input('infant_fare_sell[]', $price_tag[$ji]->infant_fare_sell, 'class="form-control input-sm harga" id="pt1-infant-fare-sell" placeholder="Ticket Infant Sell"');?>
                                  </td>
                                  <?php }?>
                                </tr>
                                <tfoot>
                                  <tr>
                                    <td colspan="7">
                                      <button type='submit' class='btn btn-success'>Save</button>
                                    </td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>
                      </div>
                      <?php
                      print $this->form_eksternal->form_close();
                      ?>
                    </div>
                  <?php
                  if($quo[0]->status < 3){
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
                  }
                  
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
                              <tfoot>
                                <tr>
                                  <td colspan="6">
                                    <button id="add-pax" type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-quo' isi=''>
                                      <i class='fa fa-plus-square'></i>
                                    </button>
                                  </td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                      </div>
                    </div>
                  </div>

                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="tab_6">
                    <div class="row" id="history-log">
                      <div class="col-md-12">
                        <?php print $this->form_eksternal->form_open("tour/tour-fit/toc/{$book[0]->kode}", 'role="form"')?>
                        <div class="row">
                          <div class="form-group">
                            <div class="col-xs-12">
                              <?php print $this->form_eksternal->form_textarea('toc', $quo[0]->toc,
                                'class="form-control input-sm" placeholder="Itinerary" id="editor2"')?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-3">
                            <br />
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <hr />
                          </div>
                        </div>
                        </form> 
                      </div>
                    </div>
                </div>
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
                              <table class="table table-striped">
                                <tr>
                                  <th>Name</th>
                                  <th><?php print $cp[0]->name?></th>
                                </tr>
                                <tr>
                                  <th>Email</th>
                                  <td><?php print $cp[0]->email?></td>
                                </tr>
                                <tr>
                                  <th>Telp</th>
                                  <td><?php print $cp[0]->telp?></td>
                                </tr>
                                <tr>
                                  <th>Alamat</th>
                                  <td><?php print $cp[0]->alamat?></td>
                                </tr>
                                <tr>
                                  <th>Note</th>
                                  <td><?php print $cp[0]->note?></td>
                                </tr>
                              </table>
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
                                  <?php
                                  $ticket = array(
                                    1 => "<span class='label label-success'>Ticket</span>",
                                    2 => "<span class='label label-warning'>Ticketless</span>",
                                  );
                                  $type = array(
                                    1 => "<span class='label label-success'>Adult</span>",
                                    2 => "<span class='label label-info'>Child</span>",
                                    3 => "<span class='label label-warning'>Infant</span>",
                                  );
                                  $title = array(
                                    1 => "Mr",
                                    2 => "Mrs",
                                  );
                                  foreach($pax AS $px){
                                    print "<tr>"
                                      . "<td>{$type[$px->type]}</td>"
                                      . "<td>{$px->first_name} {$px->last_name}</td>"
                                      . "<td>{$px->telp}</td>"
                                      . "<td>{$px->passport}</td>"
                                      . "<td>{$ticket[$px->ticket]}</td>"
                                      . "<td>"
                                        . "<div class='btn-group-vertical'>"
                                          . "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#detail-pax-{$px->id_tour_fit_request_pax}'>"
                                            . "<i class='fa fa-search'></i>"
                                          . "</button>"
                                        . "</div>"
                                      . "</td>"
                                    . "</tr>";
                                    ?>
                                  <div class="modal fade" id="detail-pax-<?php print $px->id_tour_fit_request_pax?>" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title">Detail Pax</h4>
                                            </div>
                                              <div class="box-body" style="padding: 10px">
                                                  <dl>
                                                      <dt>Name</dt>
                                                      <dd><?php print $title[$px->title]." {$px->first_name} {$px->last_name}"?></dd>
                                                      <dt>Email</dt>
                                                      <dd><?php print $px->email?></dd>
                                                      <dt>Telp</dt>
                                                      <dd><?php print $px->telp?></dd>
                                                      <dt>Kelahiran</dt>
                                                      <dd><?php print $px->tempat_lahir.", ".date("d F Y", strtotime($px->tanggal_lahir))?></dd>
                                                      <dt>No Passport</dt>
                                                      <dd><?php print $px->passport?></dd>
                                                      <dt>Place of Issued</dt>
                                                      <dd><?php print $px->tempat_passport?></dd>
                                                      <dt>Validity</dt>
                                                      <dd><?php print date("d F Y", strtotime($px->tanggal_passport))." - ".date("d F Y", strtotime($px->expired_passport))?></dd>
                                                      <dt>Ticket</dt>
                                                      <dd><?php print $ticket[$px->ticket]?></dd>
                                                      <dt>Type</dt>
                                                      <dd><?php print $type[$px->type]?></dd>
                                                      <dt>Note</dt>
                                                      <dd><?php print $px->note?></dd>
                                                  </dl>
                                              </div>
                                              <div class="modal-footer clearfix">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                              </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                    <?php
                                  }
                                  ?>
                                </tbody>
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
                                <h3 class="box-title">Sell Price</h3>
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
                      <div class="col-xs-12">
                        <div class="box box-solid box-info">
                            <div class="box-header">
                                <h3 class="box-title">Hpp</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="box-body">
                              <table id="table-hpp" class="table table-bordered table-hover">
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
                                  foreach($hpp AS $dbp){
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
                                      . "<td>{$dbp->tanggal}</td>"
                                      . "<td>{$dbp->kode}</td>"
                                      . "<td>{$dbp->title}</td>"
                                      . "<td style='text-align: right'>".number_format($dbp->qty)."</td>"
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
                                    <th style='text-align: right' id="sum-debit"><?php print number_format($total_kredit)?></th>
                                    <th style='text-align: right' id="sum-kredit"><?php print number_format($total_debit)?></th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <div class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title">Margin</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></a>
                                </div>
                            </div>
                            <div class="box-body">
                              <table id="table-hpp" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                    <th>Note</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>Cost</td>
                                    <td style='text-align: right' id="total-cost"></td>
                                    <td></td>
                                  </tr>
                                  <tr>
                                    <td>Pendapatan</td>
                                    <td></td>
                                    <td style='text-align: right' id="total-cost2"><?php print number_format(($total_kredit - $total_debit))?></td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>BALANCE</th>
                                    <th style='text-align: right'>&nbsp;</th>
                                    <th style='text-align: right' id="hasil-kredit"></th>
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
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->
    </div>
</div>
<!--<div class="row">
  <div class="col-md-12">
    <section class="col-lg-12">
      
      <hr />
    </section>
  </div>
</div>-->
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


<div class="modal fade" id="form-quotation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Form Quotation</h4>
            </div>
            <form action="<?php print site_url("tour/opt-tour/quotation-request/{$kode}")?>" method="post">
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Destination</label>
                      <?php print $this->form_eksternal->form_input('destination', $quo[0]->destination, 
                        'class="form-control input-sm" placeholder="Destination"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Airline</label>
                      <?php print $this->form_eksternal->form_input('airline', $quo[0]->airline, 'class="form-control input-sm" placeholder="Airline"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Hotel</label>
                      <?php print $this->form_eksternal->form_input('hotel', $quo[0]->hotel, 'class="form-control input-sm" placeholder="Hotel"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Stars</label>
                      <?php print $this->form_eksternal->form_dropdown('stars', array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5), array($quo[0]->stars), 
                        'class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', $quo[0]->note, 'id="edit-note" class="form-control input-sm" placeholder="Note"');?>
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


<div class="modal fade" id="edit-detail-quo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Form Itin Quotation</h4>
            </div>
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Days</label>
                      <?php print $this->form_eksternal->form_input('days', "", 
                        'id="itin-quo-days" class="form-control input-sm" placeholder="Days"');?>
                      <?php print $this->form_eksternal->form_input('id_tour_fit_request_detail', "", 
                        'id="itin-quo-id-tour-fit-request-detail" class="form-control input-sm" style="display: none"');?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Stretches</label>
                      <?php print $this->form_eksternal->form_textarea('itinerary', "", 
                        'id="itin-quo-itinerary" class="form-control input-sm" placeholder="Streches"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Meal Plan</label>
                      <?php print $this->form_eksternal->form_dropdown('meal', array(0 => "None", 1 => "FB", 2 => "HB"), array(), 
                        'id="itin-quo-meal" class="form-control input-sm"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Entrance Fee</label>
                      <?php print $this->form_eksternal->form_input('entrance', "", 
                        'id="itin-quo-entrance" class="form-control input-sm harga" placeholder="Entrance Fee"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Specific</label>
                      <?php print $this->form_eksternal->form_textarea('specific', "", 
                        'id="itin-quo-specific" class="form-control input-sm" placeholder="Specific"');?>
                    </div>
                  </div>
                </div>

              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button id="simpan-itin-quo" type="button" class="btn btn-primary pull-left" data-dismiss="modal"> Submit</button>
              </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-hidden="true">
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
                      ), array(), 'id="payment-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Title</label>
                      <?php print $this->form_eksternal->form_input('title', "", 'class="form-control input-sm" id="payment-title" placeholder="Title"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-8">
                      <label>Nominal</label>
                      <?php print $this->form_eksternal->form_input('price', "", 'class="form-control input-sm harga" id="payment-price" placeholder="Nominal"');?>
                    </div>
                    <div class="col-xs-4">
                      <label>Qty</label>
                      <?php print $this->form_eksternal->form_input('qty', "", 'class="form-control input-sm" id="payment-qty" placeholder="Qty"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Pos</label>
                      <?php print $this->form_eksternal->form_dropdown('pos', array(1 => "Penambahan", 2 => "Pengurangan"), array(), 'id="payment-pos" class="form-control input-sm"');?>
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
