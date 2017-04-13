<thead>
    <tr>
        <th>Tanggal Book</th>
        <th>Book Code</th>
        <th>Tipe</th>
        <th>Pemesan</th>
        <th>Time Limit</th>
        <th>Tiket No</th>
        <th>Payment</th>
        <th>Status</th>
        <th>Harga</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $status = array(
      1 => "<span class='label label-default'>Proses</span>",
      3 => "<span class='label label-success'>Issued</span>",
      4 => "<span class='label label-warning'>Cancel</span>",
    );
    $r = date("Y-m-d");
    $detail_harga = "";
    foreach ($data as $key => $value) {
      $tipe = "One Way";
      $items = $this->global_models->get("tiket_flight_items", array("id_tiket_flight" => $value->id_tiket_flight));
      $items1st = $penerbangan_kembali = $penumpang = "";
      foreach($items AS $itm){
        $items1st .= $itm->flight_no." {$itm->dari} - {$itm->ke} ".date("Y/M/d H:s", strtotime($itm->departure))."-".date("H:s", strtotime($itm->arrive))."<br />";
      }
      if($value->id_tiket_flight2nd){
        $tipe = "Round Trip";
        $items2nd = "";
        $items2 = $this->global_models->get("tiket_flight_items", array("id_tiket_flight" => $value->id_tiket_flight2nd));
        foreach($items2 AS $itm){
          $items2nd .= $itm->flight_no." {$itm->dari} - {$itm->ke} ".date("Y/M/d H:s", strtotime($itm->departure))."-".date("H:s", strtotime($itm->arrive))."<br />";
        }
        $penerbangan_kembali = "<tr><td><h4>Penerbangan {$this->global_models->array_kota($value->dr)} - {$this->global_models->array_kota($value->k)}</h4><td></tr><tr><td>{$items2nd}<td></tr>";
      }
      $items_penumpang = $this->global_models->get_query("SELECT B.*, A.harga, A.harga2nd"
        . " FROM tiket_book_passenger AS A"
        . " LEFT JOIN tiket_passenger AS B ON A.id_tiket_passenger = B.id_tiket_passenger"
        . " WHERE A.id_tiket_book = '{$value->id_tiket_book}'");
      $type = array(
        1 => "Adult", 2 => "Child", 3 => "Infant"
      );
      
      foreach($items_penumpang AS $ip){
        $penumpang .= "<tr><td>{$ip->title} {$ip->first_name} {$ip->last_name} ".date("Y M d", strtotime($ip->tanggal_lahir))." {$type[$ip->type]} "
        . number_format(($ip->harga + $ip->harga2nd),0,",",".")." </td></tr>";
      }
      
//      $hemat_view = '';
//      if($value->hemat > 0){
//        $hemat_view = ""
//          . "<tr>"
//            . "<td>Hemat Pembayaran</td>"
//            . "<td style='text-align: right'>".number_format($value->infant,0,",",".")."</td>"
//          . "</tr>"
//          . "";
//      }
      
      $detail_harga = "<table width='100%'>"
        . "<tr>"
          . "<td>Penerbangan Pergi</td>"
          . "<td style='text-align: right'>".number_format($value->price,0,",",".")."</td>"
        . "</tr>"
        . "<tr>"
          . "<td>Penerbangan Kembali</td>"
          . "<td style='text-align: right'>".number_format($value->child,0,",",".")."</td>"
        . "</tr>"
        . "<tr>"
          . "<td>Hemat</td>"
          . "<td style='text-align: right'>".number_format($value->infant,0,",",".")."</td>"
        . "</tr>"
        . "<tr>"
          . "<td>TOTAL</td>"
          . "<td style='text-align: right'>".number_format($value->bayar,0,",",".")."</td>"
        . "</tr>"
        . "</table>";
      
      print '
      <tr>
        <td>'.date("Y-m-d H:i:s", strtotime($value->tanggal)).'</td>
        <td>
          <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#book'.$value->id_tiket_book.'">
            '.$value->book_code.' '.$value->book2nd.'
          </a>
          <div class="modal fade" id="book'.$value->id_tiket_book.'" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"> '.$value->book_code.' '.$value->book2nd.'</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                          <table>
                            <tr>
                              <td><h4>Penerbangan '.$this->global_models->array_kota($value->dari).' - '.$this->global_models->array_kota($value->ke).'</h4><td>
                            </tr>
                            <tr>
                              <td>
                                '.$items1st.'
                              <td>
                            </tr>
                            '.$penerbangan_kembali.'
                            <tr>
                              <td><h4>Penumpang</h4><td>
                            </tr>
                            '.$penumpang.'
                          </table>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                      <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        </td>
        <td>'.$tipe.'</td>
        <td>
          '.$value->first_name.' '.$value->last_name.' <br />
          '.$value->email.' <br />
          '.$value->telphone.'
        </td>
        <td>'.date("Y-m-d H:i", strtotime($value->timelimit)).'</td>
        <td>'.$value->tiket_no.'</td>
        <td>'.$value->cara_bayar.'</td>
        <td>'.$status[$value->status].'</td>
        <td style="text-align:right"><span style="display: none">'.$r.'</span>
          <a id="harga'.$value->id_tiket_book.'" href="javascript:void(0)">
            '.number_format($value->bayar, 0, ",", ".").'</a>
          <div style="display: none" id="isiharga'.$value->id_tiket_book.'">'.$detail_harga.'</div>
          <script>
          $(function() {
            $("#harga'.$value->id_tiket_book.'").tooltipster({
              content: $("#isiharga'.$value->id_tiket_book.'").html(),
                minWidth: 300,
                maxWidth: 300,
                contentAsHTML: true,
                interactive: true
            });
          });
          </script>
        </td>
      </tr>';
      $r++;
    }
  }
  ?>
</tbody>