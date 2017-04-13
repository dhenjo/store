<div class="row">
 <div class="col-md-12">
    <div class="box-body">
      <table class="table table-condensed">
        <tr>
            <th style="width: 20%;">Nama Pemesan</th>
              <td><?php print $bk[1]." ".$bk[2];print $ttu[0]->first_name." ".$ttu[0]->last_name;?></td>
          </tr>  
        <tr>
            <th style="width: 20%;">Kode Book</th>
              <td><?php print $bk[0]; print $ttu[0]->kode?></td>
          </tr>
        <tr>
        <tr>
            <th style="width: 20%;">No TTU</th>
              <td><?php print $payment[0]->no_ttu; ?></td>
          </tr>
        <tr>
        <tr>
            <th style="width: 20%;">Total Bayar</th>
              <td><?php print number_format($payment[0]->nominal); ?></td>
          </tr>
        <tr>
          <th style="width: 20%;">Tanggungan</th>
          <td><?php 
          print ($tanggungan > 0 ? number_format($tanggungan) : number_format($ttu[0]->nominal));?></td>
        </tr>
        <tr>
          <th style="width: 20%;">Remark</th>
          <td><?php print nl2br($payment[0]->remark); ?></td>           
        </tr>
        <tr>
          <th style="width: 20%;">Type</th>
          <td><?php 
          $type = array(
            1 => "Tiket",
            2 => "Hotel",
            3 => "Tour"
          );
          print $type[$payment[0]->type]; ?></td>           
        </tr>
         <tr>
          <th style="width: 20%;">Pameran</th>
          <td><?php print $this->form_eksternal->form_dropdown('id_tour_pameran', $pameran, array($payment[0]->id_tour_pameran), 'onchange="pameran(this.value);" class="form-control input-sm select2"');?></td>           
        </tr>
        </table>
    </div>
  </div>
    <div class="col-md-12">
        <div class="box box-primary">
            <?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id" => $id))?>
              <div class="box-body" id="isi">
                <?php
                print ""
//                  . "<div class='row'>"
//                    . "<div class='col-xs-4'>"
//                      . "<label>Type</label><br />"
//                    . "</div>"
//                    . "<div class='col-xs-4'>"
//                      . "<label>Nominal</label><br />"
//                    . "</div>"
//                    . "<div class='col-xs-2'>"
//                      . "<label>MDR</label><br />"
//                    . "</div>"
//                    . "<div class='col-xs-2'>"
//                      . "<label>Status</label><br />"
//                    . "</div>"
//                  . "</div>"
                  . "";
                $type = array(
                  1 => "Tunai", 
                  2 => "Transfer BCA", 
                  3 => "Transfer Mega", 
                  4 => "Transfer Mandiri", 
                  5 => "CC Mega", 
                  7 => "Debit BCA", 
                  8 => "Debit Lainnya", 
                  9 => "CC BCA", 
                  10 => "CC Lainnya"
                );
                $status = array(
                  0 => "<label class='label label-primary'>Create</label>",
                  1 => "<label class='label label-danger'>Rejected</label>",
                  NULL => "<label class='label label-primary'>Create</label>",
                  2 => "<label class='label label-success'>Accepted</label>",
                );
                foreach($payment_list AS $pl){
                  if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "void-payment-ttu", "edit") !== FALSE){
                    $void = ""
                      . "<div class='col-xs-6'>"
                        . $this->form_eksternal->form_textarea("note_void[{$pl->id_tour_payment}]", "", "class='form-control input-sm'")
                      . "</div>"
                      . "<div class='col-xs-6'>"
                        . "<button type='submit' class='btn btn-danger' name='void' value='{$pl->id_tour_payment}'>".lang("Void")."</button>"
                      . "</div>"
                    . "";
                  }
                  print ""
                  . "<div class='row'>"
                    . "<div class='col-xs-4'>"
                      . "<label>Type</label><br />"
                      . "{$type[$pl->type]}"
                    . "</div>"
                    . "<div class='col-xs-4' style='text-align: right'>"
                      . "<label>Nominal</label><br />"
                      . number_format($pl->nominal)
                    . "</div>"
                    . "<div class='col-xs-2'>"
                      . "<label>MDR</label><br />"
                      . "{$pl->mdr} %"
                    . "</div>"
                    . "<div class='col-xs-2'>"
                      . "<label>Status</label><br />"
                      . "{$status[$pl->status]}"
                    . "</div>"
                  . "</div>"
                  . "<div class='row'>"
                    . "<div class='col-xs-4'>"
                      . "<label>Card Number</label><br />"
                      . $pl->number
                    . "</div>"
                    . "<div class='col-xs-4' style='text-align: right'>"
                      . "<label>Tanggal</label><br />"
                      . date("Y-m-d", strtotime($pl->tanggal))
                    . "</div>"
                    . "<div class='col-xs-4'>"
                      . "<label>Remarks</label><br />"
                      . nl2br($pl->remarks)
                    . "</div>"
                  . "</div>"
                  . "<div class='row'>"
                    . "{$void}"
                  . "</div>"
                  . "<hr />"
                  . "";
                  if($pl->status == 0 OR $pl->status == NULL OR $pl->status == 2)
                    $total += $pl->nominal;
                }
                if($payment[0]->nominal > $total){
                ?>
                <div class="row">
                  <div class="col-xs-4">
                    <label>Type</label>
                    <select class="form-control input-sm select2" name="type[]">
                      <optgroup label="Tunai">
                        <option value="1">Tunai</option>
                      </optgroup>
                      <optgroup label="Transfer">
                        <option value="3">Transfer Mega</option>
                        <option value="2">Transfer BCA</option>
                        <option value="4">Transfer Mandiri</option>
                      </optgroup>
                      <optgroup label="Debit">
                        <option value="7">Debit BCA</option>
                        <option value="14">Debit Mandiri</option>
                        <option value="15">Debit BNI</option>
                      </optgroup>
                      <optgroup label="Kartu Kredit">
                        <option value="9">Kartu Kredit BCA</option>
                        <option value="5">Kartu Kredit Mega</option>
                        <option value="21">Mega First Infinite</option>
                        <option value="11">Kartu Kredit BNI</option>
                        <option value="12">Kartu Kredit Mandiri</option>
                        <option value="13">Kartu Kredit Citibank</option>
                        <option value="10">Kartu Kredit Lainnya</option>
                      </optgroup>
                      <optgroup label="Others">
                        <option value="16">Travel Certificate</option>
                        <option value="17">Travel Voucher</option>
                        <option value="18">Voucher CT Corp</option>
                        <option value="19">Point Rewards</option>
                        <option value="20">Kupon</option>
                      </optgroup>
                    </select>
                  </div>
                  <div class="col-xs-4">
                    <label>Nominal</label>
                    <input type="text" name="nominal[]" class="form-control input-sm harga" placeholder="Nominal">
                  </div>
                  <div class="col-xs-2">
                    <label>MDR</label>
                    <input type="text" name="mdr[]" class="form-control input-sm harga" placeholder="MDR">
                  </div>
                  <div class="col-xs-2">
                    <label>Status</label>
                    &nbsp;
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-4">
                    <label>Card Number</label>
                    <input type="text" name="number[]" class="form-control input-sm" placeholder="Card Number">
                  </div>
                  <div class="col-xs-4">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal[]" value="<?php print date("Y-m-d")?>" class="form-control input-sm tanggal" placeholder="Tanggal">
                  </div>
                  <div class="col-xs-4">
                    <label>Remarks</label>
                    <textarea name="remark[]" class="form-control input-sm" placeholder="Remarks"></textarea>
                  </div>
                </div>
                <?php
                }
                ?>
              </div>
              <div class="box-footer">
                <?php
                if($payment[0]->nominal > $total){
                ?>
                  <button class="btn btn-success" type="button" id="add-type"><i class='fa fa-plus-square'></i></button><br /><br />
                  <button class="btn btn-primary" type="submit">Payment</button>
                <?php
                }
                ?>
                  <a href="<?php print $_SERVER['HTTP_REFERER']?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->