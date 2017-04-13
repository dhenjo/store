<thead>
    <tr>
        <th>Tanggal</th>
        <th>Lowongan</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>CV</th>
        <th>Status</th>
    </tr>
</thead>
<tbody>
  <?php
  if(is_array($data)){
    foreach ($data as $key => $value) {
      $status = array(
          2 => "Proses",
          1 => "<a href='".site_url("hrm/status-consultant/{$value->id_website_travel_consultant}/2")."'>Aktive</a>",
      );
      
      print '
      <tr>
        <td>'.$value->create_date.'</td>
        <td>'.$value->lowongan.'</td>
        <td>'.$value->first_name.' '.$value->last_name.'</td>
        <td>'.$value->email.'</td>
        <td>'.$value->hp.'</td>
        <td><a href="'.base_url()."files/antavaya/cv/{$value->file}".'">'.$value->file.'</a></td>
        <td>'.$status[$value->status].'</td>
      </tr>';
    }
  }
  ?>
</tbody>