<div class="row">
  <div class="col-xs-6">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">FIT Detail</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <table class="table table-striped">
            <tr>
              <th>FIT Code</th>
              <th><?php print $book[0]->fit_schedule?></th>
            </tr>
            <tr>
              <th>Validity</th>
              <td><?php print date("d M y", strtotime($book[0]->start_date))." - ".date("d M y", strtotime($book[0]->end_date))?></td>
            </tr>
            <tr>
              <th>Hotel</th>
              <td><?php print $book[0]->hotel?></td>
            </tr>
            <tr>
              <th>Description</th>
              <td><?php print $book[0]->desc?></td>
            </tr>
            <tr>
              <th>Stars</th>
              <td><?php
              $stars = "";
              for($r = 1 ; $r <= 5 ; $r++){
                if($book[0]->stars >= $r){
                  $stars .= "<i style='color: yellow' class='fa fa-fw fa-star'></i>";
                }
                else{
                  $stars .= "<i class='fa fa-fw fa-star-o'></i>";
                }
              }
              print $stars?></td>
            </tr>
            <tr>
              <th>Remarks</th>
              <td><?php print nl2br($book[0]->remarks)?></td>
            </tr>
          </table>
        </div>
    </div>
  </div>
  <div class="col-xs-6">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Book Detail</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <table class="table table-striped">
            <tr>
              <th>Book Code</th>
              <th><?php print $kode?></th>
            </tr>
            <tr>
              <th>Book Date</th>
              <td><?php print $book[0]->tanggal?></td>
            </tr>
            <tr>
              <th>Timelimit</th>
              <td><?php print $book[0]->date_limit." ".$book[0]->time_limit?></td>
            </tr>
            <tr>
              <th>Name</th>
              <td><?php print $book[0]->name?></td>
            </tr>
            <tr>
              <th>Email</th>
              <td><?php print $book[0]->email?></td>
            </tr>
            <tr>
              <th>Telp</th>
              <td><?php print $book[0]->telp?></td>
            </tr>
            <tr>
              <th>Departure</th>
              <td><?php print $book[0]->departure?></td>
            </tr>
            <tr>
              <th>Status</th>
              <td><?php 
              $status = array(
                1     => "<span class='label label-default'>Draft</span>",
                2     => "<span class='label label-info'>Price Request</span>",
                3     => "<span class='label label-info'>Add Price</span>",
                4     => "<span class='label label-success'>Book</span>",
                5     => "<span class='label label-danger'>Cancel</span>",
                6     => "<span class='label label-success'>Departured</span>",
              );
              print $status[$book[0]->status];
              if($book[0]->status == 3){
                print " <a href='".site_url("tour/request-tour-fit/{$kode}/4")."' class='btn btn-warning btn-sm' data-widget='collapse'>Confirm</a>";
              }
              ?></td>
            </tr>
            <tr>
              <th>Address</th>
              <td><?php print $book[0]->address?></td>
            </tr>
          </table>
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h3 class="box-title">Passenger</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <?php
                if($book[0]->status == 1){
                ?>
                <a class="btn btn-warning btn-sm" href="<?php print site_url("tour/request-tour-fit/{$kode}")?>">Request Tour</a>
                <?php }?>
            </div>
        </div>
        <div class="box-body">
          <table id="table-pax" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Type</th>
                <th>Bed Type</th>
                <th>Name</th>
                <th>Telp</th>
                <th>No Passport</th>
                <th>Status</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $type = array(
                1 => "Adult",
                2 => "Child",
                3 => "Infant"
              );
              $bed_type = array(
                1 => "TWN",
                2 => "SGL SUPP",
                3 => "X-BED"
              );
              $status = array(
                1 => "<span class='label label-success'>Active</span>",
                2 => "<span class='label label-danger'>Cancel</span>",
              );
              foreach($pax AS $dbp){
                $btn_pax = "<button type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-pax' isi='{$dbp->kode}'>"
                  . "<i class='fa fa-edit'></i>"
                . "</button>"
                . "<button type='button' class='btn btn-danger tour-delete' data-toggle='modal' data-target='#edit-keterangan-cancel' isi='{$dbp->customer_code}' class='btn btn-danger' id='id-customer-cancel'>"
                  . "<i class='fa fa-times'></i>"
                . "</button>";
                print "<tr>"
                  . "<td>{$type[$dbp->pax_type]}</td>"
                  . "<td>{$bed_type[$dbp->type]}</td>"
                  . "<td>{$dbp->first_name} {$dbp->last_name}</td>"
                  . "<td>{$dbp->telp}</td>"
                  . "<td>{$dbp->passport}</td>"
                  . "<td>{$status[$dbp->status]}</td>"
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
                  <button id="add-pax" type='button' class='btn btn-success tour-edit-pax' data-toggle='modal' data-target='#edit-detail-pax' isi=''>
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

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-warning">
        <div class="box-header">
            <h3 class="box-title">Price</h3>
            <div class="box-tools pull-right">
                <a class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></a>
                <a class="btn btn-info btn-sm" href="<?php print site_url("tour/payment-tour-fit/{$kode}")?>">Payment</a>
            </div>
        </div>
        <div class="box-body">
          <table id="table-price" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Note</th>
                <th>Qty</th>
                <th>Price/qty</th>
                <th colspan="2">Total</th>
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
                <td colspan="3"></td>
                <td style='text-align: right'><b><?php print number_format($total_kredit)?></b></td>
                <td style='text-align: right'><b><?php print number_format($total_debit)?></b></td>
              </tr>
              <tr>
                <td colspan="4"></td>
                <td style='text-align: right'><b><?php print number_format($total_kredit-$total_debit)?></b></td>
              </tr>
            </tfoot>
          </table>
        </div>
    </div>
  </div>
</div>



<div class="modal fade" id="edit-detail-pax" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Pax</h4>
            </div>
            <form action="<?php print site_url("tour/edit-book-fit-pax")?>" method="post">
              <div class="box-body" style="padding: 10px">
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Title</label>
                      <?php print $this->form_eksternal->form_dropdown('title', array(1 => "Mr", 2 => "Mrs"), array(), 'id="edit-title" class="form-control input-sm"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Type</label>
                      <?php print $this->form_eksternal->form_dropdown('pax_type', array(1 => "Adult", 2 => "Child", 3 => "Infant"), array(), 'id="edit-pax-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>First Name</label>
                      <?php print $this->form_eksternal->form_input('first_name', "", 'id="edit-first-name" class="form-control input-sm" placeholder="First Name"');?>
                      <?php print $this->form_eksternal->form_input('book_code', $kode, 'style="display: none"');?>
                      <?php print $this->form_eksternal->form_input('pax_code', "", 'id="edit-pax-kode" style="display: none"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Last Name</label>
                      <?php print $this->form_eksternal->form_input('last_name', "", 'id="edit-last-name" class="form-control input-sm" placeholder="Last Name"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Telp</label>
                      <?php print $this->form_eksternal->form_input('telp', "", 'class="form-control input-sm" id="edit-telp" placeholder="No Telp"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Bed Type</label>
                      <?php print $this->form_eksternal->form_dropdown('type', array(1 => "TWN", 2 => "SGL SUPP", 3 => "X-BED"), array(), 'id="edit-type" class="form-control input-sm"');?>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Tempat Lahir</label>
                      <?php print $this->form_eksternal->form_input('tempat_lahir', "", 'id="edit-tempat-lahir" class="form-control input-sm" placeholder="Place Of Birth"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Tanggal Lahir</label>
                      <?php print $this->form_eksternal->form_input('tanggal_lahir', "", 'id="edit-tanggal-lahir" class="form-control input-sm tanggal" placeholder="Tanggal Lahir"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>No Passport</label>
                      <?php print $this->form_eksternal->form_input('passport', "", 'id="edit-passport" class="form-control input-sm" placeholder="No Passport"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Place Of Issued</label>
                      <?php print $this->form_eksternal->form_input('tempat_passport', "", 'id="edit-tempat-passport" class="form-control input-sm" placeholder="Place Of Issue"');?>
                    </div>
                    
                  </div>
                  
                  <div class="row">
                    <div class="col-xs-6">
                      <label>Date Of Issued</label>
                      <?php print $this->form_eksternal->form_input('tanggal_passport', "", 'id="edit-tanggal-passport" class="form-control input-sm tanggal" placeholder="Date Of Issued"');?>
                    </div>
                    <div class="col-xs-6">
                      <label>Date Of Expired</label>
                      <?php print $this->form_eksternal->form_input('expired_passport', "", 'id="edit-expired-passport" class="form-control input-sm tanggal" placeholder="Date Of Expired"');?>
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