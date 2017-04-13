<thead>
    <tr>
        <th>Transaksi</th>
        <th>Tipe</th>
        <th>Point</th>
        <th>Status</th>
        <th>Jenis</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          1 => "<span class='label label-default'>Draft</span>",
          2 => "<span class='label label-success'>Active</span>",
          3 => "<span class='label label-warning'>Block</span>",
      );
      
      if($value->logo)
        $gambar = base_url()."files/portal/company/logo/{$value->logo}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>'.$value->lokasi.'</td>
        <td>'.$value->bidang_usaha.'</td>
        <td>'.$value->point.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("portal/master-portal/add-new-company/".$value->id_portal_company).'">Edit</a></li>
              <li><a href="'.site_url("portal/master-portal/users-company/".$value->id_portal_company).'">Users</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>