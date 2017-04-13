<thead>
    <tr>
        <th>Gambar</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    $category = array(1 => "Low Season", 2 => "Hight Season Chrismast", 3 => "Hight Season Lebaran");
    $sub_category = array(1 => "Eropa", 2 => "Middle East & Africa", 3 => "America", 4 => "Australia & New Zealand", 5 => "Asia", 6 => "China");
    foreach ($data as $key => $value) {
      $status = array(
          3 => "<span class='label label-default'>Draft</span>",
          2 => "<span class='label label-info'>Promosi</span>",
          1 => "<span class='label label-success'>Active</span>",
      );
      
      if($value->file_thumb)
        $gambar = base_url()."files/antavaya/grouptour/{$value->file_thumb}";
      else
        $gambar = base_url()."files/no-pic.png";
      
      print '
      <tr>
        <td><img src="'.$gambar.'" width="100"></td>
        <td>'.$value->title.'</td>
        <td>'.$category[$value->category].' <br /> '.$sub_category[$value->sub_category].'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("grouptour/master-grouptour/add-new-grouptour/".$value->id_website_group_tour).'">Edit</a></li>
              <li><a href="'.site_url("grouptour/master-grouptour/delete-grouptour/".$value->id_website_group_tour).'">Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>