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
        <link href="<?php print $url?>css/iCheck/minimal/blue.css" rel="stylesheet" type="text/css" />
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
                <!-- Content Header (Page header) -->
                <section class="content-header no-margin">
                    <h1 class="text-center">
                        Mailbox
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- MAILBOX BEGIN -->
                    
                    <div class="mailbox row">
                        <div class="col-xs-12">
                            <div class="box box-solid">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                            <!-- BOXES are complex enough to move the .box-header around.
                                                 This is an example of having the box header within the box body -->
                                            <div class="box-header">
                                                <i class="fa fa-inbox"></i>
                                                <h3 class="box-title">INBOX</h3>
                                            </div>
                                            <div style="margin-top: 15px;">
                                              <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal"><i class="fa fa-pencil"></i> Compose</a>
                                              <?php
                                              $menu_set = array(
                                                "inbox_comp"      => $inbox_comp,
                                                "star_comp"       => $star_comp,
                                                "request_out_comp" => $request_out_comp,
                                                "inbox_users"     => $inbox_users,
                                                "sent_users"      => $sent_users,
                                                "star_users"      => $star_users,
                                              );
                                              ?>
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Company</li>
                                                    <li class="<?php print $menu_set["inbox_comp"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/contact-us")?>">
                                                        <i class="fa fa-inbox"></i> Inbox <span id="jumlah_inbox"><?php print $jumlah_inbox?></span>
                                                      </a></li>
                                                    <li class="<?php print $menu_set["request_out_comp"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/permintaan-keluar")?>">
                                                        <i class="fa fa-envelope-o"></i> Permintaan Keluar
                                                      </a></li>
                                                    <li class="<?php print $menu_set["star_comp"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/star-company")?>">
                                                        <i class="fa fa-star"></i> Star
                                                      </a></li>
                                                </ul>
                                              <a class="btn btn-block btn-primary" data-toggle="modal" data-target="#compose-modal-users"><i class="fa fa-pencil"></i> Compose</a>
                                                <ul class="nav nav-pills nav-stacked">
                                                    <li class="header">Users</li>
                                                    <li class="<?php print $menu_set["inbox_users"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/inbox")?>">
                                                        <i class="fa fa-inbox"></i> Inbox <span id="jumlah_inbox_users"><?php print $jumlah_inbox_users?></span>
                                                      </a></li>
                                                    <li class="<?php print $menu_set["sent_users"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/outgoing")?>">
                                                        <i class="fa fa-mail-forward"></i> Sent
                                                      </a></li>
                                                    <li class="<?php print $menu_set["star_users"]?>">
                                                      <a href="<?php print site_url("cms/portal-cms/star")?>">
                                                        <i class="fa fa-star"></i> Star
                                                      </a></li>
                                                </ul>
                                            </div>
                                        </div><!-- /.col (LEFT) -->
                                        <?php print $template['body']?>
                                    </div><!-- /.row -->
                                </div><!-- /.box-body -->
                                <!-- box-footer -->
                            </div><!-- /.box -->
                        </div><!-- /.col (MAIN) -->
                    </div>
                    <!-- MAILBOX END -->

                </section><!-- /.content -->
            </aside>
          
        </div>

        <script src="<?php print $url?>js/jquery.min.js"></script>
        <script src="<?php print $url?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php print $url?>js/AdminLTE/app.js" type="text/javascript"></script>
        <script type="text/javascript" charset="utf-8" src="<?php print $url?>js/simpletreemenu.js"></script>
        <script src="<?php print $url?>js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script type="text/javascript">

        ddtreemenu.createTree("treemenu2", false);

        function hilang(id){
          $("#anak_hilang_"+id).fadeToggle();
        }
        
        $(function() {

            "use strict";

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });

            //When unchecking the checkbox
            $("#check-all").on('ifUnchecked', function(event) {
                //Uncheck all checkboxes
                $("input[type='checkbox']", ".table-mailbox").iCheck("uncheck");
            });
            //When checking the checkbox
            $("#check-all").on('ifChecked', function(event) {
                //Check all checkboxes
                $("input[type='checkbox']", ".table-mailbox").iCheck("check");
            });
        });
        
        function get_pesan_jendol(){
          $.post('<?php print site_url("home/portal-home/ajax-pesan-jendol")?>',function(data_pesan_jendol){
            var data_jendol = jQuery.parseJSON( data_pesan_jendol );
//            console.log(data_pesan_jendol);
            $('.pesan_jendol').text(data_jendol.jml);
            $('#isi_pesan_jendol').html(data_jendol.isi);
          });
        }
        
        get_pesan_jendol();

        </script>
        
        <?php print $foot;?>
    </body>
</html>