<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
      
			<div class="span6">
				<div class="nonboxy-widget">
          <?php
          if($stat == 2){
          ?>
          <div class="alert alert-error fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Filed!</strong> <?php print $message?>
          </div>
          <?php
          }
          if($stat == 1){
          ?>
          <div class="alert alert-success fade in">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <strong>Success!</strong> <?php print $message?>
          </div>
          <?php
          }
          ?>
					<div class="widget-head">
						<h5><i class="black-icons blocks_images"></i>Need More</h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
								<fieldset>
                  <form class=" form-horizontal well" id="formoutlet">
                    <h3>Product Lainnya</h3>
                    <p>Ini hanya sebagian kecil aplikasi kami. Kami juga memiliki sistem :
                      <ul>
                        <li>Keuangan</li>
                        <li>CRM for Sales</li>
                        <li>Development Checklist</li>
                        <li>Scheduler</li>
                        <li>Task Management</li>
                        <li>Sistem Lainnya</li>
                      </ul>
                    Pastinya semua sistem tersebut saling terhubung.
                    </p>
                    <p>Kami yakin perusahaan anda memiliki keunikan tersendiri dalam penerapan sistem. 
                      Karena hal inilah kami ada, dengan fungsi yang fleksibel
                    kami mampu mewujudkan informasi dan sistem perusahaan anda. Kami akan mendengarkan, menganalisa, merancang sehingga mampu mingimplementasikan sistem perusahaan anda menjadi sistem yang lebih rapi, terhubung dan mudah dalam sebuah aplikasi.
                    </p>
                    <p>
                      Ciptakan perusahaan yang hebat dengan sistem yang hebat. Kami siap untuk membantu. <br />
                    <table width="100%">
                      <tr>
                        <td></td>
                        <td><b>Tomo</b></td>
                        <td><b>Nugroho B Santoso</b></td>
                      </tr>
                      <tr>
                        <td><b>Email</b></td>
                        <td>tomo@nusato.com</td>
                        <td>nugroho@nusato.com</td>
                      </tr>
                      <tr>
                        <td><b>Telp</b></td>
                        <td>+62 838 7354 4537</td>
                        <td>+62 896 9975 1151</td>
                      </tr>
                    </table>
                    </p>
                  </form>
								</fieldset>
						</div>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5><i class="black-icons blocks_images"></i><?php print $title_table?></h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
              <?php print $this->form_eksternal->form_open("", 'class=" form-horizontal well" id="formoutlet"')?>
								<fieldset>
									<div class="control-group">
										<label class="control-label">Title</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('title', $detail[0]->title)?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Name</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('name', $detail[0]->name)?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('email', $detail[0]->email)?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Telp</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('telp', $detail[0]->telp)?>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Note</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note)?>
										</div>
									</div>
								</fieldset>
								<div class="form-actions">
									<button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("home")?>" class="btn"><?php print lang("cancel")?></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>