<header class="header">
  <a href="<?php print site_url()?>" target="_blank" class="logo">
      AV TMS | Tour Management System
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </a>
      <div class="navbar-right">
          <ul class="nav navbar-nav">
              <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-envelope"></i>
                      <span class="label label-success"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 0 messages</li>
                      <li>
                          <ul class="menu">
<!--                                        <li>
                                  <a href="#">
                                      <div class="pull-left">
                                        <?php
                                        if($this->session->userdata("avatar")){
                                          $avatar = $this->session->userdata("avatar");
                                        }
                                        else{
                                          $avatar = $url."img/no-pic.png";
                                        }
                                        ?>
                                          <img src="<?php print $avatar?>" class="img-circle" alt="User Image"/>
                                      </div>
                                      <h4>
                                          Support Team
                                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>-->
                          </ul>
                      </li>
                      <li class="footer"><a href="#">See All Messages</a></li>
                  </ul>
              </li>
<!--              <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-warning"></i>
                      <span class="label label-warning">!</span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">Promo Prioritas</li>
                      <?php
//                      $info_promo = $this->global_models->informasi_promo();
                      ?>
                      <li>
                          <ul class="menu">
                            <?php
                            foreach($info_promo AS $ip){
                            ?>
                              <li>
                                  <a href="<?php print site_url($ip['link'])?>">
                                      <h4 style="margin: 0">
                                          <?php print $ip["company"]?>
                                      </h4>
                                      <p style="margin: 0"><?php print $ip["title"]?></p>
                                      <p style="margin: 0"><small><i class="fa fa-clock-o"></i>End Date : <?php print date("d F Y", strtotime($ip["end_date"]))?></small></p>
                                  </a>
                              </li>
                            <?php }?>
                          </ul>
                      </li>
                      <li class="footer"></li>
                  </ul>
              </li>-->
              <li class="dropdown tasks-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-tasks"></i>
                      <span class="label label-danger"></span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 0 tasks</li>
                      <li>
                          <ul class="menu">
<!--                                        <li>
                                  <a href="#">
                                      <h3>
                                          <small class="pull-right">20%</small>
                                      </h3>
                                      <div class="progress xs">
                                          <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                              <span class="sr-only">20% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>-->
                          </ul>
                      </li>
                      <li class="footer">
                          <a href="#">View all tasks</a>
                      </li>
                  </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="glyphicon glyphicon-user"></i>
                      <span><?php print $this->session->userdata("name")?> <i class="caret"></i></span>
                  </a>
                  <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header bg-light-blue">
                        <?php
                        if($this->session->userdata("avatar")){
                          $avatar = $this->session->userdata("avatar");
                        }
                        else{
                          $avatar = $url."img/no-pic.png";
                        }
                        ?>
                          <img src="<?php print $avatar?>" class="img-circle" alt="User Image" />
                          <p>
                              <?php print $this->session->userdata("name")." - ".$this->global_models->get_field("m_privilege", "name", array("id_privilege" => $this->session->userdata("id_privilege")))?>
                          </p>
                      </li>
                      <li class="user-footer">
                          <div class="pull-left">
                              <a href="<?php print site_url("users/edit-profile")?>" class="btn btn-default btn-flat">Profile</a>
                          </div>
                          <div class="pull-right">
                              <a href="<?php print site_url("login")?>" class="btn btn-default btn-flat">Sign out</a>
                          </div>
                      </li>
                  </ul>
              </li>
          </ul>
      </div>
  </nav>
</header>