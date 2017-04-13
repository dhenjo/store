<section class="content">
  <div class="row" id="history-log">
    <div class="col-md-12">
      <ul class="timeline">
          <!-- timeline time label -->
        <?php
        $tanggal = "";
          print "<li class='time-label'>"
            . "<span class='bg-red'>"
              . date("d M y", strtotime("2016-01-09"))
            . "</span>"
          . "</li>";
              
          print "<li>"
            . "<i class='fa fa-user bg-aqua'></i>"
            . "<div class='timeline-item'>"
              . "<span class='time'><i class='fa fa-clock-o'></i> ".date("H:i:s", strtotime("2016-01-09 10:23:21"))."</span>"
              . "<h3 class='timeline-header no-border'><a href='#'>Admin</a> Documentasi Tour Request FIT</h3>"
              . "<div class='timeline-body'>"
                . "<p>Documentasi yang digunakan untuk menggunakan Request FIT.<br />"
                . "Jika terdapat pertanyaan, masukan, perbaikan, bug, dll yang berhubungan dengan teknis dapat menghubungi itdev@antavaya.com<br />"
                . "<a href='".base_url()."files/antavaya/doc/ug-fit-request.doc"."'>Document</a>"
              . "</div>"
            . "</div>"
          . "</li>";
          
        ?>
          <li>
              <i class="fa fa-clock-o"></i>
          </li>
      </ul>
    </div><!-- /.col -->
  </div> <!-- /.row -->
  <div class="row">
    <div class="col-md-6">
      <div class="box-header">
          <h3 class="box-title">Document</h3>
      </div>
      <div class="box-body">
        <table id="tableboxy" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Title</th>
              <th>Module</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2016-01-09 10:23:21</td>
              <td><a href="<?php print base_url()."files/antavaya/doc/ug-fit-request.doc"?>">Request FIT</a></td>
              <td>Tour FIT</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div><!-- /.col -->
  </div> <!-- /.row -->
</section>