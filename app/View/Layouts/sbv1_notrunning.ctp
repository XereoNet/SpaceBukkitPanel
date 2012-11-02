<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<?php echo $this->element('css'); ?>

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!--[if lte IE 6]>

<meta HTTP-EQUIV="REFRESH" content="0; url=http://www.ie6countdown.com/">

<![endif]-->

<noscript><h1>Please enabled Javascript!</h1></noscript>



<!-- Load Jquery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->webroot; ?>js/script.js"></script> 
<script src="<?php echo $this->webroot; ?>js/selectivizr.min.js"></script> 

</head>


<body>
<div class="screen_overlay">
 <div>text...</div>
</div>
<?php if((isset($spacebukkitbuildready)) && ($user_perm['is_super'] == 1)) {?>
<div class="top_message black slideDown">
<p><?php echo __('A new SpaceBukkit update is ready for you to download! Your version is'); ?> <strong><?php echo $spacebukkitbuildcurrent; ?></strong> <?php echo __('while the new version is'); ?> <strong><?php echo $spacebukkitbuildfile; ?></strong> &nbsp; &nbsp;  <a class="button icon arrowright" href="<?php ?>"><?php echo __('Click here to get it'); ?></a></p>
</div>
<?php };?>

<?php if(isset($antmessage)) {?>
<div class="top_message <?php echo $antmessagetype; ?> slideDown">
<p><?php echo $antmessage; ?></p>
</div>
<?php };?>

	<div id="header">
		<div id="container"> 

			<!-- Logo -->
			<div class="hheight"> 

				<!-- Logo -->
				<div class="col left col_1_3">
				<h1 id="logo">SpaceBukkit</h1>
				</div>
				<!-- Upper Bar -->
				<div id="upperbar" class="col right">
					<div id="serverbox">
						<span class="dropdown_servers tip"><p><a href="#"><?php echo $current_server_name; ?></a></p></span>
						<div class="tooltip server_add_to_list" style="max-width: 190px">
							<ul>
									<?php 

					//get all servers and display them nicely :)

					if ($is_super == 1) {

					//if superuser
					
					foreach ($all_servers as $list) {

						$title = $list['Server']['title'];
						$id = $list['Server']['id'];

								echo <<<END
									<li><a href="./global/setserver/$id">$title</a></li>
END;
					}
										
					} else {

					//if not superuser
					
					foreach ($user_data['AllowedServers'] as $sid => $list) {

						$title = $list['Server']['title'];
						$id = $list['Server']['id'];

								echo <<<END
									<li><a href="./global/setserver/$id">$title</a></li>
END;
					}
 }


								?>	
							</ul>
						</div>

					</div>
					
					<!-- Start/Stop, Reload, Message, Logout -->

					<div id="serverbuttons"> 

						<?php if (perm('global', 'stopStartServer', $user_perm)): ?>
						<a href="./global/start" id="start" class="bounce tip showOverlay" rel="Starting server..."></a> 
								<div class="tooltip">Start server</div>	
						<?php endif; ?>

					</div>


					<div id="userbuttons">
						
						<span><a href="#" class="account tip"><?php echo $username; ?> </a></span>
						<div class="tooltip">
							<ul>
								<li><a href="./users/edit/<?php echo $current_user_id; ?>" class="fancy"><?php echo __('Account Settings'); ?></a></li>
								<li><a href="./users/theme" class="fancy"><?php echo __('SpaceBukkit Theme'); ?></a></li>
								<li><a href="./users/logout"><?php echo __('Logout'); ?></a></li>
							</ul>
						</div>
											
					</div>
				</div>
			</div>

			<!-- Main Content Start -->
			<div id="wrapper"> 
			
					<!-- Navigation -->
					<nav id="mainnav">
						<ul>
						<?php if (perm('pages', 'dash', $user_perm)): ?>
			        		<li class="<?php if ($this->name == "DashController") { echo "current" ; }  ?> bounce fadein"> 
							<a href="<?php echo $this->Html->url('/dash', true); ?>"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> 
			        		</li>
				        <?php endif; ?>
				        <?php if ($is_super == 1) { ?>
					        <li class="<?php if ($this->name == "Tsettings") { echo "current" ; }  ?> bounce fadein floatright"> 
					        	<a href="<?php echo $this->Html->url('/tsettings', true); ?>"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> 
					        </li>
				        <?php } ?>
					        </ul>
					</nav>
					<!-- End Navigation --> 

					<!-- Tabs -->
					<nav id="smalltabs">
					</nav>
					<!-- End Tabs -->

					<div class="colorbox red">
					    <h3><?php echo __('Server is stopped!'); ?></h3> 
					    <p> 
					    	<?php echo __('This page needs a running server to fetch it\'s data. 
					        You can start your server in the upper right bar of SpaceBukkit.'); ?>
					    </p> 
					</div>
				
				</div>
			<!-- End #wrapper --> 

			<?php echo $this->element('footer'); ?>			
		</div>
		<!-- End #container --> 

	<!-- Import JS -->
	<?php echo $this->element('js'); ?>

	
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
