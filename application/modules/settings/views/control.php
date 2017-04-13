<thead>
    <tr>
        <th>Controller</th>
        <th>Link</th>
        <th>Module</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $link_detail = site_url("settings/add-new-control/".$value->id_controller);
          $link_page = site_url("settings/page/".$value->id_controller);
          $link_delete = site_url("settings/delete-control/".$value->id_controller);
          if($value->status == 1)
            $status = 'Draft';
          else
            $status = 'Active';
          print "
      <tr>
        <td>{$value->name}</td>
        <td>{$value->link}</td>
        <td>{$value->module}</td>
        <td>
          <div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='{$link_detail}'>Edit</a></li>
              <li><a href='{$link_page}'>Page</a></li>
              <li><a href='{$link_delete}'>Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>";
        }
      }
      ?>
</tbody>