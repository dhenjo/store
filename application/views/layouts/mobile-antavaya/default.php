<html>
<head>
<link rel="stylesheet" href="<?php print $url?>css/jquery.mobile-1.0a4.1.css" type="text/css"/>
<link rel="stylesheet" href="<?php print $url?>css/jquery.mobile-1.0a4.1.min.css" type="text/css"/>

<script type="text/javascript" src="<?php print $url?>js/jquery.js"></script>
<script type="text/javascript" src="<?php print $url?>js/jquery-ui-1.8.10.custom.min.js"></script>

<script type="text/javascript" src="<?php print $url?>js/jquery.mobile-1.0a4.1.min.js"></script>

<script>
$(document).ready(function(){
  
//  $.mobile.pageLoading();
//  $(window).load(function(){ $.mobile.pageLoading('hide'); });
});
</script>
</head>
<body>
<?php
print $template['body'];
?>
<div data-role="footer">
	<!--<h4></h4>-->
    <a href="<?php print site_url()?>" data-icon="home" data-ajax="false" class="kembali" id="home2">Home</a>
    <a href="<?php print site_url("antavaya/index/desc")?>" id='webversi' data-ajax="false">Desktop version</a>
   </div><!-- /footer -->
   <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/> <br/>
</div> <!-- /page -->

</body>
<?php print $foot2?>
</html>
