
<thead>
    <tr>
        <th>Sort</th>
        <th>Name</th>
        <th>Jabatan</th>
        <th>Parent</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      print '
      <tr>
        <td>'.$value->sort.'</td>
        <td><a href="'.site_url("grouptour/product-tour/child/".$value->id_users_approval).'">'.$value->name.'</a></td>
        <td>'.$value->jabatan.'</td>
        <td>'.$data_user[$value->ayah].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("grouptour/product-tour/add-new-users-approval/{$value->parent}/".$value->id_users_approval).'">Edit</a></li>
              <li><a href="'.site_url("grouptour/product-tour/child/".$value->id_users_approval).'">Child</a></li>
            <!--  <li><a href="'.site_url("menu/delete/".$value->id_users_approval).'">Delete</a></li> -->
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>