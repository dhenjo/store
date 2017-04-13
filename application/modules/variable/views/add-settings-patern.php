<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
			<div class="span12">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5><i class="black-icons blocks_images"></i><?php print $title?></h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
              <?php print $this->form_eksternal->form_open("", 'class=" form-horizontal well" id="formoutlet"', 
                      array("id_detail" => $detail[0]->id_patern))?>
								<fieldset>
                  <div class="control-group">
										<label class="control-label">Title</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="span4"')?>
										</div>
									</div>
                  <div class="control-group">
										<label class="control-label">Table</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_input('table', $detail[0]->table, 'class="span4"')?>
										</div>
									</div>
                  <div class="control-group">
										<label class="control-label">Variable</label>
										<div class="controls">
                      <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="span4"')?>
										</div>
									</div>
								</fieldset>
								<div class="form-actions">
									<button class="btn btn-primary" type="submit"><?php print lang("save")?></button>
                  <a href="<?php print site_url("variable/settings-patern")?>" class="btn"><?php print lang("cancel")?></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>