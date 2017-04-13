<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Payment</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array())?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-12">
                <label>Nomor TTU</label>
                <?php print $this->form_eksternal->form_input('nomor_ttu', "",'class="form-control input-sm" placeholder="Nomor TTU"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Nomor Deposite</label>
                <?php print $this->form_eksternal->form_input('nomor', "",'class="form-control input-sm" placeholder="Nomor Deposite"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Nominal</label>
                <?php print $this->form_eksternal->form_input('price', "", 'class="form-control input-sm harga" placeholder="Nominal"')?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <br />
              <button class="btn btn-primary" type="submit">Submit</button>
              <a href="<?php print site_url("tour/book-fit-detail/{$kode}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>