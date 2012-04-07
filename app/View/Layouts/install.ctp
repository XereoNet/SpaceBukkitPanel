<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css" /> 
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/overcast/jquery-ui-1.8.18.custom.css" /> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lte IE 6]>

<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.ie6countdown.com/">

<![endif]-->

<noscript><h1>Please enabled Javascript!</h1></noscript>


<!-- Load theme -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>themes/<?php echo $current_theme?>/css/theme.css" /> 

<!-- Load Jquery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>

<script src="<?php echo $this->webroot; ?>js/selectivizr.min.js"></script> 

</head>

<body>
	<div id="header">
		<div id="container"> 
			
			<!-- Logo -->
			<div class="hheight">
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
			</div>
			
			<!-- Main Content Start -->
			
			<?php echo $content_for_layout ?>
				
		</div>

	<!-- End #container --> 

	</div>
	
	<!-- Import JS -->

	<script src="<?php echo $this->webroot; ?>js/jquery.datatables.js"></script>
	<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/excanvas.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.uniform.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.validate.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.placeholder.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.tools.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.activity-indicator-1.0.0.min.js"></script>
	
	<!--[if IE 6]>
		<script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.nyroModal-ie6.min.js"></script>
	<![endif]-->
  
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
