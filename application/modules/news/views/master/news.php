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
          2 => "<span class='label label-info'>Non Active</span>",
          1 => "<span class='label label-success'>Active</span>",
      );
      
      if($value->file_thumb)
        $gambar = base_url()."files/antavaya/news/{$value->file_thumb}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("news/master-news/add-new-news/".$value->id_website_news).'">Edit</a></li>
              <li><a href="'.site_url("news/master-news/delete-news/".$value->id_website_news).'">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>