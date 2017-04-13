
<div class="row" id="history-log" style="height: 450px;overflow: scroll;">
    <div class="col-md-12">
      <ul class="timeline">
          <!-- timeline time label -->
        <?php
       
        foreach ($history_void as $k => $v) {
            
      
        $tanggal = "";
          print "<li class='time-label'>"
            . "<span class='bg-red'>"
              . date("d M y", strtotime($v->tanggal))
            . "</span>"
          . "</li>";
              
          print "<li>"
            . "<i class='fa fa-user bg-aqua'></i>"
            . "<div class='timeline-item'>"
              . "<span class='time'><i class='fa fa-clock-o'></i> ".date("H:i:s", strtotime($v->tanggal))."</span>"
              . "<h3 class='timeline-header no-border'><a href='#'>{$v->name}</a> Void: {$v->title}</h3>"
              . "<div class='timeline-body'>"
                . "<p>Note Void: {$v->note}</p><br />"
              . "</div>"
            . "</div>"
          . "</li>";
        }  
        ?>
          <li>
              <i class="fa fa-clock-o"></i>
          </li>
      </ul>
    </div><!-- /.col -->
  </div>