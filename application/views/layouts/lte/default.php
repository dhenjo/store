<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AV TMS | Tour Management System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="135 Budhi Santoso Information System Management. ERP System">
        <meta name="author" content="Nugroho Budhi Santoso">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php print $url?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php print $url?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php print $url?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <!--<link href="<?php print $url?>css/morris/morris.css" rel="stylesheet" type="text/css" />-->
        <!-- jvectormap -->
<!--        <link href="<?php print $url?>css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
         Date Picker 
        <link href="<?php print $url?>css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
         Daterange picker 
        <link href="<?php print $url?>css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
         bootstrap wysihtml5 - text editor 
        <link href="<?php print $url?>css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Theme style -->
        <link href="<?php print $url?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php print $url?>css/simpletree.css" rel="stylesheet">
        <?php print $css;?>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php
        include 'info-atas.php';
        ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <!--<div class="pull-left image">-->
                        <center><img src="<?php print $url?>img/logo.png" width="150" alt="B5 System" /></center>
                        <!--</div>--> 
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    
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
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
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

                <!-- Main content -->
                <section class="content">
                    <?php print $template['body']?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src="<?php print $url?>js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php print $url?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php print $url?>js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
<!--        <script src="<?php print $url?>js/raphael-min.js"></script>
        <script src="<?php print $url?>js/plugins/morris/morris.min.js" type="text/javascript"></script>-->
        <!-- Sparkline -->
<!--        <script src="<?php print $url?>js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
         jvectormap 
        <script src="<?php print $url?>js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
         jQuery Knob Chart 
        <script src="<?php print $url?>js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
         daterangepicker 
        <script src="<?php print $url?>js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
         datepicker 
        <script src="<?php print $url?>js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
         Bootstrap WYSIHTML5 
        <script src="<?php print $url?>js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
         iCheck 
        <script src="<?php print $url?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>-->

        <!-- AdminLTE App -->
        <script src="<?php print $url?>js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="<?php print $url?>js/AdminLTE/dashboard.js" type="text/javascript"></script>-->

        <!-- AdminLTE for demo purposes -->
        <!--<script src="<?php print $url?>js/AdminLTE/demo.js" type="text/javascript"></script>-->
        
        <script type="text/javascript" charset="utf-8" src="<?php print $url?>js/simpletreemenu.js"></script>
        <script type="text/javascript">

        ddtreemenu.createTree("treemenu2", false);

        function hilang(id){
          $("#anak_hilang_"+id).fadeToggle();
        }

        </script>
        <?php print $foot;?>
    </body>
</html>