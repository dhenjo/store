<?php

//print "<pre>";
//print_r($data); 
//print "</pre>";
//die; 
?>
<thead>
    <tr>
        <th>Tanggal</th>
        <th>Book</th>
        <th>No Deposite</th>
        <th>Users</th>
        <th>Confirm By</th>
        <th>Nominal</th>
        <th>Type</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  $status = array(
    1 => "<span class='label label-default'>Draft</span>",
    2 => "<span class='label label-info'>Deposite</span>",
    3 => "<span class='label label-danger'>Reject</span>",
    4 => "<span class='label label-success'>Confirm</span>",
  );
  
  $payment = array(
    1 => "Cash",
    2 => "BCA",
    3 => "Mega",
    4 => "Mandiri",
    5 => "Kartu Kredit",
    6 => "Mega Priority",
  );
  $total = 0;
  foreach($data AS $dt){
    $action = "<div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='".site_url('store/finance-accept/'.$dt->kode)."'>Terima</a></li>
              <li><a href='javascript:void(0)' class='tolak-payment' data-toggle='modal' data-target='#note-penolakan' isi='{$dt->kode}'>Tolak</a></li>
            </ul>
          </div>";
    if($dt->status == 4 OR $dt->status == 3){
      $action = "";
    }
  ?>
  <tr>
    <td><?php print $dt->tanggal?></td>
    <td><a href="<?php print site_url("grouptour/product-tour/book-information/{$dt->book_code}")?>"><?php print $dt->book_code?></a></td>
    <td><?php print $dt->no_deposit?><br /><?php print $dt->no_ttu?></td>
    <td><?php print $dt->bookers?><br /><?php print $dt->store1?><?php print $dt->store2?></td>
    <td><?php print $dt->confirm?></td>
    <td style="text-align: right"><?php print number_format($dt->nominal)?></td>
    <td><?php print $payment[$dt->payment]?></td>
    <td><?php print $status[$dt->status]?></td>
    <td><?php print $action?></td>
  </tr>
  <?php
    $total += $dt->nominal;
  }
  ?>
</tbody>
<tfoot>
  <tr>
    <th colspan="4">Total</th>
    <th style="text-align: right"><?php print number_format($total)?></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</tfoot>

<div class="modal fade" id="note-penolakan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Note</h4>
            </div>
            <?php print $this->form_eksternal->form_open("store/finance-reject", 'role="form"', array())?>
                <div class="modal-body">
                    <div class="form-group">
                      <?php print $this->form_eksternal->form_input("code_payment", "", "style='display:none' id='code-payment'");?>
                        <textarea name="note" id="email_message" class="form-control" placeholder="Message" style="height: 120px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="submit" class="btn btn-primary pull-left">Send</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>