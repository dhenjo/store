<link rel="stylesheet" href="<?php print $url?>css/jquery.ui.autocomplete.css" type="text/css" />

<link rel="stylesheet" href="<?php print $url?>css/jquery.ui.datepicker.mobile.css" type="text/css"/>

<script type="text/javascript" src="<?php print $url?>js/jquery.mobile-1.0a4.1.min.js"></script>
<script type="text/javascript" src="<?php print $url?>js/jquery.ui.datepicker.mobile.js"></script>

<?php print $this->load->view("mobile/form-book-js");?>

</head>          
<body>

<div data-role="page" data-theme="c" id="page1">
   <div data-role="header">
	<h1>Search flight</h1>
	<a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home1">Home</a>
	<img src="<?php print $url?>img/tiketdomestik_logo.png" width="150">
   </div><!-- /header -->

   <div data-role="content" data-scroll="xp">
     
      <!--<form name="fdtpicker1" id="fdtpicker1" method="POST" data-ajax="false" action="index.php?option=com_tab&view=tab&layout=default.260412">-->
      <form name="form_search" id="fdtpicker1" method="post" action="<?php print site_url("antavaya/flight-list")?>">
      <!--<form name="fdtpicker1" id="fdtpicker1" method="POST" data-ajax="false" action="tab.php">-->
      <!--<form name="fdtpicker1" id="fdtpicker1" onsubmit='return validateForm()' method="POST" data-ajax="false" action="index.php?option=com_tab&view=tab">-->
      <!--<form name="fdtpicker" method="post" action="index.php?option=com_tab&view=tab">-->
        <fieldset data-role="controlgroup" id="rdpilih">
          <!--<div id="rd2way">
            <input name="rdt" value="roundtrip" type="radio" id="rdtrip" >
            <label for="rdtrip">Round trip</label>
          </div>-->
          <div id="rd1way">
            <input name="rdotrip" value="Round trip" type="radio" id="rdtrip" checked="true">
            <label for="rdtrip" id="lblrdtirp">Round trip</label>
            <input name="rdotrip" value="oneway" type="radio" id="rdoneway">
            <label for="rdoneway" id="lbldroneway">One way</label>
          </div>
        </fieldset>
        
	<label for="autocomplt">Kota asal</label>
	<input type="text" name="tdr" id="autocomplt" value="" />

	<label for="autocomplt2">Kota tujuan</label>
	<input name="tke" id="autocomplt2" />
	
	<label for="datepicker1">Tanggal berangkat</label>
	<input type="text" name="tgl" id="datepicker1" value="" readonly />
        <div id="datepicker"></div>
	
	<div id="hilang">
          <label for="dttujuan" id="tkembali">Tanggal kembali</label>
 	  <input type="text" name="tglr" id="dttujuan" value="" readonly />
 	  <div id="dttujuan1"></div>
	</div>
	<!--
	<fieldset data-role="controlgroup">
	  <input id="sekarang" name="rdt1" value="sekarang" type="radio" />
	  <label for="sekarang">Must travel on these dates</label>
	  <input id="nanti" name="rdt1" value="nanti" type="radio" />
	  <label for="nanti">Search by price +/- 3 days</label>
	</fieldset>
	-->
	<fieldset data-role="controlgroup">
	<label for="dewasa">Dewasa</label>
	<select name="adl" id="dewasa">
	<option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option>        </select>
        
        <label for="anak">Anak-anak</label>
	<select name="chd" id="anak">
	    <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
	    <option value="3">3</option>
	        </select>
        
        
        <label for="bayi">Infant</label>
        <select name="inf" id="bayi">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        
        </fieldset>
        <input type="submit" name="sendtest1" id="sendtest1" value="Send" />
     </form>
   </div><!-- /content -->

   