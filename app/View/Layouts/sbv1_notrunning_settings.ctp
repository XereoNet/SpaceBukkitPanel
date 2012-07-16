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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
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
						<a href="./global/start" id="start" class="tip showOverlay" rel="Starting server..."></a> 
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
			        		<li class="<?php if ($this->name == "DashController") { echo "current" ; }  ?> fadein"> 
							<a href="<?php echo $this->Html->url('/dash', true); ?>"> <span class="icon dashboard"></span><?php echo __(' Dashboard') ?></a> 
			        		</li>
				        <?php endif; ?>
				        <?php if ($is_super == 1) { ?>
					        <li class="<?php if ($this->name == "Tsettings") { echo "current" ; }  ?> fadein floatright"> 
					        	<a href="<?php echo $this->Html->url('/tsettings', true); ?>"> <span class="icon settings"></span><?php echo __(' Settings ') ?></a> 
					        </li>
				        <?php } ?>
					        </ul>
					</nav>
					<!-- End Navigation --> 

					<?php echo $content_for_layout ?>

				
				</div>
			<!-- End #wrapper --> 

			<div id="footer">

				<div class="col left">
					<p>
				<?php echo __('SpaceBukkit version'); ?> <?php echo $spacebukkitbuildcurrent; ?> <?php echo __('proudly presented by the SpaceBukkit Team :)'); ?>
					</p>
				</div>

				<div class="col right">

				<ul>
					<li><a href="http://spacebukkit.xereo.net" alt="SpaceBukkit Home"><?php echo __('Home'); ?></a></li>
					<li><a href="http://spacebukkit.xereo.net/wiki" alt="SpaceBukkit Home"><?php echo __('Wiki'); ?></a></li>
					<li><a href="http://spacebukkit.xereo.net/forum" alt="SpaceBukkit Home"><?php echo __('Forums'); ?></a></li>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="display: inline-block; position: relative; top: 10px;">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="ZW8KTNTJLRGGY">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
					</form>

				</ul>

				</div>

			</div>
			<!-- End #footer --> 			
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
