<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid box-primary">
        <div class="box-header">
            <h3 class="box-title">Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
          <?php print $this->form_eksternal->form_open("", 'role="form"', array("id_detail" => $detail[0]->kode))?>
          <div class="row">
            <div class="form-group">
              <div class="col-xs-6">
                <label>Tour Name</label>
                <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Tour Name"')?>
              </div>
              <div class="col-xs-6">
                <label>Status</label>
                <?php 
                $stat = $detail[0]->status;
                if(!$stat)
                  $stat = 1;
                print $this->form_eksternal->form_dropdown('status', array(0 => "- All -", 1 => "Publish", 2 => "Draft"),
                  array($stat),'class="form-control input-sm"');
                ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label style="width: 49%">Add - On Tour</label>
                <label style="width: 24%">Adult</label>
                <label style="width: 24%">Child</label>
                <div id="isi-add-tour">
                  <?php
                  $nok = 1;
                  foreach($add_on AS $ao){
                    print '<div class="input-group input-group-sm" id="first'.$nok.'">';
                      print $this->form_eksternal->form_input('add[]', $ao->title,
                        'class="form-control input-sm" placeholder="Title" style="width: 50%"');
                      print $this->form_eksternal->form_input('add_adult[]', $ao->adult,
                        'class="form-control input-sm harga" placeholder="Adult" style="width: 25%"');
                      print $this->form_eksternal->form_input('add_child[]', $ao->child,
                        'class="form-control input-sm harga" placeholder="Child" style="width: 25%"');
                      print '<span class="input-group-btn">'
                        . '<a href="javascript:void(0)" isi="first'.$nok.'" class="btn btn-danger btn-flat delete-add-on-tour">X</a>'
                      . '</span>';
                    print '</div>';
                    $nok++;
                  }
                  ?>
                  <div class="input-group input-group-sm" id="first">
                      <?php 
                      print $this->form_eksternal->form_input('add[]', "",
                        'class="form-control input-sm" placeholder="Title" style="width: 50%"');
                      print $this->form_eksternal->form_input('add_adult[]', "",
                        'class="form-control input-sm harga" placeholder="Adult" style="width: 25%"');
                      print $this->form_eksternal->form_input('add_child[]', "",
                        'class="form-control input-sm harga" placeholder="Child" style="width: 25%"');
                      ?>
                      <span class="input-group-btn">
                        <a href="javascript:void(0)" isi="first" class="btn btn-danger btn-flat delete-add-on-tour">X</a>
                      </span>
                  </div>
                </div>
                <div class="btn-group">
                  <?php print $this->form_eksternal->form_input('nomor', $nok, 'style="display: none"')?>
                  <a href="javascript:void(0)" id="add-on-tour" class="btn btn-info"><i class="fa fa-plus"></i></a>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-6">
                <label>Destination</label>
                <?php print $this->form_eksternal->form_input('destination', $detail[0]->destination,
                  'class="form-control input-sm" placeholder="Destination"')?>
              </div>
              <div class="col-xs-6">
                <label>Region</label>
                <?php print $this->form_eksternal->form_dropdown('region', 
               array(NULL => "- Pilih -", 1 => "Europe", 2 => "Africa", 3 => "America", 4 => "Australia", 5 => "Asia", 6 => "China", 7 => "New Zealand"),
               array($detail[0]->region), 'class="form-control input-sm"')?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <label>Itinerary</label>
                <?php print $this->form_eksternal->form_textarea('summary', $detail[0]->summary,
                  'class="form-control input-sm" placeholder="Itinerary" id="editor2"')?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-3">
              <br />
              <button class="btn btn-primary" type="submit">Submit</button>
              <a href="<?php print site_url("tour/tour-master/fit")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              <hr />
            </div>
          </div>
          </form> 
        </div>
    </div>
  </div>
</div>