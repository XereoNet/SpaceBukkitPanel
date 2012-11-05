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
<link rel="stylesheet" type="text/css" media="screen" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css" />
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 

</head>

<body>
<?php if(isset($spacebukkitbuildready)) {?>
<div class="top_message black slideDown">
<p><?php echo __('A new SpaceBukkit update is ready for you to download! You\'re version is'); ?> <strong><?php echo $spacebukkitbuildcurrent; ?></strong> <?php echo __('while the new version is'); ?> <strong><?php echo $spacebukkitbuildnew; ?></strong> <a href="./update/"><?php echo __('Click here when you are ready'); ?></a></p>
</div>
<?php };?>
<?php if(isset($antmessage)) {?>
<div class="top_message <?php echo $antmessagetype; ?> slideDown">
<p><?php echo $antmessage; ?></p>
</div>
<?php };?>

</div>
	<div id="header">
		<div id="container"> 

			<!-- Logo -->
			<div class="hheight"> 

				<!-- Logo -->
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
				<!-- Upper Bar -->
				<div id="upperbar" class="col right col_2_3">

					<div id="userbuttons">
						
						<span><a href="#" class="account tip"><?php echo __('Hey there'); ?>, <?php echo $username; ?> :) </a></span>
						<div class="tooltip white">
							<ul>
								<li><a href="<?php echo $this->Html->url('/users/settings', true); ?>" class="fancy"><?php echo __('Account Settings'); ?></a></li>
								<li><a href="<?php echo $this->Html->url('/users/theme', true); ?>" class="fancy"><?php echo __('SpaceBukkit Theme'); ?></a></li>
								<li><a href="<?php echo $this->Html->url('/users/logout', true); ?>"><?php echo __('Logout'); ?></a></li>
							</ul>
						</div>

						
					</div>
				</div>
			</div>


			<!-- Main Content Start -->
			<div id="wrapper"> 
			
					<!-- Tabs -->
					<nav id="smalltabs">
					</nav>
					<!-- End Tabs -->

					<div class="colorbox red">
					    <h3><?php echo __('There are no servers stored in the database. Ask an administrator to add one.'); ?></h3> 
					</div>
				
						</div>
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 

	<!-- Import JS -->
	<script src="<?php echo $this->webroot; ?>js/ttw-simple-notifications-min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/excanvas.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.uniform.min.js"></script> 
	<script src="//tab-slide-out.googlecode.com/files/jquery.tabSlideOut.v1.3.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.livesearch.js"></script>
	<script src="<?php echo $this->webroot; ?>js/jquery.visualize.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.datatables.js"></script>
	<script src="<?php echo $this->webroot; ?>js/reload_dtb.js"></script>
	<script src="<?php echo $this->webroot; ?>js/ajax.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.placeholder.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.tools.min.js"></script> 
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
