<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css" /> 

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Load theme -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>themes/<?php echo $current_theme?>/css/theme.css" /> 

<!-- Load Jquery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
<script src="<?php echo $this->webroot; ?>js/selectivizr.min.js"></script> 

</head>
	
<body>
	<div id="header">
		<div id="container" class="login"> 
			
			<!-- Logo -->
			<div class="hheight">
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
			</div>
			
			<!-- Main Content Start -->
			
			<?php echo $content_for_layout ?>
				
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 
		<div class="clearfooter"></div>
	</div>
	<!-- End #header --> 

	<script src="<?php echo $this->webroot; ?>js/ttw-simple-notifications-min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/excanvas.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.uniform.min.js"></script> 
	<script src="http://tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.livesearch.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.visualize.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.validate.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.datatables.js"></script>
	<script src="<?php echo $this->webroot; ?>js/reload_dtb.js"></script>
	<script src="<?php echo $this->webroot; ?>js/ajax.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.placeholder.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.tools.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.colorbox-min.js"></script>
<?php 
if (isset($doodle)) {
?>
<script>
$(document).ready(function() {
var doodle = "url(<?php echo $doodle; ?>)";
$("#logo").css("background-image", doodle);  

});
</script>

<?php 
}
?>
	</body>
</html>
