<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open_multipart("", 'role="form"', 
                    array("id_detail" => $detail[0]->id_product_tour))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Title</label>
                  <?php print $this->form_eksternal->form_input('title', $detail[0]->title, 'class="form-control input-sm" placeholder="Title"');?>
                </div>

                <div class="control-group">
                  <label>Sub Title</label>
                  <?php print $this->form_eksternal->form_input('sub_title', $detail[0]->sub_title, 'class="form-control input-sm" placeholder="Sub Title"');?>
                </div>

                <div class="control-group">
                  <label>Summary</label>
                  <?php print $this->form_eksternal->form_input('summary', $detail[0]->summary, 'class="form-control input-sm" placeholder="Summary"');?>
                </div>
                  
                
                <div class="control-group">
                  <label>Category</label>
                  <?php print $this->form_eksternal->form_dropdown('category', array(1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran"), array($detail[0]->category), 'class="form-control input-sm"');?>
                </div>

                <div class="control-group">
                  <label>Sub Category</label>
                  <?php print $this->form_eksternal->form_dropdown('sub_category', array(1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China"), array($detail[0]->sub_category), 'class="form-control input-sm"');?>
                </div>

                <div class="control-group">
                  <label>Gambar</label>
                  <?php print $this->form_eksternal->form_upload('file', $detail[0]->file, "class='form-control input-sm'");
                  if($detail[0]->file)
                    print "<br /><img src='".base_url()."files/antavaya/product_tour/{$detail[0]->file}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  
                <div class="control-group">
                  <label>Gambar Thumb</label>
                  <?php print $this->form_eksternal->form_upload('file_thumb', $detail[0]->file_thumb, "class='form-control input-sm'");
                  if($detail[0]->file_thumb)
                    print "<br /><img src='".base_url()."files/antavaya/product_tour/{$detail[0]->file_thumb}' width='100' />";
                  else
                    print "<br /><img src='".base_url()."files/no-pic.png' width='50' />";
                  ?>
                </div>
                  <br><br>
                  <div class="control-group">
                      <label style="width: 100%">Product Tour Information</label>
                      <table class="table table-striped">
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Available Seat</th>
                        <th>Price Adult</th>
                        <th>Price Child</th>
                        <th>Price Infant</th>
                    </tr>
                    
                    <?php
            if($info){
                 
                  foreach ($info AS $inf){
                  print "<tr>";
                  print "<td>".$this->form_eksternal->form_input('start_date[]', $inf->start_date,'class="start_date" class="form-control input-sm" placeholder="Start Date"')."</td>";
                  print "<td>".$this->form_eksternal->form_input('end_date[]', $inf->end_date,'class="end_date" class="form-control input-sm" placeholder="End Date"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('available_seat','available_seat[]', $inf->available_seat, 'class="form-control input-sm" style="width: 80%" placeholder="Available Seat"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_adult','price_adult[]', $inf->price_adult, 'class="form-control input-sm" style="width: 80%" placeholder="Price Adult Twin Share"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_child','price_child[]', $inf->price_child, 'class="form-control input-sm" style="width: 80%" placeholder="Child Twin Share"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_infant','price_infant[]', $inf->price_infant, 'class="form-control input-sm" style="width: 80%" placeholder="Child With Extra Bed"')."</td>";                  
                  print $this->form_eksternal->form_input('id_product_tour_information[]', $inf->id_product_tour_information, 
                      'style="display: none"');
                 print "</tr>";
                  }
                }
            ?>
                     <?php
                
             //   if($akses != "view"){
                  print "<tr>";
                  print "<td>".$this->form_eksternal->form_input('start_date[]', "",'class="start_date" class="form-control input-sm" placeholder="Start Date"')."</td>";
                  print "<td>".$this->form_eksternal->form_input('end_date[]', "",'class="end_date" class="form-control input-sm" placeholder="End Date"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('available_seat','available_seat[]', "", 'class="form-control input-sm" style="width: 80%" placeholder="Available Seat"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_adult','price_adult[]', "", 'class="form-control input-sm" style="width: 80%" placeholder="Price Adult Twin Share"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_child','price_child[]', "", 'class="form-control input-sm" style="width: 80%" placeholder="Child Twin Share"')."</td>";
                  print "<td>".$this->form_eksternal->form_input_price('price_infant','price_infant[]', "", 'class="form-control input-sm" style="width: 80%" placeholder="Child With Extra Bed"')."</td>";
                 print "</tr >";?>
                   
                    
                     
                <?php
             //   }
                ?>
                   
                
                      </table>
                      <span id="tambah-items">
                    </span>
             <a href="javascript:void(0)" onclick="tambah_items()" class="btn btn-info"><?php print lang("Add")?></a>
                    <br><br>
                <div class="control-group">
                  <label>Detail</label>
                  <?php print $this->form_eksternal->form_textarea('note', $detail[0]->note, 'class="form-control input-sm" id="editor2"')?>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Save changes</button>
                  <a href="<?php print site_url("scm/product-tour")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->