<?php

//print "<pre>";
//print_r($data); 
//print "</pre>";
//die; 
print $before_table;
?>
<thead>
    <tr>
        <th>Tanggal</th>
        <th>Tour Name</th>
        <th>Bookers</th>
        <th>Code</th>
        <th>Name</th>
        <th>Status</th>
        <th>Tanggungan</th>
        <th>Option</th>
    </tr>
</thead>
<tbody id="data_list">
    
  </tbody>
  <tfoot>
    <tr>
      <th colspan="11" style="height: <?php print 20 * $menu_action?>px"></th>
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
