<thead>
    <tr>
        <th>Start</th>
        <th>End</th>
        <th>Title</th>
        <th>Diskon</th>
        <th>Diskon Nominal</th>
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
      
      print '
      <tr>
        <td>'.$value->mulai.'</td>
        <td>'.$value->akhir.'</td>
        <td>'.$value->title.'</td>
        <td>'.$value->hemat.'</td>
        <td style="text-align: right">'.number_format($value->nilai, 0).'</td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("diskon/add-diskon-mega/".$value->id_website_hemat_mega).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>