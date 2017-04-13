<div class="row">
  <div class="col-md-12">
    <div class="box box-info box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><?php print $title?></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <a href="<?php print site_url("payment/ttu-create/{$id_inventory}")?>" class="btn btn-box-tool"><i class="fa fa-plus"></i></a>
        </div>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php print lang("Tanggal")?></th>
              <th><?php print lang("No TTU")?></th>
              <th><?php print lang("Agent")?></th>
              <th><?php print lang("Status")?></th>
              <th><?php print lang("Nominal")?></th>
              <th><?php print lang("Option")?></th>
            </tr>
          </thead>
          <tbody>
          <?php
          $status = array(
            2 => "<label class='label label-primary'>Payment</label>",
            3 => "<label class='label label-danger'>Reject</label>",
            4 => "<label class='label label-success'>Confirm</label>",
          );
          
          $ttu = "";
          foreach($data AS $dt){
	          
	          if($this->session->userdata("id") == 1 OR $this->nbscache->get_olahan("permission", $this->session->userdata("id_privilege"), "show-ttu", "edit") !== FALSE){
              $ttu .= "<a href='".site_url("tour/tour-payment/ttu/{$dt->id_product_tour_book_payment}")."' class='btn btn-success'>"
                  . "<i class='fa fa-money'></i>"
                . "</a>";
          }
          
            print "<tr>"
              . "<td>{$dt->tanggal}</td>"
              . "<td>{$dt->no_ttu}</td>"
              . "<td>".($dt->id_users ? $this->global_models->get_field("m_users", "name", array("id_users" => $dt->id_users)) : "")."</td>"
              . "<td>{$status[$dt->status]}</td>"
              . "<td>".number_format($dt->nominal)."</td>"
              . "<td>"
                . "<a href='".site_url("store/print-store/ttu-indie/{$dt->id_product_tour_book_payment}")."' target='_blank' class='btn btn-warning'>"
                    . "<i class='fa fa-search'></i>"
                . "</a>"
                . "<a href='".site_url("store/print-store/ttu-kwitansi/{$dt->id_product_tour_book_payment}")."' target='_blank' class='btn btn-info'>"
                    . "<i class='fa fa-print'></i>"
                . "</a>"
                . $ttu
              . "</td>"
            . "</tr>";
          }
          ?>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
