<div class="page-title-container">
    <div class="container">
        <div class="page-title pull-left">
            <h2 class="entry-title">Program Pendidikan Travel Consultant</h2>
        </div>
        <ul class="breadcrumbs pull-right">
            <li><a href="<?php print site_url()?>">Home</a></li>
            <li class="active">Program Pendidikan Travel Consultant</li>
        </ul>
    </div>
</div>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="sidebar col-sm-4 col-md-3">
                <?php print $this->global_models->alamat_contact_us()?>
            </div>
            <div id="main" class="col-sm-8 col-md-9">
            <div class="page">
                <span style="display: none;" class="entry-title page-title">Blog Left Sidebar</span>
                <span style="display: none;" class="vcard"><span class="fn"><a rel="author" title="Posts by admin" href="#">admin</a></span></span>
                <span style="display:none;" class="updated">2014-06-20T13:35:34+00:00</span>
                <div class="post-content">
                    <div class="blog-infinite">
                        <div class="post">
                            <div class="post-content-wrapper">
                                <div class="details">
                                    <div class="row">
                                      <div class="box col-sm-6 col-md-7">
                                          <div class="icon-box box style8 style12">
                                              <div style="text-align: center">
                                                  <img src="<?php print $url."images/1392955426.jpg"?>" width="100%" />
                                              </div>
                                          </div>
                                      </div>
                                      <div class="box col-sm-6 col-md-5">
                                          <div class="icon-box box style8 style12">
                                              <div style="text-align: justify">
                                                  <?php print $this->form_eksternal->form_open_multipart("", 'role="form"')?>
                                                  <h4 style="color: #1a6ea5">
                                                      <a href="<?php print site_url("page/index/corporate-travel")?>">
                                                          <span style="color: #bd2330">KIRIMKAN SURAT LAMARAN </span> 
                                                          <br />DAN CV KAMU SEKARANG.
                                                      </a>
                                                  </h4>
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <label>Nama Depan *</label>
                                                          <?php print $this->form_eksternal->form_input("first_name", "", "style='width: 100%'")?>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <label>Nama Belakang *</label>
                                                          <?php print $this->form_eksternal->form_input("last_name", "", "style='width: 100%'")?>
                                                      </div>
                                                  </div>
                                                  <div class="row">&nbsp;</div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <label>Nomor Telepon/ HP *</label>
                                                          <?php print $this->form_eksternal->form_input("hp", "", "style='width: 100%'")?>
                                                      </div>
                                                  </div>
                                                  <div class="row">&nbsp;</div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <label>Alamat Email *</label>
                                                          <?php print $this->form_eksternal->form_input("email", "", "style='width: 100%'")?>
                                                      </div>
                                                  </div>
                                                  <div class="row">&nbsp;</div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <label>Upload Surat Lamaran & CV *</label>
                                                          <?php print $this->form_eksternal->form_upload("file", "", "style='width: 100%'")?>
                                                      </div>
                                                  </div>
                                                  <div class="row">&nbsp;</div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <button class="button">Submit</button>
                                                      </div>
                                                  </div>
                                                  <?php print $this->form_eksternal->form_close()?>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                    <div class="row">
                                        <div class="icon-box box style8 col-md-12" style="font-size: 18px">
                                            <div class="col-md-6" style="text-align: left">
                                                <a href="<?php print site_url("page/html/why-join-us")?>" class="button">Why Join Us?</a>
                                            </div>
                                            <div class="col-md-6" style="text-align: right">
                                                <a href="<?php print site_url("page/html/current-openings")?>" class="button">Current Openings</a>
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
    </div>
</section>