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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
</head>

<body>

	<div id="header">
		<div id="container" class="login"> 
			
			<!-- Logo -->
			<div class="hheight"> 

				<!-- Logo -->
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
				
			</div>
			


			<!-- Main Content Start -->
			<div id="wrapper" class="update_bukkit"> 
			
			<?php echo $content_for_layout ?>
				
			</div>
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 

	<!-- Import JS -->
<?php echo $this->element('js'); ?>
	</body>
</html>
