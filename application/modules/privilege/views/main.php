<thead>
    <tr>
        <th>Name</th>
        <th>Dashbord</th>
        <th>Option</th>
    </tr>
</thead>
<tbody>
  <?php
      if(is_array($data)){
        foreach ($data as $key => $value) {
          $link_edit = site_url("privilege/add-new/".$value->id_privilege);
          $link_delete = site_url("privilege/delete/".$value->id_privilege);
          $link_module = site_url("privilege/user-set-module/".$value->id_privilege);
          print "
      <tr>
        <td>{$value->name}</td>
        <td>{$value->dashbord}</td>
        <td>
          <div class='btn-group'>
            <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
            <ul class='dropdown-menu'>
              <li><a href='{$link_edit}'>Edit</a></li>
              <li><a href='{$link_delete}'>Delete</a></li>
              <li><a href='{$link_module}'>Privilege Module</a></li>
            </ul>
          </div>
        </td>
      </tr>";
        }
      }
      ?>
</tbody>