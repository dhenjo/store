<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Contact Person</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-12">
                <label>Departure</label>
                <?php 
                print $this->form_eksternal->form_input('departure', $detail[0]->departure, 
                  'class="form-control input-sm tanggal" placeholder="Departure"');?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Name</label>
                <?php print $this->form_eksternal->form_input('name', $detail[0]->name,'class="form-control input-sm" placeholder="Name"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Email</label>
                <?php print $this->form_eksternal->form_input('email', $detail[0]->email,'class="form-control input-sm" placeholder="Email"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Telp</label>
                <?php print $this->form_eksternal->form_input('telp', $detail[0]->telp,'class="form-control input-sm" placeholder="Telp"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Address</label>
                <?php print $this->form_eksternal->form_textarea('address', $detail[0]->address,'class="form-control input-sm" placeholder="Address"')?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <br />
              <button class="btn btn-primary" type="submit">Book</button>
              <a href="<?php print site_url("tour/fit-hotel")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>
