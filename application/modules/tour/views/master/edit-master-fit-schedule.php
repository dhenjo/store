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
              <div class="col-xs-3">
                <label>Validity</label>
                <?php 
                print $this->form_eksternal->form_input('start_date', $detail[0]->start_date, 
                  'class="form-control input-sm tanggal" placeholder="Start Date"');?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('end_date', $detail[0]->end_date,
                  'class="form-control input-sm tanggal" placeholder="End Date"')?>
              </div>
              <div class="col-xs-3">
                <label>Days</label>
                <?php print $this->form_eksternal->form_input('days', $detail[0]->days, 'class="form-control input-sm" placeholder="Days"')?>
              </div>
              <div class="col-xs-3">
                <label>Nights</label>
                <?php print $this->form_eksternal->form_input('nights', $detail[0]->nights,'class="form-control input-sm" placeholder="Nights"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Hotel</label>
                <?php print $this->form_eksternal->form_input('hotel', $detail[0]->hotel,'class="form-control input-sm" placeholder="Hotel"')?>
              </div>
              <div class="col-xs-4">
                <label>Desc</label>
                <?php print $this->form_eksternal->form_input('desc', $detail[0]->desc,'class="form-control input-sm" placeholder="Desc"')?>
              </div>
              <div class="col-xs-2">
                <label>Stars</label>
                <?php print $this->form_eksternal->form_dropdown('stars', array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5),array($detail[0]->stars),
                  'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3">
                <label>B'Fast</label>
                <?php print $this->form_eksternal->form_dropdown('bfast', array(1 => "N/A", 2 => "Include", 3 => "For 1 pax", 4 => "For 2 pax"),
                  array($detail[0]->stars), 'class="form-control input-sm"')?>
              </div>
              <div class="col-xs-3">
                <label>Price</label>
                <?php print $this->form_eksternal->form_input('bfast_price', $detail[0]->bfast_price,
                  'class="form-control input-sm harga" placeholder="Price"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $detail[0]->status;
                if(!$stat)
                  $stat = 1;
                print $this->form_eksternal->form_dropdown('status', array(0 => "- All -", 1 => "Publish", 2 => "Draft"),
                array($stat),'class="form-control input-sm"');
                ?>
              </div>
              <div class="col-xs-3">
                <label>TWN</label>
                <?php print $this->form_eksternal->form_input('twn', $detail[0]->twn,'class="form-control input-sm harga" placeholder="TWN"')?>
              </div>
              <div class="col-xs-3">
                <label>SGL SUPP</label>
                <?php print $this->form_eksternal->form_input('sgl', $detail[0]->sgl,'class="form-control input-sm harga" placeholder="SGL SUPP"')?>
              </div>
              <div class="col-xs-3">
                <label>X-BED</label>
                <?php print $this->form_eksternal->form_input('x_bed', $detail[0]->x_bed,'class="form-control input-sm harga" placeholder="X-BED"')?>
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
              <button class="btn btn-primary" type="submit">Search</button>
              <a href="<?php print site_url("tour/tour-master/manage-schedule-fit/{$kode}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>
