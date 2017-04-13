<thead>
    <tr>
        <th>Start</th>
        <th>End</th>
        <th>Title</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      
      print '
      <tr>
        <td>'.$value->mulai.'</td>
        <td>'.$value->akhir.'</td>
        <td>'.$value->title.'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("hrm/add-lowongan/".$value->id_website_hrm_lowongan).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>