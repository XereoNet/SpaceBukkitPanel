<!DOCTYPE html>
<html>
<head>
<title>Error: <?php echo $title_for_layout?> | SpaceBukkit by XereoNet | Bukkit Web Administration</title>

<!-- CSS -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>css/import.css" /> 

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Load theme -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>themes/<?php echo $current_theme?>/css/theme.css" /> 

<!-- Load Jquery -->
<?php 		echo $this->Html->css('cake.generic'); ?>
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
			<div id="wrapper"> 

				<!-- Content -->
				<section id="content"> 

				<section class="box boxpad"> 
				 
				<header>
				    	<img src="./img/warning-icon.png" style="display: inline;width: 40px;height: 40px;">
				        <h2 style="display: inline; position: relative; top: -16px; left: 10px;background: none;"><?php echo __('Sorry, SpaceBukkit has encountered an error'); ?></h2> 

				    </header>

				    <section>

				    <?php echo $content_for_layout ?>

				    <p>
						<h3><?php echo __('You can always get support following one of these links:'); ?></h3>
						<ul>
							<li><a href="http://forums.xereo.net">SpaceBukkit Forums</a></li>
							<li><a href="http://spacebukkit.xereo.net/wiki">SpaceBukkit Wiki</a></li>
							<li><a href="http://github.com/SpaceDev/SpaceBukkitPanel">SpaceBukkit Github</a></li>
						</ul>
					</p>
					
				    </section> 
				                        
				 </section>

				<div class="clear"></div>
				</section>
				<!-- End #content --> 

			
			
				
			</div>
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 
	</body>
</html>
