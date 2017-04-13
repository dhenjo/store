<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AV TMS | Tour Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="135 Budhi Santoso Information System Management. ERP System">
        <meta name="author" content="Nugroho Budhi Santoso">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?php print $url?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php print $url?>css/simpletree.css" rel="stylesheet">
        <?php print $css;?>
    </head>
    <body class="skin-blue">
        <?php
        include 'info-atas.php';
        ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="left-side sidebar-offcanvas">
                <section class="sidebar">
                    <div class="user-panel">
                        <center><img src="<?php print $url?>img/logo.png" width="150" alt="135 System" /></center>
                    </div>
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    
<?php
$edit = $this->nbscache->get_explode("menu", $this->session->userdata("id_privilege"));
$menu_ca = unserialize($edit[1]);
?>
                        
                    <ul id="treemenu2" class="treeview sidebar-menu">
    <?php
    foreach($menu_ca as $k_mc => $mc){
      print <<<EOD
      <li class='treeview'>
          <a href="javascript:void(0)">
            <i class="fa {$mc['icon']}"></i>
            <span>{$mc['name']}</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
EOD;
      $ululnya = '<ul class="acitem treeview-menu">';
      $lilinya = "";
      foreach($mc['child'] as $k_child => $mchild){
        if(count($mchild['child']) > 0){
          $link_sub = "<a href='javascript:void(0)'><i class='fa fa-angle-double-right'></i> {$mchild['name']}</a>";
        }
        else{
          if($menu == $mchild['link']){
            $ululnya = "<ul class='acitem treeview-menu' rel='open'>";
          }
          $link_sub = "<a href='".site_url($mchild['link'])."'><i class='fa fa-angle-double-right'></i> {$mchild['name']}</a>";
        }
        $lilinya .= <<<EOD
        <li>
          {$link_sub}
EOD;
        if(count($mchild['child']) > 0){
          $ulnya = "<ul class='treeview-menu'>";
          $linya = "";
          foreach($mchild['child'] as $kmchild => $mcchild){
            if($menu == $mcchild['link']){
              $ulnya = "<ul class='treeview-menu' rel='open'>";
            }
            $link_sub_child = site_url($mcchild['link']);
            $linya .= <<<EOD
              <li><a href="{$link_sub_child}">&nbsp;&nbsp;&nbsp;&nbsp;{$mcchild['name']}</a>
EOD;
          }
          $lilinya .= $ulnya.$linya."</ul>";
        }
      }
      print $ululnya;
      print $lilinya;
      print <<<EOD
        </ul>
EOD;
    }
    ?>
  </ul>

                </section>
            </aside>
            <aside class="right-side">
                <?php
                if($this->session->flashdata('notice')){
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Filed!</b> <?php print $this->session->flashdata('notice')?>.
                </div>
                <?php
                }
                if($this->session->flashdata('success')){
                ?>
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Success!</b> <?php print $this->session->flashdata('success')?>.
                </div>
                <?php
                }
                if($this->session->flashdata('extent')){
                ?>
                <div class="alert alert-warning alert-dismissable">
                    <i class="fa fa-warning"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>Warning!</b> <?php print $this->session->flashdata('extent')?>.
                </div>
                <?php
                }
                ?>
                <section class="content-header">
                    <h1>
                        <?php print $title?>
                        <small><?php print $title_small?></small>
                    </h1>
                    <ol class="breadcrumb">
                      <?php
                      foreach($breadcrumb AS $breadcrumb_key => $breadcrumb_value){
                        print "<li><a href='".site_url($breadcrumb_value)."'><i class='fa fa-dashboard'></i> {$breadcrumb_key}</a></li>";
                      }
                      ?>
                        <li class="active"><?php print $title?></li>
                    </ol>
                </section>
                <section class="content">
                  <div class="row">
                        <div class="col-md-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    Note : <span id="note_batch">Note</span> <br />
                                    Progress : <span id="prossess_batch">0</span><br />
                                    Total Post : <span id="total_batch"><?php print $total_pos?></span> <br />
                                    <span id="redirect_batch"></span>
                                    <div class="progress sm progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress_bar_batch">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col (left) -->
                    </div>
                </section>
            </aside>
        </div>

        
        <script src="<?php print $url?>js/jquery.min.js"></script>
        <script src="<?php print $url?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/AdminLTE/app.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php print $url?>js/simpletreemenu.js"></script>
        <script type="text/javascript">

        ddtreemenu.createTree("treemenu2", false);

        function hilang(id){
          $("#anak_hilang_"+id).fadeToggle();
        }

        </script>
        <?php print $template['body']?>
        <?php print $foot;?>
    </body>
</html>