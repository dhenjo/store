<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-success">
        <div class="box-header">
            <h3 class="box-title">Itin</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>Title</dt>
              <dd><?php
              $book = explode("|", $detail[0]->tour);
              print $book[1];
              ?></dd>
            <dt>Code</dt>
              <dd><?php print print $book[2];?></dd>
            <dt>Days</dt>
              <dd><?php print $book[3]." days ".$book[4]." nights";?></dd>
          </dl>
          <div class="row">
            <div class="col-xs-12">
              <a data-toggle='modal' data-target='#duplicate' href="#" class="btn btn-primary"><?php print lang("Duplicate")?></a>
              <a href="<?php print site_url("tour/tour-series/close-tour-information/{$kode}")?>" class="btn btn-success"><?php print lang("Close Tour")?></a>
              <a href="<?php print site_url("tour/tour-series/cancel-tour-information/{$kode}")?>" class="btn btn-danger"><?php print lang("Cancel")?></a>
              <a href="<?php print site_url("tour/tour-series/schedule/{$book[2]}")?>" class="btn btn-warning"><?php print lang("Back")?></a>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Schedule</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-6">
                <label>Kode PS</label>
                <?php print $this->form_eksternal->form_input('kode_ps', $detail[0]->kode_ps,'class="form-control input-sm" placeholder="Kode PS"')?>
              </div>
              <div class="col-xs-6">
                <label>At Airport</label>
                <?php print $this->form_eksternal->form_input('at_airport', $detail[0]->at_airport,'class="form-control input-sm time" placeholder="At Airport"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Tanggal Keberangkatan</label>
                <?php print $this->form_eksternal->form_input('start_date', $detail[0]->start_date,'class="form-control input-sm tanggal" placeholder="Tanggal"')?>
              </div>
              <div class="col-xs-6">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('start_time', $detail[0]->start_time,'class="form-control input-sm time" placeholder="Waktu"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Tanggal Tiba</label>
                <?php print $this->form_eksternal->form_input('end_date', $detail[0]->end_date,'class="form-control input-sm tanggal" placeholder="Tanggal"')?>
              </div>
              <div class="col-xs-6">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('end_time', $detail[0]->end_time,'class="form-control input-sm time" placeholder="Waktu"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label>Seat</label>
                <?php print $this->form_eksternal->form_input('available_seat', $detail[0]->available_seat,'class="form-control input-sm" placeholder="Seat"')?>
              </div>
              <div class="col-xs-4">
                <label>Keberangkatan</label>
                <?php print $this->form_eksternal->form_input('keberangkatan', $detail[0]->keberangkatan,'class="form-control input-sm" placeholder="Keberangkatan"')?>
              </div>
              <div class="col-xs-4">
                <label>STS</label>
                <?php print $this->form_eksternal->form_input('sts', $detail[0]->sts,'class="form-control input-sm" placeholder="STS"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-4">
                <label>Flight</label>
                <?php print $this->form_eksternal->form_input('flt', $detail[0]->flt,'class="form-control input-sm" placeholder="Flight"')?>
              </div>
              <div class="col-xs-4">
                <label>IN</label>
                <?php print $this->form_eksternal->form_input('in', $detail[0]->in,'class="form-control input-sm" placeholder="IN"')?>
              </div>
              <div class="col-xs-4">
                <label>OUT</label>
                <?php print $this->form_eksternal->form_input('out', $detail[0]->out,'class="form-control input-sm" placeholder="Out"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Adult Triple/Twin (IDR)</label>
                <?php print $this->form_eksternal->form_input('adult_triple_twin', str_replace(".00", "", $detail[0]->adult_triple_twin),'class="form-control input-sm harga" placeholder="Adult Triple/Twin"')?>
              </div>
              <div class="col-xs-6">
                <label>Sgl SUPP (IDR)</label>
                <?php print $this->form_eksternal->form_input('sgl_supp', str_replace(".00", "", $detail[0]->sgl_supp),'class="form-control input-sm harga" placeholder="Sgl SUPP"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Child Twin Bed (IDR)</label>
                <?php print $this->form_eksternal->form_input('child_twin_bed', str_replace(".00", "", $detail[0]->child_twin_bed),'class="form-control input-sm harga" placeholder="Child Twin Bed"')?>
              </div>
              <div class="col-xs-6">
                <label>Child Extra Bed (IDR)</label>
                <?php print $this->form_eksternal->form_input('child_extra_bed', str_replace(".00", "", $detail[0]->child_extra_bed),'class="form-control input-sm harga" placeholder="Child Extra Bed"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Child No Bed (IDR)</label>
                <?php print $this->form_eksternal->form_input('child_no_bed', str_replace(".00", "", $detail[0]->child_no_bed),'class="form-control input-sm harga" placeholder="Child No Bed"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Harga Visa (IDR)</label>
                <?php print $this->form_eksternal->form_input('visa', str_replace(".00", "", $detail[0]->visa),'class="form-control input-sm harga" placeholder="Visa"')?>
              </div>
              <div class="col-xs-6">
                <label>Airport Tax (IDR)</label>
                <?php print $this->form_eksternal->form_input('airport_tax', str_replace(".00", "", $detail[0]->airport_tax),'class="form-control input-sm harga" placeholder="Airport Tax"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Less Ticket Adult (IDR)</label>
                <?php print $this->form_eksternal->form_input('less_ticket_adl', str_replace(".00", "", $detail[0]->less_ticket_adl),'class="form-control input-sm harga" placeholder="Less Ticket Adult"')?>
              </div>
              <div class="col-xs-6">
                <label>Less Ticket Child (IDR)</label>
                <?php print $this->form_eksternal->form_input('less_ticket_chl', str_replace(".00", "", $detail[0]->less_ticket_chl),'class="form-control input-sm harga" placeholder="Less Ticket Child"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Status</label>
                <?php print $this->form_eksternal->form_dropdown('tampil', array(1 => "Publish", 2 => "Draft", 3 => "Delete"), array($detail[0]->tampil),'class="form-control input-sm"')?>
              </div>
              <div class="col-xs-6">
                <label>Condition</label>
                <?php print $this->form_eksternal->form_dropdown('status', array(1 => "Available", 5 => "Push Selling"), array($detail[0]->status),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Public Sales (Sub Agent & Website)</label>
                <?php print $this->form_eksternal->form_dropdown('umum', array(1 => "Internal", 2 => "Umum"), array($detail[0]->umum),'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Remarks</label>
                <?php print $this->form_eksternal->form_textarea('remarks', $detail[0]->remarks,'class="form-control input-sm" placeholder="Remarks"')?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <br />
              <button class="btn btn-primary" type="submit">Submit</button>
              <a href="<?php print site_url("tour/tour-series/schedule/{$book[2]}")?>" class="btn btn-warning"><?php print lang("Back")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>


<div class="modal fade" id="duplicate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Relasi Itin</h4>
            </div>
            <form action="<?php print site_url("tour/tour-series/duplicate-tour-information/{$kode}")?>" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <div class="checkbox">
                      <label>
                        <input type="checkbox" name="relasi" value="1" />
                          Duplikasi dengan relasi Itin
                      </label>
                  </div>
                </div>
              </div>
              <div class="modal-footer clearfix">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-primary pull-left"> Submit</button>
              </div>
            </form>
        </div>
    </div>
</div>