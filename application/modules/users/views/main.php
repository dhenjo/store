<?php print $this->form_eksternal->form_open("", 'role="form"')?>
<table class="table table-bordered">
  <tr>
    <td>Name/Email</td>
    <td><?php print $this->form_eksternal->form_input('name', $this->session->userdata("users_name"), 'class="form-control" placeholder="Name/Email"')?></td>
     </tr>
<!--  <tr>
      <td>Status</td>
    <td><?php print $this->form_eksternal->form_dropdown('status', array("" => "- Pilih -", 1 => "Active", 0 => "Non Active"), array($this->session->userdata("users_status")), 'class="form-control"')?></td>
  </tr>-->
  <tr>
    <td colspan="4"><button class="btn btn-primary" type="submit">Search</button></td>
  </tr>
</table>
</form>
<hr />
<table class="table table-bordered">
  <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Point</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
  </thead>
  <tbody id="data_list">
    
  </tbody>
  <tfoot>
    <tr>
      <th colspan="5" style="height: <?php print 20 * $menu_action?>px"></th>
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