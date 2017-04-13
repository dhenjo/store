<thead>
    <tr>
        <th>Tanggal</th>
        <th>Group Tour</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telp</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          1 => "<span class='label label-default'>Proses</span>",
          2 => "<span class='label label-success'>Deal</span>",
          3 => "<span class='label label-warning'>Cancel</span>",
      );
      
      print '
      <tr>
        <td>'.$value->create_date.'</td>
        <td><a href="'.site_url("grouptour/detail/{$value->nicename}").'" target="_blank">'.$value->promosi.'</a></td>
        <td>'.$value->name.'</td>
        <td>'.$value->email.'</td>
        <td>'.$value->telp.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("grouptour/master-grouptour/edit-book/".$value->id_website_group_tour_book).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>