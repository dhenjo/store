<thead>
    <tr>
        <th>Gambar</th>
        <th>Title</th>
        <th>Url</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          2 => "<span class='label label-default'>Draft</span>",
          1 => "<span class='label label-success'>Active</span>",
      );
      
      if($value->file)
        $gambar = base_url()."files/antavaya/page/{$value->file}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>page/index/'.$value->nicename.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("page/master-page/add-new-page/".$value->id_website_page).'">Edit</a></li>
              <li><a href="'.site_url("page/master-page/gambar/".$value->id_website_page).'">Gambar</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>