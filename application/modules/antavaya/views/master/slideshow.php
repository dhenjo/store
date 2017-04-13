<thead>
    <tr>
        <th>Sort</th>
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
          2 => "<span class='label label-default'>Draft</span>",
          1 => "<span class='label label-success'>Active</span>",
      );
      
      if($value->file)
        $gambar = base_url()."files/antavaya/slideshow/{$value->file}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td>'.$value->sort.'</td>
        <td><img src="'.$gambar.'" height="50"></td>
        <td>'.$value->title.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("antavaya/master-antavaya/add-new-slideshow/".$value->id_website_slideshow).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>