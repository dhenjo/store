<script src="<?php print $url?>js/data-table.jquery.js"></script>
<script>
  $(function () {
    $('.data-tbl-boxy').dataTable({
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "oLanguage": {
            "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
        },
        "aaSorting": [[3, 'desc']],
        "sDom": '<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>'

    });
  });
</script>
<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-block">
          <div class="widget-head">
            <h5><?php print $title?></h5>
            <div class="widget-control pull-right">
              <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"><i class="icon-cog"></i><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php print   site_url("variable/add-settings-patern") ?>"><i class="icon-plus"></i> Add New</a></li>
              </ul>
            </div>
          </div>
          <div class="widget-content">
            <div class="widget-box">
              <table class="data-tbl-boxy table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Table</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(is_array($data)){
                    foreach ($data as $key => $value) {
                      print "
                  <tr>
                    <td>{$value->title}</td>
                    <td>{$value->table}</td>
                    <td>
                      <div class='btn-group'>
                        <button data-toggle='dropdown' class='btn btn-small dropdown-toggle'>Action<span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                          <li><a href='".site_url("variable/add-settings-patern/{$value->id_patern}")."'>Edit</a></li>
                          <li><a href='".site_url("variable/delete-settings-patern/{$value->id_patern}")."'>Delete</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>