<!--<?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => $this->session->userdata("id_product_tour"),"id_detail_info" => $this->session->userdata("id_product_tour_information")))?>
-->
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
                                <?php print $this->form_eksternal->form_input('first_name', $data->first_name, 'disabled id="tfirst1" class="form-control input-sm" placeholder="First Name"');?>
                                
                               
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                 <?php print $this->form_eksternal->form_input('first_name', $data->last_name, 'disabled id="tfirst1" class="form-control input-sm" placeholder="Last Name"');?>
                                
                               
                                </div>
                                <div class="control-group">
                                <label>Email</label>
                                 <?php print $this->form_eksternal->form_input('first_name', $data->email, 'disabled id="tfirst1" class="form-control input-sm" placeholder="Email"');?>
                                
                               
                                </div>
                                <div class="control-group">
                                <label>No Telp</label>
                                 <?php print $this->form_eksternal->form_input('telp', $data->telp, 'disabled id="tfirst1" class="form-control input-sm" placeholder="telp"');?>
                                
                                </div>
                            </div>
                        </div>
    </div>
    <?php
          foreach ($customer_adult as $key => $adl) {
    
     $no = $key;
     $no = $no + 1;
     ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php print $data = $no + 1; ?>">
                                Customer <?php print $no++; ?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse<?php print $data;?>" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_name', $adl->first_name, 'disabled id="tfirst1" class="form-control input-sm" placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_name[1]', $adl->last_name, 'disabled id="tlast1" class="form-control input-sm" placeholder="Nama Belakang"');?>
                                </div>
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('date[1]', $adl->tanggal_lahir, 'disabled class="form-control input-sm start_date" placeholder="Tanggal Lahir"');?>
                               
                                </div>
                                
                            </div>
                        </div>
    </div>
     <?php
   
       }
        
        
     ?>
    
    <?php
        foreach ($customer_child as $key => $chl) {
    
     $no1 = $key;
     $no1 = $no1 + 1;
    ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_chd<?php print $data1 = $no1 + 1; ?>">
                                 Customer Anak <?php print $no1++; ?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse_chd<?php print $data1 ?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_namec', $chl->first_name, 'disabled class="form-control input-sm " placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_namec', $chl->last_name, 'disabled class="form-control input-sm " placeholder="Nama Belakang"');?>
                                </div>
                                
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('datec[]', $chl->tanggal_lahir, 'disabled class="form-control input-sm start_date" placeholder="Tanggal Lahir"');?>
                                </div>
                            </div>
                        </div>
    </div>
    <?php
       }
    ?>
    <?php
        foreach ($customer_inf as $key => $inf) {
    
     $no2 = $key;
     $no2 = $no2 + 1;
    ?>
    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_inf<?php print $data2 = $no2 + 1; ?>">
                                 Customer Bayi <?php print $no2++; ?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapse_inf<?php print $data2; ?>" class="panel-collapse collapse">
                            <div class="box-body">
                                <div class="control-group">
                                <label>Nama Depan</label>
                                <?php print $this->form_eksternal->form_input('first_namei[]', $inf->first_name, 'disabled class="form-control input-sm " placeholder="Nama Depan"');?>
                                </div>
                                <div class="control-group">
                                <label>Nama Belakang</label>
                                <?php print $this->form_eksternal->form_input('last_namei[]', $inf->last_name, 'disabled class="form-control input-sm " placeholder="Nama Belakang"');?>
                                </div>
                                
                                <div class="control-group">
                                <label>Tanggal Lahir</label>
                                <?php print $this->form_eksternal->form_input('datei[]', $inf->tanggal_lahir, 'disabled class="form-control input-sm start_date" placeholder="Tanggal Lahir"');?>
                                </div>
                            </div>
                        </div>
    </div>
    <?php }?>
</div>

