<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Quotation Request</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php echo validation_errors(); ?>
          <?php print $this->form_eksternal->form_open("", 'role="form" onsubmit="return validateForm()"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-6">
                <label>Client</label>
                <?php 
                print $this->form_eksternal->form_input('client', set_value('client'), 'class="form-control input-sm" placeholder="Client"');?>
              </div>
              <div class="col-xs-6">
                <label>Project Name</label>
                <?php 
                print $this->form_eksternal->form_input('title', set_value('title'), 'class="form-control input-sm" placeholder="Project Name"');?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Destination</label>
                <?php print $this->form_eksternal->form_input('destination', set_value('destination'),
                  'class="form-control input-sm" placeholder="Destination" id="destination"')?>
              </div>
              <div class="col-xs-3">
                <label>Period</label>
                <?php print $this->form_eksternal->form_input('departure', set_value('departure'),
                  'class="form-control input-sm tanggal" placeholder="Departure" id="departure"')?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('arrive', set_value('arrive'),
                  'class="form-control input-sm tanggal" placeholder="Arrive" id="arrive"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-3">
                <label>Adult</label>
                <?php print $this->form_eksternal->form_input('adult', set_value('adult'),'id="adult" class="form-control input-sm" placeholder="Adult"')?>
              </div>
              <div class="col-xs-3">
                <label>Child</label>
                <?php print $this->form_eksternal->form_input('child', set_value('child'),'class="form-control input-sm" placeholder="Child"')?>
              </div>
              <div class="col-xs-3">
                <label>Budget Range/Pax</label>
                <?php print $this->form_eksternal->form_input('budget_start', set_value('budget_start'),
                  'class="form-control input-sm harga" placeholder="Budget Range/Pax"')?>
              </div>
              <div class="col-xs-3">
                <label>&nbsp;</label>
                <?php print $this->form_eksternal->form_input('budget_end', set_value('budget_end'),
                  'class="form-control input-sm harga" placeholder="Budget Range/Pax"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Airline</label>
                <?php print $this->form_eksternal->form_input('airline', set_value('airline'),'id="airline" class="form-control input-sm" placeholder="Airline"')?>
              </div>
              <div class="col-xs-6">
                <label>Hotel Category</label>
                <?php print $this->form_eksternal->form_input('hotel', set_value('hotel'),'id="hotel" class="form-control input-sm" placeholder="Hotel Category"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <hr />
              </div>
            </div>
<!--            <div class="form-group">
              <div class="col-xs-12">
                <label>Date of Enquiry</label>
                <?php print $this->form_eksternal->form_input('tanggal', $detail[0]->tanggal,
                  'class="form-control input-sm tanggal" placeholder="Date of Enquiry"')?>
              </div>
              <div class="col-xs-6">
                <label>Fare Est</label>
                <?php print $this->form_eksternal->form_input('fare_est', $detail[0]->fare_est,
                  'class="form-control input-sm harga" placeholder="Fare Est"')?>
              </div>
            </div>-->
<!--            <div class="form-group">
              <div class="col-xs-12">
                <label>PNR</label>
                <?php print $this->form_eksternal->form_input('pnr', $detail[0]->pnr,'class="form-control input-sm" placeholder="PNR"')?>
              </div>
            </div>-->
<!--            <div class="form-group">
              <div class="col-xs-12">
                
              </div>
            </div>-->
            <div id="isi-add-tour">
              <div class="form-group first" id="first">
                <div class="col-xs-4">
                  <label>Itinerary (/day)</label>
                  <?php print $this->form_eksternal->form_textarea('itinerary[]', "",'class="form-control input-sm" placeholder="Itinerary"')?>
                </div>
                <div class="col-xs-4">
                  <label>Meal Plan</label>
                  <?php print $this->form_eksternal->form_dropdown('meal[]', array(0 => "None", 1 => "FB", 2 => "HB"), array(),
                    'class="form-control input-sm"')?>
                </div>
                <div class="col-xs-4">
                  <label>Specific</label>
                  <?php print $this->form_eksternal->form_textarea('specific[]', "",'class="form-control input-sm" placeholder="Specific"')?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <hr />
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <?php print $this->form_eksternal->form_input('nomor', 0, 'style="display: none"')?>
                <a href="javascript:void(0)" id="add-on-tour" class="btn btn-info"><i class="fa fa-plus"></i> Add Other Day</a>
                <a href="javascript:void(0)" isi="first" class="btn btn-danger delete-add-on-tour">X (last day)</a>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Other Request</label>
                <?php print $this->form_eksternal->form_textarea('other', set_value('other'),'class="form-control input-sm" placeholder="Other Request"')?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <br />
              <button class="btn btn-primary" type="submit">Book</button>
              <a href="<?php print site_url("tour/tour-fit/quotation-request")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>
