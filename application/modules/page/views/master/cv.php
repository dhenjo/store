<thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Telp</th>
        <th>File</th>
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
        <td>'.$value->first_name.' '.$value->last_name.'</td>
        <td>'.$value->email.'</td>
        <td>'.$value->hp.'</td>
        <td><a target="_blank" href="'.base_url().'files/antavaya/cv/'.$value->file.'">'.$value->file.'</a></td>
        <td>'.$status[$value->status].'</td>
        <td>
          <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
            <ul class="dropdown-menu">
              <li><a href="'.site_url("page/master-page/edit-cv/".$value->id_website_travel_consultant).'">Edit</a></li>
            </ul>
          </div>
        </td>
      </tr>';
    }
  }
  ?>
</tbody>