<thead>
    <tr>
        <th>Nicename</th>
        <th>Code</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $link_detail = site_url("settings/add-new-form/".$value->id_form);
          $link_delete = site_url("settings/delete-form/".$value->id_form);
          print "
      <tr>
        <td>{$value->nicename}</td>
        <td>{$value->name}</td>
        <td>
          <div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='{$link_detail}'>Edit</a></li>
              <li><a href='{$link_delete}'>Delete</a></li>
            </ul>
          </div>
        </td>
      </tr>";
        }
      }
      ?>
</tbody>