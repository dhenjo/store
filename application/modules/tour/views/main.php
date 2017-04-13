<div class="box">
  <div class="box-header">
    <div class="widget-control pull-left">
      <span style="display: none; margin-left: 10px" id="loader-page"><img src="<?php print $url?>img/ajax-loader.gif" /></span>
    </div>
    <div class="widget-control pull-right">
      <a href="#" data-toggle="dropdown" class="btn"><span class="glyphicon glyphicon-cog"></span> Menu</a>
      <ul class="dropdown-menu">
        <li><a href="<?php print site_url("tour/add-sales-lead")?>"><i class="icon-plus"></i> Add New</a></li>
      </ul>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body table-responsive">
    <table id="hasil" class="table table-bordered table-striped">
      <thead>
        <tr>
            <th>Tanggal</th>
            <th>Name</th>
            <th>Email</th>
            <th>Telp</th>
            <th>TC</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
