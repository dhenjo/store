<?php print $this->form_eksternal->form_open("", 'role="form"', 
                    array("id_detail" => ""))?>


<div class="box-body col-sm-2">

      <div class="control-group">
        <label>First Name</label>
        <?php print $this->form_eksternal->form_input('first_name', $search_data['first_name'], 
        'id="first_name" style="width:121%" class="form-control input-sm" placeholder="First Name"');?>      
      </div>

      <div class="control-group">
        <label>Telp</label>
        <?php print $this->form_eksternal->form_input('telp', $search_data['telp'], 'class="form-control" placeholder="Telp"')?>
      </div>
    </div>

<div class="box-body col-sm-2" >

      <div class="control-group">
          <label>Last Name</label>
        <?php print $this->form_eksternal->form_input('last_name', $search_data['last_name'], 
        'id="last_name" style="width:121%" class="form-control input-sm" placeholder="Last Name"');?>
      </div>

      <div class="control-group">
        <label>Status</label>
       <?php print $this->form_eksternal->form_dropdown('status', $type_status, $search_data['status'], 'class="form-control" placeholder="Status"')?></div>
    </div>

<div class="box-body col-sm-2">

      
         
      <div class="control-group" style="margin-top: 70%;">
        <button class="btn btn-primary" type="submit">Search</button> </div>
    </div>
<div class="box-footer">
    
</div>
</form>
<br />
<table class="table table-bordered">
  <thead>
    <tr>
        <th>Name</th>
        <th>Telp</th>
        <th>Email</th>
        <th>Status</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Infant</th>
     <!--   <th>Total Price</th>
        <th>Total Payment</th> -->
        <th>Option</th>
    </tr>
  </thead>
  <tbody id="data_list">
    
  </tbody>
  <tfoot>
    <tr>
      <th colspan="8" style="height: <?php print 20 * $menu_action?>px"></th>
    </tr>
  </tfoot>
</table>
<div class="box-footer clearfix" id="halaman_set">
    <ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="#">«</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">»</a></li>
    </ul>
</div>