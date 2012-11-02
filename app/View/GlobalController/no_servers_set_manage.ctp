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
					    <h3><?php echo __('There are no servers connected with this panel!'); ?></h3> 
					</div>

					<div class="col left">
					<section class="box boxpad"> 
					 
					        <header>
					            <h2><?php echo __('Add a server') ?></h2> 
					        </header>
					        
					       <section>  
					        <form id="ServerAddForm" name="ServerAddForm" method="post" action="<?php echo $this->Html->url('/servers/add', true); ?>">
								<div class="error_box"></div>
								    <section>
								      <label for="title">
								        <?php echo __('Title'); ?>
								      </label>
								    
								      <div>
								        <input id="title" name="title" type="text" placeholder="<?php echo __('My Cool Server'); ?>"/>
								      </div>
								    </section>
								  
								    <section>
								      <label for="address">
								        <?php echo __('Address'); ?>
								        <small><?php echo __('Port doesn\'t matter'); ?></small>
								      </label>
								    
								      <div>
								        <input type="text" id="address" name="address" placeholder="example.minecraft.com" />
								      </div>
								    </section>

								    <section>
								      <label for="port1">
								        <?php echo __('Spacebukkit port'); ?>
								        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
								      </label>
								    
								      <div>
								        <input type="text" id="port1" name="port1" placeholder="<?php echo __('Usually 2011'); ?>" />
								      </div>
								    </section>

								    <section>
								      <label for="port2">
								        <?php echo __('SpacebukkitRTK port'); ?>
								        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
								      </label>
								    
								      <div>
								        <input type="text" id="port2" name="port2" placeholder="<?php echo __('Usually 2012'); ?>" />
								      </div>
								    </section>
								  
								    <section>
								      <label for="password">
								        <?php echo __('Salt'); ?>
								        <small><?php echo __('This can be changed in the config.yml of your server'); ?></small>
								      </label>
								    
								      <div>
								        <input placeholder="<?php echo __('Salty Pretzels!'); ?>" name="password" id="password" type="password" />
								      </div>
								    </section>   
								<input type="submit" class="button primary submit" value="<?php echo __('Submit'); ?>">
							</form>

					    	</section> 
					                        
					 </section>

					</div>   <!-- End col left --> 
					<div class="col right">

					<section class="box boxpad"> 
					 
					    <header>
					        <h2><?php echo __('Manage Users') ?></h2> 
					    </header>

					    <section>

						     <table class="datatable dtb1 notitle" id="settings_users" style="cursor: pointer"> 
						      <thead> 
						        <tr> 
						          <th><?php echo __('Name ') ?>
						          <a href="<?php echo $this->Html->url('/users/add', true); ?>" class="fancy" style="float: right; margin-right: 5px"><?php echo __('Add new user') ?></a>
						          </th>
						        </tr> 
						      </thead> 
						   
						      <tbody>
						      </tbody> 

						      </table>

					    </section> 
					                        
					 </section>

					</div>       <!-- End col right -->
					<div class="clear"></div>
				
			</div>
			<!-- End #wrapper --> 
			
		</div>
		<!-- End #container --> 

	<!-- Import JS -->
	<script src="<?php echo $this->webroot; ?>js/ttw-simple-notifications-min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/excanvas.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.uniform.min.js"></script> 
	<script src="<?php echo $this->webroot; ?>js/jquery.validate.min.js"></script> 	
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
<script>
      
  //initiate Tables
  Table1 = $('.dtb1').dataTable( {
      "bProcessing": true,
      "sAjaxSource": '<?php echo $this->Html->url("/tsettings/getUsers2", true); ?>'
  });
      
var validator = new FormValidator('ServerAddForm', [{
    name: 'title',
    display: 'Title',    
    rules: 'required|min_length[6]'
}, {
    name: 'address',
    display: 'Address',    
    rules: 'required'
}, {
    name: 'port1',
    display: 'SpaceBukkit Port',    
    rules: 'required|numeric'
}, {
    name: 'port2',
    display: 'SpaceBukkit RTK',    
    rules: 'required|numeric'
}, {
    name: 'password',
    display: 'Salt',    
    rules: 'required'
}], function(errors, event) {    
        var SELECTOR_ERRORS = $('.error_box');     
        
        if (errors.length > 0) {        
          SELECTOR_ERRORS.empty();        
          SELECTOR_ERRORS.append(errors.join('<br />'));
          SELECTOR_ERRORS.fadeIn(200);   
          event.preventDefault();    
          } else {        
          SELECTOR_ERRORS.css({ display: 'none' });       
          }        
    });
</script>
	</body>
</html>
