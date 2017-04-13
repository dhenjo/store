<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_users" => $id_users, "id_hrm_prospective_biodata" => $detail[0]->id_hrm_prospective_biodata))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_dropdown('title', array('1' => "Mr", '2' => "Mrs", '3' => "Ms"), array($detail[0]->title), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>First Name</label>
                    <?php print $this->form_eksternal->form_input('first_name', $detail[0]->first_name, 'class="form-control input-sm" placeholder="First Name"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Last Name</label>
                    <?php print $this->form_eksternal->form_input('last_name', $detail[0]->last_name, 'class="form-control input-sm" placeholder="Last Name"');
                    ?>
                </div>
                
                <div class="control-group">
                  <label>Sex</label>
                    <?php print $this->form_eksternal->form_dropdown('sex', array('1' => "Male", '2' => "Female"), array($detail[0]->sex), 'class="form-control input-sm"')?>
                </div>
                
                <label>Tinggi dan Berat Badan</label>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <?php print $this->form_eksternal->form_input('tinggi_badan', $detail[0]->tinggi_badan, 'class="form-control input-sm" placeholder="Tinggi Badan"')?>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group">
                            <?php print $this->form_eksternal->form_input('berat_badan', $detail[0]->berat_badan, 'class="form-control input-sm" placeholder="Berat Badan"')?>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div>
                
                <label>Tempat dan Tanggal Lahir</label>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <?php print $this->form_eksternal->form_input('tempat_lahir', $detail[0]->tempat_lahir, 'class="form-control input-sm" placeholder="Tempat Lahir"')?>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <div class="input-group">
                            <?php print $this->form_eksternal->form_input('tanggal_lahir', $detail[0]->tanggal_lahir, 'id="tanggal_lahir" class="form-control input-sm" placeholder="Tanggal Lahir"')?>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div>
                
                <div class="control-group">
                  <label>Avatar</label>
                  <?php print $this->form_eksternal->form_upload('photo', $detail[0]->photo, "class='input-sm'");
                  if($detail[0]->photo)
                    print "<br /><img src='".base_url()."files/hrm/prospective_employee/{$detail[0]->photo}' width='50' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>

                <div class="control-group">
                  <label>Alamat</label>
                      <?php print $this->form_eksternal->form_textarea('address', $detail[0]->address, 'class="form-control input-sm" id="editor1"')?>
                </div>
                
                <div class="control-group">
                  <label>Account FRM</label>
                  <?php print $this->form_eksternal->form_input('frm_account', $this->global_models->get_field("frm_account", "title", array("id_frm_account" => $detail[0]->id_frm_account)), 'class="form-control input-sm" id="frm_account"');
                  print $this->form_eksternal->form_input('id_frm_account', $detail[0]->id_frm_account, 'class="form-control input-sm" id="id_frm_account" style="display: none"');
                  ?>
                </div>
                
                <div class="control-group">
                  <label>Shipping</label>
                    <?php print $this->form_eksternal->form_dropdown('shipping', array('1' => "Reguler", '2' => "Free Shipping"), array($detail[0]->shipping), 'class="form-control input-sm"')?>
                </div>
                
              </div>
              
        </div><!-- /.box -->
    </div><!--/.col (left) -->
    <div class="col-md-6">
      <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <div class="box-body">
              
                <div class="control-group">
                  <label>Telphone</label>
                      <?php print $this->form_eksternal->form_input('telphone', $detail[0]->telphone, 'class="form-control input-sm" placeholder="Telphone"')?>
                </div>

                <div class="control-group">
                  <label>Handphone</label>
                      <?php print $this->form_eksternal->form_input('handphone', $detail[0]->handphone, 'class="form-control input-sm" placeholder="Handphone"')?>
                </div>

                <div class="control-group">
                  <label>Status Tempat Tinggal</label>
                      <?php print $this->form_eksternal->form_dropdown('status_tinggal', array(1 => "Pribadi", 2 => "Kontrak", '3' => "Dinas", 4 => "Orang Tua", 5 => "Saudara"), array($detail[0]->status_tinggal), 'class="form-control input-sm"')?>
                </div>

                <div class="control-group">
                  <label>KTP</label>
                      <?php print $this->form_eksternal->form_input('card_id', $detail[0]->card_id, 'class="form-control input-sm" placeholder="KTP"')?>
                </div>
              
              <div class="control-group">
                  <label>About Us</label>
                      <?php print $this->form_eksternal->form_textarea('about_us', $detail[0]->about_us, 'class="form-control input-sm" id="editor2"')?>
                </div>
              
              <div class="control-group">
                  <label>Note</label>
                      <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor3"')?>
                </div>
              
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("portal/master-portal/company")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
            </form>
              
            </div>
      </div>
    </div>
</div>   <!-- /.row -->