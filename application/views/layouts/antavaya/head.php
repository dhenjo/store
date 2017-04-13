<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
<head>
    <!-- Page Title -->
    <title>AntaVaya Tour & Travel beli tiket murah</title>
    <link href="<?php print $url?>images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="AntaVaya Tour & Travel Tiket Pesawat Hotel" />
    <meta name="description" content="AntaVaya Tour | Tour & Travel beserta tiket berbagai maskapai dan juga hotel ternama dunia. Tiket pesawat murah">
    <meta name="author" content="AntaVaya Team">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Theme Styles -->
    <link rel="stylesheet" href="<?php print $url?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php print $url?>css/font-awesome.min.css">
    <!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>-->
    <link rel="stylesheet" href="<?php print $url?>css/animate.min.css">
    <link rel="stylesheet" href="<?php print $url?>css/bootstrap-nav-wizard.css">
    
    <!-- Current Page Styles -->
    <link rel="stylesheet" type="text/css" href="<?php print $url?>components/revolution_slider/css/settings.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php print $url?>components/revolution_slider/css/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php print $url?>components/jquery.bxslider/jquery.bxslider.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php print $url?>components/flexslider/flexslider.css" media="screen" />
    
    <!-- Main Style -->
    <link id="main-style" rel="stylesheet" href="<?php print $url?>css/style.css">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php print $url?>css/custom.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="<?php print $url?>css/updates.css">

    <!-- Updated Styles -->
    <link rel="stylesheet" href="<?php print $url?>css/updates.css">
    
    <!-- Responsive Styles -->
    <link rel="stylesheet" href="<?php print $url?>css/responsive.css">
    <?php
    print $css;
    ?>
    <!-- CSS for IE -->
    <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?php print $url?>css/ie.css" />
    <![endif]-->
    
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
    <![endif]-->

    <!-- Javascript Page Loader -->
<!--    <script type="text/javascript" src="<?php print $url?>js/pace.min.js" data-pace-options='{ "ajax": false }'></script>
    <script type="text/javascript" src="<?php print $url?>js/page-loading.js"></script>-->
    
</head>
<body>
    <span style="display: none" id="link_home"><?php print site_url()?></span>
    <span style="display: none" id="link_themes"><?php print $url?></span>
    <div id="page-wrapper">
        <header id="header" class="navbar-static-top">
            <?php
            $link_block2nd = "style='display: none'";
            $link_block = "";
            if($this->session->userdata("id") > 0){
              $link_block = "style='display: none'";
              $link_block2nd = "";
            ?>
            <div class="topnav hidden-xs">
                <div class="container">
                    <ul class="quick-menu pull-left">
                        <li><a href="<?php print site_url($this->session->userdata("dashbord"))?>">My Account</a></li>
<!--                        <li class="ribbon">
                            <a href="#">English</a>
                            <ul class="menu mini">
                                <li><a href="#" title="Dansk">Dansk</a></li>
                                <li><a href="#" title="Deutsch">Deutsch</a></li>
                                <li class="active"><a href="#" title="English">English</a></li>
                                <li><a href="#" title="Español">Español</a></li>
                                <li><a href="#" title="Français">Français</a></li>
                                <li><a href="#" title="Italiano">Italiano</a></li>
                                <li><a href="#" title="Magyar">Magyar</a></li>
                                <li><a href="#" title="Nederlands">Nederlands</a></li>
                                <li><a href="#" title="Norsk">Norsk</a></li>
                                <li><a href="#" title="Polski">Polski</a></li>
                                <li><a href="#" title="Português">Português</a></li>
                                <li><a href="#" title="Suomi">Suomi</a></li>
                                <li><a href="#" title="Svenska">Svenska</a></li>
                            </ul>
                        </li>-->
                    </ul>
<!--                    <ul class="quick-menu pull-right">
                        <li><a href="#travelo-login" class="soap-popupbox">LOGIN</a></li>
                        <li><a href="#travelo-signup" class="soap-popupbox">SIGNUP</a></li>
                        <li class="ribbon currency">
                            <a href="#" title="">USD</a>
                            <ul class="menu mini">
                                <li><a href="#" title="AUD">AUD</a></li>
                                <li><a href="#" title="BRL">BRL</a></li>
                                <li class="active"><a href="#" title="USD">USD</a></li>
                                <li><a href="#" title="CAD">CAD</a></li>
                                <li><a href="#" title="CHF">CHF</a></li>
                                <li><a href="#" title="CNY">CNY</a></li>
                                <li><a href="#" title="CZK">CZK</a></li>
                                <li><a href="#" title="DKK">DKK</a></li>
                                <li><a href="#" title="EUR">EUR</a></li>
                                <li><a href="#" title="GBP">GBP</a></li>
                                <li><a href="#" title="HKD">HKD</a></li>
                                <li><a href="#" title="HUF">HUF</a></li>
                                <li><a href="#" title="IDR">IDR</a></li>
                            </ul>
                        </li>
                    </ul>-->
                </div>
            </div>
        <?php }
        $link_users = "<li class='menu-item-has-children luar' {$link_block}>"
              . "<a href='#travelo-login' class='soap-popupbox'>Login</a></li>"
              . "<li class='menu-item-has-children' {$link_block}>"
              . "<a href='#travelo-signup' class='soap-popupbox'>Daftar</a>"
              . "</li>"
              . "<li class='menu-item-has-children dalam' {$link_block2nd}>"
              . "<a href='".site_url("antavaya/logout")."'>Logout</a></li>";
        ?>
            <div class="main-header">
                
                <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
                    Mobile Menu Toggle
                </a>

                <div class="container" style="padding-top: 15px; padding-bottom: 15px;">
                    <h1 class="navbar-brand">
                        <a href="<?php print site_url()?>" title="AntaVaya Tour & Travel - Home">
                            <img src="<?php print $url?>images/logo.png" alt="AntaVaya Tour & Travel" />
                        </a>
                    </h1>

                    <nav id="main-menu" role="navigation">
                        <ul class="menu" style="color: black; font-weight: bold">
                            <li class="menu-item-has-children">
                                <a href="<?php print site_url()?>" style="font-weight: bold">Home</a>
                            </li>
                            <li class="menu-item-has-children">
                                <a  href="<?php print site_url("page/index/tour-%26-leisure")?>" style="font-weight: bold">Tour & Leisure</a>
                                <ul>
                                    <li><a href="<?php print site_url("promosi")?>">FIT & Packages</a></li>
                                    <!--<li><a href="<?php // print site_url("page/index/domestic")?>javascript:void(0)">Domestic</a></li>-->
                                    <li><a href="<?php print site_url("grouptour")?>">Group Tour</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="<?php print site_url("page/index/corporate-travel")?>" style="font-weight: bold">Corporate Travel</a>
                                <ul>
                                    <li><a href="<?php print site_url("page/index/corporate-travel-management")?>">Corporate Travel Management</a></li>
                                    <li><a href="<?php print site_url("page/index/travel-management-services")?>">Travel Management Services</a></li>
                                    <li><a href="<?php print site_url("page/index/our-technology")?>">Our Technology</a></li>
                                    <li><a href="<?php print site_url("page/index/hrg-worldwide-network")?>">HRG Worldwide Network</a></li>
                                    <!--<li><a href="javascript:void(0)">Why AntaVaya Corporate Travel?</a></li>-->
                                    <li><a href="<?php print site_url("page/index/why-antavaya-corporate-travel")?>">Why AntaVaya Corporate Travel?</a></li>
                                    <li><a href="<?php print site_url("page/index/clients-and-testimonials")?>">Clients & Testimonials</a></li>
                                    <li><a href="<?php print site_url("page/index/about-us")?>">Who are we?</a></li>
                                </ul>
                            </li>
                            <li class="menu-item-has-children">
                                <a href="<?php print site_url("page/index/conference-%26-exhibition")?>" style="font-weight: bold">Conference & Exhibition</a>
<!--                                <ul>
                                    <li><a href="<?php print site_url("page/index/mice-services")?>">MICE Services</a></li>
                                </ul>-->
                            </li>
                            <li class="menu-item-has-children">
                                <a href="javascript:void(0)" style="font-weight: bold">More ...</a>
                                <ul>
                                    <li><a href="<?php print site_url("haji")?>">Hajj & Umrah</a></li>
                                    <li><a href="<?php print site_url("page/index/inbound-services")?>">Inbound Service</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="<?php print site_url("page/html/careers")?>">Careers</a>
                                        <ul>
                                            <li><a href="<?php print site_url('page/html/why-join-us')?>">Why Join Us?</a></li>
                                            <li><a href="<?php print site_url('page/html/careers')?>">Current Openings</a></li>
                                            <!--<li><a href="<?php print site_url('page/html/travel-consultant-dev-program')?>">Travel Consultant <br />Development Program</a></li>-->
                                        </ul>
                                    </li>
<!--                                    <li class="menu-item-has-children">
                                        <a href="<?php print site_url("page/html/about-us")?>">About Us</a>
                                        <ul>
                                            <li><a href="<?php print site_url("page/html/about-us#ct-corp")?>">CT Corp</a></li>
                                            <li><a href="<?php print site_url("page/html/about-us#glance")?>">AntaVaya at a Glance</a></li>
                                            <li><a href="<?php print site_url("page/html/about-us#antavaya-way")?>">The AntaVaya Way</a></li>
                                            <li><a href="<?php print site_url("page/html/about-us#contact-us")?>">Contact Us</a></li>
                                        </ul>
                                    </li>-->
                                    <?php print $link_users?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <nav id="mobile-menu-01" class="mobile-menu collapse">
                    <ul id="mobile-primary-menu" class="menu">
                        <li>
                            <a href="<?php print site_url()?>" style="font-weight: bold">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a  href="<?php print site_url("page/index/tour-%26-leisure")?>" style="font-weight: bold">Tour & Leisure</a>
                            <ul>
                                <li><a href="<?php print site_url("promosi")?>">FIT & Packages</a></li>
                                <!--<li><a href="<?php // print site_url("page/index/domestic")?>javascript:void(0)">Domestic</a></li>-->
                                <li><a href="<?php print site_url("grouptour")?>">Group Tour</a></li>
                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="<?php print site_url("page/index/corporate-travel")?>" style="font-weight: bold">Corporate Travel</a>
                            <ul>
                                <li><a href="<?php print site_url("page/index/corporate-travel-management")?>">Corporate Travel Management</a></li>
                                <li><a href="<?php print site_url("page/index/travel-management-services")?>">Travel Management Services</a></li>
                                <li><a href="<?php print site_url("page/index/our-technology")?>">Our Technology</a></li>
                                <li><a href="<?php print site_url("page/index/hrg-worldwide-network")?>">HRG Worldwide Network</a></li>
                                <!--<li><a href="javascript:void(0)">Why AntaVaya Corporate Travel?</a></li>-->
                                <li><a href="<?php print site_url("page/index/why-antavaya-corporate-travel")?>">Why AntaVaya Corporate Travel?</a></li>
                                <li><a href="<?php print site_url("page/index/clients-and-testimonials")?>">Clients & Testimonials</a></li>
                                <li><a href="<?php print site_url("page/index/about-us")?>">Who are we?</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?php print site_url("page/index/conference-%26-exhibition")?>" style="font-weight: bold">Conference & Exhibition</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("haji")?>">Hajj & Umrah</a>
                        </li>
                        <li>
                            <a href="<?php print site_url("page/index/inbound-services")?>">Inbound Service</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="<?php print site_url("page/html/careers")?>">Careers</a>
                             <ul>
                                 <li><a href="<?php print site_url('page/html/why-join-us')?>">Why Join Us?</a></li>
                                 <li><a href="<?php print site_url('page/html/careers')?>">Current Openings</a></li>
                                 <!--<li><a href="<?php print site_url('page/html/travel-consultant-dev-program')?>">Travel Consultant <br />Development Program</a></li>-->
                             </ul>
                        </li>
                        <?php print $link_users?>
                        
                    </ul>
                    <?php
                    if($this->session->userdata("id") > 0){
                    ?>
                    <ul class="mobile-topnav container">
                        <li><a href="<?php print site_url("page/master-page")?>">My Account</a></li>
                    </ul>
                    <?php }?>
                    
                </nav>
            </div>
            <div id="travelo-signup" class="travelo-signup-box travelo-box">
                <?php print $this->form_eksternal->form_open(site_url("antavaya/daftar"), 'role="form"')?>
                    <div class="form-group">
                        <input type="text" name="name" class="input-text full-width" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" class="input-text full-width" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="pass" class="input-text full-width" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="re_pass" class="input-text full-width" placeholder="Ulangi Password">
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="berita" value="2"> Menerima berita dari AntaVaya
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="description">Dengan mendaftar menjadi anggota AntaVaya, artinya menyetujui term & condition yang ada.</p>
                    </div>
                    <button type="submit" class="full-width btn-medium">DAFTAR</button>
                </form>
                <div class="seperator"></div>
                <p>Sudah terdaftar? <a href="#travelo-login" class="goto-login soap-popupbox">Login</a></p>
            </div>
            <div id="travelo-login" class="travelo-login-box travelo-box">
<!--                <div class="login-social">
                    <a href="#" class="button login-facebook"><i class="soap-icon-facebook"></i>Login with Facebook</a>
                    <a href="#" class="button login-googleplus"><i class="soap-icon-googleplus"></i>Login with Google+</a>
                </div>
                <div class="seperator"><label>OR</label></div>-->
                <?php print $this->form_eksternal->form_open(site_url("antavaya/login"), 'role="form"')?>
                    <div class="form-group">
                        <input type="text" name="email" class="input-text full-width" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="pass" class="input-text full-width" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button name="submit" class="full-width">LOGIN</button>
                    </div>
                    <div class="form-group">
                        <a href="<?php site_url("login/lupa-password")?>" class="forgot-password pull-right">Lupa password?</a>
<!--                        <div class="checkbox checkbox-inline">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                        </div>-->
                    </div>
                </form>
                <div class="seperator"></div>
                <p>Belum terdaftar? <br /><a href="#travelo-signup" class="goto-signup soap-popupbox">Daftar sekarang</a></p>
            </div>
        </header>