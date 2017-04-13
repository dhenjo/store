<script src="<?php print $url?>js/data-table.jquery.js"></script>
<script>
  $(function () {
    $('.data-tbl-boxy').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "oLanguage": {
            "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
        },
        "sDom": '<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>'

    });
  });
</script>
<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
			<div class="span12">
				<div class="nonboxy-widget">
					<div class="widget-head">
						<h5><i class="black-icons blocks_images"></i><?=$title?></h5>
					</div>
					<div class="widget-content">
						<div class="widget-box">
              <?=$this->form_eksternal->form_open("", 'class=" form-horizontal well" id="formoutlet"', 
                      array(
                          "id_controller" => $detail[0]->id_controller,
                      ))?>
								<fieldset>
                  <div class="control-group">
										<label class="control-label">Page</label>
										<div class="controls">
                      <?=$this->form_eksternal->form_addrow_tambahan($isi, site_url("settings/addrow-page"), "page", "halaman", "nomor_flag", $tr)?>
										</div>
									</div>
                  <div class="control-group">
                    <?=$this->form_eksternal->form_input('param', $nomor, 'id="nomor_flag" style="display: none"')?>
                  </div>
								</fieldset>
								<div class="form-actions">
									<button class="btn btn-primary" type="submit">Save changes</button>
									<button class="btn">Cancel</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
  </div>
</div>