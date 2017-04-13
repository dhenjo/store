<?php print $this->form_eksternal->form_open("grouptour/product-tour/send-passenger", 'role="form"', 
                    array(
                      "tour_code"               => $pst['tour_code'],
                      "tour_information_code"   => $pst['tour_information_code']
                    ))?>
<div class="control-group">
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="">
                                Contact Person
                            </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('ifirst_name', "", 'onblur="set_nama()" id="pemesan_depan" class="form-control input-sm" placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('ilast_name', "", 'onblur="set_nama()" id="pemesan_belakang" class="form-control input-sm" placeholder="Nama Belakang"');?>
                                </div>
                                <div class="control-group">
                                <label>Email</label>
                                <?php print $this->form_eksternal->form_input('iemail', "", 'class="form-control input-sm" placeholder="Email"');?>
                                </div>
                                <div class="control-group">
                                <label>No Telp</label>
                                <?php print $this->form_eksternal->form_input('itelp', "", 'class="form-control input-sm" placeholder="No Telp"');?>
                                </div>
                            </div>
                        </div>
    </div>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                Customer 1
                            </a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_name[1]', "", 'id="tfirst1" class="form-control input-sm" placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_name[1]', "", 'id="tlast1" class="form-control input-sm" placeholder="Nama Belakang"');?>
                                </div>
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('date[1]', "", 'class="form-control input-sm adult_date" placeholder="Tanggal Lahir"');?>
                                <?php print $this->form_eksternal->form_input("batas_dewasa", $pst['jml_adult'], "id='batas_dewasa' style='display:none'");?>
                                </div>
                                
                            </div>
                        </div>
    </div>
     <?php
        if($pst['jml_adult'] > 1){
            for($r = 2 ; $r <= $pst['jml_adult'] ; $r++){
     ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php print $r;?>">
                                Customer <?php print $r;?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse<?php print $r;?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input("first_name[]", "", 'class="form-control input-sm" placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input("last_name[]", "", 'class="form-control input-sm" placeholder="Nama Belakang"');?>
                                </div>
                                
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input("date[]", "", 'class="form-control input-sm adult_date" placeholder="Tanggal Lahir"');?>
                                </div>
                            </div>
                        </div>
    </div>
     <?php } }?> 
    <?php
    if($pst['jml_child'] > 0){
                      print $this->form_eksternal->form_input("batas_anak", $pst['jml_child'], "id='batas_anak' style='display:none'");
                      for($r = 1 ; $r <= $pst['jml_child'] ; $r++){
    ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_chd<?php print $r;?>">
                                 Customer Anak <?php print $r;?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse_chd<?php print $r;?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_namec[]', "", 'class="form-control input-sm " placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_namec[]', "", 'class="form-control input-sm " placeholder="Nama Belakang"');?>
                                </div>
                                
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('datec[]', "", 'class="form-control input-sm child_date" placeholder="Tanggal Lahir"');?>
                                </div>
                            </div>
                        </div>
    </div>
    <?php
       }}
    ?>
    <?php
    if($pst['jml_infant'] > 0){
                      print $this->form_eksternal->form_input("batas_bayi", $pst['jml_infant'], "id='batas_bayi' style='display:none'");
                      for($r = 1 ; $r <= $pst['jml_infant'] ; $r++){
    ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_inf<?php print $r;?>">
                                 Customer Bayi <?php print $r;?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse_inf<?php print $r;?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_namei[]', "", 'class="form-control input-sm " placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_namei[]', "", 'class="form-control input-sm " placeholder="Nama Belakang"');?>
                                </div>
                                
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('datei[]', "", 'class="form-control input-sm infant_date" placeholder="Tanggal Lahir"');?>
                                </div>
                            </div>
                        </div>
    </div>
    <?php }}?>
</div>
<div class="box-footer">
              <center>    <button class="btn btn-primary" type="submit">BOOK</button> </center>
                  </div>
</form>