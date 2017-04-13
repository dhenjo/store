<div id="main-content">
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-block">
          
          <div class="widget-head">
            <h5><?php print $title_table?></h5>
          </div>
          <div class="widget-content">
            <div class="widget-box">
              <table class="data-tbl-boxy4 table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telp</th>
                    <th>Option</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if(is_array($data)){
                    foreach ($data as $key => $value) {
                      $link_detail = site_url("home/contact-us/".$value->id_contact_us);
                      print <<<EOD
                  <tr>
                    <td>{$value->tanggal}</td>
                    <td>{$value->title}</td>
                    <td>{$value->name}</td>
                    <td>{$value->email}</td>
                    <td>{$value->telp}</td>
                    <td>
                      <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-small dropdown-toggle">Action<span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="{$link_detail}">Edit</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
EOD;
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