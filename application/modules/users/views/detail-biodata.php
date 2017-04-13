<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="box-tab">
          <div class="tabbable tabs-left"> 
            <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
              <li class="active"><a href="#C" data-toggle="tab">Biodata</a></li>
              <li><a href="#D" data-toggle="tab">Company</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="C">
                <div class="span6">
                  <div class="well">
                    <table width="100%">
                      <tr>
                        <td><a href="<?php print site_url("users/edit-biodata")?>" ><h4>Edit</h4></a></td>
                      </tr>
                      <tr>
                        <?php
                        $sex = array(1 => "Male", 2 => "Female");
                        $title = array('1' => "Mr", '2' => "Mrs", '3' => "Ms");
                        $status_alamat = array(1 => "Rumah Sendiri", 2 => "Kontrak", 3 => "Dengan Orang Tua", 4 => "Dengan Kerabat", 5 => "Lainnya");
                        $sim_a = "<span class='color-icons cross_co'></span>";
                        if($biodata[0]->driving_license_a)
                          $sim_a = "<span class='color-icons accept_co'></span>";
                        
                        $sim_b = "<span class='color-icons cross_co'></span>";
                        if($biodata[0]->driving_license_b)
                          $sim_b = "<span class='color-icons accept_co'></span>";
                        
                        $sim_c = "<span class='color-icons cross_co'></span>";
                        if($biodata[0]->driving_license_c)
                          $sim_c = "<span class='color-icons accept_co'></span>";
                        
                        $agama = array(1 => "Islam", 2 => "Kristen", 3 => "Hindu", 4 => "Budha", 5 => "Lainnya");
                        $martial_status = array(1 => "Menikah", 2 => "Janda/ Duda", 3 => "Single");
                        $status_employee = array(
                            1 => "<span class='label label-success'>Karyawan Kontrak</span>",
                            6 => "<span class='label label-success'>Karyawan Tetap</span>",
                            2 => "<span class='label label-info'>Habis Kontrak</span>",
                            3 => "<span class='label label-important'>Dipecat</span>",
                            4 => "<span class='label label-warning'>Scorsing</span>",
                            5 => "<span class='label label-info'>Cuti</span>",
                        );
                        
                        $photo = "no-pic.png";
                        if($biodata[0]->photo){
                          $photo = "hrm/prospective_employee/270/".$biodata[0]->photo;
                        }
                        ?>
                        <td width="90"><span class="user-thumb" style="width: 80px;height: 110px"><img src='<?php print base_url()."files/".$photo?>' width='80' /></span></td>
                        <td valign="top">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th width="40%">Nama</th>
                                <td><?php print $title[$biodata[0]->title].". ".$biodata[0]->first_name." ".$biodata[0]->last_name?></td>
                              </tr>
                              <tr>
                                <th>Sex</th>
                                <td><?php print $sex[$biodata[0]->sex]?></td>
                              </tr>
                              <tr>
                                <th>Telphone</th>
                                <td><?php print $biodata[0]->telphone." / ".$biodata[0]->handphone?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th width="40%">Tinggi/Berat Badan</th>
                                <td><?php print $biodata[0]->tinggi_badan." / ".$biodata[0]->berat_badan?></td>
                              </tr>
                              <tr>
                                <th>Tempat/Tgl Lahir</th>
                                <td><?php print $biodata[0]->tempat_lahir." / ".$biodata[0]->tanggal_lahir?></td>
                              </tr>
                              
                              <tr>
                                <th>Alamat</th>
                                <td><?php print $biodata[0]->address?></td>
                              </tr>
                              <tr>
                                <th>Status Alamat</th>
                                <td><?php print $status_alamat[$biodata[0]->status_tinggal]?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="span6">
                  <div class="well">
                    <table width="100%">
                      <tr>
                        <td colspan="2">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th width="40%">No KTP</th>
                                <td><?php print $biodata[0]->card_id?></td>
                              </tr>
                              <tr>
                                <th>About Us</th>
                                <td><?php print $biodata[0]->about_us?></td>
                              </tr>
                              <tr>
                                <th>Note</th>
                                <td><?php print $biodata[0]->note?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              
              <div class="tab-pane" id="D">
                <div class="span6">
                  <div class="well">
                    <table width="100%">
                      <tr>
                        <td><a href="<?php print site_url("portal/client-portal/add-new-company")?>" ><h4>Edit</h4></a></td>
                      </tr>
                      <tr>
                        <?php
                        
                        $logo = "no-pic.png";
                        if($company[0]->logo){
                          $logo = "portal/company/logo/".$company[0]->logo;
                        }
                        ?>
                        <td width="90"><span class="user-thumb" style="width: 80px;height: 110px"><img src='<?php print base_url()."files/".$logo?>' width='80' /></span></td>
                        <td valign="top">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th width="40%">Nama</th>
                                <td><?php print $company[0]->title?></td>
                              </tr>
                              <tr>
                                <th>Email</th>
                                <td><?php print $company[0]->email?></td>
                              </tr>
                              <tr>
                                <th>Bidang Usaha</th>
                                <td><?php print $company[0]->bidang_usaha?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th>Telphone</th>
                                <td><?php print $company[0]->telphone." / ".$company[0]->handphone?></td>
                              </tr>
                              <tr>
                                <th width="40%">BBM</th>
                                <td><?php print $company[0]->bbm?></td>
                              </tr>
                              <tr>
                                <th>Facebook</th>
                                <td><?php print $company[0]->facebook?></td>
                              </tr>
                              
                              <tr>
                                <th>Alamat</th>
                                <td><?php print $company[0]->address?></td>
                              </tr>
                              <tr>
                                <th>Propinsi</th>
                                <td><?php print $company[0]->propinsi?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="span6">
                  <div class="well">
                    <table width="100%">
                      <tr>
                        <td colspan="2">
                          <table class="table table-bordered table-striped">
                            <thead>
                            </thead>
                            <tbody>
                              <tr>
                                <th>About Us</th>
                                <td><?php print $company[0]->about_us?></td>
                              </tr>
                              <tr>
                                <th>Note</th>
                                <td><?php print $company[0]->note?></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
