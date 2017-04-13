<thead>
    <tr>
        <th>Gambar</th>
        <th>Title</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          2 => "<span class='label label-info'>Promosi</span>",
          3 => "<span class='label label-default'>Draft</span>",
          1 => "<span class='label label-success'>Active</span>",
      );
      
      if($value->file_temp)
        $gambar = base_url()."files/antavaya/promosi/{$value->file_temp}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.' <br /> '.$value->sub_title.'<br />'.$value->summary.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("promosi/master-promosi/add-new-promosi/".$value->id_website_promosi).'">Edit</a></li>
              <li><a href="'.site_url("promosi/master-promosi/delete-promosi/".$value->id_website_promosi).'">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>