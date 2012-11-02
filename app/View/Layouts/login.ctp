<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<?php echo $this->element('css'); ?>

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Load Jquery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
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
	<?php echo $this->element('js'); ?>

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
